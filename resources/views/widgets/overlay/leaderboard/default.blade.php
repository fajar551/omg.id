<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Leaderboard | Default</title>

    <link href="{{ asset('assets/img/omg.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/animate.css/css/animate.min.css') }}" rel="stylesheet">
    <style>
        :root{
            --bg-leaderboard-header : #6103D0;
            --bg-leaderboard-list :  #f1ebf7;
            --color-border-list : #C99BFD;
            --color-text-header : #ebebeb;
            --color-text-list : #2d2d39 ;
            --animate-duration: 800ms;
            --animate-delay: 0.9s;
            --box-width: 630px;
            --box-margin: auto;
            --font-family: "Ubuntu", "Montserrat", sans-serif;
        }

        body {
            width: var(--box-width);
            margin: var(--box-margin);
        }

        .box {
            max-width: var(--box-width);
            margin: var(--box-margin);
            font-family: var(--font-family);
        }

        .card-leaderboard-header {
            background-color: var(--bg-leaderboard-header);
            color: var(--color-text-header);
        }
        
        .card-leaderboard-list {
            background-color: var(--bg-leaderboard-list);
            color: var(--color-text-list);
            border: 1px solid var(--color-border-list);
        }

        .img-leaderboard img {
            width: 40px;
            height: 40px;
            margin-right: 5px;
            margin-left: 5px;
        }

        .rank-rounded {
            width: 40px;
            height: 40px;
        }
    </style>
</head>

<body>
    <div class="box m-3" id="widget-container">
        <div class="card mb-3 card-leaderboard-header rounded-pill shadow border-0" id="leaderboard-header-div" hidden>
            <div class="card-body">
                <ul class="notification-list m-0 p-0">
                    <li class="d-flex align-items-center justify-content-between">
                        <div class="img-leaderboard">
                            <img src="{{ asset('template/images/award.png') }}" alt="story-img" class="">
                        </div>
                        <div class="img-leaderboard">
                            {{-- <img src="{{ asset('template/images/icon/icon-user.png') }}" alt="story-img" class=""> --}}
                        </div>
                        <div class="w-100 d-flex justify-content-between">
                            <div class="ms-3">
                                <h4 id="title" class="p-0 m-0 mb-1"></h4>
                                <h6 id="subtitle" class="p-0 m-0"></h6>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="leaderboard-div">
            
        </div>
    </div>
