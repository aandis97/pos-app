@extends('admin.templates.master')

@section('content')
  <div class="col-md-6 col-md-offset-3">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Add a Category</h3>
      </div>

      <form class="form-horizontal" action="{{ route('category.store') }}" method="post">
        @csrf
        <div class="box-body">
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <input type="text" name="name" class="form-control" value="{{ old('name') }}">
              @if($errors->has('name'))
                <p class="help-block">
                  {{ $errors->first('name') }}
                </p>
              @endif
            </div>
          </div>
          <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
              <input type="text" name="description" class="form-control" value="{{ old('description') }}">
              @if($errors->has('description'))
                <p class="help-block">
                  {{ $errors->first('description') }}
                </p>
              @endif
            </div>
          </div>
          <div class="box-footer">
            <a href="{{ route('category.index') }}" class="btn btn-default">Cancel</a>
            <button type="submit" class="btn btn-info pull-right">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
