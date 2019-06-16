@extends('frontend::layouts.master')
@section('title', 'Danh sách khách hàng')
@section('content')
    <section class="content-header">
        <h1>
            Tổng quan hệ thống
            <small>System overview</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tùy chọn thông tin</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group required">
                                    <label>Chọn dự án</label>
                                    <select id="selectProJect" class="form-control select2 select2-hidden-accessible selectListProject" tabindex="-1" aria-hidden="true"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group required">
                                    <label>Chọn thời gian</label>
                                    <div id="datetimepicker-chart" class="input-group date">
                                        <input id="selectTime" type="text" class="form-control" readonly>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        Chọn đầy đủ thông tin <strong>dự án</strong> và <strong>thời gian</strong> để xem biểu đồ thống kê
                        <button id="btnReport" type="submit" class="btn btn-default pull-right" disabled>
                            <i class="fa fa-cloud-download"></i> Xuất báo cáo
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thống kê chung</h3>
                    </div>
                    <div class="box-body no-padding">
                        <div id="line-chart-project"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thống kê chi tiết</h3>
                    </div>
                    <div class="box-body no-padding">
                        <div id="line-chart-project-detail"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('/public/js/statistic/index.js') }}"></script>
@endpush