</body>

    <script src="{{ asset('template/vendor/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap-5/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/vendor/webfont/js/webfont.min.js') }}"></script>
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        /**
        * Overlay scripts
        * Version: 1.0
        */
        (function ($) {
            "use strict";

            $(() => {
                if (qParams.has('iframe')) {
                    regCallbackInterval({
                        "init": init,
                    });
                }

                init();
                if(!qParams.has('iframe')){
                    setInterval(function(){
                        init();
                    }, 3 * 60 * 1000);  // 3 Minutes 
                }
            }); 

            const init = async () => {
                setStyle('--animate-duration', '800ms');

                // Check if in iframe / preview
                if (qParams.get('iframe')) {
                    setStyle('--box-width', '100%');
                } else {
                    setStyle('--box-margin', 'initial');
                }

                getElementById('leaderboard-header-div').removeAttribute('hidden');
                setHTML('leaderboard-div', '');
                setHTML('title', 'Rendering...');
                setHTML('subtitle', '&nbsp;');

                // Set font
                const font = qParams.has('ldb_font') ? qParams.get('ldb_font') : "Ubuntu";
                setFont(font);

                // Setup color palete
                const colorHead = qParams.get('ldb_t1_color_1');
                if (colorHead) {
                    setStyle('--bg-leaderboard-header', colorHead);
                }

                const colorList = qParams.get('ldb_t1_color_2');
                if (colorList) {
                    setStyle('--bg-leaderboard-list', colorList);
                }

                const colorBorderList = qParams.get('ldb_t1_color_3');
                if (colorBorderList) {
                    setStyle('--color-card-footer', colorBorderList);
                }

                const colorTextHeader = qParams.get('ldb_t1_color_4');
                if (colorTextHeader) {
                    setStyle('--color-text-header', colorTextHeader);
                }

                const colorTextList = qParams.get('ldb_t1_color_5')
                if (colorTextList) {
                    setStyle('--color-text-list', colorTextList);
                }
                
                // Setup html
                let widgetParams = {
                    isIframe: qParams.get('iframe'),
                    isRealData: qParams.get('real_data'),
                    showNominal: qParams.get('ldb_show_nominal'),
                }

                if(widgetParams.isIframe && widgetParams.isRealData == 0) {
                    setHTML('leaderboard-div', renderDummyList(qParams.get('ldb_support_count'), false, widgetParams));
                    setHTML('title', qParams.get('ldb_title'));
                    setHTML('subtitle', qParams.get('ldb_subtitle'));
                    
                    return;
                }

                // Get data from BE
                const response = await fetchData();
                if (response) {
                    let { payloads } = await response.data.result;

                    payloads = {
                        ...widgetParams,
                        leaderboards: payloads.leaderboards,
                    };

                    // console.log(payloads);
                    setHTML('leaderboard-div', renderWidget(payloads));
                    setHTML('title', qParams.get('ldb_title'));
                    setHTML('subtitle', qParams.get('ldb_subtitle'));

                    return true;
                }

                setHTML('leaderboard-div', '');
                setHTML('title', 'Failed to render');
                setHTML('subtitle', '&nbsp;');
            }

            const renderDummyList = (count, noLatestSupport = false, payloads = {}) => {
                let html = '';
                for (let i = 1; i <= count; i++) {
                    let dummyPayloads = {
                        name: !noLatestSupport ? 'Supporter' +i : 'No Latest Supporter',
                        message: !noLatestSupport ? 'OMG..!! Awesome' : '',
                        formated_amount: 'Rp0',
                        showNominal: noLatestSupport ? 0 : (payloads.showNominal || 0),
                    }

                    html += renderTemplate(dummyPayloads, i);
                }

                return html;
            }

            const renderWidget = (payloads) => {
                let html = '';
                const leaderboards = payloads.leaderboards || [];
                const showNominal = payloads.showNominal || 0;

                if (!leaderboards.length) {
                    return renderDummyList(1, true);
                }

                $.each(leaderboards, function(index, value) {
                    value.showNominal = showNominal;

                    html += renderTemplate(value, ++index);
                });

                return html;
            }

            const renderTemplate = (payloads, rank) => {
                return `
                    <div class="card mb-2 card-leaderboard-list rounded-pill shadow animate__animated animate__flash" >
                        <div class="card-body">
                            <ul class="notification-list m-0 p-0">
                                <li class="d-flex align-items-center justify-content-between">
                                    <div class="rank-rounded rounded-pill bg-warning">
                                        <span class="text-center "><p class="p-0 mt-2 fs-6 text-secondary fw-bold ">${rank}</p></span> 
                                    </div>
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <div class=" ms-3">
                                                <h4 class="p-0 m-0" >${splitLongText((escape(payloads.name) || 'Someone'), 25, 20)}</h4>
                                                <p class="p-0 m-0">${splitLongText((escape(payloads.message) || 'Example Message'), 35, 30)}</p>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <h6 class="show_nominal" ${payloads.showNominal != 1 ? 'hidden' : ''}>${payloads.formated_amount || 'Rp0'}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>`;
            } 

            const fetchData = async () => {
                @php
                    $params = array_merge([
                        'key' => $key,
                        'streamKey' => $streamKey,
                    ], $qParams);
                @endphp

                const url = "{!! route('api.widget.overlay.show', $params) !!}";
                const options = {
                    method: "GET",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                }

                const response = await fetch(url, options)
                    .then(response => {
                        if (!response.ok) throw new Error(response.statusText);

                        return response.json();
                    })
                    .catch(error => {
                        console.log(`Request failed: ${error}`);

                        return false;
                    });
                
                return response;
            }

        })(jQuery);
    </script>

</html>