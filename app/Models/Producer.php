<?php

namespace App\Models;

use App\Helpers\StringHelper;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use JetBrains\PhpStorm\Pure;

class Producer extends Model
{
    use HasUuids;
    // use SoftDeletes; We can use soft delete, but it's good to have archive functions.

    protected $table = 'producers';

    protected $fillable = [
        'company_name',
        'trading_name',
        'social_number',
        'state_registration',
        'phone',
        'city_id'
    ];

    // Mutators
    #[Pure] public function getSocialNumberAttribute($socialNumber) : string
    {
        if(strlen($socialNumber) == 11)
            return StringHelper::mask('###.###.###-##',$socialNumber);
        elseif(strlen($socialNumber) == 14)
            return StringHelper::mask('##.###.###/####-##',$socialNumber);

        return $socialNumber ?? '';
    }

    #[Pure] public function setSocialNumberAttribute($socialNumber) : string
    {
        $this->attributes['social_number'] = StringHelper::onlyNumbers($socialNumber);
        return StringHelper::onlyNumbers($socialNumber);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(AddressCity::class,'city_id','id');
    }
}
