@extends('frontend::layouts.master')
@section('title', 'Quản lý chiến dịch')
@section('content')
    <section class="content-header">
        <h1>
            Quản lý chiến dịch
            <small>Campaign management</small>
        </h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Danh sách các chiến dịch</h3>
            </div>
            <div class="mg-in-datable">
                <button type="submit" id="btnAddCampaignModal" class="btn btn-default" data-toggle="modal" data-target="#addCampaignModal">
                    <i class="fa fa-plus-circle"></i> Thêm mới
                </button>
                <button type="submit" class="btn btn-default change-color-auto" data-toggle="modal" data-target="#authGoogleModal">
                    <i class="fa fa-google-plus-square"></i> Xác thực tài khoản
                </button>
            </div>
            <div class="box-body">
                <table id="tableCampaign" class="table table-bordered table-striped" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên dự án</th>
                        <th>Tên chiến dịch</th>
                        <th>Email người gửi</th>
                        <th>Tiêu đề</th>
                        <th>Thời gian gửi</th>
                        <th>Thời gian tạo</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>

    <!-- Add Campaign modal -->
    <div id="addCampaignModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tạo mới chiến dịch</h4>
                </div>
                <div class="modal-body">
                    <form id="addCampaignForm">
                        <div class="form-group required">
                            <label>Dự án</label>
                            <select name="project_id" id="selectProJect" class="form-control select2 select2-hidden-accessible selectListProject checkChange" tabindex="-1" aria-hidden="true"></select>
                        </div>
                        <div class="form-group required">
                            <label>Tên chiến dịch</label>
                            <input type="text" name="campaign_name" class="form-control" placeholder="Tên chiến dịch">
                            <input type="hidden" name="campaign_email_id" id="inputCampaignEmailID">
                            <input type="hidden" name="campaign_email_name" id="inputCampaignEmailName">
                        </div>
                        <div class="form-group required">
                            <label>Tiêu đề</label>
                            <input type="text" name="campaign_title" class="form-control" placeholder="Tiêu đề email">
                        </div>
                        <div class="form-group required">
                            <label>Nhóm liên hệ</label>
                            <select name="contact_group_id" id="selectContactGroup" class="form-control select2 select2-hidden-accessible selectListContactGroup checkChange" tabindex="-1" aria-hidden="true">
                            </select>
                        </div>
                        <div class="form-group required">
                            <label>Chọn lịch gửi</label>
                            <div class="input-group date datetimepicker">
                                <input type="text" name="campaign_schedule" class="form-control" readonly>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <mark>Nếu (Thời gian chọn) nhỏ hơn hoặc bằng (Thời gian hiện tại) thì hệ thống sẽ thực hiện ngay lập tức.</mark>
                        </div>
                        <div class="form-group">
                            <label>Mẫu email</label>
                            <select id="selectTemplate" class="form-control select2 select2-hidden-accessible selectListTemplate" tabindex="-1" aria-hidden="true">
                            </select>
                        </div>
                        <div class="form-group required">
                            <label>Nội dung</label>
                            <span class="change-color-auto pull-right"><code>[gender]</code>: Giới tính (Anh, Chị, Anh/Chị) - <code>[name]</code>: Tên (Tuấn Tới)</span>
                            <textarea name="campaign_content" id="txtAddCampaignContent" class="summernote"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddCampaign" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Thêm mới</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Auth Google modal -->
    <div id="authGoogleModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thông báo quan trọng</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <strong>Câu hỏi:</strong> Tại sao bạn nhận được thông báo này?
                        <br><strong>Câu trả lời:</strong> Phiên làm việc đã hết hạn - đồng nghĩa với việc bạn không thể thêm mới chiến dịch, bạn cần phải "Xác thực tài khoản". Hoặc bạn muốn thay đổi tài khoản.
                    </p>
                    <hr>
                    <p>
                        <strong>Hướng dẫn:</strong> Để "Xác thực tài khoản" bạn vui lòng làm theo hướng dẫn sau đây:
                    </p>
                    <ul>
                        <li>
                            <strong>Bước 1:</strong> Nhấn vào nút "Xác thực tài khoản" ở bên dưới.
                        </li>
                        <li>
                            <strong>Bước 2:</strong> Sau đó chọn tài khoản email mà bạn muốn gửi cho chiến dịch này.
                        </li>
                        <li>
                            <strong>Bước 3:</strong> Hoàn thành "Xác thực tài khoản" thì bạn có thể nhấn vào nút thêm mới để tạo chiến dịch.
                        </li>
                    </ul>
                    <hr>
                    <p>
                        <strong>Ghi chú:</strong> Để thay đổi tài khoản, vui lòng xác nhận lại tài khoản như các bước trên.
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="/api/google/auth" class="btn btn-default change-color-auto">
                        <i class="fa fa-google-plus-square"></i> Xác thực tài khoản
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaign Detail modal -->
    <div id="infoCampaignLogModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thông tin chi tiết của chiến dịch</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="progress-group">
                                <span class="progress-text">Chưa gửi</span>
                                <span class="progress-number">
                                    <span id="count_unsent">0</span> / <span class="count_total">0</span>
                                </span>
                                <div class="progress sm active">
                                    <div class="progress-bar progress-bar-primary progress-bar-striped" id="widthUnsent" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="progress-group">
                                <span class="progress-text">Đã gửi</span>
                                <span class="progress-number">
                                    <span id="count_sent">0</span> / <span class="count_total">0</span>
                                </span>
                                <div class="progress sm active">
                                    <div class="progress-bar progress-bar-success progress-bar-striped" id="widthSent" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="progress-group">
                                <span class="progress-text">Thất bại</span>
                                <span class="progress-number">
                                    <span id="count_failure">0</span> / <span class="count_total">0</span>
                                </span>

                                <div class="progress sm active">
                                    <div class="progress-bar progress-bar-danger progress-bar-striped" id="widthFailure" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="tableCampaignLog" class="table table-bordered table-striped" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên liên hệ</th>
                            <th>Email</th>
                            <th>Giới tính</th>
                            <th>Trạng thái</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Read Mail Modal -->
    <div id="readMailModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Nội dung email</h4>
                </div>
                <div class="modal-body">
                    <div class="mailbox-read-info">
                        <h3 id="readTitle"></h3>
                        <h5>Từ: <span id="readFrom"></span>
                            <span id="readTime" class="mailbox-read-time pull-right"></span>
                        </h5>
                    </div>
                    <div id="readContent" class="mailbox-read-message">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('/public/js/campaign/index.js') }}"></script>
@endpush
