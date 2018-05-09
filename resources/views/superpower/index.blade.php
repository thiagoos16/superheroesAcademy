@extends("template.app")

@section("content")
    <div class="main-panel">
        <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="#">Superpowers</a>
                </div>
            </div>
        </nav>
        
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if(Session::get('successMessage') or Session::get('errorMessage'))
                            <div class="alert alert-primary">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="material-icons">close</i>
                                </button>
                                @if(Session::get('successMessage')) 
                                    <span> {{ Session::get('successMessage') }} </span>
                                @elseif(Session::get('errorMessage'))
                                    <span> {{ Session::get('errorMessage') }} </span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{(isset($create) ? $create : "Edit")}} Superpower</h4>
                                <p class="card-category">Register a new Superpower</p>
                            </div>
                            <div class="card-body">
                                @if (isset($create))
                                    {{ Form::open(array('url' => 'superpower/create')) }} 
                                @else
                                    {{ Form::open(array('url' => 'superpower/edit')) }}
                                @endif
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div form="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                                {{ Form::label('name', 'Name', array('class' => 'bmd-label-floating')) }} 
                                                {{ Form::text('name', isset($superpower->name) ? $superpower->name : '', array('class' => 'form-control')) }}
                                                <span class="text-danger"> {{ $errors->first('name') }} </span>
                                            </div>
                                        </div>
                                    </div>
                                    @if(isset($superpower->id))
                                        <input type="hidden" name="id" value="{{ $superpower->id }}">
                                    @endif
                                    <button type="submit" class="btn btn-primary pull-right"> Submit </button>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Superpowers Listing</h4>
                                <p class="card-category">Select a Superpower to Update or to Delete</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                            <th> ID </th>
                                            <th> Name </th>
                                            <th> Actions </th>
                                        </thead>
                                        <tbody>
                                            @if (isset($superpowers))
                                                @foreach ($superpowers as $superpower)
                                                    <tr>
                                                        <td> {{ $superpower->id }} </td>
                                                        <td> {{ $superpower->name }} </td>
                                                        <td>
                                                            <a href="{{ url('superpower/edit', $superpower->id) }}" title="Edit">
                                                                <i class="material-icons">edit</i>
                                                            </a>
                                                            <a href="#" title="Delete">
                                                                <i class="material-icons">delete</i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
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
            $('#superpowers').addClass("active");
        });
    </script>
@stop