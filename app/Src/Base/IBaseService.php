<?php

namespace App\Src\Base;

interface IBaseService
{
    /**
     * Get formated or customize result from a model.
     *
     * @return array
     */
    public function formatResult($model);
    
    /**
     * Get the instance of class.
     *
     * @return object
     */
    public static function getInstance();

}
