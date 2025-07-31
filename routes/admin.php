<?php

use App\Http\Controllers\Admin\Administrator\AdminListController;
use App\Http\Controllers\Admin\Administrator\PermissionController;
use App\Http\Controllers\Admin\Administrator\RoleController;
use App\Http\Controllers\Admin\Creator\CreatorListController;
use App\Http\Controllers\Admin\Creator\PaymentAccountController;
use App\Http\Controllers\Admin\Creator\PayoutAccountController;
use App\Http\Controllers\Admin\Creator\ReportedAccountController;
use App\Http\Controllers\Admin\Creator\ReportedContentController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Master\ContentCategoryController;
use App\Http\Controllers\Admin\Master\DefaultItemController;
use App\Http\Controllers\Admin\Master\PageCategoryController;
use App\Http\Controllers\Admin\Master\PaymentMethodController;
use App\Http\Controllers\Admin\Master\PayoutChannelController;
use App\Http\Controllers\Admin\Setting\AccountSettingController;
use App\Http\Controllers\Admin\Setting\ChangePasswordSettingController;
use App\Http\Controllers\Admin\Setting\FeatureController;
use App\Http\Controllers\Admin\Setting\ProfileSettingController;
use App\Http\Controllers\Admin\Setting\SystemSettingController;
use App\Http\Controllers\Admin\Transaction\DisbursementController;
use App\Http\Controllers\Admin\Transaction\SupportController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Auth\Admin\ConfirmPasswordController;
use App\Http\Controllers\Auth\Admin\ResetPasswordController;
use App\Http\Controllers\Auth\Admin\ForgotPasswordController;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Auth\Admin\RegisterController;
use App\Http\Controllers\Auth\Admin\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome-admin');
});

