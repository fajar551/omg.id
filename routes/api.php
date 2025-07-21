<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Content\ContentCategoryController;
use App\Http\Controllers\API\Goal\GoalController;
use App\Http\Controllers\API\Post\PostController;
use App\Http\Controllers\API\Content\ContentController;
use App\Http\Controllers\API\Item\ItemController;
use App\Http\Controllers\API\Page\MyTemplateController;
use App\Http\Controllers\API\Page\PageCategoryController;
use App\Http\Controllers\API\Page\PageController;
use App\Http\Controllers\API\Page\PageTemplateController;
use App\Http\Controllers\API\Page\UserInfoController;
use App\Http\Controllers\API\Auth\VerificationController;
use App\Http\Controllers\API\Explore\ExploreController;
use App\Http\Controllers\API\Followers\FollowersController;
use App\Http\Controllers\API\Guide\GuideController;
use App\Http\Controllers\API\Integration\WebhookController as IntegrationWebhookController;
use App\Http\Controllers\API\Invoice\WebhookController;
use App\Http\Controllers\API\notification\NotificationController;
use App\Http\Controllers\API\PaymentMethod\PaymentMethodController;
use App\Http\Controllers\API\Payout\PayoutAccountController;
use App\Http\Controllers\API\Payout\PayoutChannelController;
use App\Http\Controllers\API\Payout\PayoutController;
use App\Http\Controllers\API\Report\ReportController;
use App\Http\Controllers\API\Setting\FeatureController;
use App\Http\Controllers\API\Setting\SettingController;
use App\Http\Controllers\API\SocialLink\SocialLinkController;
use App\Http\Controllers\API\Support\SupportController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\User\UserWidgetController;
use App\Http\Controllers\API\UserBalance\UserBalanceController;
use App\Http\Controllers\API\Widget\OverlayController;
use App\Http\Controllers\API\Widget\WebEmbedController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function () {
    
    // Auth public routes
    Route::group(['middleware' => ['guest:web']], function () {
        Route::post('login', [AuthController::class, "login"]);
        Route::post('register', [AuthController::class, "register"]);
        Route::get('email/resend', [VerificationController::class, "resend"])->name('api.verification.resend');
        Route::get('email/verify/{id}/{hash}', [VerificationController::class, "verify"])->name('api.verification.verify');
        Route::post('forgot-password', [AuthController::class, "forgotpassword"]);
        Route::post('reset-password', [AuthController::class, "resetpassword"]);
    });

    // Auth protected routes, need access token to access this routes
    Route::group(['middleware' => ['auth:sanctum', 'localization', 'verified']], function () {
        Route::get('logout', [AuthController::class, "logout"]);
        Route::get('user', [AuthController::class, "getUser"]);
        Route::post('status/change', [AuthController::class, "changeStatus"]);
    });

});

Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::get('show', [UserController::class, "profile"]);
        Route::post('update', [UserController::class, "updateProfile"]);
        Route::get('{file_name}/preview', [UserController::class, "preview"])->name("api.profile.preview")->withoutMiddleware(['auth:sanctum']);
    });
    Route::get('check/{username}', [UserController::class, "checkusername"])->withoutMiddleware(['auth:sanctum']);

    Route::post('password/change', [UserController::class, "changePassword"]);

    Route::group(['prefix' => 'support'], function () {
        Route::get('page', [UserController::class, "getSupportPage"]);
        Route::post('page/update', [UserController::class, "updateSupportPage"]);
        Route::get('history', [SupportController::class, "gethistory"]);
        Route::get('detail', [SupportController::class, "getdetail"])->withoutMiddleware(['auth:sanctum']);
        Route::get('page/{id}', [SupportController::class, "historypage"]);
        Route::get('totalcountperdays', [SupportController::class, "totalcountperdays"]);
        Route::get('totalamountperdays', [SupportController::class, "totalamountperdays"]);
        Route::get('platformamountperdays', [SupportController::class, "platformamountperdays"]);
    });
});

Route::group(['prefix' => 'integration', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::group(['prefix' => 'webhook'], function () {
        Route::post('test', [IntegrationWebhookController::class, "webhook"]);
        Route::put('switch-status', [IntegrationWebhookController::class, "switchStatus"]);

        // Only for test custom webhook - deleted soon
        Route::post('custom-webhook-test', [IntegrationWebhookController::class, "customWebhook"])->withoutMiddleware(['auth:sanctum']);
    });
});

