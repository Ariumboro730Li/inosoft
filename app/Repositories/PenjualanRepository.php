<?php

namespace App\Repositories;

use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

class PenjualanRepository
{
    public function groupSales(){
        $pipeline = [
            [
                '$group' => [
                    '_id' => [
                        'kendaraan_id' => [
                            '$toLower' => '$kendaraan_id'
                        ]
                    ],
                    'kendaraan_id' => [
                        '$last' => '$kendaraan_id'
                    ],
                    'total_penjualan' => [
                        '$sum' => 1
                    ],
                    'jumlah_terjual' => [
                        '$sum' => ['$toInt' => '$jumlah']
                    ]
                ]
            ],
            [
                '$sort' => [
                    'kendaraan_id' => 1
                ]
            ]
        ];


        $result = DB::collection('penjualans')
        ->raw()
        ->aggregate($pipeline)
        ->toArray();

        return $result;
    }

    public function reportSalesById(string $type, $id){
        return Penjualan::where("type_kendaraan", $type)->where("kendaraan_id", $id)->get();
    }
}
