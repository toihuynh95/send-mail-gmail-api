$(document).ready(function() {
    showListCustomer();
});

let table_customer = $('#tableCustomer');

function showListCustomer() {
    table_customer.DataTable({
        ajax: {
            method: "GET",
            url: API_CUSTOMER_SHOW
        },
        order: [[ 0, "desc" ]],
        columns: [
            {
                data: 'customer_id',
                name: 'customer_id'
            },
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'customer_email',
                name: 'customer_email'
            },
            {
                data: 'customer_phone',
                name: 'customer_phone'
            },
            {
                data: 'customer_gender',
                name: 'customer_gender',
                render: function ( data, type, columns, meta ) {
                    let customer_gender = '';
                    if(data == 1){
                        customer_gender = '<span class="btn btn-xs bg-olive">Nam</span>';
                    }else if(data == 0){
                        customer_gender = '<span class="btn btn-xs bg-maroon">Nữ</span>';
                    }else {
                        customer_gender = '<span class="btn btn-xs bg-purple">Chưa xác định</span>';
                    }
                    return customer_gender;
                }
            },
            {
                data: 'customer_created_at',
                name: 'customer_created_at'
            }
        ]
    });
}
