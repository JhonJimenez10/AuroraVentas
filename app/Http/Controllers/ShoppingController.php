<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shopping;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Compras';
        $items = Shopping::select(
            'shopping.*',
            'users.name as name_user',
            'products.name as name_product'
        )
            ->join('users', 'shopping.user_id', '=', 'users.id')
            ->join('products', 'shopping.product_id', '=', 'products.id')
            ->get();
        return view('modules.shopping.index', compact('title', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $title = 'Comprar productos';
        $item = Product::find($id);
        return view('modules.shopping.create', compact('title', 'id', 'item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Shopping();
            $item->user_id = Auth::user()->id;
            $item->product_id = $request->id;
            $item->quantity = $request->quantity;
            $item->shopping_price = $request->shopping_price;
            if ($item->save()) {
                $item = Product::find($request->id);
                $item->quantity = ($item->quantity + $request->quantity);
                $item->shopping_price = $request->shopping_price;
                $item->save();
            }
            return to_route('products.index')->with('succes', 'Se realizo la compra correctamente.');
        } catch (Exception $e) {
            return to_route('products.index')->with('error', 'No se pudo realizar la compra correctamente.' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Eliminar compra';
        $items = Shopping::select(
            'shopping.*',
            'users.name as name_user',
            'products.name as name_product'
        )
            ->join('users', 'shopping.user_id', '=', 'users.id')
            ->join('products', 'shopping.product_id', '=', 'products.id')
            ->where('shopping.id', $id)
            ->first();
        return view('modules.shopping.show', compact('title', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Editar compra';
        $item = Shopping::select(
            'shopping.*',
            'users.name as name_user',
            'products.name as name_product'
        )
            ->join('users', 'shopping.user_id', '=', 'users.id')
            ->join('products', 'shopping.product_id', '=', 'products.id')
            ->where('shopping.id', $id)
            ->first();
        return view('modules.shopping.edit', compact('title', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $quantity_past = 0;
            $item = Shopping::find($id);
            $item->quantity = $request->quantity;
            $item->shopping_price = $request->shopping_price;

            if ($item->save()) {
                $item = Product::find($request->product_id);
                $quantity_past = $item->quantity - $quantity_past;
                $item->quantity = $quantity_past + $request->quantity;
                $item->save();
            }
            return to_route('shopping.index')->with('succes', 'Compra editada correctamente.');
        } catch (Exception $e) {
            return to_route('shopping.index')->with('error', 'No se pudo actualizar correctamente.' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $item = Shopping::find($id);
            $quantity_shopping = $item->quantity;
            if ($item->delete()) {
                $item = Product::find($request->product_id);
                $item->quantity = $item->quantity - $quantity_shopping;
                $item->save();
                return to_route('shopping.index')->with('success', 'Compra eliminada con exito!');
            } else {
                return to_route('shopping.index')->with('error', 'Compra no se elimino correctamente.');
            }
        } catch (Exception $e) {
            return to_route('shopping.index')->with('error', 'No se pudo eliminar la compra.' . $e->getMessage());
        }
    }
}
