<?php


namespace App;


use GuzzleHttp\Client;

class gtdApi
{
    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    private function branchParams($cityId)
    {
        return [
            'json' => [
                'geography_city_id' => $cityId
            ]
        ];
    }

    private function trackingStatusParams($cargoNumber) {
        return [
            'json' => [
                'cargo_number' => $cargoNumber
            ]
        ];
    }

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

    public function getTrackingStatus($cargoNumber) {

        $responseTracking = $this->client->post('https://capi.gtdel.com/1.0/order/status/get', $this->trackingStatusParams($cargoNumber))->getBody()->getContents();

        $responseDecodeTracking = json_decode($responseTracking);


        $results = (array) $responseDecodeTracking;

        if (empty($responseDecodeTracking->from)) {
            return 'no results';
        }

        $movements = [];
        $movement = [];


        foreach ($results['status'] as $result) {
            foreach ($movements as $movement) {
                if(!empty($result->name)){
                    $movement['operationName'] = $result->name;
                }

                if(!empty($result->date)) {
                    $operDate = $result->date . $result->time;
                    $date = new \DateTime($operDate);
                    $movement['operationDate'] = $date->format('Y-m-d H:i:s');
                }

            }
            array_push($movements, $movement);

        }

        $firstArrayElement = array_shift($movements);



        $cityFrom = $this->getCityTitle($responseDecodeTracking->from);
        $cityTo = $this->getCityTitle($responseDecodeTracking->to);


        $results['whereToIndex'] = $cityFrom;
        $results['weight'] = '';
        $results['sender'] = '';
        $results['historyRecord'] = 'hm';
        $results['whereToCity'] = $cityTo;
        $results['recepient'] = $responseDecodeTracking->address;
        $results['movements'] = $movements;




        return $results;

    }


    public function getBranchCoords($cityId) {

        $responseCities = $this->client->post('https://capi.gtdel.com/1.0/geography/city/get-list', $this->branchParams($cityId))->getBody()->getContents();

        $responseCitiesDecode = json_decode($responseCities);

        foreach ($responseCitiesDecode as $city) {
            if ($cityId == $city->tdd_city_code) {
                $geoCityId = $city->id;
            }
        }


        $responseBranches = $this->client->post('https://capi.gtdel.com/1.0/geography/address/get-list', $this->branchParams($geoCityId))->getBody()->getContents();

        $responseBranchesDecode = json_decode($responseBranches);



        $coords = [];
        $allCoords = [];
        foreach ($responseBranchesDecode as $branch) {
            array_push($coords, (float)$branch->lat, (float)$branch->lon);
            array_push($allCoords, $coords);
            $coords = [];
        }



        return $allCoords;

    }

    public function getCityTitle($cityId) {
        $citiesResponse = $this->client->post('https://capi.gtdel.com/1.0/tdd/city/get-list')->getBody()->getContents();

        $citiesResponseDecode = json_decode($citiesResponse);

        foreach ($citiesResponseDecode as $city) {
            if ($cityId == $city->code) {
                $cityTitle = $city->name;
            }
        }

        if (empty($cityTitle)) {
            return 'no results';
        }

        return $cityTitle;

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

        $branches = $this->getBranchCoords($cityTo);

        $results->branches = $branches;



        return $results;

    }



}
