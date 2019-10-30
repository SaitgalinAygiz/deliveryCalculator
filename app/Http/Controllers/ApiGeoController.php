<?php

namespace App\Http\Controllers;

use App\yandexGeoApi;
use Illuminate\Http\Request;

class ApiGeoController extends Controller
{
    public function coordinates(Request $request) {



        $cityTitle = $request->get('cityTo');

        $yandexGeoApi = new yandexGeoApi();

        $results = $yandexGeoApi->coords($cityTitle);


        if (!empty($results)) {
            return $results;
        } else {
            return 'no results';
        }
    }
}
