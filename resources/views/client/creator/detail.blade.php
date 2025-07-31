@extends('layouts.template-support')

@section('title')
    @if ($content)
        {{ "{$content->title} - @{$content->user->page->page_url} - " .env('APP_NAME') }}
    @else
        @lang('Content Detail')
    @endif
@endsection

@section('meta')
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ request()->getUri() }}" />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />

    @if ($content)
    <meta property="og:title" content="{{ $content->title }}" />
    <meta property="og:description" content="Yuk baca {{ $content->title }} hanya di {{ env('APP_NAME') }}" />
    <meta property="article:author" content="{{ $content->user->name }}" />
    <meta property="article:published_time" content="{{ $content->created_at }}" />
    <meta property="article:modified_time" content="{{ $content->updated_at }}" />
    <meta property="og:image" content="{{ $content->thumbnail_path }}" />
    <meta name="twitter:title" content="{{ $content->title }}" />
    <meta name="twitter:description" content="Yuk baca {{ $content->title }} hanya di {{ env('APP_NAME') }}" />
    <meta name="twitter:site" content="{{ env('APP_NAME') }}" />
    <meta name="twitter:creator" content="{{ $content->user->name }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:image" content="{{ $content->thumbnail_path }}" />
    <meta name="twitter:image:alt" content="Thumbnail of content {{ $content->title }}" />
    @endif
@endsection

@section('styles')
    <link href="{{ asset('template/vendor/animate.css/css/animate.min.css') }}" rel="stylesheet">
    <style>
        .card-detail {
            background: #FFFFFF;
            border: 0.2px solid #DDDDDD;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .pargraf {
            font-family: 'HelveticaNeue';
            font-weight: 400;
            font-size: 16px;
            line-height: 19px;
            color: #141414;
        }
        .borderdetail {
            border-bottom: 1px solid #C4C4C4;
        }
        .icon-comment-report, .icon-comment-like {
            width: 26px;
            height: 26px;
            cursor: pointer;
        }
        .icon-comment-report:hover, .icon-comment-like:hover {
            transform: scale(1.1);
            transition: 0.25s;
            cursor: pointer;
        }
        .user-avatar-add-comment, .user-avatar-list-comment {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
        .icon-content-like, .icon-comment, .icon-share, .icon-bookmark {
            width: 30px;
            height: 26px;
            object-fit: cover;   
        }
        .icon-content-like:hover, .icon-comment:hover, .icon-share:hover, .icon-bookmark:hover {
            transform: scale(1.1);
            transition: 0.25s;
            cursor: pointer; 
        }
        .link-disabled {
            color: currentColor;
            cursor: not-allowed;
            opacity: 0.5;
            text-decoration: none;
            pointer-events: none;
        }
        @media (max-width: 425px) {
            .user-avatar-add-comment, .user-avatar-list-comment {
                width: 35px;
                height: 35px;
            }
        }
        pre {
            font-family: "Helvetica Neue" !important;
            font-size: 14pt !important;
            white-space: pre-wrap !important;
        }
        textarea {
            overflow: hidden;
        }
        
        /* Social Share */
        #social-links ul{
            padding-left: 0;
            display: flex;
            justify-content: center;
            width: 100%;
        }
        #social-links ul li {
            display: inline-block;
            margin: 4px;
        } 
        #social-links ul li a {
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 1px;
            font-size: 25px;
        }
        #social-links .fa-facebook{
            color: #0d6efd;
        }
        #social-links .fa-twitter{
            color: deepskyblue;
        }
        #social-links .fa-linkedin{
            color: #0e76a8;
        }
        #social-links .fa-whatsapp{
            color: #25D366
        }
        #social-links .fa-reddit{
            color: #FF4500;;
        }
        #social-links .fa-telegram{
            color: #0088cc;
        }
        .card-hover:hover {
            transform: scale(1.03);
            transition: 0.5ms;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            border-radius: 8px;
        }
        .text-elipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* number of lines to show */
                    line-clamp: 2; 
            -webkit-box-orient: vertical;
        }

        .blured {
            backdrop-filter: blur(5px);
        }
    </style>
@endsection

