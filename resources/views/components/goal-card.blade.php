<div class="card bg-white shadow rounded-small border-0">
      <div class="card-header bg-transparent d-flex justify-content-end border-0 d-none">
        <div class="header-title">
            <span class="badge badge-success fw-light p-2">
                {{ isset($isPreview) ? __('page.goal_detail') : (!$goal ? __('page.no_active_goal') : __('page.active_goal')) }}
            </span>
        </div>
        <div class="card-header-toolbar d-flex align-items-center">
            <p>&nbsp;</p>
        </div>
      </div>
      @if (!$goal)
        <div class="card-body">
            <blockquote class="blockquote mb-0">
                <p class="font-size-18 ">@lang('page.no_active_goal_description')</p>
                <footer class="blockquote-footer  font-size-12">
                    <a href="{{ route('goal.mygoal.create') }}" type="button" class="acard mb-1"><cite>@lang('form.btn_create_goal')</cite></a>
                </footer>
            </blockquote>
        </div>
      @else
      <div class="card-body px-4">
            <div class="py-3">
                <h3 class="fw-semibold "> {{ $goal['title'] }}</h3>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="mb-3">
                        @include('components.goal-progress-md', ['progress' => $goalProgress['progress']])
                    </div>
                </div>
                <div class="col-6">
                    <span class="fw-semibold">{{ $goalProgress['formated_target_achieved'] }}</span>
                </div>
                <div class="col-6">
                    <div class="d-flex justify-content-end">
                        <span class="fw-semibold">{{ $goal['formated_target'] }} </span>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-12 col-md-12">
                    <div class="row mb-3">
                        <div class="col-6"><span class="fw-semibold">@lang('form.lbl_target') @lang('form.lbl_visibility')</span></div>
                        <div class="col-6"><span>{{ $goal['formated_target_visibility'] }}</span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6"><span class="fw-semibold">@lang('form.lbl_visibility')</span></div>
                        <div class="col-6"><span>{{ $goal['formated_visibility'] }}</span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6"><span class="fw-semibold">@lang('form.lbl_milestone')</span></div>
                        <div class="col-6">
                            <span>{{ $goal['enable_milestone'] ? $goal['start_at'] . ' - ' . $goal['end_at'] : __('page.na') }}</span>
                            @if ($goal['enable_milestone'])
                            <br>
                            <small style="font-style: italic">@lang('page.about'), {{ $goal['milestone'] }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="goal-dec">
                <span class="fw-semibold">@lang('form.lbl_description')</span>
                <p class="mt-2">{{ $goal['description'] ?? '-' }}</p>
            </div>
      </div>
            @if (!isset($isPreview))
            <div class="card-footer bg-transparent border-0 card-dark-80 pb-3">
                <div class="d-flex justify-content-end btn-my-goal">
                    @if ($goalProgress['progress'] >= 100)
                    <button type="button" class="btn btn-outline-success rounded-pill btn-block mt-1 me-2" id="set-reached" title="@lang('form.btn_set_as_reached')"> @lang('Tercapai')</button>
                    <form action="{{ route('goal.mygoal.setreached') }}" method="POST" id="set-reached-form" hidden>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $goal['id'] }}" required />
                    </form>
                    @endif
                    <a id="button-edit-my-goal" href="{{ route('goal.mygoal.edit', ['id' => $goal['id']]) }}" type="button" class="btn btn-primary rounded-pill btn-block mt-1" title="@lang('form.btn_edit_goal')"> @lang('form.btn_edit_goal')</a>
                </div>
            </div>
            @endif
      @endif
</div>
