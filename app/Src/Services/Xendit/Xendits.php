<?php

namespace App\Src\Services\Xendit;

use Xendit\Xendit;

class Xendits
{
    protected $secretapikey;

    public function __construct()
    {
        $this->secretapikey = config('xendit.secret_api_key');

        $this->_configureXendit();
    }

    public function _configureXendit()
    {
        Xendit::setApiKey($this->secretapikey);
    }
}
