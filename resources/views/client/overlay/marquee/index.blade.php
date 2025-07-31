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
                                 <div class="col-12">
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-2">
                                          <label class="form-label" for="themes-select">@lang('form.lbl_themes')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-2">
                                          <select name="settings[mrq_theme]" class="form-select @error('settings.mrq_theme') is-invalid @enderror" id="themes-select" data-key="mrq_theme" onchange="buildWidget(this);" required>
                                             @foreach($themes as $k => $v)
                                             <option value="{{ strtolower($v) }}" @if(old('settings.mrq_theme', $widget_settings_map['mrq_theme']['value'])==strtolower($v)) selected @endif>{{ ucwords(str_replace('-', ' ', $v)) }}</option>
                                             @endforeach
                                          </select>
                                          @error('settings.mrq_theme')
                                          <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-2">
                                          <label class="form-label" for="font1">@lang('form.lbl_font')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-2">
                                          <input type="text" name="settings[mrq_font]" class="form-control selectfont @error('settings.mrq_theme') is-invalid @enderror" id="font1" data-key="mrq_font" value="{{ old('settings.mrq_font', $widget_settings_map['mrq_font']['value']) }}" onchange="buildWidget(this);" required>
                                          @error('settings.mrq_font')
                                          <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-2">
                                          <label class="form-label" for="">@lang('form.lbl_color_palete')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-2">
                                          <div class="row" id="color-palete-default" @if (old('settings.mrq_theme', $widget_settings_map['mrq_theme']['value']) !="default" ) style="display: none" @endif>
                                             <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mrq_t1_color_1">@lang('Label')</label>
                                                   <input type="color" name="settings[mrq_t1_color_1]" id="mrq_t1_color_1" data-key="mrq_t1_color_1" class="form-control p-0 border-0 @error('settings.mrq_t1_color_1') is-invalid @enderror" value="{{ old('settings.mrq_t1_color_1', $widget_settings_map['mrq_t1_color_1']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mrq_t1_color_1')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mrq_t1_color_2">@lang('Background')</label>
                                                   <input type="color" name="settings[mrq_t1_color_2]" id="mrq_t1_color_2" data-key="mrq_t1_color_2" class="form-control p-0 border-0 @error('settings.mrq_t1_color_2') is-invalid @enderror" value="{{ old('settings.mrq_t1_color_2', $widget_settings_map['mrq_t1_color_2']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mrq_t1_color_2')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mrq_t1_color_3">@lang('Text 1')</label>
                                                   <input type="color" name="settings[mrq_t1_color_3]" id="mrq_t1_color_3" data-key="mrq_t1_color_3" class="form-control p-0 border-0 @error('settings.mrq_t1_color_3') is-invalid @enderror" value="{{ old('settings.mrq_t1_color_3', $widget_settings_map['mrq_t1_color_3']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mrq_t1_color_3')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mrq_t1_color_4">@lang('Text 2')</label>
                                                   <input type="color" name="settings[mrq_t1_color_4]" id="mrq_t1_color_4" data-key="mrq_t1_color_4" class="form-control p-0 border-0 @error('settings.mrq_t1_color_4') is-invalid @enderror" value="{{ old('settings.mrq_t1_color_4', $widget_settings_map['mrq_t1_color_4']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mrq_t1_color_4')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                          </div>
                                          <div class="row" id="color-palete-simple" @if (old('settings.mrq_theme', $widget_settings_map['mrq_theme']['value']) !="simple" ) style="display: none" @endif>
                                             <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mrq_t2_color_1">@lang('Body')</label>
                                                   <input type="color" name="settings[mrq_t2_color_1]" id="mrq_t2_color_1" data-key="mrq_t2_color_1" class="form-control p-0 border-0 @error('settings.mrq_t2_color_1') is-invalid @enderror" value="{{ old('settings.mrq_t2_color_1', $widget_settings_map['mrq_t2_color_1']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mrq_t2_color_1')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mrq_t2_color_2">@lang('Shadow')</label>
                                                   <input type="color" name="settings[mrq_t2_color_2]" id="mrq_t2_color_2" data-key="mrq_t2_color_2" class="form-control p-0 border-0 @error('settings.mrq_t2_color_2') is-invalid @enderror" value="{{ old('settings.mrq_t2_color_2', $widget_settings_map['mrq_t2_color_2']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mrq_t2_color_2')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-group">
                                                   <label class="form-label" for="mrq_t2_color_3">@lang('Text 1')</label>
                                                   <input type="color" name="settings[mrq_t2_color_3]" id="mrq_t2_color_3" data-key="mrq_t2_color_3" class="form-control p-0 border-0 @error('settings.mrq_t2_color_3') is-invalid @enderror" value="{{ old('settings.mrq_t2_color_3', $widget_settings_map['mrq_t2_color_3']['value']) }}" onchange="buildWidget(this);">
                                                   @error('settings.mrq_t2_color_3')
                                                   <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                                   @enderror
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <hr class="mt-4 mb-4">
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-2">
                                          <label class="form-label" for="mrq_separator_type">@lang('form.lbl_type_separator')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-2">
                                          <select name="settings[mrq_separator_type]" class="form-select @error('settings.mrq_separator_type') is-invalid @enderror" data-trigger="" id="mrq_separator_type" data-key="mrq_separator_type" onchange="buildWidget(this);" required>
                                             <option value="icon" @if(old('settings.mrq_separator_type', $widget_settings_map['mrq_separator_type']['value'])=='icon' ) selected @endif>Icon</option>
                                             <option value="dot" @if(old('settings.mrq_separator_type', $widget_settings_map['mrq_separator_type']['value'])=='dot' ) selected @endif>Dot</option>
                                          </select>
                                          @error('settings.mrq_separator_type')
                                          <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-2">
                                          <label class="form-label" for="mrq_type">@lang('Tipe Running Text')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-2">
                                          <select name="settings[mrq_type]" class="form-select @error('settings.mrq_type') is-invalid @enderror" data-trigger="" id="mrq_type" data-key="mrq_type" onchange="buildWidget(this);" required>
                                             <option value="marquee" @if(old('settings.mrq_type', $widget_settings_map['mrq_type']['value'])=='marquee' ) selected @endif>Marquee</option>
                                             <option value="horizontal" @if(old('settings.mrq_type', $widget_settings_map['mrq_type']['value'])=='horizontal' ) selected @endif>Horizontal</option>
                                             <option value="vertical" @if(old('settings.mrq_type', $widget_settings_map['mrq_type']['value'])=='vertical' ) selected @endif>Vertical</option>
                                             {{-- <option value="typewriter" @if(old('settings.mrq_type', $widget_settings_map['mrq_type']['value']) == 'typewriter') selected @endif>Typewriter</option> --}}
                                          </select>
                                          @error('settings.mrq_type')
                                          <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-2">
                                          <label class="form-label">@lang('form.lbl_speed')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-2">
                                          <div class="form-check form-check-inline">
                                             <input type="radio" name="settings[mrq_speed]" class="form-check-input @error('settings.mrq_type') is-invalid @enderror" id="mrq_speed1" data-key="mrq_speed1" value="slow" @if(old('settings.mrq_speed', $widget_settings_map['mrq_speed']['value'])=='slow' ) checked @endif onchange="buildWidget(this);" required>
                                             <label class="form-check-label" for="mrq_speed1">@lang('form.lbl_speed_slow')</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                             <input type="radio" name="settings[mrq_speed]" class="form-check-input @error('settings.mrq_type') is-invalid @enderror" id="mrq_speed2" data-key="mrq_speed2" value="normal" @if(old('settings.mrq_speed', $widget_settings_map['mrq_speed']['value'])=='normal' ) checked @endif onchange="buildWidget(this);" required>
                                             <label class="form-check-label" for="mrq_speed2">@lang('form.lbl_speed_normal')</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                             <input type="radio" name="settings[mrq_speed]" class="form-check-input @error('settings.mrq_type') is-invalid @enderror" id="mrq_speed3" data-key="mrq_speed3" value="fast" @if(old('settings.mrq_speed', $widget_settings_map['mrq_speed']['value'])=='fast' ) checked @endif onchange="buildWidget(this);" required>
                                             <label class="form-check-label" for="mrq_speed3">@lang('form.lbl_speed_fast')</label>
                                          </div>
                                       </div>
                                       @error('settings.mrq_type')
                                       <div class="text-danger">{{ str_replace('settings.mrq', '', $message) }}</div>
                                       @enderror
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    {{--
                                    <div class="form-group">
                                       <label class="form-label" for="template_text">@lang('form.lbl_title')</label>
                                       <input type="text" name="template_text" class="form-control" id="template_text" value="" placeholder="">
                                    </div>
                                    <div class="form-group">
                                       <label class="form-label" for="exampleInputdate">Amount of Running Text</label>
                                    </div>
                                    --}}
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-2">
                                          <label class="form-label " for="mrq_item_count">@lang('form.lbl_show')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-2">
                                          <input type="number" name="settings[mrq_item_count]" class="form-control @error('settings.mrq_item_count') is-invalid @enderror" max="10" step="1" id="mrq_item_count" data-key="mrq_item_count" value="{{ old('settings.mrq_item_count', $widget_settings_map['mrq_item_count']['value']) }}" oninput="buildWidget(this);" required>
                                          @error('settings.mrq_item_count')
                                          <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                          @enderror
                                          <div class="mt-1">
                                             <small class="form-label "><i>* @lang('form.lbl_running_text_in_list')</i></small>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row d-flex align-items-center mb-3">
                                       <div class="col-lg-3 col-sm-2">
                                          <label class="form-label" for="mrq_messages">@lang('form.lbl_additional_message')</label>
                                       </div>
                                       <div class="col-lg-9 col-sm-2">
                                          <textarea type="text" name="settings[mrq_messages]" id="mrq_messages" class="form-control notif @error('settings.mrq_messages') is-invalid @enderror" oninput="buildWidget(this);">{{ old('settings.mrq_messages', $widget_settings_map['mrq_messages']['value']) }}</textarea>
                                          @error('settings.mrq_messages')
                                          <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                          @enderror
                                          <div class="mt-1">
                                             <small class="form-label "><i>* @lang('form.lbl_additional_message_desc')</i></small>
                                          </div>
                                       </div>
                                    </div>
                                    <hr class="mt-4 mb-4">
                                    <div class="form-group mb-2 row d-flex align-items-centerr">
                                       <div class="col-sm-12 col-lg-4">
                                          <label class="form-check-label" for="mrq_show_support_message">@lang('form.lbl_show_supporter_message')</label>
                                       </div>
                                       <div class="col-lg-8 col-sm-12">
                                          <div class="form-check form-switch d-block">
                                             <input type="hidden" name="settings[mrq_show_support_message]" id="mrq_show_support_message_input" value="{{ old('settings.mrq_show_support_message', $widget_settings_map['mrq_show_support_message']['value']) }}">
                                             <input class="form-check-input @error('settings.mrq_show_support_message') is-invalid @enderror" type="checkbox" id="mrq_show_support_message" data-key="mrq_show_support_message" value="1" @if(old('settings.mrq_show_support_message', $widget_settings_map['mrq_show_support_message']['value'])==1) checked @endif onchange="buildWidget(this);">
                                             {{-- <label class="form-check-label mx-2" for="mrq_show_support_message">@lang('form.lbl_show_supporter_message')</label> --}}
                                             @error('settings.mrq_show_support_message')
                                             <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group mb-2 row d-flex align-items-centerr">
                                       <div class="col-sm-12 col-lg-4">
                                          <label class="form-check-label" for="mrq_txtshadow">@lang('form.lbl_text_shadow')</label>
                                       </div>
                                       <div class="col-lg-8 col-sm-12">
                                          <div class="form-check form-switch d-block">
                                             <input type="hidden" name="settings[mrq_txtshadow]" id="mrq_txtshadow_input" value="{{ old('settings.mrq_txtshadow', $widget_settings_map['mrq_txtshadow']['value']) }}">
                                             <input class="form-check-input @error('settings.mrq_txtshadow') is-invalid @enderror" type="checkbox" id="mrq_txtshadow" data-key="mrq_txtshadow" value="1" @if(old('settings.mrq_txtshadow', $widget_settings_map['mrq_txtshadow']['value'])==1) checked @endif onchange="buildWidget(this);">
                                             {{-- <label class="form-check-label mx-2" for="mrq_txtshadow">@lang('form.lbl_text_shadow')</label> --}}
                                             @error('settings.mrq_txtshadow')
                                             <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                             @enderror
                                          </div>
                                       </div>
                                    </div>
                                    <div class="p-0 mb-3" id="mrq_show_label_div" @if (old('settings.mrq_theme', $widget_settings_map['mrq_theme']['value']) !="default") style="display: none" @endif >
                                       <div class="form-group mb-2 row d-flex align-items-centerr">
                                          <div class="col-sm-12 col-lg-4">
                                             <label class="form-check-label" for="mrq_show_label">@lang('form.lbl_show_label')</label>
                                          </div>
                                          <div class="col-lg-8 col-sm-12">
                                             <div class="form-check form-switch d-block">
                                                <input type="hidden" name="settings[mrq_show_label]" id="mrq_show_label_input" value="{{ old('settings.mrq_show_label', $widget_settings_map['mrq_show_label']['value']) }}">
                                                <input class="form-check-input @error('settings.mrq_show_label') is-invalid @enderror" type="checkbox" id="mrq_show_label" data-key="mrq_show_label" value="1" @if(old('settings.mrq_show_label', $widget_settings_map['mrq_show_label']['value'])==1) checked @endif onchange="buildWidget(this);">
                                                {{-- <label class="form-check-label mx-2" for="mrq_show_label">@lang('form.lbl_show_label')</label> --}}
                                                @error('settings.mrq_show_label')
                                                <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
                                                @enderror
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="p-0" id="mrq_txt_label_input" @if (old('settings.mrq_show_label', $widget_settings_map['mrq_show_label']['value']) !='1' || old('settings.mrq_theme', $widget_settings_map['mrq_theme']['value']) !="default") style="display: none" @endif>
                                       <div class="form-group row d-flex align-items-center mb-3" >
                                          <div class="col-lg-4 col-sm-2">
                                             <label class="form-label" for="mrq_txt_label">@lang('form.lbl_label_text')</label>
                                          </div>
                                          <div class="col-lg-8 col-sm-2">
                                             <input type="text" name="settings[mrq_txt_label]" class="form-control @error('settings.mrq_txt_label_input') is-invalid @enderror" maxlength="20" id="mrq_txt_label" data-key="mrq_txt_label" value="{{ old('settings.mrq_txt_label', $widget_settings_map['mrq_txt_label']['value']) }}" oninput="buildWidget(this);">
                                             @error('settings.mrq_txt_label_input')
                                             <div class="invalid-feedback">{{ str_replace('settings.mrq', '', $message) }}</div>
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
                              @include('components.overlay-setting-preview', ['url' => $url, 'url_iframe' => $url_iframe, 'marqueeAction' => true])
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
               switchColorThemeInput("{{ $widget_settings_map['mrq_theme']['value'] }}");
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
            case 'mrq_theme':
               if (value == "default") {
                  // Hide other
                  $('#color-palete-simple').hide();

                  // Show label input for theme default
                  $('#mrq_show_label_div').show();
                  $('#mrq_txt_label_input').show();
                  
                  // Show the current
                  $('#color-palete-default').show();
               } else if (value == "simple") {
                  // Hide other
                  $('#color-palete-default').hide();

                  // Hide label input for theme simple
                  $('#mrq_txt_label_input').hide();
                  $('#mrq_show_label_div').hide();
                  
                  // Show the current
                  $('#color-palete-simple').show();
               }

               // Switch color scheme for color input 
               switchColorThemeInput(value);

               childCallbacks.buildParams('mrq_theme', value);
               childCallbacks.reloadWidget();
               break;
            case 'real_data':
               value = $(el).is(":checked") ? '1' : '0';
               childCallbacks.buildParams('real_data', value);
               childCallbacks.reloadWidget();
               break;

            // Color scheme for Default theme
            case 'mrq_t1_color_1':
               childCallbacks.setStyle('--color-card-label', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mrq_t1_color_2':
               childCallbacks.setStyle('--color-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mrq_t1_color_3':
               childCallbacks.setStyle('--color-text-label', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mrq_t1_color_4':
               childCallbacks.setStyle('--color-text-card', value);
               childCallbacks.buildParams(elKey, value);
               break;

            // Color scheme for Simple theme
            case 'mrq_t2_color_1':
               childCallbacks.setStyle('--color-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mrq_t2_color_2':
               childCallbacks.setStyle('--color-card-shadow', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mrq_t2_color_3':
               childCallbacks.setStyle('--color-text-card', value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mrq_font':
               childCallbacks.setFont(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mrq_item_count':
               if (value.length) {
                  childCallbacks.buildParams(elKey, value);
                  childCallbacks.reloadWidget();
               }
               break;
            case 'mrq_messages':
               childCallbacks.buildParams(elKey, value);
               break;
               // case 'mrq_interval':
            case 'mrq_separator_type':
               childCallbacks.buildParams(elKey, value);
               childCallbacks.reloadWidget();
               break;
            case 'mrq_type':
               childCallbacks.buildParams(elKey, value);
               childCallbacks.reloadWidget();
               break;
            case 'mrq_speed1':
            case 'mrq_speed2':
            case 'mrq_speed3':
               childCallbacks.buildParams('mrq_speed', value);
               childCallbacks.reloadWidget();
               break;
            case 'mrq_show_support_message':
               let element = childCallbacks.getElementsByClassName('supporter_message');

               for (let i = 0; i < element.length; i++) {
                  if ($(el).is(":checked")) {
                     element[i].removeAttribute('hidden');
                  } else {
                     element[i].setAttribute('hidden', '');
                  }
               }

               value = $(el).is(":checked") ? '1' : '0';
               $('#mrq_show_support_message_input').val(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mrq_txtshadow':
               if ($(el).is(":checked")) {
                  childCallbacks.setStyle('--text-shadow', '2px 2px 3px #858585');
               } else {
                  childCallbacks.setStyle('--text-shadow', '0');
               }

               value = $(el).is(":checked") ? '1' : '0';
               $('#mrq_txtshadow_input').val(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mrq_show_label':
               if ($(el).is(":checked")) {
                  $('#mrq_txt_label_input').show();
                  childCallbacks.getElementById('marquee-label').removeAttribute('hidden');
               } else {
                  $('#mrq_txt_label_input').hide();
                  childCallbacks.getElementById('marquee-label').setAttribute('hidden', '');
               }

               value = $(el).is(":checked") ? '1' : '0';
               $('#mrq_show_label_input').val(value);
               childCallbacks.buildParams(elKey, value);
               break;
            case 'mrq_txt_label':
               childCallbacks.setHTML('marquee-label-text', value);
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
               $('#mrq_t1_color_1').val(childCallbacks.getQParamsByKey('mrq_t1_color_1') || '#ffc107');
               $('#mrq_t1_color_2').val(childCallbacks.getQParamsByKey('mrq_t1_color_2') || '#ebebeb');
               $('#mrq_t1_color_3').val(childCallbacks.getQParamsByKey('mrq_t1_color_3') || '#ebebeb');
               $('#mrq_t1_color_4').val(childCallbacks.getQParamsByKey('mrq_t1_color_4') || '#6103D0');
               break;
            case 'simple':
               $('#mrq_t2_color_1').val(childCallbacks.getQParamsByKey('mrq_t2_color_1') || '#ebebeb');
               $('#mrq_t2_color_2').val(childCallbacks.getQParamsByKey('mrq_t2_color_2') || '#6103D0');
               $('#mrq_t2_color_3').val(childCallbacks.getQParamsByKey('mrq_t2_color_3') || '#2d2d39');
               break;
            default:
               break;
         }
      }

      const removeSettingElementByTheme = (theme) => {
         if (isChildCallbackEmpty()) {
            console.log('removeSettingElementByTheme', 'childCallbacks not registered!');
            
            $('#color-palete-default').remove();
            $('#color-palete-simple').remove();

            return false;
         }
         
         if (theme == "default") {
            $('#color-palete-simple').remove();
         } else if (theme == "simple") {
            $('#color-palete-default').remove();
            $('#mrq_txt_label_input').remove();
            $('#mrq_show_label_div').remove();
         }
      }
   </script>
@endsection