<?php
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('projects', ProjectController::class)
    ->only(['index', 'store','edit','update','destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('roles', RoleController::class)
    ->only(['index', 'store','edit','update','destroy'])
    ->middleware(['auth', 'verified']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('roles/export/', [RoleController::class, 'export'])->name('roles');
Route::get('roles/export_view/', [RoleController::class, 'export_view'])->name('roles.export_view');
Route::get('projects/export/', [ProjectController::class, 'export'])->name('projects');
Route::get('projects/export_view', [ProjectController::class, 'export_view'])->name('projects.export_view');
Route::post('projects/import',[ProjectController::class, 'import'])->name('projects.import');

Route::get('/test', function(){



    $ttr = DB::table('roles')
            ->join('projects', 'roles.id', '=', 'projects.role_id')
            ->join('users', 'roles.id', '=', 'users.role_id')
            ->get();



    $var = Role::with('projects')->get();
    $na = $var->projects;

    dd($ttr);
    // return response('hi');
});

Route::get('/t1', function (){
    
});

require __DIR__.'/auth.php';
