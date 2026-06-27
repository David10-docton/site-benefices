<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantite_cartons',
        'benefice_calcule',
        'date_vente',
    ];

    // Une vente appartient à un produit
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}