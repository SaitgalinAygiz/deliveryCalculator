<?php

namespace App\Http\Controllers;

use App\gtdApi;
use App\pochtaApi;
use Illuminate\Http\Request;

class ApiTrackingController extends Controller
{
    public function tracking(Request $request) {





        $trackingNumber = $request->get('trackingNumber');



        //ПОЧТА
        $pochta = new pochtaApi();

        $results = $pochta->tracking($trackingNumber);

        if ($results !== 'no results') {
            $response['results'] = $results;
        }

        if (!empty($response)) {
            return $response;
        } else {
            return 'no results';
        }
    }
}
