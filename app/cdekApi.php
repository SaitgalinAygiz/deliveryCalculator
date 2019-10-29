<?php


namespace App;


use GuzzleHttp\Client;

class cdekApi
{


    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    private function cityParams($cityTitle) {
        return [
            'query' => [
                'cityName' => $cityTitle,
            ]
        ];
    }

    private function priceParams() {
        return [
            'query' =>  [
                'mode' => 3,
                'cityo' => $this->cityFrom,
                'cityp' => $this->cityTo,
                'weight' => $this->weight,
                'declarv' => 'n'
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

        $citiesResponse = $this->client->get('https://integration.cdek.ru/v1/location/cities', $this->cityParams($cityTitle))->getBody()->getContents();

        $citiesResponseDecode = json_decode($citiesResponse);

        dd($citiesResponseDecode);

        $cityId = $citiesResponseDecode->data['0']->kod;


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

        $response =  $this->client->get('http://rus.tech-dimex.ru/api/calculator/result', $this->priceParams())->getBody()->getContents();

        $responseDecode = json_decode($response);


        if (empty($responseDecode->data->Itog)) {
            return 'no results';
        }

        $results = $responseDecode->data;

        $results->price = $results->Itog;
        $results->company = 'Dimex';
        $results->interval = $results->srokDost . ' дней';
        $results->logo = '/storage/images/dimex-logo.png';


        return $results;

    }

}
