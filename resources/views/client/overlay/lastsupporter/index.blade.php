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
            <div class="col-md-12 col-lg-8  col-sm-12 order-2 order-lg-1">
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
                                             <select name="settings[lst_theme]" class="form-select @error('settings.lst_theme') is-invalid @enderror" id="themes-select" data-key="lst_theme" onchange="buildWidget(this);" required>
                                                @foreach($themes as $k => $v)
                                                <option value="{{ strtolower($v) }}" @if(old('settings.lst_theme', $widget_settings_map['lst_theme']['value'])==strtolower($v)) selected @endif>{{ ucwords(str_replace('-', ' ', $v)) }}</option>
                                                @endforeach
                                             </select>
                                             @error('settings.lst_theme')
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
                                       <div class="row col-lg-9 col-sm-12" id="color-palete-default" @if (old('settings.lst_theme', $widget_settings_map['lst_theme']['value']) !="default" ) style="display: none" @endif>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="lst_t1_color_1">@lang('Body')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t1_color_1') is-invalid @enderror" name="settings[lst_t1_color_1]" id="lst_t1_color_1" data-key="lst_t1_color_1" value="{{ old('settings.lst_t1_color_1', $widget_settings_map['lst_t1_color_1']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t1_color_1')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="lst_t1_color_2">@lang('Footer')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t1_color_2') is-invalid @enderror" name="settings[lst_t1_color_2]" id="lst_t1_color_2" data-key="lst_t1_color_2" value="{{ old('settings.lst_t1_color_2', $widget_settings_map['lst_t1_color_2']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t1_color_2')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="lst_t1_color_3">@lang('Text 1')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t1_color_3') is-invalid @enderror" name="settings[lst_t1_color_3]" id="lst_t1_color_3" data-key="lst_t1_color_3" value="{{ old('settings.lst_t1_color_3', $widget_settings_map['lst_t1_color_3']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t1_color_3')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="lst_t1_color_4">@lang('Text 2')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t1_color_4') is-invalid @enderror" name="settings[lst_t1_color_4]" id="lst_t1_color_4" data-key="lst_t1_color_4" value="{{ old('settings.lst_t1_color_4', $widget_settings_map['lst_t1_color_4']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t1_color_4')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                       </div>
                                       {{-- Simple theme color palete --}}
                                       <div class="row col-lg-9 col-sm-12" id="color-palete-simple" @if (old('settings.lst_theme', $widget_settings_map['lst_theme']['value']) !="simple" ) style="display: none" @endif>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="lst_t2_color_1">@lang('Body')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent @error('settings.lst_t2_color_1') is-invalid @enderror" name="settings[lst_t2_color_1]" id="lst_t2_color_1" data-key="lst_t2_color_1" value="{{ old('settings.lst_t2_color_1', $widget_settings_map['lst_t2_color_1']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t2_color_1')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group">
                                                <label class="form-label" for="lst_t2_color_2">@lang('Footer')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t2_color_2') is-invalid @enderror" name="settings[lst_t2_color_2]" id="lst_t2_color_2" data-key="lst_t2_color_2" value="{{ old('settings.lst_t2_color_2', $widget_settings_map['lst_t2_color_2']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t2_color_2')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group">
                                                <label class="form-label" for="lst_t2_color_3">@lang('Text 1')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t2_color_3') is-invalid @enderror" name="settings[lst_t2_color_3]" id="lst_t2_color_3" data-key="lst_t2_color_3" value="{{ old('settings.lst_t2_color_3', $widget_settings_map['lst_t2_color_3']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t2_color_3')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group">
                                                <label class="form-label" for="lst_t2_color_4">@lang('Text 2')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t2_color_4') is-invalid @enderror" name="settings[lst_t2_color_4]" id="lst_t2_color_4" data-key="lst_t2_color_4" value="{{ old('settings.lst_t2_color_4', $widget_settings_map['lst_t2_color_4']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t2_color_4')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                       </div>
                                       {{-- Card Flip theme color palete--}}
                                       <div class="row col-lg-9 col-sm-12" id="color-palete-cardflip" @if (old('settings.lst_theme', $widget_settings_map['lst_theme']['value']) !="card-flip" ) style="display: none" @endif>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="lst_t3_color_1">@lang('Body')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t3_color_1') is-invalid @enderror" name="settings[lst_t3_color_1]" id="lst_t3_color_1" data-key="lst_t3_color_1" value="{{ old('settings.lst_t3_color_1', $widget_settings_map['lst_t3_color_1']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t3_color_1')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="lst_t3_color_2">@lang('Back')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t3_color_2') is-invalid @enderror" name="settings[lst_t3_color_2]" id="lst_t3_color_2" data-key="lst_t3_color_2" value="{{ old('settings.lst_t3_color_2', $widget_settings_map['lst_t3_color_2']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t3_color_2')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="lst_t3_color_3">@lang('Text 1')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t3_color_3') is-invalid @enderror" name="settings[lst_t3_color_3]" id="lst_t3_color_3" data-key="lst_t3_color_3" value="{{ old('settings.lst_t3_color_3', $widget_settings_map['lst_t3_color_3']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t3_color_3')
                                                <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                          <div class="col-sm-3">
                                             <div class="form-group mb-3">
                                                <label class="form-label" for="lst_t3_color_4">@lang('Text 2')</label>
                                                <input type="color" class="form-control p-0 border-0 bg-transparent  @error('settings.lst_t3_color_4') is-invalid @enderror" name="settings[lst_t3_color_4]" id="lst_t3_color_4" data-key="lst_t3_color_4" value="{{ old('settings.lst_t3_color_4', $widget_settings_map['lst_t3_color_4']['value']) }}" onchange="buildWidget(this);">
                                                @error('settings.lst_t3_color_4')
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
                                          <input type="text" name="settings[lst_font]" id="font1" value="{{ old('settings.lst_font', $widget_settings_map['lst_font']['value']) }}" data-key="lst_font" class="form-control col-lg-9 col-sm-12 selectfont @error('settings.lst_font') is-invalid @enderror" onchange="buildWidget(this);" required>
                                          @error('settings.lst_font')
                                          <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <hr class="mt-4 mb-4">
                                    <div id="setting-cardflip" @if ($widget_settings_map['lst_theme']['value'] !="card-flip" ) style="display: none" @endif>
                                       <div class="form-group row d-flex align-items-center mb-3">
                                          <div class="col-lg-3 col-sm-2">
                                             <label>@lang('form.lbl_flip_type')</label>
                                          </div>
                                          <div class="col-lg-9 col-sm-2">
                                             <div class="form-check form-check-inline">
                                                <input type="radio" name="settings[lst_flip_type]" class="form-check-input @error('settings.lst_flip_type') is-invalid @enderror" id="lst_flip_type_horizontal" data-key="lst_flip_type_horizontal" @if(old('settings.lst_flip_type', $widget_settings_map['lst_flip_type']['value'])=='horizontal' ) checked @endif value="horizontal" onchange="buildWidget(this);">
                                                <label class="form-check-label" for="lst_flip_type_horizontal">@lang('Horizontal')</label>
                                             </div>
                                             <div class="form-check form-check-inline">
                                                <input type="radio" name="settings[lst_flip_type]" class="form-check-input @error('settings.lst_flip_type') is-invalid @enderror" id="lst_flip_type_vertical" data-key="lst_flip_type_vertical" @if(old('settings.lst_flip_type', $widget_settings_map['lst_flip_type']['value'])=='vertical' ) checked @endif value="vertical" onchange="buildWidget(this);">
                                                <label class="form-check-label" for="lst_flip_type_vertical">@lang('Vertical')</label>
                                             </div>
                                             @error('settings.lst_flip_type')
                                             <div class="text-danger">{{ str_replace('settings.lst', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group mb-2 row d-flex align-items-centerr">
                                       <div class="col-sm-12 col-lg-4">
                                          <label class="form-check-label pt-1" for="lst_support_message">@lang('form.lbl_show_support_message')</label>
                                       </div>
                                       <div class="col-lg-8 col-sm-12">
                                          <div class="form-check form-switch d-block">
                                             <input type="hidden" name="settings[lst_support_message]" id="lst_support_message_input" value="{{ old('settings.lst_support_message', $widget_settings_map['lst_support_message']['value']) }}" />
                                             <input type="checkbox" id="lst_support_message" class="form-check-input @error('settings.lst_support_message') is-invalid @enderror" data-key="lst_support_message" value="1" {{ ($widget_settings_map['lst_support_message']['value'] == 1) ? 'checked' : ''}} onchange="buildWidget(this);">
                                             {{-- <label class="form-check-label mx-2 pt-1" for="lst_support_message">@lang('form.lbl_show_support_message')</label> --}}
                                             @error('settings.lst_support_message')
                                             <div class="invalid-feedback">{{ str_replace('settings.lst', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-centerr">
                                       <div class="col-sm-12 col-lg-4">
                                          <label class="form-check-label pt-1" for="lst_marquee">@lang('form.lbl_set_message_as_marquee')</label>
                                       </div>
                                       <div class="col-lg-8 col-sm-12">
                                          <div class="form-check form-switch d-block">
                                             <input type="hidden" name="settings[lst_marquee]" id="lst_marquee_input" value="{{ old('settings.lst_marquee', $widget_settings_map['lst_marquee']['value']) }}" />
                                             <input type="checkbox" id="lst_marquee" class="form-check-input @error('settings.lst_marquee') is-invalid @enderror" value="1" data-key="lst_marquee" @if(old('lst_marquee', $widget_settings_map['lst_marquee']['value'])==1) checked @endif onchange="buildWidget(this);">
                                             {{-- <label class="form-check-label mx-2 pt-1" for="lst_marquee">@lang('form.lbl_set_message_as_marquee')</label> --}}
                                             @error('settings.lst_marquee')
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
                     <div class="accordion-item bg-white rounded-small">
                        <h2 class="accordion-header bg-transparent text-black " id="headingOne">
                           <button class="accordion-button  bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                           @lang('Preview')
                           </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                              @include('components.overlay-setting-preview', ['url' => $url, 'url_iframe' => $url_iframe, 'goalAction' => true])
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
               switchColorThemeInput("{{ $widget_settings_map['lst_theme']['value'] }}");
            }
         });

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
            case 'lst_theme':
               if (value == "default") {
                  // Hide the other
                  $('#color-palete-simple').hide();
                  $('#color-palete-cardflip').hide();
                  $('#setting-cardflip').hide();

                  // Show default theme setting
                  $('#color-palete-default').show();
               } else if (value == "simple") {
                  // Hide the other
                  $('#color-palete-default').hide();
                  $('#color-palete-cardflip').hide();
                  $('#setting-cardflip').hide();

                  // Show simple theme setting
                  $('#color-palete-simple').show();
               } else if (value == "card-flip") {
                  $('#color-palete-default').hide();
                  $('#color-palete-simple').hide();

                  // Show card-flip theme setting
                  $('#color-palete-cardflip').show();
                  $('#setting-cardflip').show();
               }

               // Switch color scheme for color input 
               switchColorThemeInput(value);

               childCallbacks.buildParams('lst_theme', value);
               childCallbacks.reloadWidget();
               break;
            case 'real_data':
               value = $(el).is(":checked") ? '1' : '0';
               childCallbacks.buildParams('real_data', value);
               childCallbacks.reloadWidget();
               break;

               // Color scheme for Default theme
            case 'lst_t1_color_1':
               childCallbacks.setStyle('--color-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_t1_color_2':
               childCallbacks.setStyle('--color-card-footer', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_t1_color_3':
               childCallbacks.setStyle('--color-text-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_t1_color_4':
               childCallbacks.setStyle('--color-text-footer', value);
               childCallbacks.buildParams(elKey, value);
               break;

               // Color scheme for Simple theme
            case 'lst_t2_color_1':
               childCallbacks.setStyle('--color-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_t2_color_2':
               childCallbacks.setStyle('--color-card-footer', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_t2_color_3':
               childCallbacks.setStyle('--color-text-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_t2_color_4':
               childCallbacks.setStyle('--color-text-footer', value);
               childCallbacks.buildParams(elKey, value);
               break;

               // Color scheme for Card-Flip theme
            case 'lst_t3_color_1':
               childCallbacks.setStyle('--color-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_t3_color_2':
               childCallbacks.setStyle('--color-card-back', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_t3_color_3':
               childCallbacks.setStyle('--color-text-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_t3_color_4':
               childCallbacks.setStyle('--color-text-back', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_font':
               childCallbacks.setFont(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_support_message':
               if ($(el).is(":checked")) {
                  childCallbacks.getElementById('support_message_div').removeAttribute('hidden');
               } else {
                  childCallbacks.getElementById('support_message_div').setAttribute('hidden', '');
               }

               value = $(el).is(":checked") ? '1' : '0';
               $('#lst_support_message_input').val(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_marquee':
               if ($(el).is(":checked")) {
                  childCallbacks.setHTML('support_message_div', childCallbacks.getSupportMessageType('marquee'));
                  childCallbacks.getElementById('support_message_div').classList.remove('pb-2');
                  childCallbacks.getElementById('support_message_div').classList.add('pb-0');
               } else {
                  childCallbacks.setHTML('support_message_div', childCallbacks.getSupportMessageType());
                  childCallbacks.getElementById('support_message_div').classList.add('pb-2');
               }

               value = $(el).is(":checked") ? '1' : '0';
               $('#lst_marquee_input').val(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'lst_flip_type_horizontal':
               if ($(el).is(":checked")) {
                  childCallbacks.setFlipType('horizontal', true);
                  childCallbacks.buildParams('lst_flip_type', 'horizontal');
               }
               break;
            case 'lst_flip_type_vertical':
               if ($(el).is(":checked")) {
                  childCallbacks.setFlipType('vertical', true);
                  childCallbacks.buildParams('lst_flip_type', 'vertical');
               }
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
               $('#lst_t1_color_1').val(childCallbacks.getQParamsByKey('lst_t1_color_1') || '#6103D0');
               $('#lst_t1_color_2').val(childCallbacks.getQParamsByKey('lst_t1_color_2') || '#ebebeb');
               $('#lst_t1_color_3').val(childCallbacks.getQParamsByKey('lst_t1_color_3') || '#ebebeb');
               $('#lst_t1_color_4').val(childCallbacks.getQParamsByKey('lst_t1_color_4') || '#2d2d39');
               break;
            case 'simple':
               $('#lst_t2_color_1').val(childCallbacks.getQParamsByKey('lst_t2_color_1') || '#f59c3d');
               $('#lst_t2_color_2').val(childCallbacks.getQParamsByKey('lst_t2_color_2') || '#ebebeb');
               $('#lst_t2_color_3').val(childCallbacks.getQParamsByKey('lst_t2_color_3') || '#2d2d39');
               $('#lst_t2_color_4').val(childCallbacks.getQParamsByKey('lst_t2_color_4') || '#2d2d39');
               break;
            case 'card-flip':
               $('#lst_t3_color_1').val(childCallbacks.getQParamsByKey('lst_t3_color_1') || '#6103D0');
               $('#lst_t3_color_2').val(childCallbacks.getQParamsByKey('lst_t3_color_2') || '#D0EE26');
               $('#lst_t3_color_3').val(childCallbacks.getQParamsByKey('lst_t3_color_3') || '#ebebeb');
               $('#lst_t3_color_4').val(childCallbacks.getQParamsByKey('lst_t3_color_4') || '#2d2d39');
               break;
            default:
               break;
         }
      }

      const removeSettingElementByTheme = (theme) => {
         if (isChildCallbackEmpty()) {
            console.log('removeSettingElementByTheme', 'childCallbacks not registered!');

            $('#color-palete-simple').remove();
            $('#color-palete-default').remove();
            $('#color-palete-cardflip').remove();
            $('#setting-cardflip').remove();

            return false;
         }

         if (theme == "default") {
            $('#color-palete-simple').remove();
            $('#color-palete-cardflip').remove();
            $('#setting-cardflip').remove();
         } else if (theme == "simple") {
            $('#color-palete-default').remove();
            $('#color-palete-cardflip').remove();
            $('#setting-cardflip').remove();
         } else if (theme == "card-flip") {
            $('#color-palete-default').remove();
            $('#color-palete-simple').remove();
         }
      }
   </script>
@endsection