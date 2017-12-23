<!DOCTYPE html>
<html lang="en">
<head>
@include('base.head')
</head>
<body>
<div class="wrapper">

    <div class="sidebar" data-color="purple" data-image="../assets/img/sidebar-1.jpg">
        <!--
            Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

            Tip 2: you can also add an image using data-image tag
        -->

        <div class="logo">
            <a href="/" class="simple-text">
                <img src="{{ asset('/images/logo.png') }}" alt="logo image" style="width: 100px;height: 70px"/>
            </a>
        </div>

        <div class="sidebar-wrapper">
            <ul class="nav">
                @if(!session('user'))
                <li class="<?php  if($select == "dashboard") echo "active"; ?>">
                    <a href="/">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                    @endif
                <li class="<?php if($select == "account") echo "active"; ?>">
                    <a href="/user">
                        <i class="material-icons">person</i>
                        <p>My Account</p>
                    </a>
                </li>
                <li class="<?php if($select == "list") echo "active"; ?>">
                    <a href="/animalList">
                        <i class="material-icons">content_paste</i>
                        <p>Animal List</p>
                    </a>
                </li>
                <li class="<?php if($select == "new") echo "active"; ?>">
                    <a href="/animalNew">
                        <i class="material-icons">library_books</i>
                        <p>New Animal</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?php if($select == "dashboard"){?>
        <div class="main-panel" style="background-image: url('/images/dashboard.jpg');background-repeat: no-repeat;background-size: cover;">
            {{--//style="image background-image: url('/images/dashboard.jpg')"--}}
    <?php }else{ ?>
        <div class="main-panel">
            <?php } ?>
        @yield('content')
        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="#">Angel Team</a>, made with love for Animal Lover
                </p>
            </div>
        </footer>
    </div>
</div>
<?php if($select == "list"){ ?>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog"  style="width: 70%">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Animal</h4>
            </div>
            <form action="/edit_animal" role="form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="aid" id="aid">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
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
                                    <select class="form-control" name="cid" id="cid" required>
                                        <?php foreach($kind as $item){ echo "<option value='".$item->cid."'>".$item->kind."</option>"; } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <h4 align="center">Sex</h4>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <select class="form-control" name="gender" id="gender" required>
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
                                        <input type="number" placeholder="Input Age" class="form-control" name="age" id="age" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <h4 align="center">Color</h4>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Input Color" class="form-control" name="color" id="color" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <h4 align="center">Size</h4>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <select class="form-control" name="size" id="size" required>
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
                                    <input type="file" class="form-control" name="image">
                                    <img src="" name="photo" id="photo"  style="width: 100px;height: 100px">
                                    <input type="hidden" name="photo" id="photo1" value="222">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <h4 align="center">Status</h4>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="0">Intake</option>
                                        <option value="1">Adoptable</option>
                                        <option value="1">Closed</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-7 col-sm-7" style="padding-left: 50px;padding-right: 50px">
                            <div class="row">
                                <h4>Informatie(Nederlands)</h4>
                            </div>
                            <div class="row">
                                <textarea class="form-control" placeholder="Input informatie" rows="5" name="infoNe" id="infoNe"></textarea>
                            </div>
                            <div class="row">
                                <h4>Informashon(Papianentu)</h4>
                            </div>
                            <div class="row">
                                <textarea class="form-control" placeholder="Here can be your nice text" rows="5" name="infoPa" id="infoPa"></textarea>
                            </div>
                            <div class="row">
                                <h4>Information(English)</h4>
                            </div>
                            <div class="row">
                                <textarea class="form-control" placeholder="Here can be your nice text" rows="5" name="infoEn" id="infoEn"></textarea>
                            </div>
                        </div>
                    </div>


                </div>
                <hr>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="save">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<?php } ?>

@include('base.foot')
</body>
</html>
