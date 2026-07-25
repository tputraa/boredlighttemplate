<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'roleid',
    'rolename',
    'isactive',
])]
class UserGroup extends Model
{
    /** @use HasFactory<\Database\Factories\UserGroupFactory> */
    use HasFactory;

    protected $table = 'user_group';

    protected $primaryKey = 'roleid';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $casts = [
        'isactive' => 'integer',
    ];
}
