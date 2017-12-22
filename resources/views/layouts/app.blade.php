<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blog') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('page.css')

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>  
  <!--- work site -->
  <nav class="navbar navbar-expand-lg navbar-light menu-border">
    
    <a class="navbar-brand" href="#">{{ config('app.name') }}</a>

    <button class="navbar-toggler" 
            type="button" 
            data-toggle="collapse" 
            data-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" 
            aria-expanded="false" 
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      @include('partials.menu')  
      @include('partials.userbar')
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-sm-9 blog-main">
        @include('flash::message')
        <main>
            @yield('main')          
        </main>
      </div>
      <div class="col-sm-3 blog-sidebar">
        <aside>
            <form class="bd-search hidden-sm-down search-styling">
              <input type="text" class="form-control" id="search-input" placeholder="Search..." autocomplete="off">
            </form>
            @yield('aside')
        </aside>
      </div><!-- /.blog-sidebar -->
    </div><!-- /.row -->
  </div><!-- /.container -->
  <footer class="blog-footer">
      @yield('footer')
      &copy;{{ config('app.name', 'Blog') }}. Licensed under creative commons
      <p>
          <a href="#">Back to top</a>
      </p>
  </footer>

    @if (Auth::guest())
        @include('partials.loginbox2')
    @endif

    <!-- JQUERY-->
    <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous">
    </script>
    
    <!-- Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <!-- application script -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- page specific scripts -->
    @yield('page.script')
</body>
</html>
