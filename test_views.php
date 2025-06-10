<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing view compilation...\n";

try {
    $view = view('admin.users');
    echo "admin.users: ✓ Compiled successfully\n";
} catch (Exception $e) {
    echo 'admin.users: ✗ ERROR - ' . $e->getMessage() . "\n";
}

try {
    $view = view('admin.settings');
    echo "admin.settings: ✓ Compiled successfully\n";
} catch (Exception $e) {
    echo 'admin.settings: ✗ ERROR - ' . $e->getMessage() . "\n";
}

try {
    $view = view('admin.logs');
    echo "admin.logs: ✓ Compiled successfully\n";
} catch (Exception $e) {
    echo 'admin.logs: ✗ ERROR - ' . $e->getMessage() . "\n";
}

try {
    $view = view('inventory.activity-log');
    echo "inventory.activity-log: ✓ Compiled successfully\n";
} catch (Exception $e) {
    echo 'inventory.activity-log: ✗ ERROR - ' . $e->getMessage() . "\n";
}

echo "\nAll tests completed.\n";
