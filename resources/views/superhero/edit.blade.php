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
                                <h4 class="card-title">Superhero Edit</h4>
                                <p class="card-category">Fill in the Fields to Edit <b>{{$superhero->nickname}}</b> Superhero</p>
                            </div>
                            <div class="card-body">
                                {{ Form::open(array('url' => 'superhero/edit', 'enctype' => 'multipart/form-data')) }} 
                                    <div class="row"> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Nickname</label>
                                                <input type="text" name="nickname" class="form-control" value="{{ $superhero->nickname }}">
                                                <span class="text-danger"> {{ $errors->first('nickname') }} </span>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Real Name</label>
                                                <input type="text" name="real_name" class="form-control" value="{{ $superhero->real_name }}">
                                                <span class="text-danger"> {{ $errors->first('real_name') }} </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Catch Phrase</label>
                                                <input type="text" name="catch_phrase" class="form-control" value="{{ $superhero->catch_phrase }}">
                                                <span class="text-danger"> {{ $errors->first('catch_phrase') }} </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Origin Description</label>
                                                <textarea name="origin_description" class="form-control" rows=3> {{ $superhero->origin_description }} </textarea>
                                                <span class="text-danger"> {{ $errors->first('origin_description') }} </span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="superhero_id" value="{{ $superhero->id }}">
                                    <button type="submit" class="btn btn-primary pull-right"> Submit </button>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Superpowers of {{ $superhero->nickname }}</h4>
                                <p class="card-category">Select a Superpower to Delete</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                            <th> Name </th>
                                            <th> Actions </th>
                                        </thead>
                                        <tbody>
                                            @if (isset($superpowers))
                                                @foreach ($superpowers as $superpower)
                                                    <tr id="row{{$superpower->id}}">
                                                        <td> {{ $superpower->name }} </td>
                                                        <td>
                                                            <a href="#table" data-superheroId="{{$superhero->id}}" data-superpowerId="{{$superpower->id}}" id="{{$superpower->id}}" title="Delete" class="btn_remove_superpower">
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
            $('#superheroes').addClass("active");
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.btn_remove_superpower', function() {
                var superhero_id = $(this).attr('data-superheroId');
                var superpower_id = $(this).attr('data-superpowerId');
                var line_id = $(this).attr('id');
                
                $.ajax({
                    url:"{{ url('superhero/detachOneSuperpower') }}/" + superhero_id + "/" + superpower_id,
                    method:"GET",
                    success:  function() {
                        $('#row' + line_id + '').remove();
                        alert("Superpower Successfully Deleted.");
                    },
                    error:  function () {
                        alert("Coud not Delete Superpower.");
                    }
                });
            });
        });
    </script>
@stop
