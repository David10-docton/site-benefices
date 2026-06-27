<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Liste tous les produits du vendeur connecté
    public function index()
    {
        $products = Product::where('user_id', auth()->id())->get();
        return view('products.index', compact('products'));
    }

    // Affiche le formulaire d'ajout
    public function create()
    {
        return view('products.create');
    }

    // Enregistre un nouveau produit
    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'prix_achat'  => 'required|numeric|min:0',
            'prix_vente'  => 'required|numeric|min:0',
        ]);

        Product::create([
            'user_id'    => auth()->id(),
            'nom'        => $request->nom,
            'prix_achat' => $request->prix_achat,
            'prix_vente' => $request->prix_vente,
        ]);

        return redirect()->route('products.index')
                         ->with('success', 'Produit ajouté avec succès !');
    }

    // Affiche le formulaire de modification
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Met à jour un produit
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nom'        => 'required|string|max:255',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
                         ->with('success', 'Produit modifié avec succès !');
    }

    // Supprime un produit
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
                         ->with('success', 'Produit supprimé avec succès !');
    }
}