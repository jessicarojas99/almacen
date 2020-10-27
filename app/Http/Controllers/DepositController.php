<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Deposit;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $brands = Brand::all();
        return view('deposit.index', compact('brands'));
    }

    public function list()
    {
        //
        $deposit = Deposit::join("brands", "deposits.brand_id", "=", "brands.id")
            ->select('deposits.id as Did', 'item', 'brands.name as Bname', 'code', 'state', 'deposits.created_at as Dcreated')->get();
        return Datatables()->of($deposit)
            ->addColumn('action', function ($deposit) {
                $acciones = '<a href="javascript:void(0)" onclick="showItem(' . $deposit->Did . ')" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i> Info</a>';
                return $acciones;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storage = new Deposit();
        $storage->item = ucfirst($request->item);
        $storage->code = strtoupper($request->code);
        $storage->size = $request->size;
        $storage->processor = strtoupper($request->processor);
        $storage->condition = ucfirst($request->condition);
        $storage->state = $request->state;
        $storage->description = ucfirst($request->description);
        $storage->brand_id = $request->brand;
        $storage->saveOrFail();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Deposit::where("deposits.id", "=", $id)->get();
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit $deposit)
    {
        $item = Deposit::find($request->id);
        $item->item = ucfirst($request->item);
        $item->code = strtoupper($request->code);
        $item->size = $request->size;
        $item->processor = strtoupper($request->processor);
        $item->condition = ucfirst($request->condition);
        $item->state = $request->state;
        $item->description = ucfirst($request->description);
        $item->brand_id = $request->brand;
        $item->saveOrFail();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $item = Deposit::find($id);
        $item->reason = $request->motivo;
        $item->saveOrFail();
        $item->delete();
        return back();
    }
}
