<?php

namespace Database\Seeders;

use App\Models\EmployeeRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Filip Kovac',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        $sarah = User::firstOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name' => 'Sarah Mendes',
                'password' => bcrypt('password'),
                'is_admin' => false,
            ]
        );

        $tom = User::firstOrCreate(
            ['email' => 'tom@example.com'],
            [
                'name' => 'Tom Bright',
                'password' => bcrypt('password'),
                'is_admin' => false,
            ]
        );

        if (EmployeeRequest::count() === 0) {
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
}
