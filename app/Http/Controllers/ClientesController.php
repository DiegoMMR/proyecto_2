<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Hashids;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{

    protected $rules = [
        'dpi' => 'required|numeric',
        'nombre' => 'required|max:255',
        'email' => 'required|email',
        'direccion' => 'required|max:255',
        'telefono' => 'required|numeric',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::paginate(15);
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
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
            return redirect()->route('clientes.create')
                ->withErrors($validator)
                ->withInput();
        }

        Cliente::create($req);
        toastr()->success('Cliente Creado Exitosamente');
        return redirect()->route('clientes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente_id = Hashids::decode($id)[0];
        $cliente = Cliente::find($cliente_id);
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente_id = Hashids::decode($id)[0];
        $cliente = Cliente::find($cliente_id);
        return view('clientes.edit', compact('cliente'));
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
            return redirect()->route('clientes.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $cliente_id = Hashids::decode($id)[0];
        $cliente = Cliente::find($cliente_id);

        $cliente->update($req);
        toastr()->success('Cliente Actualizado');
        return redirect()->route('clientes.index');
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
