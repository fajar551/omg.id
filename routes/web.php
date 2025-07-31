<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Client\Balance\BalanceController;
use App\Http\Controllers\Client\Creator\CreatorController;
use App\Http\Controllers\Client\Content\ContentController;
use App\Http\Controllers\Client\Dashboard\DashboardController;
use App\Http\Controllers\Client\Explore\ExploreController;
use App\Http\Controllers\Client\Goal\GoalController;
use App\Http\Controllers\Client\Goal\GoalHistoryController;
use App\Http\Controllers\Client\Integration\CustomIntegrationController;
use App\Http\Controllers\Client\Integration\DiscordIntegrationController;
use App\Http\Controllers\Client\Item\ItemController;
use App\Http\Controllers\Client\Overlay\OverlayController;
use App\Http\Controllers\Client\Page\PageController;
use App\Http\Controllers\Client\Payout\PayoutController;
use App\Http\Controllers\Client\PayoutAccount\PayoutAccountController;
use App\Http\Controllers\Client\Post\PostController;
use App\Http\Controllers\Client\Setting\ChangePasswordSettingController;
use App\Http\Controllers\Client\Setting\GeneralSettingController;
use App\Http\Controllers\Client\Setting\ProfileSettingController;
use App\Http\Controllers\Client\Setting\SocialLinkSettingController;
use App\Http\Controllers\Client\Setting\SupportPageSettingController;
use App\Http\Controllers\Client\Payment\PaymentController;
use App\Http\Controllers\Client\Report\ReportController;
use App\Http\Controllers\Client\StaticPage\StaticPageController;
use App\Http\Controllers\Client\Support\SupportController;
use App\Http\Controllers\Client\Supporter\SupporterController;
use App\Src\Services\Eloquent\SettingService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Client\Product\ProductController as ClientProductController;
use App\Http\Controllers\Client\Product\ProductPaymentController;


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

Route::get('/', [StaticPageController::class, "index"])->name('landing');

Route::group(['prefix' => 'pages'], function () {
    Route::get('/', [StaticPageController::class, "index"])->name('pages.landing');
    Route::get('term-of-service', [StaticPageController::class, "termOfService"])->name('pages.termofservice');
    Route::get('privacy-police', [StaticPageController::class, "privacyPolice"])->name('pages.privacypolice');
    Route::get('feature', [StaticPageController::class, "feature"])->name('pages.feature');
    Route::get('about', [StaticPageController::class, "about"])->name('pages.about');
    Route::get('help', [StaticPageController::class, "help"])->name('pages.help');
    Route::get('career', [StaticPageController::class, "career"])->name('pages.career');
});

Route::group(['prefix' => 'explore'], function () {
    Route::get('/', [ExploreController::class, "index"])->name('explore.index')->middleware('feature:explore,on,404');
});

// Testing/Preview page
// Route::get('/example', function (){
//     return view("page-dev");
// });

Route::group(['prefix' => 'report'], function () {
    Route::get('/', [ReportController::class, "index"])->name('report.index');
    Route::post('store', [ReportController::class, "store"])->name('report.store');
});

Auth::routes(['verify' => true]);

Route::group(['prefix' => 'auth'], function () {
    Route::get('{provider}', [LoginController::class, 'redirect'])->name('auth.social.provider');
    Route::get('{provider}/callback', [LoginController::class, 'callback'])->name('auth.social.callback');
});

Route::group(['prefix' => 'password', 'middleware' => ['auth', 'verified', 'is_creator', 'has_access_token']], function () {
    Route::get('change', [ResetPasswordController::class, 'showChangePasswordForm'])->name('password.change.index');
    Route::post('change', [ResetPasswordController::class, 'changePassword'])->name('password.change');
});

