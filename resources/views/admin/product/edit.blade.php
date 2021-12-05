@extends('admin.templates.master')

@section('content')
  <div class="col-md-10 col-md-offset-1">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Edit a Product</h3>
      </div>

      <form class="form-horizontal" action="{{ route('product.update', $product) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="box-body">
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <input type="text" name="name" class="form-control" value="{{ $product->name ?? old('name') }}">
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
              <textarea name="description" class="form-control" id="editor1">{{ $product->description ?? old('description') }}</textarea>
              @if($errors->has('description'))
                <p class="help-block">
                  {{ $errors->first('description') }}
                </p>
              @endif
            </div>
          </div>

            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
              <label class="col-sm-2 control-label">Price</label>
              <div class="col-sm-10">
                <input type="text" name="price" class="form-control" value="{{ $product->price ?? old('price') }}">
                @if($errors->has('price'))
                  <p class="help-block">
                    {{ $errors->first('price') }}
                  </p>
                @endif
              </div>
            </div>


          <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
            <label class="col-sm-2 control-label">Image</label>
            <div class="col-sm-10">
              <input type="file" name="image" class="form-control" value="{{ old('image') }}">
              @if($errors->has('image'))
                <p class="help-block">
                  {{ $errors->first('image') }}
                </p>
              @endif
            </div>
          </div>

          <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
            <label class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10">
              <select name="category[]" class="form-control select2" multiple="multiple">
                @foreach($categories as $category)
                  <option value="{{ $category->id }}"
                    @if($product->categories->contains($category))
                      selected
                    @endif
                    >{{ $category->name }}</option>
                @endforeach
              </select>
              @if($errors->has('category'))
                <p class="help-block">
                  {{ $errors->first('category') }}
                </p>
              @endif
            </div>
          </div>

          <div class="box-footer">
            <a href="{{ route('product.index') }}" class="btn btn-default">Cancel</a>
            <button type="submit" class="btn btn-info pull-right">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('admin/bower_components/select2/dist/css/select2.min.css') }}">

@endpush

@push('scripts')
<script src="{{ asset('admin/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script>
  $(function(){
    $('.select2').select2();
    
    CKEDITOR.replace('editor1');
  });
</script>
@endpush
