<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FG_Controller;
use App\Http\Controllers\DonationController;



// Public Routes -----------------------------------

// Update Logo
Route::post('/update-logo', [LogoController::class, 'updateLogo'])->name('update.logo');

// Show Logo
Route::get('/', [LogoController::class, 'showLogos'])->name('load.logos');

// Login Function
Route::post('/', [AuthController::class, 'login'])->name('login');


// Forum Public Routes -----------------------------------
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index')->middleware('auth');
Route::post('/forum', [ForumController::class, 'store'])->name('forum.store')->middleware('auth');
Route::get('/load-more-messages', [ForumController::class, 'loadMoreMessages'])->name('forum.loadMore');


// Registration Public Routes -----------------------------------
Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');

// Parishioner Records Public Routes -----------------------------------
Route::get('/parishioner-records', [RegistrationController::class, 'retrieve_records'])->name('parishioner.records');
Route::delete('/parishioner/delete/{id}', [RegistrationController::class, 'delete_parishioner'])->name('parishioner.destroy');
Route::get('/parishioner/edit/{id}', [RegistrationController::class, 'edit_parishioner'])->name('parishioner.edit');
Route::post('/parishioner/register', [RegistrationController::class, 'register_parish'])->name('parishioner.register');
Route::put('/parishioner/update/{id}', [RegistrationController::class, 'update_parishioner'])->name('parishioner.update');

// Folder Public Routes -----------------------------------
Route::get('/list', [FolderController::class, 'retrieve_folders'])->name('folder');
Route::post('/list/create', [FolderController::class, 'create'])->name('folder.create');
Route::post('/list/update/{id}', [FolderController::class, 'update'])->name('folder.update');
Route::delete('/list/delete/{id}', [FolderController::class, 'delete'])->name('folder.delete');
Route::get('/list/search', [FolderController::class, 'searchFolders'])->name('folder.search');

// FG_Members Public Routes -----------------------------------
Route::get('/fg-members/{folder_id}', [FG_Controller::class, 'retrieve_fg_members'])->name('fg.members');
Route::post('/fg-members/create', [FG_Controller::class, 'create'])->name('fg.members.create');
Route::put('/fg-members/update/{member}', [FG_Controller::class, 'update'])->name('fg.members.update');
Route::delete('/fg-members/{member}', [FG_Controller::class, 'destroy'])->name('fg.members.delete');

// FG_Members View_Profile Protected Routes -----------------------------------
Route::put('/fg-members/view_profile/{member}', [FG_Controller::class, 'complete_update'])->name('fg.members.complete_update');
Route::get('/fg-members/view_profile/{member}', [FG_Controller::class, 'retrieve_fg_data'])->name('fg.members.view_profile');
Route::delete('/fg-members/view_profile/{member}/{folder_id}', [FG_Controller::class, 'on_view_destroy'])->name('fg.members_onview.delete');

// Donation Public Routes -----------------------------------
Route::get('/donation', [FolderController::class, 'retrieve_folders_donation'])->name('donation');
Route::get('/donation/search', [FolderController::class, 'searchFolders'])->name('folder.search');

// Donation On_View Routes -----------------------------------
Route::get('/donation/view/{folder_id}', [DonationController::class, 'index'])->name('donation.view');
Route::get('/get-members/{folderId}/{year}', [DonationController::class, 'getMembers']);
Route::post('/donations/save', [DonationController::class, 'saveDonation']);
Route::get('/get-years', [DonationController::class, 'getYears']);


// Profile Settings Public Routes -----------------------------------
Route::get('/profile-settings', [AuthController::class, 'profile_settings'])->name('profile.settings');


// Protected Routes (Requires Authentication) -----------------------------------
Route::middleware(['auth'])->group(function () {

    // Menu Page
    Route::get('/home', function () {
        return view('pages.home');
    })->name('home');

    // Change Password
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password');
});

// Logout Session -----------------------------------
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); // Redirect to login or home page
})->name('logout');