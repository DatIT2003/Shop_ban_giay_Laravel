@extends('admin_layout')
@section('admin_content')

<div class="panel panel-default">
    <div class="panel-heading">
        Phản Hồi Bình Luận
    </div>
    <div class="panel-body">
        <form action="{{ route('admin.contact.sendReply', $contact->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" value="{{ $contact->email }}" disabled>
            </div>
            <div class="form-group">
                <label>Message:</label>
                <textarea class="form-control" rows="5" disabled>{{ $contact->message }}</textarea>
            </div>
            <div class="form-group">
                <label>Reply:</label>
                <textarea name="reply" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi Phản Hồi</button>
        </form>
    </div>
</div>

@endsection
