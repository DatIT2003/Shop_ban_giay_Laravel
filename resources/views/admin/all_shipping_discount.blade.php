@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt Kê Mã Code Giảm Giá Phí ship
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-4">
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-4">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <?php
        use Illuminate\Support\Facades\Session;
        $message = Session::get('message');
        if ($message) {
            echo '<span class="text-alert">'.$message.'</span>';
            Session::put('message', null);
        }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên Mã Giảm Giá Phí Ship</th>
            <th>Mã Code Phí ship</th>
            <th>Giảm Giá</th>
            <th>Loại</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_discount_codes as $key => $discount_code)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{ $discount_code->name }}</td>
            <td>{{ $discount_code->code }}</td>
            <td>{{ number_format($discount_code->discount_amount) }}</td>
            <td>{{ $discount_code->discount_type }}</td>
            <td>
              <a href="{{URL::to('/edit-shipping-discount/'.$discount_code->id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn Có Chắc Là Muốn Xóa Mã Giảm Giá Phí Ship Này Không?')" href="{{URL::to('/delete-shipping-discount/'.$discount_code->id)}}" class="active styling-delete" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
