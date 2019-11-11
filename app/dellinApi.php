<?php


namespace App;


use GuzzleHttp\Client;

class dellinApi
{


    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;
    private $cityTitle;


    private function branchParams() {
        return [ 'json' => [
            'appkey' => 'B38AE3E7-F8BF-4604-ACF5-861ECDEBF615'
        ]];
    }


    private function cityParams($cityTitle) {
        return [
            'json' => [
                'appkey' => 'B38AE3E7-F8BF-4604-ACF5-861ECDEBF615',
                'q' => $cityTitle,
                'limit' => 1

            ]
        ];
    }

    private function priceParams() {
        return [
            'json' =>  [
                'appkey' => 'B38AE3E7-F8BF-4604-ACF5-861ECDEBF615',
                "derivalPoint" => $this->cityFrom,
                "derivalDoor" => false,
                "arrivalPoint" => $this->cityTo,
                "arrivalDoor" => false,
                "sizedVolume" => $this->width * $this->height * $this->length,
                "sizedWeight" => $this->weight,
            ]
        ];
    }


    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

    }





    public function getBranchCoords($cityId) {


        $branchesResponseUrl = json_decode($this->client->post('https://api.dellin.ru/v3/public/terminals.json', $this->branchParams())->getBody()->getContents());


        $branchesResponse = json_decode($this->client->get($branchesResponseUrl->url)->getBody()->getContents());


        $coords = [];
        $allCoords = [];

        foreach ($branchesResponse->city as $city) {

            if ($cityId == $city->code) {
                foreach ($city->terminals->terminal as $terminal) {

                        array_push($coords, (float)$terminal->latitude, (float)$terminal->longitude);
                        array_push($allCoords, $coords);
                        $coords = [];
                    }
                }

            }

        return $allCoords;


    }


    public function getCityId($cityTitle) {

        $citiesResponse = $this->client->post('https://api.dellin.ru/v2/public/kladr.json', $this->cityParams($cityTitle))->getBody()->getContents();

        $citiesResponse = json_decode($citiesResponse);




        if (!empty($citiesResponse->cities[0])) {
            return $citiesResponse->cities[0]->code;
        } else {
            return 'no results';
        }
    }

    public function price ($cityFrom, $cityTo, $weight, $width, $height, $length) {

        $this->cityFrom = $cityFrom;
        $this->cityTo = $cityTo;
        $this->weight = $weight;
        $this->width = (integer) $width / 100;
        $this->height = (integer) $height / 100;
        $this->length = (integer) $length / 100;

        $response =  $this->client->post('https://api.dellin.ru/v1/public/calculator.json', $this->priceParams())->getBody()->getContents();

        $json = json_decode($response);

        if (empty($json->price)) {
            return 'no results';
        }


        //Я первый раз писал, мб потом нормально сделаю
        $interval = $json->time->genitive;
        $price = $json->price;
        $json = $json->time;
        $json->interval = $interval;
        $json->price = (integer) $price;
        $json->company = 'Деловые Линии';
        $json->logo = '/storage/images/dellin.png';

        $branches = $this->getBranchCoords($cityTo);

        $json->branches = $branches;


        return $json;

    }

}
