@extends('layouts.template-home')

@section('title', __('Report Form'))

@section('styles')
    <style>
        p {
            text-align: justify;
        }
    </style>
@endsection

@section('content')
    <section class="container-fluid position-relative bg-heros p-0">
        <div class="position-absolute bottom-0 start-0 w-100">
            <div class="container px-lg-5 px-3">
                <h1 class="text-white fw-semibold" data-aos="zoom-in-right" data-aos-duration="1000">Report </h1>
            </div>
        </div>
    </section>

    <section class="section min-vh-100 bg-light m-0">
        <div class="container position-relative">
            <div class="row px-lg-5 px-3">
                <div class="col-12" data-aos="zoom-in-up" data-aos-duration="1000">
                    <form action="{{ route('report.store') }}" autocomplete="off" method="POST" id="formreport" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('POST')
                        <input type="hidden" name="creator_id" value="{{ old('creator_id', $creator_id) }}">
                        <input type="hidden" name="content_id" value="{{ old('content_id', $content_id) }}">
                        <div class="card rounded-small shadow card-dark">
                            {{-- <div class="bg-primary" style="border-radius: 10px; height: 100px;"></div> --}}
                            <div class="card-body row">
                                <h3 class="card-title" style="font-weight: 600;">@lang('Report Form')</h3>
                                <p>Jika Anda menemukan konten atau pengguna yang tidak mengikuti <a href="{{ route('pages.termofservice') }}" target="_blank" class="text-primary">kebijakan layanan</a> di {{ env('APP_NAME') }} mohon untuk mengisi form di bawah ini dengan data yang sebenar-benarnya.</p>
                                <hr>
                                <div class="col-12 p-3 gap-4">
                                    @include('components.flash-message', ['flashName' => 'message'])
                                    <div class="form-group row mb-3">
                                        <label class="form-label col-sm-4" for="fromuser">@lang('form.lbl_full_name') <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input name="name" type="text" id="fromuser" class="form-control mb-0 @error('name') is-invalid @enderror" placeholder="@lang('form.lbl_full_name')" value="{{ old('name', $name) }}" @isset($name) style="cursor: not-allowed;" readonly @endisset required autocomplete="off">
                                            <small>*) Nama lengkap pelapor</small> 
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="form-label col-sm-4" for="useremail">@lang('form.lbl_email') <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input name="email" type="email" id="useremail" class="form-control mb-0 @error('email') is-invalid @enderror" placeholder="budi@mail.com" value="{{ old('email', $email) }}" @isset($email) style="cursor: not-allowed;" readonly @endisset required autocomplete="off">
                                            <small>*) Email pelapor</small> 
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if (!isset($type))
                                        <div class="form-group row mb-3">
                                            <label class="form-label col-sm-4" for="type">@lang('Jenis Laporan') <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <div class="form-check custom-radio form-check-inline">
                                                    <input type="radio" id="type1" name="type" value="creator" class="form-check-input" {{ old('type', $type) == 'creator' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="type1"> @lang('Kreator') </label>
                                                </div>
                                                <div class="form-check custom-radio form-check-inline">
                                                    <input type="radio" id="type2" value="content" name="type" class="form-check-input" {{ old('type', $type) == 'content' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="type2"> @lang('Konten') </label>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" name="type" class="form-check-input" value="{{ old('type', $type) }}">
                                    @endif
                                    <div class="form-group row mb-3">
                                        <label class="form-label col-sm-4" for="fromuser">@lang('form.lbl_category') <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            @error('category')
                                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                            @enderror
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="Ketelanjangan/Nudity" id="Ketelanjangan/Nudity" @if (is_array(old('category')) && in_array('Ketelanjangan/Nudity', old('category'))) checked @endif>
                                                <label class="form-check-label" for="Ketelanjangan/Nudity">
                                                    Ketelanjangan/Nudity
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="Kekerasan" id="Kekerasan" @if (is_array(old('category')) && in_array('Kekerasan', old('category'))) checked @endif>
                                                <label class="form-check-label" for="Kekerasan">
                                                    Kekerasan
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="Harassment" id="Harassment" @if (is_array(old('category')) && in_array('Harassment', old('category'))) checked @endif>
                                                <label class="form-check-label" for="Harassment">
                                                    Harassment
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="Bunuh Diri" id="Bunuh Diri" @if (is_array(old('category')) && in_array('Bunuh Diri', old('category'))) checked @endif>
                                                <label class="form-check-label" for="Bunuh Diri">
                                                    Bunuh Diri
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="Berita Palsu/Hoax" id="Berita Palsu/Hoax" @if (is_array(old('category')) && in_array('Berita Palsu/Hoax', old('category'))) checked @endif>
                                                <label class="form-check-label" for="Berita Palsu/Hoax">
                                                    Berita Palsu/Hoax
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="Spam" id="Spam" @if (is_array(old('category')) && in_array('Spam', old('category'))) checked @endif>
                                                <label class="form-check-label" for="Spam">
                                                    Spam
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="Pembajakan/Penjualan Tidak Resmi" id="Pembajakan/Penjualan Tidak Resmi" @if (is_array(old('category')) && in_array('Pembajakan/Penjualan Tidak Resmi', old('category'))) checked @endif>
                                                <label class="form-check-label" for="Pembajakan/Penjualan Tidak Resmi">
                                                    Pembajakan/Penjualan Tidak Resmi
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="Ujaran Kebencian" id="Ujaran Kebencian" @if (is_array(old('category')) && in_array('Ujaran Kebencian', old('category'))) checked @endif>
                                                <label class="form-check-label" for="Ujaran Kebencian">
                                                    Ujaran Kebencian
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="Terorisme" id="Terorisme" @if (is_array(old('category')) && in_array('Terorisme', old('category'))) checked @endif>
                                                <label class="form-check-label" for="Terorisme">
                                                    Terorisme
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="Lainnya" id="Lainnya" @if (is_array(old('category')) && in_array('Lainnya', old('category'))) checked @endif>
                                                <label class="form-check-label" for="Lainnya">
                                                    Lainnya
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="form-label col-sm-4" for="fromuser">@lang('Link') <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="link" class="form-control mb-0 @error('link') is-invalid @enderror" id="link" value="{{ old('link', $link) }}" @isset($link) style="cursor: not-allowed;" readonly @endisset placeholder="Link terkait" required autocomplete="off">
                                            @error('link')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3 d-flex align-items-center">
                                        <label class="form-label col-sm-4" for="fromuser">@lang('Screenshot') <span class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <img class="img-thumbnail rounded border-info icon-180  mb-2 " style="object-fit:cover;" id="enlarge-img"  src="{{ $model['icon'] ?? asset('assets/img/image.png') }}" alt="profile-pic">
                                            <div class="form-group">
                                                <input type="file" name="screenshot" class="form-control form-control-sm @error('screenshot') is-invalid @enderror" id="screenshot" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*" required>
                                                @error('screenshot')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="form-label col-sm-4" for="useremail">@lang('form.lbl_description')</label>
                                        <div class="col-sm-8">
                                            <textarea name="description" class="form-control mb-0 notif inner-card-dark @error('description') is-invalid @enderror" id="description" placeholder="Deskripsi laporan">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="form-label col-sm-4" for="fromuser"></label>
                                        <div class="col-sm-8 d-flex justify-content-md-start justify-content-center ">
                                            <button type="button" class="btn rounded-pill btn-primary w-50 w-sm-100 btn-block mb-3 mt-4" id="btn-submit">@lang('page.submit')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    {{-- <script src="{{ asset('assets/js/script.js') }}"></script> --}}
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script>
        /**
        * Report page script
        * Version: 1.0
        */
        (function ($) {
            "use strict";
            
            const submitConfirm = () => {
                ToastConfirm.fire({
                    title: langGet('page.are_you_sure'),
                    html: langGet('page.report_confirm'),
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formreport').submit();
                    }
                }).catch(swal.noop);
            }

            $(document).on('click', '#btn-submit', function(e) {
                const isValid = document.querySelector('#formreport').reportValidity();
                if (!isValid) return;

                submitConfirm();
            });
        })(jQuery);
    </script>
@endsection
