<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Receipt;
use App\Receipt_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Deposit::select(DB::raw("CONCAT(deposits.item,' - ',deposits.code) AS itemCode"), 'deposits.id')
            ->where('deposits.state', '=', 'Disponible')
            ->get();
        return view('receipt.index', compact('items'));
    }

    public function itemSelected($id)
    {
        $item = Deposit::select(DB::raw("CONCAT(deposits.item,' - ',deposits.code) AS itemCode"), 'deposits.id')
            ->where('deposits.id', '=', $id)
            ->first();
        return response()->json($item);
    }

    public function list()
    {
        $receipt = Receipt::join("users", "receipts.user_id", "=", "users.id")
            ->select('receipts.id as Rid', 'code', 'users.name as Uname', 'responsable', 'receipts.created_at as Rcreated')->get();
        return Datatables()->of($receipt)
            ->addColumn('action', function ($receipt) {
                $acciones = '<a href="javascript:void(0)" onclick="showItem(' . $receipt->Tid . ')" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i> Detalle</a>';
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
        // try {
        //     DB::beginTransaction();
        //code...
        $receipt = new Receipt();
        $receipt->code = "CF31";
        $receipt->responsable = $request->responsable;
        $receipt->delivery_date = $request->delivery;
        $receipt->return_date = $request->return;
        $receipt->user_id = Auth::id();
        $receipt->saveOrFail();

        $idDetail = $request->idDetailValue;
        $cont = 0;

        while ($cont < count($idDetail)) {
            $item = Deposit::find($idDetail[$cont]);
            $item->state = "No disponible";
            $item->saveOrFail();
            $detail = new Receipt_detail();
            $detail->deposit_id = $idDetail[$cont];
            $detail->receipt_id = $receipt->id;
            $detail->saveOrFail();
            $cont = $cont + 1;
        }

        // DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollBack();
        // }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        //
    }
}
