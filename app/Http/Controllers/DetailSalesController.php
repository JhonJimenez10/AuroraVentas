<?php

namespace App\Http\Controllers;

use App\Models\DetailSale;
use App\Models\Product;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Detalle de Ventas';

        // Incluimos también el nombre del cliente para el listado (útil si quieres mostrarlo ahí)
        $items = Sale::select(
            'sales.*',
            'users.name as user_name',
            'customers.full_name as customer_full_name'
        )
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
            ->orderBy('sales.created_at', 'desc')
            ->get();

        return view('modules.details_sales.index', compact('title', 'items'));
    }

    public function detail_sale($id)
    {
        $title = 'Detalle de Venta';

        // 🔹 Traemos todos los campos necesarios del cliente con alias "customer_*"
        $sale = Sale::select(
            'sales.*',
            'users.name as user_name',
            'customers.full_name as customer_full_name',
            'customers.id_type as customer_id_type',
            'customers.identification as customer_identification',
            'customers.phone as customer_phone',
            'customers.email as customer_email',
            'customers.city as customer_city',
            'customers.canton as customer_canton',
            'customers.province as customer_province',
            'customers.address as customer_address'
        )
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
            ->where('sales.id', $id)
            ->firstOrFail();

        $details = DetailSale::select(
            'detail_sales.*',
            'products.name as product_name'
        )
            ->join('products', 'detail_sales.product_id', '=', 'products.id')
            ->where('detail_sales.sale_id', $id)
            ->get();

        return view('modules.details_sales.details_sale', compact('title', 'sale', 'details'));
    }

    public function annul_sale($id)
    {
        DB::beginTransaction();
        try {
            //Actualizar el stock de los productos
            $details = DetailSale::select(
                'product_id',
                'quantity'
            )
                ->where('sale_id', $id)
                ->get();

            //Devolver el stock
            foreach ($details as $detail) {
                Product::where('id', $detail->product_id)
                    ->increment('quantity', $detail->quantity);
            }

            //Eliminar productos vendidos
            DetailSale::where('sale_id', $id)->delete();
            Sale::where('id', $id)->delete();

            DB::commit();
            return to_route('sales.detail-sale')->with('success', 'Venta anulada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('sales.detail-sale')->with('error', 'Error al anular la venta: ' . $e->getMessage());
        }
    }

    public function generateTicket($id)
    {
        // 🔹 Incluir también datos del cliente en el ticket
        $sale = Sale::select(
            'sales.*',
            'users.name as user_name',
            'customers.full_name as customer_full_name',
            'customers.id_type as customer_id_type',
            'customers.identification as customer_identification',
            'customers.phone as customer_phone',
            'customers.email as customer_email',
            'customers.city as customer_city',
            'customers.canton as customer_canton',
            'customers.province as customer_province',
            'customers.address as customer_address'
        )
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
            ->where('sales.id', $id)
            ->firstOrFail();

        $details = DetailSale::select(
            'detail_sales.*',
            'products.name as product_name',
        )
            ->join('products', 'detail_sales.product_id', '=', 'products.id')
            ->where('detail_sales.sale_id', $id)
            ->get();

        //generar el pdf
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('modules.details_sales.ticket', compact('sale', 'details'));

        // Descargar/mostrar el pdf
        return $pdf->stream('ticket_sale_' . $sale->id . '.pdf');
    }
}
