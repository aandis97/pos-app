@extends('admin.templates.master')

@section('content') 
@include('admin.templates.components._alerts')
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Product</h3>
        </div>

        <div class="box-body">
          <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
          <br>
          <br>
          <table class="table table-bordered">
            <tr>
              <th>No</th>
              <th>Name</th>
              <th>Image</th>
              <th>Slug</th>
              <!-- <th>Description</th> -->
              <th>Category</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
            @php
              $page = 1;

              if(request()->has('page')) {
                $page = request('page');
              }

              $no = config('olshop.pagination') * $page  - (config('olshop.pagination')-1);
            @endphp
            @foreach($products as $item)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $item->name }}</td>
              <td>
                <img src="{{ url('images/products/'.$item->image)  }}" alt="" width="50px">
              </td>
              <td>{{ $item->slug }}</td>
              <!-- <td>{{ $item->description }}</td> -->
              <td>
                @foreach($item->categories as $category)
                  <span class="label label-primary">{{ $category->name }}</span>
                @endforeach
              </td>
              <td>{{ $item->price }}</td>
              <td>
                <a href="{{ route('product.edit',$item) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                <button  class="btn btn-danger" id="delete" data-title="{{ $item->name }}" href="{{ route('product.destroy', $item) }}"><i class="fa fa-trash"></i></button>
              </td>

              <form action="" method="post" id="deleteForm">
                @csrf
                @method("DELETE")
              </form>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer clearfix">
          {{ $products->links() }}
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  $('button#delete').on('click', function(){
    var href = $(this).attr('href');
    var name = $(this).data('title');

    swal({
      title: "Are you sure to delete \""+name+"\"?",
      text: "Once deleted, you will not be able to recover this data!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        document.getElementById('deleteForm').action = href;
        document.getElementById('deleteForm').submit();
        swal("Poof! Your data has been deleted!", {
          icon: "success",
        });
      }
    });
  });
</script>
@endpush
