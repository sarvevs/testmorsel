<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = false;

    public function post()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
