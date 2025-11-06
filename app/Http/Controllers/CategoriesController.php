<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Administrar Categorias';
        $items = Category::all();

        return view('modules.categories.index', compact('title', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Crear Categoria';
        return view('modules.categories.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $category = new Category();
            $category->user_id = Auth::user()->id;
            $category->name = $request->input('name');
            $category->save();
            return redirect()->route('categories.index')->with('success', 'Categoria creada exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Error al crear la categoria: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Eliminar Categoria';
        $item = Category::findOrFail($id);

        return view('modules.categories.show', compact('title', 'item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Editar Categoria';
        $item = Category::findOrFail($id);

        return view('modules.categories.edit', compact('title', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->name = $request->input('name');
            $category->save();

            return redirect()->route('categories.index')->with('success', 'Categoria actualizada exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Error al actualizar la categoria: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()->route('categories.index')->with('success', 'Categoria eliminada exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Error al eliminar la categoria: ' . $e->getMessage());
        }
    }
}
