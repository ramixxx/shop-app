<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [

    ];

    public function sidebar_child_item() {
        return $this->hasMany(SidebarChildItem::class);
    }
}
