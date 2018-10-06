<?php

namespace App\Http\Controllers;
use App\User;
use Hashids;
use Artesaos\Defender\Role;
use App\Cliente;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $users = User::with('roles')->paginate(15);
            return view('user.index', compact('users'));
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
            $user_id = Hashids::decode($id)[0];
            $user = User::find($user_id);
            return view('user.show', compact('user'));
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
            $user_id = Hashids::decode($id)[0];
            $user = User::where('id', $user_id)->with('roles')->first();

            $user->role = $user->roles[0]->id;
            $roles = Role::pluck('name', 'id')->all();
            return view('auth.edit', compact('user', 'roles'));
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
        try {
            \DB::beginTransaction();
            $req = $request->all();
            $user_id = Hashids::decode($id)[0];
            $user = User::with('roles')->find($user_id);

            $validator = Validator::make($req, [
                'name' => 'required|string|max:255',
                'email' => 'required|unique:users,email,'.$user->id
                ]);
                
            if ($validator->fails()) {
                return back()
                ->withErrors($validator)
                ->withInput();
            }        

            $user->update($req);

            if ($req['role'] == 3) {//cliente
                $cliente = Cliente::where('email',  $req['email'])->count();
                if($cliente){ 
                    $cliente_id = Cliente::where('email',  $req['email'])->first()->id;
                } else {
                    \DB::rollback();
                    toastr()->error('Cliente No encontrado');
                    return back()->withInput();
                }
            } else {
                $cliente_id = null;
            }

            //quitar rol actual
            $role = \Defender::findRoleById($user->roles[0]->id);
            $user->detachRole($role);

            //poner nuevo
            $role = \Defender::findRoleById($req['role']);
            $user->attachRole($role);

            \DB::commit();
            toastr()->success('Usuario Actualizado');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            \DB::rollback();
            toastr()->error('Algo salio mal');
            return back()->withInput();
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
