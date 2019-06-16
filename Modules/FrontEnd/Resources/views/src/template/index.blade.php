@extends('frontend::layouts.master')
@section('title', 'Danh sách nội dung mẫu')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách nội dung mẫu
            <small>Template list</small>
        </h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Danh sách nội dung mẫu</h3>
            </div>
            <div class="mg-in-datable">
                <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#addUserModal">
                    <i class="fa fa-plus-circle"></i> Thêm nội dung
                </button>
            </div>
            <div class="box-body">
                <table id="tableUser" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>chủ đề</th>
                        <th>nội dung</th>
                        <th>Hoạt động</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1 </td>
                        <td> Quang cao san pham  </td>
                        <td> <textarea>Xin gioi thieu...... xin cam on</textarea></td>
                        <td><button class="btn btn-xs bg-info">Sử dụng</button> <button class="btn btn-xs btn-info">Sửa</button> <button class="btn btn-xs btn-danger">Xóa</button></td>
                    </tr>
                    <tr>
                        <td>2 </td>
                        <td> Thu moi </td>
                        <td> <textarea>Xin tran trong...... xin cam on</textarea></td>
                        <td><button class="btn btn-xs bg-info">Sử dụng</button> <button class="btn btn-xs btn-info">Sửa</button> <button class="btn btn-xs btn-danger">Xóa</button></td>
                    </tr>
                    <tr>
                        <td>3 </td>
                        <td> Thiep chuc mung  </td>
                        <td> <textarea>Xin chuc mung...... xin cam on</textarea></td>
                        <td><button class="btn btn-xs bg-info">Sử dụng</button> <button class="btn btn-xs btn-info">Sửa</button> <button class="btn btn-xs btn-danger">Xóa</button></td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Add modal -->
    <div id="addUserModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm mới nội dung mẫu</h4>
                </div>
                <form id="addUserForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">Tiêu đề</label>
                            <input type="text" name="template_name" class="form-control" placeholder="Tiêu đề">

                        </div>
                        <div class="form-group">
                            <label for="email">Nội dung</label>

                            <textarea name="template_content" id="demo-editor-bootstrap" cols="91" rows="10" placeholder="content"></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnAddUser" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Thêm mới</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Update modal -->
    <div id="updateUserModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cập nhật thông tin người dùng</h4>
                </div>
                <form id="updateUserForm">
                    <div class="modal-body">
                        <input type="hidden" id="user_id">
                        <input type="hidden" name="_method" value="put">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="user_name" id="user_name" disabled class="form-control" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="level">Loại người dùng</label>
                            <select name="user_level" id="user_level" class="form-control">
                                <option value="0" selected>Khách hàng</option>
                                <option value="1">Quản trị viên</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnUpdateUser" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-down"></i> Cập nhật</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('/public/js/user/index.js') }}"></script>


@endpush
