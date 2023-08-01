<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plots extends Model
{
    use HasUuids;
    protected $table = "plots";

    protected $fillable = [
        'farm_id',
        'identification',
        'geojson_file'
    ];
}
