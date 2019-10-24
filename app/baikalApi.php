<?php


namespace App;


use GuzzleHttp\Client;

class baikalApi
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
            'query' =>  [
                'from' => [
                    'guid' => $this->cityFrom,
                    'delivery' => 0,
                    'loading' => 0,
                ],
                'to' => [
                    'guid' => $this->cityTo,
                    'delivery' => 0,
                    'loading' => 0,
                ],
                'insurance' => 0,
                'return_docs' => 0,
                'cargo' => [
                    'weight' => $this->weight,
                    'volume' => $this->length * $this->width * $this->height,
                    'length' => $this->length,
                    'width' => $this->width,
                    'height' => $this->height,
                    'oversized' => 0,
                    'pack' => [
                        'crate' => 0,
                        'pallet' => 0,
                        'sealed_pallet' => 0,
                        'bubble_wrap' => 0,
                        'big_bag' => 0,
                        'medium_bag' => 0,
                        'small_bag' => 0,
                    ],
                    'units' => 1,
                ],
                'netto' => 1,


            ]
        ];
    }


    public function __construct()
    {
        $credentials = base64_encode('76814aae5ccffdfdbe222d082f16a72d: "https://api.baikalsr.ru/v1/affiliate"');

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => ['Basic '.$credentials],


            ],
        ]);

    }



    public function getCityId($cityTitle) {

        $citiesResponse = $this->client->get('https://api.baikalsr.ru/v1/fias/cities?text='.$cityTitle)->getBody()->getContents();


        $citiesResponseDecode = json_decode($citiesResponse);

        $cityId = $citiesResponseDecode['0']->guid;

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

        $response =  $this->client->get('https://api.baikalsr.ru/v1/calculator', $this->priceParams())->getBody()->getContents();

        $responseDecode = json_decode($response);

        if (empty($responseDecode->total)) {
            return 'no results';
        }

        $responseDecode->price = (integer) $responseDecode->total->int;

        $responseDecode->company = 'Байкал';
        $responseDecode->logo = '/storage/images/baikal-logo.png';
        $responseDecode->interval = (string) $responseDecode->transit->int . ' ' . $responseDecode->transit->day;


        return $responseDecode;

    }

}
