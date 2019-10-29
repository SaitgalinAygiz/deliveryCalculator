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
use App\vozovozApi;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class HomeController extends Controller
{


    public function index()
    {


        /*
        $cityFrom = 'Москва';
        $cityTo = 'Санкт-Петербург';
        $weight = 1;
        $width = 100;
        $height = 100;
        $length = 100;


        $results = [];

        $baikalApi = new baikalApi();

        $cityFromId = $baikalApi->getCityId($cityFrom);
        $cityToId = $baikalApi->getCityId($cityTo);

        if ($cityFromId == 'no results' || $cityToId == 'no results') {
            //no results
        } else {
            $cdekApiPriceResult = $baikalApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);

            if ($cdekApiPriceResult == 'no results') {
                //no results
            } else {
                array_push($results, $cdekApiPriceResult);
            }
        }

        dd($results);

        */




        return view('welcome');
    }






}