Route::group(['prefix' => '{page_name}'], function () {
    Route::get('/', [CreatorController::class, 'index'])->name('creator.index')->middleware('feature:creator_page,on,404');
    Route::get('content', [CreatorController::class, 'content'])->name('creator.content')->middleware('feature:creator_page,on,404');
    Route::get('content/saved', [CreatorController::class, 'savedContent'])->name('creator.savedcontent')->middleware('feature:creator_page,on,404');
    Route::get('content/{slug}/detail', [CreatorController::class, 'contentDetail'])->name('creator.contentdetail')->middleware(['feature:creator_page,on,404']);
    
    // Product detail route for public
    Route::get('product/{product_id}/detail', [CreatorController::class, 'productDetail'])->name('product.detail.public')->middleware('feature:creator_page,on,404');
    
    Route::group(['prefix' => 'support'], function () {
        Route::get('/', [SupportController::class, 'index'])->name('support.index');
        Route::get('{orderID}/status', [SupportController::class, 'paymentStatus'])->name('support.payment_status');
    });

    /*
    TODO: Uncomment this later!
    Route::group(['prefix' => 'content'], function () {
        Route::get('/', [ContentController::class, 'index'])->name('content.index');
        Route::get('{slug}', [ContentController::class, 'show'])->name('content.detail');
    });
    
    Route::group(['prefix' => 'post'], function () {
        Route::get('/', [PostController::class, 'index'])->name('post.index');
        Route::get('{slug}', [PostController::class, 'show'])->name('post.detail');
    });
    */
});

// @Deprecated - use support.payment_status instead
// Route::get('/payment-status/{orderID}', [PaymentController::class, 'index'])->name('creator.payment_status.index');

Route::get('/creator/{username}', [App\Http\Controllers\Client\Creator\CreatorStoreController::class, 'show'])->name('creator.store.show');



