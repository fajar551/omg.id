<?php

namespace App\Src\Helpers;

use App\Src\Services\Eloquent\SettingService;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Auth;

class Utils
{

    public static function findArrayKeyWithPattern($pattern, $array)
    {
        $keys = array_keys($array);
        $matches = array_values(preg_grep($pattern, $keys));

        return $matches[0] ?? null;
    }

    public static function humanReadableSize(int $sizeInBytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        if ($sizeInBytes === 0) {
            return '0 ' . $units[1];
        }
        for ($i = 0; $sizeInBytes > 1024; $i++) {
            $sizeInBytes /= 1024;
        }

        return round($sizeInBytes, 2) . ' ' . $units[$i];
    }

    public static function toIDR($number)
    {
        return "Rp" . number_format(round($number), 0, null, ".");
    }

    /**
     * Converts a number into a short version, eg: 1000 -> 1k
     * Based on: http://stackoverflow.com/a/4371114
     * Source: https://gist.github.com/RadGH/84edff0cc81e6326029c
     * 
     * @param int $n
     * @return int $precision
     */
    public static function kNFormatter( $n, $precision = 1 ) {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K+';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M+';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B+';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T+';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }

        return $n_format . $suffix;
    }
	
    public static function defaultDateFormat($jsFormat = false)
    {
        return $jsFormat ? "dd-mm-yyyy" : "d-m-Y";
    }

    public static function formatDate($date, $useTime = false)
    {
        return $date ? Carbon::parse($date)->format($useTime ? self::defaultDateTimeFormat() : self::defaultDateFormat()) : null;
    }

    public static function defaultDateTimeFormat($jsFormat = false)
    {
        return $jsFormat ? "dd-mm-yyyy hh:mm:ss" : "d-m-Y H:i:s";
    }

    public static function mysqlDateFormat($useTime = false)
    {
        return $useTime ? "Y-m-d H:i:s" : "Y-m-d";
    }

    public static function diffDateForHumans($start, $end)
    {
        if (!($start instanceof Carbon)) {
            $start = Carbon::parse($start);
        }

        if (!($end instanceof Carbon)) {
            $end = Carbon::parse($end);
        }

        return $start->diffForHumans($end, [
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
            'parts' => 2,
            'join' => true,
            'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS,
        ]);
    }

    public static function getLabelForStatus($status = Constant::UNKNOWN_STATUS)
    {
        switch (strtolower($status)) {
            case 'inactive':
            case 'private':
                return '<span class="badge badge-pill bg-danger">' . strtoupper($status) . '</span>';
            case 'process':
            case 'active':
            case 'public':
            case 'publish':
            case 'free':
                return '<span class="badge badge-pill bg-success text-white">' . strtoupper($status) . '</span>';
            case 'suspend':
            case 'draft':
            case 'pending':
                return '<span class="badge badge-pill bg-warning">' . strtoupper($status) . '</span>';
            case 'reached':
            case 'done':
                return '<span class="badge badge-pill bg-primary">' . strtoupper($status) . '</span>';
            case 'premium':
            case 'supporter':
                return '<span class="badge badge-pill bg-secondary">' . strtoupper($status) . '</span>';
            default:
                return '<span class="badge badge-pill bg-primary">' . strtoupper($status) . '</span>';
        }
    }

    public static function getActionFor($action, $route = null, $event = '', $dataAttr = [], $customClass = [])
    {
        if ($dataAttr) {
            array_map(function ($key) use (&$dataAttr) {
                $dataAttr[$key] = " data-$key=\"{$dataAttr[$key]}\" ";
            }, array_keys($dataAttr));
        }

        $dataAttr = implode(" ", $dataAttr);
        $customClass = implode(" ", $customClass);
        $route =  $route ?? 'javascript:void(0)';

        switch (strtolower($action)) {
            case 'view':
            case 'show':
            case 'detail':
                // return '<a href="' .($route ?? 'javascript:void(0);') .'" class="m-1" style="font-size: 1.2rem;" ' .$event .$dataAttr .' data-bs-toggle="tooltip" data-bs-placement="top" title="View" data-bs-original-title="View"><i class="ri-eye-fill" style="color: black;"></i></a>';
                return "<a href=\"$route\" class=\"m-1 $customClass\" style=\"font-size: 1.2rem;\" $event $dataAttr data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"View\" data-bs-original-title=\"View\"><i class=\"ri-eye-fill\"></i></a>";
            case 'edit':
            case 'update':
                // return '<a href="' .($route ?? 'javascript:void(0);') .'" class="m-1" style="font-size: 1.2rem;" ' .$event .$dataAttr .' data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-bs-original-title="Edit"><i class="ri-edit-2-fill" style="color: black;"></i></a>';
                return "<a href=\"$route\" class=\"m-1 $customClass\" style=\"font-size: 1.2rem;\" $event $dataAttr data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Edit\" data-bs-original-title=\"Edit\"><i class=\"ri-edit-2-fill\"></i></a>";
            case 'delete':
            case 'remove':
                // return '<a href="' .($route ?? 'javascript:void(0);') .'" class="m-1" style="font-size: 1.2rem;" ' .$event .$dataAttr .' data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-bs-original-title="Delete"><i class="ri-delete-bin-line" style="color: black;"></i></a>';
                return "<a href=\"$route\" class=\"m-1 $customClass\" style=\"font-size: 1.2rem;\" $event $dataAttr data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Delete\" data-bs-original-title=\"Delete\"><i class=\"ri-delete-bin-line\"></i></a>";
            default:
                return '';
        }
    }

    // returns true if $needle is a substring of $haystack
    public static function strContains($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
    }

    public static function getQParamsVal($url, $key = null)
    {
        try {
            $url_components = parse_url($url);
            parse_str($url_components['query'], $params);

            return $key ? $params[$key] : $params;
        } catch (\Throwable $th) {
            //throw $th;
        }

        return null;
    }

    public static function activityLog($logName = 'default', $description = 'Activity Log', $params = [])
    {
        activity()
            ->inLog($logName)
            ->withProperties(['attributes' => $params])
            ->log($description);
    }

    public static function in_array_multidim($needle, array $heyStack, $key)
    {
        return in_array($needle, array_column($heyStack, $key));
    }

    /**
     * Check if previous route name is equal to a given route name.
     *
     * @param string $routeName
     * @return boolean
     */
    public static function wherePreviousRouteName(string $routeName)
    {
        return self::previousRouteName() === $routeName;
    }

    /**
     * Check if previous route name is equal to a given route name.
     *
     * @param array $routeName
     * @return boolean
     */
    public static function wherePreviousRouteNameIn(array $routeNames)
    {
        return in_array(self::previousRouteName(), $routeNames);
    }

    /**
     * Return whether previous route name is equal to a given route name.
     *
     * @return string
     */
    public static function previousRouteName()
    {
        $previousRouteName = '';
        try {
            $url = url()->previous();
            $previousRouteName = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        } catch (\Throwable $th) {
            // Exception is thrown if no mathing route found.
            // This will happen for example when comming from outside of this app.
        }

        return $previousRouteName;
    }

    public static function getGuide()
    {
        $cek = SettingService::getInstance()->getMultiple(['navbar_guide', 'dashboard_guide', 'goal_guide', 'item_guide', 'overlay_guide', 'balance_guide', 'content_guide', 'page_guide', 'navsupporter_guide', 'contentsubs_guide', 'support_guide', 'following_guide'],  Auth::user()->id);
        
        return json_encode($cek, TRUE);
    }

    public static function updateGuide($route, $user_id)
    {
        $cek = SettingService::getInstance()->getMultiple(['navbar_guide', 'dashboard_guide', 'goal_guide', 'item_guide', 'overlay_guide', 'balance_guide', 'content_guide', 'page_guide', 'navsupporter_guide', 'contentsubs_guide', 'support_guide', 'following_guide'],  $user_id);

        if ($route == "home") {
            if ($cek['dashboard_guide'] == 0) {
                SettingService::getInstance()->set('dashboard_guide', 1, 0, $user_id);
            }
        }

        if ($route == "goal.mygoal.index") {
            if ($cek['goal_guide'] == 0) {
                SettingService::getInstance()->set('goal_guide', 1, 0, $user_id);
            }
        }

        if ($route == "item.index") {
            if ($cek['item_guide'] == 0) {
                SettingService::getInstance()->set('item_guide', 1, 0, $user_id);
            }
        }

        if ($route == "overlay.index") {
            if ($cek['overlay_guide'] == 0) {
                SettingService::getInstance()->set('overlay_guide', 1, 0, $user_id);
            }
        }

        if ($route == "balance.index") {
            if ($cek['balance_guide'] == 0) {
                SettingService::getInstance()->set('balance_guide', 1, 0, $user_id);
            }
        }
        if ($route == "content.index") {
            if ($cek['content_guide'] == 0) {
                SettingService::getInstance()->set('content_guide', 1, 0, $user_id);
            }
        }

        if ($route == "page.index") {
            if ($cek['page_guide'] == 0) {
                SettingService::getInstance()->set('page_guide', 1, 0, $user_id);
            }
        }

        if ($cek['navbar_guide'] == 0) {
            SettingService::getInstance()->set('navbar_guide', 1, 0, $user_id);
        }

        if ($route == "supporter.subscribedcontent" || $route == "supporter.supporthistory" || $route == "supporter.followedcreator") {
            if ($cek['navsupporter_guide'] == 0) {
                SettingService::getInstance()->set('navsupporter_guide', 1, 0, $user_id);
            }
        }

        if ($route == "supporter.subscribedcontent") {
            if ($cek['contentsubs_guide'] == 0) {
                SettingService::getInstance()->set('contentsubs_guide', 1, 0, $user_id);
            }
        }
        
        if ($route == "supporter.supporthistory") {
            if ($cek['support_guide'] == 0) {
                SettingService::getInstance()->set('support_guide', 1, 0, $user_id);
            }
        }
        
        if ($route == "supporter.followedcreator") {
            if ($cek['following_guide'] == 0) {
                SettingService::getInstance()->set('following_guide', 1, 0, $user_id);
            }
        }

    }
}
