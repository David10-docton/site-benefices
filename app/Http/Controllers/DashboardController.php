<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $totalBenefice = Sale::whereHas('product', function ($query) {
                $query->where('user_id', auth()->id());
            })->sum('benefice_calcule');

            $totalProduits = Product::where('user_id', auth()->id())->count();

            $totalVentes = Sale::whereHas('product', function ($query) {
                $query->where('user_id', auth()->id());
            })->count();

            $dernieresVentes = Sale::whereHas('product', function ($query) {
                $query->where('user_id', auth()->id());
            })->with('product')->latest()->take(5)->get();

        } catch (\Exception $e) {
            $totalBenefice = 0;
            $totalProduits = 0;
            $totalVentes = 0;
            $dernieresVentes = collect();
        }

        return view('dashboard', compact(
            'totalBenefice',
            'totalProduits',
            'totalVentes',
            'dernieresVentes'
        ));
    }
}