<?php
use Illuminate\Support\Facades\Schema;

echo "Check if 'paid' exists in student_fees:\n";
$cols = Schema::getColumnListing('student_fees');
if (in_array('paid', $cols)) {
    echo "SUCCESS: 'paid' column found.\n";
} else {
    echo "FAILURE: 'paid' column NOT found.\n";
    print_r($cols);
}

try {
    echo "Starting query with 'paid'...\n";
    $query = App\Models\StudentFee::query();
    $stats = (clone $query)->selectRaw('
        SUM(amount) as total_expected, 
        SUM(paid) as total_collected
    ')->first();
    echo "Result:\n";
    print_r($stats);
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
