@if(session('success'))
  <div class="alert alert-success">
    <p>{{ session('success') }}</p>
  </div>
@endif

@if(session('info'))
  <div class="alert alert-info">
    <p>{{ session('info') }}</p>
  </div>
@endif

@if(session('danger'))
  <div class="alert alert-danger">
    <p>{{ session('danger') }}</p>
  </div>
@endif
