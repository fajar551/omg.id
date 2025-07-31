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
                                 <div class="col-md-12">
                                    <div class="form-group mb-3">
                                       <div class="row">
                                          <div class="col-lg-3 col-sm-12">
                                             <label class="form-label pt-2" for="themes-select">@lang('form.lbl_themes')</label>
                                          </div>
                                          <div class="col-lg-9 col-sm-12">
                                             <select name="settings[ldb_theme]" class="form-select @error('settings.ldb_theme') is-invalid @enderror" id="themes-select" data-key="ldb_theme" onchange="buildWidget(this);" required>
                                                @foreach($themes as $k => $v)
                                                <option value="{{ strtolower($v) }}" @if(old('settings.ldb_theme', $widget_settings_map['ldb_theme']['value'])==strtolower($v)) selected @endif>{{ ucwords(str_replace('-', ' ', $v)) }}</option>
                                                @endforeach
                                             </select>
                                             @error('settings.ldb_theme')
                                             <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row form-group mb-0 d-flex aligin-items-center">
                                       <div class="col-lg-3 col-sm-12">
                                          <label class="form-label pt-3 " for="">@lang('Palet Warna')</label>
                                       </div>
                                       {{-- Default theme color palete--}}
                                       <div class="row col-lg-9 col-sm-12" id="color-palete-default" @if (old('settings.ldb_theme', $widget_settings_map['ldb_theme']['value']) !="default" ) style="display: none" @endif>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="ldb_t1_color_1">@lang('Header')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.ldb_t1_color_1') is-invalid @enderror" name="settings[ldb_t1_color_1]" id="ldb_t1_color_1" data-key="ldb_t1_color_1" value="{{ old('settings.ldb_t1_color_1', $widget_settings_map['ldb_t1_color_1']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.ldb_t1_color_1')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="ldb_t1_color_2">@lang('List')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.ldb_t1_color_2') is-invalid @enderror" name="settings[ldb_t1_color_2]" id="ldb_t1_color_2" data-key="ldb_t1_color_2" value="{{ old('settings.ldb_t1_color_2', $widget_settings_map['ldb_t1_color_2']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.ldb_t1_color_2')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="ldb_t1_color_3">@lang('Border')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.ldb_t1_color_3') is-invalid @enderror" name="settings[ldb_t1_color_3]" id="ldb_t1_color_3" data-key="ldb_t1_color_3" value="{{ old('settings.ldb_t1_color_3', $widget_settings_map['ldb_t1_color_3']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.ldb_t1_color_3')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="ldb_t1_color_4">@lang('Text 1')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.ldb_t1_color_4') is-invalid @enderror" name="settings[ldb_t1_color_4]" id="ldb_t1_color_4" data-key="ldb_t1_color_4" value="{{ old('settings.ldb_t1_color_4', $widget_settings_map['ldb_t1_color_4']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.ldb_t1_color_4')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="ldb_t1_color_5">@lang('Text 2')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.ldb_t1_color_5') is-invalid @enderror" name="settings[ldb_t1_color_5]" id="ldb_t1_color_5" data-key="ldb_t1_color_5" value="{{ old('settings.ldb_t1_color_5', $widget_settings_map['ldb_t1_color_5']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.ldb_t1_color_5')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
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
                                          <input type="text" name="settings[ldb_font]" id="font1" class="form-control col-lg-9 col-sm-12 selectfont @error('settings.ldb_font') is-invalid @enderror" value="{{ old('settings.ldb_font', $widget_settings_map['ldb_font']['value']) }}" data-key="ldb_font" onchange="buildWidget(this);" required>
                                          @error('settings.ldb_font')
                                          <div class="invalid-feedback">{{ str_replace('settings.ldb', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <hr class="mt-4 mb-4">
                                    <div class="form-group mb-3">
                                       <div class="row d-flex align-items-center">
                                          <div class="col-lg-3 col-sm-12">
                                             <label class="form-label " for="ldb_support_count">@lang('form.lbl_supporter_count')</label>
                                          </div>
                                          <div class="col-lg-9 col-sm-12">
                                             <select name="settings[ldb_support_count]" id="ldb_support_count" class="form-select col-9 @error('settings.ldb_support_count') is-invalid @enderror" data-key="ldb_support_count" onchange="buildWidget(this);" required>
                                                @for($i = 1; $i <= 10; $i++) 
                                                   <option value="{{ $i }}" @if(old('settings.ldb_support_count', $widget_settings_map['ldb_support_count']['value'])==$i) selected @endif>{{ $i }} Sopporter</option>
                                                @endfor
                                             </select>
                                             @error('settings.ldb_support_count')
                                             <div class="invalid-feedback">{{ str_replace('settings.ldb', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group mb-3 row d-flex align-items-centerr">
                                       <div class="col-lg-3 col-sm-12">
                                          <label class="form-label " for="ldb_interval">@lang('form.lbl_time_interval')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-12">
                                          <select name="settings[ldb_interval]" id="ldb_interval" class="form-select  @error('settings.ldb_interval') is-invalid @enderror" data-key="ldb_interval" onchange="buildWidget(this);" required>
                                             @foreach([1,3,5,7,14,30,60,90] as $hari )
                                                <option value="{{ $hari }}" @if(old('settings.ldb_interval', $widget_settings_map['ldb_interval']['value'])==$hari) selected @endif>{{ $hari }} Days ago</option>
                                             @endforeach
                                          </select>
                                          @error('settings.ldb_interval')
                                          <div class="invalid-feedback">{{ str_replace('settings.ldb', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="form-group mb-3 row d-flex align-items-centerr">
                                       <label class="form-label col-lg-3 col-sm-12" for="ldb_interval">@lang('form.lbl_title')</label>
                                       <div class="col-lg-9 col-sm-12">
                                          <input type="text" name="settings[ldb_title]" id="ldb_title" class="form-control col-9 @error('settings.ldb_title') is-invalid @enderror" value="{{ old('settings.ldb_title', $widget_settings_map['ldb_title']['value']) }}" data-key="ldb_title" oninput="buildWidget(this);" required>
                                          @error('settings.ldb_title')
                                          <div class="invalid-feedback">{{ str_replace('settings.ldb', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="form-group row mb-3 row d-flex align-items-centerr">
                                       <label class="form-label col-lg-3 col-sm-12" for="ldb_subtitle">@lang('form.lbl_subtitle')</label>

                                       <div class="col-lg-9 col-sm-12">
                                          <input type="text" name="settings[ldb_subtitle]" id="ldb_subtitle" class="form-control col-9 @error('settings.ldb_subtitle') is-invalid @enderror" value="{{ old('settings.ldb_subtitle', $widget_settings_map['ldb_subtitle']['value']) }}" data-key="ldb_subtitle" oninput="buildWidget(this);" required>
                                          @error('settings.ldb_subtitle')
                                          <div class="invalid-feedback">{{ str_replace('settings.ldb', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="form-group mb-3 row d-flex align-items-centerr">
                                       <div class="col-sm-12 col-lg-3">
                                          <label class="form-label mt-1" for="ldb_show_nominal_input">@lang('form.lbl_show_nominal')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-12">
                                          <div class="form-check form-switch d-block">
                                             <input type="hidden" name="settings[ldb_show_nominal]" id="ldb_show_nominal_input" value="{{ old('settings.ldb_show_nominal', $widget_settings_map['ldb_show_nominal']['value']) }}">
                                             <input type="checkbox" id="ldb_show_nominal" class="form-check-input @error('settings.ldb_show_nominal') is-invalid @enderror" value="1" @if(old('settings.ldb_show_nominal', $widget_settings_map['ldb_show_nominal']['value'])==1) checked @endif data-key="ldb_show_nominal" onchange="buildWidget(this);">
                                             @error('settings.ldb_show_nominal')
                                             <div class="invalid-feedback">{{ str_replace('settings.ldb', '', $message) }}</div>
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
                     <div class="accordion-item bg-white rounded-small">
                        <h2 class="accordion-header bg-transparent text-black " id="headingOne">
                           <button class="accordion-button  bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              @lang('Preview')
                           </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                              @include('components.overlay-setting-preview', ['url' => $url, 'url_iframe' => $url_iframe, 'ldbAction' => true])
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
   <script type="text/javascript">
      $(() => {
         window.addEventListener("message", (e) => {
            var data = e.data;

            if(data === "childCallbacksHasRegistered") {
               switchColorThemeInput("{{ $widget_settings_map['ldb_theme']['value'] }}");
            }
         });

         $('#input-form').on('submit', () => {
            removeSettingElementByTheme($('#themes-select').val());
         });

         $('#overlay-preview').css("min-height", "450px");

      });

      const buildWidget = (el) => {
         const elKey = $(el).attr('data-key');
         let value = escape($(el).val());;

         if (isChildCallbackEmpty()) {
            console.log('buildWidget', 'childCallbacks not registered!');
            return false;
         }

         switch (elKey) {
            case 'ldb_theme':
               // Switch color scheme for color input 
               switchColorThemeInput(value);

               childCallbacks.buildParams('ldb_theme', value);
               childCallbacks.reloadWidget();
               break;
            case 'real_data':
               value = $(el).is(":checked") ? '1' : '0';
               childCallbacks.buildParams('real_data', value);
               childCallbacks.reloadWidget();
               break;

            // Color scheme for Default theme
            case 'ldb_t1_color_1':
               childCallbacks.setStyle('--bg-leaderboard-header', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ldb_t1_color_2':
               childCallbacks.setStyle('--bg-leaderboard-list', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ldb_t1_color_3':
               childCallbacks.setStyle('--color-border-list', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ldb_t1_color_4':
               childCallbacks.setStyle('--color-text-header', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ldb_t1_color_5':
               childCallbacks.setStyle('--color-text-list', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ldb_font':
               childCallbacks.setFont(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'ldb_support_count':
               childCallbacks.buildParams(elKey, value);
               childCallbacks.init();
               break;
            case 'ldb_interval':
               childCallbacks.buildParams(elKey, value);
               childCallbacks.reloadWidget();
               break;
            case 'ldb_title':
               if (value.length) {
                  childCallbacks.setHTML('title', value);
                  childCallbacks.buildParams(elKey, value);
               }
               break;
            case 'ldb_subtitle':
               if (value.length) {
                  childCallbacks.setHTML('subtitle', value);
                  childCallbacks.buildParams(elKey, value);
               }
               break;
            case 'ldb_show_nominal':
               let element = childCallbacks.getElementsByClassName('show_nominal');
               console.log(element);

               for (let i = 0; i < element.length; i++) {
                  if ($(el).is(":checked")) {
                     element[i].removeAttribute('hidden');
                  } else {
                     element[i].setAttribute('hidden', '');
                  }
               }

               value = $(el).is(":checked") ? '1' : '0';
               $('#ldb_show_nominal_input').val(value);
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
               $('#ldb_t1_color_1').val(childCallbacks.getQParamsByKey('ldb_t1_color_1') || '#6103D0');
               $('#ldb_t1_color_2').val(childCallbacks.getQParamsByKey('ldb_t1_color_2') || '#f1ebf7');
               $('#ldb_t1_color_3').val(childCallbacks.getQParamsByKey('ldb_t1_color_3') || '#C99BFD');
               $('#ldb_t1_color_4').val(childCallbacks.getQParamsByKey('ldb_t1_color_4') || '#ebebeb');
               $('#ldb_t1_color_5').val(childCallbacks.getQParamsByKey('ldb_t1_color_5') || '#2d2d39');
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
            // TODO
         } 
      }
   </script>
@endsection