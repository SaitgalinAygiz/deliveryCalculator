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
            'password' => 'CWi7VtiLxf',
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




    public function login () {

        $request = $this->client->get('https://api.sandbox.nrg-tk.ru/v3/login', $this->loginParams);

        return $res = $request->getStatusCode();

    }

    public function getCityId($cityTitle) {
        $citiesResponse = $this->client->get('https://api.sandbox.nrg-tk.ru/v3/cities')->getBody()->getContents();

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

        $response =  $this->client->post('https://api.sandbox.nrg-tk.ru/v3/price', $this->priceParams())->getBody();

        $json = json_decode($response);
        $json = $json->transfer[0];
        $json->company = 'Энергия';
        $json->logo = '/storage/images/nrg-logo.png';


        return $json;

    }

}
