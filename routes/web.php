<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accept_invitation\AcceptInvitationController;
use App\Http\Controllers\Aceess_code\AccessCodeController;
use App\Http\Controllers\Auth\SessionAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Exam\ExamsController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\tests\TestAttemptsController;
use App\Http\Controllers\tests\TestInvitationsController;
use App\Http\Controllers\tests\TestsController;
use App\Http\Controllers\tests\TestsSessionController;
use App\Http\Controllers\UpgradePlanController;
use App\Models\SubscriptionPlan;

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

Route::get('tests', [TestsController::class, 'index'])->name('tests.index');
Route::get('download/test/{test}', [TestsController::class, 'download'])->name('tests.download');
Route::get('print/test/{test}', [TestsController::class, 'print'])->name('tests.print');

Route::get('/login', [SessionAuthController::class, 'loginForm'])->name('login-form');
Route::post('/login', [SessionAuthController::class, 'login'])->name('login');
Route::post('/register', [SessionAuthController::class, 'register'])->name('register');

Route::get('/', function () {

    $plans = SubscriptionPlan::all();

    return view('site.index', ['subscriptionPlans' => $plans]);
})->name('site.index');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', [SessionAuthController::class, 'logout'])->name('logout');

    Route::get('/app', DashboardController::class)->name('app.dashboard');

    // Upgrade Plans
    Route::get('upgrade_plans', [UpgradePlanController::class, 'index'])->name('upgrade_plans.index');

    // Payment
    Route::get('payment/{subscriptionPlan}', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('payment/{subscriptionPlan}/success', [PaymentController::class, 'success'])->name('payment.success');
});

/* tests */
Route::get('tests', [TestsController::class, 'index'])->name('tests.index');
Route::get('tests/create', [TestsController::class, 'create'])->name('tests.create');
Route::get('tests/edit', [TestsController::class, 'edit'])->name('tests.edit');

Route::get('tests', [TestsController::class, 'index'])->name('tests.index');
Route::get('tests/create', [TestsController::class, 'create'])->name('tests.create');
Route::get('tests/edit/{test}', [TestsController::class, 'edit'])->name('tests.edit');
Route::get('tests/create', [TestsController::class, 'create'])->name('tests.create');
Route::get('/app', DashboardController::class)->name('app.dashboard');

// exam
Route::get('exam', [ExamsController::class, 'index'])->name('exams.index');
Route::get('getDate/{id}', [ExamsController::class, 'getUserTestAttemptAnswers'])->name('exams.getUserTestAttemptAnswers');
Route::get('test-by-access-code/{accessCode}', [ExamsController::class, 'getTestByAccessCode']);

Route::get('control/exam', [ExamsController::class, 'control'])->name('exams.control');

Route::get('access/exam', [ExamsController::class, 'access'])->name('exams.access');

Route::get('exam-event', [ExamsController::class, 'examEvent']);

/* tests */

Route::get('tests/attempts', [TestAttemptsController::class, 'index'])->name('tests.attempts.index');
Route::get('tests/invitations', [TestInvitationsController::class, 'index'])->name('tests.invitations.index');

//tests Session
Route::get('testsSession', [TestsSessionController::class, 'index'])->name('testsSession.index');


// User
Route::get('users/edit', [UsersController::class, 'edit'])->name('users.edit');

//access code

Route::get('access_code', [AccessCodeController::class, 'index'])->name('accces_code.index');


//Success Message

Route::get('accept_invitation', [AcceptInvitationController::class, 'index'])->name('accept_invitation.index');

// Plans
Route::get('subscription_plans', [SubscriptionPlanController::class, 'index'])->name('subscription_plans.index');
