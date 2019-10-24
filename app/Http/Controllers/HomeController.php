<?php

namespace App\Http\Controllers;

use App\baikalApi;
use App\dellinApi;
use App\gtdApi;
use App\nrgApi;
use App\pecomApi;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class HomeController extends Controller
{


    public function index()
    {


        /*

        $cityFrom = 'Уфа';
        $cityTo = 'Москва';
        $weight = 1;
        $width = 100;
        $height = 100;
        $length = 100;


        $results = [];

        $pecomApi = new pecomApi();
        $cityFromId = $pecomApi->getCityId($cityFrom);
        $cityToId = $pecomApi->getCityId($cityTo);


        if ($cityFromId == 'no results' || $cityToId == 'no results') {
            //no results
        } else {
            $gtdApiPriceResult = $pecomApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);

            if ($gtdApiPriceResult == 'no results') {
                //no results
            } else {
                array_push($results, $gtdApiPriceResult);
            }
        }

        */






        return view('welcome');
    }






}
