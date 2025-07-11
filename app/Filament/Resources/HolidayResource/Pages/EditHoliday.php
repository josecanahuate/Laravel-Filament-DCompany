<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use App\Mail\HolidayApproved;
use App\Mail\HolidayDecline;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    //coloque el correo fake manual pk no estoy recibiendo correos en correo personal.
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        //dd($record);
        //SEND EMAIL TO EMPLOYEE ONLY IF 'aproved'
        if ($record->type == 'aproved') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'day' => $record->day
            );
            //Mail::to("ciyevic332@binafex.com")->send(new HolidayApproved($data));
            $recipient = $user;

            Notification::make()
            ->title('Solicitud de Vacaciones')
            ->warning()
            ->iconColor('success')
            ->body('Solicitud de Vacaciones Aprobada')
            ->sendToDatabase($recipient);


        } else if ($record->type == 'decline'){
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'day' => $record->day
            );
            //Mail::to("ciyevic332@binafex.com")->send(new HolidayDecline($data));

            $recipient = $user;

            Notification::make()
            ->title('Solicitud de Vacaciones')
            ->warning()
            ->iconColor('warning')
            ->body('Solicitud de Vacaciones Rechazada')
            ->sendToDatabase($recipient);
        }

        return $record;
    }
}
