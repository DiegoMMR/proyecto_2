<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $admin;

    public function run()
    {
        DB::table('users')->delete();
        $this->crear_roles();
        $this->genUsr();
    }

    private function crear_roles(){
    
        Defender::createRole('administrador');
        Defender::createRole('empleado');
        Defender::createRole('cliente');

    }


    private function genUsr(){
        $devPwd = 'UFwmEM29281123wM9prd';

        User::create(array(
            'name'     => 'Administrator',
            'email'    => 'iam@admin.com',
            'password' => Hash::make($devPwd),
            'verified'   => 1,
        ));


        $this->command->info('User created');

        $this->admin = 'administrador';

        $administrador = Defender::findRole($this->admin);
        $user = User::find(1);
        $user->attachRole($administrador);
    }

}
