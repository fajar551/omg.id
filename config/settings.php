<?php

use App\Src\Helpers\Utils;

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration for App
    |--------------------------------------------------------------------------
    |
    | Default setting value and setting key for this app
    |
    */

    'widget' => [
        'overlay' => [
            'notification' => [
                'ntf_theme' => 'default',                // simple, clasic, modern 

                // Color palete for theme 1 / default
                'ntf_t1_color_1' => '',
                'ntf_t1_color_2' => '',
                'ntf_t1_color_3' => '',

                'ntf_font' => 'Ubuntu',
                'ntf_direction' => 'right',             // right, left, top, bottom            
                'ntf_mute' => 0,
                'ntf_sound' => '',
                'ntf_duration' => 10,                    // 1 - 30 in secconds
                'ntf_min_support' => 0,
                'ntf_template_text' => 'OMG...!! {supporter} memberimu dukungan sebesar {amount}',
                'ntf_animation' => 'animate__tada',            
            ],
            'leaderboard' => [
                'ldb_theme' => 'default',                // simple, clasic, modern 

                // Color palete for theme 1 / default
                'ldb_t1_color_1' => '',         // Header
                'ldb_t1_color_2' => '',         // List
                'ldb_t1_color_3' => '',         // Border List
                'ldb_t1_color_4' => '',         // Text Header
                'ldb_t1_color_5' => '',         // Text List
                
                'ldb_font' => 'Ubuntu',
                'ldb_sortby' => 'nominal',              // unit, nominal
                'ldb_support_count' => 3,               // 1 - 10 in numeric
                'ldb_interval' => 5,                    // 1 - 90 in days
                'ldb_title' => 'Leaderboard',
                'ldb_subtitle' => 'Top Supporter',
                'ldb_show_nominal' => 1,
            ],
            'mediashare' => [
                'mds_theme' => 'default',               // default, simple, clasic, modern, etc 

                // Color palete for theme 1 / default
                'mds_t1_color_1' => '',          // Body
                'mds_t1_color_2' => '',          // Footer
                'mds_t1_color_3' => '',          // Text Footer
                'mds_t1_color_4' => '',          // Progress
                
                'mds_font' => 'Ubuntu',
                'mds_template_text' => 'Baru saja mendukungmu sebesar',
                'mds_show_support_message' => 1,
                'mds_show_footer' => 1,
            ],
            'lastsupporter' => [
                'lst_theme' => 'default',           // default, simple, clasic, modern, etc 
                
                // Color palete for theme 2 / default
                'lst_t1_color_1' => '',             // Body
                'lst_t1_color_2' => '',             // Footer
                'lst_t1_color_3' => '',             // Text Body
                'lst_t1_color_4' => '',             // Text Footer

                // Color palete for theme 2 / simple
                'lst_t2_color_1' => '',          // Body
                'lst_t2_color_2' => '',          // Footer
                'lst_t2_color_3' => '',          // Text Body
                'lst_t2_color_4' => '',          // Text Footer
                
                // Color palete for theme 3 / card flip
                'lst_t3_color_1' => '',          // Front Body
                'lst_t3_color_2' => '',          // Back Body
                'lst_t3_color_3' => '',          // Text Front Body
                'lst_t3_color_4' => '',          // Text Back Body

                'lst_font' => 'Ubuntu',
                'lst_support_message' => 1,
                'lst_marquee' => 1,
                'lst_flip_type' => 'horizontal',        // rotateX(180deg)/Horizontal, rotateY(180deg)/Vertical
            ],
            'goal' => [
                'goa_theme' => 'default',                // default, simple, clasic, modern, etc 
                
                // Color palete for theme 1 / default
                'goa_t1_color_1' => '',          // Body
                'goa_t1_color_2' => '',          // Footer
                'goa_t1_color_3' => '',          // Text
                'goa_t1_color_4' => '',          // Progress

                // Color palete for theme 2 / Simple
                'goa_t2_color_1' => '',          // Body
                'goa_t2_color_2' => '',          // Shadow
                'goa_t2_color_3' => '',          // Text
                'goa_t2_color_4' => '',          // Progress
                
                // Color palete for theme 3 / Pill
                'goa_t3_color_1' => '',          // Body
                'goa_t3_color_2' => '',          // Shadow
                'goa_t3_color_3' => '',          // Text
                'goa_t3_color_4' => '',          // Progress
                
                'goa_font' => 'Ubuntu',
                'goa_source' => 'tip-history',          // active-goal, tip-history
                'goa_custom_title' => 'Example Goal',
                'goa_show_link' => 1,
                'goa_since_date' => date("Y-m-d"),
                'goa_custom_target' => 0,
                'goa_show_current_nominal' => 1,
                'goa_show_target_nominal' => 1,
                'goa_show_progress' => 1,
                'goa_show_border' => 1,
                'goa_show_shadow' => 1,
            ],
            'marquee' => [
                'mrq_theme' => 'default',                // default, simple, clasic, modern, etc 

                // Color palete for theme 1 / default
                'mrq_t1_color_1' => '',             // Label
                'mrq_t1_color_2' => '',             // Body
                'mrq_t1_color_3' => '',             // Text Label 
                'mrq_t1_color_4' => '',             // Text body
                
                // Color palete for theme 2 / simple
                'mrq_t2_color_1' => '',             // Body
                'mrq_t2_color_2' => '',             // Shadow / Border
                'mrq_t2_color_3' => '',             // Text body
                
                'mrq_font'    => 'Ubuntu',
                'mrq_item_count' => 3,                  // 1 - 10 
                'mrq_messages' => 'Dukung saya di OMG!;' .config('app.url'),    // separator by ; 
                // 'mrq_type' => 'latest-tips',         // latest-tips, top-supporters
                'mrq_interval' => 3,                    // 1 - 90 in days
                'mrq_show_support_message' => 1, 
                'mrq_separator_type' => 'dot',          // dot, icon
                'mrq_speed' => 'normal',                // slow, normal, fast
                'mrq_txtshadow' => 0,
                'mrq_txt_label' => 'OMG.ID',
                'mrq_show_label' => 1,
                'mrq_type' => 'marquee',                // horizontal/vertical/marquee/typewriter
            ],
            'qrcode' => [
                'qrc_theme' => 'default',                // simple, clasic, modern, etc 
                'qrc_font' => 'Ubuntu',                 
                'qrc_style' => 'square',                // dots, rounded, classy, classy-rounded, square, extra-rounded 

                // Color palete for theme 1 / Default
                'qrc_t1_color_1' => '',             // Card
                'qrc_t1_color_2' => '',             // Border
                'qrc_t1_color_3' => '',             // Pattern
                'qrc_t1_color_4' => '',             // Text
                
                'qrc_top_label' => '', 
                'qrc_bottom_label' => 'Dukung saya di OMG.ID',
                'qrc_target_page' => 'simple',          // simple, full
                'qrc_show_border' => false,
            ],
        ],
        'web_embed' => [
            'custom_button' => [
                'csb_text' => 'Support Me on OMG!', 
                'csb_color_1' => '#BE1E2D',
                'csb_font' => 'default',
                'csb_logo' => 'default',                // default, or active units            
                'csb_btn_size' => 35,                   // 12 - 50 in px 
                'csb_font_size' => 14,                  // 8 - 100 in px, pt 
                'csb_target_page' => 'simple',          // simple, full
            ],
            'static_button' => [
                'stb_theme' => 'default',               // btn-text-1, btn-text-2, btn-text-3, icon-only-rounded, icon-only-circle,, icon-only-square, etc 
                'stb_btn_color' => 'red',               // red, green, blue, green, grey, black, pink, yellow, orange
                'stb_btn_size' => 35,                   // 12 - 50 in px 
                'stb_font_size' => 14,                  // 8 - 100 in px, pt 
                'stb_target_page' => 'simple',          // simple, full
            ],
        ],
    ],

    'widget_names' => [
        'notification' => 'Notification',
        'leaderboard' => 'Leaderboard',
        'mediashare' => 'Media Share',
        'lastsupporter' => 'Last Supporter',
        'goal' => 'Target / Goal',
        'marquee' => 'Running Text',
        'qrcode' => 'QR Code',
        'custom_button' => 'Custom Button',
        'static_button' => 'Static Button',
    ],

    'widget_options' => [
        'notification' => [
            'ntf_theme' => [
                'rules' => 'required|string',   // |in:default,simple,clasic,modern
                'messages' => [],
            ],
            'ntf_t1_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'ntf_t1_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'ntf_t1_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'ntf_font' => [
                'rules' => 'required|string',
                'messages' => [],
            ],
            'ntf_direction' => [
                'rules' => 'required|string|in:right,left,top,bottom',
                'messages' => [],
            ],
            'ntf_mute' => [
                'rules' => 'nullable|numeric|in:0,1',
                'messages' => [],
            ],
            'ntf_duration' => [
                'rules' => 'required|numeric',
                'messages' => [],
            ],
            'ntf_min_support' => [
                'rules' => 'required|numeric|min:0|max:500000',
                'messages' => [],
            ],
            'ntf_template_text' => [
                'rules' => 'required|string|max:255',
                'messages' => [],
            ],
        ],
        'leaderboard' => [
            'ldb_theme' => [
                'rules' => 'required|string', // |in:default,simple,clasic,modern
                'messages' => [],
            ],
            'ldb_t1_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'ldb_t1_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'ldb_t1_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'ldb_t1_color_4' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'ldb_t1_color_5' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'ldb_font' => [
                'rules' => 'required|string',
                'messages' => [],
            ],
            'ldb_sortby' => [
                'rules' => 'required|string|in:unit,nominal',      // Not impelemented yet
                'messages' => [],
            ],
            'ldb_support_count' => [
                'rules' => 'required|numeric|min:1|max:20',
                'messages' => [],
            ],
            'ldb_interval' => [
                'rules' => 'required|numeric|min:1',
                'messages' => [],
            ],
            'ldb_title' => [
                'rules' => 'required|string|max:255',
                'messages' => [],
            ],
            'ldb_subtitle' => [
                'rules' => 'required|string|max:255',
                'messages' => [],
            ],
            'ldb_show_nominal' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
        ],
        'mediashare' => [
            'mds_theme' => [
                'rules' => 'required|string',   // |in:default,simple,clasic,modern
                'messages' => [],
            ],
            'mds_t1_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mds_t1_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mds_t1_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mds_t1_color_4' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mds_font' => [
                'rules' => 'required|string',
                'messages' => [],
            ],
            'mds_show_support_message' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'mds_show_footer' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'mds_template_text' => [
                'rules' => 'required|string|max:191',
                'messages' => [],
            ],
        ],
        'lastsupporter' => [
            'lst_theme' => [
                'rules' => 'required|string',   // |in:default,simple,clasic,modern,card-flip
                'messages' => [],
            ],
            'lst_t1_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t1_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t1_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t1_color_4' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t2_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t2_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t2_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t2_color_4' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t3_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t3_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t3_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_t3_color_4' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'lst_font' => [
                'rules' => 'required|string',
                'messages' => [],
            ],
            'lst_support_message' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'lst_marquee' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'lst_flip_type' => [
                'rules' => 'required|string|in:horizontal,vertical',
                'messages' => [],
            ],
        ],
        'goal' => [
            'goa_theme' => [
                'rules' => 'required|string',   // |in:default,simple,clasic,modern
                'messages' => [] 
            ],
            'goa_t1_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'goa_t1_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'goa_t1_color_3' => [
                'rules' => 'required|string|max:100',            
                'messages' => [],
            ],
            'goa_t1_color_4' => [
                'rules' => 'required|string|max:100',            
                'messages' => [],
            ],
            'goa_t2_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'goa_t2_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'goa_t2_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'goa_t2_color_4' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'goa_t3_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'goa_t3_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'goa_t3_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'goa_t3_color_4' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'goa_font' => [
                'rules' => 'required|string',
                'messages' => [],
            ],
            'goa_source' => [
                'rules' => 'required|string|in:active-goal,tip-history',
                'messages' => [],
            ],
            'goa_custom_title' => [
                'rules' => 'required|string|max:191',
                'messages' => [],
            ],
            'goa_show_link' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'goa_since_date' => [
                'rules' => 'required|date|date_format:Y-m-d',
                'messages' => [],
            ],
            'goa_custom_target' => [
                'rules' => 'required|numeric|min:0',
                'messages' => [],
            ],
            'goa_show_current_nominal' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'goa_show_target_nominal' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'goa_show_progress' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'goa_show_shadow' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'goa_show_border' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
        ],
        'marquee' => [
            'mrq_theme' => [
                'rules' => 'required|string',   // |in:default,simple,clasic,modern
                'messages' => [],
            ],
            'mrq_t1_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mrq_t1_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mrq_t1_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mrq_t1_color_4' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mrq_t2_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mrq_t2_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mrq_t2_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'mrq_font'    => [
                'rules' => 'required|string',
                'messages' => [],
            ],
            'mrq_item_count' => [
                'rules' => 'required|numeric|min:1', 
                'messages' => [],
            ],
            'mrq_messages' => [
                'rules' => 'nullable|string|max:255', 
                'messages' => [],
            ],
            // 'mrq_type' => [
                // 'rules' => 'latest-tips',         // latest-tips, top-supporters
                // 'messages' => [],
            // ],
            'mrq_interval' => [
                'rules' => 'nullable|numeric',   // Not Implemented yet
                'messages' => [],
            ],
            'mrq_show_support_message' => [
                'rules' => 'required|numeric|in:0,1', 
                'messages' => [],
            ],
            'mrq_separator_type' => [
                'rules' => 'required|string|in:dot,icon',
                'messages' => [],
            ],
            'mrq_speed' => [
                'rules' => 'required|string|in:slow,normal,fast',
                'messages' => [],
            ],
            'mrq_txtshadow' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'mrq_txt_label' => [
                'rules' => 'nullable|string|max:191',
                'messages' => [],
            ],
            'mrq_show_label' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
            'mrq_type' => [
                'rules' => 'required|string|in:horizontal,vertical,marquee,typewriter',
                'messages' => [],
            ],
        ],
        'qrcode' => [
            'qrc_theme' => [
                'rules' => 'required|string',   // |in:default,simple,clasic,modern
                'messages' => [],
            ],
            'qrc_style' => [
                'rules' => 'required|string|in:default,dot,round,classy,classy-rounded,square,extra-rounded', 
                'messages' => [],
            ],
            'qrc_font' => [
                'rules' => 'required|string', 
                'messages' => [],
            ],
            'qrc_t1_color_1' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'qrc_t1_color_2' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'qrc_t1_color_3' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'qrc_t1_color_4' => [
                'rules' => 'required|string|max:100',
                'messages' => [],
            ],
            'qrc_top_label' => [
                'rules' => 'nullable|string|max:191',
                'messages' => [],
            ],
            'qrc_bottom_label' => [
                'rules' => 'nullable|string|max:191',
                'messages' => [],
            ],
            'qrc_target_page' => [
                'rules' => 'nullable|string|in:simple,full',
                'messages' => [],
            ],
            'qrc_show_border' => [
                'rules' => 'required|numeric|in:0,1',
                'messages' => [],
            ],
        ],
    ],

    'default_new_tip' => [
        "name" => "Someone",
        "email" => "someone@omg.id",
        "invoice_id" => null,
        "order_id" => null,
        "avatar" => null,
        "message" => "[TEST] THIS IS TEST MESSAGE!",
        "amount" => $total = (0),
        "formated_amount" => Utils::toIDR($total),
        "items" => [
            [
                "name" => "Rp0",
                "qty" => 2,
                "price" => 0,
                "total" => $total,
                "formated_price" => Utils::toIDR(0),
                "formated_total" => Utils::toIDR($total),
            ],
        ]
    ],

    /*
    * Available setting key
    */
    'setting_keys' => [
        // Payment method fee settings keys & properties
        'qris' => [
            'rules' => 'nullable|numeric|min:0|max:100',
            'value' => 0,
            'data_type' => 'double',
        ],
        'gopay' => [
            'rules' => 'nullable|numeric|min:0|max:100',
            'value' => 0,
            'data_type' => 'double',
        ],
        'dana' => [
            'rules' => 'nullable|numeric|min:0|max:100',
            'value' => 0,
            'data_type' => 'double',
        ],
        'ovo' => [
            'rules' => 'nullable|numeric|min:0|max:100',
            'value' => 0,
            'data_type' => 'double',
        ],
        'linkaja' => [
            'rules' => 'nullable|numeric|min:0|max:100',
            'value' => 0,
            'data_type' => 'double',
        ],
        'shopeepay' => [
            'rules' => 'nullable|numeric|min:0|max:100',
            'value' => 0,
            'data_type' => 'double',
        ],
        'platform_fee' => [
            'rules' => 'nullable|numeric|min:0|max:100',
            'value' => 0,
            'data_type' => 'double',
        ],
        'bank_transfer' => [
            'rules' => 'nullable|numeric|min:0|max:100000',
            'value' => 0,
            'data_type' => 'double',
        ],
        'payout_fee' => [
            'rules' => 'nullable|numeric|min:0|max:100000',
            'value' => 0,
            'data_type' => 'double',
        ],
        'ppn' => [
            'rules' => 'nullable|numeric|min:0|max:100',
            'value' => 0,
            'data_type' => 'double',
        ],
        'cc_rp' => [
            'rules' => 'nullable|numeric|min:0|max:100000',
            'value' => 0,
            'data_type' => 'double',
        ],
        'cc_percent' => [
            'rules' => 'nullable|numeric|min:0|max:100',
            'value' => 0,
            'data_type' => 'double',
        ],

        // Webhook integration settings keys & properties
        'discord_webhook' => [
            'rules' => 'nullable|string',
            'value' => '',
            'data_type' => 'json',
        ],
        'custom_webhook' => [
            'rules' => 'nullable|string',
            'value' => '',
            'data_type' => 'json',
        ],

        // Streaming url settings keys & properties
        'stream_url' => [
            'rules' => 'nullable|string|url',
            'value' => '',
            'data_type' => 'string',
        ],

        // language settings keys & properties
        'language' => [
            'rules' => 'required|string|in:en,id',
            'value' => config('app.locale', 'en'),
            'data_type' => 'string',
        ],

        // Email notifications settings keys & properties
        'allow_new_support' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],

        'allow_news_and_update' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 1,
            'data_type' => 'boolean',
        ],

        // Bad words filter settings keys & properties
        'profanity_custom_filter' => [
            'rules' => 'nullable|string',
            'value' => '',
            'data_type' => 'string',
        ],
        'profanity_by_system' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],

        // media_share settings keys & properties
        'media_share' => [
            'rules' => 'nullable|string',
            'value' => null,
            'data_type' => 'json',
        ],

        // setting app guide tour
        'navbar_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'dashboard_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'goal_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'item_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'overlay_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'balance_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'content_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'page_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'navsupporter_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'contentsubs_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'support_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],
        
        'following_guide' => [
            'rules' => 'nullable|numeric|in:0,1',
            'value' => 0,
            'data_type' => 'boolean',
        ],

    ]

];
