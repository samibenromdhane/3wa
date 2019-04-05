<?php

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

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['access'])->group(function () {
	Route::post('/add', 'ClassroomController@handleAddClassroom')->name('handleAddClassroom');
	Route::get('/delete/{id}', 'ClassroomController@handleDeleteClassroom')->name('handleDeleteClassroom');
	Route::get('/classrooms','ClassroomController@showClassrooms')->name('showClassrooms');
	Route::get('/classroom/{id}','ClassroomController@showClassroom')->name('showClassroom');
	Route::post('/edit/{id}','ClassroomController@handleEditClassroom')->name('handleEditClassroom');
	Route::get('/user/register','ClassroomController@showRegister')->name('showRegister');
	Route::post('/user/register','ClassroomController@handleRegister')->name('handleRegister');
	Route::get('/user/logout','ClassroomController@handleLogout')->name('handleLogout');
	Route::get('/students/{id}','ClassroomController@showStudents')->name('showStudents');
	Route::get('/students/delete/{id}','ClassroomController@handleDeleteStudent')->name('handleDeleteStudent');
	Route::get('/students/show/{id}','ClassroomController@showEditStudent')->name('showEditStudent');
	Route::post('/students/edit/{id}','ClassroomController@handleEditStudent')->name('handleEditStudent');
});

Route::get('/user/login','ClassroomController@showLogin')->name('showLogin');
Route::post('/user/login','ClassroomController@handleLogin')->name('handleLogin');