<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FuelType extends Model
{
    use HasFactory;

  //  protected $table = 'car_fuel_types';
  //  protected $primaryKey = 'fuel_type_id';
  //  protected $keyType = 'string';
  // public $incrementing = false;
  // const CREATED_AT = 'created_at';
  // const UPDATED_AT = 'updated_at;

  public $timestamps = false;
  protected $fillable = ['name'];

   public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

}
