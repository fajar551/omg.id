<?php

namespace App\Src\Services\Webhook;

use App\Models\User;
use App\Src\Exceptions\NotFoundException;
use App\Src\Helpers\StatusCode;
use App\Src\Helpers\Utils;
use App\Src\Services\Eloquent\SettingService;
use App\Src\Validators\WebhookValidator;
use Exception;
use Illuminate\Support\Facades\Http;

class WebhookService {

    protected $validator;

    public function __construct(WebhookValidator $validator) {
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new WebhookValidator());
    }

    public function send(array $data)
    {
        if (isset($data["type"]) && is_array($data["type"])) {
            $settingKeys = $data["type"];
        } else {
            $settingKeys = ["{$data["type"]}_webhook"];
        }

        $this->validator->validateWebhook(
            array_merge($data, ["type" => $settingKeys])
        );

        $result = [];
        $user = User::find($data["userid"]);
        $data["page_name"] = $user->page ? $user->page->page_url : $user->username;

        $settingService = SettingService::getInstance();
        foreach ($settingKeys as $name) {
            $webhookSettings = $settingService->get($name, null, $data["userid"]);
            $status = $webhookSettings->status ?? null;
            $type = explode("_", $name)[0];

            if (!$status) {
                $result[] = "$type webhook not activated or not configure properly.";
                continue;
            }

            $templateMessage = $webhookSettings->template_message ?? null;
            if ($templateMessage) {
                $data["template_message"] = $templateMessage;
            }
            
            $url = $webhookSettings->url ?? null;
            if ($url) {
                $data["webhook_url"] = $url;
                $result[] = $this->sendWebhook($type, $data);
            }
        }

        return $result;
    }

    private function sendWebhook($type, $data)
    {
        $test = (isset($data["test"]) && $data["test"]) || (isset($data["real_data"]) && !$data["real_data"]);
        $newtip = @$data["new_tip"];
        if (!$newtip) {
            throw new NotFoundException("No New Tip Found", []);
        }

        $templateMessage = $data["template_message"] ?? __("message.default_template_message");
        $templateMessage = str_replace(["{supporter}", "{amount}"], [$newtip["name"], Utils::toIDR($newtip["amount"])], $templateMessage);

        $hookPayloads = [
            "webhook_url" => $data["webhook_url"],
            "title" => ($test ? "[TEST] " : "") . __("message.new_tip_from", ["supporter" => $newtip["name"] ]),
            "subtitle" => __("message.support_page_message"),            
            "description" => $templateMessage,
            "message" => "Pesan: {$newtip["message"]}",
            "url" => request()->root() ."/{$data["page_name"]}",
        ];

        switch ($type) {
            case 'discord':
                try {
                    $discordPayloads = [
                        'content' => $hookPayloads["title"],
                        'embeds' => [
                            [
                                'title' => $hookPayloads["subtitle"],
                                'description' => substr($hookPayloads["description"], 0, 2000),
                                'url' => $hookPayloads["url"],
                                'color' => hexdec('2ecc71'),    
                                'footer' => [
                                    'text' => $hookPayloads["message"],
                                ],
                            ]
                        ],
                    ];

                    $res = Http::post($hookPayloads["webhook_url"], $discordPayloads);

                    if ($res->getStatusCode() == 404) {
                        throw new NotFoundException("Webhook URL Not Found", []);
                    }

                    return json_decode($res) ? json_decode($res) : ["message" => StatusCode::getMessageForCode($res->getStatusCode())];
                } catch (\Throwable $th) {
                    return ["message" => "Discord Webhook Error: " .$th->getMessage()];
                }

                break;
            case 'custom':
                try {
                    $customPayloads = [
                        'title' => $hookPayloads["title"],
                        'subtitle' => $hookPayloads["subtitle"],
                        'description' => substr($hookPayloads["description"], 0, 2000),
                        'url' => $hookPayloads["url"],
                        'message' => $hookPayloads["message"],
                    ];
                    
                    $res = Http::post($hookPayloads["webhook_url"], $customPayloads);

                    if ($res->getStatusCode() == 404) {
                        throw new NotFoundException("Webhook URL Not Found", []);
                    }
                    
                    if ($res->getReasonPhrase() != "OK") {
                        throw new Exception($res->getReasonPhrase());
                    }

                    return json_decode($res) ? json_decode($res) : ["message" => StatusCode::getMessageForCode($res->getStatusCode())];
                } catch (\Throwable $th) {
                    return ["message" => "Custom Webhook Error: " .$th->getMessage()];
                }

                break;
            default:
                # code...
                break;
        }
    }



}