Route::group(['prefix' => 'post', 'middleware' => ['auth:sanctum', 'localization']], function () {

    Route::get('lists', [PostController::class, "getPosts"]);
    Route::get('{user_id}/published-posts', [PostController::class, "getPublishedPosts"])->withoutMiddleware(['auth:sanctum']);
    Route::get('{id}/detail', [PostController::class, "getDetail"]);
    Route::post('create', [PostController::class, "store"]);
    Route::post('update', [PostController::class, "update"]);
    Route::delete('{id}/delete', [PostController::class, "delete"]);
    Route::put('{id}/pinned', [PostController::class, "setPinned"]);
    Route::put('status/change', [PostController::class, "setStatus"]);
    Route::put('{post_id}/like', [PostController::class, "like"]);
    Route::post('comment/create', [PostController::class, "commentCreate"]);
    Route::post('comment/update', [PostController::class, "commentUpdate"]);
    Route::delete('comment/{comment_id}/delete', [PostController::class, "commentDelete"]);
    Route::put('comment/{comment_id}/like', [PostController::class, "commentLike"]);
    Route::get('{file_name}/preview', [PostController::class, "preview"])->name("api.post.preview")->withoutMiddleware(['auth:sanctum']);
    
});

Route::group(['prefix' => 'goal', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::post('create', [GoalController::class, "store"]);
    Route::post('update', [GoalController::class, "update"]);
    Route::delete('{id}/delete', [GoalController::class, "delete"]);
    Route::get('{id}/detail', [GoalController::class, "getDetail"]);
    Route::get('{user_id}/lists', [GoalController::class, "getGoals"]);
    Route::get('active/{page_url}', [GoalController::class, "getAcive"])->withoutMiddleware(['auth:sanctum']);
    Route::put('activate', [GoalController::class, "setAcive"]);
    Route::put('reached', [GoalController::class, "setReached"]);
});

Route::group(['prefix' => 'item', 'middleware' => ['auth:sanctum', 'localization']], function () {

    Route::post('create', [ItemController::class, "store"]);
    Route::post('update', [ItemController::class, "update"]);
    Route::delete('{id}/delete', [ItemController::class, "delete"]);
    Route::get('{id}/detail', [ItemController::class, "getDetail"]);
    Route::get('lists', [ItemController::class, "getItems"]);
    Route::get('{user_id}/active-items', [ItemController::class, "getActiveItems"])->withoutMiddleware(['auth:sanctum']);
    Route::get('{id}/activate', [ItemController::class, "setActiveItem"]);
    Route::get('{file_name}/preview', [ItemController::class, "preview"])->name("api.item.preview")->withoutMiddleware(['auth:sanctum']);
    
});

Route::group(['prefix' => 'content', 'middleware' => ['auth:sanctum', 'localization']], function() {
    Route::get('lists', [ContentController::class, "getContents"]);
    Route::get('{slug}/detail', [ContentController::class, "show"]);
    Route::get('{category_id}/filterbycategory', [ContentController::class, "filterByCategory"]);
    Route::post('create', [ContentController::class, "store"]);
    Route::post('update', [ContentController::class, "update"]);
    Route::delete('{content_id}/delete', [ContentController::class, "delete"]);
    Route::put('category', [ContentController::class, "setCategory"]);
    Route::put('status', [ContentController::class, "setStatus"]);
    Route::get('{file_name}/thumbnail', [ContentController::class, "previewThumbnail"])->name("api.contentthumbnail.preview")->withoutMiddleware(['auth:sanctum']);
    Route::get('{file_name}/coverimgae', [ContentController::class, "previewCover"])->name("api.contentcover.preview")->withoutMiddleware(['auth:sanctum']);
    Route::post('comment/create', [ContentController::class, "commentCreate"]);
    Route::post('comment/update', [ContentController::class, "commentUpdate"]);
    Route::get('{content_id}/comments', [ContentController::class, "comments"]);
    Route::delete('comment/{id}/delete', [ContentController::class, "commentDelete"]);
    Route::get('{user_id}/published-content', [ContentController::class, "getPublishedContent"])->withoutMiddleware(['auth:sanctum']);
    Route::put('like', [ContentController::class, "like"]);
    Route::put('comment/like', [ContentController::class, "commentLike"]);
    Route::get('{user_id}/published-login', [ContentController::class, "getPublished"]);
});

Route::group(['prefix' => 'contentcategory', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('lists', [ContentCategoryController::class, "index"]);
    Route::get('categories', [ContentCategoryController::class, "categories"]);
    Route::get('{category_id}/detail', [ContentCategoryController::class, "show"]);
    Route::post('create', [ContentCategoryController::class, "store"]);
    Route::put('update', [ContentCategoryController::class, "update"]);
    Route::delete('{id}/delete', [ContentCategoryController::class, "delete"]);
});

Route::group(['prefix' => 'pagecategory', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('/', [PageCategoryController::class, "index"])->withoutMiddleware(['auth:sanctum']);
    Route::get('{category_id}/detail', [PageCategoryController::class, "show"]);
    Route::post('create', [PageCategoryController::class, "store"]);
    Route::put('update', [PageCategoryController::class, "update"]);
    Route::delete('{category_id}/delete', [PageCategoryController::class, "delete"]);
});

