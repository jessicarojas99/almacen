<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Receipt;
use App\Receipt_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = [
            "Gerencia General",
            "Unidad de Adquisiciones",
            "Unidad de RRHH",
            "Unidad Administrativa",
            "Unidad Financiera",
            "Unidad Contable",
            "Gerencia Comercial",
            "Gerencia de Planificacion y Proyectos",
            "Unidad de Proyectos",
            "Unidad de Analisis Operativo",
            "Unidad de Obras Civiles",
            "Unidad de TI",
            "Unidad de Seguridad Industrial",
            "Unidad de Auditoria Interna",
            "Unidad de Transparencia",
            "Unidad de Asesoria Legal"
        ];
        $items = Deposit::select(DB::raw("CONCAT(deposits.item,' - ',deposits.code) AS itemCode"), 'deposits.id')
            ->where('deposits.state', '=', 'Disponible')
            ->get();
        return view('receipt.index', compact('items', 'units'));
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
                $acciones = '<a href="javascript:void(0)" onclick="showItem(' . $receipt->Rid . ')" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i> Detalle</a>
                <a href="/prestamo/imprimir/' . $receipt->Rid . '" target="_blank" class="btn btn-dark btn-sm bgVerde"><i class="fas fa-print"></i> Recibo</a>';
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
        $dato = Validator::make($request->all(), [
            'responsable' => 'required|min:3|max:200',
            'delivery' => 'required',
        ], [
            'responsable.required' => 'El campo responsable es obligatorio.',
            'responsable.min' => 'El responsable debe tener al menos 3 caracteres.',
            'responsable.max' => 'El responsable no debe exceder a los 200 caracteres.',
            'delivery.required' => 'La fecha de entrega es obligatoria.',
        ]);
        if ($dato->fails()) {
            return response()->json(['errors' => $dato->errors()]);
        } else {
            $mytime = Carbon::now();
            $mytime = $mytime->format('d-m-Y');
            $receipt = new Receipt();
            $receipt->code = $request->code . "-" . $mytime;
            $receipt->responsable = ucwords($request->responsable);
            $receipt->unit = $request->unit;
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
    public function show($id)
    {
        $receipt = Receipt_detail::join("receipts", "receipts.id", "=", "receipt_details.receipt_id")
            ->join("users", "receipts.user_id", "=", "users.id")
            ->join("deposits", "deposits.id", "=", "receipt_details.deposit_id")
            ->select(DB::raw("CONCAT(deposits.item,' - ',deposits.code) AS itemCode"), 'receipts.id as Rid', 'receipts.code as Rcode', 'users.name as Uname', 'responsable', 'delivery_date', 'return_date', 'unit')
            ->where("receipts.id", "=", $id)
            ->get();

        return response()->json($receipt);
    }
    public function printReceipt($id)
    {
        $receipt = Receipt_detail::join("receipts", "receipts.id", "=", "receipt_details.receipt_id")
            ->join("users", "receipts.user_id", "=", "users.id")
            ->join("deposits", "deposits.id", "=", "receipt_details.deposit_id")
            ->select(DB::raw("CONCAT(deposits.item,' - ',deposits.code) AS itemCode"), 'receipts.id as Rid', 'receipts.code as Rcode', 'users.name as Uname', 'responsable', 'delivery_date', 'return_date', 'unit')
            ->where("receipts.id", "=", $id)
            ->get();

        $now = Carbon::now();
        $pdf = PDF::loadView('receipt.recibos', compact('receipt', 'now'));
        return $pdf->stream('recibo.pdf');
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
