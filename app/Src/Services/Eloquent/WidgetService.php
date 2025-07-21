<?php

namespace App\Src\Services\Eloquent;

use App\Models\StreamKey;
use App\Models\Support;
use App\Models\User;
use App\Models\UserWidget;
use App\Models\Widget;
use App\Src\Base\IBaseService;
use App\Src\Exceptions\NotFoundException;
use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\Utils;
use App\Src\Services\JCrowe\FilterWord;
use App\Src\Services\Webhook\WebhookService;
use App\Src\Validators\WidgetValidator;
use Carbon\Carbon;
use Str;
use InvalidArgumentException;
use File;

class WidgetService implements IBaseService {

    protected $model;
    protected $validator;
    protected $widgetType = null;
    protected $modelUserWidget;

    public function __construct(Widget $model, WidgetValidator $validator, UserWidget $modelUserWidget) {
        $this->model = $model;
        $this->validator = $validator;
        $this->modelUserWidget = $modelUserWidget;
    }

    public static function getInstance()
    {
        return new static(new Widget(), new WidgetValidator(), new UserWidget());
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function setWidgetType($type)
    {
        $this->widgetType = $type;
    }

    public function getWidgetType()
    {
        if (!$this->widgetType) {
            throw new InvalidArgumentException("Invalid widget type!");
        }

        return $this->widgetType;
    }

    public function store(array $data)
    {
        $this->validator->validateStore($data);
        
        $model = $this->model;
        $model->name = ucwords($data["name"]);
        $model->key = Str::slug($data["key"], '_');
        $model->type = Str::slug(@$data["type"], '_');
        $model->save();

        return $this->formatResult($model);
    }

    public function updateOrCreate(array $data)
    {
        $this->model->updateOrCreate(
            ['key' => $data['key'] ],
            ['name' => $data['name'], 'key' => $data['key'], 'type' => Str::slug($data["type"], '_')]
        );
    }

    public function getAvailableWidgets($type = null)
    {
        if (!$type) {
            $type = $this->getWidgetType();
        }

        $this->validator->validateWidgetType(["type" => $type]);

        $cfgWidgets = config("settings.widget.{$type}");
        $existWidget = $this->model->where("type", $type)->pluck('key')->toArray(); 

        // Check if there's new widget defined from config/settings.php
        foreach ($cfgWidgets as $wKey => $wgt) {
            // If widget not exist in database then create new widgets
            if (!in_array($wKey, $existWidget)) {
                $this->updateOrCreate([
                    'type' => $type,
                    'key' => $wKey,
                    'name' => config("settings.widget_names.{$wKey}"),
                ]);
            }
        }

        // Check if the genrated widget has deleted or removed from config/settings.php
        foreach ($existWidget as $wKey) {
            // If widget not exist in config/settings.php then remove it from database
            if (!array_key_exists($wKey, $cfgWidgets)) {
                $this->model->where("key", $wKey)->delete();
            }
        }

        return $this->model->where("type", $type)->oldest("id")->get()->map(function ($model) {
            return $this->formatResult($model);
        });
    }

    public function getAvailableWidgetsTheme($key = null)
    {
        $this->validator->validateWidgetKey(["key" => $key]);

        $widgetDir = config("view.widget_paths") ."/{$this->getWidgetType()}/$key";
        $availableTheme = [];

        if (File::exists($widgetDir)) {
            foreach (File::allFiles($widgetDir) as $file) {
                $name = explode(".", $file->getFilename())[0];

                if ((Utils::strContains("dev", $name) || !Utils::strContains("dev", $name)) && in_array(config('app.env'), ['local'])) {
                    $availableTheme[] = $name;
                } else if(!Utils::strContains("dev", $name)) {
                    $availableTheme[] = $name;
                }
            }
        }

        return $availableTheme ?: ["default"];
    }

    public function getAvailableNotifSound()
    {
        $soundDir = public_path('assets/audio');
        $availableSound = [];

        if (File::exists($soundDir)) {
            foreach (File::allFiles($soundDir) as $file) {
                $fileName = $file->getFilename();
                $name = explode(".", $fileName)[0];

                $availableSound[] = [
                    'name' => ucwords(str_replace('-', ' ', $name)),
                    'file_name' => $fileName,
                    'file_path' => asset("assets/audio/$fileName"),
                ];
            }
        }

        return $availableSound;
    }

    public function getWidgetWithSettings($key = null, $userid, $settingOnly = false)
    {
        $this->validator->validateWidgetKey(["key" => $key]);

        $model = $this->model->where("key", $key)->first();
    
        if (!$model->settings()->where("user_id", $userid)->count()) {
            $this->seedSetting([
                "user_id" => $userid,
                "key" => $key,
            ]);
        } else {
            $currentSettings = $model->settings()->where("user_id", $userid)->get()->toArray();
            $defaultConfig = config("settings.widget.{$this->getWidgetType()}")[$key];

            foreach ($currentSettings as $setting) {
                if (array_key_exists($setting["name"], $defaultConfig)) {
                    unset($defaultConfig[$setting["name"]]);
                }
            }

            foreach ($defaultConfig as $keyConfig => $value) {
                $this->addSetting([
                    "key" => $key,
                    "user_id" => $userid,
                    "name" => $keyConfig,
                    "value" => $value,
                ]);
            }
        }

        if ($settingOnly) {
            return $model->settings()->where("user_id", $userid)->get()->map(function($model) {
                return $this->formatWidgetSettingResult($model);
            });
        }

        return $this->formatResult($model, true);
    }

    public function generateWidgetUrl($key = null, $userid, $extra = [])
    {
        $settings = $this->getWidgetWithSettings($key, $userid, true);
        $streamKey = StreamKey::firstOrCreate(
            ['user_id' => $userid],
            ['key' => Str::random(40)]
        )->key;

        $params = array_merge([
            "key" => $key,
            "real_data" => true,
            "streamKey" => $streamKey,
        ], $extra);

        foreach ($settings as $key => $setting) {
            $params[$setting["name"]] = $setting["value"];
        }

        return route("api.widget.{$this->getWidgetType()}.preview", $params);
    }

    public function generateStreamKey($userid)
    {
        $key = Str::random(40);
        StreamKey::updateOrCreate(
            ['user_id' => $userid],
            ["key" => $key],
        );

        return $key;
    }

    public function currentStreamKey($userid)
    {
        $streamKey = StreamKey::where('user_id', $userid)->first();
        if (!$streamKey) {
            $key = $this->generateStreamKey($userid);
        } else {
            $key = $streamKey->key;
        }

        return $key;
    }

    public function addSetting(array $data)
    {
        $widget = $this->model->where("key", $data["key"])->first();

        $widget->settings()->where("user_id", $data["user_id"])->updateOrCreate(
            ['name' => $data["name"]],
            [
                "user_id" => $data["user_id"],
                "name" => $data["name"],
                "value" => $data["value"],
                "data_type" => SettingService::getInstance()->castDataType($data["value"]),
            ]
        );

        $this->adduserwidget($widget->id, $data['user_id']);
    }

    public function updateWidgetSetting(array $data)
    {
        $userid = $data["userid"];
        $config = $data["settings"];
        $key = $data["key"];

        $data["config_key"] = array_keys($data["settings"]);
        $data["widget_type"] = $this->getWidgetType();

        $this->validator->validateWidgetUpdate($data);

        $defaultConfig = config("settings.widget.{$this->getWidgetType()}")[$key];

        foreach ($config as $keyConfig => $value) {
            if (array_key_exists($keyConfig, $defaultConfig)) {
                $this->addSetting([
                    "key" => $key,
                    "user_id" => $userid,
                    "name" => $keyConfig,
                    "value" => $value,
                ]);
            } else {
                $this->deleteUnknownSettingName([
                    "user_id" => $userid,
                    "key" => $key,
                    "name" => $keyConfig,
                ]);
            }
        }
    }

    public function adduserwidget(int $widget_id, int $user_id)
    {
        $this->modelUserWidget->updateOrCreate([
            "user_id" => $user_id,
            "widget_id" => $widget_id
        ]);
    }

    public function seedSetting(array $data)
    {
        $settings = config("settings.widget.{$this->getWidgetType()}");
        $userid = @$data["user_id"];

        if ($userid) {
            $key = $data["key"];

            if (array_key_exists($key, $settings)) {
                $config = $settings[$key]; 

                foreach ($config as $keyConfig => $value) {
                    $this->addSetting([
                        "key" => $key,
                        "user_id" => $userid,
                        "name" => $keyConfig,
                        "value" => $value,
                    ]);
                }
            }
        }
    }

    public function deleteUnknownSettingName(array $data) {
        // TODO: Test and check this
        $userid = @$data["user_id"];
        $key = @$data["key"];
        $name = @$data["name"];

        $widget = $this->model->where("key", $key)->first();
        if ($widget) {
            return $widget->settings()->where("user_id", $userid)->where("name", $name)->delete();
        }

        return false;
    }

    public function checkValidStreamKey($streamKey)
    {
        $streamKey = StreamKey::where("key", $streamKey)->first();
        if (!$streamKey) {
            throw new ValidatorException("Invalid stream key!", []);
        }

        return $streamKey;
    }

    public function getWidgetSettingMap($key, $userid)
    {
        $widgetSettings = $this->getWidgetWithSettings($key, $userid, true);
        $mapSetting = $widgetSettings->map(function($item) {
            return [ $item['name'] => $item['value'] ];
        })->toArray();

        $setting = [];
        array_map(function($value) use(&$setting) {
            foreach ($value as $key => $value2) {
                $setting[$key] = [
                    "name" => $key,
                    "value" => $value2,
                ];
            }
        }, $mapSetting);

        return $setting;
    }

    public function widgetShow(array $data)
    {
        $key = $this->checkValidStreamKey($data["streamKey"]);

        $userid = $key->user_id;
        // $widgetSettings = $this->getWidgetWithSettings($data["key"], $userid, true);
        
        $extraData = [];
        $data["test"] = (isset($data["test"]) && (in_array($data["test"], ["1", "true"])));
        $data["real_data"] = (isset($data["real_data"]) && (in_array($data["real_data"], ["1", "true"])));

        // Get profanity setting for bad words filter
        $setting = SettingService::getInstance();
        $customBadWords = [];
        $filterBySystem = $setting->get("profanity_by_system", null, $userid);
        if (!$filterBySystem) {
            $customBadWords = $setting->get("profanity_custom_filter", null, $userid);
            $customBadWords = array_map('trim', explode(";", $customBadWords));
        }

        switch ($data["key"]) {
            case 'lastsupporter':
            case 'mediashare':
            case 'notification':
                $newTip = [];

                // Dummy result for test/preview mode
                // if (!$data["real_data"]) {
                    $newTip = config("settings.default_new_tip");
                // }

                if ($data["real_data"]) {
                    // TODO: add min support from setting to display notification 
                    $supportsQ = Support::select("id", "creator_id", "supporter_id", "invoice_id", "name", "message", "email", "status", "media_share", "created_at")
                                        ->where("creator_id", $userid)
                                        ->paidSuccess()
                                        ->with([
                                            'supporter' => function($q) {
                                                $q->select("id", "name", "username", "email", "profile_picture");
                                            },
                                            'details' => function($q) {
                                                $q->select("id", "support_id", "item_id", "price", "qty", "total");
                                            },
                                            'details.item' => function($q) {
                                                $q->select("id", "name");
                                            },
                                            'invoice' => function($q) {
                                                $q->select("id", "order_id");
                                            },
                                        ])
                                        ->latest()
                                        ->first();

                    if ($supportsQ) {
                        $items = [];
                        $amount = 0;
                        foreach ($supportsQ->details as $key => $detail) {
                            $items[] = [
                                "name" => $detail->item->name ?? "Item",
                                "qty" => $detail->qty,
                                "price" => $detail->price,
                                "total" => $detail->total,
                                "formated_price" => Utils::toIDR($detail->price),
                                "formated_total" => Utils::toIDR($detail->total),
                            ];

                            $amount += $detail->total;
                        }

                        $newTip = [
                            "name" => $supportsQ->name ?? "Someone",
                            "email" => $supportsQ->email ?? "",
                            "invoice_id" => $supportsQ->invoice_id,
                            "order_id" => $supportsQ->invoice->order_id,
                            "avatar" => !empty($supportsQ->supporter->profile_picture) ? route("api.profile.preview", ["file_name" => $supportsQ->supporter->profile_picture]) : null,
                            "message" => !empty($supportsQ->message) ? FilterWord::getInstance()->filter($supportsQ->message, $customBadWords, $filterBySystem) : __("No Message"),
                            "amount" => $amount,
                            "formated_amount" => Utils::toIDR($amount),
                            "items" => $items,
                        ];
                    } else {
                        $newTip["message"] = __("No latest support.");
                    }
                }

                if (!$newTip) {
                    throw new NotFoundException("No New Tip Found", []);
                }

                if ($data["key"] == "notification") {
                    $widgetSettings = $this->getWidgetWithSettings($data["key"], $userid, true);
                    $mapSetting = $widgetSettings->map(function($item) {
                        return [ $item['name'] => $item['value'] ];
                    })->toArray();

                    if (!isset($data["ntf_template_text"])) {
                        $data["ntf_template_text"] = array_column($mapSetting, "ntf_template_text")[0] ?? __("message.default_template_message");
                    }

                    if ($data["ntf_template_text"]) {
                        $templateMessage = str_replace(["{supporter}", "{amount}"], [$newTip["name"], Utils::toIDR($newTip["amount"])], $data["ntf_template_text"]);
                        $newTip["template_text"] = $templateMessage;
                    }

                    if (!$data["test"]) {
                        if (!isset($data["ntf_min_support"])) {
                            $data["ntf_min_support"] = array_column($mapSetting, "ntf_min_support")[0] ?? 0;
                        } 
                        
                        if ($newTip["amount"] < $data["ntf_min_support"]) {
                            return "Support amount less than Min Suppport (no notification send)";
                        }
                    }
                }

                $mediaShare = [];
                // if ($data["key"] == "mediashare") {
                $mdsSetting = $setting->get("media_share", null, $userid);
                if ($mdsSetting) {
                    // Media share status is on
                    if ($mdsSetting->status == 1) {
                        $isMediaAvailable = false;

                        if ($data["test"] && !$data["real_data"]) {
                            $url = $data['yt_url'] ?? 'www.youtube.com/watch?v=T7lnaDyJTs0';
                            $videoId = Utils::getQParamsVal($url, 'v');
                            $startSeconds = $data['start_seconds'] ?? 0;

                            if ($videoId) {
                                $isMediaAvailable = true;
                            }
                        } else if($data["real_data"]) {
                            if ($supportsQ) {
                                $mediaShareData = $supportsQ->media_share;
                                if ($mediaShareData) {
                                    $url = $mediaShareData['url'];
                                    $videoId = Utils::getQParamsVal($url, 'v');
                                    $startSeconds = $mediaShareData['startSeconds'] ?? 0;
    
                                    if ($videoId) {
                                        $isMediaAvailable = true;
                                    }
                                }
                            }
                        }

                        if ($isMediaAvailable) {
                            $maxDuration = $mdsSetting->max_duration; 
                            $pricePerSecond = $mdsSetting->price_per_second;
                            if ($pricePerSecond <= 0) {
                                $pricePerSecond = 1;    // Avoid devide by zero. the price amount should be gt 0
                            }
                        
                            $tipAmount = $newTip['amount'];
                            $maxDurationSupport = $tipAmount / $pricePerSecond;
                            if ($maxDurationSupport <= $maxDuration && $maxDurationSupport > 0) {
                                $maxDuration = $maxDurationSupport;
                            }

                            $endSeconds = $startSeconds + $maxDuration;
                            $mediaShare = [
                                'videoId' => $videoId,
                                'startSeconds' => $startSeconds,
                                'endSeconds' => $endSeconds > 0 ? $endSeconds : 60,
                            ];
                        }
                    }
                }
                // }

                $extraData = [
                    "new_tip" => $newTip,
                    "media_share" => $mediaShare,
                    "userid" => $userid,
                    "channels" => $data["key"],
                    "broadcast_to_supporter" => false,
                ];

                $data = array_merge($data, $extraData);

                // Send notify to creator with notifyData
                if (!isset($data['fetch_only'])) {
                    $creator = User::find($userid);
                    $newTipTo = [
                        "id" => $creator->id,
                        "name" => $creator->name,
                        "username" => $creator->username,
                        "page_url" => $creator->page->page_url,
                        "email" => $creator->email,
                        "support_type" => $data["support_type"] ?? 1,
                    ];

                    $data["new_tip_to"] = $newTipTo;

                    // New tip to
                    NotificationService::getInstance()->sendNotificationTo($userid, 'notify.new_tip', $data);

                    // New tip from
                    // $data["supporter_id"] = 1;  // TODO: Remove this
                    if (isset($data["supporter_id"]) || isset($data["supporter_email"])) {
                        $data["broadcast_to_supporter"] = true;
                        NotificationService::getInstance()->sendNotificationTo($data["supporter_id"] ?? null, 'notify.new_tip', $data);
                    }
                }

                if (!$data["test"] && $data["key"] == "notification") {
                    $webhookData = [
                        "userid" => $userid,
                        "type" => ["discord_webhook", "custom_webhook"],
                        "test" => $data["test"],
                        "new_tip" => $newTip,
                    ];
    
                    WebhookService::getInstance()->send($webhookData);
                }

                return [
                    'payloads' => [
                        "test" => $data["test"],
                        "is_preview" => $data["iframe"] ?? false,
                        "streamKey" => $data["streamKey"],
                        "new_tip" => $data["new_tip"],
                        "media_share" => $data["media_share"],
                    ]
                ];
            case 'leaderboard': 
                $leaderBoards = [];

                $shortBy = "nominal";
                if (isset($data["ldb_sortby"]) && $data["ldb_sortby"] == "nominal") {
                    $shortBy = "nominal";
                } 
                
                if (isset($data["ldb_sortby"]) && $data["ldb_sortby"] == "unit") {
                    $shortBy = "unit";
                }

                // Dummy result for test/preview mode
                if (!$data["real_data"]) {
                    if (isset($data["ldb_support_count"])) {
                        $startPrice = 5000;
                        for ($i=1; $i < $data["ldb_support_count"]; $i++) { 
                            $leaderBoards[] = [
                                "name" => "Someone $i",
                                "amount" => $amount = ($shortBy == "unit" ? $units = rand(1,10) : $startPrice * $i),
                                "formated_amount" => ($shortBy == "unit" ? __("$units Units") : Utils::toIDR($amount)),
                                "message" => __("Good Job!"),
                            ];
                        }
                    }
                }
                
                if ($data["real_data"]) {
                    $supportsQ = Support::select("id", "creator_id", "supporter_id", "name", "message", "email", "status", "created_at")
                                            ->where("creator_id", $userid)
                                            ->paidSuccess()
                                            ->with([
                                                'supporter' => function($q) {
                                                    $q->select("id", "name", "username", "email");
                                                },
                                            ]);
                    
                    if ($shortBy == "nominal") {
                        $supportsQ->withSum('details', 'total');
                    } 
                    
                    if ($shortBy == "unit") {
                        $supportsQ->withCount('details as details_sum_total');
                    }

                    if (isset($data["ldb_support_count"])) {
                        $supportsQ->take($data["ldb_support_count"]);
                    }

                    if (isset($data["ldb_interval"])) {
                        $supportsQ->whereDate('created_at', '>=', now()->subDays($data["ldb_interval"])->setTime(0, 0, 0)->toDateTimeString());
                    }

                    $supportsQ = $supportsQ->get()->toArray();
                    foreach ($supportsQ as $key => $support) {
                        if (!array_key_exists($support["email"], $leaderBoards)) {
                            $leaderBoards[$support["email"]] = [
                                "name" => $support["name"] ?? "Someguy",
                                "amount" => $support["details_sum_total"],
                                "message" => FilterWord::getInstance()->filter($support["message"], $customBadWords, $filterBySystem),
                            ];
                        } else {
                            $leaderBoards[$support["email"]]["amount"] += $support["details_sum_total"];
                        }

                        if($shortBy == "unit") {
                            $leaderBoards[$support["email"]]["formated_amount"] = $leaderBoards[$support["email"]]["amount"] .__(" Units");
                        } else {
                            $leaderBoards[$support["email"]]["formated_amount"] = Utils::toIDR($leaderBoards[$support["email"]]["amount"]);
                        }
                    }

                }

                $leaderBoards = array_values($leaderBoards);
                usort($leaderBoards, function($a, $b) {
                    // TRICK: you could use a > b or a - b or a <=> b for sorting in an ascending order. 
                    // For a descending order just the swap position of a and b
                    return $b['amount'] <=> $a['amount'];
                });

                $extraData = [
                    "top_supporter" => $leaderBoards,
                ];

                $data = array_merge($data, $extraData);

                return [
                    'payloads' => [
                        "test" => $data["test"],
                        "is_preview" => $data["iframe"] ?? false,
                        "real_data" => $data["real_data"],
                        "streamKey" => $data["streamKey"],
                        "leaderboards" => $data["top_supporter"],
                    ]
                ];
            case 'goal':
                $goals = [];
                $user = User::find($userid);
                $creatorLink = $user->page ? $user->page->page_url : $user->username;
                $sortCreatorLink =  request()->getHttpHost() ."/$creatorLink/support";
                $creatorLink = route('support.index', ['page_name' => $creatorLink]);

                // Dummy result for test/preview mode
                // if (!$data["real_data"]) {
                    $goals = [
                        "title" => isset($data["goa_source"]) && $data["goa_source"] == "tip-history" ? ($data["goa_custom_title"] ?? "Example Goal") : "Example Goal",
                        "target" => $target = isset($data["goa_source"]) && $data["goa_source"] == "tip-history" ? ($data["goa_custom_target"] ?? 0) : 0,
                        "target_achieved" => $targetAchieved = 0,
                        "creator_link" => $creatorLink,
                        "short_creator_link" => $sortCreatorLink,
                        "formated_target" => Utils::toIDR($target),
                        "formated_target_achieved" => Utils::toIDR($targetAchieved),
                    ];
                // }

                if ($data["real_data"]) {
                    $goalService = GoalService::getInstance();
                    $goalQ = $goalService->getActiveGoals($userid);

                    if ($goalQ) {
                        $goals = [
                            "title" => $goalQ["title"],
                            "target" => $goalQ["target"],
                            "creator_link" => $creatorLink,
                            "short_creator_link" => $sortCreatorLink,
                        ];

                        $supportsQ = Support::select("id", "creator_id", "supporter_id", "name", "message", "email", "status", "created_at")
                                        ->where("creator_id", $userid)
                                        ->paidSuccess();

                        if (isset($data["goa_source"]) && $data["goa_source"] == "tip-history") {
                            $supportsQ->withSum('invoice', 'creator_amount');
                            if (isset($data["goa_since_date"]) && $data["goa_since_date"]) {
                                $supportsQ->whereDate("created_at", ">=", Carbon::parse($data["goa_since_date"])->format('Y-m-d H:i:s'));
                            }

                            $supportsQ = $supportsQ->get();
                            $targetAchieved = $supportsQ ? array_sum(array_column($supportsQ->toArray(), 'invoice_sum_creator_amount')) : 0;

                            $goals["title"] = $data["goa_custom_title"];
                            $goals["target"] = $data["goa_custom_target"] ?? 0;
                            $goals["target_achieved"] = $targetAchieved;
                            $goals["formated_target"] = Utils::toIDR($goals["target"]);
                            $goals["formated_target_achieved"] = Utils::toIDR($goals["target_achieved"]);
                        }

                        if (isset($data["goa_source"]) && $data["goa_source"] == "active-goal") {
                            $supportsQ->where("goal_id", $goalQ["id"])->withSum('invoice', 'creator_amount');
                            $supportsQ = $supportsQ->get();
                            $targetAchieved = $supportsQ ? array_sum(array_column($supportsQ->toArray(), 'invoice_sum_creator_amount')) : 0;

                            $goals["target_achieved"] = $targetAchieved;
                            $goals["formated_target"] = Utils::toIDR($goals["target"]);
                            $goals["formated_target_achieved"] = Utils::toIDR($goals["target_achieved"]);
                        }

                    } else {
                        $goals["title"] = __("No active goal");
                    }
                }

                $goals['progress'] = 0;
                if (isset($data["goa_show_progress"]) && $data["goa_show_progress"]) {
                    if (isset($goals["target"]) && $goals["target"] > 0) {
                        $goals['progress'] = round( ($goals["target_achieved"] / $goals["target"]) * 100, 2 );
                    }
                }

                if (isset($data["goa_show_target_nominal"]) && !$data["goa_show_target_nominal"]) {
                    // unset($goals["target"]);
                    // unset($goals["formated_target"]);
                }

                if (!isset($data["goa_show_target_nominal"])) {
                    // unset($goals["target"]);
                    // unset($goals["formated_target"]);
                }

                if (isset($data["goa_show_current_nominal"]) && !$data["goa_show_current_nominal"]) {
                    // unset($goals["target_achieved"]);
                    // unset($goals["formated_target_achieved"]);
                }

                if (!isset($data["goa_show_current_nominal"])) {
                    // unset($goals["target_achieved"]);
                    // unset($goals["formated_target_achieved"]);
                }

                if (isset($data["goa_show_link"]) && !$data["goa_show_link"]) {
                    // unset($goals["creator_link"]);
                }
                
                if (!isset($data["goa_show_link"])) {
                    // unset($goals["creator_link"]);
                }

                $extraData = [
                    "goal" => $goals,
                ];

                $data = array_merge($data, $extraData);

                return [
                    'payloads' => [
                        "test" => $data["test"],
                        "is_preview" => $data["iframe"] ?? false,
                        "real_data" => $data["real_data"],
                        "streamKey" => $data["streamKey"],
                        "goal" => $data["goal"],
                    ]
                ];
            case 'marquee':
                $marqueeData = [];

                // Dummy result for test/preview mode
                // if (!$data["real_data"]) {
                    if (isset($data["mrq_item_count"])) {
                        $startPrice = 10000;
                        for ($i=1; $i <= $data["mrq_item_count"]; $i++) { 
                            $message = [];
                            if (isset($data["mrq_show_support_message"]) && $data["mrq_show_support_message"]) {
                                $message["message"] = __("message.default_supporter_test_message");
                            }

                            $marqueeData[] = array_merge($message, [
                                "name" => "Someone $i",
                                "ammount" => $total = ($startPrice * $i),
                                "formated_amount" => Utils::toIDR($total),
                                "items" => [
                                    [
                                        "name" => Utils::toIDR($startPrice),
                                        "qty" => $i,
                                        "price" => $startPrice,
                                        "total" => $total,
                                        "formated_price" => Utils::toIDR($startPrice),
                                        "formated_total" => Utils::toIDR($total),
                                    ],
                                ]
                            ]);
                        }
                    }
                // }

                if ($data["real_data"]) {
                    $supportsQ = Support::select("id", "creator_id", "supporter_id", "name", "message", "email", "status", "created_at")
                                        ->where("creator_id", $userid)
                                        ->paidSuccess()
                                        ->with([
                                            'supporter' => function($q) {
                                                $q->select("id", "name", "username", "email");
                                            },
                                            'details' => function($q) {
                                                $q->select("id", "support_id", "item_id", "price", "qty", "total");
                                            },
                                            'details.item' => function($q) {
                                                $q->select("id", "name");
                                            },
                                        ])
                                        ->latest();

                    if (isset($data["mrq_item_count"])) {
                        $supportsQ->take($data["mrq_item_count"]);
                    }
                    
                    $supportsQ = $supportsQ->get();
                    if ($supportsQ) {
                        $marqueeData = [];
                        foreach ($supportsQ as $support) {
                            $items = [];
                            $amount = 0;
                            foreach ($support->details as $detail) {
                                $items[] = [
                                    "name" => $detail->item->name ?? "Item",
                                    "qty" => $detail->qty,
                                    "price" => $detail->price,
                                    "total" => $detail->total,
                                    "formated_price" => Utils::toIDR($detail->price),
                                    "formated_total" => Utils::toIDR($detail->total),
                                ];

                                $amount += $detail->total;
                            }

                            $message = [];
                            if (isset($data["mrq_show_support_message"]) && $data["mrq_show_support_message"]) {
                                $message["message"] = FilterWord::getInstance()->filter($support->message, $customBadWords, $filterBySystem);
                            }

                            $marqueeData[] = array_merge($message, [
                                "name" => $support->name ?? "Someone",
                                "amount" => $amount,
                                "formated_amount" => Utils::toIDR($amount),
                                "items" => $items,
                            ]);
                        }
                    } else {
                        $marqueeData = [];
                    }
                }

                $widgetSettings = $this->getWidgetWithSettings($data["key"], $userid, true);
                $mapSetting = $widgetSettings->map(function($item) {
                    return [ $item['name'] => $item['value'] ];
                })->toArray();

                // Get uptodate data from db for additional messages
                $mrqMessages = array_column($mapSetting, "mrq_messages")[0] ?? [];
                $mrqMessages = $mrqMessages ? array_slice(explode(";", $mrqMessages), 0, 5, true) : [];

                $extraData = [
                    "marquee" => $marqueeData,
                    "additional_message" => $mrqMessages,
                ];

                $data = array_merge($data, $extraData);

                return [
                    'payloads' => [
                        "test" => $data["test"],
                        "is_preview" => $data["iframe"] ?? false,
                        "real_data" => $data["real_data"],
                        "streamKey" => $data["streamKey"],
                        "marquee" => $data["marquee"],
                        "additional_message" => $data["additional_message"],
                    ]
                ];
            default:
                # code...
                break;
        }
    }

    public function formatResult($model, $includeSetting = false)
    {
        $result = [
            "id" => $model->id,
            "name" => $model->name,
            "key" => $model->key,
        ];

        if ($includeSetting) {
            $result["settings"] = $model->settings()->get()->map(function($model) {
                return $this->formatWidgetSettingResult($model);
            });
        }

        return $result;
    }

    public function formatWidgetSettingResult($model)
    {
        return [
            "id" => $model->id,
            "name" => $model->name,
            "value" => $model->value,
        ];
    }

}