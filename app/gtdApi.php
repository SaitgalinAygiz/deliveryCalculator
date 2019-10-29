<?php


namespace App;


use GuzzleHttp\Client;

class gtdApi
{
    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    private function priceParams() {
        return [
            'json' =>  [
                'city_pickup_code' => $this->cityFrom,
                'city_delivery_code' => $this->cityTo,
                'declared_price' => 1,
                'places' => [[
                    'height' => $this->height,
                    'width' => $this->width,
                    'length' => $this->length,
                    'weight' => $this->weight,
                    'count_place' => 1,

                ]],
                'insurance' => 0
            ]
        ];
    }


    public function __construct()
    {
        $credentials = '7nNnheZwE315r2d4JvEBisn0L5FGc_6o';

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => ['Bearer '.$credentials],


            ],
        ]);

    }



    public function getCityId($cityTitle) {

        $citiesResponse = $this->client->post('https://capi.gtdel.com/1.0/tdd/city/get-list')->getBody()->getContents();



        $citiesResponseDecode = json_decode(mb_strtolower($citiesResponse));

        $cityTitle = mb_strtolower($cityTitle);

        foreach ($citiesResponseDecode as $city) {
            if ($cityTitle == $city->name) {
                $cityId = $city->code;
            }
        }


        if (!empty($cityId)) {
            return $cityId;
        } else {
            return 'no results';
        }

    }

    public function price ($cityFrom, $cityTo, $weight, $width, $height, $length) {

        $this->cityFrom = $cityFrom;
        $this->cityTo = $cityTo;
        $this->weight = $weight;
        $this->width = (integer) $width;
        $this->height = (integer) $height;
        $this->length = (integer) $length;

        $response =  $this->client->post('https://capi.gtdel.com/1.0/order/calculate', $this->priceParams())->getBody()->getContents();

        $responseDecode = json_decode($response);


        if (empty($responseDecode['0']->standart)) {
            return 'no results';
        }

        $results = $responseDecode['0']->standart;

        $results->price = $results->detail['1']->price;
        $results->company = 'GTD';
        $results->interval = $results->time . ' дней';
        $results->logo = '/storage/images/gtd-logo.png';


        return $results;

    }

}
