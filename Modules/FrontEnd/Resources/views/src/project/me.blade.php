@extends('frontend::layouts.master')
@section('title', 'Thông tin dự án')
@section('content')
    <section class="content-header">
        <h1>
            Thông tin dự án
            <small>Project information</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách các dự án</h3>
                    </div>
                    <div class="box-body">
                        <table id="tableProject" class="table table-bordered table-striped" width="100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên dự án</th>
                                <th>Mã hợp đồng</th>
                                <th>Loại dự án</th>
                                <th>Gói dịch vụ</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script src="{{ asset('/public/js/project/me.js') }}"></script>
@endpush