Route::group(['prefix' => 'feature', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('/', [FeatureController::class, "index"]);
    Route::get('{feature_id}/detail', [FeatureController::class, "show"]);
    Route::post('create', [FeatureController::class, "store"]);
    Route::put('update', [FeatureController::class, "update"]);
    Route::delete('{feature_id}/delete', [FeatureController::class, "delete"]);
});

Route::group(['prefix' => 'pagetemplate', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('/', [PageTemplateController::class, "getTemplates"]);
    Route::get('{template_id}/detail', [PageTemplateController::class, "show"]);
    Route::get('{category_id}/filterbycategory', [PageTemplateController::class, "filterByCategory"]);
    Route::post('create', [PageTemplateController::class, "store"]);
    Route::put('setcategory', [PageTemplateController::class, "setCategory"]);
    Route::post('update', [PageTemplateController::class, "update"]);
    Route::delete('{template_id}/delete', [PageTemplateController::class, "delete"]);
    Route::get('{file_name}/preview', [PageTemplateController::class, "preview"])->name("api.templateimage.preview")->withoutMiddleware(['auth:sanctum']);
});

Route::group(['prefix' => 'mytemplate', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('/', [MyTemplateController::class, "index"]);
    Route::get('{mytemplate_id}/detail', [MyTemplateController::class, "show"]);
    Route::post('create', [MyTemplateController::class, "store"]);
    Route::put('update', [MyTemplateController::class, "update"]);
    Route::delete('{mytemplate_id}/delete', [MyTemplateController::class, "delete"]);
});

Route::group(['prefix' => 'userinfo', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('/', [UserInfoController::class, "index"]);
    Route::get('{userinfo_id}/detail', [UserInfoController::class, "show"]);
    Route::get('active/{page_url}', [UserInfoController::class, "getAcive"])->withoutMiddleware(['auth:sanctum']);
    Route::post('create', [UserInfoController::class, "store"]);
    Route::put('update', [UserInfoController::class, "update"]);
    Route::put('activate', [UserInfoController::class, "setAcive"]);
    Route::delete('{userinfo_id}/delete', [UserInfoController::class, "delete"]);
});

Route::group(['prefix' => 'social', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::post('create', [SocialLinkController::class, "store"]);
    Route::get('{user_id}/show', [SocialLinkController::class, "getSocialLink"])->withoutMiddleware(['auth:sanctum']);
});

Route::group(['prefix' => 'page', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('{page_url}', [PageController::class, "index"])->withoutMiddleware(['auth:sanctum']);
    Route::post('create', [PageController::class, "store"]);
    Route::post('setprofile', [PageController::class, "setProfile"]);
    Route::post('setcover', [PageController::class, "setCover"]);
    Route::post('setvideo', [PageController::class, "setVideo"]);
    Route::post('setsummary', [PageController::class, "setSummary"]);
    Route::post('setcategory', [PageController::class, "setCategory"]);
    Route::post('setfeatured', [PageController::class, "setfeatured"]);
    Route::post('setpicked', [PageController::class, "setpicked"]);
    Route::post('setsensitive', [PageController::class, "setsensitive"]);
    Route::post('setstatus', [PageController::class, "setstatus"]);
    Route::get('{file_name}/previewcover', [PageController::class, "preview"])->name("api.pagecover.preview")->withoutMiddleware(['auth:sanctum']);
    Route::get('{file_name}/previewavatar', [PageController::class, "previewavatar"])->name("api.pageavatar.preview")->withoutMiddleware(['auth:sanctum']);
});

Route::group(['prefix' => 'support', 'middleware' => ['guest:web']], function () {
    Route::middleware('throttle:100,1')->group(function () {
        Route::post('snaptoken', [SupportController::class, "show"]);
    });
    Route::post('snapcharge', [SupportController::class, "snapcharge"]);
    Route::post('paymentcharge', [SupportController::class, "paymentcharge"]);
});

Route::group(['prefix' => 'widget'], function () {
    Route::group(['prefix' => 'overlay'], function () {
        Route::group(['middleware' => ['auth:sanctum', 'localization']], function () {
            Route::get('{key}', [OverlayController::class, "index"]);
            Route::get('widget-url/{key}', [OverlayController::class, "widgetURL"]);
            Route::get('renew/stream-key', [OverlayController::class, "renewStreamKey"]);
            Route::put('setting/update', [OverlayController::class, "updateSetting"]);
            Route::get('preview/{key}', [OverlayController::class, "preview"])->name("api.widget.overlay.preview")->withoutMiddleware(['auth:sanctum']);
            Route::get('show/{key}', [OverlayController::class, "widgetShow"])->name("api.widget.overlay.show")->withoutMiddleware(['auth:sanctum']);
        });
    });

    Route::group(['prefix' => 'web-embed'], function () {
        Route::get('{key}', [WebEmbedController::class, "index"]);
        Route::post('setting/update', [WebEmbedController::class, "updateSetting"]);
        Route::get('preview/{key}', [WebEmbedController::class, "preview"])->name("api.widget.web_embed.preview")->withoutMiddleware(['auth:sanctum']);
    });
});

