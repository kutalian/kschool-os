<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Categories
        $categories = [
            ['name' => 'Staff Salaries', 'description' => 'Monthly salaries for teaching and non-teaching staff'],
            ['name' => 'Utilities', 'description' => 'Electricity, Water, and Internet bills'],
            ['name' => 'Maintenance', 'description' => 'Repairs and general upkeep of school facilities'],
            ['name' => 'Office Supplies', 'description' => 'Stationery, printing paper, and ink'],
            ['name' => 'Events & Functions', 'description' => 'Costs for school events, sports day, etc.'],
            ['name' => 'Transportation', 'description' => 'Fuel and maintenance for school buses'],
        ];

        foreach ($categories as $cat) {
            ExpenseCategory::firstOrCreate(['name' => $cat['name']], $cat);
        }

        // 2. Create Expenses (Sample Data for the last 3 months)
        $cats = ExpenseCategory::all();

        if ($cats->count() > 0) {
            // Salaries (Fixed roughly same date each month)
            for ($i = 0; $i < 3; $i++) {
                Expense::create([
                    'category_id' => $cats->where('name', 'Staff Salaries')->first()->id,
                    'amount' => rand(500000, 800000),
                    'date' => Carbon::now()->subMonths($i)->startOfMonth()->addDays(28),
                    'reference_no' => 'SAL-' . Carbon::now()->subMonths($i)->format('M-Y'),
                    'description' => 'Staff Salaries for ' . Carbon::now()->subMonths($i)->format('F Y'),
                    'incurred_by' => 'Accountant'
                ]);
            }

            // Random daily expenses
            for ($i = 0; $i < 20; $i++) {
                $randomCat = $cats->random();
                if ($randomCat->name == 'Staff Salaries')
                    continue;

                Expense::create([
                    'category_id' => $randomCat->id,
                    'amount' => rand(5000, 50000),
                    'date' => Carbon::now()->subDays(rand(1, 60)),
                    'reference_no' => 'EXP-' . strtoupper(uniqid()),
                    'description' => 'Random expense for ' . $randomCat->name,
                    'incurred_by' => 'Admin'
                ]);
            }
        }
    }
}
