<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'menucode',
    'menuname',
    'menuparent',
    'is_active',
    'idx',
    'menutype',
    'menulink',
    'icon',
])]
class MstMenu extends Model
{
    /** @use HasFactory<\Database\Factories\MstMenuFactory> */
    use HasFactory;

    protected $table = 'mstmenu';

    protected $primaryKey = 'menucode';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $casts = [
        'is_active' => 'integer',
        'idx' => 'integer',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'menuparent', 'menucode')
            ->where('is_active', 1)
            ->orderBy('idx');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'menuparent', 'menucode');
    }
}
