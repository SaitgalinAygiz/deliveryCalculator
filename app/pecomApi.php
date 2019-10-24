<?php


namespace App;


use GuzzleHttp\Client;

class pecomApi
{
    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    private function getCityParams($cityTitle) {

        if ($cityTitle == 'Москва') {
            $cityTitle = 'Москва Восток';
        }

        return [
            'json' => [
                'title' => $cityTitle,
            ]
        ];
    }

    private function priceParams() {


        return [
            'json' =>  [
                    'senderCityId' => $this->cityFrom, //туймазы
                    'receiverCityId' => $this->cityTo, //сургут
                    'isOpenCarSender' => false,
                    'senderDistanceType' => 0,
                    'isDayByDay' => false,
                    'isOpenCarReceiver' => false,
                    'receiverDistanceType' => 0,
                    'isHyperMarket' => false,
                    'isInsurance' => false,
                    'isPickUp' => false,
                    'isDelivery' => false,
                    'Cargos' => [[
                        'length' => $this->length,
                        'width' => $this->width,
                        'height' => $this->height,
                        'volume' => $this->length * $this->width * $this->height,
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

        $credentials = base64_encode('Aygiz_S:72FDBD5ACA69A63E727EE1C8EAD4BAEDA92DB22E');

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
                'Accept' => 'application/json',
                'Authorization' => ['Basic '.$credentials],
            ],
        ]);

    }


    public function getCityId($cityTitle) {

        $citiesResponse = $this->client->post('https://kabinet.pecom.ru/api/v1/branches/all/')->getBody()->getContents();

        $citiesResponseDecode = json_decode(mb_strtolower($citiesResponse));


        $cityTitle = mb_strtolower($cityTitle);

        if ($cityTitle == 'москва') {
            $cityTitle = 'москва восток';
        }

        foreach ($citiesResponseDecode->branches as $city) {
            if ($cityTitle == $city->title) {
                $cityId = $city->bitrixid;
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
        $this->width =  $width / 100;
        $this->height =  $height / 100;
        $this->length =  $length / 100;


        $response =  $this->client->post('https://kabinet.pecom.ru/api/v1/calculator/calculateprice/', $this->priceParams())->getBody()->getContents();


        $response = json_decode($response);

        if (empty($response->transfers[0])) {
            return 'no results';
        }

        $results = $response->transfers[0];




        $results->price = (integer) $response->transfers[0]->costTotal;

        if (isset($response->commonTerms[0]->transportingWithDeliveryWithPickup)) {

            $results->interval = $response->commonTerms[0]->transportingWithDeliveryWithPickup;
            $results->interval = str_replace(' ','', $results->interval) . ' дней';

        }
        $results->company = 'ПЭК';
        $results->logo = '/storage/images/logo-pek.png';


        return $results;


    }




}
