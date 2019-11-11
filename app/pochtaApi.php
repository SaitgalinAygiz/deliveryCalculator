<?php


namespace App;


use SoapClient;

class pochtaApi
{
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
