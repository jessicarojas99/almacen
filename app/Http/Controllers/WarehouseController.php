<?php

namespace App\Http\Controllers;

use App\Brand;
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
        $brands=Brand::all();
        return view('warehouse.index', compact('brands'));
    }

    public function list()
    {
        //
        $warehouse = Warehouse::select('id', 'item', 'brand_id', 'code', 'quantity','created_at')->get();
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
        $storage->code = $request->code;
        $storage->color = $request->color;
        $storage->quantity = $request->quantity;
        $storage->description = $request->description;
        $storage->brand_id = $request->brand;
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
        $item->brand_id = $request->brand;
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
    public function destroy($id,Request $request)
    {
        $item = Warehouse::find($id);
        $item->reason = $request->motivo;
        $item->saveOrFail();
        $item->delete();
       //Warehouse::destroy($id);
        return back();
    }
}
