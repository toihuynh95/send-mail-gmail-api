@extends('frontend::layouts.master')
@section('title', 'Danh sách khách hàng')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách khách hàng
            <small>Customer list</small>
        </h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Danh sách khách hàng</h3>
            </div>
            <div class="box-body">
                <table id="tableCustomer" class="table table-bordered table-striped" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên đầy đủ</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Giới tính</th>
                        <th>Ngày tạo</th>
                    </tr>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('/public/js/customer/index.js') }}"></script>
@endpush
