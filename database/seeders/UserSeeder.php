<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\Users\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->is_admin = true;
        $user->name = 'Admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('admin0808');
        $user->save();

        $user = new User();
        $user->is_admin = false;
        $user->name = 'Operator1';
        $user->email = 'operator1@operator.com';
        $user->password = bcrypt('123456789');
        $user->save();

        $user = new User();
        $user->is_admin = false;
        $user->name = 'Operator2';
        $user->email = 'operator2@operator.com';
        $user->password = bcrypt('987654321');
        $user->save();
    }
}
