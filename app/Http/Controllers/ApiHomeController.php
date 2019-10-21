<?php


namespace App\Http\Controllers;


use App\dellinApi;
use App\nrgApi;
use App\pecomApi;
use Illuminate\Http\Request;

class ApiHomeController extends Controller
{
    public function calculate(Request $request) {


        $cityFrom = (string) $request->get('cityFrom');
        $cityTo = (string) $request->get('cityTo');
        $weight = (float)$request->get('weight');
        $width = (float)$request->get('width');
        $height = (float) $request->get('height');
        $length = (float)$request->get('length');

        $nrgCheckbox = $request->get('nrgCheckbox');
        $dellinCheckbox = $request->get('dellinCheckbox');
        $pecomCheckbox = $request->get('pecomCheckbox');


        $results = [];

        //Энергия
        if ($nrgCheckbox !== false){

            $nrgApi = new nrgApi();
            $cityFromId = $nrgApi->getCityId($cityFrom);
            $cityToId = $nrgApi->getCityId($cityTo);
            $nrgApi->login();
            $nrgApiPriceResult = $nrgApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);

            array_push($results, $nrgApiPriceResult);
        }

        //Деловые линии
        if ($dellinCheckbox !== false) {

            $dellinApi = new dellinApi();
            $cityFromId = $dellinApi->getCityId($cityFrom);
            $cityToId = $dellinApi->getCityId($cityTo);
            $dellinApiPriceResult = $dellinApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);

            array_push($results, $dellinApiPriceResult);
        }

        return $results;


    }

}
