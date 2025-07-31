@if (session($flashName))
      <div class="alert alert-left alert-{{ session('type') ?? 'info' }} alert-dismissible fade show mb-3 rounded-small" role="alert">
            <span><i class="fas fa-{{ session('type') == 'success' ? 'check' : (session('type') == 'danger' ? 'exclamation-triangle' : 'info')}}"></i></span>
            <span> {!! $message ?? session($flashName) !!} </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
@endif