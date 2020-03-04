<?php

namespace App\Imports;

use App\Room;
use Maatwebsite\Excel\Concerns\ToModel;

class RoomsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Room([
            'id'            => $row[0],
            'image'         => $row[1], 
            'name'          => $row[2],
            'location'      => $row[3],
            'description'   => $row[4], 
            'created_at'    => $row[5],
            'updated_at'    => $row[6],
            'deleted_at'    => $row[7],
        ]);
    }
}
