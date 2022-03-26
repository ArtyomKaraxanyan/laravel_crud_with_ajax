<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Ajax Validation Example - ItSolutionStuff.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="{{asset("my-project/jquery.min.js")}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

<div class="container">
    <h2> Ajax </h2>

    <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>

    <form>
        {{ csrf_field() }}
        <div class="form-group">
            <label>First Name:</label>
            <input id type="text" name="first_name" class="form-control" placeholder="First Name">
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="last_name" class="form-control" placeholder="Last Name">
        </div>

        <div class="form-group">
            <strong>Email:</strong>
            <input type="text" name="email" class="form-control" placeholder="Email">
        </div>

        <div class="form-group">
            <strong>Address:</strong>
            <textarea class="form-control" name="address" placeholder="Address"></textarea>
        </div>

        <div class="form-group">
            <button class="btn btn-success btn-submit">Submit</button>
        </div>
    </form>
</div>
<div class="edit">
    <form></form>
</div>
<div class="edit-btn">

</div>

    <table style="width:100%">
        <tr>
            <th>first_name</th>
            <th>last_name</th>
            <th>email</th>
            <th>address</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        @foreach($contacts as $contact)
        <tr id="contact">
            <td >{{$contact->first_name}}</td>
            <td >{{$contact->last_name}}</td>
            <td >{{$contact->email}}</td>
            <td>{{$contact->address}}</td>
            <td > <button class="editRecord" data-id="{{ $contact->id }}" data-token="{{ csrf_token() }}">Edit Record</button></td>
            <td > <button class="deleteRecord" data-id="{{ $contact->id }}" data-token="{{ csrf_token() }}">Delete Record</button></td>
        </tr>
        @endforeach


    </table>


<script type="text/javascript">

    $(document).ready(function() {
        $(".editRecord").on('click',function(e){
            e.preventDefault();
            let id = $(this).data("id");
            let _token = $("meta[name='csrf-token']").attr("content");
            let el=this;

            $(".edit").find("form").html('');
            $(".edit").find("form").append('<label>First Name:</label> <input  id="f_name" type="text" name="first_name" class="form-edit" >');
            $(".edit").find("form").append('<label>last Name:</label> <input id="l_name" type="text" name="last_name" class="form-edit" >');
            $(".edit").find("form").append('<label>Email Name:</label> <input id="email" type="text" name="email" class="form-edit" >');
            $(".edit").find("form").append('<label>Address Name:</label> <textarea id="address" type="text" name="address" class="form-edit">');
            $(".edit").find("form").append('<button class="btn btn-success updateRecord">Update</button>');


            $.ajax(
                {
                    url: "my-form/edit/"+id,
                    type:'GET',
                    data:{
                        id:id,
                        _token: _token,

                    },
                    success:function(data){
                        $.each( data, function( key, value ) {
                             $("#f_name").val(value['first_name']);
                             $("#l_name").val(value['last_name']);
                             $("#email").val(value['email']);
                             $("#address").val(value['address']);
                        });


                    }
                }


            );
        });
        $(".updateRecord").on('click',function(e){
            e.preventDefault();
            let id = $(this).data("id");
            let _token = $("meta[name='csrf-token']").attr("content");
            let first_name = $("input[name='first_name']").val();
            let last_name = $("input[name='last_name']").val();
            let email = $("input[name='email']").val();
            let address = $("textarea[name='address']").val();
            $.ajax(
                {
                    url: "my-form/update/"+id,
                    type:'PATCH',
                    data: {_token:_token, id:id ,first_name:first_name, last_name:last_name, email:email, address:address},
                    success: function(data) {
                        if($.isEmptyObject(data.error)){
                            $(".print-error-msg").find("form").remove();
                            $(".print-error-msg").css('display','block').remove();
                            // $(".form-edit").val(null)
                            alert(data.success);
                        }else{
                            printErrorMsg(data.error);
                        }
                    }
                });
        });
        $(".deleteRecord").on('click',function(e){
            e.preventDefault();
            let id = $(this).data("id");
             let _token = $("meta[name='csrf-token']").attr("content");
             let el=this;
            $.ajax(
                {
                    url: "my-form/"+id,
                    type:'DELETE',
                    data:{
                        id:id,
                        _token: _token,

                    },
                    success:function (data){
                        $(el).closest("#contact").remove();
                        alert(data.success)
                    }
                }


                );
        });

        $(".btn-submit").on('click',function(e){
            e.preventDefault();

             let _token = $("input[name='_token']").val();
            let first_name = $("input[name='first_name']").val();
            let last_name = $("input[name='last_name']").val();
            let email = $("input[name='email']").val();
            let address = $("textarea[name='address']").val();

            $.ajax({
                url: "{{ route('my.form') }}",
                type:'POST',
                // dataType: "json",
                // contentType: "application/json; charset=utf-8",
                data: {_token:_token, first_name:first_name, last_name:last_name, email:email, address:address},
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                        $(".print-error-msg").find("ul").remove();
                        $(".print-error-msg").css('display','block').remove();
                        $(".form-control").val(null)
                            alert(data.success);
                    }else{
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    });


</script>


</body>
</html>
