<?php

namespace App\Imports;

use App\Models\Calendar;
use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MyTimesheetImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            //dd($row);
            $calendar_id = Calendar::where('name', $row['calendario_laboral'])->first()->id;
            $user_id = User::where('name', $row['usuario'])->first()->id;
            //$user = User::where('name', $row['usuario'])->first(); // OTRA FORMA
            Timesheet::create([
                'calendar_id' => $calendar_id,
                'user_id' => $user_id,
                //'user_id' => $user->id,
                'type' => $row['tipo'],
                'day_in' => $row['hora_de_entrada'],
                'day_out' => $row['hora_de_salida'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
