@extends('layouts.app')

@section('content')
<div style="font-size:18px;font-weight:500;margin-bottom:20px">Tableau de bord</div>

{{-- Cartes statistiques --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px">
    <div style="background:#fff;border-radius:10px;padding:16px;border:0.5px solid #e0e0d8">
        <div style="font-size:12px;color:#888780;margin-bottom:6px">Bénéfice total</div>
        <div style="font-size:24px;font-weight:500;color:#1D9E75">{{ number_format($totalBenefice, 0, ',', ' ') }} F</div>
    </div>
    <div style="background:#fff;border-radius:10px;padding:16px;border:0.5px solid #e0e0d8">
        <div style="font-size:12px;color:#888780;margin-bottom:6px">Produits enregistrés</div>
        <div style="font-size:24px;font-weight:500;color:#185FA5">{{ $totalProduits }}</div>
    </div>
    <div style="background:#fff;border-radius:10px;padding:16px;border:0.5px solid #e0e0d8">
        <div style="font-size:12px;color:#888780;margin-bottom:6px">Ventes effectuées</div>
        <div style="font-size:24px;font-weight:500;color:#BA7517">{{ $totalVentes }}</div>
    </div>
</div>

{{-- Graphiques --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:24px">
    <div style="background:#fff;border-radius:12px;padding:16px;border:0.5px solid #e0e0d8">
        <div style="font-size:13px;font-weight:500;color:#5f5e5a;margin-bottom:12px">Évolution des bénéfices (6 derniers mois)</div>
        <canvas id="lineChart" height="120"></canvas>
    </div>
    <div style="background:#fff;border-radius:12px;padding:16px;border:0.5px solid #e0e0d8">
        <div style="font-size:13px;font-weight:500;color:#5f5e5a;margin-bottom:12px">Bénéfice par produit</div>
        <canvas id="barChart" height="120"></canvas>
    </div>
</div>

{{-- Dernières ventes --}}
<div style="background:#fff;border-radius:12px;padding:16px;border:0.5px solid #e0e0d8">
    <div style="font-size:13px;font-weight:500;color:#5f5e5a;margin-bottom:12px">Dernières ventes</div>
    <table style="width:100%;border-collapse:collapse;font-size:13px">
        <thead>
            <tr style="border-bottom:0.5px solid #e0e0d8">
                <th style="text-align:left;padding:8px 0;color:#888780;font-weight:400">Produit</th>
                <th style="text-align:left;padding:8px 0;color:#888780;font-weight:400">Cartons</th>
                <th style="text-align:left;padding:8px 0;color:#888780;font-weight:400">Date</th>
                <th style="text-align:left;padding:8px 0;color:#888780;font-weight:400">Bénéfice</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dernieresVentes as $vente)
            <tr style="border-bottom:0.5px solid #e0e0d8">
                <td style="padding:10px 0">{{ $vente->product->nom }}</td>
                <td style="padding:10px 0">{{ $vente->quantite_cartons }}</td>
                <td style="padding:10px 0">{{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y') }}</td>
                <td style="padding:10px 0">
                    <span style="background:#e1f5ee;color:#085041;padding:3px 10px;border-radius:10px;font-size:12px">
                        + {{ number_format($vente->benefice_calcule, 0, ',', ' ') }} F
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding:16px 0;color:#888780;text-align:center">Aucune vente enregistrée pour l'instant</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Données pour les graphiques --}}
@php
    $ventesParMois = \App\Models\Sale::whereHas('product', function($q) {
        $q->where('user_id', auth()->id());
    })
    ->selectRaw("strftime('%m', date_vente) as mois, SUM(benefice_calcule) as total")
    ->groupBy('mois')
    ->orderBy('mois')
    ->get();

    $produitsBenefice = \App\Models\Product::where('user_id', auth()->id())
    ->withSum('sales', 'benefice_calcule')
    ->get();
@endphp

<script>
const moisLabels = @json($ventesParMois->pluck('mois')->map(fn($m) => ['01'=>'Jan','02'=>'Fév','03'=>'Mar','04'=>'Avr','05'=>'Mai','06'=>'Juin','07'=>'Juil','08'=>'Août','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Déc'][$m] ?? $m));
const moisData   = @json($ventesParMois->pluck('total'));
const prodNoms   = @json($produitsBenefice->pluck('nom'));
const prodData   = @json($produitsBenefice->pluck('sales_sum_benefice_calcule'));

new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: moisLabels,
        datasets: [{
            data: moisData,
            borderColor: '#1D9E75',
            backgroundColor: 'rgba(29,158,117,0.08)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#1D9E75',
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { font: { size: 11 } } },
            y: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { font: { size: 11 }, callback: v => v.toLocaleString() + ' F' } }
        }
    }
});

new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: prodNoms,
        datasets: [{
            data: prodData,
            backgroundColor: ['#1D9E75','#378ADD','#BA7517','#534AB7','#D85A30'],
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 } } },
            y: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { font: { size: 11 } } }
        }
    }
});
</script>
@endsection