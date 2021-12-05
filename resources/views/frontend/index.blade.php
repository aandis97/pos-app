<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }} ">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/font-awesome/css/font-awesome.min.css') }} ">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/Ionicons/css/ionicons.min.css') }} ">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }} ">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/iCheck/square/blue.css') }} ">

    <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }} ">

    <style>
        .item-product {
            background-color: white;
            height: 500px;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 20px;
        }
    </style>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand"><b>Majoo</b> Teknologi Indonesia</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
                            <li ><a href="{{ route('category.index') }}">Goto Admin Page</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="content-wrapper">
            <div class="container">
                <h3>Select Products by Categories : </h3>
                <section class="" id="categories">
                </section>

                <section class="content">
                    <row id="products">

                    </row>
                </section>
            </div>
        </div>
        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.4.13
                </div>
                <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
                reserved.
            </div>
            <!-- /.container -->
        </footer>
    </div>
    <!-- ./wrapper -->


    <!-- jQuery 3 -->
    <script src="{{ asset('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('admin/plugins/iCheck/icheck.min.js') }}"></script>

    <script>
        var selectedCategoryIds = [];
        var currentCategories = [];
        refreshProduct();

        function addOrRemoveCategoryIds(id) {
            if (selectedCategoryIds.includes(id)) {
                selectedCategoryIds = selectedCategoryIds.filter(item => item != id);
            } else {
                selectedCategoryIds.push(id);
            }

            console.log(selectedCategoryIds);
            refreshProduct();

            // regenerate categories label
            var categoriesData = '';
            currentCategories.forEach((item, index, arr) => {
                categoriesData += `<a href="#"><label class="label `+(selectedCategoryIds.includes(item.id) ? 'label-success' : 'label-default')+`" onClick="addOrRemoveCategoryIds(` + item.id + `)">` + item.name + `</label></a> `;
            });
            $('#categories').html(categoriesData);
        }

        function refreshProduct() {
            console.log('refresh product');

            $(document).ready(function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('api.products') }}",
                    data: {
                        category_ids: selectedCategoryIds,
                    },
                    success: function(data) {
                        console.log(data);
                        var products = data.data;

                        var productsData = '';

                        products.forEach((item, index, arr) => {
                            var baseUrl = "{{ url('/images/products') }}";

                            productsData += `
                                <div class="col-md-4" >
                                    <div class="item-product">
                                        <img src="`+ baseUrl+"/"+item.image + `" style="width:100%">
                                        <h4>` + item.name + `</h4>
                                        <h6> Rp. ` + formatRupiah(item.price) + `</h6>
                                        <p>` + item.description + `</p>
                                    </div>
                                </div>
                            `;
                        });

                        $('#products').html(productsData);
                    }
                });
            });
        }

        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('api.categories') }}",
                data: {
                    filter: 'all',
                    is_active: 'true'
                },
                success: function(data) {
                    console.log(data);
                    var categories = data.data;

                    var categoriesData = '';

                    categories.forEach((item, index, arr) => {

                        console.log("item" + item.name);
                        console.log("index" + index);
                        console.log("arr" + arr);
                        currentCategories.push({
                            "id": item.id,
                            "name": item.name,
                        });

                        categoriesData += `<a href="#"><label class="label label-default" onClick="addOrRemoveCategoryIds(` + item.id + `)">` + item.name + `</label></a> `;
                    });

                    $('#categories').append(categoriesData);
                }
            });
        });

        function formatRupiah(angka) {
            var number_string = angka.toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }
    </script>
</body>

</html>