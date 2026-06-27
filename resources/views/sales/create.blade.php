@extends('layouts.app')

@section('content')
<div style="max-width:500px">
    <div style="font-size:18px;font-weight:500;margin-bottom:20px">Enregistrer une vente</div>

    <div style="background:#fff;border-radius:12px;border:0.5px solid #e0e0d8;padding:24px">
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:16px">
                <label style="font-size:13px;color:#5f5e5a;display:block;margin-bottom:6px">Produit vendu</label>
                <select name="product_id" style="width:100%;padding:10px 12px;border:0.5px solid #d3d1c7;border-radius:8px;font-size:14px;outline:none;background:#fff" required>
                    <option value="">-- Choisir un produit --</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->nom }} (bénéfice/carton : {{ number_format($product->beneficeParCarton(), 0, ',', ' ') }} F)
                    </option>
                    @endforeach
                </select>
                @error('product_id')<div style="color:#A32D2D;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:16px">
                <label style="font-size:13px;color:#5f5e5a;display:block;margin-bottom:6px">Nombre de cartons vendus</label>
                <input type="number" name="quantite_cartons" value="{{ old('quantite_cartons') }}" placeholder="Ex: 10" min="1" style="width:100%;padding:10px 12px;border:0.5px solid #d3d1c7;border-radius:8px;font-size:14px;outline:none" required>
                @error('quantite_cartons')<div style="color:#A32D2D;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:24px">
                <label style="font-size:13px;color:#5f5e5a;display:block;margin-bottom:6px">Date de la vente</label>
                <input type="date" name="date_vente" value="{{ old('date_vente', date('Y-m-d')) }}" style="width:100%;padding:10px 12px;border:0.5px solid #d3d1c7;border-radius:8px;font-size:14px;outline:none" required>
                @error('date_vente')<div style="color:#A32D2D;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:10px">
                <button type="submit" style="background:#185FA5;color:#fff;padding:10px 20px;border:none;border-radius:8px;font-size:14px;cursor:pointer">Enregistrer</button>
                <a href="{{ route('sales.index') }}" style="padding:10px 20px;border:0.5px solid #d3d1c7;border-radius:8px;font-size:14px;text-decoration:none;color:#5f5e5a">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection