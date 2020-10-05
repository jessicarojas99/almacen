<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class ReportsController extends Controller
{
    public function index()
    {

        return view('reportes/consultas');
    }
    public function consultarusers()
    {
        // $users=User::get();
        $pdf= PDF::loadView('reportes.pdf');

        return $pdf->stream('user-list.pdf');

    }
}
