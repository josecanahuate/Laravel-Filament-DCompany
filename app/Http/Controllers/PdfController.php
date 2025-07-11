<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function TimesheetRecords(){
        $timesheets = Timesheet::with('user') // carga la relación user
        ->select('id', 'calendar_id', 'user_id', 'type', 'day_in', 'day_out') // selecciona solo columnas necesarias
        ->get();
        $pdf = Pdf::loadView('pdf.example', compact('timesheets'));
        return $pdf->download('example.pdf');
    }
}
