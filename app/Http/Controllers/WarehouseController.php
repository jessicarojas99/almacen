<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Record;
use DataTables;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return view('warehouse.index', compact('brands'));
    }
    public function list()
    {
        //
        $warehouse = Warehouse::join("brands", "warehouses.brand_id", "=", "brands.id")
            ->select('warehouses.id as Wid', 'item', 'brands.name as Bname', 'code', 'quantity', 'warehouses.created_at as Wcreated')->get();
        return Datatables()->of($warehouse)
            ->addColumn('action', function ($warehouse) {
                $acciones = '<a href="javascript:void(0)" onclick="showItem(' . $warehouse->Wid . ')" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i> Info</a>';
                return $acciones;
            })
            ->rawColumns(['action'])
            ->make(true);
        // return datatables()->of($warehouse)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->name != "") {

            $dato = Validator::make($request->all(), [
                'item' => 'required|min:3|max:200',
                'code' => 'required|min:3|max:200',
                'quantity' => 'required|integer',
                'name' => 'unique:brands',

            ], [
                'item.required' => 'El item es obligatorio.',
                'item.min' => 'El item debe tener al menos 3 caracteres.',
                'item.max' => 'El item no debe exceder a los 200 caracteres.',
                'code.required' => 'El código es obligatorio.',
                'code.min' => 'El código debe tener al menos 3 caracteres.',
                'code.max' => 'El código no debe exceder a los 200 caracteres.',
                'name.unique' => 'El nombre ya existe.'

            ]);
            if ($dato->fails()) {
                return response()->json(['errors' => $dato->errors()]);
            } else {
                $marca = new Brand();
                $marca->name = ucfirst($request->name);
                $marca->saveOrFail();
                $storage = new Warehouse();
                $storage->item = ucfirst($request->item);
                $storage->code = strtoupper($request->code);
                $storage->color = ucfirst($request->color);
                $storage->quantity = $request->quantity;
                $storage->description = ucfirst($request->description);
                $storage->brand_id = $marca->id;
                $storage->saveOrFail();
                $rec = new Record();
                $rec->warehouse_id = $storage->id;
                $rec->quantity = $storage->quantity;
                $rec->saveOrFail();
            }
        } else {
            $dato = Validator::make($request->all(), [
                'item' => 'required|min:3|max:200',
                'code' => 'required|min:3|max:200',
                'quantity' => 'required|integer',
                'brand' => 'required|integer|not_in:0',

            ], [
                'item.required' => 'El item es obligatorio.',
                'item.min' => 'El item debe tener al menos 3 caracteres.',
                'item.max' => 'El item no debe exceder a los 200 caracteres.',
                'code.required' => 'El código es obligatorio.',
                'code.min' => 'El código debe tener al menos 3 caracteres.',
                'code.max' => 'El código no debe exceder a los 200 caracteres.',
                'brand.integer' => 'Debe seleccionar una marca',

            ]);
            if ($dato->fails()) {
                return response()->json(['errors' => $dato->errors()]);
            } else {
                $storage = new Warehouse();
                $storage->item = ucfirst($request->item);
                $storage->code = strtoupper($request->code);
                $storage->color = ucfirst($request->color);
                $storage->quantity = $request->quantity;
                $storage->description = ucfirst($request->description);
                $storage->brand_id = $request->brand;
                $storage->saveOrFail();
                $rec = new Record();
                $rec->warehouse_id = $storage->id;
                $rec->quantity = $storage->quantity;
                $rec->saveOrFail();
            }
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Record::join("warehouses", "records.warehouse_id", "=", "warehouses.id")
            ->join("brands", "warehouses.brand_id", "=", "brands.id")
            ->select("warehouses.item", "brands.name as Bname", "warehouses.code", "warehouses.quantity", "records.quantity as Rquantity", "warehouses.description", "warehouses.created_at as Wdate", "warehouses.color", "records.created_at as Rdate")
            ->where("records.warehouse_id", "=", $id)
            ->get();
        // $item = Record::where("records.warehouse_id", "=", $id)->get();
        return response()->json($item);
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
        if ($request->quantity != $item->quantity) {
            $rec = new Record();
            $rec->warehouse_id = $item->id;
            $rec->quantity = $request->quantity;
            $rec->saveOrFail();
        }
        $item->item = ucfirst($request->item);
        $item->brand_id = $request->brand;
        $item->code = strtoupper($request->code);
        $item->color = ucfirst($request->color);
        $item->quantity = $request->quantity;
        $item->description = ucfirst($request->description);
        $item->saveOrFail();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $item = Warehouse::find($id);
        $item->reason = $request->motivo;
        $item->saveOrFail();
        $item->delete();
        return back();
    }
}
