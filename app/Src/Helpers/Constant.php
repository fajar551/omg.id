<?php

namespace App\Src\Helpers;

class Constant {

    const UNKNOWN_STATUS = "Unknown";
    const SEEDER_LIMIT = 50;

    const USER_STATUS = [
        0 => 'Inactive',
        1 => 'Active',
        2 => 'Suspend',
    ];

    const POST_STATUS = [
        0 => 'Draft',
        1 => 'Publish',
    ];

    const CONTENT_STATUS = [
        0 => 'Draft',
        1 => 'Publish',
    ];

    const TEMPLATE_CATEGORY = [
        0 => 'Free',
        1 => 'Premium',
    ];

    const REPORT_STATUS = [
        0 => 'Pending',
        1 => 'Process',
        2 => 'Done',
    ];

    const GOAL_VISIBILITY = [
        1 => 'Public',
        2 => 'Private',
        3 => 'Supporter',
    ];

    const GOAL_TARGET_VISIBILITY = [
        1 => 'Show',
        2 => 'Hide',
    ];

    const GOAL_STATUS = [
        0 => 'Inactive',
        1 => 'Active',
        2 => 'Reached',
    ];

    const GOAL_TYPE = [
        'Donation',
        'Viewer',
        'Like',
        'Subscriber',
        'Other',
    ];

    const PAYOUT_TYPE = [
        1 => 'Ewallet',
        2 => 'Bank'
    ];

    const PAYOUT_ACCOUNT_STATUS = [
        0 => 'Unverified',
        1 => 'Verified',
    ];

    const DEFAULT_TEMPLATE = null;

    const POST_UPLOAD_PATH = "user/posts";

    const PROFILE_UPLOAD_PATH = "user/profiles";
    
    const ITEM_UPLOAD_PATH = "user/items";

    const CONTENT_THUMBNAIL_PATH = "user/contents/thumbnails";

    const CONTENT_COVER_IMAGE_PATH = "user/contents/cover_images";

    const CONTENT_FILE_PATH = "user/contents/files";

    const TEMPLATE_IMAGE_PATH = "user/template/images";

    const PAGE_COVER_PATH = "user/page/cover_image";

    const PAGE_AVATAR_PATH = "user/page/avatar";

    const PAYMENT_METHOD_IMAGE_PATH = "user/payment_method/image";

    const REPORT_SCREENSHOT_PATH = "user/report/screenshot";

    public static function getUserStatus($key = "")
    {
        return self::USER_STATUS[$key] ?? self::UNKNOWN_STATUS;
    }

    public static function getGoalVisibility($key = "")
    {
        return self::GOAL_VISIBILITY[$key] ?? self::UNKNOWN_STATUS;
    }

    public static function getGoalTargetVisibility($key = "")
    {
        return self::GOAL_TARGET_VISIBILITY[$key] ?? self::UNKNOWN_STATUS;
    }

    public static function getGoalStatus($key = "")
    {
        return self::GOAL_STATUS[$key] ?? self::UNKNOWN_STATUS;
    }

    public static function getPostStatus($key = "")
    {
        return self::POST_STATUS[$key] ?? self::UNKNOWN_STATUS;
    }

    public static function getTemplateCategory($key = "")
    {
        return self::TEMPLATE_CATEGORY[$key] ?? self::UNKNOWN_STATUS;
    }
    
    public static function getReportStatus($key = "")
    {
        return self::REPORT_STATUS[$key] ?? self::UNKNOWN_STATUS;
    }

    public static function getPayoutType($key = "")
    {
        return self::PAYOUT_TYPE[$key] ?? self::UNKNOWN_STATUS;
    }

    public static function getPayoutAccountStatus($key = "")
    {
        return self::PAYOUT_ACCOUNT_STATUS[$key] ?? self::UNKNOWN_STATUS;
    }

}
