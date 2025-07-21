<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Last Supporter | Default</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --color-card:linear-gradient(180deg, #FFFFFF 0%, rgba(255, 255, 255, 0.4) 25.38%, rgba(254, 254, 254, 0.590518) 80.82%, rgba(252, 252, 252, 0.816404) 99.99%, #FFFFFF 100%);;  
            --color-card-footer: #c1c6cc;
            --color-card-border: #ebebeb;
            --color-text-card: #d2d5d8;
            --color-text-footer: #2d2d39;
            --box-width: 520px;
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
        
        .bg-color-card {
            background: var(--color-card);
            color: var(--color-text-card);
        }
        
        .bg-color-footer {
            background: var(--color-card-footer);
            color: var(--color-text-footer);
        }

        .color-card-border {
            /* border: 2px solid; */
            border-color: var(--color-card-border)!important;
        }

        /* .avatar-80 {
            height: 60px;
            width: 60px;
            line-height: 60px;
        } */

        /* .box-corner:before,
        .box-corner:after {
            content: "";
            position: absolute;
            left: 0; 
            right: 0;
            bottom: 100%;
            margin-left:-1px;
            margin-right:-1px;
            border-bottom: 8px solid var(--color-card-border);
            border-left: 16px solid transparent;
            border-right: 16px solid transparent;
        } */

        /* .box-corner:before{
            border-left: 15px solid var(--color-card-border);
        }

        .box-corner:after{
            border-right: 15px solid var(--color-card-border);
        } */

        /* .box-corner:after {
            bottom: auto;
            top: 100%;
            border-bottom: none;
            border-top: 8px solid var(--color-card-border);
        }

        .message:before,
        .message:after {
            content: "\2014\00A0";
        } */

    </style>
</head>
<body>
    <div class="box mt-3 m-3" id="widget-container"></div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @if (!isset($qParams['iframe']))
    <script src="{{ asset('js/echo.js') }}"></script>   
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/omg-widget.js') }}"></script>

    <script type="text/javascript">

        let payloadsData = {};
        let hasRender = false;

        $(() => {
            if (parent && parent.registerChildFunction){
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
                });
            }

            init();
            if (!qParams.has('iframe')) {
                // Echo.channel("stream.newtip.{{ $streamKey }}").listen('.stream.newtip', (data) => {
                //     const { payloads } = data;

                //     // console.log(payloads);
                //     if (hasRender) {
                //         renderWidgetContent(payloads.new_tip);
                //     }
                // });

                Echo.channel("stream.new_tip.{{ $streamKey }}")
                    .notification((data) => {
                        // console.log(data);
                        const { type, payloads } = data;

                        if (type == 'notify.new_tip') {
                            if (hasRender && !payloads.test) {
                                renderWidgetContent(payloads.new_tip);
                            }
                        }
                });

                Echo.connector.pusher.connection.bind("state_change", function (states) {
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
            const colorCard = qParams.get('lst_t2_color_1'); 
            if (colorCard) {
                setStyle('--color-card', colorCard);
            }

            // Color card footer
            const colorCardFooter = qParams.get('lst_t2_color_2');
            if (colorCardFooter) {
                setStyle('--color-card-footer', colorCardFooter);
            }

            // Color card border
            const colorCardBorder = qParams.get('lst_t2_color_3');
            if (colorCardBorder) {
                setStyle('--color-card-border', colorCardBorder);
            }

            // Color card text
            const colorCardText = qParams.get('lst_t2_color_4');
            if (colorCardText) {
                setStyle('--color-text-card', colorCardText);
            }

            // Color footer text
            const colorFooterText = qParams.get('lst_t2_color_5');
            if (colorFooterText) {
                setStyle('--color-text-footer', colorFooterText);
            }

            // Setup html
            let widgetParams = {
                showMessage: qParams.get('lst_support_message'),
                setAsMarquee: qParams.get('lst_marquee')
            }

            // Get data from BE
            const response = await fetchData();
            if (response) {
                let { payloads } = await response.data.result;
                
                payloads = {
                    ...widgetParams,
                    ...payloads.new_tip
                };

                console.log(payloads);
                setHTML('widget-container', renderWidget(payloads));

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
                <div class="d-flex justify-content-center">
                    <div class="card w-100 rounded-1 box-corner color-card-border bg-color-card shadow-sm animate__animated animate__fadeIn">
                        <div class="card-body p-1">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 ms-3 mt-2">
                                    <h5 class="mb-1 text-nowrap"><strong id="supporter_name">${splitLongText((payloads.name || ''), 25, 20)}</strong></h5>
                                    <p>Baru saja mendukungmu sebesar <strong id="support">${payloads.formated_amount || 'Rp0'}</strong></p>
                                </div>
                                <div class="flex-shrink-0 me-3">
                                    <img class="img-fluid rounded-circle avatar-80" id="supporter_avatar" src="${payloads.avatar ?? "{{ asset('template/images/user/user.png') }}"}" alt="">
                                </div>
                            </div>
                        </div>
                        <div id="support_message_div" class="card-footer bg-color-footer overflow-hidden ps-2 pe-2 ${setAsMarquee == '1' ? 'pb-0 pt-1' : '' }" ${payloads.showMessage != '1' ? 'hidden' : ''}>
                            ${supportMessage}
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
            }
        }

        const renderLoader = () => {
            return `
                <div class="d-flex justify-content-center">
                    <div class="card w-100 rounded-1 box-corner color-card-border bg-color-card shadow-sm animate__animated animate__fadeIn">
                        <div class="card-body p-1">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 ms-3 mt-2 mb-2">
                                    <h5 class="mb-1 text-center"><strong id="text-render">Rendering...</strong></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        const getSupportMessageType = (type = 'text') => {
            let payloads = payloadsData;
            let supportMessage = `<span class="message fst-italic text-nowrap" id="supporter_message"> ${splitLongText((payloads.message || 'Example Message'), 40, 35)} </span>`;
            if (type == 'marquee') {
                supportMessage = `<marquee class="p-0" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                                    <span class="message fst-italic text-nowrap" id="supporter_message"> ${splitLongText((payloads.message || 'Example Message'), 40, 35)} </span>
                                </marquee>`;
            }

            return supportMessage;
        }
        
    </script>

</body>
</html>
