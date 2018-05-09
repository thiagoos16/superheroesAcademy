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
                                <h4 class="card-title">Superhero Create</h4>
                                <p class="card-category">Fill in the Fields to Register a New Superhero</p>
                            </div>
                            <div class="card-body">
                                {{ Form::open(array('url' => 'superhero/create')) }} 
                                    <div class="row"> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Nickname</label>
                                                <input type="text" name="nickname" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Real Name</label>
                                                <input type="text" name="real_name" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Catch Phrase</label>
                                                <input type="text" name="catch_phrase" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Origin Description</label>
                                                <textarea name="origin_description" class="form-control" rows=3> </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label>Superpowers</label>
                                                <select class="form-control" id="superpower_id">
                                                    <option value = "" disabled selected>Superpower</option>
                                                    @foreach($superpowers as $superpower)
                                                        <option value="{{$superpower->id}}"> {{$superpower->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="margin-top:13px;"> 
                                            <div class="form-group">
                                                <a href="#table" id="add_superpower" class="btn btn-primary" title="Add Superpower" style="border-radius:100%; padding:15px;">
                                                    <i class="material-icons">add</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <table class="table"> 
                                                <tbody id="listTable"> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> 

                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label>Images</label>
                                            </div>
                                            <table class="imageTable"> 
                                                <tbody id="listImageTable"> 
                                                    <input type="file" name="images[]">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-2" style="margin-top:13px;"> 
                                            <div class="form-group">
                                                <a href="#table" id="add_image" class="btn btn-primary" title="Add Image" style="border-radius:100%; padding:15px;">
                                                    <i class="material-icons">add</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary pull-right"> Submit </button>
                                {{ Form::close() }}
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
        $(document).ready(function() {
            var i = 1;

            $('#add_superpower').click(function() {
                var id = $('#superpower_id').val();
                var value= $('#superpower_id option:selected').text();
                
                $('#listTable').append(
                    '<tr id="row' + i + '"> <td> <label> ' + value + ' </label> <input type="hidden" name="superpowerList[]" value="' + id + '"/> </td> <td> <a href="#table" name="btn_remove" class="btn_remove" id="' + i + '"> <i class="material-icons">delete</i> </a> </td> </tr>'
                );
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var i = 1;

            $('#add_image').click(function() {
                $('#listImageTable').append(
                    '<tr id="imageRow' + i + '"> <td> <input type="file" name="images[]"/> </td> <td> <a href="#imageTable" name="btn_remove_image" class="btn_remove_image" id="' + i + '"> <i class="material-icons">delete</i> </a> </td> </tr>'
                );
            });

            $(document).on('click', '.btn_remove_image', function(){
                var button_id = $(this).attr("id");
                $('#imageRow' + button_id + '').remove();
            });
        })
    </script>
@stop