<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {

        $lastTimesheet = Timesheet::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();

        if ($lastTimesheet == null) {
            return [
            Action::make('inWork')
            ->label('Entrar a Trabajar')
            ->color('success')
            ->requiresConfirmation()
            ->action(function (){
                $user = Auth::user();
                $timesheet = new Timesheet();
                $timesheet->calendar_id = 1;
                $timesheet->user_id = $user->id;
                $timesheet->type = 'work';
                $timesheet->day_in = Carbon::now();
                $timesheet->day_out = '';
                $timesheet->save();
            }),
            Actions\CreateAction::make(),
        ];
        }


        return [
            Action::make('inWork')
            ->label('Entrar a Trabajar')
            ->color('success')
            ->visible(!$lastTimesheet->day_out == null)
            ->disabled($lastTimesheet->day_in == null)
            ->requiresConfirmation()
            ->action(function (){
                $user = Auth::user();
                $timesheet = new Timesheet();
                $timesheet->calendar_id = 1;
                $timesheet->user_id = $user->id;
                $timesheet->type = 'work';
                $timesheet->day_in = Carbon::now();
                $timesheet->day_out = '';
                $timesheet->save();

                Notification::make()
                ->title('Has Entrado a Trabajar')
                ->success()
                ->iconColor('success')
                ->body('Changes to the post have been saved.')
                ->send();
            }),

            Action::make('inPause')
            ->label('Comenzar Pausa')
            ->color('info')
            ->requiresConfirmation()
            ->visible($lastTimesheet->day_out == null && $lastTimesheet->type != 'pause')
            ->disabled(!$lastTimesheet->day_out == null)
            ->action(function () use($lastTimesheet){
                $lastTimesheet->day_out = Carbon::now();
                $lastTimesheet->save();
                $timesheet = new Timesheet();
                $timesheet->calendar_id = 1;
                $timesheet->user_id = Auth::user()->id;
                $timesheet->type = 'pause';
                $timesheet->day_in = Carbon::now();
                $timesheet->day_out = '';
                $timesheet->save();

                Notification::make()
                ->title('Has Empezado una Pausa')
                ->success()
                ->send();
            }),

            Action::make('stopPause')
            ->label('Parar Pausa')
            ->color('info')
            ->requiresConfirmation()
            ->visible($lastTimesheet->day_out == null && $lastTimesheet->type == 'pause')
            ->disabled(!$lastTimesheet->day_out == null)
            ->action(function () use($lastTimesheet){
                $lastTimesheet->day_out = Carbon::now();
                $lastTimesheet->save();
                $timesheet = new Timesheet();
                $timesheet->calendar_id = 1;
                $timesheet->user_id = Auth::user()->id;
                $timesheet->type = 'work';
                $timesheet->day_in = Carbon::now();
                $timesheet->day_out = '';
                $timesheet->save();

                Notification::make()
                ->title('Has Empezado a Trabajar')
                ->success()
                ->send();
            }),

            Action::make('stopWork')
            ->label('Parar de Trabajar')
            ->color('success')
            ->requiresConfirmation()
            ->visible($lastTimesheet->day_out == null && $lastTimesheet->type != 'pause')
            ->disabled(!$lastTimesheet->day_out == null)
            ->action(function () use($lastTimesheet){
                $lastTimesheet->day_out = Carbon::now();
                $lastTimesheet->save();

            Notification::make()
            ->title('Has Terminado de Trabajar')
            ->success()
            ->send();            }),

            Actions\CreateAction::make(),
        ];
    }
}