Route::group(['prefix' => 'client', 'middleware' => ['verified', 'must_change_password', 'is_creator', 'is_banned', 'has_access_token']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('home');

    Route::group(['prefix' => 'goal', 'middleware' => ['auth']], function () {
        Route::group(['prefix' => 'my-goal'], function () {
            Route::get('/', [GoalController::class, "index"])->name('goal.mygoal.index');
            Route::get('create', [GoalController::class, "create"])->name('goal.mygoal.create');
            Route::get('{id}/edit', [GoalController::class, "edit"])->name('goal.mygoal.edit');
            Route::post('store', [GoalController::class, "store"])->name('goal.mygoal.store');
            Route::put('update', [GoalController::class, "update"])->name('goal.mygoal.update');
            Route::put('reached', [GoalController::class, "setReached"])->name('goal.mygoal.setreached');
        });
        
        Route::group(['prefix' => 'goal-history'], function () {
            Route::get('/', [GoalHistoryController::class, "index"])->name('goal.history.index');
            Route::delete('delete', [GoalHistoryController::class, "delete"])->name('goal.history.delete');
            Route::get('dtGoalHistory', [GoalHistoryController::class, "dtGoalHistory"])->name('goal.history.dtgoal');
        });
    });

    Route::group(['prefix' => 'item', 'middleware' => ['auth']], function () {
        Route::get('/', [ItemController::class, "index"])->name('item.index');
        Route::get('create', [ItemController::class, "create"])->name('item.create');
        Route::get('{id}/edit', [ItemController::class, "edit"])->name('item.edit');
        Route::post('store', [ItemController::class, "store"])->name('item.store');
        Route::put('update', [ItemController::class, "update"])->name('item.update');
        Route::delete('delete', [ItemController::class, "delete"])->name('item.delete');
        Route::post('setactive', [ItemController::class, "setactive"])->name('item.setactive');
        Route::post('changeicon', [ItemController::class, "changeicon"])->name('item.changeicon');
    });

    Route::group(['prefix' => 'content/manage', 'middleware' => ['auth', 'feature:manage_content,on,404']], function () {
        Route::get('/', [ContentController::class, "index"])->name('content.index');
        Route::get('create', [ContentController::class, "create"])->name('content.create');
        Route::get('{id}/edit', [ContentController::class, "edit"])->name('content.edit');
        Route::post('store', [ContentController::class, "store"])->name('content.store');
        Route::put('update', [ContentController::class, "update"])->name('content.update');
        Route::delete('delete', [ContentController::class, "delete"])->name('content.delete');
        Route::get('meta', [ContentController::class, "meta"])->name('content.meta')->withoutMiddleware(['auth']);
        Route::post('upload', [ContentController::class, "upload"])->name('content.upload');
        Route::post('fetchImage', [ContentController::class, "fetchImage"])->name('content.fetchImage');
        Route::put('status', [ContentController::class, "setStatus"])->name('content.status');
        Route::get('{id}/download', [ContentController::class, "download"])->name('content.download');
    });

    Route::group(['prefix' => 'overlay', 'middleware' => ['auth']], function () {
        Route::get('/', [OverlayController::class, "index"])->name('overlay.index');
        Route::get('{key}', [OverlayController::class, "index"])->name('overlay.notification');
        Route::put('update', [OverlayController::class, "update"])->name('overlay.update');
        Route::put('update-mediashare', [OverlayController::class, "updateMediaShare"])->name('overlay.store.mediashare');
    });

    Route::group(['prefix' => 'balance', 'middleware' => ['auth']], function () {
        Route::get('/', [BalanceController::class, "index"])->name('balance.index');
        Route::get('getlisttransactions', [BalanceController::class, "getlisttransactions"])->name('balance.transaction.list');
        Route::post('create', [PayoutController::class, "create"])->name('payout.create');
        Route::post('exporttransactions', [BalanceController::class, "exporttransactions"])->name('balance.exporttransactions');
    });

    Route::group(['prefix' => 'integration', 'middleware' => ['auth']], function () {
        Route::group(['prefix' => 'discord'], function () {
            Route::get('/', [DiscordIntegrationController::class, "index"])->name('integration.discord.index');
            Route::post('create', [DiscordIntegrationController::class, "store"])->name('integration.discord.store');
        });
        
        Route::group(['prefix' => 'custom'], function () {
            Route::get('/', [CustomIntegrationController::class, "index"])->name('integration.custom.index');
            Route::post('create', [CustomIntegrationController::class, "store"])->name('integration.custom.store');
        });
    });

    Route::group(['prefix' => 'setting', 'middleware' => ['auth']], function () {
        // Creator Profile Setting
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [ProfileSettingController::class, "index"])->name('setting.profile.index');
            Route::post('update', [ProfileSettingController::class, "update"])->name('setting.profile.update');
            Route::post('update/profilepic', [ProfileSettingController::class, "updateProfilePicture"])->name('setting.profile.update.pp');
        });

        Route::group(['prefix' => 'support-page'], function () {
            Route::get('/', [SupportPageSettingController::class, "index"])->name('setting.supportpage.index');
            Route::post('create', [SupportPageSettingController::class, "store"])->name('setting.supportpage.store');
        });
        
        Route::group(['prefix' => 'change-pw'], function () {
            Route::get('/', [ChangePasswordSettingController::class, "index"])->name('setting.changepw.index');
            Route::post('change', [ChangePasswordSettingController::class, "changePassword"])->name('setting.changepw.update');
        });
        
        Route::group(['prefix' => 'social-link'], function () {
            Route::get('/', [SocialLinkSettingController::class, "index"])->name('setting.social.index');
            Route::post('create', [SocialLinkSettingController::class, "store"])->name('setting.social.store');
        });

        Route::group(['prefix' => 'general'], function () {
            Route::get('/', [GeneralSettingController::class, "index"])->name('setting.general.index');
            Route::post('renew-streamkey', [GeneralSettingController::class, "renewStreamkey"])->name('setting.general.streamkey.store');
            Route::post('create', [GeneralSettingController::class, "store"])->name('setting.general.system.store');
        });

    });

    Route::group(['prefix' => 'payoutaccount', 'middleware' => ['auth']], function () {
        Route::get('/', [PayoutAccountController::class, "index"])->name('payoutaccount.index');
        Route::post('create', [PayoutAccountController::class, "create"])->name('payoutaccount.create');
        Route::post('setprimary', [PayoutAccountController::class, "setprimary"])->name('payoutaccount.setprimary');
        Route::get('{id}/edit', [PayoutAccountController::class, "edit"])->name('payoutaccount.edit');
        Route::post('update', [PayoutAccountController::class, "update"])->name('payoutaccount.update');
        Route::post('delete', [PayoutAccountController::class, "delete"])->name('payoutaccount.delete');
    });

    Route::group(['prefix' => 'page', 'middleware' => ['auth', 'feature:manage_page,on,404']], function () {
        Route::get('/', [PageController::class, "index"])->name('page.index');
        Route::post('editcover', [PageController::class, "editcover"])->name('page.editcover');
        Route::post('setProfile', [PageController::class, "setProfile"])->name('page.setProfile');
        Route::post('setsummary', [PageController::class, "setSummary"])->name('page.setsummary');
        Route::post('setvideo', [PageController::class, "setvideo"])->name('page.setvideo');
    });

    Route::group(['prefix' => 'supporter', 'middleware' => ['auth']], function () {
        Route::get('subscribed-content', [SupporterController::class, "subscribed_content"])->name('supporter.subscribedcontent');
        Route::get('support-history', [SupporterController::class, "support_history"])->name('supporter.supporthistory');
        Route::get('getlisttransactions', [SupporterController::class, "getlisttransactions"])->name('supporter.transaction.list');
        Route::get('followed-creator', [SupporterController::class, "followed_creator"])->name('supporter.followedcreator');
    });
});



