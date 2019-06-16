<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: DejaVu Sans !important;
        }
        .information {
            margin: 15px;
            line-height: 16px;
            font-size: 13px;
            width: 100%;
        }
        .footer {
            background-color: #dd4b39;
            color: #FFF;
            width: 100%;
            font-size: 13px;
            margin-top: 10px;
        }
        .footer table {
            padding: 5px;
        }
        td, th{padding: 10px 5px;}
    </style>
</head>
<body>
<div class="information">
    <div style="float: left;">
        <p>
            <strong>Email Marketing Company</strong> <br/>
            <strong>Địa chỉ:</strong> 123 Lê Trọng Tấn, Sơn Kỳ, Tân Phú, TP.HCM <br/>
            <strong>Điện thoại:</strong> (+84) 904 420 410
        </p>
    </div>
    <div style="float: right">
        <img style="width: 70px" src="https://cdn.iconscout.com/icon/free/png-256/email-mail-verify-verified-inbox-true-right-18038.png">
    </div>
</div>
<div class="information">
    <div style="text-align: center; padding-top: 100px;">
        <h1>BÁO CÁO THÔNG TIN DỰ ÁN</h1>
    </div>
</div>
<table cellspacing="0" class="information">
    <thead style="background-color: lightgray;">
    <tr>
        <th>#</th>
        <th>Thông tin chi tiết</th>
        <th>Số lượng</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">1</th>
        <td>Tổng số email đang chờ gửi</td>
        <td align="right">{{$data['statistic_unsent']}}</td>
    </tr>
    <tr>
        <th scope="row">2</th>
        <td>Tổng số email đã gửi</td>
        <td align="right">{{$data['statistic_sent']}}</td>
    </tr>
    <tr>
        <th scope="row">3</th>
        <td>Tổng số email gửi thất bại</td>
        <td align="right">{{$data['statistic_failure']}}</td>
    </tr>
    <tr>
        <th scope="row"></th>
        <th>Tổng số email đã sử dụng</th>
        <th align="right">{{$data['statistic_value']}} / {{$data['mailing_service_amount']}}</th>
    </tr>
    </tbody>
</table>
<div class="information">
    <div style="float: right">
        <p>
            <strong>Tên dự án:</strong> {{$data['project_name']}}<br>
            <strong>Gói dịch vụ:</strong> <span>{{$data['mailing_service_name']}} ( {{$data['mailing_service_amount']}} )</span><br/>
            <strong>Ngày tạo:</strong> {{$data['project_created_at']}}<br/>
            <strong>Thời gian:</strong> {{$data['time_start']}} - {{$data['time_end']}}
        </p>
    </div>
</div>
<div class="footer" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                <strong>Copyright &copy; {{ date('Y') }} Email Marketing.</strong>
            </td>
            <td align="right" style="width: 50%;">
                <strong>EMK:</strong> "Nói được, làm được"
            </td>
        </tr>

    </table>
</div>
</body>
</html>
