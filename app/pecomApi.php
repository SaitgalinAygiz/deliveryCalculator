<?php


namespace App;


use GuzzleHttp\Client;

class pecomApi
{
    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    private function getCityParams($cityTitle) {



        if ($cityTitle == 'Краснодар') {
            $cityTitle = 'КрасноДАР';
        }

        return [
            'json' => [
                'title' => $cityTitle,
            ]
        ];
    }

    private function idParams($cityId) {
        return [
            'json' => [
                'id' => $cityId
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
                'calcDate' => "2019-11-21",
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


        $city = PecomCity::where('city_title', $cityTitle)->firstOrFail();

        $cityId = $city->bitrix_id;

        if (!empty($cityId)) {
            return $cityId;
        } else {
            return 'no results';
        }
    }


    public function getBranchCoords($cityId) {

        $city = PecomCity::where('bitrix_id', $cityId)->firstOrFail();

        $cityCoords = $city->coords()->get();

        $coords = [];
        $allCoords = [];

        foreach ($cityCoords as $cityCoord) {
            array_push($coords, $cityCoord->address_longitude, $cityCoord->address_latitude);
            array_push($allCoords, $coords);
            $coords = [];
        }


        if (!empty($allCoords)) {
            return $allCoords;
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

        /*
        if (isset($response->commonTerms[0]->transportingWithDeliveryWithPickup)) {
            $results->interval = $response->commonTerms[0]->transportingWithDeliveryWithPickup;
            $results->interval = str_replace(' ','', $results->interval) . ' дней';
        }

        */

        $results->interval = 'уточняйте';

        $results->company = 'ПЭК';
        $results->logo = '/storage/images/logo-pek.jpg';

        $branches = $this->getBranchCoords($cityTo);

        $results->branches = $branches;

        return $results;


    }




}
