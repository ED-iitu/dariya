<?php

use App\User;
use Illuminate\Database\Seeder;
use Kodeine\Acl\Models\Eloquent\Role;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = new Role();
        $roleAdmin->name = 'Administrator';
        $roleAdmin->slug = 'admin';
        $roleAdmin->description = 'manage administration privileges';
        $roleAdmin->save();

        $user = User::query()->find(1);
        if($user){
            $user->assignRole($roleAdmin);
        }
    }
}
