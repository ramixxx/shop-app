<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidebarChildItem extends Model
{
    use HasFactory;

    protected $fillable = [

    ];

    public function link() {
        return $this->belongsTo(Link::class);
    }
}
