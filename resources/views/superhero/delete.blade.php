@extends("template.app")

@section("content")
    <div class="main-panel">
        <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="#">Superheroes</a>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Delete {{$superhero->nickname}} Superhero</h4>
                                <p class="card-category">Do you really want to delete this Superhero?</p>
                            </div>
                            <div class="card-body">
                            <div class="pull-right">
                                <a href="{{ url('superhero/delete', $superhero->id) }}" class="btn btn-primary">
                                    Confirm <i class="material-icons">check_circle</i>
                                </a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script> 
    <script type="text/javascript">
        $(function() {
            $('#superheroes').addClass("active");
        });
    </script>
@stop