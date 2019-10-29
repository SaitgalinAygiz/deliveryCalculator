<?php


namespace App;


use GuzzleHttp\Client;

class vozovozApi
{
    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    private function priceParams() {
        return [

            'json' =>  [
                'object' => "price",
                'action' => 'get',
                'params' => [
                    'cargo' => [
                        'dimension' => [
                            'quantity' => 1,
                            'volume' => $this->width * $this->height * $this->length,
                            'weight' => $this->weight
                        ]
                    ],
                    'gateway' => [
                        'dispatch' => [
                            'point' => [
                                'location' => $this->cityFrom,
                                'terminal' => 'default'
                            ]
                        ],
                        'destination' => [
                            'point' => [
                                'location' => $this->cityTo,
                                'terminal' => 'default'
                            ]
                        ]
                    ]
                ],

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

        $response = $this->client->post('https://vozovoz.ru/api/?token=C52AOE5vkllExasa0EHeQ9UiYUhSBCHLHJOTBhsM', $this->priceParams())->getBody()->getContents();

        $responseDecode = json_decode($response);


        if (empty($responseDecode->response->price)) {
            return 'no results';
        }

        $results = $responseDecode->response;


        $servicePrice = (integer) $results->service['2']->price;
        $basePrice = (integer) str_replace(' ', '', $results->price);


        $results->price = $basePrice - $servicePrice;
        $results->company = 'Возовоз';



        if ($results->deliveryTime->from == $results->deliveryTime->to) {
            $results->interval = $results->deliveryTime->from . ' дней';
        } else {
           $results->interval =  $results->deliveryTime->from . '-' . $results->deliveryTime->to . ' дней';
        }

        $results->logo = '/storage/images/vozovoz-logo.jpg';




        return $results;

    }

}
