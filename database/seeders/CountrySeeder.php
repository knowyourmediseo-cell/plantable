<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        // India
        $india = Country::create([
            'name' => 'India',
            'code' => 'IN',
            'iso3' => 'IND',
            'phone_code' => '+91',
            'currency' => 'INR',
            'currency_symbol' => '₹',
            'status' => true,
        ]);

        // Indian States
        $states = [
            'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur', 'Nashik', 'Aurangabad'],
            'Delhi' => ['New Delhi', 'Delhi'],
            'Karnataka' => ['Bangalore', 'Mysore', 'Mangalore', 'Hubli'],
            'Tamil Nadu' => ['Chennai', 'Coimbatore', 'Madurai', 'Salem'],
            'Gujarat' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot'],
        ];

        foreach ($states as $stateName => $cities) {
            $state = State::create([
                'country_id' => $india->id,
                'name' => $stateName,
                'status' => true,
            ]);

            foreach ($cities as $cityName) {
                City::create([
                    'state_id' => $state->id,
                    'name' => $cityName,
                    'status' => true,
                ]);
            }
        }

        // United States
        $usa = Country::create([
            'name' => 'United States',
            'code' => 'US',
            'iso3' => 'USA',
            'phone_code' => '+1',
            'currency' => 'USD',
            'currency_symbol' => '$',
            'status' => true,
        ]);

        // US States
        $usStates = [
            'California' => ['Los Angeles', 'San Francisco', 'San Diego'],
            'New York' => ['New York City', 'Buffalo', 'Rochester'],
            'Texas' => ['Houston', 'Dallas', 'Austin'],
        ];

        foreach ($usStates as $stateName => $cities) {
            $state = State::create([
                'country_id' => $usa->id,
                'name' => $stateName,
                'status' => true,
            ]);

            foreach ($cities as $cityName) {
                City::create([
                    'state_id' => $state->id,
                    'name' => $cityName,
                    'status' => true,
                ]);
            }
        }

        // United Kingdom
        $uk = Country::create([
            'name' => 'United Kingdom',
            'code' => 'GB',
            'iso3' => 'GBR',
            'phone_code' => '+44',
            'currency' => 'GBP',
            'currency_symbol' => '£',
            'status' => true,
        ]);

        $ukRegions = [
            'England' => ['London', 'Manchester', 'Birmingham'],
            'Scotland' => ['Edinburgh', 'Glasgow'],
        ];

        foreach ($ukRegions as $stateName => $cities) {
            $state = State::create([
                'country_id' => $uk->id,
                'name' => $stateName,
                'status' => true,
            ]);

            foreach ($cities as $cityName) {
                City::create([
                    'state_id' => $state->id,
                    'name' => $cityName,
                    'status' => true,
                ]);
            }
        }
    }
}
