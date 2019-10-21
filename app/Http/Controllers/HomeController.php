<?php

namespace App\Http\Controllers;

use App\dellinApi;
use App\nrgApi;
use App\pecomApi;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class HomeController extends Controller
{


    public function index()
    {


        $cityFrom = 'Москва';
        $cityTo = 'Уфа';
        $weight = '1';
        $width = '100';
        $height = '100';
        $length = '100';

        $pecomApi = new pecomApi();
        $cityFromId = $pecomApi->getCityId($cityFrom);
        $cityToId = $pecomApi->getCityId($cityTo);



        $pecomApiPriceResult = $pecomApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);

        return view('welcome');
    }






}