@section('content')
    <section class="section min-vh-100 bg-light m-0">
        <div class="container px-lg-5 px-3 pt-3 mt-5" data-aos="zoom-in-up" data-aos-duration="800">
            <div class="row mb-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb ">
                            <li class="breadcrumb-item fs-5 active" aria-current="page">
                                <a class="fw-semibold" href="{{ url()->previous() }}">
                                    @lang('Kembali')
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                @if(!$access || !auth()->check())
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="card card-detail rounded-small shadow border-0 card-dark">
                        <div class="card-body p-lg-5 text-center">
                            {{ $message }}
                            @if (!auth()->check())
                            <div class="mt-3">
                                <a href="{{route('login')}}" class="btn btn-primary rounded-pill w-50">Login</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="card card-detail rounded-small shadow border-0 card-dark">
                        <div class="card-body p-lg-5">
                            <h2 class="fw-semibold">{{ $content->title }} </h2>
                            <div class="col mt-20">
                                <img src="{{ $content->thumbnail_path ?? asset('template/images/content_thumbnail.png') }}" alt="" class="img-fluid border border-2" style="border-radius: 8px !important; width: 100%; height: 250px; object-fit:cover;">
                            </div>
                            <div class="mt-20">
                                <p class="text-muted text-sm">by {{ $content->user->name }}</p>
                            </div>
                            <div class="deskripsi">
                                <div id="editorjs" spellcheck="false" class="ps-3 pe-3 rounded"></div>
                            </div>
                            @if ($content->file || $content->external_link)
                            <span class="mb-3">External Link dan Downloadable File: </span>
                            <ul>
                                @if ($content->file)
                                <li>
                                    <a href="{{ route('content.download', ['id' => $content->id]) }}" class=""> Downloadable File </a>
                                </li>
                                @endif
                                @if ($content->external_link)
                                <li>
                                    <a href="{{ $content->external_link }}" class=""> External Link </a>
                                </li>
                                @endif
                            </ul>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-12 d-flex justify-content-between align-items-center px-0 mt-3">
                        <div class="col-lg-5 col-sm-12">
                            <div class="card card-detail rounded-small shadow bg-info border-primary card-dark">
                                <div class="card-body d-flex justify-content-center gap-2">
                                    <div class="d-flex lign-items-center">
                                        <a href="javascript:void(0);" data-id="{{ $content->id }}" class="content-like">
                                        @if ($content->likes && auth()->check())
                                            @if (Utils::in_array_multidim(auth()->user()->id, $content->likes->toArray(), 'user_id'))
                                            <img src="{{ asset('template/images/icon/content_like_fill.svg') }}" class="icon-content-like" title="Klik to Unlike"/>
                                            @else 
                                            <img src="{{ asset('template/images/icon/content_like_outline.svg') }}" class="icon-content-like" title="Klik to Like"/>
                                            @endif
                                        @else
                                        <img src="{{ asset('template/images/icon/content_like_outline.svg') }}" class="icon-content-like" title="Klik to Like"/>
                                        @endif
                                        </a>
                                        <div class="text-primary mx-1 pt-2" id="content-like-counting-{{ $content->id }}">{{ Utils::kNFormatter($content->likes_count) }}</div>
                                    </div>
                                    <div class="d-flex lign-items-center mx-2">
                                        <a href="#scrollToComment" title="Komentar">
                                            <img src="{{ asset('template/images/ic_chat.svg') }}" alt="" class="icon-comment">
                                        </a>
                                        <div class="text-primary mx-1 pt-2">{{ Utils::kNFormatter($content->comments_count) }}</div>
                                    </div>
                                    {{-- <div class="d-flex lign-items-center" title="Berlangganan">
                                        <a href="javascript:void(0);">
                                            <img src="{{ asset('template/images/ic_bookmark.svg') }}" alt="" class="icon-bookmark">
                                        </a>
                                        <div class="text-primary mx-1 pt-2">{{ $content->subscribe_count }}</div>
                                    </div> --}}
                                    <div class="d-flex lign-items-center mx-2">
                                        <a  href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#socialModal" title="Bagikan konten ini">
                                            <img src="{{ asset('template/images/ic_share.svg') }}" alt="" class="icon-share">
                                        </a>
                                        {{-- <div class="text-primary mx-1 pt-2">30</div> --}}
                                    </div>
                                    <!-- Modal  Share-->
                                    <div class="modal fade" id="socialModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="socialModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="socialModalLabel">Bagikan ke</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                {!! $socialShare !!}
                                                </div>
                                                {{-- <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Share</button>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="d-none d-lg-block btn-karya-lain" href="{{ route('creator.content', ['page_name' => $pageDetail['page_url']]) }}" role="button">
                            <span class="mx-2 fs-6 fw-bold">Lihat Karya Lainnya</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="card border-0 card-detail rounded-small shadow p-3 card-dark">
                            <div class="card-body row p-0">
                                <div class="col-12">
                                    <div class="d-flex align-items-center ">
                                        <img src="{{ $pageDetail['avatar'] ?? asset('template/images/user-detail.png') }}" height="87" width="87" class="shadow-sm rounded-pill border border-2" />
                                        <div class="content-profile mx-3 w-100">
                                            <h6 class="font-creator fw-semibold my-0">
                                                {{ $pageDetail['name'] }}
                                            </h6>
                                            <p>
                                                <a href="{{ route('creator.index', ['page_name' => $pageDetail['page_url']]) }}" class="btn btn-link text-primary p-0" target="_blank">
                                                    <small class=""><span>@</span>{{ $pageDetail['page_url'] }}</small>
                                                </a>
                                            </p>
                                            
                                            <span clasa="fw-semibold  font-creator "> 
                                                <span class="font-creator">Followers <span class="followers-count" data-followers="{{ $pageDetail['follow_detail']['followers_count'] }}">{{ Utils::kNFormatter($pageDetail['follow_detail']['followers_count']) }}</span></span> 
                                                <span class=" font-creator">&bullet;</span> 
                                                <span class=" font-creator">Following <span class="following-count" data-following="{{ $pageDetail['follow_detail']['followings_count'] }}">{{ Utils::kNFormatter($pageDetail['follow_detail']['followings_count']) }}</span></span> 
                                            </span>

                                            <div class="d-flex flex-md-row flex-column mt-2 gap-2">
                                                <div class="d-flex gap-2">
                                                    <button class="btn {{ $pageDetail['follow_detail']['isFollowing'] ? 'btn-outline-primary' : 'btn-primary' }} btn-sm px-4 btn-follow w-100" id="btn-follow" data-id="{{ $pageDetail['user_id'] }}" style="font-size: 10px;" title="Follow atau Unfollow"> {{ $pageDetail['follow_detail']['isFollowing'] ? 'UNFOLLOW' : 'FOLLOW' }} </button>
                                                    <button class="btn btn-info btn-sm btn-support w-100" id="btn-support" style="font-size: 10px;" title="Dukung Kreator" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> BAGI YUK! </button>
                                                </div>
                                                <a href="{{ route('report.index') . '?link=' . Request::fullUrl() . '&type=creator' }} @if (auth()->check()) {{ '&email=' . auth()->user()->email . '&name=' . auth()->user()->name }} @endif"
                                                    class="btn btn-outline-warning btn-sm" style="font-size: 10px;"
                                                    data-toggle="tooltip" data-placement="top" title="Laporkan" target="_blank">
                                                    <i class="ri-error-warning-line" style="font-size: 15px;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('components.cardcreatorpopup')

                    </div>

                    <div class="col-12 mt-4" data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">
                        <h5>{{ $content->comments_count }} Komentar</h5>
                    </div>

                    <div class="col-12 mt-20" id="scrollToComment">
                        <div class="card border-0 card-detail rounded-small shadow p-3 card-dark">
                            <div class="card-body p-2 mb-3">
                                <div class="col-12 row ">
                                    <div class="col-2">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <img src="{{ auth()->check() ? auth()->user()->profile_picture_path : asset("template/images/user/user.png") }}" class="user-avatar-add-comment rounded-circle bg-white border shadow-sm" />
                                        </div>
                                    </div>
                                    <div class="col-10 p-0">
                                        <form action="" method="POST" class="mt-2 needs-validation" id="addcomment-form" enctype="multipart/form-data" autocomplete="off">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $content->id }}" required>
                                            <div class="form-group mb-3">
                                                <h6 class="fw-semibold">{!! auth()->check() ? 'Comments as ' .'<span class="fw-bold">' .auth()->user()->name .'</span>' : 'Login untuk memberikan komentar' !!}</h6>
                                                <textarea name="body" class="form-control" rows="3" placeholder="Tuliskan komentar Anda" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                @if (auth()->check())
                                                <button type="submit" class="btn btn-outline-primary rounded-pill" id="btn-addcomment">Submit</button>
                                                @else
                                                <a href="{{route('login')}}" class="btn btn-primary rounded-pill">Login</a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <hr class="mt-4">
                            </div>
                            <div id="comment-section">
                                @guest
                                    @forelse ($content->comments->take(3) as $comment)
                                    <div class="card-body p-2" id="comment-wrapper-{{ $comment->id }}">
                                        <div class="col-12 row ">
                                            <div class="col-2">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <img src="{{ $comment->user->profile_picture_path }}" class="user-avatar-list-comment rounded-circle bg-white border shadow-sm" />
                                                </div>
                                            </div>
                                            <div class="col-10 p-0">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="fw-semibold">{{ $comment->user->name }}</h6>
                                                    @if (auth()->check())
                                                        @if ($comment->user->id == auth()->user()->id)
                                                        <div class="dropdown">
                                                            <button class="btn btn-transaprent btn-sm dropdown-toggle drop-comment p-1" type="button" id="drop-action1" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 5px;" title="Kelola">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </button>
                                                            <ul class="dropdown-menu bg-white border-1 shadow" aria-labelledby="drop-action1">
                                                                <li><a href="javascript:void(0);" class="dropdown-item btn-edit" data-id="{{ $comment->id }}"> Edit Komentar</a></li>
                                                                <li><a href="javascript:void(0);" class="dropdown-item btn-delete" data-id="{{ $comment->id }}"> Hapus Komentar</a></li>
                                                            </ul>
                                                        </div>
                                                        @endif
                                                    @endif
                                                </div>
                                                <pre class="py-0 my-0 comment-body-{{ $comment->id }}" style="font-size: 16px">{{ trim($comment->body) }}</pre>
                                                <div class="d-flex mt-2">
                                                    <div class="d-flex align-items-center" data-id="{{ $comment->id }}">
                                                        <div class="like-container">
                                                            <a href="javascript:void(0);" data-id="{{ $comment->id }}" class="comment-like">
                                                            @if ($comment->likes && auth()->check())
                                                                @if (Utils::in_array_multidim(auth()->user()->id, $comment->likes->toArray(), 'user_id'))
                                                                <img src="{{ asset('template/images/icon/wpf_like_ac.svg') }}" class="icon-comment-like" title="Klik to Unlike"/>
                                                                @else 
                                                                <img src="{{ asset('template/images/icon/wpf_like.svg') }}" class="icon-comment-like" title="Klik to Like"/>
                                                                @endif
                                                            @else
                                                            <img src="{{ asset('template/images/icon/wpf_like.svg') }}" class="icon-comment-like" title="Klik to Like"/>
                                                            @endif
                                                            </a>
                                                        </div>
                                                        <span class="mx-2 text-sm"><span id="comment-like-counting-{{ $comment->id }}">{{ $comment->likes_count }}</span> Suka</span>
                                                    </div>
                                                    <div class="d-flex align-items-center mx-2">
                                                        <a href="{{ route('report.index') . '?link=' . Request::fullUrl() . '&type=comment' }} @if (auth()->check()) {{ '&email=' . auth()->user()->email . '&name=' . auth()->user()->name }} @endif" class="mx-2 text-sm text-dark"
                                                            data-toggle="tooltip" data-placement="top" title="Laporkan" target="_blank">
                                                            <img src="{{ asset('template/images/icon/warning.svg') }}" class="icon-comment-report" />
                                                            Laporkan
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr class="mt-3">
                                            </div>
                                        </div>
                                    </div>
                                    @if ($loop->last)
                                    <div class="row d-flex justify-content-center mt-4 mb-3">
                                        <div class="col-lg-5 col-sm-12 ">
                                            <span class="text-center">Login untuk melihat semua komentar</span>
                                        </div>
                                    </div> 
                                    @endif
                                    @empty
                                    <div class="d-flex justify-content-center" id="no-comment">
                                        <span class="text-center mb-3">Belum ada komentar</span>
                                    </div>
                                    @endforelse
                                @endguest
                            </div>
                            @if ($content->comments_count > 0 && auth()->check())
                            <div class="row d-flex justify-content-center mt-4 mb-4">
                                <div class="col-lg-5 col-sm-12 ">
                                    <button class="btn btn-outline-primary rounded-pill d-block w-100 load-more">Tampilkan lebih banyak</button>
                                </div>
                            </div> 
                            @endif
                            @if (!$content->comments_count && auth()->check())
                            <div class="d-flex justify-content-center mb-3" id="no-comment">
                                <span class="text-center">Belum ada komentar</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-3 d-none d-lg-block">
                    <div class="card border-0 card-detail rounded-small shadow pt-3 pb-4 card-dark">
                        <div class="card-h pt- px-3">
                            <h6 class="fw-bold">Karya Spesial Untukmu</h6>
                        </div>
                        
                        @forelse ($relatedContent as $related)
                        @if ($related->user->page)
                            @php
                                // TODO: Improve this, do not make a logic directly on blade file 
                                $blured = '';
                                if (!auth()->check()) {
                                    if ($related->qty > 0) {
                                        $blured = 'blured';
                                    }
                                } else {
                                    if ($related->user_id == auth()->user()->id) {
                                        return;
                                    }

                                    $hasSubscribed = $related->subscribe()->where([
                                        'user_id' => auth()->user()->id, 
                                        'content_id' => $related->id,
                                        'status' => 1
                                    ])->first();

                                    // Paid content
                                    if ($related->qty > 0) {
                                        // The content not subscribed
                                        if (!$hasSubscribed) {
                                            $blured = 'blured';
                                        }
                                    }
                                }

                                $route = $blured ? 'creator.content' : 'creator.contentdetail';
                            @endphp
                            <a href="{{ route($route, ['page_name' => $related->user->page->page_url, 'slug' => $related->slug]) }}">
                                <div class="card-body card-hover p-1 m-2 related-content" data-id="">
                                    {{-- <img src="{{ $related->thumbnail_path ?? asset('template/images/ratangle-res.png') }}" class="img-fluid " style="border-radius=8px; width:100%; max-height:110px; object-fit:cover; backdrop-filter: blur(5px);" /> --}}
                                    <div class="position-relative">
                                        <img src="{{ $related->thumbnail_path ?? asset('template/images/content_thumbnail.png') }}" class="img-fluid " style="border-radius:8px; width:100%; max-height:110px; min-height:110px; object-fit:cover; " />
                                        <div class="bg-card-creator position-absolute {{ $blured }}" style="border-radius:8px;"></div>
                                        <span class="badge bg-secondary text-dark position-absolute top-0 end-0 m-2">{{ $related->qty == 0 ? 'Free' : '' }}</span>
                                    </div>
                                    <div class="mt-2 "><span class="text-sm" style="font-size: 8px;"> TOPIC</span></div>
                                    <span class="mt-2 text-sm text-dark text-elipsis" tyle="font-size: 10px;">{{ $related->title }}</span>
                                </div>
                            </a>
                            <hr class="mb-2 ms-2 me-2">
                        @endif
                        @empty
                            <small class="text-center mt-3">Tidak ada data</small>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/editor.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/header-2.6.2.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/paragraph-2.8.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/image-2.6.2.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/simple-image-1.4.1.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/list-1.7.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/nested-list-1.0.2.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/checklist-1.3.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/link-2.4.1.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/delimiter-1.2.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/code-2.7.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/inline-code-1.3.1.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/marker-1.2.2.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/quote-2.4.0.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/embed-2.5.1.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/paragraph-with-alignment-3.0.1.min.js') }}"></script>
    <script src="{{ asset('template/vendor/editorjs/ext/editorjs-alert-1.0.3.min.js') }}"></script>
    <script src="{{ asset('template/vendor/serialize-json/jquery.serializejson.min.js') }}"></script>
    <script src="{{ asset('assets/js/share.js') }}"></script>
    <script> const pageName = '{{ $page['page_url'] }}'; </script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('template/js/bootstrap-input-spinner.js')}}" type="text/javascript"></script>
    @if (env('APP_ENV') == 'production')
    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-yXcEzjhVAqWaf3qm"></script>
    @else
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-yXcEzjhVAqWaf3qm"></script>
    @endif
    <script src="{{ asset('assets/js/support-v1.1.js') }}" type="text/javascript"></script>
    <script>
        /**
        * Creator page detail script
        * Version: 1.0
        */
        (function ($) {
            "use strict";

            // If the content is not locked
            @if ($content && auth()->check())

            const contentId = "{{ $content->id }}";
            const authId = "{{ auth()->check() ? auth()->user()->id : '' }}";
            const authCheck = "{{ auth()->check() }}";
            let editor = null;
            let nextPage = 1;
            let isLastPage = false;

            // Editor JS
            editor = new EditorJS({
                holder: 'editorjs',
                autofocus: false,
                placeholder: 'No Content',
                readOnly: true,
                onReady: () => {
                    // console.log('Editor.js is ready to work!');
                },
                onChange: (args) => {
                    // console.log('Editor\'s content changed!' + JSON.stringify(args.blocks));
                },
                tools: {
                    header: {
                        class: Header,
                        inlineToolbar : true
                    },
                    delimiter: Delimiter,
                    paragraph: {
                        class: Paragraph,
                        inlineToolbar: true,
                    },
                    list: {
                        class: List,
                        inlineToolbar: true,
                        config: {
                            defaultStyle: 'unordered'
                        }
                    },
                    nestedlist: {
                        class: NestedList,
                        inlineToolbar: true,
                    },
                    checklist: {
                        class: Checklist,
                        inlineToolbar: true,
                    },
                    linkTool: {
                        class: LinkTool,
                    },
                    Marker: {
                        class: Marker,
                    },
                    inlineCode: {
                        class: InlineCode,
                    },
                    alert: {
                        class: Alert,
                        inlineToolbar: true,
                        config: {
                            title: 'Judul',
                            desc: 'Deskripsi'
                        }
                    },
                    image: {
                        class: ImageTool,
                    },
                    code: CodeTool,
                    quote: {
                        class: Quote,
                        inlineToolbar: true,
                        config: {
                            quotePlaceholder: 'Masukan Quote',
                            captionPlaceholder: 'Penulis Quote',
                        },
                    },
                    // image: SimpleImage,
                    embed: Embed,
                }
            });

            const renderContent = async () => {
                @if ($body = json_encode($content->body))
                    let blocks = {!! $body !!};
                    if (editor) {
                        await editor.isReady.then(() => {
                            if (!blocks) {
                                console.log('Block body is empty!');
                                return;
                            }

                            editor.blocks.render(blocks); 
                            // console.log('Editor.js is ready to work!');
                        }).catch((reason) => {
                            console.log(`Editor.js initialization failed because of ${reason}`)
                        });
                    } else {
                        console.log('Editor.js not initialization'); 
                    }
                @endif
            }
            @endif

            // If the user already logged in 
            @if (auth()->check() && $content)

            const like = async (type, id, wrapper) => {
                if (!type && !id && !wrapper) {
                    console.log('Missing required parameter!');
                    return;
                }
                
                if (!['content', 'comment'].includes(type)) {
                    console.log('The type must be in content or comment!');
                    return;
                }

                let url = `/api/content/like`;
                if (type == 'comment') {
                    url = `/api/content/comment/like`;
                } 

                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('id', id);
                
                $(wrapper).addClass('link-disabled');
                await axios.post(url, formData)
                    .then(({ data }) => {
                        const { message = 'Success!', data: result = {} } = data;

                        let likeCountWrapper = $(`#${type}-like-counting-${id}`);
                        let likeCount = parseInt(likeCountWrapper.html());

                        if (result.like) {
                            if (type == 'content') {
                                $(wrapper).html(`<img src="{{ asset('template/images/icon/content_like_fill.svg') }}" class="icon-content-like" title="Klik to Unlike"/>`);
                            } else {
                                $(wrapper).html(`<img src="{{ asset('template/images/icon/wpf_like_ac.svg') }}" class="icon-comment-like" title="Klik to Unlike"/>`);
                            }
                            
                            likeCountWrapper.html(++likeCount);
                        } else {
                            if (type == 'content') {
                                $(wrapper).html(`<img src="{{ asset('template/images/icon/content_like_outline.svg') }}" class="icon-content-like" title="Klik to Like"/>`);
                            } else {
                                $(wrapper).html(`<img src="{{ asset('template/images/icon/wpf_like.svg') }}" class="icon-comment-like" title="Klik to Like"/>`);
                            }

                            likeCountWrapper.html(--likeCount);
                        }
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;

                        Toast2.fire({ 
                            icon: 'error', 
                            title: message 
                        });
                    }).finally(() => {
                        $(wrapper).removeClass('link-disabled');
                    });
            }

            const follow = async (id) => {
                const formData = new FormData();
                formData.append('user_id', id);
                
                $('#btn-follow').attr({"disabled": true}).html('Loading...');
                const result = await axios.post(`/api/follow`, formData)
                    .then(({ data }) => {
                        const { message = 'Success!', data: result = {} } = data;
                        const { follow = false, info = '' } = result;

                        let counting = 0;
                        let followCountWrapper = $(`.followers-count`);
                        let followCount = parseInt(followCountWrapper.data('followers'));
                        if (follow) {
                            $('#btn-follow').addClass('btn-outline-primary');
                            $('#btn-follow').removeClass('btn-primary');
                            $('#btn-follow').text('UNFOLLOW');

                            counting = ++followCount;
                        } else {
                            $('#btn-follow').removeClass('btn-outline-primary');
                            $('#btn-follow').addClass('btn-primary');
                            $('#btn-follow').text('FOLLOW');

                            counting = --followCount;
                        }
                        
                        followCountWrapper.html(kNFormatter(counting));
                        followCountWrapper.data('followers', counting);

                        Toast2.fire({
                            icon: follow ? 'info' : 'warning',
                            title: follow ? 'Following' : 'Unfollowing',
                            html: info
                        });

                        return data;
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;

                        Toast2.fire({ 
                            icon: 'error', 
                            title: message 
                        });
                    }).finally(() => {
                        $('#btn-follow').attr({"disabled": false}).text($('#btn-follow').text());
                    });
            }

            const comment = async () => {
                const formData = $('#addcomment-form').serializeJSON();
                
                $('#btn-addcomment').attr({"disabled": true}).html('Loading...');
                await axios.post(`/api/content/comment/create`, formData)
                    .then(({ data }) => {
                        const { message = 'Success!', data: result = {} } = data;

                        renderNewComment(result);

                        return data;
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;

                        Toast2.fire({ 
                            icon: 'error', 
                            title: message 
                        });

                        return data;
                    }).finally(() => {
                        $('#btn-addcomment').attr({"disabled": false}).html('Submit');
                    });
            }

            const commentDelete = async (id) => {
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                formData.append('id', id);
                
                await axios.post(`/api/content/comment/${id}/delete`, formData)
                    .then(({ data }) => {
                        const { message = 'Success!', data: result = {} } = data;

                        $(`#comment-wrapper-${id}`).fadeOut(300, function() { $(this).remove();});

                        return data;
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;

                        Toast2.fire({ 
                            icon: 'error', 
                            title: message 
                        });

                        return data;
                    }).finally(() => {

                    });
            }

            const commentUpdate = async (id, body) => {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('body', body);
                
                await axios.post(`/api/content/comment/update`, formData)
                    .then(({ data }) => {
                        const { message = 'Success!', data: result = {} } = data;

                        Toast2.fire({ 
                            icon: 'success', 
                            title: message 
                        });

                        return data;
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;

                        Toast2.fire({ 
                            icon: 'error', 
                            title: message 
                        });

                        return data;
                    }).finally(() => {

                    });
            }
            
            const loadComment = async () => {
                $('.load-more').attr({"disabled": true}).html('Loading...');
                
                await axios.get(`/api/content/${contentId}/comments?page=${nextPage}`)
                    .then(({ data }) => {
                        const { message = 'Success!', data: result = {} } = data;

                        nextPage = getNextPage(result.meta.next_page_url);
                        renderComment(result.comments);

                        return data;
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;

                        Toast2.fire({ 
                            icon: 'error', 
                            title: message 
                        });

                        return data;
                    }).finally(() => {
                        $('.load-more').attr({"disabled": false}).html('Tampilkan lebih banyak');
                    });
            }

            const renderNewComment = (comment) => {
                if (!comment) return;

                let html = commentTemplate(comment);

                $('#addcomment-form')[0].reset();
                $('#comment-section').prepend(html);
                $("#comment-section").get(0).scrollIntoView();
                $('#no-comment').addClass('d-none');
            }

            const renderComment = (comments) => {
                if (!comments) return;

                let html = comments.map((comment, index) => {
                    return commentTemplate(comment);
                }).join('');

                $('#comment-section').append(html);
            }
            
            const getNextPage = (link) => { 
                if (!link) return null;

                const url = new URL(link);
                const qParams = new URLSearchParams(url.search);

                return qParams.get('page');
            }

            const in_array_multidim = (needle, heyStack, key) => {
                return heyStack.filter(item => item[key] == needle).length;
            }

            const commentTemplate = (comment) => {
                // Like toggle to determine if the comment is like by the logged in user
                let likeToggle = `<img src="{{ asset('template/images/icon/wpf_like.svg') }}" class="icon-comment-like" title="Klik to Like"/>`;
                if (comment.likes.length && authCheck == 1) {
                    if (in_array_multidim(authId, comment.likes, 'user_id')) {
                        likeToggle = `<img src="{{ asset('template/images/icon/wpf_like_ac.svg') }}" class="icon-comment-like" title="Klik to Unlike"/>`;
                    }
                }

                // Action toggle comment three dot on right side
                let actionToogle = '';
                if (comment.user.id == authId) {
                    actionToogle = `<div class="dropdown">
                                        <button class="btn btn-transaprent btn-sm dropdown-toggle drop-comment p-1" type="button" id="drop-action1" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 5px;" title="Kelola">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu bg-white border-1 shadow" aria-labelledby="drop-action1">
                                            <li><a href="javascript:void(0);" class="dropdown-item btn-edit" data-id="${ comment.id }"> Edit Komentar</a></li>
                                            <li><a href="javascript:void(0);" class="dropdown-item btn-delete" data-id="${ comment.id }"> Hapus Komentar</a></li>
                                        </ul>
                                    </div>`;
                }

                return `<div class="card-body p-2 animate__animated animate__flash" id="comment-wrapper-${ comment.id }">
                            <div class="col-12 row ">
                                <div class="col-2">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="${ comment.user.profile_picture_path }" class="user-avatar-list-comment rounded-circle bg-white border shadow-sm" />
                                    </div>
                                </div>
                                <div class="col-10 p-0">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-semibold">${ comment.user.name }</h6>
                                        ${ actionToogle }
                                    </div>
                                    <pre class="py-0 my-0 comment-body-${ comment.id }" style="font-size: 16px">${ sanitize(comment.body) }</pre>
                                    <div class="d-flex mt-2">
                                        <div class="d-flex align-items-center" data-id="${ comment.id }">
                                            <div class="like-container">
                                                <a href="javascript:void(0);" data-id="${ comment.id }" class="comment-like">
                                                ${ likeToggle }
                                                </a>
                                            </div>
                                            <span class="mx-2 text-sm"><span id="comment-like-counting-${ comment.id }">${ comment.likes_count }</span> Suka</span>
                                        </div>
                                        <div class="d-flex align-items-center mx-2">
                                            <a href="{{ route('report.index') . '?link=' . Request::fullUrl() . '&type=comment' }} @if (auth()->check()) {{ '&email=' . auth()->user()->email . '&name=' . auth()->user()->name }} @endif" class="mx-2 text-sm text-dark"
                                                data-toggle="tooltip" data-placement="top" title="Laporkan" target="_blank">
                                                <img src="{{ asset('template/images/icon/warning.svg') }}" class="icon-comment-report" />
                                                Laporkan
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="mt-3">
                                </div>
                            </div>
                        </div>`;
            }

            function changeDivToTextarea(id) {
                let value = $(`.comment-body-${id}`).text().trim();
                let editableText = $(`<textarea name="comment-body-editable" class="form-control notif border-0 px-0" data-id="${id}" rows="3">${ value }</textarea>`);

                $(`.comment-body-${id}`).replaceWith(editableText);
                editableText.focus();

                // setup the blur event for this new textarea
                editableText.blur(changeDivToParagraph);
            }

            function changeDivToParagraph() {
                let value = $(this).val().trim();
                if (!value) {
                    Toast2.fire({ 
                        icon: 'error', 
                        title: 'Komentar masih kosong!' 
                    });

                    return;
                }

                let id = $(this).attr('data-id');
                let viewableText = $(`<pre class="py-0 my-0 comment-body-${ id }" style="font-size: 16px">${sanitize(value)}</pre>`);
                
                $(this).replaceWith(viewableText);
                
                commentUpdate(id, value);

                // setup the click event for this new div
                // viewableText.click(changeDivToTextarea);
            }

            function sanitize(text) {
                return $('<div>').text(text).html();
            }

            /* Load the content body to editor.js */
            renderContent();
            
            /* Load the comment by ajax call */
            loadComment();
        
            /* Content like */
            $(document).on('click', '.content-like', function() {
                like('content', $(this).attr('data-id'), this);
            });

            /* Comment like */
            $(document).on('click', '.comment-like', function() {
                like('comment', $(this).attr('data-id'), this);
            });

            /* Comment add */
            $(document).on('submit', '#addcomment-form', function() {
                comment();
                return false;
            });

            /* Comment delete */
            $(document).on('click', '.btn-delete', function(e) {
                ToastDelete.fire({
                    title: '@lang("page.sure")',
                    html: '@lang("page.sure_comment_delete")',
                }).then((result) => {
                    if (result.isConfirmed) {
                        commentDelete($(this).attr('data-id'));
                    }
                });
            });

            /* Comment edit */
            $(document).on('click', '.btn-edit', function(e) {
                changeDivToTextarea($(this).attr('data-id'));
            });

            /* Load more comment */
            $(document).on('click', '.load-more', function(e) {
                if (nextPage) {
                    loadComment();
                } else {
                    if (!isLastPage) {
                        isLastPage = true;
                        let html = `<div class="d-flex justify-content-center">
                                        <span class="text-center mb-3">Tidak ada data</span>
                                    </div>`;
    
                        $('#comment-section').append(html);
                    }
                }
            });

            $(document).on('click', '#btn-support', function(e) {
                $('input[name="type"]').val(1);
            });

            @endif

            /* Action follow */
            $(document).on('click', '#btn-follow', function(e) {
                if (!authCheck) {
                    Toast2.fire({ 
                        icon: 'warning', 
                        title: 'Yuk login untuk mengikuti.' 
                    });
                } else {
                    follow($(this).attr('data-id'));
                }
            });
            
        })(jQuery);
    </script>

@endsection
