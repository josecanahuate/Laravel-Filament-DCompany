<?php

namespace App\Filament\Resources\TimesheetResource\Pages;

use App\Filament\Resources\TimesheetResource;
use App\Imports\MyTimesheetImport;
use App\Models\Timesheet;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
 use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
            ->color("primary")
            ->use(MyTimesheetImport::class),
            Actions\CreateAction::make(),

            Action::make('createPDF')
            ->color("warning")
            ->requiresConfirmation()
            ->label('PDF')
            ->url(
                fn (): string => route('pdf.example', ['user' => Auth::user()]),
                shouldOpenInNewTab: true
            )
        ];
    }
}
