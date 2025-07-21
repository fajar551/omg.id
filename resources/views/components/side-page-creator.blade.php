<style>
    .social-link-img-md {
        width: 30px;
        height: 30px;
    }
</style>

<div class="col-lg-4 d-grid align-self-start gap-3">
    @if (isset($social_links['facebook']) || isset($social_links['instagram']) || isset($social_links['twitter']) || isset($social_links['youtube']))
    <div class="card creators rounded-small shadow border-0 d-md-none d-block ">
        <div class="card-header bg-transparent border-0 pb-0 card-title fw-bold">
            Social Links
        </div>
        <div class="card-body p-0 pb-2 d-flex align-item-center justify-content-center">
            <div class="badge text-dark d-flex gap-3">
                @if (isset($social_links['facebook']))
                    <a href="https://facebook.com/{{ $social_links['facebook'] }}"><img src="{{ asset('template/images/fb.png') }}" class="social-link-img-md"/></a>
                @endif
                @if (isset($social_links['instagram']))
                    <a href="https://instagram.com/{{ $social_links['instagram'] }}"><img src="{{ asset('template/images/ig.png') }}" class="social-link-img-md"/></a>
                @endif
                @if (isset($social_links['twitter']))
                    <a href="https://twitter.com/{{ $social_links['twitter'] }}"><img src="{{ asset('template/images/tw.png') }}" class="social-link-img-md"/></a>
                @endif
                @if (isset($social_links['youtube']))
                    <a href="https://youtube.com/{{ $social_links['youtube'] }}"><img src="{{ asset('template/images/yt.png') }}" class="social-link-img-md"/></a>
                @endif
            </div>
        </div>
    </div>
    @endif
    <div class="card creators rounded-small shadow p-3 border-0 d-none d-lg-block card-dark">
        <ul class="list-group bg-transparent border-0">
            <li class="list-group-item border-0 rounded-pill {{ activeRouteName('creator.index') }}" aria-current="true">
                <a href="{{ route('creator.index', ['page_name' => $pageName]) }}" class="nav-link d-flex align-items-center justify-content-start text-primary  fw-bold t py-0 mb-0 " aria-current="page" style="font-size: 16px !important;">
                    @if (activeRouteName('creator.index'))
                    <img src="{{ asset('template/images/icon/ic_home_active.png') }}" height="25">
                    @else
                    <img src="{{ asset('template/images/icon/ic_home_inactive.png') }}" height="25">
                    @endif
                    <span class="mx-4 text-primary">Beranda</span>
                </a>
            </li>
            <li class="list-group-item border-0 rounded-pill {{ activeRouteName('creator.content') }}" aria-current="true">
                <a href="{{ route('creator.content', ['page_name' => $pageName]) }}" class="nav-link d-flex align-items-center justify-content-start text-primary  fw-bold t py-0 mb-0 " aria-current="page" style="font-size: 16px !important;">
                    @if (activeRouteName('creator.content'))
                    <img src="{{ asset('template/images/icon/ic_star_active.png') }}" height="25">
                    @else
                    <img src="{{ asset('template/images/icon/ic_star_inactive.png') }}" height="25">
                    @endif
                    <span class="mx-4 text-primary">Konten</span>
                </a>
            </li>
            <li class="list-group-item border-0 rounded-pill {{ activeRouteName('creator.savedcontent') }}" aria-current="true">
                <a href="{{ route('creator.savedcontent', ['page_name' => $pageName]) }}" class="nav-link d-flex align-items-center justify-content-start text-primary  fw-bold t py-0 mb-0 " aria-current="page" style="font-size: 16px !important;">
                    @if (activeRouteName('creator.savedcontent'))
                    <img src="{{ asset('template/images/icon/ic_saved_active.png') }}" height="25">
                    @else
                    <img src="{{ asset('template/images/icon/ic_saved_inactive.png') }}" height="25">
                    @endif
                    <span class="mx-4 text-primary">Aktif</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="card creators rounded-small shadow border-0 card-dark">
        <div class="card-header bg-transparent border-0">
            <h5 class="card-title text-center fw-bold">{{ $page['page_message'] }}</h5>
            <p class="text-center fs-6 m-0">{{ $page['bio'] }}</p>
        </div>
        @if (!empty($creatorGoal))
            <div class="card-body text-center">
                <div class="card bg-primary shadow-0" style="border-radius: 8px;">
                    <div class="px-3 py-3 bg-subprogress m-auto w-100">
                        <span class="text-white" style="font-size: 18px; font-weight: 400;">{{ $creatorGoal['goal']['title'] . ' ' . $creatorGoal['goalProgress']['progress'] . '%' }}</span>
                        @include('components.goal-progress-sm', [
                            'progress' => $creatorGoal['goalProgress']['progress'],
                        ])
                        @if ($creatorGoal['goal']['target_visibility'] == 1)
                            <div class="d-flex justify-content-between">
                                <span class="text-sm text-white">{{ $creatorGoal['goalProgress']['formated_target_achieved'] }}</span>
                                <span class="text-sm text-white">{{ $creatorGoal['goal']['formated_target'] }}</span>
                            </div>
                        @endif
                        <button class="btn btn-secondary btn-sm mt-3 rounded-pill px-4 bg-button-white btn-bagi" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="font-size: 10px;">
                            BAGI YUK!
                        </button>
                    </div>
                </div>
            </div>
        @endif
        @include('components.cardcreatorpopup')
    </div>
    @if (!empty($page['summary']))
        <div class="card creators rounded-small shadow border-0 d-none d-md-block card-dark">
            <div class="card-header bg-transparent border-0">
                <h5 class="card-title text-center fw-bold m-0">Summary</h5>
            </div>
            <div class="card-body">
                <p class="text-center fs-6 m-0">
                    {{ $page['summary'] }}
                </p>
            </div>
        </div>
    @endif
    @if (!empty($page['video']))
        <div class="card creators rounded-small shadow border-0 card-dark">
            <div class="card-body">
                {{-- <h5 class="card-title text-center fw-bold">
                Video
            </h5> --}}
                <iframe height="250" width="100%" src="{{ $page['video'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    @endif
    
</div>
