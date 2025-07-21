<div class="card border-0 shadow rounded-small">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h5 class="card-title">@lang('page.overlay_url')</h5>
        </div>
        <div class="card-header-toolbar d-flex align-items-center">
            <a href="javascript:void(0);" class="btn btn-outline-warning btn-sm me-2 copy" data-clipboard-action="copy" data-clipboard-target="#urlcopy" >@lang('form.btn_copy_url')</a>
            <a href="{{ $url }}" class="btn btn-outline-warning btn-sm open-url" target="_blank" id="open-url-btn">@lang('form.btn_open_url')</a>
        </div>
    </div>
    <div class="card-body ps-4 pe-4">
        <div class="form-group mb-1">
            <textarea id="urlcopy" class="form-control">{{ $url }}</textarea>
        </div>
        <small><i>* @lang('page.overlay_url_copy_desc')</i></small>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-outline-success mb-1 w-50 " id="btn-submit">@lang('form.btn_save_and_generate_url')</button>
        </div>
    </div>
</div>