<?php

namespace App\Exports;

use App\Room;
use Maatwebsite\Excel\Concerns\FromCollection;

class RoomsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Room::all();
    }
}
