<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/services', 'services')->name('services');
    Route::get('/services/{slug}', 'serviceShow')->name('services.show');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactStore')->name('contact.store');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog/{slug}', 'blogShow')->name('blog.show');
    Route::get('/knowledge', 'knowledge')->name('knowledge');
    Route::get('/knowledge/{slug}', 'knowledgeShow')->name('knowledge.show');
    Route::post('/ai/chat', 'chat')->name('ai.chat');
});
