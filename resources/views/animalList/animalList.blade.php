@extends('base')

@section('content')
<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Animal Lover Animal List</a>
        </div>

    </div>
</nav>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">Animal List</h4>
                    <p class="category">Pleae animal</p>
                </div>
                <div class="card-content table-responsive">
                    <table class="table">
                        <thead class="text-danger">
                            <th width="10%">ID</th>
                            <th width="10%">Type</th>
                            <th width="20%">Sex</th>
                            <th width="20%">Picture</th>
                            <th width="20%">Submit Date</th>
                            <th width="10%"></th>
                            <th width="10%"></th>
                        </thead>
                        <tbody>
                            <?php $count = 0;
                                foreach ($list as $item){
                                    ?>
                                <tr>
                                    <td><?= $count+1; $count++;?></td>
                                    <td><?= $item->kind?></td>
                                    <td><?php if($item->gender == 0) echo "Male"; else echo "Female"; ?></td>
                                    <td><img src="{{ asset('/uploads/')}}<?php echo "/".$item->photo_url; ?>" style="width: 50px;height: 50px" alt="image"/></td>
                                    <td><?= $item->updated_at?></td>
                                    <td><button type="button" rel="tooltip" title="Edit Task" class="edit btn btn-primary btn-simple btn-xs" data-count="<?= $count-1; ?>" data-id="{{ $item->aid }}">
                                            <i class="material-icons">edit</i>
                                        </button></td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Remove" class="remove btn btn-danger btn-simple btn-xs" data-id="{{ $item->aid }}">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

    <script  type="text/javascript">
        var url="";
        jQuery(document).ready(function(){
            $(".edit").click(function(){
                var id = $(this).attr('data-count');
                var list = <?php echo json_encode($list); ?>;
                $("#name").val(list[id]['name']);
                $("#cid").val(list[id]['cid']);
                $("#gender").val(list[id]['gender']);
                $("#age").val(list[id]['age']);
                $("#color").val(list[id]['color']);
                $("#size").val(list[id]['size']);
                $("#status").val(list[id]['status']);
                $("#infoNe").val(list[id]['infoNe']);
                $("#infoPa").val(list[id]['infoPa']);
                $("#infoEn").val(list[id]['infoEn']);
                $("#aid").val(list[id]['aid']);
                $("#photo").attr("src","{{ asset('/uploads/')}}"+"/"+list[id]['photo_url']);
                $("#photo1").attr("value",list[id]['photo_url']);
                $("#myModal").modal('show');

            });

            $(".remove").click(function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "/del_user",
                    type: "post",
                    data: {_token:"{{ csrf_token() }}", id:id},
                    success: function(resp) {
                        window.location.href = "/animalList";
                    },
                    fail: function(resp) {
                        console.log(resp);
                    }
                });
            });
        });
    </script>

@endsection