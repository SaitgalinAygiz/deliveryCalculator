<?php


namespace App;


use GuzzleHttp\Client;

class dellinApi
{


    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;
    private $cityTitle;


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





    public function getCityId($cityTitle) {

        $citiesResponse = $this->client->post('https://api.dellin.ru/v2/public/kladr.json', $this->cityParams($cityTitle))->getBody()->getContents();

        $citiesResponse = json_decode($citiesResponse);

        $result = $citiesResponse->cities[0]->code;

        return $result;

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
        $interval = $json->time->genitive;
        $price = $json->price;
        $json = $json->time;
        $json->interval = $interval;
        $json->price = (integer) $price;
        $json->company = 'Деловые Линии';
        $json->logo = '/storage/images/dellin.png';


        return $json;

    }

}
