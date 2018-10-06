<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CuentasExternas;
use App\CuentasTerceros;
use App\Cuentas;
use App\Movimientos;
use Hashids;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;

class CuentasTercerosController extends Controller
{
    protected $rules = [
        'alias' => 'required|max:255',
        'cuenta_externa_id' => 'required',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $cuentas = CuentasTerceros::where('user_id', Auth::id())->with('cuenta')->paginate(15);
            
            return view('cuentas-terceros.index', compact('cuentas'));
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
            return view('cuentas-terceros.create');
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
            $req = $request->all();
            $validator = Validator::make($req, $this->rules);

            if ($validator->fails()) {
                return redirect()->route('cuentas-externas.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            $cuentaExterna = CuentasExternas::where('id', $req['cuenta_externa_id'])->count();

            if ($cuentaExterna) {

                $cuenta = CuentasExternas::where('id', $req['cuenta_externa_id'])->get()[0];

                $req['user_id'] = Auth::id();
                $req['cuenta_externa_id'] = $cuenta->id;

                CuentasTerceros::create($req);
            }else {
                toastr()->error('Cuenta No encotrada');
                return back();
            }


            toastr()->success('Cuenta Creada Exitosamente');
            return redirect()->route('cuentas-terceros.index');
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
        //
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
            $cuenta_id = Hashids::decode($id)[0];
            $cuenta = CuentasTerceros::find($cuenta_id);

            return view('cuentas-terceros.edit', compact('cuenta'));
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
            $req = $request->all();

            $cuenta_id = Hashids::decode($id)[0];
            $cuenta = CuentasTerceros::find($cuenta_id);

            $cuenta->update($req);
            toastr()->success('Cuenta Actualizada');
            return redirect()->route('cuentas-terceros.index');
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
            if (Auth::user()->esCliente()) {

                $cuentasTerceros = CuentasTerceros::where('user_id', Auth::id())->pluck('alias', 'id');
                $cuentas = Cuentas::where('cliente_id', Auth::user()->cliente_id)->pluck('nombre', 'id');

                if (sizeof($cuentas) == 0) {
                    toastr()->error('No hay Cuentas registradas');
                    return back();
                }

                return view('cuentas-terceros.cajero', compact('cuentas', 'cuentasTerceros'));
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
            \DB::beginTransaction();

            $req = $request->all();

            $messages = [
                'monto.regex' => 'El Monto debe de ser con 2 decimales por lo menos',
            ];
            
            $validator = Validator::make($req, [
                'cuenta_id' => 'required|numeric',
                'cuenta_terceros_id' => 'required|numeric',
                'monto' => 'required|numeric|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            ], $messages);

            if ($validator->fails()) {
                return back()
                ->withErrors($validator)
                ->withInput();
            }

            $cuenta = Cuentas::find($req['cuenta_id']);

            $aux = $cuenta->saldo - $req['monto'];
            if ($aux < 0) {
                toastr()->error('Saldo insuficiente');
                \DB::rollback();
                return back()->withInput();
            }

            $req['saldo_anterior'] = $cuenta->saldo;
            $cuenta->saldo = $cuenta->saldo - $req['monto'];
            $req['saldo_nuevo'] = $cuenta->saldo;
            $req['tipo'] = 'T';

            $cuentaTerceros = CuentasTerceros::find($req['cuenta_terceros_id']);
            
            
            $cuentaExterna = CuentasExternas::find($cuentaTerceros->cuenta_externa_id);

            if ($cuentaExterna->limite_monto < $req['monto']) {
                toastr()->error('El monto Supera el limite de la cuenta destino');
                \DB::rollback();
                return back()->withInput();
            }

            $hoy = Carbon::now();
            $inicioMes = $hoy->startOfMonth()->toDateTimeString();
            $finMes = $hoy->endOfMonth()->toDateTimeString();


            $movimientos = Movimientos::where('cuenta_terceros_id', $cuentaTerceros->id)
                                        ->where('cuenta_id', $cuenta->id)
                                        ->whereBetween('created_at', array($inicioMes, $finMes))
                                        ->count();

            if ($movimientos >= $cuentaExterna->limite_transacciones) {
                toastr()->error('Ha llegado a su limite de transaciones para esta cuenta');
                \DB::rollback();
                return back()->withInput();
            }

            $cuentaExterna->saldo = $cuentaExterna->saldo + $req['monto'];

            //\DB::rollback();
            $cuenta->save();
            $cuentaExterna->save();
            Movimientos::create($req);

            \DB::commit();

            toastr()->success('Movimiento Realizado Exitosamente');
            return redirect()->route('cuentas.index');
        } catch (\Exception $e) {
            \DB::rollback();
            toastr()->error('Algo salio mal');
            return back();
        }
    }
}
