<?php

use App\Http\Controllers\Accept_invitation\AcceptInvitationController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\tests\NotificationController;
use App\Http\Controllers\tests\TestAttemptsController;
use App\Http\Controllers\tests\TestInvitationsController;
use App\Http\Controllers\tests\TestsController;
use App\Http\Controllers\tests\TestsSessionController;
use App\Http\Controllers\UpgradePlanController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\User\UserTestAttemptsQuestionsAnswersController;
use App\Http\Controllers\User\UserTestAttemptsQuestionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Authentication */



Route::post('register', [ApiAuthController::class, 'register'])->name('api.register');
Route::post('login', [ApiAuthController::class, 'login'])->name('api.login');
Route::post('logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');

Route::get('/exam/{id}', [TestsController::class, 'getTest']);

Route::put('/user-test-attempts/{userTestAttemptId}', [TestAttemptsController::class, 'update']);
Route::post('/user-test-attempts', [TestAttemptsController::class, 'store']);
Route::post('/user-test-attempts/questions', [UserTestAttemptsQuestionsController::class, 'store']);
Route::post('/user-test-attempt-question-answers', [UserTestAttemptsQuestionsAnswersController::class, 'store']);
Route::get('allTests', [TestsController::class, 'getAllTests']);
Route::put('/update-is-code-used/{id}', [TestInvitationsController::class, 'updateIsCodeUsed']);


Route::group(['middleware' => ['auth:sanctum']], function () {

    /* tests */
    Route::post('tests', [TestsController::class, 'store'])->name('tests.store');
    Route::get('tests/fetch', [TestsController::class, 'fetch'])->name('tests.fetch');
    Route::get('tests/{test}', [TestsController::class, 'show'])->name('tests.show');
    Route::delete('tests/{test}', [TestsController::class, 'destroy'])->name('tests.destroy');
    Route::put('tests/edit/{test}', [TestsController::class, 'update'])->name('tests.update');

    //tests session
    Route::post('testsSession', [TestsSessionController::class, 'store'])->name('testsSession.store');
    Route::put('testsSession/{testSession}', [TestsSessionController::class, 'update'])->name('testsSession.update');
    Route::get('testsSession/fetch', [TestsSessionController::class, 'fetch'])->name('testsSession.fetch');
    Route::get('testsSession/{testSession}', [TestsSessionController::class, 'show'])->name('testsSession.show');
    Route::delete('testsSession/{testSession}', [TestsSessionController::class, 'destroy'])->name('testsSession.destroy');

    //tests Invitation

    Route::post('tests/invitations', [TestInvitationsController::class, 'store'])->name('tests.invitations.store');
    Route::get("tests/invitations/fetch", [TestInvitationsController::class, 'fetch'])->name('tests.invitations.fetch');
    Route::put("tests/invitations/{testInvitation}", [TestInvitationsController::class, 'update'])->name('tests.invitations.update');
    Route::delete("tests/invitations/{testInvitation}", [TestInvitationsController::class, 'destroy'])->name('tests.invitations.destroy');
    Route::post("tests/invitations/{testInvitation}", [TestInvitationsController::class, 'resend'])->name('tests.invitations.resend');

    //tests Attempts
    Route::get('tests/attempts/fetch', [TestAttemptsController::class, 'fetch'])->name('tests.attempts.fetch');


    /* questions */

    Route::get('questions/fetch', [QuestionsController::class, 'fetch'])->name('questions.fetch');
    Route::get('questions/{question}', [QuestionsController::class, 'show'])->name('questions.show');
    Route::post('questions/{test}', [QuestionsController::class, 'store'])->name('questions.store');
    Route::put('questions/{question}', [QuestionsController::class, 'update'])->name('questions.update');
    Route::delete('questions/{question}', [QuestionsController::class, 'destroy'])->name('questions.destroy');

    /* answers */

    Route::get('answers/fetch', [AnswersController::class, 'fetch'])->name('answers.fetch');
    Route::get('answers/{answer}', [AnswersController::class, 'show'])->name('answers.show');
    Route::post('answers/{question}', [AnswersController::class, 'store'])->name('answers.store');
    Route::put('answers/{answer}', [AnswersController::class, 'update'])->name('answers.update');
    Route::delete('answers/{answer}', [AnswersController::class, 'destroy'])->name('answers.destroy');

    // Users
    Route::get('users', [UsersController::class, 'fetch'])->name('users.fetch');
    Route::put('users/update', [UsersController::class, 'update'])->name('users.update');


    // Test Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    //Upgrade Plans
    Route::get('upgrade_plans/fetch', [UpgradePlanController::class, 'fetch'])->name('upgrade_plans.fetch');

    //payment
    Route::put('payment/{subscriptionPlan}/update', [PaymentController::class, 'update'])->name('payment.update');
});

//Accept Invitation
Route::put('accept_invitation/{testInvitation}', [AcceptInvitationController::class, 'update'])->name('accept_invitation.update');

//Subscription Plan
Route::get('plans/fetch', [SubscriptionPlanController::class, 'fetch'])->name('plans.fetch');
Route::get('plans/{subscriptionPlan}', [SubscriptionPlanController::class, 'show'])->name('plans.show');
Route::post('plans', [SubscriptionPlanController::class, 'store'])->name('plans.store');
Route::put('plans/{subscriptionPlan}/update', [SubscriptionPlanController::class, 'update'])->name('plans.update');
Route::delete('plans/{subscriptionPlan}/destroy', [SubscriptionPlanController::class, 'destroy'])->name('plans.destroy');
