<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'first_name',
        'last_name',
        'company',
        'phone',
        'email',
        'address_line_1',
        'address_line_2',
        'country_id',
        'state_id',
        'city_id',
        'postal_code',
        'landmark',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address_line_1;
        if ($this->address_line_2) {
            $address .= ', ' . $this->address_line_2;
        }
        $address .= ', ' . $this->city->name;
        $address .= ', ' . $this->state->name;
        $address .= ', ' . $this->country->name;
        $address .= ' - ' . $this->postal_code;
        return $address;
    }
}
