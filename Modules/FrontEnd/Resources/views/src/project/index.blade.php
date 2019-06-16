@extends('frontend::layouts.master')
@section('title', 'Quản lý dự án')
@section('content')
    <section class="content-header">
        <h1>
            Quản lý dự án
            <small>Project management</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách các dự án</h3>
                    </div>
                    <div class="mg-in-datable">
                        <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#addProjectModal">
                            <i class="fa fa-plus-circle"></i> Thêm mới
                        </button>
                    </div>
                    <div class="box-body">
                        <table id="tableProject" class="table table-bordered table-striped" width="100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên dự án</th>
                                <th>Người sở hữu</th>
                                <th>Mã hợp đồng</th>
                                <th>Loại dự án</th>
                                <th>Gói dịch vụ</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Project modal -->
    <div id="addProjectModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm mới thông tin dự án</h4>
                </div>
                <div class="modal-body">
                    <form id="addProjectForm">
                        <div class="form-group required">
                            <label>Chọn người sở hữu</label>
                            <select name="customer_id" class="form-control select2 select2-hidden-accessible selectListCustomer" tabindex="-1" aria-hidden="true">
                            </select>
                        </div>
                        <div class="form-group required">
                            <label>Mã hợp đồng</label>
                            <input type="text" name="contract_code" class="form-control" placeholder="Mã hợp đồng">
                        </div>
                        <div class="form-group required">
                            <label>Tên dự án</label>
                            <input type="text" name="project_name" class="form-control" placeholder="Tên dự án">
                        </div>
                        <div class="form-group required">
                            <label>Loại dự án</label>
                            <select name="project_type_id" class="form-control select2 select2-hidden-accessible selectListProjectType" tabindex="-1" aria-hidden="true"></select>
                        </div>
                        <div class="form-group required">
                            <label>Gói dịch vụ</label>
                            <select name="mailing_service_id" class="form-control select2 select2-hidden-accessible selectListMailingService" tabindex="-1" aria-hidden="true">
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddProject" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Thêm mới</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Update Project modal -->
    <div id="updateProjectModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cập nhật thông tin dự án</h4>
                </div>
                <div class="modal-body">
                    <form id="updateProjectForm">
                        <div class="form-group">
                            <label>Người sở hữu dự án (khách hàng)</label>
                            <select disabled="disabled" id="inputCustomer" class="form-control select2 select2-hidden-accessible selectListCustomer" tabindex="-1" aria-hidden="true">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mã hợp đồng</label>
                            <input type="text" name="contract_code" disabled="disabled" id="inputContractCode" class="form-control" placeholder="Mã hợp đồng">
                            <input type="hidden" id="inputProjectID">
                        </div>
                        <div class="form-group">
                            <label>Tên dự án</label>
                            <input type="text" name="project_name" id="inputProjectName" class="form-control" placeholder="Tên dự án">
                        </div>
                        <div class="form-group">
                            <label>Loại dự án</label>
                            <select name="project_type_id" id="inputProjectTypeID" class="form-control select2 select2-hidden-accessible selectListProjectType" tabindex="-1" aria-hidden="true">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Gói dịch vụ</label>
                            <select name="mailing_service_id" id="inputProjectMailingServiceID" class="form-control select2 select2-hidden-accessible selectListMailingService" tabindex="-1" aria-hidden="true">
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnUpdateProject" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-up"></i> Cập nhật</button>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('/public/js/project/index.js') }}"></script>
@endpush
