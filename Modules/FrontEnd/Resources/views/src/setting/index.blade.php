@extends('frontend::layouts.master')
@section('title', 'Cài đặt chung')
@section('content')
    <section class="content-header">
        <h1>
            Cài đặt chung
            <small>General settings</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách email mẫu</h3>
                    </div>
                    <div class="mg-in-datable">
                        <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#addTemplateModal">
                            <i class="fa fa-plus-circle"></i> Thêm mới
                        </button>
                    </div>
                    <div class="box-body">
                        <table id="tableTemplate" class="table table-bordered table-striped" width="100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên email mẫu</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#service" data-toggle="tab">Các gói dịch vụ</a></li>
                        <li><a href="#project-type" data-toggle="tab">Danh sách loại dự án</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="service">
                            <div class="box box-solid">
                                <div class="mg-in-datable">
                                    <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#addMailingServiceModal">
                                        <i class="fa fa-plus-circle"></i> Thêm mới
                                    </button>
                                </div>
                                <div class="box-body">
                                    <table id="tableMailingService" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên gói dịch vụ</th>
                                            <th>Số lượng</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="project-type">
                            <div class="box box-solid">
                                <div class="mg-in-datable">
                                    <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#addProjectTypeModal">
                                        <i class="fa fa-plus-circle"></i> Thêm mới
                                    </button>
                                </div>
                                <div class="box-body">
                                    <table id="tableProjectType" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên loại dự án</th>
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

    <!-- Add Template modal -->
    <div id="addTemplateModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm mới email mẫu</h4>
                </div>
                <div class="modal-body">
                    <form id="addTemplateForm">
                        <div class="form-group required">
                            <label>Tên email mẫu</label>
                            <input type="text" name="template_name" class="form-control" placeholder="Tên email mẫu">
                        </div>
                        <div class="form-group required">
                            <label>Nội dung</label>
                            <textarea name="template_content" id="txtAddTemplateContent" class="summernote"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddTemplate" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Thêm mới</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Update Template modal -->
    <div id="updateTemplateModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cập nhật thông tin email mẫu</h4>
                </div>
                <div class="modal-body">
                    <form id="updateTemplateForm">
                        <div class="form-group">
                            <label>Tên email mẫu</label>
                            <input type="text" name="template_name" id="inputTemplateName" class="form-control" placeholder="Tên email mẫu">
                            <input type="hidden" id="inputTemplateID">
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea name="template_content" class="summernote" id="txtUpdateTemplateContent"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnUpdateTemplate" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-up"></i> Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Mailing Service modal -->
    <div id="addMailingServiceModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm gói dịch vụ</h4>
                </div>
                <div class="modal-body">
                    <form id="addMailingServiceForm">
                        <div class="form-group required">
                            <label>Tên gói dịch vụ</label>
                            <input type="text" name="mailing_service_name" class="form-control" placeholder="Tên gói dịch vụ">
                        </div>
                        <div class="form-group required">
                            <label>Số lượng email / tháng</label>
                            <input type="text" name="mailing_service_amount" class="form-control" placeholder="Số lượng email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddMailingService" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Thêm mới</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Mailing Service modal -->
    <div id="updateMailingServiceModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cập nhật thông tin gói dịch vụ</h4>
                </div>
                <div class="modal-body">
                    <form id="updateMailingServiceForm">
                        <div class="form-group">
                            <label>Tên gói dịch vụ</label>
                            <input type="text" name="mailing_service_name" id="inputMailingServiceName" class="form-control" placeholder="Tên gói dịch vụ">
                            <input type="hidden" id="inputMailingServiceID">
                        </div>
                        <div class="form-group">
                            <label>Số lượng email / tháng</label>
                            <input type="text" name="mailing_service_amount" id="inputMailingServiceAmount" class="form-control" placeholder="Số lượng email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnUpdateMailingService" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-up"></i> Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Project Type modal -->
    <div id="addProjectTypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm loại dự án</h4>
                </div>
                <div class="modal-body">
                    <form id="addProjectTypeForm">
                        <div class="form-group required">
                            <label>Tên loại dự án</label>
                            <input type="text" name="project_type_name" class="form-control" placeholder="Tên loại dự án">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddProjectType" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Thêm mới</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Project Type modal -->
    <div id="updateProjectTypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cập nhật thông tin loại dự án</h4>
                </div>
                <div class="modal-body">
                    <form id="updateProjectTypeForm">
                        <div class="form-group">
                            <label>Tên loại dự án</label>
                            <input type="text" name="project_type_name" id="inputProjectTypeName" class="form-control" placeholder="Tên loại dự án">
                            <input type="hidden" id="inputProjectTypeID">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnUpdateProjectType" class="btn bg-purple pull-right"><i class="fa fa-arrow-circle-up"></i> Cập nhật</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('/public/js/setting/index.js') }}"></script>
@endpush
