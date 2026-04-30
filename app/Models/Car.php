<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Car extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'maker_id',
        'model_id',
        'car_type_id',
        'fuel_type_id',
        'city_id',
        'user_id',
        'year',
        'mileage',
        'price',
        'vin',
        'address',
        'phone',
        'description',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    protected $appends = ['state_id'];

    public function getStateIdAttribute()
    {
        return $this->city?->state_id;
    }

public function features(): HasOne
{
    return $this->hasOne(CarFeatures::class);
}
public function primaryImage(): HasOne
{ 
    return $this->hasOne(CarImage::class)->oldestOfMany('position');
}

public function images(): HasMany
{
    return $this->hasMany(CarImage::class)->orderBy('position');
}

public function carType(): BelongsTo
{
    return $this->belongsTo(CarType::class);
}

//public function favoriteUsers(): BelongsToMany
public function favoredUsers(): BelongsToMany
{
    return $this->belongsToMany(User::class,'favorite_cars');
}

public function fuelType(): BelongsTo
{
    return $this->belongsTo(FuelType::class);
}

public function maker(): BelongsTo
{
    return $this->belongsTo(Maker::class);
}

public function model(): BelongsTo
{
    return $this->belongsTo(\App\Models\Model::class);
}

public function owner(): BelongsTo
{
    return $this->belongsTo(User::class,'user_id');
}

public function city(): BelongsTo
{
    return $this->belongsTo(City::class);
}

public function getCreateDate(): string
{
    return (new Carbon($this->created_at))->format('Y-m-d');
}

public function getTitle(): string
{
    return $this->year . ' - ' . $this->maker->name . ' ' . $this->model->name;
}

}