Route::group(['prefix' => 'paymentmethod', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('/', [PaymentMethodController::class, "index"]);
    Route::get('{payment_method_id}/detail', [PaymentMethodController::class, "show"]);
    Route::post('create', [PaymentMethodController::class, "store"]);
    Route::post('update', [PaymentMethodController::class, "update"]);
    Route::delete('{payment_method_id}/delete', [PaymentMethodController::class, "delete"]);
    Route::get('{file_name}/preview', [PaymentMethodController::class, "preview"])->name("api.paymentmethod.preview")->withoutMiddleware(['auth:sanctum']);
});

Route::group(['prefix' => 'webhook', 'middleware' => ['guest:web']], function() {
    Route::post('midtrans', [WebhookController::class, 'midtrans']);
    Route::post('xenditewallet', [WebhookController::class, 'xenditewallet']);
    Route::post('xenditva', [WebhookController::class, 'xenditva']);
});

Route::group(['prefix' => 'setting', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::post('set', [SettingController::class, "set"]);
    Route::post('get', [SettingController::class, "get"]);
});

Route::group(['prefix' => 'userbalance', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('', [UserBalanceController::class, "show"]);
});

Route::group(['prefix' => 'payout', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::post('xenditpayout', [PayoutController::class, "xenditdisbursement"]);
    Route::post('callback', [PayoutController::class, "callback"])->withoutMiddleware(['auth:sanctum']);
    Route::get('totalpayout', [PayoutController::class, "totalpayout"]);
    Route::get('history', [PayoutController::class, "history"]);
    Route::post('midtranspayout', [PayoutController::class, "midtranspayout"]);
    Route::post('callbackmidtrans', [PayoutController::class, "callbackmidtrans"])->withoutMiddleware(['auth:sanctum']);
});

Route::group(['prefix' => 'payoutaccount', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('', [PayoutAccountController::class, "index"]);
    Route::get('{id}/detail', [PayoutAccountController::class, "show"]);
    Route::get('getprimary', [PayoutAccountController::class, "getprimary"]);
    Route::get('inactivate', [PayoutAccountController::class, "inactivate"]);
    Route::post('create', [PayoutAccountController::class, "store"]);
    Route::put('update', [PayoutAccountController::class, "update"]);
    Route::delete('{id}/delete', [PayoutAccountController::class, "delete"]);
    Route::put('setprimary', [PayoutAccountController::class, "setPrimary"]);
    Route::put('setstatus', [PayoutAccountController::class, "setstatus"]);
});

Route::group(['prefix' => 'payoutchannel', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('{id}/detail', [PayoutChannelController::class, "show"]);
    Route::get('getchannel', [PayoutChannelController::class, "getchannel"]);
});

Route::group(['prefix' => 'userwidget', 'middleware' => ['guest:web']], function () {
    Route::post('setstreaming', [UserWidgetController::class, "setstreaming"])->name("api.userwidget.setused");
    Route::get('getstreaming', [UserWidgetController::class, "index"])->name("api.getonlinestreamer");
});

Route::group(['prefix' => 'explore', 'middleware' => ['guest:web']], function () {
    Route::get('/', [ExploreController::class, 'index']);
});

Route::group(['prefix' => 'follow', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::post('', [FollowersController::class, 'index']);
    Route::get('{page_url}/detail', [FollowersController::class, 'detail'])->withoutMiddleware(['auth:sanctum']);
});

Route::group(['prefix' => 'report', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('', [ReportController::class, 'index']);
    Route::get('{report_id}', [ReportController::class, 'show']);
    Route::put('setstatus', [ReportController::class, 'setstatus']);
    Route::post('create', [ReportController::class, 'store'])->withoutMiddleware(['auth:sanctum']);
    Route::post('suspend', [ReportController::class, 'suspend']);
    Route::post('unsuspend', [ReportController::class, 'unsuspend']);
    Route::get('{file_name}/preview', [ReportController::class, "preview"])->name("api.report.preview")->withoutMiddleware(['auth:sanctum']);
});

Route::group(['prefix' => 'notifications', 'middleware' => ['auth:sanctum', 'localization']], function () {
    Route::get('get', [NotificationController::class, "get"])->name("api.notification.get");
    Route::put('mark-as-read', [NotificationController::class, "markNotification"])->name('api.notification.mark');
});

Route::post('guideupdate', [GuideController::class, 'update'])->middleware(['auth:sanctum']);