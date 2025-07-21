<div class="accordion card " id="accordionExample-{{ $id }}">
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading-{{ $id }}">
        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $id }}" aria-expanded="false" aria-controls="collapse-{{ $id }}">
            @lang('Show')
        </button>
        </h2>
        <div id="collapse-{{ $id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $id }}" data-bs-parent="#accordionExample-{{ $id }}" style="">
            <div class="accordion-body ps-3 pe-3 pt-1 pb-1">
                @foreach ($summaries as $key => $summary)
                    <div class="d-flex d-flex justify-content-between">
                        {{ ucwords($key) }}:
                        <small class="ms-2 text-end">{!! $summary !!}</small>
                    </div>
                    <hr class="mt-1 mb-2">
                @endforeach
            </div>
        </div>
    </div>
</div>