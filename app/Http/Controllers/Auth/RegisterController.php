<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\SendVerificationEmail;
use Artesaos\Defender\Role;
use App\Cliente;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showRegistrationForm()
    {
        $roles = Role::pluck('name', 'id')->all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {         
        
        if ($data['role'] == 3) {//cliente
            $cliente = Cliente::where('email',  $data['email'])->count();
            if($cliente){ 
                $cliente_id = Cliente::where('email',  $data['email'])->first()->id;
            } else {
                return 'Cliente No encontrado';    
            }
        } else {
            $cliente_id = null;
        }

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'cliente_id' => $cliente_id,
            'password' => Hash::make($data['password']),
            'email_token' => base64_encode($data['email']),
        ]);
        
        $user->save();
        
        $role = \Defender::findRoleById($data['role']);
        $user->attachRole($role);

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $req = $request->all();
        $validator = Validator::make($req, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            ]);
            
        if ($validator->fails()) {
            return back()
            ->withErrors($validator)
            ->withInput();
        }

        //crea un a contraseña random
        $req['password'] = str_random(13);
        $user = $this->create($req);
        if ($user == 'Cliente No encontrado') {
            toastr()->error('Cliente No encontrado');
            return back()->withInput();
        }else {
            event(new Registered($user));
        }

        dispatch(new SendVerificationEmail($user, $req['password']));

        toastr()->success('Usuario Creado Exitosamente');
        return redirect()->route('users.index');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        $user = User::where('email_token', $token)->first();
        $user->verified = 1;

        if($user->save()){
            return view('emailconfirm', ['user' => $user]);
        }
    }
}
