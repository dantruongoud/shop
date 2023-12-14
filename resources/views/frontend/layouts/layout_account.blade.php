<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Account | E-Shopper</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/prettyPhoto.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/price-range.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{ asset('frontend/images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('frontend/images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('frontend/images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{ asset('frontedn/images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed"
        href="{{ asset('frontend/images/ico/apple-touch-icon-57-precomposed.png') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-...." crossorigin="anonymous" />
</head>
<!--/head-->

<body>

    <!--/header-->
    @include('frontend.layouts.header')

    <!--/slider-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('frontend.layouts.accout-menu-left')
                </div>
                <div class="col-sm-9" style="margin-bottom: 50px;">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>


    @include('frontend.layouts.footer')
    <!--/Footer-->



    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    {{-- <script>
        const fileInput = document.querySelector('#file-js-example input[type=file]');
      fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
          const fileName = document.querySelector('#file-js-example .file-name');
          fileName.textContent = fileInput.files[0].name;
        }
      }
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            document.getElementById('saleSelect').addEventListener('change', function () {
                var selectedValue = this.value;
    
                var saleInputContainer = document.getElementById('saleInputContainer');
    
                if (selectedValue === '1') {
                    saleInputContainer.style.display = 'inline-block';
                } else {
                    saleInputContainer.style.display = 'none';
                }
            });
        });
    </script>

    <script>
        function updateFileList() {

            var input = document.querySelector('input[type="file"]');

            var fileList = document.getElementById('file-list');
            fileList.innerHTML = '';

            if (input.files.length > 3) {
                
                input.value = ''; 
                return alert('You can only select a maximum of 3 images.');
            }
            
            for (var i = 0; i < input.files.length; i++) {
                var fileName = input.files[i].name;
                var listItem = document.createElement('div');
                listItem.textContent = fileName;
                fileList.appendChild(listItem);
            }
    }
    </script>
</body>

</html>