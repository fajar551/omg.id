<div class="row">
    <div class=" col-lg-8 col-md-12 col-sm-12">
        <div class="card card-dark-80">
            <div class="card-header card-dark-80 d-flex justify-content-between p-2">
                <div class="header-title">
                   <h5 class="card-title">{{ ucwords($name) }}</h5>
                </div>
                <div class="card-header-toolbar d-flex align-items-center">
                    <div class="dropdown">
                        <span class="dropdown-toggle btn btn-sm btn-outline-primary " id="dropdownMenuButton01" data-bs-toggle="dropdown" aria-expanded="true" role="button">
                            <i class="ri-menu-3-line"></i>
                        </span>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton01">
                            <a class="dropdown-item" href="#" data-id="{{ $page_id }}" onclick="Editorpick(this)"><i class="ri-user-star-line me-2"></i>{{$editor_pick == 1 ? "Delete editor pick" : "Select editor pick"}}</a>
                            <a class="dropdown-item" href="#" data-id="{{ $page_id }}" onclick="Featured(this)"><i class="ri-star-line me-2"></i>{{$featured == 1 ? "Unfeatured" : "Select Featured"}}</a>
                            <a class="dropdown-item" href="#" data-id="{{ $id }}" onclick="Suspend(this)"><i class="las la-exclamation-triangle me-2"></i>Suspend</a>
                            <a class="dropdown-item" href="#" data-id="{{ $id }}" onclick="Unsuspend(this)"><i class="las la-universal-access me-2"></i>Unsuspend</a>
                        </div>
                     </div>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="iq-birthday-block">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="#">
                                <img src="{{ $profile_picture ? route('api.profile.preview', ['file_name' => $profile_picture]) : asset('template/images/user/user.png') }}" alt="profile-img"  class="img-fluid rounded" style="width: 90px; height: 90px;">
                            </a>
                            <div class="friend-info ms-0 ms-md-2 mt-md-0 mt-2">
                                <h5>{{ $email }} | {{ "@$username" }}</h5>
                                <p class="mb-0">{{ $gender == "male" ? __('form.lbl_gender_male') : ($gender == "female" ? __('form.lbl_gender_female') : '' ) }}</p>
                                <p class="mb-0">{{ $phone_number }}</p>
                                {{-- <p class="mb-0">{{ __('Registered Since, ') .Carbon::parse($created_at)->diffForhumans() }}</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @if ($editor_pick == 1)
                            <span class="badge bg-success mt-2 text-end"><i class="ri-user-star-line me-2"></i>Editor Pick</span>
                        @endif
                        @if ($featured == 1)
                            <span class="badge bg-primary mt-2 ms-1 text-end"><i class="ri-star-line me-2"></i>Featured</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>