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
use App\yandexGeoApi;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class HomeController extends Controller
{


    public function index()
    {

        /*

        $cityTitle = 'Москва';

        $yandexGeoApi = new yandexGeoApi();

        $results = $yandexGeoApi->coords($cityTitle);


        dd($results);

        */



        return view('welcome');
    }






}
