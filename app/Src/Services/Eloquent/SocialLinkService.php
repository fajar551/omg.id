<?php

namespace App\Src\Services\Eloquent;

use App\Models\SocialLink;
use App\Src\Validators\SocialLinkValidator;
use Str;

class SocialLinkService {

    protected $model;
    protected $validator;
    protected $defaultSocialLink = [
        "facebook" => null,
        "instagram" => null,
        "twitter" => null,
        "youtube" => null,
        "tiktok" => null,
    ];

    public function __construct(SocialLink $model, SocialLinkValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new SocialLink(), new SocialLinkValidator());
    }

    public function store(array $data)
    {
        $this->validator->validateStore($data);
 
        $socials = $data["socials"];
        $userid = $data["user_id"];

        foreach ($socials as $name => $pageUrl) {
            if (in_array($name, array_keys($this->defaultSocialLink))) {
                $this->model->updateOrCreate(
                    ['user_id' => $userid, 'name' => $name],
                    ['name' => $name, 'page_url' => $pageUrl]
                );
            } else {
                $this->deleteSocialLink($userid, $name);
            }
        }

        $links = $this->model->where("user_id", $userid)->get()->map(function($model) {
            return $this->formatResult($model);
        });

        $socialLinks = [];
        foreach ($links as $link) {
            $socialLinks[$link["name"]] = $link["page_url"];
        }

        $result["social_links"] = $socialLinks;
        
        return $result;
    }

    public function getSocialLink($userid)
    {
        $this->validator->validateUserId($userid);

        $links = $this->model->where("user_id", $userid)->get()->map(function($model) {
            return $this->formatResult($model);
        });

        $socialLinks = [];
        foreach ($links as $link) {
            $name = $link["name"];
            if (in_array($name, array_keys($this->defaultSocialLink))) {
                $socialLinks[$name] = $link["page_url"];
            } else {
                $this->deleteSocialLink($userid, $name);
            }
        }

        foreach ($this->defaultSocialLink as $name => $value) {
            if (!in_array($name, array_keys($socialLinks))) {
                $socialLinks[$name] = $value;
            }
        }

        $result["social_links"] = $socialLinks ?: $this->defaultSocialLink;

        return $result;
    }

    public function deleteSocialLink($userid, $name)
    {
        $this->model->where("user_id", $userid)->where("name", $name)->delete();
    }

    public function formatResult($model)
    {
        return [
            "id" => $model->id,
            "name" => $model->name,
            "page_url" => $model->page_url,
            "created_at" => $model->created_at->format("d-m-Y H:i"),
            "updated_at" => $model->updated_at->format("d-m-Y H:i"),
        ];
    }

}