<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'title',
        'publisher'
    ];

    public function publisher(){
        return $this->belongsTo(User::class,'publisher_id');
    }
}
