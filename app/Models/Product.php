<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'prix_achat',
        'prix_vente',
    ];

    // Un produit appartient à un vendeur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un produit peut avoir plusieurs ventes
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Calcule le bénéfice par carton
    public function beneficeParCarton()
    {
        return $this->prix_vente - $this->prix_achat;
    }
}