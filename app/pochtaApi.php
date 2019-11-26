<?php


namespace App;


use GuzzleHttp\Client;
use SoapClient;

class pochtaApi
{


    private $client;

    private $cityFrom, $cityTo, $weight, $width, $height, $length;


    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Accept' => 'application/json',
                'Authorization' => 'AccessToken pB1fjLZ6n4Z3Fk5iFeT9xoJtgxyTjQyd',
                'X-User-Authorization' => 'Basic c2FpdGdhbGluMThAZ21haWwuY29tOkZxdWJQMjAxNjEzNjc3Nw==',
                ],
        ]);

    }

    private function priceParams() {
        return [
            'json' => [
                'completeness-checking' => true,
                'contents-checking' => true,
                'courier' => false,
                'declared-value' => 0,
                'delivery-point-index' => $this->cityTo,
                'dimension' => [
                    'height' => $this->height,
                    'length' => $this->length,
                    'width' => $this->width
                ],
                'dimension-type' => "S",
                'entries-type' => "GIFT",
                'fragile' => false,
                'index-from' => $this->cityFrom,
                'index-to' => $this->cityTo,
                'inventory' => false,
                'mail-category' => 'SIMPLE',
                'mail-type' => 'UNDEFINED',
                'mass' => $this->weight,
                'notice-payment-method' => "CASHLESS",
                'payment-method' => "CASHLESS",
                'sms-notice-recepient' => 0,
                'transport-type' => "SURFACE",
                'vsd' => false,
                'with-electronic-notice' => true,
                'with-order-of-notice' => false,
                'with-simple-notice' => false

            ]
        ];
    }


    public function params($trackNumber) {
        return [
            'OperationHistoryRequest' => [
                'Barcode' => $trackNumber,
                'MessageType' => 0,
                'Language' => 'RUS'
            ],
            'AuthorizationHeader' => [
                'login' => 'GwbtFbSZKwUXYs',
                'password' => 'iienu2MME3Sr'
            ]

        ];
    }

    public function normalizeAddress($cityTitle) {

        $response = $this->client->get('/postoffice/1.0/settlement.offices.codes?settlement='.urlencode($cityTitle))->getBody()->getContents();
        https://otpravka-api.pochta.ru
        $responseDecode = json_decode($response);


        if (empty($responseDecode['0'])) {
            return 'no results';
        }

        $cityCode = $responseDecode['0'];

        return $cityCode;

    }

    public function price ($cityFrom, $cityTo, $weight, $width, $height, $length) {

        $this->cityFrom = $cityFrom;
        $this->cityTo = $cityTo;
        $this->weight = $weight;
        $this->width =  $width / 100;
        $this->height =  $height / 100;
        $this->length =  $length / 100;


        $response =  $this->client->post('https://otpravka-api.pochta.ru/1.0/tariff', $this->priceParams());

        $response = json_decode($response);


        dd($response);

        if (empty($response->transfers[0])) {
            return 'no results';
        }

        $results = $response->transfers[0];

        $results->price = (integer) $response->transfers[0]->costTotal;

        $results->interval = 'уточняйте';
        $results->company = 'ПЭК';
        $results->logo = '/storage/images/logo-pek.jpg';
        $branches = $this->getBranchCoords($cityTo);
        $results->branches = $branches;

        return $results;


    }



    public function tracking($trackNumber) {

        try {
            $soapclient = new \SoapClient('https://tracking.russianpost.ru/rtm34?wsdl', array('trace' => 1, 'soap_version' => SOAP_1_2));
            $params = $this->params($trackNumber);
            $operationHistoryRequest = $soapclient->getOperationHistory(new \SoapParam($params, 'OperationHistoryRequest'));
        } catch (\SoapFault $fault) {
            return 'no results';
        }

        $results = $operationHistoryRequest->OperationHistoryData;


        $results->sender = $results->historyRecord['0']->UserParameters->Sndr;
        $results->recepient = $results->historyRecord['0']->UserParameters->Rcpn;

        $results->whereToIndex = $results->historyRecord['0']->AddressParameters->DestinationAddress->Index;
        $results->whereToCity = $results->historyRecord['0']->AddressParameters->DestinationAddress->Description;

        $results->weight = (string) $results->historyRecord['0']->ItemParameters->Mass . ' г';

        $movements = [];
        $movement = [];

        foreach ($results->historyRecord as $result) {
            foreach ($movements as $movement) {
                if(!empty($result->AddressParameters->OperationAddress->Description)){
                    $movement['operationAddress'] = $result->AddressParameters->OperationAddress->Description;
                }

                if(!empty($result->AddressParameters->OperationAddress->Index)) {
                    $movement['operationIndex'] = $result->AddressParameters->OperationAddress->Index;
                }

                if(!empty($result->OperationParameters->OperDate)) {
                    $operDate = $result->OperationParameters->OperDate;
                    $date = new \DateTime($operDate);
                    $movement['operationDate'] = $date->format('Y-m-d H:i:s');
                }

                if(!empty($result->OperationParameters->OperAttr->Name)) {
                    $movement['operationName'] = $result->OperationParameters->OperAttr->Name;
                }
            }
            array_push($movements, $movement);
        }

        $firstArrayElement = array_shift($movements);
        $firstArrayElement['operationName'] = 'Информация о грузе получена';
        array_unshift($movements, $firstArrayElement);

        $secondArrayElement = array_shift($movements);

        $results->movements = $movements;

        return $results;

    }

}
