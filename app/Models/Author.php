<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    
    public function news()
    {
        return $this->hasMany(News::class, 'source_id');
    }
}
