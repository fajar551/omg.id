<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Src\Services\Auth\AuthService;
use App\Src\Services\Eloquent\ContentSubscribeService;
use App\Src\Services\Eloquent\ItemService;
use App\Src\Services\Eloquent\PageService;
use App\Src\Services\Eloquent\UserBalanceService;
use App\Src\Services\Eloquent\WidgetService;
use Str;

class OnUserVerified
{

    protected $authServices; 
    protected $userBalanceService;
    protected $pageService;
    protected $itemService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AuthService $authServices, UserBalanceService $userBalanceService, PageService $pageService, ItemService $itemService)
    {
        $this->authServices = $authServices;
        $this->userBalanceService = $userBalanceService;
        $this->pageService = $pageService;
        $this->itemService = $itemService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $user = $event->user;
        $userid = $user->id;

        // Set/Initialize the user creator role
        $user->syncRoles(['creator']);

        // Set creator account to 1=active
        try {
            $this->authServices->changeStatus([
                'status' => 1, 
                'user_id' => $userid,
            ]);
        } catch (\Throwable $ex) {
            activity()
            ->inLog('Error Change Status onUserVerified')
			->withProperties(['attributes' => [
                "class" => AuthService::class,
                "Function" => 'changeStatus',
                "error" => $ex->getCode(),
				"message" => $ex->getMessage(),
                "trace" => strtok($ex->getTraceAsString(), '#1')
				]])
				->log($ex->getMessage());
        }

        // Set/Initialize creator balance
        try {
            $this->userBalanceService->create($userid);
        } catch (\Throwable $ex) {
            activity()
            ->inLog('Error Create user balance onUserVerified')
			->withProperties(['attributes' => [
                "class" => UserBalanceService::class,
                "Function" => 'create',
                "error" => $ex->getCode(),
				"message" => $ex->getMessage(),
                "trace" => strtok($ex->getTraceAsString(), '#1')
				]])
				->log($ex->getMessage());
        }
        
        // Set/Initialize creator default page
        try {
            $this->pageService->store([
                'name' => $user->name,
                'user_id' => $userid, 
                'page_url' => Str::slug($user->username, "-"),
                'status' => 1,
                'page_message' => __("message.default_page_message"),
            ]);
        } catch (\Throwable $ex) {
            activity()
            ->inLog('Error Create Page onUserVerified')
			->withProperties(['attributes' => [
                "class" => PageService::class,
                "Function" => 'store',
                "error" => $ex->getCode(),
				"message" => $ex->getMessage(),
                "trace" => strtok($ex->getTraceAsString(), '#1')
				]])
				->log($ex->getMessage());
        }

        // Set/Initialize creator default item
        try {
            $this->itemService->setCreatorDefaultItem($userid);
        } catch (\Throwable $ex) {
            activity()
            ->inLog('Error Set Item Default Creator onUserVerified')
			->withProperties(['attributes' => [
                "class" => ItemService::class,
                "Function" => 'setCreatorDefaultItem',
                "error" => $ex->getCode(),
				"message" => $ex->getMessage(),
                "trace" => strtok($ex->getTraceAsString(), '#1')
				]])
				->log($ex->getMessage());
        }

        // Send welcome email to new creator
            $user->sendWelcomeEmailNotification();


        // Check Content Subscribe by Email for update user_id
        try {
            ContentSubscribeService::getInstance()->checkEmailGuest($user->email, $user->id);
        } catch (\Throwable $ex) {
            activity()
            ->inLog('Error Update user_id on email guest content subscribe')
			->withProperties(['attributes' => [
                "class" => ContentSubscribeService::class,
                "Function" => 'checkEmailGuest',
                "error" => $ex->getCode(),
				"message" => $ex->getMessage(),
                "trace" => strtok($ex->getTraceAsString(), '#1')
				]])
				->log($ex->getMessage());
        }

        // Generate stream key for user
        try {
            // if (!$user->streamKey) {
                WidgetService::getInstance()->generateStreamKey($userid);
            // }
        } catch (\Throwable $ex) {
            activity()
            ->inLog('Error generate stream key onUserVerified')
			->withProperties(['attributes' => [
                "class" => WidgetService::class,
                "Function" => 'generateStreamKey',
                "error" => $ex->getCode(),
                "message" => $ex->getMessage(),
                "trace" => strtok($ex->getTraceAsString(), '#1')
            ]])
            ->log($ex->getMessage());
        }

        // TODO: Next Set/Initialize other creator data
    }
}