// Extensions Routes
Route::get('js/lang.js', function () {
    $lang = config('app.locale');
    //$strings = \Illuminate\Support\Facades\Cache::rememberForever('lang_'.$lang.'.js', function () use($lang) {
        $path= resource_path('lang/' . $lang);
        $files = File::allFiles($path);
        $strings = [];
        foreach ($files as $file) {
            $name = basename($file->getPathname(), '.php');
            $strings[$name] = require $file->getpathName();
        }

        //return $strings;
    //});

    header('Content-Type: text/javascript');
    echo("
    const lang = " . json_encode($strings) . ";" ."
    const langGet = (name, replacements = {}) => {
        const explodedName = name.split('.');
        let resultLang = '';
        let tempLang = lang;

        // Find the text in the lang json
        for (const key in explodedName) {
            tempLang = tempLang[explodedName[key]];
            resultLang = tempLang;
        }

        // String replacement
        for (const replace in replacements) {
            resultLang = resultLang.replace(`:\${replace}`, replacements[replace]);
        }

        return resultLang || name;
    }");

    exit();
})->name('lang');

Route::get('assets/js/vars.omg.js', function () {

    $data = [
        'uid' => auth()->check() ? auth()->user()->id : null,
        'auth' => auth()->check(),
        'tk' => session('access_token'),
        'apiURL' => url('/api'),
        'appURL' => url('')
    ];
    

    header('Content-Type: text/javascript');
    echo('const vars = ' . json_encode($data) . ';');
    exit();
})->name('vars.omg.js');


Route::middleware(['auth', 'is_creator'])->group(function () {
    Route::resource('products', ClientProductController::class);
    Route::post('products/{id}/toggle-hide', [ClientProductController::class, 'toggleHide'])->name('products.toggleHide');
    Route::get('/client/page/products', [PageController::class, 'products'])->name('page.products');
    Route::get('product/manage/{id}/edit', [ClientProductController::class, 'edit'])->name('product.manage.edit');
    Route::delete('product/manage/delete/{id}', [ClientProductController::class, 'destroy'])->name('product.manage.destroy');
});

// Hapus route products.create agar tidak ada akses langsung ke /products/create

Route::group(['prefix' => 'product/manage', 'middleware' => ['auth', 'is_creator']], function () {
    Route::get('/', [ClientProductController::class, "index"])->name('product.index');
    Route::get('create', [ClientProductController::class, "create"])->name('product.create');
    Route::get('{id}/edit', [ClientProductController::class, "edit"])->name('product.edit');
    Route::post('store', [ClientProductController::class, "store"])->name('product.store');
    Route::put('update/{id}', [ClientProductController::class, "update"])->name('product.update');
    Route::delete('delete/{id}', [ClientProductController::class, "destroy"])->name('product.delete');
});

// Alternative Product Payment Routes (DISABLED)
// Route::get('{page_name}/buy/product/{id}', [App\Http\Controllers\Client\Product\ProductPurchaseController::class, 'show'])->name('product.purchase.show');
// Route::post('{page_name}/buy/product/{id}', [App\Http\Controllers\Client\Product\ProductPurchaseController::class, 'purchase'])->name('product.purchase');
// Route::get('{page_name}/buy/payment/{id}', [App\Http\Controllers\Client\Product\ProductPurchaseController::class, 'payment'])->name('product.payment');
// Route::post('/product/payment/checkout', [\App\Http\Controllers\Product\ProductPaymentWebController::class, 'checkout'])->name('product.payment.checkout');

// HAPUS: Test route for payment testing
// Route::get('test/payment/{page_name}/{product_id}', function($pageName, $productId) {
//     $product = \App\Models\Product::find($productId);
//     if (!$product) {
//         return redirect()->back()->with('error', 'Product not found');
//     }
//     
//     $paymentMethods = \App\Models\PaymentMethod::where('disabled', null)->orderBy('order', 'ASC')->get();
//     
//     return view('products.purchase', compact('product', 'pageName', 'paymentMethods'));
// })->name('test.payment');

// Product download route
Route::get('product/download/{purchase_id}', function($purchaseId) {
    $purchase = \App\Models\ProductPurchase::with(['product.ebook', 'product.ecourse', 'product.digital'])->find($purchaseId);
    
    if (!$purchase) {
        abort(404, 'Purchase not found');
    }
    
    // Check if purchase is paid
    if ($purchase->status !== 'success') {
        abort(403, 'Payment not completed');
    }
    
    // Get file path based on product type
    $filePath = null;
    switch ($purchase->product->type) {
        case 'ebook':
            $filePath = $purchase->product->ebook->file_path ?? null;
            break;
        case 'ecourse':
            $filePath = $purchase->product->ecourse->file_path ?? null;
            break;
        case 'digital':
            $filePath = $purchase->product->digital->file_path ?? null;
            break;
    }
    
    if (!$filePath || !file_exists($filePath)) {
        abort(404, 'Product file not found');
    }
    
    // Return file download
    return response()->download($filePath, $purchase->product->name . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
})->name('product.download');

// Webhook routes for payment status
Route::post('webhook/product-purchase/xendit', [App\Http\Controllers\Client\Product\ProductPurchaseWebhookController::class, 'xenditWebhook']);
Route::post('webhook/product-purchase/midtrans', [App\Http\Controllers\Client\Product\ProductPurchaseWebhookController::class, 'midtransWebhook']);

// Product Payment Routes
Route::post('/product/payment/process', [App\Http\Controllers\Client\Product\ProductPaymentController::class, 'processPayment'])->name('product.payment.process');
Route::get('/product/payment/{purchase_id}/status', [App\Http\Controllers\Client\Product\ProductPaymentController::class, 'paymentStatus'])->name('product.payment.status');
Route::post('/product/payment/webhook', [App\Http\Controllers\Client\Product\ProductPaymentController::class, 'webhook'])->name('product.payment.webhook');

// Email Monitoring Routes (Admin Only)
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/email-monitoring', [App\Http\Controllers\Admin\EmailMonitoringController::class, 'index'])->name('admin.email-monitoring');
    Route::post('/admin/test-product-email/{purchase_id}', [App\Http\Controllers\Admin\EmailMonitoringController::class, 'testEmail'])->name('admin.test-product-email');
    Route::get('/admin/email-logs', [App\Http\Controllers\Admin\EmailMonitoringController::class, 'logs'])->name('admin.email-logs');
});