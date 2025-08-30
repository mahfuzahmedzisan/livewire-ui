<?php

use App\Livewire\Frontend\Pages\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
