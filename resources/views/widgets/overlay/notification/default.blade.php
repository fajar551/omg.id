<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Notification | Default</title>
    <link href="{{ asset('assets/img/omg.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('template/vendor/bootstrap-5/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/animate.css/css/animate.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --color-card: #6103D0;  
            --color-card-avatar: #ebebeb;
            --color-text-card: #ebebeb;
            --box-width: 420px;
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
        
        .bg-parent {
            position: relative;
            background-color: var(--color-card);
            width: 100%;
            height: auto;
            border-radius: 23px;
            /* line-height: 90px; */
            margin: auto;
        }

        .bg-float-left {
            width: 80%;
            padding-right: 10px;
            padding-top: 0 !important;
        }
        
        .bg-float-left-text {
            font-weight: 550;
            font-size: 14px;
            color: var(--color-text-card);
        }

        .bg-float-right {
            background-color: var(--color-card-avatar);
            position: absolute;
            top: 0;
            right: -1px;
            width: 20%;
            height: 100%;
            border-radius: 0px 23px 23px 0px;
        }

    </style>
</head>
<body>
    <div class="" id="div-animate">
        <div class="box m-3" id="widget-container" style="display: none;"></div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('template/vendor/jquery/js/jquery.min.js') }}"></script>
    @if (!isset($qParams['iframe'])) <script src="{{ asset('js/echo.js') }}"></script> @endif
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

            let tipQueue = [];
            let payloadsData = {};
            let hasRender = false;
            let notifSound = new Audio(`{{ asset("assets/audio") }}/${qParams.get('ntf_sound') || 'coin-win.wav'}`);
            let isWidgetShow = false;
            let countDownTimer = null;

            $(() => {
                if (qParams.has('iframe')) {
                    regCallbackInterval({
                        "setAnimation": setAnimation,
                    });
                }

                init();
                if (!qParams.has('iframe')) {
                    Echo.channel("stream.new_tip.{{ $streamKey }}")
                        .notification((data) => {
                            // console.log(data);
                            const { type, payloads } = data;

                            if (type == 'notify.new_tip') {
                                const { new_tip, test, notify_type } = payloads;

                                if (new_tip) {
                                    // console.log("push new tip!");
                                    new_tip.test = test;

                                    if (test && notify_type == 'notification') {
                                        loadNewTipTest(new_tip);
                                        return;
                                    }

                                    if (!test && notify_type == 'notification') {
                                        tipQueue.push({
                                            new_tip
                                        });
                                        
                                        setTimeout(() => {
                                            loadNewTip();
                                        }, 300);
                                    }
                                }
                            }
                    });

                    Echo.connector.pusher.connection.bind("state_change", function (states) {
                        console.log(`Socket is ${states.current}`);
                    });
                }

                setInterval(() => {
                    loadNewTip();
                }, 3 * 60 * 1000);  // 3 Minutes
            });

            const playNotifSound = () => {
                if (qParams.has('ntf_mute') && qParams.get('ntf_mute') == 0) {
                    setTimeout(() => {
                        let ntfSound = notifSound.play();
                        if (ntfSound!== undefined) {
                            ntfSound.then(_ => {
            
                            }).catch(error => {
                                console.log('Please click in the body area first.');
                            });
                        }
                    }, 1000);
                } 
            }

            const init = async () => {
                setHTML('widget-container', renderLoader());
                setStyle('--animate-duration', '500ms');

                // Check if in iframe / preview
                if (qParams.get('iframe')) {
                    setStyle('--box-width', '100%');
                    $('#widget-container').show();
                } else {
                    $('#widget-container').hide();
                    setStyle('--box-margin', 'initial');
                }
                
                // Set font
                const font = qParams.has('ntf_font') ? qParams.get('ntf_font') : "Ubuntu"; 
                setFont(font);

                // Color card body
                const colorCard = qParams.get('ntf_t1_color_1'); 
                if (colorCard) {
                    setStyle('--color-card', colorCard);
                }

                // Color card avatar
                const colorCardAvatar = qParams.get('ntf_t1_color_2');
                if (colorCardAvatar) {
                    setStyle('--color-card-avatar', colorCardAvatar);
                }

                // Color footer text
                const colorCardText = qParams.get('ntf_t1_color_3');
                if (colorCardText) {
                    setStyle('--color-text-card', colorCardText);
                }

                // Setup html
                let widgetParams = {
                    isIframe: qParams.get('iframe'),
                    templateText: qParams.get('ntf_template_text'),
                }

                setHTML('widget-container', renderWidget(widgetParams));

                if (qParams.get('iframe')) {
                    setAnimation(qParams.get('ntf_animation') || 'animate__tada');
                }

                document.addEventListener('visibilitychange', function() {
                    if(document.hidden) {
                        // tab is now inactive
                        clearAnimation();
                    } else {
                        // restart timers
                        setAnimation(qParams.get('ntf_animation') || 'animate__tada');
                    }
                });
            }

            const renderWidget = (payloads = {}) => {
                return `
                    <div class="d-flex justify-content-center " ${payloads.isIframe != '1' ? 'hidden' : ''}>
                        <div class="card shadow bg-parent border-0">
                            <div class="card-body px-2 py-3 ms-2 bg-content">
                                <div class="bg-float-left">
                                    <div class="bg-float-left-text">
                                        <div class="mb-2 text-uppercase fw-bold" id="supporter_name">${payloads.test || payloads.isIframe ? '[New Tip Simulation]' : 'New Tip..!!'}</div>
                                        <span id="template_text"> ${escape(payloads.templateText)}</span> 
                                    </div>
                                </div>
                                <div class="bg-float-right border-0 text-center">
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <img id="supporter_avatar" src="${payloads.avatar ?? "{{ asset('template/images/user/user.png') }}"}" class="rounded-circle  mb-2 " width="50" height="50" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            const renderWidgetContent = (payloads, force = false) => {
                if (force) {
                    clearInterval(countDownTimer);
                    countDownTimer = null;
                    isWidgetShow = false;
                    
                    $('#widget-container').hide();
                }
                
                if (isWidgetShow) {
                    return;
                }

                // setHTML('supporter_name', splitLongText((payloads.name || 'Someone'), 25, 20));
                setHTML('supporter_name', payloads.test || payloads.isIframe ? '[New Tip Simulation]' : 'New Tip..!!');
                setHTML('support', payloads.formated_amount || 'Rp0');
                setHTML('template_text', payloads.template_text);
                setHTML('supporter_message', splitLongText((payloads.message || 'Example Message'), 40, 35));
                if (payloads.avatar) {
                    getElementById('supporter_avatar').src = payloads.avatar;
                } else {
                    getElementById('supporter_avatar').src = "{{ asset('template/images/user/user.png') }}";
                }

                let timeleft = qParams.get('ntf_duration') || 5;
                
                if (countDownTimer == null) {
                    countDownTimer = setInterval(function() {
                        if(timeleft <= 0) {
                            // onFinish
                            clearInterval(countDownTimer);
                            countDownTimer = null;
                            isWidgetShow = false;
                            
                            $('#widget-container').hide();
                            clearAnimation();
                        } else {
                            // onTick
                            isWidgetShow = true;
                        }
                        
                        timeleft -= 1;
                    }, 1000);
                }
                
                $('#widget-container').show();
                
                playNotifSound();
                setAnimation(qParams.get('ntf_animation') || 'animate__tada');
            }

            const renderLoader = () => {
                return `
                    <div class="d-flex justify-content-center">
                        <div class="card shadow bg-parent border-0">
                            <div class="card-body p-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3 mt-2 mb-2">
                                        <h5 class="mb-1 text-center bg-float-left-text"><strong id="text-render">Rendering...</strong></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            const loadNewTip = () => {
                if (tipQueue.length) {
                    let { new_tip } = tipQueue[0];

                    renderWidgetContent(new_tip);

                    tipQueue.shift();
                }
            }

            const loadNewTipTest = (new_tip) => {
                renderWidgetContent(new_tip, true);
            }

            let timeOut = null;
            const setAnimation = (animationName = 'animate__tada') => {
                const element = getElementById('div-animate');
                element.className = '';            
                setTimeout(() => {
                    element.classList.add('animate__animated', animationName, !qParams.get('iframe') ? 'animate__delay-2s' : 'no-delay');
                }, 500);

                element.addEventListener('animationend', () => {
                    // console.log('animationEnd');
                    if (qParams.get('iframe') && timeOut == null) {
                        timeOut = setTimeout(() => {
                            setAnimation(qParams.get('ntf_animation') || 'animate__tada');
                            clearAnimation();
                        }, 5000);
                    }

                    if (!qParams.get('iframe') && timeOut == null && isWidgetShow) {
                        timeOut = setTimeout(() => {
                            setAnimation(qParams.get('ntf_animation') || 'animate__tada');
                            clearAnimation();
                        }, 5000);
                    }
                });
            }

            const clearAnimation = () => {
                clearTimeout(timeOut);
                timeOut = null;
            }

        })(jQuery);
    </script>

</body>
</html>
