<!Doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">

        <title>Superheroes Academy</title>

        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

        <!-- Material Dashboard CSS -->
        <link rel="stylesheet" href="/css/material-dashboard.css">

        <style>
            .pagination {
                display: inline-block;
            }

            .pagination a {
                color: black;
                float: left;
                padding: 8px 16px;
                text-decoration: none;
            }

            .pagination li.active span {
                background-color: #9c27b0;
                color: white;
                float: left;
                padding: 8px 16px;
                text-decoration: none;
                border-radius:3px;
                box-shadow: 0 4px 20px 0px rgba(0, 0, 0, .14),
                            0 7px 10px -5px rgba(156, 39, 176, 0.4);
                webkit-box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 
                                   0 7px 10px -5px rgba(156, 39, 176, 0.4);
            }

            .pagination a:hover:not(.active) {background-color: #ddd;}

            .pagination li.disabled span {
                color: black;
                float: left;
                padding: 8px 16px;
                text-decoration: none;
            }
        </style>
    </head>
    <body class="">
        <div class="wrapper">
            <div class="sidebar" data-color="purple" data-background-color="white">
                <div class="logo">
                    <a href="{{url('/')}}" class="simple-text logo-normal">
                        Superhero Academy
                    </a>
                </div>
                <div class="sidebar-wrapper">
                    <ul class="nav">
                        <li class="nav-item " id="superheroes">
                            <a class="nav-link" href="{{ url('superhero/') }}">
                                <i class="material-icons">accessibility</i>
                                <p>Superheroes</p>
                            </a>
                        </li>
                        <li class="nav-item " id="superpowers">
                            <a class="nav-link" href="{{ url('superpower/') }}">
                                <i class="material-icons">whatshot</i>
                                <p>Superpowers</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            @yield('content')  
        </div>
        <!--   Core JS Files   -->
        <script src="/js/core/jquery.min.js"></script>
        <script src="/js/core/popper.min.js"></script>
        <script src="/js/bootstrap-material-design.js"></script>

        <!-- Library for adding dinamically elements -->
        <script src="/js/plugins/arrive.min.js" type="text/javascript"></script>

        <!--  Notifications Plugin   -->
        <script src="/js/plugins/bootstrap-notify.js"></script>

        <!-- Plugin for Scrollbar -->
        <script src="/js/plugins/perfect-scrollbar.jquery.min.js"></script>

        <!-- Material Dashboard Core initialisations of plugins and Bootstrap Material Design Library -->
        <script src="/js/material-dashboard.js?v=2.0.0"></script>
    </body>
</html>