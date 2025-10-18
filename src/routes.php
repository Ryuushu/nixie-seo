<?php

use Illuminate\Support\Facades\Route;
use Nixie\Seo\Controllers\SeoController;

Route::prefix('admin/seo')
    ->name('seo.')
    ->middleware(['web'])
    ->group(function () {
        Route::get('/', [SeoController::class, 'index'])->name('index');
        Route::get('/create', [SeoController::class, 'create'])->name('create');
        Route::post('/', [SeoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SeoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SeoController::class, 'update'])->name('update');
        Route::delete('/{id}', [SeoController::class, 'destroy'])->name('destroy');
    });