<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Hexafume Home
|--------------------------------------------------------------------------
*/
Route::get("/", [ProjectController::class, "homePage"])->name("home");

Route::get("/about", [ProjectController::class, "aboutPage"])->name("about");

Route::get("/services", [ProjectController::class, "servicesPage"])->name("services");

Route::get("/process", [ProjectController::class, "processPage"])->name("process");

Route::get("/work", [ProjectController::class, "index"])->name("work");

Route::get("/team", [TeamMemberController::class, "teamPage"])->name("team");

Route::get("/team-member/{slug?}", [TeamMemberController::class, "memberPage"])->name("team-member");

Route::get("/contact", [ProjectController::class, "contactPage"])->name("contact");

Route::get("/project/{slug}", [ProjectController::class, "show"])->name("project-detail");

/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', function () {
        return view('admin.login');
    })->name('login');

    Route::get('/', [ProjectController::class, 'adminDashboard'])->name('dashboard');

    Route::get('/projects', [ProjectController::class, 'adminIndex'])->name('projects.index');

    Route::get('/projects/create', [ProjectController::class, 'adminCreate'])->name('projects.create');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'adminEdit'])->name('projects.edit');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::get('/team-members/create', [TeamMemberController::class, 'create'])->name('team-members.create');
    Route::get('/team-members/{teamMember}/edit', [TeamMemberController::class, 'edit'])->name('team-members.edit');
    Route::get('/team', [TeamMemberController::class, 'index'])->name('team.index');
    Route::post('/team', [TeamMemberController::class, 'store'])->name('team.store');
    Route::put('/team/{teamMember}', [TeamMemberController::class, 'update'])->name('team.update');
    Route::delete('/team/{teamMember}', [TeamMemberController::class, 'destroy'])->name('team.destroy');

    Route::get('/messages', [EmailController::class, 'adminIndex'])->name('messages.index');
    Route::get('/messages/{email}', [EmailController::class, 'adminShow'])->name('messages.show');
    Route::post('/messages/{email}/reply', [EmailController::class, 'adminReply'])->name('messages.reply');
    Route::delete('/messages/{email}', [EmailController::class, 'adminDestroy'])->name('messages.destroy');

    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/{slug}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::match(['PUT', 'POST'], '/pages/{slug}', [PageController::class, 'update'])->name('pages.update');
});


/*
|--------------------------------------------------------------------------
| Contact Form (Hexafume frontend → backend email send)
|--------------------------------------------------------------------------
*/
Route::post("/contact", [ContactController::class, "send"])->name(
    "contact.send",
);

/*
|--------------------------------------------------------------------------
| Email Management Routes
|--------------------------------------------------------------------------
*/
Route::get("/email/compose", [EmailController::class, "compose"])->name(
    "email.compose",
);
Route::post("/email/send", [EmailController::class, "send"])->name(
    "email.send",
);
Route::get("/email/inbox", [EmailController::class, "index"])->name(
    "email.index",
);
Route::get("/email/{email}", [EmailController::class, "show"])->name(
    "email.show",
);
Route::delete("/email/{email}", [EmailController::class, "destroy"])->name(
    "email.destroy",
);

/*
|--------------------------------------------------------------------------
| Project Management
|--------------------------------------------------------------------------
*/
Route::post("/admin/projects", [ProjectController::class, "store"])->name("admin.projects.store");
Route::put("/admin/projects/{project}", [ProjectController::class, "update"])->name("admin.projects.update");
