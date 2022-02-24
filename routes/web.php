<?php
  
use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\UserController;
use App\Events\handler;
use App\Models\message;
use App\Models\groupchat;
use App\Events\ghandler;

/*LOGIN & REGISTRATION*/
  
Route::get('/', [UserController::class, 'index'])->name('login');
Route::get('message/{id}', [UserController::class, 'message']);
Route::post('post-login', [UserController::class, 'postLogin'])->name('login.post'); 
Route::get('sign-up', [UserController::class, 'registration'])->name('register');
Route::post('post-registration', [UserController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [UserController::class, 'dashboard']); 
Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::get('change-password', [UserController::class, 'change']);
Route::post('change-password', [UserController::class, 'changePassword'])->name('change.password');
Route::post('upload', [UserController::class, 'upload'])->name('upload');
Route::post('update', [UserController::class, 'update'])->name('update');
Route::post('add-contact', [UserController::class, 'addContact'])->name('add.contact');
Route::get('/search', [UserController::class, 'search'])->name('this.search');
Route::get('/autocomplete-search-query', [UserController::class, 'query'])->name('autocomplete.search.query');
Route::get('/settings',[UserController::class, "settings"])->name('settings');
Route::get('/home',[UserController::class, "home"]);
Route::get('/select/{id}',[UserController::class, "select"]);
Route::get('/group/{id}',[UserController::class, "gselect"]);
Route::post('/chat', [UserController::class, "chat"]);
Route::post('/file', function (){
    $name = request()->file->getClientOriginalName();
    request()->file->storeAs('public/docs', $name);
    return "<img src=/storage/docs/".$name.">";
});
Route::get('msgdel/{id}', [UserController::class, "msgdel"]);
Route::view('/test', 'test');
Route::get('typing/{id}', [UserController::class, "typing"]);
Route::get('notyping/{id}', [UserController::class, "notyping"]);




