<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AddressState extends Model
{
    protected $table = 'states';

    // Relation with cities
    public function cities():HasMany
    {
        return $this->hasMany(AddressCity::class,'state_id','id');
    }
}
