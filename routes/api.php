<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\GatewayOneController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\AboutPageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/sliders', [SliderController::class, 'ApiAllSlider']);
Route::get('/services', [ServiceController::class, 'AllServices']);
Route::get('/service/{slug}', [ServiceController::class, 'getServiceBySlug']);
Route::get('/gatewayone', [GatewayOneController::class, 'ApiGatewayOne']);
Route::get('/gatewaytwo', [GatewayOneController::class, 'ApiGatewayTwo']);
Route::get('/testimonial', [TestimonialController::class, 'ApiGetTestimonial']);
Route::get('/blogcat', [BlogController::class, 'ApiBlogCat']);
Route::get('/blog', [BlogController::class, 'ApiAllBlog']);
Route::get('/blog/{slug}', [BlogController::class, 'ApiAllBlogSlug']);
Route::get('/blog/{slug}', [BlogController::class, 'ApiAllBlogSlug']);
Route::get('/category/{category_id}/blogs', [BlogController::class, 'getBlogsByCategory']);
Route::get('/sitesetting', [SettingController::class, 'ApiSiteSetting']);
Route::get('/about', [AboutPageController::class, 'ApiAboutPage']);
