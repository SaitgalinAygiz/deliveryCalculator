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
            'Authorization' => 'Basic Aygiz_S:72FDBD5ACA69A63E727EE1C8EAD4BAEDA92DB22E'
        ];
    }

    private function priceParams() {
        return [
            'headers' => ['Authorization' => 'Basic Aygiz_S:72FDBD5ACA69A63E727EE1C8EAD4BAEDA92DB22E'],
            'json' =>  [
                'places' => [
                    '0' => [
                        '0' => $this->width,
                        '1' => $this->length,
                        '2' => $this->height,
                        '3' => $this->height * $this->length * $this->height,
                        '4' => $this->weight,
                        '5' => 1,
                        '6' => 1,
                    ],
                ],
                'take' => $this->cityFrom,

                'senderCityId' => $this->cityFrom, //туймазы
                'receiverCityId' => $this->cityTo, //сургут
                'isOpenCarSender' => false,
                'senderDistanceType' => 0,
                'isDayByDay' => false,
                'isOpenCarReceiver' => false,
                'isHyperMarket' => false,
                'isInsurance' => true,
                'isPickUp' => false,
                'isDelivery' => false,
                'Cargos' => [[
                    'length' => $this->length,
                    'width' => $this->width,
                    'height' => $this->height,
                    'maxSize' => max($this->length, $this->width, $this->height),
                    'isHP' => false,
                    'sealingPositionsCount' => 0,
                    'weight' => $this->weight,
                    'overSize' => false

                ]],

            ]
        ];
    }


    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
            ],
        ]);

    }


    public function login() {

        $request = $this->client->post('https://kabinet.pecom.ru/api/v1/auth', $this->loginParams());

        return $request;

    }

    public function getCityId($cityTitle) {


        $citiesResponse = $this->client->get('http://www.pecom.ru/ru/calc/towns.php')->getBody()->getContents();

        $cities = json_decode($citiesResponse, true);



        $cityId = array_key_first($cities[$cityTitle]);

        return $cityId;

    }

    public function price ($cityFrom, $cityTo, $weight, $width, $height, $length) {

        $this->cityFrom = $cityFrom;
        $this->cityTo = $cityTo;
        $this->weight = $weight;
        $this->width = $width / 100;
        $this->height =  $height / 100;
        $this->length = $length / 100;

        $response =  $this->client->post('https://kabinet.pecom.ru/api/v1/calculator/calculateprice/', $this->priceParams())->getBody();

        dd($response);



        return $response;

    }




}
