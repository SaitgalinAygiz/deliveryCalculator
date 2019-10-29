<?php


namespace App;


use GuzzleHttp\Client;

class jdeApi
{


    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    private function priceParams() {
        return [

            'query' =>  [
                'from' => $this->cityFrom,
                'to' => $this->cityTo,
                'smart' => 1,
                'weight' => $this->weight,
                'volume' => $this->width * $this->length * $this->height,
                'length' => $this->length,
                'width' => $this->width,
                'height' => $this->height,
                'quantity' => 1,
                'user' => 2252177796428553,
                'token' => 195658567888696640,
            ]
        ];
    }


    public function __construct()
    {

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',

            ],
        ]);

    }




    public function price ($cityFrom, $cityTo, $weight, $width, $height, $length) {

        $this->cityFrom = $cityFrom;
        $this->cityTo = $cityTo;
        $this->weight = $weight;
        $this->width = (integer) $width / 100;
        $this->height = (integer) $height / 100;
        $this->length = (integer) $length / 100;

        $response = $this->client->get('https://api.jde.ru/vD/calculator/price', $this->priceParams())->getBody()->getContents();

        $responseDecode = json_decode($response);


        if (empty($responseDecode->price)) {
            return 'no results';
        }

        $responseDecode->company = 'ЖелДорЭкспедиция';

        if ($responseDecode->mindays == $responseDecode->maxdays) {
            $responseDecode->interval = $responseDecode->mindays . ' дней';
        } else {
            $responseDecode->interval =  $responseDecode->mindays . '-' . $responseDecode->maxdays . ' дней';
        }

        $responseDecode->logo = '/storage/images/jde-logo.png';




        return $responseDecode;

    }

}
