@extends('dashboard.layouts.master')
@section('title')
User Management
@endsection
@section('breadcrumb')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a href="{{route('dashboard.index')}}" class="breadcrumb-item active">User Management- edit</a>
    </nav>
</div>
@endsection
@section('main')
<div class="content">
<a class="fa fa-arrow-circle-o-left" style="font-size:24px;" href="/"></a>
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
                    <a href="" class="badge badge-success">Edit</a>
                    <a href="" class="badge badge-danger">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
