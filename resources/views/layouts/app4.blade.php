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
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /*
         * Globals
         */

        @media (min-width: 48em) {
          html {
            font-size: 18px;
          }
        }

        body {
          font-family: Georgia, "Times New Roman", Times, serif;
          color: #555;
        }

        h1, .h1,
        h2, .h2,
        h3, .h3,
        h4, .h4,
        h5, .h5,
        h6, .h6 {
          font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
          font-weight: normal;
          color: #333;
        }


        /*
         * Override Bootstrap's default container.
         */

        .container {
          max-width: 60rem;
        }


        /*
         * Masthead for nav
         */

        .blog-masthead {
          margin-bottom: 3rem;
          background-color: #428bca;
          -webkit-box-shadow: inset 0 -.1rem .25rem rgba(0,0,0,.1);
                  box-shadow: inset 0 -.1rem .25rem rgba(0,0,0,.1);
        }

        /* Nav links */
        .nav-link {
          position: relative;
          padding: 1rem;
          font-weight: 500;
          color: #cdddeb;
        }
        .nav-link:hover,
        .nav-link:focus {
          color: #fff;
          background-color: transparent;
        }

        /* Active state gets a caret at the bottom */
        .nav-link.active {
          color: #fff;
        }
        .nav-link.active:after {
          position: absolute;
          bottom: 0;
          left: 50%;
          width: 0;
          height: 0;
          margin-left: -.3rem;
          vertical-align: middle;
          content: "";
          border-right: .3rem solid transparent;
          border-bottom: .3rem solid;
          border-left: .3rem solid transparent;
        }


        /*
         * Blog name and description
         */

        .blog-header {
          padding-bottom: 1.25rem;
          margin-bottom: 2rem;
          border-bottom: .05rem solid #eee;
        }
        .blog-title {
          margin-bottom: 0;
          font-size: 2rem;
          font-weight: normal;
        }
        .blog-description {
          font-size: 1.1rem;
          color: #999;
        }

        @media (min-width: 40em) {
          .blog-title {
            font-size: 3.5rem;
          }
        }


        /*
         * Main column and sidebar layout
         */

        /* Sidebar modules for boxing content */
        .sidebar-module {
          padding: 1rem;
          /*margin: 0 -1rem 1rem;*/
        }
        .sidebar-module-inset {
          padding: 1rem;
          background-color: #f5f5f5;
          border-radius: .25rem;
        }
        .sidebar-module-inset p:last-child,
        .sidebar-module-inset ul:last-child,
        .sidebar-module-inset ol:last-child {
          margin-bottom: 0;
        }


        /* Pagination */
        .blog-pagination {
          margin-bottom: 4rem;
        }
        .blog-pagination > .btn {
          border-radius: 2rem;
        }


        /*
         * Blog posts
         */

        .blog-post {
          margin-bottom: 4rem;
        }
        .blog-post-title {
          margin-bottom: .25rem;
          font-size: 2.5rem;
        }
        .blog-post-meta {
          margin-bottom: 1.25rem;
          color: #999;
        }


        /*
         * Footer
         */

        .blog-footer {
          padding: 2.5rem 0;
          color: #999;
          text-align: center;
          background-color: #f9f9f9;
          border-top: .05rem solid #e5e5e5;
        }
        .blog-footer p:last-child {
          margin-bottom: 0;
        }
    </style>
    <!-- Scripts -->



    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    
</head>
<body>
    <div class="blog-masthead">
      <div class="container">
        <nav class="nav blog-nav">
          <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    
                    @include('partials.menu')

                    
                    @include('partials.userbar')
          </div>
        </nav>
      </div>
    </div>

    @if (Auth::guest())
        @include('partials.loginbox2')
    @endif

    <!-- JQUERY-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

    <!-- Bootstrap Script -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->

    <!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <!-- application script -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- page specific scripts -->
    @yield('page.script')
</body>
</html>
