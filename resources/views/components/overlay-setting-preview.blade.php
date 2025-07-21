<div  id="overlay-preview-div">
   <div >
      <div class="card mb-3 inner-card-dark">
         <div class="card-header border-0 bg-transparent d-flex justify-content-between">
           
            <div class="card-header-toolbar d-flex align-items-center">
               {{-- TODO: Add close button in mobile --}}
                  @if(!empty($realDataSimulation))
                  {{-- <label class="form-check-label" for="flexCheckDefault" id="lbl-switch-status">@lang('form.lbl_simulation_with_real_data')</label> --}}
                  {{-- <div class="form-check form-switch ms-2"> --}}
                     {{-- TODO: What for is this? --}}
                     {{-- <input type="hidden" value="1" name="settings[real_data]"> --}}
                     {{-- <input type="checkbox" name="settings[real_data]" class="form-check-input pe-0" value="1" id="flexCheckDefault" data-key="real_data" onchange="buildWidget(this);"> --}}
                  {{-- </div> --}}
                  @endif
            </div>
         </div>
         <div class="card-body card-body-overlay" data-url="{{ $url }}" data-url_iframe="{{ $url_iframe }}">
            <iframe class="iframe-goal iframe-widget" id="overlay-preview" src="{{ $url_iframe }}" width="100%" height="300px" style="border-radius: 6px;"></iframe>
         </div>
      </div>
      @if(!empty($mediaShareAction))
      <div class="card mb-3 card-testing inner-card-dark">
          <div class="card-body border-0 ">
               <div class="row mb-3">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label class="form-label" for="yt_url">@lang('form.lbl_youtube_url') *</label>
                        <input type="url" name="yt_url" id="yt_url" class="form-control rounded-pill" placeholder="https://www.youtube.com/watch?v=xxyyy-zzzz" >
                     </div>
                  </div>
                  <div class="col-md-12 mt-3">
                     <div class="form-group">
                        <label class="form-label" for="start_seconds">@lang('form.lbl_start_seconds') </label>
                        <input type="number" name="startSeconds" step="1" min="0" max="10000" id="start_seconds" class="form-control rounded-pill" placeholder="@lang('form.lbl_start_seconds_desc')" >
                     </div>
                  </div>
               </div>
               <button id="btn-push-notif" class="btn btn-sm btn-outline-primary rounded-pill mb-1 py-2 w-100" type="button" data-label="@lang('form.btn_send_test_notification')">@lang('form.btn_send_test_notification')</button>
          </div>
      </div>
      @endif
      @if(!empty($notificationAction))
      <div class="card mb-3 card-testing inner-card-dark">
         <div class="card-body border-0">
            <div class="form-group mb-3">
               <div class="form-check form-switch d-block">
                  <input type="checkbox" name="settings[real_data]" class="form-check-input pe-0" value="1" id="flexCheckDefault" data-key="real_data" onchange="buildWidget(this);">
                  <label class="form-check-label mx-2" for="status">@lang('form.lbl_simulation_with_real_data')</label>
               </div>
            </div>
            <button id="btn-push-notif" class="btn btn-sm btn-outline-primary rounded-pill mb-1 py-2 w-100" type="button" data-label="@lang('form.btn_send_test_notification')">@lang('form.btn_send_test_notification')</button>
         </div>
      </div>
      @endif
      @if(!empty($goalAction) || !empty($marqueeAction) || !empty($ldbAction))
      <div class="card mb-3 card-testing inner-card-dark">
         <div class="card-body border-0 ">
            <div class="form-group">
               <div class="form-check form-switch d-block">
                  <input type="checkbox" name="settings[real_data]" class="form-check-input pe-0" value="1" id="flexCheckDefault" data-key="real_data" onchange="buildWidget(this);">
                  <label class="form-check-label mx-2" for="status">@lang('form.lbl_simulation_with_real_data')</label>
               </div>
            </div>
         </div>
      </div>
      @endif
   </div>
</div>
