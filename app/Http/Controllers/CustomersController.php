<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Clientes';

        // Búsqueda simple opcional por nombre, identificación o correo
        $q = $request->get('q');
        $items = Customer::query()
            ->when($q, function ($query) use ($q) {
                $query->where('full_name', 'like', "%{$q}%")
                    ->orWhere('identification', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->orderBy('full_name')
            ->paginate(15)
            ->withQueryString();

        return view('modules.customers.index', compact('title', 'items', 'q'));
    }

    public function create()
    {
        $title = 'Nuevo Cliente';
        return view('modules.customers.create', compact('title'));
    }

    public function store(Request $request)
    {
        // Normaliza entradas
        $request->merge([
            'id_type'        => strtoupper(trim($request->input('id_type'))),
            'identification' => trim($request->input('identification')),
        ]);

        // 1) Pre-chequeo manual (evita llegar a la BD y muestra alerta clara)
        $exists = Customer::where('id_type', $request->id_type)
            ->where('identification', $request->identification)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['identification' => 'El cliente ya existe con ese tipo y número de identificación.']);
        }

        // 2) Validación con mensajes personalizados
        $messages = [
            'identification.unique'   => 'El cliente ya existe con ese tipo y número de identificación.',
            'identification.required' => 'La identificación es obligatoria.',
            'id_type.in'              => 'El tipo de identificación debe ser RUC o CEDULA.',
        ];

        $data = $request->validate([
            'id_type'        => ['required', Rule::in(['RUC', 'CEDULA'])],
            'identification' => [
                'required',
                'max:25',
                Rule::unique('customers')->where(fn($q) => $q->where('id_type', $request->id_type)),
            ],
            'full_name'   => ['required', 'max:150'],
            'phone'       => ['nullable', 'max:30'],
            'email'       => ['nullable', 'email', 'max:150'],
            'postal_code' => ['nullable', 'max:20'],
            'city'        => ['nullable', 'max:100'],
            'canton'      => ['nullable', 'max:100'],
            'province'    => ['nullable', 'max:100'],
            'address'     => ['nullable', 'max:255'],
        ], $messages);

        try {
            Customer::create($data);
            return redirect()->route('customers.index')->with('success', 'Cliente creado correctamente.');
        } catch (QueryException $e) {
            // 3) Si la BD lanza violación de índice único (PostgreSQL: 23505 / MySQL: 1062)
            $code = (string)($e->errorInfo[0] ?? $e->getCode());
            if ($code === '23505' || $code === '23000' || $e->getCode() == 1062) {
                return back()
                    ->withInput()
                    ->withErrors(['identification' => 'El cliente ya existe con ese tipo y número de identificación.']);
            }
            return back()->withInput()->with('error', 'Error al crear el cliente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al crear el cliente.');
        }
    }

    public function edit(Customer $customer)
    {
        $title = 'Editar Cliente';
        return view('modules.customers.edit', compact('title', 'customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        // Normaliza
        $request->merge([
            'id_type'        => strtoupper(trim($request->input('id_type'))),
            'identification' => trim($request->input('identification')),
        ]);

        // Pre-chequeo manual ignorando el propio registro
        $exists = Customer::where('id_type', $request->id_type)
            ->where('identification', $request->identification)
            ->where('id', '<>', $customer->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['identification' => 'Ya existe otro cliente con ese tipo y número de identificación.']);
        }

        $messages = [
            'identification.unique'   => 'Ya existe otro cliente con ese tipo y número de identificación.',
            'identification.required' => 'La identificación es obligatoria.',
            'id_type.in'              => 'El tipo de identificación debe ser RUC o CEDULA.',
        ];

        $data = $request->validate([
            'id_type'        => ['required', Rule::in(['RUC', 'CEDULA'])],
            'identification' => [
                'required',
                'max:25',
                Rule::unique('customers')
                    ->ignore($customer->id)
                    ->where(fn($q) => $q->where('id_type', $request->id_type)),
            ],
            'full_name'   => ['required', 'max:150'],
            'phone'       => ['nullable', 'max:30'],
            'email'       => ['nullable', 'email', 'max:150'],
            'postal_code' => ['nullable', 'max:20'],
            'city'        => ['nullable', 'max:100'],
            'canton'      => ['nullable', 'max:100'],
            'province'    => ['nullable', 'max:100'],
            'address'     => ['nullable', 'max:255'],
        ], $messages);

        try {
            $customer->update($data);
            return redirect()->route('customers.index')->with('success', 'Cliente actualizado correctamente.');
        } catch (QueryException $e) {
            $code = (string)($e->errorInfo[0] ?? $e->getCode());
            if ($code === '23505' || $code === '23000' || $e->getCode() == 1062) {
                return back()
                    ->withInput()
                    ->withErrors(['identification' => 'Ya existe otro cliente con ese tipo y número de identificación.']);
            }
            return back()->withInput()->with('error', 'Error al actualizar el cliente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al actualizar el cliente.');
        }
    }

    public function destroy(Customer $customer)
    {
        // Si una venta referencia al cliente y la FK tiene restrictOnDelete(),
        // esto lanzará una excepción y mostramos un mensaje claro.
        try {
            $customer->delete();
            return redirect()->route('customers.index')->with('success', 'Cliente eliminado correctamente.');
        } catch (Exception $e) {
            return back()->with('error', 'No se puede eliminar el cliente porque tiene ventas asociadas.');
        }
    }

    // (Opcional) Endpoint para autocompletar clientes en formularios
    public function search(Request $request)
    {
        $q = $request->get('q', '');
        $items = Customer::query()
            ->where('full_name', 'like', "%{$q}%")
            ->orWhere('identification', 'like', "%{$q}%")
            ->limit(10)
            ->get(['id', 'full_name', 'identification', 'id_type', 'email', 'phone']);

        return response()->json($items);
    }
}
