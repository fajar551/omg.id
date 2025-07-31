<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Last Supporter | Card Flip</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .card {
            background-color: #ffff;
            border-radius: 12px;
        }
        .message {
            color: #ffff;
        }
        .footer {
            background-color: #ffff;
        }
    </style>
</head>

<body>
    <div class="card border-0  shadow" id="widget-container">
        <div class="card-body  d-flex justify-content-between align-items-center">
            <div class="conten">
                <h5>Lorem, ipsum.</h5>
                <h6>Baru saja mengirimkan</h6>
                <h6 class="fw-bold">
                    Rp. 100.000
                </h6>

            </div>
            <div class="image">
                <div class="img-leaderboard">
                    <img src="{{ asset('template/images/icon/icon-user.png') }}" alt="story-img" class="" width="60" height="60">
                </div>
            </div>
        </div>
        <div class="px-3">
        <hr>
        </div>
        <div class="card-footer bg-transparent border-top-0">
            Lorem, ipsum dolor. <span> <img src="{{ asset('template/images/icon/bendera.png') }}" alt="story-img" class="" ></span> Lorem, ipsum do <span> <img src="{{ asset('template/images/omg.png') }}" alt="" class="" width="20" height="20"> </span>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @if (!isset($qParams['iframe']))
    <script src="{{ asset('js/echo.js') }}"></script>
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>

    <!-- <script type="text/javascript">
        let payloadsData = {};
        let hasRender = false;
        let flipInterval = null;

        $(() => {
            if (parent && parent.registerChildFunction) {
                console.log('registering function with parent');

                parent.registerChildFunction({
                    "setStyle": setStyle,
                    "setHTML": setHTML,
                    "setFont": setFont,
                    "getElementById": getElementById,
                    "toIDR": toIDR,
                    "buildParams": buildParams,
                    "reloadWidget": reloadWidget,
                    "getSupportMessageType": getSupportMessageType,
                    "setFlipType": setFlipType,
                });
            }

            init();
            if (!qParams.has('iframe')) {
                // Echo.channel("stream.newtip.{{ $streamKey }}").listen('.stream.newtip', (data) => {
                //     const { payloads } = data;

                //     // console.log(payloads);
                //     if (hasRender) {
                //         if (!payloads.test) {
                //             renderWidgetContent(payloads.new_tip);
                //         }
                //     }
                // });

                Echo.channel("stream.new_tip.{{ $streamKey }}")
                    .notification((data) => {
                        // console.log(data);
                        const {
                            type,
                            payloads
                        } = data;

                        if (type == 'notify.new_tip') {
                            if (hasRender && !payloads.test) {
                                renderWidgetContent(payloads.new_tip);
                            }
                        }
                    });

                Echo.connector.pusher.connection.bind("state_change", function(states) {
                    console.log(`Socket is ${states.current}`);
                });
            }
        });

        const init = async () => {
            setHTML('widget-container', renderLoader());
            setStyle('--animate-duration', '500ms');

            // Check if in iframe / preview
            if (qParams.get('iframe')) {
                setStyle('--box-width', '100%');
            } else {
                setStyle('--box-margin', 'initial');
            }

            // Set font
            const font = qParams.has('lst_font') ? qParams.get('lst_font') : "Ubuntu";
            setFont(font);

            // Color card body
            const colorCard = qParams.get('lst_t3_color_1');
            if (colorCard) {
                setStyle('--color-card', colorCard);
            }

            // Color card back
            const colorCardBack = qParams.get('lst_t3_color_2');
            if (colorCardBack) {
                setStyle('--color-card-back', colorCardBack);
            }

            // Color card text
            const colorCardText = qParams.get('lst_t3_color_3');
            if (colorCardText) {
                setStyle('--color-text-card', colorCardText);
            }

            // Color footer text
            const colorCardBackText = qParams.get('lst_t3_color_4');
            if (colorCardBackText) {
                setStyle('--color-text-back', colorCardBackText);
            }

            // Setup html
            let widgetParams = {
                showMessage: qParams.get('lst_support_message'),
                setAsMarquee: qParams.get('lst_marquee')
            }

            // Get data from BE
            const response = await fetchData();
            if (response) {
                let {
                    payloads
                } = await response.data.result;

                payloads = {
                    ...widgetParams,
                    ...payloads.new_tip
                };

                console.log(payloads);
                setHTML('widget-container', renderWidget(payloads));
                if (qParams.get('iframe')) {
                    getElementById('text-flip-info').removeAttribute('hidden');
                } else {
                    getElementById('text-flip-info').setAttribute('hidden', '');
                }

                // Flip transform
                const flipType = qParams.get('lst_flip_type');
                if (flipType) {
                    setFlipType(flipType);
                }

                return true;
            }

            setHTML('text-render', 'Failed to render');
        }

        const fetchData = async () => {
            @php
            $params = array_merge([
                'key' => $key,
                'streamKey' => $streamKey,
                'fetch_only' => 1,
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

        const renderWidget = (payloads = {}) => {
            payloadsData = payloads;

            let setAsMarquee = payloads.setAsMarquee;
            let supportMessage = getSupportMessageType();
            if (setAsMarquee == '1') {
                supportMessage = getSupportMessageType('marquee');;
            }

            hasRender = true;
            return `
                <strong class="fst-italic" id="text-flip-info">* Click card to flip.</strong>
                <div class="card-flip" onclick="this.classList.toggle('is-flipped');">
                    <div class="card-face card-face-front">
                        <div class="card bg-color-card shadow card-border h-100 animate__animated animate__fadeIn">
                            <div class="card-body p-3 overflow-hidden">
                                <div>
                                    <img class="img-fluid rounded-circle avatar avatar-50 job-icon mb-2 d-inline-block" id="supporter_avatar" src="${payloads.avatar ?? "{{ asset('template/images/user/user.png') }}"}" alt="">
                                </div>
                                <h5 id="supporter_name">${splitLongText((payloads.name || 'Someone'), 25, 20)}</h5>
                                <small class="text-nowrap me-3">Memberikan dukungan sebesar <strong id="support">${payloads.formated_amount || 'Rp0'}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="card-face card-face-back">
                        <div class="card card bg-color-card-back shadow card-border h-100 p-0 animate__animated animate__fadeIn">
                            <div class="card-body text-center p-3">
                                <div>
                                    <img class="img-fluid rounded-circle avatar avatar-50 job-icon mb-2 d-inline-block" id="supporter_avatar_back" src="${payloads.avatar ?? "{{ asset('template/images/user/user.png') }}"}" alt="">
                                </div>
                                <div id="support_message_div" class="overflow-hidden  ${setAsMarquee == '1' ? 'pb-0 pt-1' : '' }">
                                    ${supportMessage}
                                </div>
                                <small>&nbsp;</small>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        const renderWidgetContent = (payloads) => {
            setHTML('supporter_name', splitLongText((payloads.name || 'Someone'), 25, 20));
            setHTML('support', payloads.formated_amount || 'Rp0');
            setHTML('supporter_message', splitLongText((payloads.message || 'Example Message'), 40, 35));
            if (payloads.avatar) {
                getElementById('supporter_avatar').src = payloads.avatar;
                getElementById('supporter_avatar_back').src = payloads.avatar;
            }

            const card = document.querySelector('.card-flip');
            card.classList.toggle('is-flipped');
        }

        const renderLoader = () => {
            return `
                <div class="card-flip">
                    <div class="card-face card-face-front">
                        <div class="card bg-color-card shadow h-100 card-border p-0 animate__animated animate__fadeIn">
                            <div class="card-body ">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ">
                                        <h5 class="mb-1 text-center"><strong id="text-render">Rendering...</strong></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        const getSupportMessageType = (type = 'text') => {
            let payloads = payloadsData;
            let supportMessage = `<h5 class="message fst-italic text-nowrap" id="supporter_message"> ${splitLongText((payloads.message || 'Example Message'), 40, 35)} </h5>`;
            if (type == 'marquee') {
                supportMessage = `<marquee class="p-0" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                                    <h5 class="message fst-italic text-nowrap" id="supporter_message"> ${splitLongText((payloads.message || 'Example Message'), 40, 35)} </h5>
                                </marquee>`;
            }

            return supportMessage;
        }

        const setFlipType = (flip = 'horizontal', force = false) => {
            setStyle('--flip-transform', flip == 'horizontal' ? 'rotateX(180deg)' : 'rotateY(180deg)');
            runCardFlip(force);
        }

        const runCardFlip = (force = false) => {
            const card = document.querySelector('.card-flip');

            if (force) {
                card.classList.toggle('is-flipped');
                return;
            }

            if (flipInterval != null) {
                clearInterval(flipInterval);
                flipInterval = null;
            }

            flipInterval = setInterval(() => {
                card.classList.toggle('is-flipped');
            }, 10 * 1000); // 10 Seconds
        }
    </script> -->

</body>

</html>