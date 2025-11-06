<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ReportsProductsController extends Controller
{
    public function index()
    {
        $title = 'Reporte de productos';
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
        return view('modules.reports_products.index', compact('title', 'items'));
    }

    public function out_of_stock()
    {
        $title = 'Falta de stock';
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
            ->where('products.quantity', [0, 1])
            ->get();
        return view('modules.reports_products.out_of_stock', compact('title', 'items'));
    }
}
