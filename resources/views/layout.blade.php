<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>{{ $title }} | Erajaya App</title>

   <link href="{{ mix('css/app.css') }}" rel="stylesheet">

   @yield('css')
</head>

<body>
   @yield('modal')

   @include('partials.breadcrumb')
   @include('partials.sidebar')

   <!-- Content -->
   <div class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72">
      @yield('content')
   </div>
   <!-- End Content -->
   <!-- jQuery first -->
   {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

   <!-- DataTables JS -->
   <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script> --}}
   <script src="{{ mix('js/app.js') }}"></script>
   @yield('js')
</body>

</html>
