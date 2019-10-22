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
        $weight = (integer)$request->get('weight');
        $width = (integer)$request->get('width');
        $height = (integer) $request->get('height');
        $length = (integer)$request->get('length');

        $nrgCheckbox = $request->get('nrgCheckbox');
        $dellinCheckbox = $request->get('dellinCheckbox');
        $pecomCheckbox = $request->get('pecomCheckbox');


        $results = [];

        //Энергия
        if ($nrgCheckbox !== false){

            $nrgApi = new nrgApi();
            $cityFromId = $nrgApi->getCityId($cityFrom);
            $cityToId = $nrgApi->getCityId($cityTo);

            //оч плохо(
            if ($cityFromId == 'no results' || $cityToId == 'no results') {
                //no results
            } else {
                $nrgApi->login();
                $nrgApiPriceResult = $nrgApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);
                array_push($results, $nrgApiPriceResult);
            }


        }

        //Деловые линии
        if ($dellinCheckbox !== false) {

            $dellinApi = new dellinApi();
            $cityFromId = $dellinApi->getCityId($cityFrom);
            $cityToId = $dellinApi->getCityId($cityTo);

            if ($cityFromId == 'no results' || $cityToId == 'no results') {
                //no results
            } else {
                $dellinApiPriceResult = $dellinApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);

                array_push($results, $dellinApiPriceResult);
            }



        }


        //ПЭК
        if($pecomCheckbox !== false) {
            $pecomApi = new pecomApi();
            $cityFromId = $pecomApi->getCityId($cityFrom);
            $cityToId = $pecomApi->getCityId($cityTo);

            if ($cityFromId == 'no results' || $cityToId == 'no results') {
                //no results
            } else {
                $pecomApiPriceResult = $pecomApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);
                array_push($results, $pecomApiPriceResult);
            }

        }

        if (!empty($results)) {
            return $results;
        } else {
            return 'no results';
        }


    }

}
