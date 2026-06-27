@extends('layouts.app')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
    <div style="font-size:18px;font-weight:500">Mes ventes</div>
    <a href="{{ route('sales.create') }}" style="background:#185FA5;color:#fff;padding:8px 16px;border-radius:8px;text-decoration:none;font-size:13px">+ Enregistrer une vente</a>
</div>

<div style="background:#fff;border-radius:12px;border:0.5px solid #e0e0d8;overflow:hidden">
    <table style="width:100%;border-collapse:collapse;font-size:13px">
        <thead>
            <tr style="border-bottom:0.5px solid #e0e0d8;background:#f9f9f7">
                <th style="text-align:left;padding:12px 16px;color:#888780;font-weight:400">Produit</th>
                <th style="text-align:left;padding:12px 16px;color:#888780;font-weight:400">Cartons vendus</th>
                <th style="text-align:left;padding:12px 16px;color:#888780;font-weight:400">Date</th>
                <th style="text-align:left;padding:12px 16px;color:#888780;font-weight:400">Bénéfice</th>
                <th style="text-align:left;padding:12px 16px;color:#888780;font-weight:400">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            <tr style="border-bottom:0.5px solid #e0e0d8">
                <td style="padding:12px 16px;font-weight:500">{{ $sale->product->nom }}</td>
                <td style="padding:12px 16px">{{ $sale->quantite_cartons }}</td>
                <td style="padding:12px 16px">{{ \Carbon\Carbon::parse($sale->date_vente)->format('d/m/Y') }}</td>
                <td style="padding:12px 16px">
                    <span style="background:#e1f5ee;color:#085041;padding:3px 10px;border-radius:10px">
                        + {{ number_format($sale->benefice_calcule, 0, ',', ' ') }} F
                    </span>
                </td>
                <td style="padding:12px 16px">
                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" onsubmit="return confirm('Supprimer cette vente ?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="color:#A32D2D;font-size:12px;background:none;border:0.5px solid #A32D2D;border-radius:6px;padding:4px 10px;cursor:pointer">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:24px;text-align:center;color:#888780">
                    Aucune vente enregistrée. <a href="{{ route('sales.create') }}" style="color:#185FA5">Enregistrer votre première vente</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection