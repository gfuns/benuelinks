<?php
namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'first_name' => 'Solomon',
                'last_name'  => 'Adagba',
                'email'      => 'solomonadagba@gmail.com',
                'password'   => Hash::make("12244190"),
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($data as $inv) {
            Agent::updateOrCreate($inv);
        }
    }
}
