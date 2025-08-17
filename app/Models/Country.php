<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    private const TABLE = 'countries';

    protected $fillable = [
        'cca3',
        'name_common',
        'name_official',
        'region',
        'subregion',
        'capital',
        'population',
        'area',
        'flag_emoji',
    ];
}
