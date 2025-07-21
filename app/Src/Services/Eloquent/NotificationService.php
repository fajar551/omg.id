<?php

namespace App\Src\Services\Eloquent;

use App\Models\Like;
use App\Models\User;
use App\Src\Base\IBaseService;
use App\Src\Validators\LikeValidator;

class NotificationService implements IBaseService {

    protected $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    public function getNotifications(array $data)
    {
        $model = $this->model->find($data["userid"]);
        $notificationId = $data["notificationId"];
        $data = [];
        $notifications = $model->notifications()
                                ->when($notificationId, function ($query) use ($notificationId) {
                                    return $query->where('id', $notificationId);
                                })
                                ->latest()
                                ->paginate(3);

        $data['meta_data'] = [
            "unread_notification" => $model->unreadNotifications->count(),
            "pagging" => [
                "current_page" => $notifications->currentPage(),
                "last_page" =>  $notifications->lastPage(),
                "per_page" => $notifications->perPage(),
                "total_page" => $notifications->total(),
                "next_page_url" => $notifications->nextPageUrl(),
            ]
        ];

        foreach ($notifications as $notif) {
            $details = [];

            switch ($notif->type) {
                case 'App\Notifications\ResetPasswordNotification':
                    $details = [
                        "id" => $notif->data["id"], 
                        "name" => $notif->data["name"], 
                        "username" => $notif->data["username"], 
                        "email" => $notif->data["email"], 
                        "notify_message" => __('notifications.password_reset'),
                        "notify_url" => $notif->data["reset_link"] ?? null, 
                    ];
                    break;
                case 'App\Notifications\WelcomeEmailNotification':
                    $details = [
                        "id" => $notif->data["id"], 
                        "name" => $notif->data["name"], 
                        "username" => $notif->data["username"], 
                        "email" => $notif->data["email"],
                        "notify_message" => __('notifications.welcome_message', ['app_name' => env('APP_NAME', 'OMG.ID')]),
                        "notify_url" => route('setting.profile.index'),
                    ];
                    break;
                case 'App\Notifications\NewTipNotification':
                    $page_url = null;
                    if (isset($notif->data["new_tip_to"]["id"])) {
                        $user = $this->model->find($notif->data["new_tip_to"]["id"]);
                        $page_url = $user->page->page_url;
                    }

                    $details = [
                        "creator_id" => $notif->user->id,
                        "creator_name" => $creator_name = $notif->data["new_tip_to"]["name"],
                        "supporter_name" => $supporter_name = $notif->data["new_tip"]["name"] ?? "Someone",
                        "supporter_email" => $supporter_email = $notif->data["new_tip"]["email"] ?? "",
                        "supporter_avatar" => $supporter_avatar = $notif->data["new_tip"]["avatar"] ?? null,
                        "support_message" => $support_message = $notif->data["new_tip"]["message"] ?? "",
                        "support_nominal" => $support_nominal = $notif->data["new_tip"]["formated_amount"] ?? "N/A",
                        "order_id" => $order_id = @$notif->data["new_tip"]["order_id"],
                        "notify_message" => __('notifications.support_message', [
                            'supporter' => $supporter_name, 
                            'amount' => $support_nominal,
                            'message' => $support_message,
                            'to' => '',
                        ]),
                        "notify_url" => $order_id && $page_url ? route('support.payment_status', ['page_name' => $page_url, 'orderID' => $order_id]) : null,
                    ];

                    // TODO: Check this
                    $supporter_notify = $notif->data["supporter_notify"] ?? 0;
                    $supporter = $supporter_notify == 1 ? __("page.you") : $supporter_name;
                    if (isset($notif->data["new_tip_to"]["support_type"]) && $notif->data["new_tip_to"]["support_type"] == 1) {
                        $details["notify_message"] = __('notifications.support_message', [
                            'supporter' => $supporter, 
                            'amount' => $support_nominal,
                            'message' => $support_message,
                            'to' => $supporter_notify == 1 ? __("page.to_creator") ." $creator_name" : '',
                        ]);
                    } else if (isset($notif->data["new_tip_to"]["support_type"]) && $notif->data["new_tip_to"]["support_type"] == 2) {
                        $details["notify_message"] = __('notifications.support_content_message', [
                            'supporter' => $supporter, 
                            'amount' => $support_nominal,
                            'message' => $support_message,
                            'to' => $supporter_notify == 1 ? __("page.from") ." $creator_name" : '',
                        ]);
                    }

                    break;
                case 'App\Notifications\PayoutAccountActivationNotification':
                    $notify_message = "Unknown";
                    if ($notif->user->hasRole(['creator'])) {
                        $notify_message = __('notifications.payout_account_activation', ['status' => ucwords($notif->data["status"])]);
                    } else {
                        $notify_message = __("notifications.payout_account_activation_admin", [
                            'name' => $notif->data["name"] ?? "-",
                            'email' => $notif->data["email"] ?? "-",
                        ]);
                    }
                    
                    $details = [
                        "payout_account_id" => @$notif->data["payout_account_id"],
                        "user_id" => @$notif->data["user_id"],
                        "notify_message" => $notify_message,
                        "notify_url" => $notif->user->hasRole(['creator']) ? route('payoutaccount.index') : route('admin.creator.payoutaccount.index'),
                    ];
                    break;
                case 'App\Notifications\PayoutAccountVerifiedNotification':
                    $details = [
                        "payout_account_id" => @$notif->data["payout_account_id"],
                        "user_id" => @$notif->data["user_id"],
                        "notify_message" => __('notifications.payout_account_activation', ['status' => ucwords($notif->data["status"])]),
                        "notify_url" => route('payoutaccount.index') ,
                    ];
                    break;
                case 'App\Notifications\DisbursementNotification':
                    $notify_message = "Unknown";
                    $status = strtolower($notif->data["data"]["status"]);
                    $amount = $notif->data["data"]["amount"];

                    if ($status == 'queued' || $status == "pending" || $status == 'processed') {
                        $notify_message = __('notifications.disbursement_status_process', [
                            'amount' => $amount, 
                            'status' => ucwords($status),
                        ]);
                    } else if($status == 'completed') {
                        $notify_message = __('notifications.disbursement_status_completed', [
                            'amount' => $amount, 
                            'status' => ucwords($status),
                        ]);
                    } else if($status == 'failed') {
                        $notify_message = __('notifications.disbursement_status_failed', [
                            'amount' => $amount, 
                            'status' => ucwords($status),
                        ]);
                    }
                    
                    $details = [
                        "notify_message" => $notify_message,
                        "notify_url" => route('balance.index') ,
                    ];
                    break;
                default:
                    break;
            }

            if ($details) {
                $data['payloads'][] = [
                    "id" => $notif->id,
                    "type" => $notif->type,
                    "formated_type" => $notif->getFormatedType(),
                    "notifiable_id" => $notif->notifiable_id,
                    "has_read" => (bool) $notif->read_at,
                    "read_at" => $notif->read_at,
                    "formated_read_at" => $notif->read_at ? $notif->read_at->diffForHumans() : null,
                    "created_at" =>  $notif->created_at->translatedFormat('l, d-m-Y'),
                    "formated_created_at" => $notif->created_at ? $notif->created_at->diffForHumans() : null,
                    "details" => $details,
                ];
            }
        }

        return $data;
    }

