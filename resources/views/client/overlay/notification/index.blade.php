@extends('layouts.template-body')

@section('title')
   <title>{{ $widget_with_settings['name'] }}</title>
@endsection

@section('styles')
   <link rel="stylesheet" href="{{ asset('assets/css/overlay.css') }}">
   <link rel="stylesheet" href="{{ asset('template/css/jquery.fontselect.min.css') }}">
@endsection

@section('content')
<div class="container px-5 mb-5">

   @include('components.breadcrumb', ['title' => __('page.overlay'), 'pages' => [route('overlay.index') => __('page.overlay'), '#' => $widget_with_settings['name']]])

   <div class="row">         
      <div class="col-12">
         @include('components.flash-message', ['flashName' => 'message'])
      </div>
   </div>
   
   <div class="row">
      <div class="col-md-12">
         <div class="col-12 d-none d-lg-block d-lg-block">
            @include('components.nav-overlay',['widgets' => $widgets ])
         </div>

         @include('components.nav-overlay-mobile',['widgets' => $widgets, "widget_with_settings" => $widget_with_settings ])

         <div class="row">
            <div class="col-md-12 col-lg-8 col-sm-12 order-2 order-lg-1">
               <div class="row mb-3 position-relative">
                  <div class="col-md-12 col-lg-12">
                     <div class="card border-0 shadow rounded-small card-dark">
                        <div class="card-body ">
                           <form action="{{ route('overlay.update') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="key" value="{{ $widget_with_settings['key'] }}">
                              <div class="row">
                                 <div class="col-md-12 col-lg-12 ">
                                    <div class="form-group mb-3">
                                       <div class="row">
                                          <div class="col-lg-3 col-sm-12">
                                             <label class="form-label pt-2" for="themes-select">@lang('form.lbl_themes')</label>
                                          </div>
                                          <div class="col-lg-9 col-sm-12">
                                             <select name="settings[ntf_theme]" class="form-select @error('settings.ntf_theme') is-invalid @enderror" id="themes-select" data-key="ntf_theme" onchange="buildWidget(this);" required>
                                                @foreach($themes as $k => $v)
                                                <option value="{{ strtolower($v) }}" @if(old('settings.ntf_theme', $widget_settings_map['ntf_theme']['value'])==strtolower($v)) selected @endif>{{ ucwords(str_replace('-', ' ', $v)) }}</option>
                                                @endforeach
                                             </select>
                                             @error('settings.ntf_theme')
                                             <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row mb-0 d-flex aligin-items-center">
                                       <div class="col-lg-3 col-sm-12">
                                          <label class="form-label pt-3 " for="">@lang('Palet Warna')</label>
                                       </div>
                                       {{-- Default theme color palete--}}
                                       <div class="row col-lg-9 col-sm-12" id="color-palete-default" @if (old('settings.ntf_theme', $widget_settings_map['ntf_theme']['value']) !="default" ) style="display: none" @endif>
                                          <div class="col-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="ntf_t1_color_1">@lang('Body')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.ntf_t1_color_1') is-invalid @enderror" name="settings[ntf_t1_color_1]" id="ntf_t1_color_1" data-key="ntf_t1_color_1" value="{{ old('settings.ntf_t1_color_1', $widget_settings_map['ntf_t1_color_1']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.ntf_t1_color_1')
                                                <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="ntf_t1_color_2">@lang('Avatar')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.ntf_t1_color_2') is-invalid @enderror" name="settings[ntf_t1_color_2]" id="ntf_t1_color_2" data-key="ntf_t1_color_2" value="{{ old('settings.ntf_t1_color_2', $widget_settings_map['ntf_t1_color_2']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.ntf_t1_color_2')
                                                <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="ntf_t1_color_3">@lang('Text 1')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.ntf_t1_color_3') is-invalid @enderror" name="settings[ntf_t1_color_3]" id="ntf_t1_color_3" data-key="ntf_t1_color_3" value="{{ old('settings.ntf_t1_color_3', $widget_settings_map['ntf_t1_color_3']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.ntf_t1_color_3')
                                                <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-2">
                                          <label class="form-label" for="font1">@lang('form.lbl_font')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-2">
                                          <input type="text" name="settings[ntf_font]" id="font1" value="{{ old('settings.ntf_font', $widget_settings_map['ntf_font']['value']) }}" data-key="ntf_font" class="form-control col-lg-9 col-sm-12 selectfont @error('settings.ntf_font') is-invalid @enderror" onchange="buildWidget(this);" required>
                                          @error('settings.ntf_font')
                                          <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <hr class="mt-4 mb-4">
                                    <div class="form-group mb-3">
                                       <div class="row">
                                          <div class="col-lg-3 col-sm-12">
                                             <label class="form-label pt-2" for="forDuration">@lang('form.lbl_duration') (@lang('form.lbl_seconds'))</label>
                                          </div>
                                          <div class="col-lg-9 col-sm-12">
                                             <input type="number" name="settings[ntf_duration]" id="ntf_duration" min="5" max="30" step="1" class="form-control col-9 @error('settings.ntf_duration') is-invalid @enderror" id="template_text" data-key="ntf_duration" value="{{ old('settings.ntf_duration', $widget_settings_map['ntf_duration']['value']) }}" onchange="buildWidget(this);" required>
                                             @error('settings.ntf_duration')
                                             <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group mb-3">
                                       <div class="row">
                                          <div class="col-lg-3 col-sm-12">
                                             <label class="form-label pt-2" for="animation-select">@lang('form.lbl_animation')</label>
                                          </div>
                                          <div class="col-lg-9 col-sm-12">
                                             @php
                                                $animateList = [
                                                   'animate__tada' => 'tada',
                                                   'animate__flash' => 'flash',
                                                   'animate__swing' => 'swing',
                                                   'animate__rubberBand' => 'rubberBand',
                                                   'animate__heartBeat' => 'heartBeat',
                                                   'animate__wobble' => 'wobble',
                                                   'animate__zoomInUp' => 'zoomInUp',
                                                   'animate__zoomInDown' => 'zoomInDown',
                                                   'animate__zoomInLeft' => 'zoomInLeft',
                                                   'animate__zoomInRight' => 'zoomInRight',
                                                ];
                                             @endphp
                                             <select name="settings[ntf_animation]" class="form-select @error('settings.ntf_animation') is-invalid @enderror" data-key="ntf_animation" onchange="buildWidget(this);" required>
                                                @foreach($animateList as $key => $animateName)
                                                <option value="{{ $key }}" @if(old('settings.ntf_animation', $widget_settings_map['ntf_animation']['value'])==$key) selected @endif>{{ ucwords($animateName) }}</option>
                                                @endforeach
                                             </select>
                                             @error('settings.ntf_animation')
                                             <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group mb-3">
                                       <div class="row">
                                          <div class="col-lg-3 col-sm-12">
                                             <label class="form-label pt-2" for="animation-select">@lang('form.lbl_notif_sound')</label>
                                          </div>
                                          <div class="col-lg-9 col-sm-12">
                                             <select name="settings[ntf_sound]" class="form-select @error('settings.ntf_sound') is-invalid @enderror" data-key="ntf_sound" onchange="buildWidget(this);" required>
                                                @foreach($ntfSounds as $key => $sound)
                                                <option value="{{ $sound['file_name'] }}" @if(old('settings.ntf_sound', $widget_settings_map['ntf_sound']['value']) == $sound['file_name']) selected @endif>{{ $sound['name'] }}</option>
                                                @endforeach
                                             </select>
                                             @error('settings.ntf_sound')
                                             <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center">
                                       <div class="col-lg-3 col-sm-12">
                                          <label class="form-label " for="ntf_mute">@lang('form.lbl_notif_mute')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-12">
                                          <div class="form-check form-switch d-block">
                                             <input type="hidden" name="settings[ntf_mute]" id="ntf_mute_input" value="{{ old('settings.ntf_mute', $widget_settings_map['ntf_mute']['value']) }}" />
                                             <input type="checkbox" id="ntf_mute" class="form-check-input  @error('settings.ntf_mute') is-invalid @enderror" data-key="ntf_mute" value="1" {{ ($widget_settings_map['ntf_mute']['value'] == 1) ? 'checked' : ''}} onchange="buildWidget(this);">
                                             {{-- <label class="form-check-label mx-2 pt-1" for="ntf_mute">@lang('form.lbl_show_footer')</label> --}}
                                             @error('settings.ntf_mute')
                                             <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <hr class="mt-4 mb-4">
                                    <div class="col-12 mb-3 ">
                                       <div class="form-group row mb-3">
                                          <div class="col-lg-3 col-sm-12">
                                             <label class="form-label" for="ntf_min_support">@lang('form.lbl_min_support_for_notifications') </label>
                                          </div>
                                          <div class="col-lg-9 col-sm-12">
                                             <input type="number" name="settings[ntf_min_support]" id="ntf_min_support" min="0" max="500000" step="1000" class="form-control col-9 @error('settings.ntf_min_support') is-invalid @enderror" id="template_text" data-key="ntf_min_support" value="{{ old('settings.ntf_min_support', $widget_settings_map['ntf_min_support']['value']) }}" onchange="buildWidget(this);" required>
                                             @error('settings.ntf_min_support')
                                             <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                             @enderror
                                             <div class="mt-1">
                                                <small class="form-label "><i>* @lang('form.lbl_min_support_for_notifications_desc')</i></small>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-group row mb-3">
                                          <div class="col-lg-3 col-sm-12">
                                             <label class="form-label" for="template_text">@lang('form.lbl_template_text')</label>
                                          </div>
                                          <div class="col-lg-9 col-sm-12">
                                             <input type="text" name="settings[ntf_template_text]" class="form-control @error('settings.ntf_template_text') is-invalid @enderror" id="template_text" data-key="ntf_template_text" value="{{ old('settings.ntf_template_text', $widget_settings_map['ntf_template_text']['value']) }}" oninput="buildWidget(this);" required>
                                             @error('settings.ntf_template_text')
                                             <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                       <div class="form-group row d-flex align-items-center mt-3">
                                          <div class="d-flex justify-content-end mt-3">
                                             <div class="col-lg-5 col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary rounded-pill mb-1 w-100 " id="btn-submit">@lang('form.btn_save_and_generate_url')</button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-md-12 col-lg-12">
                     @include('components.overlay-setting-url', ['url' => $url])
                  </div>
               </div>
            </div>
            <div class="col-md-12 col-lg-4 col-sm-12 order-1 order-lg-2 " >
               <div class="overlaysticky"   id="overlay-preview-div">
                  <div class="accordion col-notifikasi bg-transparent " id="accordionExample">
                     <div class="accordion-item bg-white rounded-small">
                        <h2 class="accordion-header bg-transparent text-black " id="headingOne">
                           <button class="accordion-button  bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              @lang('Preview')
                           </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                              @include('components.overlay-setting-preview', ['url' => $url, 'url_iframe' => $url_iframe, 'notificationAction' => true])
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('scripts')
   <script src="{{ asset('template/js/jquery.fontselect.min.js') }}"></script>
   <script src="{{ asset('assets/js/clipboard.min.js') }}"></script>
   <script src="{{ asset('assets/js/script.js') }}"></script>
   <script src="{{ asset('assets/js/utils.js') }}"></script>
   <script src="{{ asset('assets/js/omg-widget-host.js') }}"></script>
   <script src="{{ asset('assets/js/overlay.js') }}"></script>
   <script type="text/javascript" src="{{ asset('assets/js/guide/overlay.js') }}"></script>
   <script>

      let notifSound = null; 

      $(() => {
         window.addEventListener("message", (e) => {
            var data = e.data;

            if (data === "childCallbacksHasRegistered") {
               switchColorThemeInput("{{ $widget_settings_map['ntf_theme']['value'] }}");
               if (!isChildCallbackEmpty()) {
                  if (childCallbacks.getQParamsByKey('ntf_mute') == 0) {
                     setTimeout(() => {
                        childCallbacks.setAnimation(childCallbacks.getQParamsByKey('ntf_animation'));
                        playPreviewSound(childCallbacks.getQParamsByKey('ntf_sound') || 'coin-win.wav');
                     }, 2 * 1000);
                  }
               }
            }
         });

         $('#input-form').on('submit', () => {
            removeSettingElementByTheme($('#themes-select').val());
         });

         $('#btn-push-notif').on('click', async function() {
            let button = $(this);
            let label = button.attr('data-label');

            if (childCallbacks.hasOwnProperty('getQParams')) {
               let params = childCallbacks.getQParams();
               button.attr('disabled', true);

               await axios.get(`${api_url}widget/overlay/show/notification?${params}`)
                  .then(function(response) {
                     // console.log(response);
                     const {
                        data
                     } = response;
                     const {
                        message,
                        status
                     } = data;

                     let timeleft = 10;
                     let downloadTimer = setInterval(function() {
                        if (timeleft <= 0) {
                           clearInterval(downloadTimer);

                           button.html(label);
                           button.attr('disabled', false);
                        } else {
                           button.html(`${label} (${timeleft})`);
                        }

                        timeleft -= 1;
                     }, 1000);
                  })
                  .catch(function(error) {
                     console.log(error);

                     button.html(label);
                     button.attr('disabled', false);
                  });
            } else {
               console.log("Can't send test notification! required method: getQParams");
            }
         });
      });

      const buildWidget = (el) => {
         const elKey = $(el).attr('data-key');
         let value = escape($(el).val());;

         if (isChildCallbackEmpty()) {
            console.log('buildWidget', 'childCallbacks not registered!');
            return false;
         }

         switch (elKey) {
            case 'ntf_theme':
               if (value == "simple") {
                  // Hide the other
                  $('#color-palete-default').hide();

                  // Show simple theme setting
                  $('#color-palete-simple').show();
               } else if (value == "default" || value == "default-dev") {
                  // Hide the other
                  $('#color-palete-simple').hide();

                  // Show default theme setting
                  $('#color-palete-default').show();
               }

               // Switch color scheme for color input 
               switchColorThemeInput(value);

               childCallbacks.buildParams('ntf_theme', value);
               childCallbacks.reloadWidget();
               break;
            case 'real_data':
               value = $(el).is(":checked") ? '1' : '0';
               childCallbacks.buildParams('real_data', value);
               childCallbacks.reloadWidget();
               break;

               // Color scheme for Default theme
            case 'ntf_t1_color_1':
               childCallbacks.setStyle('--color-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ntf_t1_color_2':
               childCallbacks.setStyle('--color-card-avatar', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ntf_t1_color_3':
               childCallbacks.setStyle('--color-text-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ntf_font':
               childCallbacks.setFont(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ntf_template_text':
               if (value.length) {
                  childCallbacks.setHTML('template_text', value);
                  childCallbacks.buildParams(elKey, value);
               }
               break;
            case 'ntf_animation':
               childCallbacks.setAnimation(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ntf_sound':
               if (!$('#ntf_mute').is(":checked")) {
                  playPreviewSound(value);
               }
               break;
            case 'ntf_mute':
               value = $(el).is(":checked") ? '1' : '0';

               childCallbacks.buildParams(elKey, value);
               $('#ntf_mute_input').val(value);
               break;
            default:
               break;
         }
      }

      const switchColorThemeInput = (theme) => {
         if (isChildCallbackEmpty() && !childCallbacks.hasOwnProperty('getQParamsByKey')) {
            console.log('switchColorThemeInput', 'childCallbacks not registered!');
            return false;
         }

         switch (theme) {
            case 'default':
            case 'default-dev':
               $('#ntf_t1_color_1').val(childCallbacks.getQParamsByKey('ntf_t1_color_1') || '#6103D0');
               $('#ntf_t1_color_2').val(childCallbacks.getQParamsByKey('ntf_t1_color_2') || '#ebebeb');
               $('#ntf_t1_color_3').val(childCallbacks.getQParamsByKey('ntf_t1_color_3') || '#ebebeb');
               break;
            default:
               break;
         }
      }

      const playPreviewSound = (audioFile) => {
         if (notifSound != null) {
            notifSound.pause();
            notifSound = null;
         }
         
         notifSound = new Audio(`{{ asset("assets/audio") }}/${audioFile}`);
         let ntfSound = notifSound.play();
         if (ntfSound!== undefined) {
            ntfSound.then(_ => {

            }).catch(error => {
                  console.log('Please click in the body area first.');
            });
         }
      }

      const removeSettingElementByTheme = (theme) => {
         if (isChildCallbackEmpty()) {
            console.log('removeSettingElementByTheme', 'childCallbacks not registered!');
            
            $('#color-palete-default').remove();

            return false;
         }

         if (theme == "default") {
           // TODO: Hide some element according theme
         }
      }
   </script>
@endsection