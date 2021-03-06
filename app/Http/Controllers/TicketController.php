<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Warehouse;
use App\Ticket_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
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
        $items = Warehouse::select(DB::raw("CONCAT(warehouses.item,' - ',warehouses.code) AS itemCode"), 'warehouses.id')
            ->where('warehouses.quantity', '>', 0)
            ->get();
        return view('ticket.index', compact('items', 'units'));
    }

    public function itemSelected($id)
    {
        $item = Warehouse::select(DB::raw("CONCAT(warehouses.item,' - ',warehouses.code) AS itemCode"), 'warehouses.id', 'warehouses.quantity')
            ->where('warehouses.id', '=', $id)
            ->first();
        return response()->json($item);
    }

    public function list()
    {
        $ticket = Ticket::join("users", "tickets.user_id", "=", "users.id")
            ->select('tickets.id as Tid', 'code', 'users.name as Uname', 'responsable', 'tickets.created_at as Tcreated')->get();
        return Datatables()->of($ticket)
            ->addColumn('action', function ($ticket) {
                $acciones = '<a href="javascript:void(0)" onclick="showItem(' . $ticket->Tid . ')" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i> Detalle</a>
                <a href="/comprobante/imprimir/' . $ticket->Tid . '" target="_blank" class="btn btn-dark btn-sm bgVerde"><i class="fas fa-print"></i> Comprobante</a>';
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
        ], [
            'responsable.required' => 'El campo responsable es obligatorio.',
            'responsable.min' => 'El responsable debe tener al menos 3 caracteres.',
            'responsable.max' => 'El responsable no debe exceder a los 200 caracteres.',
        ]);
        if ($dato->fails()) {
            return response()->json(['errors' => $dato->errors()]);
        } else {
            $mytime = Carbon::now();
            $mytime = $mytime->format('d-m-Y');
            $ticket = new Ticket();
            $ticket->code =  $request->code . "-" . $mytime;
            $ticket->responsable = ucwords($request->responsable);
            $ticket->unit = $request->unit;
            $ticket->user_id = Auth::id();
            $ticket->saveOrFail();

            $idDetail = $request->idDetailValue;
            $quantityDetail = $request->quantityDetailValue;
            $cont = 0;

            while ($cont < count($idDetail)) {
                $item = Warehouse::find($idDetail[$cont]);
                $item->quantity = ($item->quantity) - $quantityDetail[$cont];
                $item->saveOrFail();
                $detail = new Ticket_detail();
                $detail->quantity = $quantityDetail[$cont];
                $detail->warehouse_id = $idDetail[$cont];
                $detail->ticket_id = $ticket->id;
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

    public function codeGenerate($name)
    {
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket_detail::join("tickets", "tickets.id", "=", "ticket_details.ticket_id")
            ->join("users", "tickets.user_id", "=", "users.id")
            ->join("warehouses", "warehouses.id", "=", "ticket_details.warehouse_id")
            ->select(DB::raw("CONCAT(warehouses.item,' - ',warehouses.code) AS Witem"), 'tickets.id as Tid', 'tickets.code as Tcode', 'users.name as Uname', 'responsable', 'warehouses.code as Wcode', 'ticket_details.quantity as Tquantity', 'ticket_details.id as TDid', 'tickets.created_at as Tcreated', 'unit')
            ->where("tickets.id", "=", $id)
            ->get();

        return response()->json($ticket);
    }

    public function printTicket($id)
    {

        $ticket = Ticket_detail::join("tickets", "tickets.id", "=", "ticket_details.ticket_id")
            ->join("users", "tickets.user_id", "=", "users.id")
            ->join("warehouses", "warehouses.id", "=", "ticket_details.warehouse_id")
            ->select('tickets.id as Tid', 'tickets.code as Tcode', 'users.name as Uname', 'responsable', 'warehouses.item as Witem', 'warehouses.code as Wcode', 'ticket_details.quantity as Tquantity', 'ticket_details.id as TDid', 'tickets.created_at as Tcreated', 'unit')
            ->where("tickets.id", "=", $id)
            ->get();
        $now = Carbon::now();
        $pdf = PDF::loadView('ticket.comprobante', compact('ticket', 'now'));
        return $pdf->stream('comprobante.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
