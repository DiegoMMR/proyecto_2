<?php

namespace App\Http\Controllers;
use Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            //lo regresa si no esta verificada la cuenta
            if(Auth::user()->estaVerificado())
            {            
                return view('home');
            }else {
                Auth::logout();
                return view('sin-verificar');
            }
        } catch (\Exception $e) {
            toastr()->error('Algo salio mal');
            return back();
        }
    }
    public function inicio()
    {
        return view('welcome');
    }
}
