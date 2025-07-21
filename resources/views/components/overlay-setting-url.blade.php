<div class="card border-0 shadow rounded-small bg-primary-thin bg-primary-thin-border card-dark">
   <div class="card-body ">
      <div class="form-group row d-flex align-items-center mb-3">
         <div class="col-lg-3 col-sm-12 ">
            <label for="" class="col-form-label">Overlay URL</label>
         </div>
         <div class="col-lg-9 col-sm-12">
            <textarea id="urlcopy" class="form-control blured-input" readonly>{{ $url }}</textarea>
            <div class="d-flex justify-content-start mt-3">
               <button id="btncopyurl" type="button" class="btn btn-sm btn-outline-primary rounded-pill mb-1 me-2 copy" data-clipboard-action="copy" data-clipboard-target="#urlcopy">@lang('form.btn_copy_url')</button>
               <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-info rounded-pill mb-1 me-2 open-url">@lang('form.btn_open_url')</a>
            </div>
         </div>
      </div>
   </div>
</div>