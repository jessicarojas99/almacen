<?php

namespace App\Http\Controllers;

use App\User;
use Yajra\DataTables\Facades\DataTables;
use App\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('warehouse.index');
    }

    public function list()
    {
        //
        $warehouse = Warehouse::select('id', 'item', 'brand', 'code', 'quantity')->get();
        return datatables()->of($warehouse)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Warehouse::create($request->all());
        // return $this->successResponse('Organismo financiador creado');
        $storage = new Warehouse();
        $storage->item = $request->item;
        $storage->brand = $request->brand;
        $storage->code = $request->code;
        $storage->color = $request->color;
        $storage->quantity = $request->quantity;
        $storage->description = $request->description;
        $storage->saveOrFail();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Warehouse::where("warehouses.id", "=", $id)->get();
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $item = Warehouse::find($request->id);
        $item->item = $request->item;
        $item->brand = $request->brand;
        $item->code = $request->code;
        $item->color = $request->color;
        $item->quantity = $request->quantity;
        $item->description = $request->description;
        $item->saveOrFail();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Warehouse::destroy($id);
        return back();
    }
}
