<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            [
                'name'      => 'Lauretta McClure', 'email' =>'shanie.gorczany@example.com', 'phone' =>'566666666', 'password'  => bcrypt('password'),
                'latitude' => 24.69023, 'longitude' => 46.685, 'address' => 'address', 'type'      => 'client',
            ],
            [
                'name'      => 'Kristian Beatty', 'email' =>'brandyn50@example.org', 'phone' =>'577777777', 'password'  => bcrypt('password'), 'latitude' => 24.69023,
                'longitude' => 46.685, 'address' => 'address', 'type'      => 'driver',
            ],
            [
                'name'      => 'Ms. Raquel Borer Sr.', 'email' =>'hhudson@example.org', 'phone' =>'588888888', 'password'  => bcrypt('password'), 'latitude' => 24.69022,
                'longitude' => 46.684, 'address' => 'address', 'type'      => 'driver',
            ],
            [
                'name'      => 'Jordane Schroeder', 'email' =>'alden.rutherford@example.com', 'phone' =>'584444444', 'password'  => bcrypt('password'),
                'latitude' => 24.69018, 'longitude' => 46.680, 'address' => 'address', 'type'      => 'driver',
            ],
            [
                'name'      => 'Dr. Lemuel Jacobson', 'email' =>'norval23@example.net', 'phone' =>'599999999', 'password'  => bcrypt('password'), 'latitude' => 24.69021,
                'longitude' => 46.683, 'address' => 'address', 'type'      => 'driver',
            ],
            [
                'name'      => 'Kiel Volkman', 'email' =>'ynolan@example.net', 'phone' =>'5111111110', 'password'  => bcrypt('password'), 'latitude' => 24.69020, 'longitude' => 46.682,
                'address' => 'address', 'type'      => 'driver',
            ],
            [
                'name'      => 'Cortney Wolf', 'email' =>'jast.lillian@example.org', 'phone' =>'563333333', 'password'  => bcrypt('password'), 'latitude' => 24.69019,
                'longitude' => 46.681, 'address' => 'address', 'type'      => 'driver',
            ],

        ];

        User::insert($users);
    }
}
