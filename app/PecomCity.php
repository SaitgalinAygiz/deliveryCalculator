<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class PecomCity extends Model
{
    private $client;

    protected $table = 'pecom_cities';


    protected $fillable = [
        'bitrix_id',
        'city_title'
    ];

    public function coords() {

        return $this->hasMany(PecomCoords::class, 'city_id');
    }

    public function getApiCities() {

        $credentials = base64_encode('Aygiz_S:72FDBD5ACA69A63E727EE1C8EAD4BAEDA92DB22E');

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
                'Accept' => 'application/json',
                'Authorization' => ['Basic '.$credentials],
            ],
        ]);

        $citiesResponse = $this->client->post('https://kabinet.pecom.ru/api/v1/branches/all/')->getBody()->getContents();

        $citiesResponseDecode = json_decode($citiesResponse);




        foreach ($citiesResponseDecode->branches as $branch) {
            $city = PecomCity::create([
                'bitrix_id' => (integer) $branch->bitrixId,
                'city_title' => $branch->title
        ]);
            foreach ($branch->divisions as $division) {
                foreach ($division->warehouses as $warehouse) {
                    //склады
                    if ($warehouse->isWarehouseGivesFreights == true){
                        //если склад выдает грузы

                        $explodeResults = explode(',', $warehouse->coordinates);
                        $city->coords()->create([
                            'address_longitude' => (float) $explodeResults['0'],
                            'address_latitude' => (float) $explodeResults['1']
                        ]);
                    }
                }
            }


        }

    }

}
