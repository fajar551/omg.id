<?php

namespace App\Src\Helpers;

class UploadPath
{
    /**
     * Get the content upload path.
     * 
     * @param string $key
     * @return string
     */
	public static function content(string $key)
	{
		return "uploads/content/$key";
	}

}
