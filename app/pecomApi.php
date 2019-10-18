<?php


namespace App;


use GuzzleHttp\Client;

class pecomApi
{
    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    private $token = 'Aygiz_S:72FDBD5ACA69A63E727EE1C8EAD4BAEDA92DB22E';

    private function loginParams() {
        return [
            'json' => [
                'login' => 'Aygiz_S',
                'password' => '72FDBD5ACA69A63E727EE1C8EAD4BAEDA92DB22E',

                ]
        ];
    }

    private function priceParams() {
        return [
            'json' =>  [
                'idCityFrom' => $this->cityFrom, //туймазы
                'idCityTo' => $this->cityTo, //сургут
                'cover' => 0,
                'idCurrency' => 1,
                'items' => [[
                    'weight' => $this->weight,
                    'width' => $this->width,
                    'height' => $this->height,
                    'length' => $this->length
                ]],
                'declaredCargoPrice' => 0,
                'idClient' => 0
            ]
        ];
    }


    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json; charset=utf-8',
                'Accept' => 'application/json',
                'Authorization' => 'Basic 72FDBD5ACA69A63E727EE1C8EAD4BAEDA92DB22E'
            ],
        ]);

    }


    public function login() {

        $request = $this->client->post('https://kabinet.pecom.ru/api/v1/auth/profiledata');

        return $request;

    }

    public function getCityId($cityTitle) {
        $citiesResponse = $this->client->post('https://kabinet.pecom.ru/api/v1/branches/all');

        $cities = json_decode($citiesResponse);


        foreach ($cities->cityList as $city) {
            if ($cityTitle == $city->name) {
                $cityId = $city->id;
            }
        }



        return $cityId;

    }

    public function price ($cityFrom, $cityTo, $weight, $width, $height, $length) {

        $this->cityFrom = $cityFrom;
        $this->cityTo = $cityTo;
        $this->weight = $weight;
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;

        $response =  $this->client->post('https://kabinet.pecom.ru/api/v1/calculator', $this->priceParams())->getBody();

        $json = json_decode($response);
        $json = $json->transfer[0];
        $json->company = 'Энергия';
        $json->logo = '/storage/images/nrg-logo.png';


        return $json;

    }




}