    public function sendNotificationTo($userid, $type = null, $params = [])
    {
        $user = $this->model->find($userid);
        if (!$user) {
            $user = $this->model->where('email', $params['supporter_email'])->first();
        }

        try {
            switch ($type) {
                case 'notify.password_reset':
                    // Handled by laravel system and the params need a token
                    $user->sendPasswordResetNotification($params);
                    break;
                case 'notify.new_tip':
                    $user->sendNewTipNotification($params);
                    break;
                case 'notify.payout_account_activation':
                    $user->sendPayoutAccountActivationNotification($params);
                    break;
                case 'notify.payout_account_verified':
                    $user->sendPayoutAccountVerifiedNotification($params);
                    break;
                case 'notify.disbursement_request':
                    $user->sendDisbursementNotification($params);
                    break;
                default:
                    # code...
                    break;
            }
        } catch (\Exception $ex) {
            activity()
                ->inLog('sendNotificationTo')
                ->performedOn($user)
                ->causedBy($user)
                ->withProperties(['attributes' => [
                    "class" => NotificationService::class,
                    "function" => 'sendNotificationTo',
                    "notify_type" => $type,
                    "error" => $ex->getCode(),
                    "message" => $ex->getMessage(),
                    "trace" => strtok($ex->getTraceAsString(), '#1')
                ]])
                ->log($ex->getMessage());
        }
    }

    public function markNotification(array $data)
    {
        $notificationId = @$data['notificationid'];
        $userid = @$data['userid'];
        $model = $this->model->find($userid);

        $model->unreadNotifications
                ->when($notificationId, function ($query) use ($notificationId) {
                    return $query->where('id', $notificationId);
                })
                ->markAsRead();

        return [
            'unread_notification' => $model->unreadNotifications()->count(),
        ];
    }

    public static function getInstance()
    {
        return new static(new User());
    }

    public function formatResult($model)
    {
        return [];
    }

}