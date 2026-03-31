<?php

namespace Database\Seeders;

use App\Models\EmployeeRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Filip Kovac',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $sarah = User::factory()->create([
            'name' => 'Sarah Mendes',
            'email' => 'employee@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $tom = User::factory()->create([
            'name' => 'Tom Bright',
            'email' => 'tom@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        EmployeeRequest::create([
            'created_by' => $sarah->id,
            'title' => 'Leave - 14 to 18 April',
            'description' => 'Taking the week off, family visiting from abroad.',
            'type' => 'leave',
            'status' => 'pending',
        ]);

        EmployeeRequest::create([
            'created_by' => $sarah->id,
            'title' => 'Flight reimbursement - March trip',
            'description' => 'Return flight to Dublin for the client meeting on the 12th. Receipt attached separately.',
            'type' => 'reimbursement',
            'status' => 'approved',
        ]);

        EmployeeRequest::create([
            'created_by' => $tom->id,
            'title' => 'Extra monitor for home setup',
            'description' => 'Need a second screen, been working off laptop only which is slowing me down.',
            'type' => 'other',
            'status' => 'pending',
        ]);
    }
}
