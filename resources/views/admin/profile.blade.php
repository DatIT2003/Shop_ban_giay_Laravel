<!-- resources/views/admin/profile.blade.php -->

@extends('admin_layout')

@section('admin_content')
    <div class="profile">
        <h2>Thông tin cá nhân của Admin</h2>
        <p><strong>Tên:</strong> {{ $admin_id->STT }}</p>
        <p><strong>Tên:</strong> {{ $admin_name->name }}</p>
        <p><strong>Email:</strong> {{ $admin_email->email }}</p>
        <p><strong>SDT:</strong> {{ $admin_phone->phone }}</p>
        <p><strong>Ngày tạo:</strong> {{ $tbl_admin->created_at }}</p>
        <p><strong>Cập nhật lần cuối:</strong> {{ $tbl_admin->updated_at }}</p>

        <!-- Add more fields as needed -->
    </div>
@endsection
