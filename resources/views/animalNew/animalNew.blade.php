@extends('base')

@section('content')
<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Animal Lover New Animal</a>
        </div>

    </div>
</nav>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">Add Animal</h4>
                    <p class="category">Pleae add animal</p>
                </div>
                <div class="card-content table-responsive table-full-width">
                    @if ( $errors->count() > 0 )
                        <p>The following errors have occurred:</p>

                        <ul>
                            @foreach( $errors->all() as $message )
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <form action="/add_animal" role="form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <h4 align="center">Name</h4>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <input type="text" placeholder="Input Name" class="form-control" name="name" id="name" required/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <h4 align="center">Kind</h4>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <select class="form-control" name="cid" required>
                                            <?php foreach($kind as $item)
                                                echo "<option value='".$item->cid."'>".$item->kind."</option>";
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <h4 align="center">Sex</h4>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <select class="form-control" name="gender" required>
                                            <option value="0">Male</option>
                                            <option value="1">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <h4 align="center">Age</h4>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" placeholder="Input Age" class="form-control" name="age" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <h4 align="center">Color</h4>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" placeholder="Input Color" class="form-control" name="color" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <h4 align="center">Size</h4>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <select class="form-control" name="size" required>
                                            <option value="0">Small</option>
                                            <option value="1">Medium</option>
                                            <option value="1">Large</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <h4 align="center">Picture</h4>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <input type="file" class="form-control" name="image" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <h4 align="center">Status</h4>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <select class="form-control" name="status" required>
                                            <option value="0">Intake</option>
                                            <option value="1">Adoptable</option>
                                            <option value="1">Closed</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-8 col-sm-8" style="padding-left: 50px;padding-right: 50px">
                                <div class="row">
                                    <h4>Informatie(Nederlands)</h4>
                                </div>
                                <div class="row">
                                    <textarea class="form-control" placeholder="Input informatie" rows="5" name="infoNe"></textarea>
                                </div>
                                <div class="row">
                                    <h4>Informashon(Papianentu)</h4>
                                </div>
                                <div class="row">
                                    <textarea class="form-control" placeholder="Here can be your nice text" rows="5" name="infoPa"></textarea>
                                </div>
                                <div class="row">
                                    <h4>Information(English)</h4>
                                </div>
                                <div class="row">
                                    <textarea class="form-control" placeholder="Here can be your nice text" rows="5" name="infoEn"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" align="center">
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection