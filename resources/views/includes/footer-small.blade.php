<div class="container-fluid footer mt-auto" >
    <footer class="container container-footer">
        <div class="card shadow rounded-top footer-dark">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="d-flex justify-content-md-start justify-content-center align-items-center">
                            <li class="nav-item nav-footer">
                                <a class="nav-link text-dark" href=" {{ route('pages.termofservice') }} ">@lang('page.terms_and_condition')</a>
                            </li>
                            <li class="nav-item nav-footer">
                                <div class="padding-ic pb-1">
                                    <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="3" cy="3" r="3" fill="#7422D6" />
                                    </svg>
                                </div>
                            </li>
                            <li class="nav-item nav-footer">
                                <a class="nav-link text-dark" href=" {{ route('pages.privacypolice') }}">@lang('page.privacy_police')</a>
                            </li>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <li class="nav-item nav-footer text-md-end text-center">
                            <a class="nav-link" href="/"><span class="text-dark">&copy;Copyright</span> <strong>{{ env('APP_NAME', 'OMG.ID Dev ') }}</strong></a>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
