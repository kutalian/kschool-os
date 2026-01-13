<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\TransportRoute;

class TransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Vehicles
        $bus1 = Vehicle::create([
            'vehicle_number' => 'KA-01-SB-1001',
            'capacity' => 40,
            'driver_name' => 'Ramesh Gupta',
            'driver_license' => 'DL-KA01-2010001234',
            'driver_phone' => '9876543210',
            'status' => 'active',
        ]);

        $bus2 = Vehicle::create([
            'vehicle_number' => 'KA-01-SB-1002',
            'capacity' => 40,
            'driver_name' => 'Suresh Kumar',
            'driver_license' => 'DL-KA01-2012005678',
            'driver_phone' => '9876543211',
            'status' => 'active',
        ]);

        $van1 = Vehicle::create([
            'vehicle_number' => 'KA-05-MV-2022',
            'capacity' => 12,
            'driver_name' => 'John Doe',
            'driver_license' => 'DL-KA05-2015009012',
            'driver_phone' => '9876543222',
            'status' => 'maintenance',
        ]);

        // 2. Create Routes
        TransportRoute::create([
            'route_name' => 'Route 1 - North City',
            'start_point' => 'Central Station',
            'end_point' => 'North Academy Campus',
            'fare' => 1500.00,
            'vehicle_id' => $bus1->id,
        ]);

        TransportRoute::create([
            'route_name' => 'Route 2 - South Extension',
            'start_point' => 'City Market',
            'end_point' => 'South Tech Park',
            'fare' => 1800.00,
            'vehicle_id' => $bus2->id,
        ]);

        TransportRoute::create([
            'route_name' => 'Route 3 - Downtown Shuttle',
            'start_point' => 'Metro Terminal',
            'end_point' => 'Main Gate',
            'fare' => 800.00,
            'vehicle_id' => null, // Unassigned
        ]);

        TransportRoute::create([
            'route_name' => 'Route 4 - West Suburbs',
            'start_point' => 'West Mall',
            'end_point' => 'West Campus',
            'fare' => 2000.00,
            'vehicle_id' => null,
        ]);
    }
}
