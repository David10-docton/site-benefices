@extends('layouts.app')

@section('content')
<div style="max-width:500px">
    <div style="font-size:18px;font-weight:500;margin-bottom:20px">Ajouter un produit</div>

    <div style="background:#fff;border-radius:12px;border:0.5px solid #e0e0d8;padding:24px">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:16px">
                <label style="font-size:13px;color:#5f5e5a;display:block;margin-bottom:6px">Nom du produit</label>
                <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex: Savon Lux" style="width:100%;padding:10px 12px;border:0.5px solid #d3d1c7;border-radius:8px;font-size:14px;outline:none" required>
                @error('nom')<div style="color:#A32D2D;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:16px">
                <label style="font-size:13px;color:#5f5e5a;display:block;margin-bottom:6px">Prix d'achat chez le fournisseur (F)</label>
                <input type="number" name="prix_achat" value="{{ old('prix_achat') }}" placeholder="Ex: 5000" step="0.01" min="0" style="width:100%;padding:10px 12px;border:0.5px solid #d3d1c7;border-radius:8px;font-size:14px;outline:none" required>
                @error('prix_achat')<div style="color:#A32D2D;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:24px">
                <label style="font-size:13px;color:#5f5e5a;display:block;margin-bottom:6px">Prix de vente par carton (F)</label>
                <input type="number" name="prix_vente" value="{{ old('prix_vente') }}" placeholder="Ex: 7000" step="0.01" min="0" style="width:100%;padding:10px 12px;border:0.5px solid #d3d1c7;border-radius:8px;font-size:14px;outline:none" required>
                @error('prix_vente')<div style="color:#A32D2D;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:10px">
                <button type="submit" style="background:#185FA5;color:#fff;padding:10px 20px;border:none;border-radius:8px;font-size:14px;cursor:pointer">Enregistrer</button>
                <a href="{{ route('products.index') }}" style="padding:10px 20px;border:0.5px solid #d3d1c7;border-radius:8px;font-size:14px;text-decoration:none;color:#5f5e5a">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection