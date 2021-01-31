@extends('layouts.list')
@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Product List</div>

                <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" value="" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="search">&nbsp;</label>
                        <button type="text" class="form-control btn btn-primary" id="search" name="search"  value=""  >Search</button>
                    </div>
                    <div class="col-md-2">
                        <label for="clear">&nbsp;</label>
                        <button type="text" class="form-control btn btn-danger" id="clear" name="clear"  value=""  >Clear</button>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success" role="alert" id="list-msg" style="display:none;"></div>
                            <div class="alert alert-danger" role="alert" id="list-err-msg" style="display:none;"></div>
                            
                            <div class="col-4 offset-md-8 text-right">
                                <a href="javascript:void(0)" class="btn btn-primary add" >New Product</a>
                            </div><br>
                            
                            <table class="table" id="productTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col-md-8 -->

        <!-- Start Show User-->
        <div class="modal fade" id="ajax-show-crud-modal" tabindex="-1" aria-labelledby="userShowModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userShowModal"></h5>     
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <tbody>
                                        <tr><th scope="row">ID</th><td id="shid"></td></tr>
                                        <tr><th scope="row">Name</th><td id="shname"></td></tr>
                                        <tr><th scope="row">Price</th><td id="shprice"></td></tr>

                                        <tr><th scope="row" colspan="2">Description</th></tr>
                                        <tr><td id="shdesc" colspan="2">                                            
                                        </td></tr>

                                        <tr><th scope="row" colspan="2">Images</th></tr>
                                        <tr><td id="shimages">
                                            <img src="" style="width: 60px; height: 60px; border-radius: 50%;" >
                                        </td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="" class="btn btn-secondary mclose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Show User-->

        <!-- Add Product-->
        <div class="modal fade" id="ajax-add-crud-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="productAddModalTitle"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert" id="addProductError" style="display:none;"></div>
                        <form id="addProductForm" name="addProductForm" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="product_name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" id="product_name" class="form-control" name="product_name" value="" required autofocus>
                                    <span id="product_nameError" class="alert-message" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="product_price">Price</label>
                                <div class="col-sm-12">
                                    <input type="text" id="product_price" class="form-control" name="product_price" value="" required>
                                    <span id="product_priceError" class="alert-message" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="product_desccription">Description</label>
                                <div class="col-sm-12">
                                    <textarea rows="3" cols="" class="form-control" id="product_desccription" name="product_desccription"></textarea>
                                    <span id="product_desccriptionError" class="alert-message" style="color:red;"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6 control-label" for="product_image">Images</label>
                                <div class="col-sm-12">
                                    <input id="product_image" type="file" class="form-control" name="product_image[]" multiple required >
                                    <span id="product_imageError" class="alert-message" style="color:red;"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" value="create">Save</button>
                        <button type="button" class="btn btn-info" id="btn-clear" value="clear">Clear</button>
                        <button type="button" class="btn btn-secondary mclose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Product-->

        <!-- Edit Product-->
        <div class="modal fade" id="ajax-edit-crud-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="productEditModalTitle"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert" id="editProductError" style="display:none;"></div>
                        <div class="alert alert-success" role="alert" id="editProductSuccess" style="display:none;"></div>
                        <form id="editProductForm" name="editProductForm" class="form-horizontal" method="post">
                            <input type="hidden" name="product_id" id="product_id" value="">
                            @method('PUT')
                            <div class="form-group">
                                <label for="edproduct_name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" id="edproduct_name" class="form-control" name="product_name" value="" required autofocus>
                                    <span id="edproduct_nameError" class="alert-message" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="edproduct_price">Price</label>
                                <div class="col-sm-12">
                                    <input type="text" id="edproduct_price" class="form-control" name="product_price" value="" required>
                                    <span id="edproduct_priceError" class="alert-message" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="edproduct_desccription">Description</label>
                                <div class="col-sm-12">
                                    <textarea rows="3" cols="" class="form-control" id="edproduct_desccription" name="product_desccription"></textarea>
                                    <span id="edproduct_desccriptionError" class="alert-message" style="color:red;"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6 control-label" for="edproduct_image">Images</label>
                                <div class="col-sm-12">
                                    <input id="edproduct_image" type="file" class="form-control" name="product_image[]" multiple required >
                                    <span id="edproduct_imageError" class="alert-message" style="color:red;"></span>
                                </div>
                            </div>

                            <div class="form-group" >
                                <div class="row" id="imgopr">
                                    
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-update" value="update">Update</button>
                        <button type="button" class="btn btn-secondary mclose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Router-->

    </div>
</div>
<script>
    
    function load_data(){
        var product_name = $("#product_name").val();
        var table = $('#productTable').DataTable({
            processing: true,
            serverSide: true,
            ajax:{ 
                url:"{{ route('products.index') }}",
                data:{product_name:product_name}
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'product_name', name: 'product_name'},
                {data: 'product_price', name: 'product_price'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }

    //Load Listing
    load_data();

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $("#search").click(function(){
            $('#productTable').DataTable().destroy();
            load_data();
        });

        $("#clear").click(function(){
            $('#name').val('');
            $('#productTable').DataTable().destroy();
            load_data();
        });

        $("#productTable").on("click", ".show", function(event) {            
            event.preventDefault();
            $('#userShowModal').html("Product Details");
            var action = $(this).attr('action');
            
            $.ajax({
                type : 'GET',
                url  : action,
                aysnc: true,
                success:function(resp){
                    if(resp.data != ""){
                        var data = resp.data;
                        $('#shid').html(data.id);
                        $('#shname').html(data.product_name);
                        $('#shprice').html(data.product_price);
                        $('#shdesc').html(data.product_desccription);

                        var images = "";
                        if(data.images != ""){
                            $.each(data.images, function( index, value ) {
                                images +='<img src="'+value+'" style="width: 70px; height: 70px;" >';
                            });
                        }
                        $('#shimages').html(images);

                        $('#ajax-show-crud-modal').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        
                    }
                }
            });
        });

        $(".add").click(function(){
            //clear validation mesage and form field
            $('#addProductForm').trigger("reset");
            $(".alert-message").html("");
              
            $('#productAddModalTitle').html("Add New Product");
            $('#ajax-add-crud-modal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        
        $("#btn-save").click(function(){
            if ($("#addProductForm").length > 0) {
                var form_data = new FormData($("#addProductForm")[0]);            
                $.ajax({
                    data: form_data, //$('#addProductForm').serialize(),
                    url: "{{ route('products.store') }}",
                    type: "POST",
                    dataType: 'json',
                    cache:true,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#btn-save').html('Saving..');
                        $("#addProductError").html('').hide();
                        $('#list-err-msg').html('').hide();
                    },
                    success: function (resp) {
                        var data = resp.data;
                        
                        if(resp.status === true){
                            $('#btn-save').html('Saved');
                            $('#addProductForm').trigger("reset");
                            $('#ajax-add-crud-modal').modal('hide');
                            $('#list-msg').show().html(resp.message);

                            $('#productTable').DataTable().destroy();
                            load_data();
                        }else{
                            $("#addProductError").show().html(resp.message);
                        }
                    
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Save');
                        $(".alert-message").html("");
                        $('#list-msg').html("").hide();
                        $('#product_nameError').text(data.responseJSON.errors.product_name);
                        $('#product_priceError').text(data.responseJSON.errors.product_price);
                        $('#product_desccriptionError').text(data.responseJSON.errors.product_desccription);
                        $('#product_imageError').text(data.responseJSON.errors.product_image);
                    }
                });
            }
        });

        $("#productTable").on("click", ".edit", function(event) {            
            event.preventDefault();
            $(".alert-message").html("");
            $("#editProductError").html('').hide();
            $('#productEditModalTitle').html("Edit User");
            var action = $(this).attr('action');
            
            $.ajax({
                type : 'GET',
                url  : action,
                aysnc:true,
                success:function(resp){
                    if(resp.data != ""){
                        var data = resp.data;
                        $("#product_id").val(data.id);
                        $('#edproduct_name').val(data.product_name);
                        $('#edproduct_price').val(data.product_price);
                        $('#edproduct_desccription').val(data.product_desccription);
                        var imgstr = data.product_image;
                        imgarr = imgstr.split(",");

                        var images = "";
                        if(data.images != ""){
                            $.each(data.images, function( index, value ) {
                               //console.log(data.imgact);
                                images +='<div class="col-sm-2"><img alt="'+imgarr[index]+'" src="'+value+'" style="width: 70px; height: 70px;" ><button type="button" class="btn btn-danger btn-sm imgdelete" action="'+data.imgact[index]+'">X</button></div>';
                            });
                        }
                        $('#imgopr').html(images);                        
                        $('#btn-update').html('Update');

                        //Open modal
                        $('#ajax-edit-crud-modal').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        
                    }
                }
            });
        });

        $("#btn-update").click(function(){
            if ($("#editProductForm").length > 0) {
                var product_id = $("#product_id").val();
                if(product_id > 0 && product_id != ''){
                    var form_data = new FormData($("#editProductForm")[0]);
                    $.ajax({
                        data: form_data, //$('#editProductForm').serialize(),
                        url: "products/"+product_id,
                        type: "POST",
                        dataType: 'json',
                        cache:true,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('#btn-update').html('Updating..');
                            $("#editProductError").html('').hide();
                            $('#list-err-msg').html('').hide();
                        },
                        success: function (resp) {
                            var data = resp.data;
                            
                            if(resp.status === true){
                                $('#btn-update').html('Updated');
                                $('#editProductForm').trigger("reset");
                                $('#ajax-edit-crud-modal').modal('hide');
                                $('#list-msg').show().html(resp.message);

                                $('#productTable').DataTable().destroy();
                                load_data();
                            }else{
                                $("#editProductError").show().html(resp.message);
                                $('#btn-update').html('Update');
                            }
                        
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            $('#btn-update').html('Update');
                            $(".alert-message").html("");
                            $('#list-msg').html("").hide();
                            $('#edproduct_nameError').text(data.responseJSON.errors.product_name);
                            $('#edproduct_priceError').text(data.responseJSON.errors.product_price);
                            $('#edproduct_desccriptionError').text(data.responseJSON.errors.product_desccription);
                        }
                    });
                }
            }
        });

        //$(".imgdelete").click(function(){
        $("#ajax-edit-crud-modal").on("click", ".imgdelete", function(event) {
            var idaction = $(this).attr('action');
            var altstr = $(this).siblings("img").attr('alt');
            var thisparent = $(this).parent();
            console.log(thisparent);
            console.log(altstr);
            $.ajax({
                url: idaction,
                type: 'POST',
                data:{'altstr':altstr },
                dataType: 'json',
                beforeSend: function() {
                    $("#editProductError").html('').hide();
                    $("#editProductSuccess").html('').hide();                    
                },
                success: function (resp){
                    if(resp != ''){
                        if(resp.status === true){
                            console.log($(this).parent());
                            thisparent.remove();
                            $("#editProductSuccess").show().html(resp.message);
                        }else{
                            $("#editProductError").show().html(resp.message);
                        }
                    }
                },
                error: function(resp){
                    console.log("Error");
                    $("#editProductError").html('').hide();
                    $("#editProductSuccess").html('').hide();
                }
            });
        });
        

        $("#productTable").on("click", ".delete", function(event) {
            var dc = confirm("Are you sure? You want to delete product?");
            if (dc == true) {
                var daction = $(this).attr("action");
                $.ajax({
                    url: daction,
                    type: 'DELETE',
                    dataType: 'json',
                    beforeSend: function() {
                        $('#list-msg').html('').hide();
                        $('#list-err-msg').html('').hide();
                    },
                    success: function (resp){
                        if(resp != ''){
                            if(resp.status === true){
                                $('#list-msg').show().html(resp.message);
                                $('#productTable').DataTable().destroy();
                                load_data();
                            }else{
                                $('#list-err-msg').show().html(resp.message);
                            }
                        }
                    },
                    error: function(resp){
                        $('#list-err-msg').html('').hide();
                        $('#list-msg').html('').hide();
                    }
                });
            }
        });
        
        //close modal
        $(".mclose").click(function(){
            $(this).closest('.modal').modal('hide');
        });

        //clear form
        $("#btn-clear").click(function(){
            $('#addProductForm')[0].reset();
        });
        
    });
</script>
@endsection
