<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status', // Ex.: 'draft' ou 'published'
        'category_id',
        'author_id',
    ];

    /**
     * Define the relationship with Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define the relationship with User (Author).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
