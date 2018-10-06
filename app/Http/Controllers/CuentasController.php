<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuentas;
use App\Cliente;
use App\Movimientos;
use Hashids;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;

class CuentasController extends Controller
{
    protected $rules = [
        'cliente_id' => 'required|numeric',
        'nombre' => 'required|max:255',
        'saldo' => 'required|numeric|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            if (!Auth::user()->esCliente()) {
                $cuentas = Cuentas::with('cliente:id,nombre')->paginate(15);
            }else {
                $cuentas = Cuentas::where('cliente_id', Auth::user()->cliente_id)->with('cliente:id,nombre')->paginate(15);
            }
            return view('cuentas.index', compact('cuentas'));
        } catch (\Exception $e) {
            toastr()->error('Algo salio mal');
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            if (Auth::user()->esCliente()) {
                toastr()->error('Algo salio mal');
                return back();
            }
            $clientes = Cliente::all()->pluck('nombre', 'id');

            if (sizeof($clientes) == 0) {
                toastr()->error('No hay Clientes registrados');
                return redirect()->route('cuentas.index');
            }
            return view('cuentas.create', compact('clientes'));
        } catch (\Exception $e) {
            toastr()->error('Algo salio mal');
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            if (Auth::user()->esCliente()) {
                toastr()->error('Algo salio mal');
                return back();
            }
            $req = $request->all();
            $messages = [
                'saldo.regex' => 'El Monto debe de ser con 2 decimales por lo menos',
            ];
            $validator = Validator::make($req, $this->rules, $messages);

            if ($validator->fails()) {
                return redirect()->route('cuentas.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            Cuentas::create($req);
            toastr()->success('Cuenta Creada Exitosamente');
            return redirect()->route('cuentas.index');
        } catch (\Exception $e) {
            toastr()->error('Algo salio mal');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $cuenta_id = Hashids::decode($id)[0];
            $cuenta = Cuentas::with('cliente')->find($cuenta_id);
            $movimientos = Movimientos::where('cuenta_id', $cuenta->id)->orderBy('created_at', 'desc')->paginate(15);

            return view('cuentas.show', compact('cuenta', 'movimientos'));
        } catch (\Exception $e) {
            toastr()->error('Algo salio mal');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            if (Auth::user()->esCliente()) {
                toastr()->error('Algo salio mal');
                return back();
            }
            $cuenta_id = Hashids::decode($id)[0];
            $cuenta = Cuentas::find($cuenta_id);
            $clientes = Cliente::all()->pluck('nombre', 'id');

            return view('cuentas.edit', compact('cuenta', 'clientes'));
        } catch (\Exception $e) {
            toastr()->error('Algo salio mal');
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            if (Auth::user()->esCliente()) {
                toastr()->error('Algo salio mal');
                return back();
            }
            $req = $request->all();
            $messages = [
                'saldo.regex' => 'El Monto debe de ser con 2 decimales por lo menos',
            ];
            $validator = Validator::make($req, $this->rules, $messages);

            if ($validator->fails()) {
                return redirect()->route('cuentas.edit')
                    ->withErrors($validator)
                    ->withInput();
            }

            $cuenta_id = Hashids::decode($id)[0];
            $cuenta = Cliente::find($cuenta_id);

            $cuenta->update($req);

            toastr()->success('Cuenta Actualizado');
            return redirect()->route('cuentas.index');
        } catch (\Exception $e) {
            toastr()->error('Algo salio mal');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function mostrar_cajero()
    {
        try{
            if (!Auth::user()->esCliente()) {

                $cuentas = Cuentas::all()->pluck('id', 'id');
                $tipos = ["D"=>"Deposito", "R"=>"Retiro"];

                if (sizeof($cuentas) == 0) {
                    toastr()->error('No hay Cuentas registradas');
                    return back();
                }

                return view('cajero.create', compact('cuentas', 'tipos'));
            }else {
                return back();
            }
        } catch (\Exception $e) {
            toastr()->error('Algo salio mal');
            return back();
        }
    }
    public function listar_movimientos()
    {   
        try{ 
            if (!Auth::user()->esCliente()) {   
                $movimientos = Movimientos::orderBy('created_at', 'desc')->paginate(15);
                return view('cajero.index', compact('movimientos'));
            }else {
                return back();
            }
        } catch (\Exception $e) {
            toastr()->error('Algo salio mal');
            return back();
        }
    }

    public function transaccion(Request $request)
    {
        try{
            if (Auth::user()->esCliente()) {   
                return back();
            }

            \DB::beginTransaction();

            $req = $request->all();

            $messages = [
                'monto.regex' => 'El Monto debe de ser con 2 decimales por lo menos',
            ];
            
            $validator = Validator::make($req, [
                'cuenta_id' => 'required|numeric',
                'tipo' => 'required|max:1',
                'monto' => 'required|numeric|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            ], $messages);

            if ($validator->fails()) {
                return back()
                ->withErrors($validator)
                ->withInput();
            }

            $cuenta = Cuentas::find($req['cuenta_id']);

            if ($req['tipo'] == 'D') {
                $req['saldo_anterior'] = $cuenta->saldo;
                $cuenta->saldo = $req['monto'] + $cuenta->saldo;
                $req['saldo_nuevo'] = $cuenta->saldo;
            }

            if ($req['tipo'] == 'R') {
                $aux = $cuenta->saldo - $req['monto'];
                if ($aux < 0) {
                    toastr()->error('Saldo insuficiente');
                    \DB::rollback();
                    return back()->withInput();
                }
                $req['saldo_anterior'] = $cuenta->saldo;
                $cuenta->saldo = $cuenta->saldo - $req['monto'];
                $req['saldo_nuevo'] = $cuenta->saldo;
            }

            //\DB::rollback();
            $cuenta->save();
            Movimientos::create($req);

            \DB::commit();

            toastr()->success('Movimiento Realizado Exitosamente');
            return redirect()->route('listar-movimientos');
        } catch (\Exception $e) {
            \DB::rollback();
            toastr()->error('Algo salio mal');
            return back();
        }
    }

}
