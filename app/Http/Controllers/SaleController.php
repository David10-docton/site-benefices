<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Liste toutes les ventes du vendeur connecté
    public function index()
    {
        $sales = Sale::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('product')->latest()->get();

        return view('sales.index', compact('sales'));
    }

    // Affiche le formulaire d'ajout de vente
    public function create()
    {
        $products = Product::where('user_id', auth()->id())->get();
        return view('sales.create', compact('products'));
    }

    // Enregistre une nouvelle vente
    public function store(Request $request)
    {
        $request->validate([
            'product_id'       => 'required|exists:products,id',
            'quantite_cartons' => 'required|integer|min:1',
            'date_vente'       => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Calcul automatique du bénéfice
        $benefice = $product->beneficeParCarton() * $request->quantite_cartons;

        Sale::create([
            'product_id'       => $request->product_id,
            'quantite_cartons' => $request->quantite_cartons,
            'benefice_calcule' => $benefice,
            'date_vente'       => $request->date_vente,
        ]);

        return redirect()->route('sales.index')
                         ->with('success', 'Vente enregistrée avec succès !');
    }

    // Supprime une vente
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')
                         ->with('success', 'Vente supprimée avec succès !');
    }
}