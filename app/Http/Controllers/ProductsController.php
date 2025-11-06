<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Provider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Productos';
        $items = Product::select(
            'products.*',
            'categories.name as name_category',
            'providers.name as name_provider',
            'images.route as image_product',
            'images.id as image_id'
        )
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('providers', 'products.provider_id', '=', 'providers.id')
            ->leftJoin('images', 'products.id', '=', 'images.product_id')
            ->get();
        return view('modules.products.index', compact('title', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Crear producto";
        $categories = Category::all();
        $providers = Provider::all();
        return view('modules.products.create', compact('title', 'categories', 'providers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Product();
            $item->user_id = Auth::user()->id;
            $item->category_id = $request->category_id;
            $item->provider_id = $request->provider_id;
            $item->code = $request->code;
            $item->name = $request->name;
            $item->description = $request->description;
            $item->save();
            $id_product = $item->id;

            if ($id_product > 0) {
                if ($this->upload_image($request, $id_product)) {
                    return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
                } else {
                    return redirect()->route('products.index')->with('error', 'No se subio la imagen.');
                }
            }

            return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('products.index')->with('error', 'Error al crear el producto: ' . $e->getMessage());
        }
    }

    public function upload_image($request, $id_product)
    {
        $routeImage = $request->file('image')->store('images', 'public');
        $nameImage = basename($routeImage);

        $item = new Image();
        $item->product_id = $id_product;
        $item->name = $nameImage;
        $item->route = $routeImage;
        return $item->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Eliminar producto';
        $items = Product::select(
            'products.*',
            'categories.name as name_category',
            'providers.name as name_provider'
        )
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('providers', 'products.provider_id', '=', 'providers.id')
            ->where('products.id', $id)
            ->first();
        return view('modules.products.show', compact('title', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Editar Producto";
        $categories = Category::all();
        $providers = Provider::all();
        $item = Product::find($id);
        return view('modules.products.edit', compact('title', 'item', 'categories', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Product::find($id);
            $item->category_id = $request->category_id;
            $item->provider_id = $request->provider_id;
            $item->code = $request->code;
            $item->name = $request->name;
            $item->description = $request->description;
            $item->sale_price = $request->sale_price;
            $item->save();
            return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('products.index')->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Product::find($id);
            $item->delete();
            return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('products.index')->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
    public function active($id, $active)
    {
        $item = Product::find($id);
        $item->active = $active;
        return $item->save();
    }

    public function show_image($id)
    {
        $title = 'Editar imagen';
        $item = Image::find($id);
        return view('modules.products.show-image', compact('title', 'item'));
    }

    public function update_image(Request $request, $id)
    {
        try {
            $item = Image::find($id);
            if ($item->route && Storage::disk('public')->exists($item->route)) {
                Storage::disk('public')->delete($item->route);
            }
            $routeImage = $request->file('image')->store('images', 'public');
            $nameImage = basename($routeImage);

            $item->route = $routeImage;
            $item->name = $nameImage;
            $item->save();
            return redirect()->route('products.index')->with('success', 'Imagen actualizada exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('products.index')->with('error', 'Error al actualizar la imagen: ' . $e->getMessage());
        }
    }
}
