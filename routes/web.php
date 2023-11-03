<?php

use Illuminate\Support\Facades\Route;

//ADMIN
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PageController as AdminPageController;

//GUEST
use App\Http\Controllers\Guest\PageController as GuestPageController;

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

Route::get('/', [GuestPageController::class, 'index'])->name('guest.home');


Route::middleware(['auth', 'verified'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/', [AdminPageController::class, 'index'])->name('home');

    //Route soft delete
    Route::get('projects/trash', [ProjectController::class, 'trash'])->name('projects.trash.index');
    Route::patch('projects/trash/{project}/restore', [ProjectController::class, 'restore'])->name('projects.trash.restore');
    Route::delete('projects/trash/{project}', [ProjectController::class, 'forceDestroy'])->name('projects.trash.force-destroy');
    Route::delete('projects/{project}/delete-image', [ProjectController::class, 'deleteImage'])->name('projects.delete-image');

    //Nel url stampo lo slug al posto dell'Id
    Route::resource('projects', ProjectController::class)->parameters(['projects' => 'project:slug']);

  });

require __DIR__ . '/auth.php';