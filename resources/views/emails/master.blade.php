<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <title>OMG</title>
    <style>
        /* @font-face{
            font-family: "HelveticaNeue";
            src: url("{{ asset('assets/fonts/helvitica/Helvetica\ Neu\ Bold.ttf')}}");
            src: url("{{ asset('assets/fonts/helvitica/HelveticaNeueHv.ttf')}}");
            src: url("{{ asset('assets/fonts/helvitica/HelveticaNeueIt.ttf')}}");
            src: url("{{ asset('assets/fonts/helvitica/HelveticaNeueLt.ttf')}}");
            src: url("{{ asset('assets/fonts/helvitica/HelveticaNeueMed.ttf')}}");
        } */
        @import url('https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&display=swap');
        /* -------------------------------------
						GLOBAL RESETS
					------------------------------------- */
        img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
        }

        body {
            font-family: 'Arimo', sans-serif;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 10 0%;
        }

        table td {
            font-family: 'Arimo';
            font-size: 14px;
            vertical-align: top;
        }

        table thead {
            font-weight: bold;
        }

        /* -------------------------------------
						BODY & CONTAINER
					------------------------------------- */

        .body {
            background-color: #f7f7f8;
            width: 100%;
        }

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            display: block;
            Margin: 0 auto !important;
            /* makes it centered */
            max-width: 600px;
            /* padding: 10px; */
            width: 600px;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            box-sizing: border-box;
            display: block;
            Margin: 0 auto;
            /* max-width: 580px; */
            /* padding: 10px; */
        }

        /* -------------------------------------
						HEADER, FOOTER, MAIN
					------------------------------------- */

        .header a {
            text-decoration: none;
        }

        .logo {
            width: 180px;
            height: auto;
        }

        .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%;
        }

        .wrapper {
            box-sizing: border-box;
            box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 15%) !important;
           
        }

        .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
        }

     
       
        .footer td,
        .footer p,
        .footer span,
        .footer a {
            color: #D0EE26;
            font-size: 12px;
            text-align: center;
        }
        .footer .sosial-list{
            font-size: 16px;
            font-weight: normal;
        }
        ul.social-list li {
            margin-right: 10px;
        }
        ul.social-list a {
            font-size: 16px;
            text-decoration: none;
        }
        /* -------------------------------------
						TYPOGRAPHY
		------------------------------------- */
        h1,
        h2,
        h3,
        h4 {
            color: #D0EE26;
            font-family: 'Arimo';
            font-weight: 700;
            line-height: 1.4;
            margin: 0;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 35px;
            font-weight: 700;
            text-align: center;
            text-transform: capitalize;
        }


        p,
        ul,
        ol {
            font-family: 'Arimo';
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px;
        }

        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin-left: 5px;
        }

        a {
            color: #D0EE26;
            text-decoration: underline;
        }

        .footer h3{
            margin-bottom: 10px;
        }

        .address p{
            margin-bottom: 5px;
        }

        /* -------------------------------------
						BUTTONS
					------------------------------------- */
        .btn {
            box-sizing: border-box;
            width: 100%;
        }

        .btn>tbody>tr>td {
            padding-bottom: 15px;
        }

        .btn table {
            width: auto;
        }

        .btn table td {
            background-color: #ffffff;
            border-radius: 5px;
            text-align: center;
        }

        .btn {
            /* display: inline-block; */
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 14px;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            text-transform: capitalize;
            padding: 10px 20px;
        }

        .btn-primary{
            background-color: #6103D0;
        }

        .btn-primary  {
            background-color: #6103D0;
            border-color: #6103D0;
            color: #fff;
        }
        .address{
            margin-top:20px;
        }
        /* -------------------------------------
						OTHER STYLES THAT MIGHT BE USEFUL
					------------------------------------- */
        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .clear {
            clear: both;
        }

        .mt0 {
            margin-top: 0;
        }

        .mb0 {
            margin-bottom: 0;
        }

        .powered-by a {
            text-decoration: none;
        }

        hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            Margin: 20px 0;
        }

        /* -------------------------------------
						RESPONSIVE AND MOBILE FRIENDLY STYLES
					------------------------------------- */
        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
                font-size: 14px !important;
            }

            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 10px !important;
            }

            table[class=body] .content {
                padding: 0 !important;
            }

            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }

            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            table[class=body] .btn table {
                width: 100% !important;
            }

            table[class=body] .btn a {
                width: 100% !important;
            }

            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }
        }
        .content-email{
            width: 580px;
            padding: 30px 10px 30px 10px;
            overflow-wrap: break-word;
        }
        .content-email p ,.content-email .text-link {
            margin-bottom: 15px;
        }
    
        /* -------------------------------------
						PRESERVE THESE STYLES IN THE HEAD
					------------------------------------- */
        @media all {
            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }

            .btn-primary table td:hover {
                background-color: #34495e !important;
            }

            .btn-primary a:hover {
                background-color: #34495e !important;
                border-color: #34495e !important;
            }
        }

        .symbolfix img {
            width: 10px !important;
            height: 10px !important;
        }
        @media only screen and (max-width: 425px) {
            .content-email {
                width: 280px;
            }
            .footer::before{
                width: 200px;
                height: 106px;

            }
            ul.social-list a{
                font-size: 16px !important;
            }
            .footer{
                height: 240px;
            }
            .address {
                margin-top: 0;
            }
            .address h3 {
                font-size: 14px;
            }
            .footer::after{
                width: 60px;
                height: 51px;
            }
            .footer::before {
                width: 123px;
                height: 66px;
            }
        }
    </style>
