<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CuentasExternas;
use Illuminate\Support\Facades\Validator;
use Hashids;

class CuentasExternasController extends Controller
{

    protected $rules = [
        'nombre' => 'required|max:255',
        'saldo' => 'required|numeric|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
        'limite_monto' => 'required|numeric|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
        'limite_transacciones' => 'required|numeric',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $cuentas = CuentasExternas::paginate(15);
            
            return view('cuentas-externas.index', compact('cuentas'));
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
            return view('cuentas-externas.create');
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
            $messages = [
                'saldo.regex' => 'El Monto debe de ser con 2 decimales por lo menos',
                'limite_monto.regex' => 'El Monto debe de ser con 2 decimales por lo menos',
            ];
            $validator = Validator::make($req, $this->rules, $messages);

            if ($validator->fails()) {
                return redirect()->route('cuentas-externas.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            CuentasExternas::create($req);

            toastr()->success('Cuenta Creada Exitosamente');
            return redirect()->route('cuentas-externas.index');
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
            $cuenta = CuentasExternas::find($cuenta_id);

            return view('cuentas-externas.edit', compact('cuenta'));
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
            $messages = [
                'saldo.regex' => 'El Monto debe de ser con 2 decimales por lo menos',
                'limite_monto.regex' => 'El Monto debe de ser con 2 decimales por lo menos',
            ];
            $validator = Validator::make($req, $this->rules, $messages);

            if ($validator->fails()) {
                return redirect()->route('cuentas-externas.edit')
                    ->withErrors($validator)
                    ->withInput();
            }

            $cuenta_id = Hashids::decode($id)[0];
            $cuenta = CuentasExternas::find($cuenta_id);

            $cuenta->update($req);
            toastr()->success('Cuenta Actualizado');
            return redirect()->route('cuentas-externas.index');
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
}
