<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Test route to verify routing
Route::get('/test', function () {
    return 'test route working';
});



use App\Http\Controllers\DashboardController;
// Home page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('index');
})->name('home');



use App\Http\Controllers\NationalProductivityController;
use App\Http\Controllers\CommunityModelVillageController;
use App\Http\Controllers\CitizenMirrorController;
use App\Http\Controllers\ProYouthController;
use App\Http\Controllers\FiveSController;
use App\Http\Controllers\CertificationCourseController;
use App\Http\Controllers\TrainingProgramController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Session-based auth)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // National Productivity Competition (Criteria Program)
    Route::resource('npc', NationalProductivityController::class);
    Route::get('npc/{npc}/report', [NationalProductivityController::class, 'report'])->name('npc.report');
    // Download NPC report as PDF
    Route::get('/npc/{id}/report/download', [NationalProductivityController::class, 'downloadReport'])->name('npc.report.download');

    // Community Model Village Program
    Route::resource('cmv', CommunityModelVillageController::class);

    // Citizen Mirror
    Route::resource('citizen-mirror', CitizenMirrorController::class);

    // ProYouth Program
    Route::get('proyouth', [ProYouthController::class, 'index'])->name('proyouth.index');
    Route::get('4i', [App\Http\Controllers\FourIController::class, 'index'])->name('fouri.index');
    // Video entries
    Route::get('proyouth/video/create', [ProYouthController::class, 'createVideo'])->name('proyouth.video.create');
    Route::post('proyouth/video', [ProYouthController::class, 'storeVideo'])->name('proyouth.video.store');
    Route::get('proyouth/video/{id}/edit', [ProYouthController::class, 'editVideo'])->name('proyouth.video.edit');
    Route::put('proyouth/video/{id}', [ProYouthController::class, 'updateVideo'])->name('proyouth.video.update');
    Route::delete('proyouth/video/{id}', [ProYouthController::class, 'destroyVideo'])->name('proyouth.video.destroy');
    // Proposal entries
    Route::get('proyouth/proposal/create', [ProYouthController::class, 'createProposal'])->name('proyouth.proposal.create');
    Route::post('proyouth/proposal', [ProYouthController::class, 'storeProposal'])->name('proyouth.proposal.store');
    Route::get('proyouth/proposal/{id}/edit', [ProYouthController::class, 'editProposal'])->name('proyouth.proposal.edit');
    Route::put('proyouth/proposal/{id}', [ProYouthController::class, 'updateProposal'])->name('proyouth.proposal.update');
    Route::delete('proyouth/proposal/{id}', [ProYouthController::class, 'destroyProposal'])->name('proyouth.proposal.destroy');
    // Selection, Marks & Winners
    Route::get('proyouth/selected', [ProYouthController::class, 'selectedList'])->name('proyouth.selected');
    Route::get('proyouth/marks/{type}/{id}', [ProYouthController::class, 'editMarks'])->name('proyouth.marks.edit');
    Route::post('proyouth/marks/{type}/{id}', [ProYouthController::class, 'updateMarks'])->name('proyouth.marks.update');
    Route::post('proyouth/winner/{type}/{id}', [ProYouthController::class, 'toggleWinner'])->name('proyouth.winner.toggle');
    Route::get('proyouth/report/{type}', [ProYouthController::class, 'report'])->name('proyouth.report');
    Route::get('proyouth/report/{type}/download', [ProYouthController::class, 'downloadReport'])->name('proyouth.report.download');

    // 5S Certification
    Route::resource('five-s', FiveSController::class);

    // Certification Course
    Route::resource('courses', CertificationCourseController::class);

    // Training Program
    Route::resource('training', TrainingProgramController::class);

    // Officers
    Route::resource('officers', OfficerController::class);

    // 4i Program
    Route::resource('allocations', App\Http\Controllers\AllocationController::class)->names('fouri.allocations');
    Route::get('allocations/{allocation}/report', [App\Http\Controllers\AllocationController::class, 'report'])->name('fouri.allocations.report');
    Route::get('allocations/{allocation}/report/download', [App\Http\Controllers\AllocationController::class, 'downloadReport'])->name('fouri.allocations.report.download');
    Route::delete('allocations/images/{image}', [App\Http\Controllers\AllocationController::class, 'destroyImage'])->name('fouri.allocations.images.destroy');
    Route::resource('letters', App\Http\Controllers\LetterController::class);
    Route::get('letters/{letter}/report', [App\Http\Controllers\LetterController::class, 'report'])->name('letters.report');
    Route::get('letters/{letter}/report/download', [App\Http\Controllers\LetterController::class, 'downloadReport'])->name('letters.report.download');

    // Gallery
    Route::get('gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('gallery', [GalleryController::class, 'upload'])->name('gallery.upload');
    Route::delete('gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    // Archive
    Route::resource('archive', ArchiveController::class);
    Route::get('archive/{archive}/download', [ArchiveController::class, 'download'])->name('archive.download');

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::get('reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::delete('reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
    Route::get('reports/{report}/pdf', [ReportController::class, 'downloadPdf'])->name('reports.pdf');
    Route::get('reports/{report}/excel', [ReportController::class, 'downloadExcel'])->name('reports.excel');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});
