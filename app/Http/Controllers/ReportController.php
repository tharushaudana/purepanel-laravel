<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PDF;

class ReportController extends Controller
{
    public function downloadPublicMarksReport(Center $center, Test $test)
    {
        $data = [
            'test' => $test,
        ];
          
        $pdf = PDF::loadView('reports.public_marks_report', $data);
    
        return $pdf->stream();
    }

    public function test() {
        $test = Test::find(3);

        $data = [
            'test' => $test,
        ];
          
        $pdf = PDF::loadView('reports.public_marks_report', $data);
    
        //return $pdf->download('techsolutionstuff.pdf');
        return $pdf->stream();
    }
}
