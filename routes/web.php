<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Barryvdh\Debugbar\Facades\Debugbar;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
    GET - Reqeust a resource
    POST - Create a new resource
    PUT - Update a resource
    PATCH - Modify a resource
    DELETE - Delete a resource
    OPTIONS - Ask the server which verbs are allowed
*/

// Route::get('/', function () {
//     // try {
//     //     throw new Exception('Try Message!');
//     // } catch (\Exception $e) {
//     //     Debugbar::addException($e);
//     // }
//     // Debugbar::startMeasure('Wohoo', 'Rendering of out first message');

//     // $name = "Code with Adnan";

//     // dd(config('services.mailgun.domain'));

//     // dd(env('APP_NAME'));

//     return view('welcome');
// });

// Route for invoke method
// Route::get('/', HomeController::class);
Route::get('/', [PostController::class, 'index'])->name('blog.index');

// Route Resource
// Route::resource('blog', PostController::class);


Route::prefix('/blog')->group(function () {
    // GET
    Route::get('/create', [PostController::class, 'create'])->name('blog.create');
    Route::get('/{id}', [PostController::class, 'show'])->name('blog.show');
    // ->whereNumber('id');
    // ->where([
    //     'id' => '[0-9]+',
    //     'name' => '[A-Za-z]+'
    // ]);

    // POST
    Route::post('/store', [PostController::class, 'store'])->name('blog.store');

    // PUT OR PATCH
    Route::get('/edit/{id}', [PostController::class, 'edit'])->name('blog.edit');
    Route::patch('/{id}', [PostController::class, 'update'])->name('blog.update');

    // DELETE
    Route::delete('/destroy/{id}', [PostController::class, 'destroy'])->name('blog.destroy');
});

// Multiple HTTP verbs
Route::match(['GET', 'POST'], '/blog', [PostController::class, 'index']);
// Route::any('/blog', [PostController::class, 'index']);

// Return view
// Route::view('/blog', 'blog.index', ['name' => 'Code with Adnan']);

// Fallback Route
Route::fallback(FallbackController::class);
