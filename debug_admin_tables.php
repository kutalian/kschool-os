<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = ['phone_call_logs', 'visitors', 'admission_enquiries', 'postal_records'];

foreach ($tables as $table) {
    echo "Columns in $table:\n";
    if (Illuminate\Support\Facades\Schema::hasTable($table)) {
        print_r(Illuminate\Support\Facades\Schema::getColumnListing($table));
    } else {
        echo "Table does not exist.\n";
    }
    echo "-------------------\n";
}
