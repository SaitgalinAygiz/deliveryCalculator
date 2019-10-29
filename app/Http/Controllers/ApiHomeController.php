<?php


namespace App\Http\Controllers;


use App\baikalApi;
use App\dellinApi;
use App\dimexApi;
use App\glavdostavkaApi;
use App\gtdApi;
use App\jdeApi;
use App\nrgApi;
use App\pecomApi;
use App\vozovozApi;
use Illuminate\Http\Request;

class ApiHomeController extends Controller
{
    public function calculate(Request $request) {


        //код пока что ВРЕМЕННО такой

        $cityFrom = (string) $request->get('cityFrom');
        $cityTo = (string) $request->get('cityTo');
        $weight = (integer)$request->get('weight');
        $width = (integer)$request->get('width');
        $height = (integer) $request->get('height');
        $length = (integer)$request->get('length');

        $nrgCheckbox = $request->get('nrgCheckbox');
        $dellinCheckbox = $request->get('dellinCheckbox');
        $pecomCheckbox = $request->get('pecomCheckbox');
        $baikalCheckbox = $request->get('baikalCheckbox');
        $gtdCheckbox = $request->get('gtdCheckbox');
        $vozovozCheckbox = $request->get('vozovozCheckbox');
        $glavdostavkaCheckbox = $request->get('glavdostavkaCheckbox');
        $jdeCheckbox = $request->get('jdeCheckbox');
        $dimexCheckbox = $request->get('dimexCheckbox');


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
                $nrgApiPriceResult = $nrgApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);
                if ($nrgApiPriceResult == 'no results') {
                    //no results
                } else {
                    array_push($results, $nrgApiPriceResult);
                }
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

                if ($dellinApiPriceResult == 'no results') {
                    //no results
                } else {
                    array_push($results, $dellinApiPriceResult);
                }

            }



        }


        //ПЭК
        if ($pecomCheckbox !== false) {
            $pecomApi = new pecomApi();
            $cityFromId = $pecomApi->getCityId($cityFrom);
            $cityToId = $pecomApi->getCityId($cityTo);

            if ($cityFromId == 'no results' || $cityToId == 'no results') {
                //no results
            } else {
                $pecomApiPriceResult = $pecomApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);
                if ($pecomApiPriceResult == 'no results') {
                    //no results
                } else {
                    array_push($results, $pecomApiPriceResult);
                }
            }

        }

        //Байкал сервис
        if ($baikalCheckbox !== false) {

            $baikalApi = new baikalApi();

            $cityFromId = $baikalApi->getCityId($cityFrom);
            $cityToId = $baikalApi->getCityId($cityTo);

            if ($cityFromId == 'no results' || $cityToId == 'no results') {
                //no results
            } else {
                $baikalApiPriceResult = $baikalApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);
                if ($baikalApiPriceResult == 'no results') {
                    //no results
                } else {
                    array_push($results, $baikalApiPriceResult);
                }
            }

        }

        if ($gtdCheckbox !== false) {

            $gtdApi = new gtdApi();
            $cityFromId = $gtdApi->getCityId($cityFrom);
            $cityToId = $gtdApi->getCityId($cityTo);

            if ($cityFromId == 'no results' || $cityToId == 'no results') {
                //no results
            } else {
                $gtdApiPriceResult = $gtdApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);
                if ($gtdApiPriceResult == 'no results') {
                    //no results
                } else {
                    array_push($results, $gtdApiPriceResult);
                }
            }
        }

        if ($vozovozCheckbox !== false) {

            $vozovozApi = new vozovozApi();
            $vozovozApiPriceResult = $vozovozApi->price($cityFrom, $cityTo, $weight, $width, $height, $length);
            if ($vozovozApiPriceResult == 'no results') {
                //no results
            } else {
                array_push($results, $vozovozApiPriceResult);
            }
        }

        if ($glavdostavkaCheckbox !== false) {

            $glavdostavkaApi = new glavdostavkaApi();

            $cityFromId = $glavdostavkaApi->getCityId($cityFrom);
            $cityToId = $glavdostavkaApi->getCityId($cityTo);

            if ($cityFromId == 'no results' || $cityToId == 'no results') {
                //no results
            } else {

                $vozovozApiPriceResult = $glavdostavkaApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);
                if ($vozovozApiPriceResult == 'no results') {
                    //no results
                } else {
                    array_push($results, $vozovozApiPriceResult);
                }
            }
        }

        if ($jdeCheckbox !== false) {
            $jdeApi = new jdeApi();

            $jdeApiPriceResult = $jdeApi->price($cityFrom, $cityTo, $weight, $width, $height, $length);

            if ($jdeApiPriceResult == 'no results') {
                //no results
            } else {
                array_push($results, $jdeApiPriceResult);
            }

        }

        if ($dimexCheckbox !== false) {
            $dimexApi = new dimexApi();

            $cityFromId = $dimexApi->getCityId($cityFrom);
            $cityToId = $dimexApi->getCityId($cityTo);

            if ($cityFromId == 'no results' || $cityToId == 'no results') {
                //no results
            } else {

                $dimexApiPriceResult = $dimexApi->price($cityFromId, $cityToId, $weight, $width, $height, $length);

                if ($dimexApiPriceResult == 'no results') {
                    //no results
                } else {
                    array_push($results, $dimexApiPriceResult);
                }
            }
        }





        if (!empty($results)) {
            return $results;
        } else {
            return 'no results';
        }


    }

}
