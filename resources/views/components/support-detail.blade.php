<div class="accordion card" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne{{$id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$id}}" aria-expanded="false" aria-controls="collapseOne{{$id}}">
            Show
        </button>
        </h2>
        <div id="collapseOne{{$id}}" class="accordion-collapse collapse" aria-labelledby="headingOne{{$id}}" data-bs-parent="#accordionExample">
            <div class="accordion-body">
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