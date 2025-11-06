<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Administrar usuarios';
        $items = User::all();
        return view('modules.users.index', compact('items', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Crear usuario';
        return view('modules.users.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'active' => true,
                'role' => $request->role,
            ]);
            return to_route('users.index')->with('success', 'Usuario creado exitosamente.');
        } catch (Exception $e) {
            return to_route('users.index')->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = User::find($id);
        $title = 'Editar usuario';
        return view('modules.users.edit', compact('item', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = User::find($id);
            $item->name = $request->name;
            $item->email = $request->email;
            $item->role = $request->role;
            $item->save();
            return to_route('users.index')->with('success', 'Usuario actualizado exitosamente.');
        } catch (Exception $e) {
            return to_route('users.index')->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function tbody()
    {
        $items = User::all();
        return view('modules.users.tbody', compact('items'));
    }
    public function active($id, $active)
    {
        $item = User::find($id);
        $item->active = $active;
        return $item->save();
    }
    public function update_password($id, $password)
    {
        $item = User::find($id);
        $item->password = Hash::make($password);
        return $item->save();
    }
}
