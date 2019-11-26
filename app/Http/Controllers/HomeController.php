<?php

namespace App\Http\Controllers;

use App\baikalApi;
use App\cdekApi;
use App\dellinApi;
use App\dimexApi;
use App\glavdostavkaApi;
use App\gtdApi;
use App\jdeApi;
use App\nrgApi;
use App\pecomApi;
use App\pochtaApi;
use App\vozovozApi;
use App\yandexGeoApi;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class HomeController extends Controller
{


    public function index()
    {


        /*
        $allCities = [];
        $city = [];

        $row = 1;

        if(($handle = fopen("../storage/app/public/cities.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    array_push($city, $data[$c]);

                }
                array_push($allCities, $city);
                $city = [];
                dd($allCities);

            }
            fclose($handle);
        }


        */

        /*
        $gtdApi = new gtdApi();

        $trackingNumber = 'МСКЕК40010818306';
        $trackingNumber = 'КИВВДКИМ-4/0333';

        $results = $gtdApi->getTrackingStatus($trackingNumber);

        dd($results);


        */

        /*


        $trackingNumber = 'МСКЕК40010818306';

        //GTD
        $gtdApi = new gtdApi();

        $results = $gtdApi->getTrackingStatus($trackingNumber);

        if ($results !== 'no results') {
            $response['results'] = $results;
        } else {
            $results = null;
        }

        //ПОЧТА
        $pochta = new pochtaApi();

        $results = $pochta->tracking($trackingNumber);

        if ($results !== 'no results') {
            $response['results'] = $results;
        }


        dd($response);




        $cityFrom = 'Москва';
        $cityTo = 'Уфа';
        $weight = 1000;
        $width = 10;
        $length = 10;
        $height = 10;


        $pochtaApi = new pochtaApi();

        $cityFromNormalize = $pochtaApi->normalizeAddress($cityFrom);
        $cityToNormalize = $pochtaApi->normalizeAddress($cityTo);


        $results = $pochtaApi->price($cityFromNormalize, $cityToNormalize, $weight, $width, $height, $length);



        dd($results);

        */


        return view('welcome');

    }






}
