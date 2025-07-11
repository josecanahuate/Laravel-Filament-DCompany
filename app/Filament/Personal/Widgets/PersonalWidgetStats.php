<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Holiday;
use App\Models\Timesheet;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PersonalWidgetStats extends BaseWidget
{

    protected function getStats(): array
    {
         return [
            Stat::make('Pending Holidays', $this->getPendingHolidays(Auth::user())),
            Stat::make('Approved Holidays', $this->getAprovedHoliday(Auth::user())),
            Stat::make('Total Work', $this->getTotalWorks(Auth::user())),
            Stat::make('Total Pause', $this->getTotalPause(Auth::user())),
        ];
    }

    protected function getPendingHolidays(User $user){
        $totalPending = Holiday::where('user_id', $user->id)
        ->where('type', 'pending')->get()->count();

        return $totalPending;
    }


    protected function getAprovedHoliday(User $user){
        $totalAproved = Holiday::where('user_id', $user->id)
        ->where('type', 'aproved')->get()->count();

        return $totalAproved;
    }


    //OBTENIENDO LAS HORAS TRABAJADAS EN EL DIA PRESENTE
    protected function getTotalWorks(User $user){
        $totalWorks = Timesheet::where('user_id', $user->id)
            ->where('type', 'work')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $sumSeconds = 0;
        foreach ($totalWorks as $timesheet) {
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalDuration = $finishTime->diffInSeconds($startTime);
            $sumSeconds += $totalDuration;
        }

        $totalHoursWorks = gmdate("H:i:s", $sumSeconds);

        return $totalHoursWorks;
    }


    //OBTENIENDO LAS HORAS PAUSADAS EN EL DIA PRESENTE
     protected function getTotalPause(User $user){
        $totalPause = Timesheet::where('user_id', $user->id)
        ->where('type', 'pause')->whereDate('created_at', Carbon::today())->get();

        $sumSeconds = 0;
        foreach ($totalPause as $timesheet) {
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalDuration = $finishTime->diffInSeconds($startTime);
            $sumSeconds += $totalDuration;
        }
        //$totalPauseWorks = floor($sumSeconds / 3600);
        //dd($totalDuration);
        $totalPauseWorks = gmdate("H:i:s", $sumSeconds);

        return $totalPauseWorks;
    }
}