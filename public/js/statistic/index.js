$(document).ready(function() {
    // DateTime Picker
    $('#datetimepicker-chart').datetimepicker({
        // locale: 'vi',
        maxDate: Date.now(),
        format: 'YYYY-MM',
        ignoreReadonly: true
    });
    //

    $('#btnReport').click(function () {
        let statistic_month = moment(new Date($('#selectTime').val())).format('MM');
        let statistic_year = moment(new Date($('#selectTime').val())).format('Y');
        let project_id = $('#selectProJect').val();
        report(project_id, statistic_year, statistic_month);
    });

    $('#selectProJect').change( () => {
        if($('#selectTime').val() && $('#selectProJect').val()){
            let statistic_month = moment(new Date($('#selectTime').val())).format('MM');
            let statistic_year = moment(new Date($('#selectTime').val())).format('Y');
            let project_id = $('#selectProJect').val();
            loadChartProject(project_id, statistic_year, statistic_month);
            loadChartProjectDetail(project_id, statistic_year, statistic_month);
            $('#btnReport').prop('disabled', false);
        }else {
            $('#line-chart-project').html('');
            $('#line-chart-project-detail').html('');
            $('#btnReport').prop('disabled', true);
        }
    });
    $('#datetimepicker-chart').on('dp.change', function(e){
        if($('#selectTime').val() && $('#selectProJect').val()){
            let statistic_month = moment(new Date($('#selectTime').val())).format('MM');
            let statistic_year = moment(new Date($('#selectTime').val())).format('Y');
            let project_id = $('#selectProJect').val();
            loadChartProject(project_id, statistic_year, statistic_month);
            loadChartProjectDetail(project_id, statistic_year, statistic_month);
            $('#btnReport').prop('disabled', false);
        }else {
            $('#line-chart-project').html('');
            $('#line-chart-project-detail').html('');
            $('#btnReport').prop('disabled', true);
        }
    });
    //
    showListProject();
});

function loadChartProject(project_id, statistic_year, statistic_month) {
    $('#line-chart-project').html('');
    $.ajax({
        type: 'POST',
        url: API_VIEW_BY_MONTH_TOTAL,
        data: {statistic_year: statistic_year, statistic_month: statistic_month, project_id: project_id},
        success: function(data, status, xhr) {
            var data = data.data;
            var chart_project = Morris.Line({
                element: 'line-chart-project',
                xkey: 'statistic_day',
                ykeys: ['statistic_value'],
                labels: ['Tổng số email đã gửi'],
                fillOpacity: 0.6,
                hideHover: 'auto',
                behaveLikeLine: true,
                resize: true,
                pointFillColors:['#ffffff'],
                pointStrokeColors: ['black'],
                lineColors:['black'],
                parseTime:false
            });
            chart_project.setData(data);
        }
    });
}

function loadChartProjectDetail(project_id, statistic_year, statistic_month) {
    $('#line-chart-project-detail').html('');
    $.ajax({
        type: 'POST',
        url: API_VIEW_BY_MONTH_DETAIL,
        data: {statistic_year: statistic_year, statistic_month: statistic_month, project_id: project_id},
        success: function(data, status, xhr) {
            var data = data.data;
            var chart_project = Morris.Line({
                element: 'line-chart-project-detail',
                xkey: 'statistic_day',
                ykeys: ['statistic_unsent','statistic_sent','statistic_failure'],
                labels: ['Đang chờ', 'Đã gửi', 'Thất bại'],
                fillOpacity: 0.6,
                hideHover: 'auto',
                behaveLikeLine: true,
                resize: true,
                pointFillColors:['#ffffff'],
                pointStrokeColors: ['#3c8dbc', '#00a65a', '#dd4b39'],
                lineColors:['#3c8dbc', '#00a65a', '#dd4b39'],
                parseTime:false
            });
            chart_project.setData(data);
        }
    });
}

function showListProject() {
    $.ajax({
        type: 'GET',
        url: API_PROJECT_SHOW_LIST,
        success: function(data, status, xhr) {
            if(data.data.length > 0) {
                $('.selectListProject').find('option').remove().end().append('<option value="" selected="selected">Chưa chọn dự án</option>').val('whatever');
                for (const project of data.data) {
                    if(project.project_status == 1){
                        $('.selectListProject').append($("<option></option>").attr("value", project.project_id).text(project.project_name));
                    }else {
                        $('.selectListProject').append($("<option></option>").attr("value", project.project_id).text(project.project_name).attr('disabled', 'disabled'));
                    }
                }
            }
        }
    });
}

function report(project_id, statistic_year, statistic_month) {
    $.ajax({
        type: 'POST',
        url: API_REPORT,
        data: {statistic_year: statistic_year, statistic_month: statistic_month, project_id: project_id},
        success: function(data, status, xhr) {
            window.open(data.data);
        }
    });
}
