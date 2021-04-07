<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
    	'id',
    	'uuid',
    	'session_id'
    ];

    public function allInfo()
    {
        return $this->hasOne(Product::class, 'uuid', 'uuid');
    }
}
