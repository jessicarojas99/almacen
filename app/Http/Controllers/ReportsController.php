<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Deposit;
use App\User;
use App\Warehouse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Carbon;

class ReportsController extends Controller
{
    public function index()
    {
        $brands=Brand::all();
        return view('reportes/consultas', compact('brands'));
    }

    public function reportespdf(Request $request)
    {
        $warehouse = Warehouse::join("brands","warehouses.brand_id","=","brands.id")
        ->select('item', 'brands.name as Bname', 'code', 'quantity','warehouses.created_at as Wcreated')
        ->whereItem($request->item)
        ->whereBrand($request->marca)
        ->whereFrom($request->fechainicio)
        ->whereTo($request->fechafin)
        ->get();
        $now=Carbon::now();
        $pdf= PDF::loadView('reportes.pdf',compact('warehouse','now'));
        return $pdf->stream('reporte.pdf');
       // $pdf->stream('user-list.pdf');

    }
    public function consulta(Request $request)
    {

        if(request()->ajax()){

                $warehouse = Warehouse::join("brands","warehouses.brand_id","=","brands.id")
                ->select('warehouses.id as Wid', 'item', 'brands.name as Bname', 'code', 'quantity','warehouses.created_at as Wcreated')
                ->whereItem($request->item)
                ->whereBrand($request->brand)
                ->whereFrom($request->fromdate)
                ->whereTo($request->todate)
                ->whereQuantity($request->quantity)
                ->get();
            return datatables()->of($warehouse)->toJson();
        }

    }
    public function consultadeposito(Request $request)
    {
        if(request()->ajax()){

                $deposit= Deposit::select('id', 'item', 'brand', 'code', 'size','state')
                ->whereItem($request->item)
                ->whereBrand($request->brand)
                ->get();

            return datatables()->of($deposit)->toJson();
        }
    }
}
