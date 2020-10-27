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
        if($request->get('tipo') == 1){

            $warehouse = Warehouse::join("brands","warehouses.brand_id","=","brands.id")
            ->select('item', 'brands.name as Bname', 'code', 'quantity','warehouses.created_at as Wcreated')
            ->whereItem($request->item)
            ->whereBrand($request->marca)
            ->whereFrom($request->fechainicio)
            ->whereTo($request->fechafin)
            ->get();
            $now=Carbon::now();
            $pdf= PDF::loadView('reportes.pdf',compact('warehouse','now'));
            return $pdf->stream('almacen.pdf');
        }
        else if($request->get('tipo') == 2)
        {
            $deposit = Deposit::join("brands", "deposits.brand_id", "=", "brands.id")
            ->select('deposits.id as Did', 'item', 'brands.name as Bname', 'code', 'state', 'deposits.created_at as Dcreated')
            ->whereItem($request->item)
            ->whereBrand($request->marca)
            ->whereFrom($request->fechainicio)
            ->whereTo($request->fechafin)
            ->whereState($request->estado)
            ->get();
        $now=Carbon::now();
        $pdf= PDF::loadView('reportes.pdfdeposit',compact('deposit','now'));
        return $pdf->stream('deposito.pdf');
        }       // $pdf->stream('user-list.pdf');

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

            $deposit = Deposit::join("brands", "deposits.brand_id", "=", "brands.id")
            ->select('deposits.id as Did', 'item', 'brands.name as Bname', 'code', 'state', 'deposits.created_at as Dcreated')
            ->whereItem($request->item)
            ->whereBrand($request->brand)
            ->whereFrom($request->fromdate)
            ->whereTo($request->todate)
            ->whereState($request->state)
            ->get();
            return Datatables()->of($deposit)->toJson();

        }
    }
}
