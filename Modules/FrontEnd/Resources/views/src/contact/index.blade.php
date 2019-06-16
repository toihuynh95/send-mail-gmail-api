@extends('frontend::layouts.master')
@section('title', 'Quản lý thông tin liên hệ')
@section('content')
    <section class="content-header">
        <h1>
            Quản lý thông tin liên hệ
            <small>Manage contact information</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách nhóm liên hệ</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding" style="">
                        <ul class="nav nav-pills nav-stacked custom-scrollable" id="listGroupContactActive"></ul>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#detail" data-toggle="tab">Danh sách liên hệ trong nhóm</a></li>
                        <li><a href="#contact" data-toggle="tab">Quản lý liên hệ</a></li>
                        <li><a href="#group" data-toggle="tab">Quản lý nhóm liên hệ</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="detail">
                            <div class="box box-solid">
                                <div class="mg-in-datable">
                                    <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#addGroupContactDetailModal">
                                        <i class="fa fa-plus-circle"></i> Thêm mới
                                    </button>
                                </div>
                                <div class="box-body">
                                    <table id="tableContactGroupDetail" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên liên hệ</th>
                                            <th>Email</th>
                                            <th>Giới tính</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="contact">
                            <div class="box box-solid">
                                <div class="mg-in-datable">
                                    <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#addContactModal">
                                        <i class="fa fa-plus-circle"></i> Thêm mới
                                    </button>
                                    <button id="btnExportContact" type="submit" class="btn btn-default">
                                        <i class="fa fa-file-excel-o"></i> Xuất danh sách
                                    </button>
                                </div>
                                <div class="box-body">
                                    <table id="tableContact" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên liên hệ</th>
                                            <th>Email</th>
                                            <th>Giới tính</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="group">
                            <div class="box box-solid">
                                <div class="mg-in-datable">
                                    <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#addGroupContactModal">
                                        <i class="fa fa-plus-circle"></i> Thêm mới
                                    </button>
                                </div>
                                <div class="box-body">
                                    <table id="tableGroup" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên nhóm</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Contact Modal -->
    <div id="addContactModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm thông tin liên hệ mới</h4>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#manual">Thêm thủ công</a></li>
                    <li><a data-toggle="tab" href="#file">Thêm bằng tệp</a></li>
                </ul>
                <div class="tab-content">
                    <div id="manual" class="tab-pane fade in active">
                        <div class="modal-body">
                            <form id="addContactForm">
                                <div class="form-group required">
                                    <label for="name">Tên liên hệ</label>
                                    <input type="text" name="contact_name" class="form-control" placeholder="Tên liên hệ">
                                </div>
                                <div class="form-group required">
                                    <label for="email">Email liên hệ</label>
                                    <input type="text" name="contact_email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group required">
                                    <label for="level">Giới tính</label>
                                    <select name="contact_gender" class="form-control">
                                        <option value="0" selected>Nữ</option>
                                        <option value="1">Nam</option>
                                        <option value="2">Chưa xác định</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nhóm liên hệ</label>
                                    <select name="contact_group_id" class="form-control select2 select2-hidden-accessible selectListContactGroup" tabindex="-1" aria-hidden="true">
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnAddContact" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Thêm mới liên hệ</button>
                        </div>
                    </div>

                    <div id="file" class="tab-pane fade">
                        <div class="modal-body">
                            <form id="importContactForm">
                                <div class="form-group required">
                                    <label>Tệp danh sách liên hệ</label> <strong class="pull-right"><i class="fa fa-arrow-down"></i> <a target="_blank" href="/storage/app/public/example/Template_Example.xlsx">Tải tệp mẫu</a></strong>
                                    <input type="file" name="contact_file" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Nhóm liên hệ</label>
                                    <select name="contact_group_id" class="form-control select2 select2-hidden-accessible selectListContactGroup" tabindex="-1" aria-hidden="true">
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnImportContact" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Thêm mới liên hệ</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Update Contact Modal -->
    <div id="updateContactModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Chỉnh sửa thông tin liên hệ</h4>
                </div>
                <div class="modal-body">
                    <form id="updateContactForm">
                        <div class="form-group">
                            <label for="name">Tên liên hệ</label>
                            <input type="text" name="contact_name" id="inputContactName" class="form-control" placeholder="Tên liên hệ">
                            <input type="hidden" name="contact_id" id="inputContactID">
                        </div>
                        <div class="form-group">
                            <label for="email">Email liên hệ</label>
                            <input type="text" name="contact_email" id="inputContactEmail" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="level">Giới tính</label>
                            <select name="contact_gender" id="inputContactGender" class="form-control">
                                <option value="0" selected>Nữ</option>
                                <option value="1">Nam</option>
                                <option value="2">Chưa xác định</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnUpdateContact" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-up"></i> Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Group Contact Modal -->
    <div id="addGroupContactModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm nhóm mới</h4>
                </div>
                <form id="addGroupContactForm">
                    <div class="modal-body">
                        <div class="form-group required">
                            <label for="user_full_name">Tên nhóm liên hệ</label>
                            <input type="text" name="contact_group_name" class="form-control" placeholder="Tên nhóm liên hệ">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnAddGroupContact" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Group Contact Modal -->
    <div id="updateGroupContactModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Chỉnh sửa thông tin nhóm</h4>
                </div>

                <div class="modal-body">
                    <form id="updateGroupContactForm">
                        <div class="form-group">
                            <label>Tên nhóm liên hệ</label>
                            <input type="text" name="contact_group_name" id="inputContactGroupName" class="form-control" placeholder="Tên nhóm liên hệ">
                            <input type="hidden" id="inputContactGroupID">
                        </div>
                        <div class="form-group">
                            <label>Tình trạng</label>
                            <select name="contact_group_status" id="inputContactGroupStatus" class="form-control">
                                <option value="1" selected>Hiện</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnUpdateGroupContact" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-up"></i> Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Group Contact Detail Modal -->
    <div id="addGroupContactDetailModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm liên hệ vào nhóm</h4>
                </div>
                <input type="hidden" id="inputContactGroupIDCheck">
                <div class="modal-body">
                    <table id="tableContactAllDatatable" class="table table-bordered table-striped" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên liên hệ</th>
                            <th>Email</th>
                            <th>Giới tính</th>
                            <th>Hành động</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('/public/js/contact/index.js') }}"></script>
@endpush
