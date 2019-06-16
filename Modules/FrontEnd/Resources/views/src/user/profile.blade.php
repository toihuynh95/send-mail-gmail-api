@extends('frontend::layouts.master')
@section('title', 'Thông tin cá nhân')
@push('style')
    <style>
    </style>
@endpush
@section('content')
    <section class="content-header">
        <h1>
            Thông tin cá nhân
            <small>Profile</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-5">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin chi tiết</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <form id="updateAvatar">
                                    <div class="form-group">
                                        <img alt="User Pic" src="{{asset('public/vendor/adminlte/dist/img/my-account-icon.jpg')}}" id="avatar-profile" class="profile-user-img img-responsive img-circle avatar">
                                    </div>
                                    <div class="form-group">
                                        <label for="profile-image" class="btn btn-block btn-sm bg-purple"><i class="fa fa-cloud-upload"></i>&nbsp; Chọn ảnh...</label>
                                        <input class="form-control hidden" name="user_avatar" id="profile-image" type="file">
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-8">
                                <h3 class="profile-username text-center profileName"></h3>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>Email:</b> <a class="pull-right userName"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Loại tài khoản: </b> <a class="pull-right userLevel"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab">Cài đặt tài khoản</a></li>
                        <li><a href="#info" id="tabProfileInfo" data-toggle="tab">Thông tin cá nhân</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <h2 class="page-header">Thay đổi biệt danh</h2>
                            <form id="updateProfile" class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="email" disabled class="form-control" id="inputProfileEmail">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="user_full_name" id="inputProfileName" placeholder="Tên đầy đủ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="button" id="btnUpdateProfile" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-up"></i> Cập nhật thông tin</button>
                                    </div>
                                </div>
                            </form>

                            <h2 class="page-header">Đổi mật khẩu</h2>
                            <form id="resetPassword" class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" name="current_password" placeholder="Nhập mật khẩu hiện tại">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu mới">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Nhập lại mật khẩu mới">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="button" id="btnResetPassword" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-up"></i> Cập nhật mật khẩu</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="info">
                            <form id="updatePersonalInfo" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Họ và tên</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" disabled id="inputCustomerName">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" disabled id="inputCustomerEmail">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Điện thoại</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="customer_phone" id="inputCustomerPhone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Địa chỉ</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="customer_address" id="inputCustomerAddress">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Giới tính</label>
                                    <div class="col-sm-10">
                                        <select name="customer_gender" id="inputCustomerGender" class="form-control">
                                            <option value="0">Nữ</option>
                                            <option value="1">Nam</option>
                                            <option value="2" selected="">Chưa xác định</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="button" id="btnUpdatePersonalInfo" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-up"></i> Cập nhật thông tin</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('/public/js/user/profile.js') }}"></script>
@endpush
