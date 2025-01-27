<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Infobox extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'image_path', 'fields'];

    protected $casts = [
        'fields' => 'array', // Define o campo 'fields' como um array para manipulação fácil
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

}
