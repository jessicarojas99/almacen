<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\User;
use App\Warehouse;
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
        $warehouse = Warehouse::select('id', 'item', 'brand', 'code', 'quantity')->get();
        $pdf= PDF::loadView('reportes.pdf',compact('warehouse'));
        return $pdf->stream('user-list.pdf');

    }
    public function consulta(Request $request)
    {

        if(request()->ajax()){
            if(!empty($request->brand))
            {
                $warehouse = Warehouse::select('id', 'item', 'brand', 'code', 'quantity')
                ->whereItem($request->item)
                ->whereBrand($request->brand)
                ->get();
            }
            else{
                $warehouse = Warehouse::select('id', 'item', 'brand', 'code', 'quantity')->get();
            }
            return datatables()->of($warehouse)->toJson();
        }

    }
    public function consultadeposito(Request $request)
    {
        if(request()->ajax()){
            if(!empty($request->brand)){
                $deposit= Deposit::select('id', 'item', 'brand', 'code', 'size','state')
                ->whereItem($request->item)
                ->whereBrand($request->brand)
                ->get();
            }
            else{
                $deposit= Deposit::select('id', 'item', 'brand', 'code', 'size','state')->get();
            }
            return datatables()->of($deposit)->toJson();
        }
    }
}
