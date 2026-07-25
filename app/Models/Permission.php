<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /** @use HasFactory<\Database\Factories\PermissionFactory> */
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

    /**
     * Get CRUD access flags for a given role and menu.
     *
     * @return array{fview: int, fadd: int, fedit: int, fdelete: int}
     */
    public static function getAccess(?int $groupId, int $menucode): array
    {
        $row = self::query()
            ->where('user_group_id', $groupId)
            ->where('menucode', $menucode)
            ->first();

        if ($row === null) {
            return [
                'fview' => 0,
                'fadd' => 0,
                'fedit' => 0,
                'fdelete' => 0,
            ];
        }

        return [
            'fview' => (int) $row->fview,
            'fadd' => (int) $row->fadd,
            'fedit' => (int) $row->fedit,
            'fdelete' => (int) $row->fdelete,
        ];
    }
}
