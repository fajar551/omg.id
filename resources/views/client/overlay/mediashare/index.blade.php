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
                           <form action="{{ route('overlay.store.mediashare') }}" method="POST" class="mt-2 needs-validation" id="input-form-setting" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit-setting'))" autocomplete="off">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="key" value="{{ $widget_with_settings['key'] }}">
                              <div class="row">
                                 <div class="col-md-12 ps-3 pe-3">
                                    <div class="form-group mb-3">
                                       <div class="form-check form-switch d-block">
                                          <input type="checkbox" name="status" id="status" class="form-check-input @error('status') is-invalid @enderror" value="1" {{ old('status', $status) == 1 ? 'checked' : ''}}>
                                          <label class="form-check-label mx-2" for="status">@lang('form.lbl_activate_media_share')</label>
                                          @error('status')
                                          <div class="invalid-feedback">{{ $message }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="row d-flex align-items-end">
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label class="form-label">@lang('form.lbl_max_duration') (@lang('form.lbl_seconds')) *</label>
                                             <input type="number" name="max_duration" min="60" step="1" max="1000" class="form-control @error('max_duration') is-invalid @enderror" placeholder="@lang('form.lbl_max_duration')" value="{{ old('max_duration', $max_duration) }}">
                                             @error('max_duration')
                                             <div class="invalid-feedback">{{ $message }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label class="form-label">@lang('form.lbl_price_per_second') *</label>
                                             <input type="number" name="price_per_second" min="1" step="1" max="1000" class="form-control @error('price_per_second') is-invalid @enderror" placeholder="@lang('form.lbl_price_per_second')" value="{{ old('price_per_second', $price_per_second) }}">
                                             @error('price_per_second')
                                             <div class="invalid-feedback">{{ $message }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label class="form-label">&nbsp;</label>
                                             <button type="submit" id="btn-submit-setting" class="btn btn-outline-primary rounded-pill w-100 ">@lang('form.btn_save')</button>
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
                     <div class="card border-0 shadow rounded-small card-dark">
                        <div class="card-body ">
                           <form action="{{ route('overlay.update') }}" method="POST" class="mt-2 needs-validation" id="input-form" enctype="multipart/form-data" onsubmit="doSubmit($('#btn-submit'))" autocomplete="off">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="key" value="{{ $widget_with_settings['key'] }}">
                              <div class="row">
                                 <div class="col-12">
                                    <div class="form-group row d-flex align-items-cente mb-3">
                                       <div class="col-lg-3 col-sm-12 ">
                                          <label class="form-label" for="themes-select">@lang('form.lbl_themes')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-12">
                                          <select name="settings[mds_theme]" class="form-select @error('settings.mds_theme') is-invalid @enderror" id="themes-select" data-key="mds_theme" onchange="buildWidget(this);" required>
                                             @foreach($themes as $k => $v)
                                             <option value="{{ strtolower($v) }}" @if(old('settings.mds_theme', $widget_settings_map['mds_theme']['value'])==strtolower($v)) selected @endif>{{ ucwords(str_replace('-', ' ', $v)) }}</option>
                                             @endforeach
                                          </select>
                                          @error('settings.mds_theme')
                                          <div class="invalid-feedback">{{ str_replace('settings.mds', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-cente mb-3">
                                       <div class="col-lg-3 col-sm-12">
                                          <label class="form-label" for="font1">@lang('form.lbl_font')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-12">
                                          <input type="text" name="settings[mds_font]" id="font1" value="{{ old('settings.mds_font', $widget_settings_map['mds_font']['value']) }}" data-key="mds_font" class="form-control selectfont @error('settings.mds_font') is-invalid @enderror" onchange="buildWidget(this);" required>
                                          @error('settings.mds_font')
                                          <div class="invalid-feedback">{{ str_replace('settings.mds', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-12">
                                          <label class="form-label" for="">@lang('form.lbl_color_palete')</label>
                                       </div>
                                       {{-- Default theme color palete--}}
                                       <div class="col-lg-9 col-sm-12">
                                          <div class="row" id="color-palete-default" @if (old('settings.mds_theme', $widget_settings_map['mds_theme']['value']) !="default" ) style="display: none" @endif>
                                             <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mds_t1_color_1">@lang('Body')</label>
                                                   <input type="color" class="form-control p-0 @error('settings.mds_t1_color_1') is-invalid @enderror" name="settings[mds_t1_color_1]" id="mds_t1_color_1" data-key="mds_t1_color_1" value="{{ old('settings.mds_t1_color_1', $widget_settings_map['mds_t1_color_1']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mds_t1_color_1')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mds', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mds_t1_color_2">@lang('Footer')</label>
                                                   <input type="color" class="form-control p-0 @error('settings.mds_t1_color_2') is-invalid @enderror" name="settings[mds_t1_color_2]" id="mds_t1_color_2" data-key="mds_t1_color_2" value="{{ old('settings.mds_t1_color_2', $widget_settings_map['mds_t1_color_2']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mds_t1_color_2')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mds', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mds_t1_color_3">@lang('Text 1')</label>
                                                   <input type="color" class="form-control p-0 @error('settings.mds_t1_color_3') is-invalid @enderror" name="settings[mds_t1_color_3]" id="mds_t1_color_3" data-key="mds_t1_color_3" value="{{ old('settings.mds_t1_color_3', $widget_settings_map['mds_t1_color_3']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mds_t1_color_3')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mds', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                          </div>
                                          {{-- <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mds_t1_color_4">@lang('Progress')</label>
                                                   <input type="color" class="form-control @error('settings.mds_t1_color_4') is-invalid @enderror" name="settings[mds_t1_color_4]" id="mds_t1_color_4" data-key="mds_t1_color_4" value="{{ old('settings.mds_t1_color_4', $widget_settings_map['mds_t1_color_4']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mds_t1_color_4')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mds', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                           --}}
                                       </div>
                                    </div>
                                    <hr class="mt-4 mb-4">
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-12">
                                          <label class="form-label " for="template_text">@lang('form.lbl_template_text')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-12">
                                          <input type="text" name="settings[mds_template_text]" class="form-control @error('settings.mds_template_text') is-invalid @enderror" id="template_text" data-key="mds_template_text" value="{{ old('settings.mds_template_text', $widget_settings_map['mds_template_text']['value']) }}" oninput="buildWidget(this);" required>
                                          @error('settings.mds_template_text')
                                          <div class="invalid-feedback">{{ str_replace('settings.ntf', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center">
                                       <div class="col-lg-4 col-sm-12">
                                          <label class="form-label " for="mds_show_support_message">@lang('form.lbl_show_support_message')</label>
                                       </div>
                                       <div class="col-lg-8 col-sm-12">
                                          <div class="form-check form-switch d-block">
                                             <input type="hidden" name="settings[mds_show_support_message]" id="mds_show_support_message_input" value="{{ old('settings.mds_show_support_message', $widget_settings_map['mds_show_support_message']['value']) }}" />
                                             <input type="checkbox" id="mds_show_support_message" class="form-check-input @error('settings.mds_show_support_message') is-invalid @enderror" data-key="mds_show_support_message" value="1" {{ ($widget_settings_map['mds_show_support_message']['value'] == 1) ? 'checked' : ''}} onchange="buildWidget(this);">
                                             {{-- <label class="form-check-label mx-2 pt-1" for="mds_show_support_message">@lang('form.lbl_show_support_message')</label> --}}
                                             @error('settings.mds_show_support_message')
                                             <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center">
                                       <div class="col-lg-4 col-sm-12">
                                          <label class="form-label " for="mds_show_footer">@lang('form.lbl_show_footer')</label>
                                       </div>
                                       <div class="col-lg-8 col-sm-12">
                                          <div class="form-check form-switch d-block">
                                             <input type="hidden" name="settings[mds_show_footer]" id="mds_show_footer_input" value="{{ old('settings.mds_show_footer', $widget_settings_map['mds_show_footer']['value']) }}" />
                                             <input type="checkbox" id="mds_show_footer" class="form-check-input  @error('settings.mds_show_footer') is-invalid @enderror" data-key="mds_show_footer" value="1" {{ ($widget_settings_map['mds_show_footer']['value'] == 1) ? 'checked' : ''}} onchange="buildWidget(this);">
                                             {{-- <label class="form-check-label mx-2 pt-1" for="mds_show_footer">@lang('form.lbl_show_footer')</label> --}}
                                             @error('settings.mds_show_footer')
                                             <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                             @enderror
                                          </div>
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
                     <div class="accordion-item bg-white rounded-small card-dark">
                        <h2 class="accordion-header bg-transparent text-black " id="headingOne">
                           <button class="accordion-button  bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              @lang('Preview')
                           </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                              @include('components.overlay-setting-preview', ['url' => $url, 'url_iframe' => $url_iframe, 'mediaShareAction' => true])
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
   <script>
      $(() => {
         window.addEventListener("message", (e) => {
            var data = e.data;

            if(data === "childCallbacksHasRegistered") {
               switchColorThemeInput("{{ $widget_settings_map['mds_theme']['value'] }}");
            }
         });

         $('#btn-submit').on('click', () => {
            $('#input-form').submit();
         });

         $('#btn-push-notif').on('click', async function() {
            let button = $(this);
            let label = button.attr('data-label');

            if (childCallbacks.hasOwnProperty('getQParams')) {
               let params = childCallbacks.getQParams();
               button.attr('disabled', true);

               let yt_url = $('#yt_url').val();
               let start_seconds = $('#start_seconds').val();
               let extraParams = '';

               if (yt_url) {
                  extraParams += `&yt_url=${yt_url}`;
               }
               if (start_seconds) {
                  extraParams += `&start_seconds=${start_seconds}`;
               }

               await axios.get(`${api_url}widget/overlay/show/mediashare?${params}${extraParams}`)
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

         $('#overlay-preview').css("min-height", "450px");

         $('#input-form').on('submit', () => {
            removeSettingElementByTheme($('#themes-select').val());
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
            case 'mds_theme':
               //  Switch color scheme for color input 
               switchColorThemeInput(value);

               childCallbacks.buildParams('mds_theme', value);
               childCallbacks.reloadWidget();
               break;
            case 'real_data':
               value = $(el).is(":checked") ? '1' : '0';
               childCallbacks.buildParams('real_data', value);
               childCallbacks.reloadWidget();
               break;
            case 'mds_t1_color_1':
               childCallbacks.setStyle('--color-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mds_t1_color_2':
               childCallbacks.setStyle('--color-card-footer', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mds_t1_color_3':
               childCallbacks.setStyle('--color-text-footer', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mds_t1_color_4':
               childCallbacks.setStyle('--color-progress', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mds_font':
               childCallbacks.setFont(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mds_template_text':
               if (value.length) {
                  childCallbacks.setHTML('template_text', value);
                  childCallbacks.buildParams(elKey, value);
               }
               break;
            case 'mds_show_support_message':
               if ($(el).is(":checked")) {
                  childCallbacks.getElementById('support_message_div').removeAttribute('hidden');
               } else {
                  childCallbacks.getElementById('support_message_div').setAttribute('hidden', '');
               }

               value = $(el).is(":checked") ? '1' : '0';
               $('#mds_show_support_message_input').val(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mds_show_footer':
               if ($(el).is(":checked")) {
                  childCallbacks.getElementById('footer_div').removeAttribute('hidden');
               } else {
                  childCallbacks.getElementById('footer_div').setAttribute('hidden', '');
               }

               value = $(el).is(":checked") ? '1' : '0';
               $('#mds_show_footer_input').val(value);
               childCallbacks.buildParams(elKey, value);
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
               $('#mds_t1_color_1').val(childCallbacks.getQParamsByKey('mds_t1_color_1') || '#2d2d39');
               $('#mds_t1_color_2').val(childCallbacks.getQParamsByKey('mds_t1_color_2') || '#ebebeb');
               $('#mds_t1_color_3').val(childCallbacks.getQParamsByKey('mds_t1_color_3') || '#6103D0');
               $('#mds_t1_color_4').val(childCallbacks.getQParamsByKey('mds_t1_color_4') || '#F22635');
               break;
            default:
               break;
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