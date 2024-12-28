<?php

use App\Http\Controllers\FeedController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Post\InteractController;
use App\Http\Controllers\Post\ViewController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Startup\ListStartupController;
use App\Http\Controllers\Startup\ManageStartupController;
use App\Http\Controllers\Startup\NewStartupController;
use App\Http\Controllers\Startup\ViewStartupController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\Messages\ListMessagesController;
use App\Http\Controllers\User\Messages\SendMessageController;
use App\Http\Controllers\User\Messages\ViewMessageController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\Startup\Manage\ManageController;
use App\Http\Controllers\User\Startup\NewController;
use App\Http\Middleware\EnsureLoggedIn;
use App\Http\Middleware\EnsureLoggedOut;
use App\Http\Requests\Startup\CreateNewStartupRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(EnsureLoggedOut::class)->name('home');

Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware(EnsureLoggedOut::class);
Route::post('/register', [RegisterController::class, 'register'])->name('register::register')->middleware(EnsureLoggedOut::class);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware(EnsureLoggedOut::class);
Route::post('/login', [LoginController::class, 'login'])->name('login::login')->middleware(EnsureLoggedOut::class);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard')->middleware(EnsureLoggedIn::class);
Route::post('/user/dashboard/update-bio', [DashboardController::class, 'updateBio'])->name('user.dashboard::updateBio')->middleware(EnsureLoggedIn::class);
Route::post('/user/dashboard/make-post', [DashboardController::class, 'makePost'])->name('user.dashboard::makePost')->middleware(EnsureLoggedIn::class);

Route::get('/user/dashboard/share/{post}', [DashboardController::class, 'share'])->name('user.dashboard.share')->middleware(EnsureLoggedIn::class);
Route::post('/user/dashboard/share/{post}', [DashboardController::class, 'sharePost'])->name('user.dashboard.share::sharePost')->middleware(EnsureLoggedIn::class);


Route::get('/user/profile/{username}', [ProfileController::class, 'index'])->name('user.profile');
Route::get('/user/messages/send/{username}', [SendMessageController::class, 'index'])->name('user.messages.send')->middleware(EnsureLoggedIn::class);
;
Route::get('/user/messages/list/{show?}', [ListMessagesController::class, 'index'])->name('user.messages.list')->middleware(EnsureLoggedIn::class);
;
Route::post('/user/messages/send/{username}', [SendMessageController::class, 'send'])->name('user.messages.send::send')->middleware(EnsureLoggedIn::class);
;
Route::get('/user/messages/view/{id}', [ViewMessageController::class, 'index'])->name('user.messages.view')->middleware(EnsureLoggedIn::class);
;

Route::get('/user/settings', [SettingsController::class, 'index'])->name('user.settings')->middleware(EnsureLoggedIn::class);
Route::post('/user/settings/update/picture', [SettingsController::class, 'updatePicture'])->name('user.settings::updatePicture')->middleware(EnsureLoggedIn::class);


Route::get('/startup/new', [NewStartupController::class, 'index'])->name('startup.new')->middleware(EnsureLoggedIn::class);
Route::post('/startup/new', [NewStartupController::class, 'create'])->name('startup.new::create')->middleware(EnsureLoggedIn::class);
Route::get('/startup/view/{id}', [ViewStartupController::class, 'index'])->name('startup.view');
Route::post('/startup/view/{id}/set-primary-startup', [ViewStartupController::class, 'setPrimaryStartup'])->name('startup.view::setPrimaryStartup')->middleware(EnsureLoggedIn::class);
Route::post('/startup/view/{id}/send-join-request', [ViewStartupController::class, 'sendJoinRequest'])->name('startup.view::sendJoinRequest')->middleware(EnsureLoggedIn::class);
Route::get('/startup/manage/{id}', [ManageStartupController::class, 'index'])->name('startup.manage')->middleware(EnsureLoggedIn::class);
Route::post('/startup/{startupId}/manage/request/{requestId}/accept', [ManageStartupController::class, 'acceptRequest'])->name('startup.manage::acceptRequest');
Route::post('/startup/{startupId}/manage/request/{requestId}/deny', [ManageStartupController::class, 'denyRequest'])->name('startup.manage::denyRequest');

Route::get('/startup/list', [ListStartupController::class, 'index'])->name('startup.list')->middleware(EnsureLoggedIn::class);


Route::get('/post/view/{id}', [ViewController::class, 'index'])->name('post.view');
Route::post('/post/interact/{id}/comment', [InteractController::class, 'comment'])->name('post.interact::comment')->middleware(EnsureLoggedIn::class);
Route::post('/post/interact/{id}/like', [InteractController::class, 'like'])->name('post.interact::like')->middleware(EnsureLoggedIn::class);

Route::get('/feed', [FeedController::class, 'index'])->name('feed');
Route::get('/search', [SearchController::class, 'index'])->name('search');

