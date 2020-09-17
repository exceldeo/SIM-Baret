@extends('dashboard.layouts.master')
@section('title')
User Management
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item active">User Management</a>
    </nav>
</div>
@endsection
@section('main')
<div class="content">
<a class="fa fa-arrow-circle-o-left" style="font-size:30px; padding-left: 40px " href="/"></a>

<style>
    .open-button {
    background-color: #555;
    color: white;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    opacity: 0.8;
    position: fixed;
    bottom: 23px;
    right: 28px;
    width: 280px;
    }

    /* The popup form - hidden by default */
    .form-popup {
    display: none;
    position: fixed;
    bottom: 0;
    right: 15px;
    border: 3px solid #f1f1f1;
    z-index: 9;
    }

    /* Add styles to the form container */
    .form-container {
    max-width: 300px;
    padding: 10px;
    background-color: white;
    }

    /* Full-width input fields */
    .form-container input[type=text], .form-container input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    border: none;
    background: #f1f1f1;
    }

    /* When the inputs get focus, do something */
    .form-container input[type=text]:focus, .form-container input[type=password]:focus {
    background-color: #ddd;
    outline: none;
    }

    /* Set a style for the submit/login button */
    .form-container .btn {
    background-color: #4CAF50;
    color: white;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    width: 100%;
    margin-bottom:10px;
    opacity: 0.8;
    }

    /* Add a red background color to the cancel button */
    .form-container .cancel {
    background-color: red;
    }

    /* Add some hover effects to buttons */
    .form-container .btn:hover, .open-button:hover {
    opacity: 1;
    }

</style>

<button class="btn btn-primary my-3" style="float:right" onclick="openForm()">Tambah Data</button>
<div class="form-popup" id="myForm">
  <form action="/action_page.php" class="form-container">
    <h1>Login</h1>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn">Login</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>

<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>
<!--  -->




<table class="table">
        <thead class="thead" style="color:#0000cc; text-align: center;">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $user as $user) 
            <tr style=" text-align: center;">
                <th>{{ $user->id}}</th>
                <td>{{ $user->nama}}</td>
                <td>{{ $user->email}}</td>
                <td>{{ $user->user_role}}</td>
                <td >
                    <form action="{{$user->id}}/edit" class=" float-left"> 
                    @csrf
                    <button class="btn btn-warning "type="submit" >Edit</button>   
                    </form>
                    <form action="user/{{$user->id}} " class="float-right " method="post"> 
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger "type="submit" >Delete</button>   
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
