<script type="text/javascript" src="{{ asset('template/vendor/jquery/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/vendor/bootstrap-5/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/vendor/bootstrap-5/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/scroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/axios.js') }}"></script>
<script type="text/javascript" src="{{ route('lang') }}"></script>
<script type="text/javascript" src="{{ route('vars.omg.js') }}"></script>

@if (Auth::check())
<script type="text/javascript" src="{{ asset('js/echo.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/notification-v2.1.js') }}"></script>
@endif

<script type="text/javascript">
    const api_url = '{!! url('api') !!}/';
    const app_url = '{!! url('') !!}/';

    function loaderPage() {
        setTimeout(function () {
            document.getElementById("loader").style.display = "none";
            document.getElementById("myDiv").style.display = "block";
        }, 200);
    }

    $(() => {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-tooltip="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
    
    /*
    $(() => {
        var css = `
            <style type="text/css">
                body::-webkit-scrollbar {
                    width: 5px;
                    background-color: #F5F5F5;
                }

                body::-webkit-scrollbar-thumb {
                    background-color: #6610f2;
                }

                body::-webkit-scrollbar-track {
                    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                    background-color: #F5F5F5;
                }
            </style>`;

        setTimeout(() => {
            $("#overlay-preview").contents().find("head").append(css);
        }, 5000);
    });
    */
</script>