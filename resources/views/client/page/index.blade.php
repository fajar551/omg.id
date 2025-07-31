@extends('layouts.template-body')

@section('title')
    <title>@lang('My Page')</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.css" />
    <style>
        .card.creators {
            border-radius: var(--border-radius-sm);
            background-color: white;
        }

        .progress-bar.creator {
            background-color: #D0EE26 !important;
        }

        .list-group-item.active {
            background-color: #dabaff;
            border: 0 !important;
        }

        .bg-card-creator {
            background: rgba(254, 254, 254, 0.2);
            /* backdrop-filter: blur(8px); */
            height: 100%;
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
        }

        .text-comment {
            font-size: 13px;
            overflow: hidden;
        }

        .card-show {
            display: none;
        }

        #loadMore {
            padding: 10px;
            width: 100%;
            display: block;
            text-align: center;
            background-color: #33739E;
            color: #fff;
            border-width: 0 1px 1px 0;
            border-style: solid;
            border-color: #fff;
            box-shadow: 0 1px 1px #ccc;
            transition: all 600ms ease-in-out;
            -webkit-transition: all 600ms ease-in-out;
            -moz-transition: all 600ms ease-in-out;
            -o-transition: all 600ms ease-in-out;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .card-karyas {
            height: 318px;
            cursor: pointer;
        }

        .card-karyas:hover {
            background-color: var(--color-info);
        }

        @media only screen and (max-width: 600px) {
            .img-profile-creator {
                width: 60px;
            }

            .container-profile {
                left: 10px !important;
                top: 30px !important;
            }

            .bg-creator-support {
                height: 119px !important;
            }

            .font-creator {
                font-size: 12px;
                margin-bottom: 0px;
            }

            .btn-creator {
                padding-left: 5px !important;
                padding-right: 5px !important;

            }

            p.font-parent {
                margin-bottom: 0px !important;
            }

            .card.creators {
                margin-top: 10px;
            }

            .col-creator {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            .card-karyas {
                padding: 0px !important;
                /* height: 306px; */
                cursor: pointer;
            }
        }

        .page-thumbnail img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .card-img-overlay {
            /* background: #28282878; */
            background: rgb(0, 0, 0);
            background: linear-gradient(0deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0.3) 100%);
            border-radius: 10px;
        }

        .social-link {
            border-radius: 8px;
            background-color: #ffffffd4;
        }

        .social-link img:hover {
            transform: scale(1.1);
            transition: 0.8s;
        }

        .btn-creator-follow,
        .btn-bagi {
            width: 50%;
        }

        .btn-report {
            width: 25%;
        }

        .page-info {
            width: 30%;
        }

        @media(max-width: 768px) {
            .page-info {
                width: 50%;
            }
        }

        @media(max-width: 425px) {
            .page-info {
                justify-content: center !important;
                width: 100%;
            }

            .page-thumbnail img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="">
        <div class="container px-5 mb-5">
            <div class="row">
                <div class="col-12">
                    @include('components.breadcrumb', [
                        'title' => __('Kelola Halaman Kreator'),
                        'pages' => [
                            '#' => __('My Page'),
                        ],
                    ])
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @include('components.flash-message', ['flashName' => 'message'])
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow rounded-small text-white border-0">
                        <div class="d-flex" style="min-height: 280px; max-height: 280px;">
                            <img src="{{ $data['cover_image'] ?? asset('template/images/herocreator.png') }}" class="cropped cover-image" style="width: 100%; object-fit: cover; border-radius: var(--border-radius-sm);">
                            <div class="card-img-overlay d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-start card-page-info w-100">
                                    <div class="text-center page-thumbnail me-3">
                                        <a href="javascript:void(0);" id="btn-change-icon" data-id="{{ $data['id'] }}">
                                            <img src="{{ $data['avatar'] ?? asset('assets/img/default-item.svg') }}" alt="profile-img" class="rounded-circle border border-1 shadow-sm">
                                        </a>
                                    </div>
                                    <div class="page-info">
                                        <h4 class="text-line-1 fw-bold" title="">{{ $data['name'] }}</h4>
                                        <p class="mb-0 text-line-1 fw-semibold" title=""><span>@</span>{{ $data['page_url'] }} {{ isset($data['category']['title']) ? '- ' . $data['category']['title'] : '' }}</p>
                                        <div clasa="fw-semibold text-white font-creator">
                                            <span class="text-white font-creator">Followers </span>
                                            <span class="text-white font-creator" id="countfollowers"> {{ Utils::kNFormatter($data['follow_detail']['followers_count']) }}</span>
                                            <span class="text-white font-creator">&bullet;</span>
                                            <span class="text-white font-creator"> Following {{ Utils::kNFormatter($data['follow_detail']['followings_count']) }} </span>
                                        </div>
                                        <hr class="mt-2">
                                        <div class="d-flex">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-sm btn-light step11 rounded-small" title="Edit profil halaman">
                                                <i class="fa fa-edit"></i> Edit Profile
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute top-0 end-0 me-4 mt-4">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#croperr" class="btn btn-sm btn-light step12 rounded-small" title="Edit cover">
                                    <i class="fa fa-edit"></i> Edit Cover
                                </button>
                                <a href="{{ route('creator.index', ['page_name' => $data['page_url']]) }}" target="_blank" class="btn btn-sm btn-light text-dark rounded-small" title="Pratinjau halaman">
                                    <i class="fa fa-eye"></i> <span class="d-none d-md-inline">Preview</span>
                                </a>
                            </div>
                            <div class="position-absolute bottom-0 end-0">
                                <div class="text-dark d-none d-lg-block me-4 mb-4">
                                    <div class="p-2 badge social-link step13">
                                        <a href="https://facebook.com/{{ $social_link['social_links']['facebook'] }}"><img src="{{ asset('template/images/fb.png') }}" alt="" width="20" height="20" class="ms-1 me-1" /></a>
                                        <a href="https://instagram.com/{{ $social_link['social_links']['instagram'] }}"><img src="{{ asset('template/images/ig.png') }}" alt="" width="20" height="20" class="ms-1 me-1" /></a>
                                        <a href="https://twitter.com/{{ $social_link['social_links']['twitter'] }}"><img src="{{ asset('template/images/tw.png') }}" alt="" width="20" height="20" class="ms-1 me-1" /></a>
                                        <a href="https://youtube.com/{{ $social_link['social_links']['youtube'] }}"><img src="{{ asset('template/images/yt.png') }}" alt="" width="20" height="20" class="ms-1 me-1" /></a>
                                    </div>
                                    <a href="{{ route('setting.social.index') }}" class="btn btn-sm btn-light step14 rounded-small" title="Tambah sosial media link">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 d-lg-block">
                    <div class="card creators shadow border-0 mb-md-4 mt-md-4 mt-sm-3 card-dark">
                        <div class="card-header bg-transparent border-0">
                            <h5 class="card-title text-center fw-bold">{{ $data['page_message'] }}</h5>
                            <p class="text-center fs-6 m-0">{{ $data['bio'] }}</p>
                        </div>
                        <div class="card-body text-center step15">
                            @if (!empty($creatorGoal))
                                <div class="cards bg-primary shadow-0" style="border-radius: 8px;">
                                    <div class="px-3 py-3 bg-subprogress m-auto w-100">
                                        <span class="text-white text-line-2" style="font-size: 18px; font-weight: 400;">{{ $creatorGoal['goal']['title'] }}</span>
                                        @include('components.goal-progress-sm', ['progress' => $creatorGoal['goalProgress']['progress']])
                                        <div class="d-flex justify-content-between">
                                            <span class="text-sm text-white">{{ $creatorGoal['goalProgress']['formated_target_achieved'] }}</span>
                                            <span class="text-sm text-white">{{ $creatorGoal['goal']['formated_target'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('goal.mygoal.edit', ['id' => $creatorGoal['goal']['id']]) }}" class="btn btn-sm mt-3 btn-outline-primary text-primary rounded-small" style="width: -webkit-fill-available;" title="Edit goal">
                                    <i class="fa fa-edit"></i> @lang('form.btn_edit_goal')
                                </a>
                            @else
                                <a href="{{ route('goal.mygoal.create') }}" class="btn btn-sm mt-3 btn-outline-primary text-primary rounded-small" style="width: -webkit-fill-available;" title="Buat goal baru">
                                    <i class="fa fa-plus"></i> @lang('form.btn_create_goal')
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card creators shadow border-0 mb-md-4 mt-md-4 mt-sm-3 card-dark">
                        <div class="card-header bg-transparent border-0">
                            <h5 class="card-title text-center fw-bold m-0">Summary</h5>
                        </div>
                        <div class="card-body step16">
                            @if (!empty($data['summary']))
                                <p class="text-center fs-6 m-0">
                                    {{ $data['summary'] }}
                                </p>
                            @endif
                            <button type="button" data-bs-toggle="modal" data-bs-target="#summaryModal" class="btn btn-sm mt-3 btn-outline-primary text-primary rounded-small" style="width: -webkit-fill-available;" title="Tambah atau edit summary">
                                <i class="fa fa-edit"></i> @lang('page.edit')
                            </button>
                            <div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="summaryModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="summaryModalLabel">@lang('page.edit') Summary </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('page.setsummary') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit-summary'))" autocomplete="off">
                                            <div class="modal-body">
                                                {{-- @include('components.flash-message', ['flashName' => 'message',]) --}}
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group">
                                                        <textarea name="summary" class="form-control @error('summary') is-invalid @enderror notif " rows="5" style="line-height: 22px;" placeholder="Summary">{{ old('summary', $data['summary']) }}</textarea>
                                                        @error('summary')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id" value="{{ $data['id'] }}">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" id="btn-submit-summary" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card creators shadow border-0 mb-md-4 mt-md-4 mt-sm-3 card-dark">
                        <div class="card-header bg-transparent border-0">
                            <h5 class="card-title text-center fw-bold m-0">Video</h5>
                        </div>
                        <div class="card-body step17">
                            @if (!empty($data['video']))
                                <iframe height="200" width="100%" src="{{ $data['video'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @endif
                            <button type="button" data-bs-toggle="modal" data-bs-target="#videoModal" class="btn btn-sm mt-3 px-4 btn-outline-primary text-primary rounded-small" style="width: -webkit-fill-available;" title="Tambah atau edit video youtube">
                                <i class="fa fa-edit"></i> @lang('page.edit')
                            </button>
                            <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="videoModalLabel">@lang('page.edit') Video</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                                        </div>
                                        <form action="{{ route('page.setvideo') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit-video'))" autocomplete="off">
                                            <div class="modal-body">
                                                {{-- @include('components.flash-message', [ 'flashName' => 'message', ]) --}}
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group">
                                                        <input type="text" name="video" class="form-control @error('video') is-invalid @enderror notif" id="video" placeholder="Tambah video dari youtube" value="{{ old('video', $data['video']) }}">
                                                        @error('video')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        {{-- <p class="mt-4">Insert Youtube video url.</p> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id" value="{{ $data['id'] }}">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" id="btn-submit-video" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-3">Produk Saya</h5>
                        <div class="row" id="products-creator">
                            @foreach ($products as $product)
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                                    @include('products.card-product', ['product' => $product, 'product_id' => $product->id])
                                </div>
                            @endforeach
                            @if(auth()->check() && auth()->user()->hasRole('creator'))
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100 shadow-sm border-primary border-2 card-karyas inner-card-dark rounded-xsmall d-flex align-items-center justify-content-center" style="cursor:pointer; min-height: 250px;" data-bs-toggle="modal" data-bs-target="#modalTambahProduk" title="Tambah Produk Baru">
                                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                            <span style="font-size:3rem; color:#c9aaff;">+</span>
                                            <p class="text-primary pt-2 fw-bold" style="font-size:1.2rem;">Tambah Produk</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card creators border-0 mb-md-4 mt-md-4 p-4 card-dark">
                        <h5 class="fw-semibold">Konten Terbaru </h5>
                        <div class="row step18" id="products-creator">
                            @php
                                $user_id = $data['user_id'];
                                $pageName = $data['page_url'];
                                $page['user_id'] = $data['user_id'];
                            @endphp
                            @foreach ($content['data'] as $ctn)
                            <div class="col-xl-4 col-md-6 col-sm-12 mb-3 step18">
                                @include('components.card-content-v2', [
                                    'content' => array_merge($ctn, ['thumbnail_path' => $ctn['thumbnail'], 'pageName' => $pageName]), 
                                    'activeItem' => array_merge([$ctn['item'], $ctn['price']], ['icon' => $ctn['item_icon']]),
                                    'action' => 'subscribed',
                                    // 'user_id' => $user_id,
                                ])
                            </div>
                            
                            @endforeach
                            <div class="col-xl-4 col-md-6 col-sm-12 mb-3 step19">
                                <div class="card card-karyas rounded-xsmall border-primary shadow-sm rounded-small inner-card-dark" onclick="createKarya()" title="Buat konten baru">
                                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('template/images/icon/pluss.svg') }}" alt="" class="pluss mt-2">
                                        <p class="text-primary pt-2">Buat Konten</p>
                                    </div>
                                </div>
                            </div>

                            {{-- @include('components.card-content') --}}

                            {{-- <div class="col-lg-4 col-sm-12 my-3 step19">
                                <div class="card card-karyas rounded-xsmall border-primary shadow-sm" onclick="createKarya()" title="Buat konten baru">
                                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('template/images/icon/pluss.svg') }}" alt="" class="pluss mt-2">
                                        <p class="text-primary pt-2">Buat Konten</p>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal  fade" id="croperr" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Cover')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="canvas">
                    <div class="page">
                        <h2>Upload cover.</h2>
                        <div class="box d-flex align-items-center">
                            <!-- <input type="file" id="file-input"> -->
                            <span class="btn btn-upload border-0 btn-file" title="Upload image">
                                <img src="{{ asset('template/images/uploadimg.png') }}" alt="" width="80"> <input type="file" id="file-input">
                            </span>

                            <div class="">
                                <p>Recommended ratio is 1258 x 225.</p>
                            </div>
                        </div>
                        <div class="box-2">
                            <div class="result" style="max-height: 164px"></div>
                        </div>
                        <div class="box-2 img-result hide">

                        </div>
                        <!-- input file -->
                        <div class="box" hidden>
                            <div class="options hide mt-3">
                                <label> Width</label>
                                <input type="number" class="img-w" value="1258" min="1258" max="1258" />
                                <input type="number" class="img-h" value="225" min="225" max="225" />
                            </div>
                            <a href="" class="btn download hide"></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save hide" id="btn-save-crop">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Edit Profil Halaman')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('page.setProfile') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit-profile'))" autocomplete="off">
                    <div class="modal-body">
                        {{-- @include('components.flash-message', ['flashName' => 'message']) --}}
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <label for="name" class="form-label">@lang('form.lbl_name') <span class="text-danger fw-bold"><span class="text-danger fw-bold">*</span></span> </label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror notif" id="name" placeholder="@lang('form.lbl_name')" value="{{ old('name', $data['name']) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mt-4">
                                <label for="page_url" class="form-label">@lang('form.lbl_support_page_url') <span class="text-danger fw-bold"><span class="text-danger fw-bold">*</span></span> </label>
                                <input type="text" name="page_url" class="form-control @error('page_url') is-invalid @enderror notif" id="page_url" placeholder="@lang('form.lbl_support_page_url')" value="{{ old('page_url', $data['page_url']) }}" required>
                                @error('page_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mt-4">
                                <label class="form-label" for="category_id">@lang('form.lbl_category') </label>
                                <select class="form-select" id="category_id" name="category_id">
                                    @foreach ($category as $item)
                                        @if ($item['id'] != 0)
                                            <option value="{{ $item['id'] }}" {{ isset($data['category']['id']) ? ($item['id'] == $data['category']['id'] ? 'selected' : '') : '' }}> {{ $item['title'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-4">
                                <label class="form-label">@lang('form.lbl_support_page_message')</label>
                                <textarea name="page_message" class="form-control @error('page_message') is-invalid @enderror notif " rows="5" style="line-height: 22px;" placeholder="@lang('form.lbl_support_page_message')" required>{{ old('page_message', $data['page_message']) }}</textarea>
                                @error('page_message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mt-4">
                                <label class="form-label">@lang('form.lbl_description')</label>
                                <textarea name="bio" class="form-control @error('bio') is-invalid @enderror notif " rows="5" style="line-height: 22px;" placeholder="@lang('form.lbl_description')" required>{{ old('bio', $data['bio']) }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btn-submit-profile" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalTambahProdukLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahProdukLabel">Tambah Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="formTambahProduk">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="col-md-8 order-md-1 order-2">
                  <div class="card shadow border-0 rounded-small min-vh-50 card-dark">
                    <div class="card-body">
                      <div class="form-group mb-3">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="type" class="form-label">Jenis Produk <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                          <option value="">Pilih Jenis Produk</option>
                          <option value="ebook">Ebook</option>
                          <option value="ecourse">Ecourse</option>
                          <option value="buku">Buku Fisik</option>
                          <option value="digital">Digital Product</option>
                        </select>
                        @error('type')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                        @error('price')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3" id="form-stock">
                        <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" min="0">
                        @error('stock')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}">
                        @error('description')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 order-md-2 order-1 mb-3">
                  <div class="card shadow border-0 rounded-small min-vh-50 card-dark">
                    <div class="card-header border-0 bg-transparent">
                      <label class="form-label" for="enlarge-img">Gambar Produk</label>
                    </div>
                    <div class="card-body">
                      <div class="form-group mb-3 d-flex justify-content-center">
                        <img class="img-thumbnail rounded icon-160" id="enlarge-img" src="{{ asset('assets/img/image.png') }}" alt="Preview Gambar">
                      </div>
                      <div class="form-group mt-3">
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                        <small class="">*) jpg, jpeg, png, Max: 2mb</small>
                        @error('image')
                          <div class="invalid-feedback text-danger mt-3">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div id="notif-produk"></div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/submit.js') }}"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/guide/pagesetting.js') }}"></script>
    
    <script>
    // Wait for jQuery to be available
    function initializeProductFormScripts() {
        if (typeof $ === 'undefined') {
            console.error('jQuery is not available, retrying in 100ms...');
            setTimeout(initializeProductFormScripts, 100);
            return;
        }
        
        console.log('jQuery is available, initializing product form scripts...');
        
        $(document).ready(function() {
            const typeSelect = document.getElementById('type');
            const stockField = document.getElementById('form-stock');
            
            function toggleStockField() {
                const selectedType = typeSelect.value;
                if (stockField) {
                    // Sembunyikan stok jika digital, ebook, atau ecourse
                    stockField.style.display = (selectedType === 'digital' || selectedType === 'ebook' || selectedType === 'ecourse') ? 'none' : 'block';
                    
                    // Set required attribute based on type
                    const stockInput = document.getElementById('stock');
                    if (stockInput) {
                        stockInput.required = (selectedType === 'buku');
                    }
                }
            }
            
            if (typeSelect) {
                typeSelect.addEventListener('change', toggleStockField);
                // Initial call
                toggleStockField();
            }
        });
    }

    // Initialize scripts when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initializeProductFormScripts();
    });

    // Also try to initialize if DOM is already loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeProductFormScripts);
    } else {
        initializeProductFormScripts();
    }
    </script>
    <script>
        function createKarya() {
            window.location.href = '{{ route('content.create') }}';
        }

        // vars
        let result = document.querySelector('.result'),
            img_result = document.querySelector('.img-result'),
            img_w = document.querySelector('.img-w'),
            img_h = document.querySelector('.img-h'),
            options = document.querySelector('.options'),
            save = document.querySelector('.save'),
            cropped = document.querySelector('.cropped'),
            upload = document.querySelector('#file-input'),
            cropper = '';


        upload.addEventListener('change', (e) => {
            if (e.target.files.length) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    if (e.target.result) {

                        let img = document.createElement('img');
                        img.id = 'image';
                        img.src = e.target.result
                        result.innerHTML = '';

                        result.appendChild(img);
                        // show save btn and options
                        save.classList.remove('hide');
                        options.classList.remove('hide');
                        // init cropper
                        cropper = new Cropper(img, {
                            dragMode: 'move',
                            autoCropArea: 1,
                            restore: false,
                            guides: false,
                            center: false,
                            highlight: false,
                            cropBoxMovable: false,
                            cropBoxResizable: false,
                            toggleDragModeOnDblclick: false,
                            viewMode: 3,
                        });
                    }
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // save on click
        save.addEventListener('click', (e) => {
            e.preventDefault();
            // get result to data uri
            let imgSrc = cropper.getCroppedCanvas({
                width: img_w.value
            });
            // remove hide class of img
            cropped.classList.remove('hide');
            img_result.classList.remove('hide');
            // show image cropped
            cropped.src = imgSrc.toDataURL();

            var base64data = imgSrc.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    saveCrop(base64data);
                }
            });
        });

        const saveCrop = async (base64data) => {
            // console.log(base64data);
            $('#btn-save-crop').attr({
                "disabled": true
            }).html("Loading...");

            const formData = {
                "cover_image": base64data
            };
            await axios.post(`/api/page/setcover`, formData)
                .then(({
                    data
                }) => {
                    const {
                        message
                    } = data;

                    // TODO: Handle Response
                    console.log(data);
                }).catch(({
                    response: {
                        data
                    }
                }) => {
                    const {
                        message,
                        errors = {}
                    } = data;

                    // console.log(data);
                }).finally(() => {
                    $('#btn-save-crop').attr({
                        "disabled": false
                    }).html("Submit");
                });

        };
    </script>
    <script>
$(function() {
    $('#formTambahProduk').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#modalTambahProduk').modal('hide');
                $('#notif-produk').html(
                    `<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        Produk berhasil ditambahkan!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`
                );
                location.reload(); // reload halaman agar grid produk terupdate
            },
            error: function(xhr) {
                let msg = 'Gagal menambah produk.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                $('#notif-produk').html(
                    `<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        ${msg}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`
                );
            }
        });
    });
});
</script>
@endsection
