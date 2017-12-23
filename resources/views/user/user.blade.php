@extends('base')

@section('content')
<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Animal Lover | My account</a>
        </div>
    </div>
</nav>
<div class="content">
    <div class="container-fluid">

        <div class="card" id="loginPage">
            @if(session('user')['role'] == 2)
            <div class="card-header" data-background-color="purple">
                @else
                    <div class="card-header" data-background-color="blue">
                    @endif
                @if(session('user')['role'] == 1 || session('user')['role'] == 0)
                    <h4 class="title">My Account</h4>
                    <p class="category">Pleae animal</p>
                @endif
                @if(session('user')['role'] == 2)
                    <div class="row">
                        <div class="col-md-6"><h4 class="title">Account List</h4>
                            <p class="category">Pleae animal</p></div>
                        <div class="col-md-6"><button class="btn btn-default" style="float: right"> Add Organization </button></div>
                    </div>


                    @endif
            </div>
            @if(session('user')['role'] == 1 || session('user')['role'] == 0)
            <div class="card-content table-responsive">
                <form method="post" action="/edit_account">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">

                                @if(session('user')['role'] == 1)
                                <div class="row">
                                    <div class="col-sm-4 col-md-4"><h4>Organization</h4></div>
                                    <div class="col-sm-8 col-md-8">
                                        <?php if($data[0]['organization']!=null && count($data[0]['organization']) ){?>
                                            <h4>{{ $data[0]['organization'][0]['organization_name'] }}</h4>
                                        <?php } ?>
                                    </div>
                                </div>
                                @endif

                                <div class="row">
                                    <div class="col-sm-4 col-md-4"><h4>Name</h4></div>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="hidden" name="uid" value="{{$data[0]['uid']}}">
                                        <input type="text" class="form-control" name="username" value="{{ $data[0]['username'] }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 col-md-4"><h4>Location</h4></div>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="text" class="form-control" name="location" value="{{ $data[0]['location'] }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 col-md-4"><h4>Email</h4></div>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="email" class="form-control" name="email" value="{{ $data[0]['email'] }}" required>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <hr>
                    </div>
                    <div class="row" align="center">
                        <button class="btn btn-success" type="submit"> Save </button>
                    </div>
                </form>
            </div>
                @elseif(session('user')['role'] == 2)
                <div class="card-content table-responsive">
                    <table class="table">
                        <thead class="text-success">
                            <th>Name</th>
                            <th>Location</th>
                            <th>Organization</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php $count = 0; foreach($data as $item){  ?>
                                <tr>
                                    <td>{{$item['username']}}</td>
                                    <td>{{$item['location']}}</td>
                                    <td>{{$item['organization_name']}}</td>
                                    <td><button type="button" rel="tooltip" title="Edit Task" class="edit btn btn-primary btn-simple btn-xs" data-count="<?= $count-1; ?>" data-id="{{ $item->uid }}">
                                            <i class="material-icons">edit</i>
                                        </button></td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Remove" class="remove btn btn-danger btn-simple btn-xs" data-id="{{ $item->uid }}">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                @endif
        </div>
    </div>
</div>
</div>
    <script>
        jQuery(document).ready(function(){
            $(".remove").click(function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "/del_user",
                    type: "post",
                    data: {_token:"{{ csrf_token() }}", id:id},
                    success: function(resp) {
                        window.location.href = "/user";
                    },
                    fail: function(resp) {
                        console.log(resp);
                    }
                });
            });
        });
    </script>
@endsection