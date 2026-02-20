<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'quantity', 'regular_price', 'sale_price','attribute_size','attribute_color',
        'category', 'thumbnail', 'viewer', 'author', 'description'
    ];
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }
}
