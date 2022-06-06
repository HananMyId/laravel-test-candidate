<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    public static function search($query)
    {
        return empty($query)
            ? static::query()->whereRaw('1=1')
            : static::whereRaw('1=1')->where('name', 'LIKE', '%'. $query . '%');
    }
}
