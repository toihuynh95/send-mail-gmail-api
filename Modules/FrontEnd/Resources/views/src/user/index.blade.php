@extends('frontend::layouts.master')
@section('title', 'Danh sách tài khoản người dùng')
@section('content')
    <section class="content-header">
        <h1>
            Tài khoản người dùng
            <small>User account</small>
        </h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Danh sách tài khoản người dùng</h3>
            </div>
            <div class="mg-in-datable">
                <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#addUserModal">
                    <i class="fa fa-plus-circle"></i> Thêm mới
                </button>
            </div>
            <div class="box-body">
                <table id="tableUser" class="table table-bordered table-striped" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Biệt danh</th>
                        <th>Tài khoản</th>
                        <th>Loại tài khoản</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
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
                    <h4 class="modal-title">Thêm mới người dùng</h4>
                </div>
                <form id="addUserForm">
                    <div class="modal-body">
                        <div class="form-group required">
                            <label>Email</label>
                            <input type="text" name="user_name" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group required">
                            <label>Tên đầy đủ</label>
                            <input type="text" name="user_full_name" class="form-control" placeholder="Tên đầy đủ">
                        </div>
                        <div class="form-group required">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Mật khẩu">
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="inputGeneratePassword">
                                    Sử dụng mật khẩu ngẫu nhiên từ hệ thống
                                </label>
                            </div>


                        </div>
                        <div class="form-group required">
                            <label>Loại người dùng</label>
                            <select name="user_level" id="inputUserLevel" class="form-control">
                                <option value="1" selected>Nhân viên</option>
                                <option value="0">Khách hàng</option>
                            </select>
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
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnUpdateUser" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-up"></i> Cập nhật</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('/public/js/user/index.js') }}"></script>
@endpush
