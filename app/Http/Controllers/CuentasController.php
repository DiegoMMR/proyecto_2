<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuentas;
use App\Cliente;
use Hashids;
use Illuminate\Support\Facades\Validator;

class CuentasController extends Controller
{
    protected $rules = [
        'cliente_id' => 'required|numeric',
        'nombre' => 'required|max:255',
        'saldo' => 'required|numeric',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuentas = Cuentas::with('cliente:id,nombre')->paginate(15);
        return view('cuentas.index', compact('cuentas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::all()->pluck('nombre', 'id');
        if (sizeof($clientes) == 0) {
            toastr()->error('No hay Clientes registrados');
            return redirect()->route('cuentas.index');
        }
        return view('cuentas.create', compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = $request->all();
        $validator = Validator::make($req, $this->rules);

        if ($validator->fails()) {
            return redirect()->route('cuentas.create')
                ->withErrors($validator)
                ->withInput();
        }

        Cuentas::create($req);
        toastr()->success('Cuenta Creada Exitosamente');
        return redirect()->route('cuentas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuenta_id = Hashids::decode($id)[0];
        $cuenta = Cuentas::with('cliente')->find($cuenta_id);
        return view('cuentas.show', compact('cuenta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cuenta_id = Hashids::decode($id)[0];
        $cuenta = Cuentas::find($cuenta_id);
        $clientes = Cliente::all()->pluck('nombre', 'id');

        return view('cuentas.edit', compact('cuenta', 'clientes'));
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
        $req = $request->all();
        $validator = Validator::make($req, $this->rules);

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
}
