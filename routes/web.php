<?php

use MediaWebId\OurWorks\Http\Controllers\Backend\OurWorksController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth.admin'])->prefix('backend')->group(function () {

    // ourworks
    Route::post('/ourwork/{ourwork}/delete', [OurWorksController::class, 'delete'])->name('ourwork.delete')->middleware('admin_permission:Delete Our Works');
    Route::get('/ourwork/{ourwork}/edit', [OurWorksController::class, 'edit'])->name('ourwork.edit')->middleware('admin_permission:Edit Our Works');
    Route::get('/ourwork', [OurWorksController::class, 'index'])->name('ourwork.index')->middleware('admin_permission:View Our Works');
    Route::get('/ourwork/page', [OurWorksController::class, 'getPage'])->name('ourwork.page')->middleware('admin_permission:View Our Works');
    Route::get('/ourwork/create', [OurWorksController::class, 'create'])->name('ourwork.create')->middleware('admin_permission:Create Our Works');
    Route::post('/ourwork', [OurWorksController::class, 'store'])->name('ourwork.store')->middleware('admin_permission:Create Our Works');
});
