<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailSale;
use App\Models\Product;
use App\Models\Sale;
use Exception;
use GuzzleHttp\Handler\Proxy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\TryCatch;

class SalesController extends Controller
{
    public function index()
    {
        $title = 'Ventas';
        $items = Product::all();
        // ▶️ Si tu vista muestra el formulario aquí, puedes mandar clientes:
        $customers = Customer::orderBy('full_name')->get();
        return view('modules.sales.index', compact('title', 'items', 'customers'));
    }
    public function add_cart($id_product)
    {
        $item = Product::findOrFail($id_product);
        $available = (int) $item->quantity;

        // ❌ Si no hay stock, no permitir agregar
        if ($available <= 0) {
            return to_route('sales.new-sale')->with('error', 'No hay stock disponible para: ' . $item->name);
        }

        // Obtener carrito actual
        $items_cart = Session::get('items_cart', []);

        // Cantidad ya en el carrito para este producto
        $qtyInCart = 0;
        foreach ($items_cart as $c) {
            if ((int)$c['id'] === (int)$id_product) {
                $qtyInCart += (int)$c['quantity'];
            }
        }

        // ❌ Si al agregar 1 supero el stock, bloquear
        if ($qtyInCart + 1 > $available) {
            return to_route('sales.new-sale')->with('error', 'La cantidad solicitada supera el stock disponible para: ' . $item->name);
        }

        // Agregar o incrementar
        $product_exists = false;
        foreach ($items_cart as $key => $cart) {
            if ((int)$cart['id'] === (int)$id_product) {
                $items_cart[$key]['quantity'] = (int)$items_cart[$key]['quantity'] + 1;
                $product_exists = true;
                break;
            }
        }

        if (!$product_exists) {
            $items_cart[] = [
                'id'         => $item->id,
                'code'       => $item->code,
                'name'       => $item->name,
                'quantity'   => 1,
                'sale_price' => $item->sale_price,
            ];
        }

        Session::put('items_cart', $items_cart);
        return to_route('sales.new-sale')->with('success', 'Producto agregado al carrito de ventas');
    }


    public function remove_cart($id_product)
    {
        $items_cart = Session::get('items_cart', []);
        foreach ($items_cart as $key => $cart) {
            if ($cart['id'] == $id_product) {
                if ($cart['quantity'] > 1) {
                    $items_cart[$key]['quantity'] -= 1;
                } else {
                    unset($items_cart[$key]);
                }
                break;
            }
        }
        Session::put('items_cart', $items_cart);
        return to_route('sales.new-sale')->with('success', 'Producto eliminado del carrito de ventas');
    }

    public function delete_cart()
    {
        //Eliminar la sesion

        Session::forget('items_cart');
        return to_route('sales.new-sale')->with('success', 'Carrito de ventas eliminado');
    }

    public function store(Request $request)
    {
        $items_cart = Session::get('items_cart', []);

        if (empty($items_cart)) {
            return to_route('sales.new-sale')->with('error', 'El carrito de ventas esta vacio');
        }

        // ▶️ Validar el cliente seleccionado (asumiendo campo "customer_id" llega del form)
        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
        ]);

        DB::beginTransaction();
        try {
            $totalSale = 0;
            foreach ($items_cart as $item) {
                $totalSale += $item['sale_price'] * $item['quantity'];
            }

            $sale = new Sale();
            $sale->user_id = Auth::id();
            $sale->customer_id = $request->input('customer_id'); // ▶️ Guardar cliente
            $sale->total_sale = $totalSale;
            $sale->save();

            foreach ($items_cart as $item) {
                $product = Product::find($item['id']);

                if ($product->quantity < $item['quantity']) {
                    DB::rollBack();
                    return to_route('sales.new-sale')->with('error', 'No hay suficiente stock para el producto: ' . $product->name);
                }

                $detailSale = new DetailSale();
                $detailSale->sale_id = $sale->id;
                $detailSale->product_id = $item['id'];
                $detailSale->quantity = $item['quantity'];
                $detailSale->unit_price = $item['sale_price'];
                $detailSale->subtotal = $item['sale_price'] * $item['quantity'];
                $detailSale->save();

                $product->quantity -= $item['quantity'];
                $product->save();
            }

            Session::forget('items_cart');
            DB::commit();
            return to_route('sales.new-sale')->with('success', 'Venta registrada correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return to_route('sales.new-sale')->with('error', 'Error al registrar la venta: ' . $e->getMessage());
        }
    }
}
