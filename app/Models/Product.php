<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function imageGalleries()
    {
        return $this->hasMany(ProductImageGallery::class);
    }
}
