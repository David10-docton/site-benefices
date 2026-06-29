@php
    try {
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
    } catch (\Exception $e) {
        $ventesParMois = collect();
        $produitsBenefice = collect();
    }
@endphp