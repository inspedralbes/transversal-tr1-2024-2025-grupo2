<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['category_id'];

    public function size()
    {
        return $this->belongsTo(Size::class); // <- establece una relacion de muchos a uno
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id'); // <- establece una relacion de muchos a uno
    }

}
