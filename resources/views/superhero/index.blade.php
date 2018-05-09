@extends("template.app")

@section("content")
    <div class="main-panel">
        <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="#">Superheroes</a>
                    <a href="{{ url('superhero/viewCreate') }}" class="btn btn-primary" title="add" style="border-radius:100%; padding:15px;">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Superhero Listing</h4>
                                <p class="card-category">Select a Superhero to Update or to Delete</p>
                            </div>
                            <div class="card-body">
                                @if(isset($superheroes))
                                    @foreach($superheroes as $superhero)
                                        
                                    @endforeach
                                @endif
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