<?php


namespace App;


use GuzzleHttp\Client;

class glavdostavkaApi
{

    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    private function priceParams() {
        return [
            'query' =>  [
                'responseFormat' => 'json',
                'method' => 'api_calc',
                'depPoint' => $this->cityFrom,
                'arrPoint' => $this->cityTo,
                'cargoKg' => [
                    '1' => $this->weight
                ],
                'cargoMest' => [
                    '1' => 1
                ],
                'cargoL' => [
                    '1' => $this->length
                ],
                'cargoW' => [
                    '1' => $this->width
                ],
                'cargoH' => [
                    '1' => $this->height
                ],
                'cargoCalculation' => 1,
            ]
        ];
    }


    public function __construct()
    {

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
        ]);

    }



    public function getCityId($cityTitle) {



        $citiesResponse = $this->client->post('https://glav-dostavka.ru/api/calc/?responseFormat=json&method=api_city')->getBody()->getContents();

        $citiesResponseDecode = json_decode($citiesResponse);

        foreach ($citiesResponseDecode as $city) {
            if ($cityTitle == $city->name) {
                $cityId = $city->id;
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
        $this->width = (integer) $width / 100;
        $this->height = (integer) $height / 100;
        $this->length = (integer) $length / 100;



        $response =  $this->client->get('https://glav-dostavka.ru/api/calc/', $this->priceParams())->getBody()->getContents();

        $responseDecode = json_decode($response);


        if (empty($responseDecode->price)) {
            return 'no results';
        }


        $responseDecode->company = 'Главдоставка';
        $responseDecode->interval = 'уточняйте';
        $responseDecode->logo = '/storage/images/glavdostavka-logo.png';


        return $responseDecode;

    }

}
