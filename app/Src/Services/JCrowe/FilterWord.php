<?php

namespace App\Src\Services\JCrowe;

use JCrowe\BadWordFilter\BadWordFilter;

class FilterWord {

    protected $options;

    public function __construct() {
        $this->options = [
            'source' => 'array', 
            'bad_words_array' => config("profanity.defaults"),
            'also_check' => [],
        ];
    }

    public static function getInstance()
    {
        return new static();
    }

    public function filter($string = "", $customBadWords = [], $filterBySystem = false)
    {
        if ($filterBySystem) {
            $this->options["bad_words_array"] = config("profanity.banned");
        }

        if (!$filterBySystem && $customBadWords) {
            $this->options["also_check"] = $customBadWords;
        }
        
        $filter = new BadWordFilter($this->options);
        $cleanString = $filter->clean($string);

        return $cleanString;
    }

}