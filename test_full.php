<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$errors = []; $ok = 0;

function chk($label, $fn) {
    global $errors, $ok;
    try { $fn(); echo "OK  $label\n"; $ok++; }
    catch (Throwable $e) { echo "ERR $label => " . $e->getMessage() . "\n"; $errors[] = $label; }
}

// Tables
chk('users',      function(){ \App\Models\User::count(); });
chk('books',      function(){ \App\Models\Book::count(); });
chk('borrows',    function(){ \App\Models\Borrow::count(); });
chk('reviews',    function(){ \App\Models\Review::count(); });
chk('categories', function(){ \App\Models\Category::count(); });

// Borrow columns
chk('col borrows.status',      function(){ if(!\Illuminate\Support\Facades\Schema::hasColumn('borrows','status')) throw new Exception('missing'); });
chk('col borrows.catatan',     function(){ if(!\Illuminate\Support\Facades\Schema::hasColumn('borrows','catatan')) throw new Exception('missing'); });
chk('col borrows.approved_by', function(){ if(!\Illuminate\Support\Facades\Schema::hasColumn('borrows','approved_by')) throw new Exception('missing'); });
chk('col borrows.return_date', function(){ if(!\Illuminate\Support\Facades\Schema::hasColumn('borrows','return_date')) throw new Exception('missing'); });

// Borrow model
chk('Borrow statusLabel', function(){ $b = new \App\Models\Borrow(); $b->status='menunggu'; $b->statusLabel(); });
chk('Borrow statusColor', function(){ $b = new \App\Models\Borrow(); $b->status='dipinjam'; $b->statusColor(); });

// Routes
$routes = [
    'dashboard','login','logout',
    'books.catalog','books.show','books.borrow','books.borrow.store',
    'books.reviews.index','books.reviews.store','books.reviews.edit','books.reviews.update','books.reviews.destroy',
    'user.borrows','borrows.request.return','borrows.print',
    'user.reviews.index',
    'admin.dashboard','admin.books','admin.books.store','admin.books.destroy',
    'admin.categories','admin.categories.store','admin.categories.destroy',
    'admin.borrows','admin.borrows.approve','admin.borrows.reject','admin.borrows.confirm.return',
    'admin.users','admin.staff','admin.staff.store','admin.staff.destroy','admin.reviews',
    'admin.reports.books','admin.reports.users','admin.reports.borrows','admin.reports.staff',
    'petugas.dashboard','petugas.books','petugas.borrows',
    'petugas.borrows.approve','petugas.borrows.reject','petugas.borrows.confirm.return',
    'petugas.reports.books','petugas.reports.borrows',
];
$params = ['book'=>1,'review'=>1,'borrow'=>1,'user'=>1,'category'=>1,'jenis'=>'fiksi'];
foreach ($routes as $r) {
    chk("route $r", function() use ($r, $params){ route($r, $params); });
}

// Views
$views = [
    'dashboard','user.borrows','user.borrow-create','user.borrow-print','user.reviews.index',
    'books.show','books.reviews','books.reviews-edit','books.catalog',
    'admin.dashboard','admin.books','admin.categories','admin.borrows',
    'admin.users','admin.staff','admin.reviews',
    'admin.reports.books','admin.reports.users','admin.reports.borrows','admin.reports.staff',
    'petugas.dashboard','petugas.books','petugas.borrows',
    'petugas.reports.books','petugas.reports.borrows',
    'auth.login','auth.register',
    'layouts.admin','layouts.petugas',
];
foreach ($views as $v) {
    chk("view $v", function() use ($v){ if(!view()->exists($v)) throw new Exception("not found"); });
}

echo "\n=== $ok OK, ".count($errors)." GAGAL ===\n";
if ($errors) { echo "ERRORS:\n"; foreach($errors as $e) echo "  - $e\n"; }
