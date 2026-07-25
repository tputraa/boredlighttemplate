<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_group_id',
    'menucode',
    'fview',
    'fadd',
    'fedit',
    'fdelete',
])]
class MenuAccess extends Model
{
    /** @use HasFactory<\Database\Factories\MenuAccessFactory> */
    use HasFactory;

    protected $table = 'menuaccess';

    public $incrementing = false;

    protected $primaryKey = null;

    protected $casts = [
        'user_group_id' => 'integer',
        'menucode' => 'integer',
        'fview' => 'integer',
        'fadd' => 'integer',
        'fedit' => 'integer',
        'fdelete' => 'integer',
    ];
}
