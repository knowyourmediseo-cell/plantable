<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function countries()
    {
        $countries = Country::active()->orderBy('name')->get();
        return response()->json($countries);
    }

    public function states($countryId)
    {
        $states = State::where('country_id', $countryId)->active()->orderBy('name')->get();
        return response()->json($states);
    }

    public function cities($stateId)
    {
        $cities = City::where('state_id', $stateId)->active()->orderBy('name')->get();
        return response()->json($cities);
    }
}
