<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $safeInsertUser = function(array $data) {
            $table = (new User())->getTable();

            if (isset($data['email']) && User::where('email', $data['email'])->exists()) {
                return null;
            }

            $filteredData = [];
            foreach ($data as $column => $value) {
                if (Schema::hasColumn($table, $column)) {
                    $filteredData[$column] = $value;
                }
            }

            return User::create($filteredData);
        };

        $safeInsertPatient = function(array $data) {
            $table = (new Patient())->getTable();

            if (isset($data['email']) && Patient::where('email', $data['email'])->exists()) {
                return null;
            }

            $filteredData = [];
            foreach ($data as $column => $value) {
                if (Schema::hasColumn($table, $column)) {
                    $filteredData[$column] = $value;
                }
            }

            if (isset($filteredData['password'])) {
                $filteredData['password'] = Hash::make($filteredData['password']);
            }

            return Patient::create($filteredData);
        };

        // Seed patient
        $safeInsertPatient([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'patient01',
            'email' => 'patient@example.com',
            'password' => 'Patient123',
            'phone' => '09171234567',
            'emergency_contact' => '09170000000',
            'address' => '123 Test Street, Manila',
            'date_of_birth' => '1995-01-01',
            'gender' => 'male',
            'medical_history' => 'None',
            'dental_concerns' => 'Routine checkup',
        ]);

        // Seed staff
        $safeInsertUser([
            'name' => 'Staff 1',
            'email' => 'staff@example.com',
            'username' => 'staff01',
            'password' => Hash::make('Staff123'),
            'role' => 'staff',
            'phone' => '09172345678',
            'address' => '456 Staff Lane, Manila',
            'date_of_birth' => '1990-05-20',
        ]);

        // Seed admin
        $safeInsertUser([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'username' => 'admin01',
            'password' => Hash::make('Admin123'),
            'role' => 'dentist',
            'phone' => '09173456789',
            'address' => '789 Admin Ave, Manila',
            'date_of_birth' => '1985-01-01',
        ]);
    }
}