Route::group(['prefix' => '/'], function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Logout Routes
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Registration Routes
    // Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::post('register', [RegisterController::class, 'register']);

    // Forgot Password Routes
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset Password Routes
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    // Confim Password Routes
    Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm.show');
    Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm'])->name('password.confirm');
    
    // Email Verification Routes
    // Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    // Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    // Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

Route::group(['middleware' => ['auth', 'is_admin', 'has_access_token']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('home');
    Route::get('dashboard/totalsoldproductsperdays', [DashboardController::class, 'totalsoldproductsperdays'])->name('dashboard.totalsoldproductsperdays');

    Route::group(['prefix' => 'master'], function () {
        Route::group(['prefix' => 'payment-method'], function () {
            Route::get('/', [PaymentMethodController::class, "index"])->name('master.paymentmethod.index');
            Route::put('change-icon', [PaymentMethodController::class, "changeIcon"])->name('master.paymentmethod.changeicon');
            Route::get('create', [PaymentMethodController::class, "create"])->name('master.paymentmethod.create');
            Route::post('store', [PaymentMethodController::class, "store"])->name('master.paymentmethod.store');
            Route::get('edit/{id}', [PaymentMethodController::class, "edit"])->name('master.paymentmethod.edit');
            Route::post('update', [PaymentMethodController::class, "update"])->name('master.paymentmethod.update');
            Route::post('setactive', [PaymentMethodController::class, "setactive"])->name('master.paymentmethod.setactive');
            // TODO: Continue next route...
        });

        Route::group(['prefix' => 'page-category'], function () {
            Route::get('/', [PageCategoryController::class, "index"])->name('master.pagecategory.index');
            Route::get('dtlist', [PageCategoryController::class, "dtlist"])->name('master.pagecategory.list');
            Route::post('store', [PageCategoryController::class, "store"])->name('master.pagecategory.store');
            Route::post('edit', [PageCategoryController::class, "edit"])->name('master.pagecategory.edit');
            Route::post('delete', [PageCategoryController::class, "delete"])->name('master.pagecategory.delete');
            // TODO: Continue next route...
        });

        Route::group(['prefix' => 'payout-channel'], function () {
            Route::get('/', [PayoutChannelController::class, "index"])->name('master.payoutchannel.index');
            Route::get('dtlist', [PayoutChannelController::class, "dtlist"])->name('master.payoutchannel.list');
            Route::post('store', [PayoutChannelController::class, "store"])->name('master.payoutchannel.store');
            Route::post('edit', [PayoutChannelController::class, "edit"])->name('master.payoutchannel.edit');
            Route::post('delete', [PayoutChannelController::class, "delete"])->name('master.payoutchannel.delete');
            // TODO: Continue next route...
        });

        Route::group(['prefix' => 'content-category'], function () {
            Route::get('/', [ContentCategoryController::class, "index"])->name('master.contentcategory.index');
            // TODO: Continue next route...
        });

        Route::group(['prefix' => 'default-item'], function () {
            Route::get('/', [DefaultItemController::class, "index"])->name('master.defaultitem.index');
            Route::get('update/{id}', [DefaultItemController::class, "update"])->name('master.defaultitem.update');
            Route::post('edit', [DefaultItemController::class, "edit"])->name('master.defaultitem.edit');
            Route::post('delete', [DefaultItemController::class, "delete"])->name('master.defaultitem.delete');
            Route::post('create', [DefaultItemController::class, "create"])->name('master.defaultitem.create');
            Route::post('changeicon', [DefaultItemController::class, "changeicon"])->name('master.defaultitem.changeicon');
            // TODO: Continue next route...
        });
    });
    
    Route::group(['prefix' => 'creator'], function () {
        Route::group(['prefix' => 'list'], function () {
            Route::get('/', [CreatorListController::class, "index"])->name('creator.list.index');
            Route::get('dtlistcreator.json', [CreatorListController::class, "dtListCreator"])->name('creator.list.datatable');
            Route::post('suspend', [CreatorListController::class, "suspend"])->name('creator.list.suspend');
            Route::post('unsuspend', [CreatorListController::class, "unsuspend"])->name('creator.list.unsuspend');
            Route::post('setpicked', [CreatorListController::class, "setpicked"])->name('creator.list.setpicked');
            Route::post('setfeatured', [CreatorListController::class, "setfeatured"])->name('creator.list.setfeatured');
            // TODO: Continue next route...
        });

        Route::group(['prefix' => 'payment-account'], function () {
            Route::get('/', [PaymentAccountController::class, "index"])->name('creator.paymentaccount.index');
            // TODO: Continue next route...
        });

        Route::group(['prefix' => 'payout-account'], function () {
            Route::get('/', [PayoutAccountController::class, "index"])->name('creator.payoutaccount.index');
            Route::post('setverified', [PayoutAccountController::class, "setverified"])->name('creator.payoutaccount.setverified');
            // TODO: Continue next route...
        });

        Route::group(['prefix' => 'reported-account'], function () {
            Route::get('/', [ReportedAccountController::class, "index"])->name('creator.reportedaccount.index');
            Route::get('getlistcreatorprocess', [ReportedAccountController::class, "getlistcreatorprocess"])->name('creator.reportedaccount.creatorprocess');
            Route::get('getlistcreatordone', [ReportedAccountController::class, "getlistcreatordone"])->name('creator.reportedaccount.getlistcreatordone');
            Route::post('suspend', [ReportedAccountController::class, "suspend"])->name('creator.reportedaccount.suspend');
            Route::post('unsuspend', [ReportedAccountController::class, "unsuspend"])->name('creator.reportedaccount.unsuspend');
            // TODO: Continue next route...
        });

        Route::group(['prefix' => 'reported-content'], function () {
            Route::get('/', [ReportedContentController::class, "index"])->name('creator.reportedcontent.index');
            Route::get('getlistcontentprocess', [ReportedContentController::class, "getlistcontentprocess"])->name('creator.reportedcontent.getlistcontentprocess');
            Route::get('getlistcontentdone', [ReportedContentController::class, "getlistcontentdone"])->name('creator.reportedcontent.getlistcontentdone');
            Route::post('block', [ReportedContentController::class, "block"])->name('creator.reportedcontent.block');
            Route::post('unblock', [ReportedContentController::class, "unblock"])->name('creator.reportedcontent.unblock');
            // TODO: Continue next route...
        });
    });
    
    Route::group(['prefix' => 'administrator'], function () {
        Route::group(['prefix' => 'list'], function () {
            Route::get('/', [AdminListController::class, "index"])->name('administrator.list.index');
            Route::get('create', [AdminListController::class, "create"])->name('administrator.list.create');
            Route::get('{id}/edit', [AdminListController::class, "edit"])->name('administrator.list.edit');
            Route::post('store', [AdminListController::class, "store"])->name('administrator.list.store');
            Route::put('update', [AdminListController::class, "update"])->name('administrator.list.update');
            Route::delete('delete', [AdminListController::class, "delete"])->name('administrator.list.delete');
            Route::get('dtindex.json', [AdminListController::class, "dtIndex"])->name('administrator.list.dtindex');
        });

        Route::group(['prefix' => 'role'], function () {
            Route::get('/', [RoleController::class, "index"])->name('administrator.role.index');
            Route::get('create', [RoleController::class, "create"])->name('administrator.role.create');
            Route::get('{id}/edit', [RoleController::class, "edit"])->name('administrator.role.edit');
            Route::post('store', [RoleController::class, "store"])->name('administrator.role.store');
            Route::put('update', [RoleController::class, "update"])->name('administrator.role.update');
            Route::delete('delete', [RoleController::class, "delete"])->name('administrator.role.delete');
            Route::get('dtindex.json', [RoleController::class, "dtIndex"])->name('administrator.role.dtindex');
        });

        Route::group(['prefix' => 'permission'], function () {
            Route::get('/', [PermissionController::class, "index"])->name('administrator.permission.index');
            Route::get('create', [PermissionController::class, "create"])->name('administrator.permission.create');
            Route::get('{id}/edit', [PermissionController::class, "edit"])->name('administrator.permission.edit');
            Route::post('store', [PermissionController::class, "store"])->name('administrator.permission.store');
            Route::put('update', [PermissionController::class, "update"])->name('administrator.permission.update');
            Route::delete('delete', [PermissionController::class, "delete"])->name('administrator.permission.delete');
            Route::get('dtindex.json', [PermissionController::class, "dtIndex"])->name('administrator.permission.dtindex');
        });
    });
    
    Route::group(['prefix' => 'setting'], function () {
        Route::group(['prefix' => 'system'], function () {
            Route::get('/', [SystemSettingController::class, "index"])->name('setting.system.index');
            Route::post('store-payment-fee', [SystemSettingController::class, "storePaymentFee"])->name('setting.system.storepaymentfee');
            // TODO: Continue next route...
        });
        
        Route::group(['prefix' => 'account'], function () {
            Route::get('/', [AccountSettingController::class, "index"])->name('setting.account.index');
            // TODO: Continue next route...
        });

        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [ProfileSettingController::class, "index"])->name('setting.profile.index');
            Route::post('update', [ProfileSettingController::class, "update"])->name('setting.profile.update');
            // TODO: Continue next route...
        });

        Route::group(['prefix' => 'change-pw'], function () {
            Route::get('/', [ChangePasswordSettingController::class, "index"])->name('setting.changepw.index');
            Route::post('change', [ChangePasswordSettingController::class, "changePassword"])->name('setting.changepw.update');
        });

        Route::group(['prefix' => 'feature'], function () {
            Route::get('/', [FeatureController::class, "index"])->name('setting.feature.index');
            Route::get('dtlist', [FeatureController::class, "dtlist"])->name('setting.feature.list');
            Route::post('store', [FeatureController::class, "store"])->name('setting.feature.store');
            Route::post('edit', [FeatureController::class, "edit"])->name('setting.feature.edit');
            Route::post('delete', [FeatureController::class, "delete"])->name('setting.feature.delete');
            Route::post('status', [FeatureController::class, "status"])->name('setting.feature.status');
            // TODO: Continue next route...
        });
    });

    Route::group(['prefix' => 'transaction'], function () {
        Route::group(['prefix' => 'support'], function () {
            Route::get('/', [SupportController::class, "index"])->name('transaction.support.index');
            Route::get('dtlist', [SupportController::class, "dtlist"])->name('transaction.support.dtlist');
            Route::get('selectSearch', [SupportController::class, "selectSearch"])->name('transaction.support.selectSearch');
            Route::post('totalsupport', [SupportController::class, "totalsupport"])->name('transaction.support.totalsupport');
            Route::post('creatoramount', [SupportController::class, "creatoramount"])->name('transaction.support.creatoramount');
            Route::post('platformamount', [SupportController::class, "platformamount"])->name('transaction.support.platformamount');
            Route::get('exportexcel', [SupportController::class, "exportexcel"])->name('transaction.support.exportexcel');
            // TODO: Continue next route...
        });
        
        Route::group(['prefix' => 'disbursement'], function () {
            Route::get('/', [DisbursementController::class, "index"])->name('transaction.disbursement.index');
            Route::get('dtlist', [DisbursementController::class, "dtlist"])->name('transaction.disbursement.dtlist');
            Route::post('totalpayout', [DisbursementController::class, "totalpayout"])->name('transaction.disbursement.totalpayout');
            Route::post('payoutamount', [DisbursementController::class, "payoutamount"])->name('transaction.disbursement.payoutamount');
            Route::get('exportexcel', [DisbursementController::class, "exportexcel"])->name('transaction.disbursement.exportexcel');
            // TODO: Continue next route...
        });
    });
});