</head>

<body style="background-color: #f6f6f6; font-family: 'Arimo'; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4;  margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" class="body">
        <tr>
            <td></td>
            <td class="container" >
                <div class="content" style="display: block; margin: 0 auto !important; max-width: 600px;" >
                    <div class="header">
                        <a target="_blank" href="{{ url('/') }}" class="logo mr-auto">
                            <table border="0" cellpadding="0" width="100%" cellspacing="0" >
                                <tr>
                                    <td>
                                        <img src="{{ asset('assets/img/email-header.png') }}" style="max-width: 600px;" alt="OMG.ID" >
                                    </td>
                                </tr>
                            </table>
                        </a>
                    </div>
                    <!-- START CENTERED WHITE CONTAINER -->
                    <table role="presentation" class="main" style="max-width: 582px; width:100%;">

                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class="wrapper" style="box-sizing: border-box; box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 15%) !important;" >
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 100% !important;">
                                    <tr>
                                        <td>
                                             <div class="content-email" style="background: #fff; width: 100%;  padding: 30px 10px 30px 10px; overflow-wrap: break-word;">
                                                @yield('content')
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- END MAIN CONTENT AREA -->
                    </table>
                    <!-- START FOOTER -->
                    <div class="footer" style="clear: both; margin-top: 10px;  text-align: center; width: 100%; background: #6103D0; background-image:url({{ asset('assets/img/email-footer.png') }});  height: 220px; position: relative; background-position-x: center; background-position-y: center; background-size: cover;">
                        <div class="text-center" style="padding:10px">
                            <h3 style="color: #D0EE26; font-family: 'Arimo'; font-weight: 700; line-height: 1.4; margin: 0;" >Temukan Kami</h3>
                            <ul class="social-list" style="list-style:none; display:inline-flex; margin-bottom: 15px;font-size: 14px; font-weight: normal;" >
                                <li>
                                    <a href="#" style="display: flex; color: #D0EE26; text-decoration: none;" >
                                        <img width="20" height="20" style="margin-right: 5px;" src="{{ asset('assets/img/instagram.png') }}"> omg.id
                                    </a>
                                </li>
                                <li>
                                    <a href="#" style="display: flex; color: #D0EE26; text-decoration: none;" >
                                       <img width="20" height="20" style="margin-right: 5px;" src="{{ asset('assets/img/twitter.png') }}"> omg.id
                                    </a>
                                </li>
                                <li>
                                    <a href="#" style="display: flex; color: #D0EE26; text-decoration: none;" >
                                        <img width="20" height="20" style="margin-right: 5px;" src="{{ asset('assets/img/email.png') }}"> omg.id
                                    </a>
                                </li>
                            </ul>
                            <div class="address" >
                                <h3 style="color: #D0EE26; font-family: 'Arimo'; font-weight: 700; line-height: 1.4; margin: 0;" >PT Qwords Company International</h3>
                                <p style="color: #D0EE26; font-size: 12px; text-align: center;" >Jl. Blotan No 18 Kayen, Desa/Kel. Wedomartani,</p>
                                <p style="color: #D0EE26; font-size: 12px; text-align: center;" >Kec. Ngemplak, Kab. Sleman, Provinsi D.I.Yogyakarta</p>
                            </div>
                            <div class="cp">
                                <p style="color: #D0EE26; font-size: 12px; text-align: center;" >&copy; {{ date('Y') }} omg.id All Rights Reserved.</p>
                            </div>

                        </div>
                       
                    </div>
                    <!-- END FOOTER -->

                    <!-- END CENTERED WHITE CONTAINER -->
                </div>
            </td>
            <td></td>
        </tr>
    </table>
</body>

</html>