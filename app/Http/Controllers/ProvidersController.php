<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Exception;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Proveedores';
        $items = Provider::all();

        return view('modules.providers.index', compact('items', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Agregar Proveedor';
        return view('modules.providers.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $provider = new Provider();
            $provider->name = $request->name;
            $provider->phone = $request->phone;
            $provider->email = $request->email;
            $provider->postal_code = $request->postal_code;
            $provider->address = $request->address;
            $provider->notes = $request->notes;
            $provider->save();

            return redirect()->route('providers.index')->with('success', 'Proveedor creado exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el proveedor: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Eliminar Proveedor';
        $item = Provider::find($id);
        return view('modules.providers.show', compact('item', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Editar Proveedor';
        $item = Provider::find($id);
        return view('modules.providers.edit', compact('item', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $provider = Provider::find($id);
            if (!$provider) {
                return redirect()->back()->with('error', 'Proveedor no encontrado.')->withInput();
            }

            $provider->name = $request->name;
            $provider->phone = $request->phone;
            $provider->email = $request->email;
            $provider->postal_code = $request->postal_code;
            $provider->address = $request->address;
            $provider->notes = $request->notes;
            $provider->save();

            return redirect()->route('Provider.index')->with('success', 'Proveedor actualizado exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el proveedor: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $provider = Provider::find($id);
            if (!$provider) {
                return redirect()->back()->with('error', 'Proveedor no encontrado.');
            }

            $provider->delete();
            return redirect()->route('providers.index')->with('success', 'Proveedor eliminado exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el proveedor: ' . $e->getMessage());
        }
    }
}
