<?php


namespace App\Http\Controllers;


use App\nrgApi;
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



        //ЭНЕРГИЯ
        $nrgApi = new nrgApi();
        $cityFromId = $nrgApi->getCityId($cityFrom);
        $cityToId = $nrgApi->getCityId($cityTo);
        $nrgApi->login();
        $nrgApiPriceResult = $nrgApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);

        //


        //Что-то еще...

        $results = array($nrgApiPriceResult);

        return $results;


    }

}
