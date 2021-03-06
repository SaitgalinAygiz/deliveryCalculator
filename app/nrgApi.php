<?php


namespace App;


use GuzzleHttp\Client;

class nrgApi
{

    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    private $loginParams = [
        'query' => [
            'user' => 'saitgalin18@gmail.com',
            'password' => 'Zpx1AXHJMR',
        ]
    ];

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
                'Content-Type' => 'application/json',
                'NrgApi-DevToken' => 'tE31cLTwBU148eABxQ89YPX3r1IfQtbeawxyWBy93ptIkhSe04jZY7s0gBhMdv6H',
            ],
        ]);

    }




    public function login() {

        $request = $this->client->get('https://mainapi.nrg-tk.ru/v3/login', $this->loginParams);

        return $res = $request->getStatusCode();

    }


    public function getBranchCoords($cityId) {

        $responseBranches = $this->client->get('https://mainapi.nrg-tk.ru/v3/cities')->getBody()->getContents();


        $responseBranchesDecode = json_decode($responseBranches);


        $coords = [];
        $allCoords = [];

        foreach ($responseBranchesDecode->cityList as $city) {
            if ($cityId == $city->id) {
                foreach ($city->warehouses as $warehouse) {
                    if ($warehouse->isIssuer == 1) {

                        array_push($coords, (float)$warehouse->latitude, (float)$warehouse->longitude);
                        array_push($allCoords, $coords);
                        $coords = [];
                    }
                }
            }
        }

        return $allCoords;

    }



    public function getCityId($cityTitle) {
        $citiesResponse = $this->client->get('https://mainapi.nrg-tk.ru/v3/cities')->getBody()->getContents();


        $cities = json_decode(mb_strtolower($citiesResponse));

        $cityTitle = mb_strtolower($cityTitle);

         foreach ($cities->citylist as $city) {
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

        $response =  $this->client->post('https://mainapi.nrg-tk.ru/v3/price', $this->priceParams())->getBody();

        $results = json_decode($response);

        if(empty($results->transfer[0])) {
            return 'no results';
        }

        $results = $results->transfer[0];
        $results->company = 'Энергия';
        $results->logo = '/storage/images/nrg-logo.png';


        $branches = $this->getBranchCoords($cityTo);

        $results->branches = $branches;


        return $results;

    }

}
