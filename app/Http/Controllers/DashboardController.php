<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // Total des bénéfices du vendeur connecté
        $totalBenefice = Sale::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->sum('benefice_calcule');

        // Nombre total de produits
        $totalProduits = Product::where('user_id', auth()->id())->count();

        // Nombre total de ventes
        $totalVentes = Sale::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->count();

        // Les 5 dernières ventes
        $dernieresVentes = Sale::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('product')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalBenefice',
            'totalProduits',
            'totalVentes',
            'dernieresVentes'
        ));
    }
}