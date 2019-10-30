<?php


namespace App;


use GuzzleHttp\Client;

class yandexGeoApi
{

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

    }

    public function cityQuery($cityTitle) {
        return [
            'query' => [
                'geocode' => $cityTitle,
                'apikey' => '8ebea8f7-96e8-48de-b0b7-83d722db9b86',
                'format' => 'json'
            ]
        ];
    }

    public function coords ($cityTitle) {


        $geoResponse = $this->client->get('https://geocode-maps.yandex.ru/1.x', $this->cityQuery($cityTitle))->getBody()->getContents();

        $geoResponseDecode = json_decode($geoResponse);

        $position = $geoResponseDecode->response->GeoObjectCollection->featureMember['0']->GeoObject->Point->pos;

        $coordinates = explode(' ', $position);



        return $coordinates;


    }


}
