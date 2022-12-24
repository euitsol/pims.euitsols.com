function get_month_name(monthNumber) {
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December'];
    return months[monthNumber - 1];
}

//Parameters: It receive 9 parameter but only three parameters are compulsory
//uses:ajaxDataFetch('MoreProduct',{'product_id':product_id}, ['created_user', 'updated_user','deleted_user', 'supplier','cat','cat.subcat','cat.subcat.product'],function(response){console.log(response);},append_selector,null,'supplier',null,'shop_name');
//explanation:1.Model name(type = string),2. tables field name and their value(your condition in where clause)(type = object) 3.relationship in with(type = object)
//4. calback function.you get one parameter which is ajax response 5.a element(select element) where you want to append ajax response,6.old value,if you want to keep data selected when validation error back, 7.belongsTo function name, 8.hasMany function name,
// 9.colum name which you wanto show in append selector
function ajaxDataFetch(model,data_obj,  with_arr, returnFunc = null, append_selector = null, old_value =
    null, belongs_to, has_many = null, coloum = 'name') {

    $.ajax({
        url: "{{ route('asset.product_fetch.ajax') }}",
        method: 'GET',
        async: false,
        data: {
            'arr': data_obj,
            'model': model,
            'with_arr': with_arr,
        },
        success: function(response) {
            if (returnFunc) {
                returnFunc(response)
            }
            let option = "<option value='' hidden>Select...</option>";
            if (response) {
                if (append_selector) {
                    $.each(response, function(index, value) {
                        if (value[has_many]) {
                            $.each(value[has_many], function(has_index, has_value) {
                                if (has_value[belongs_to]) {
                                    option +=
                                        `<option value="${has_value[belongs_to].id}" ${old_value == has_value[belongs_to].id ? 'selected' : ''}>${has_value[belongs_to][coloum]}</option>`;
                                } else {
                                    option +=
                                        `<option value="${has_value.id}" ${old_value == has_value.id ? 'selected' : ''}>${has_value[coloum]}</option>`;
                                }
                            });
                        } else if (value[belongs_to]) {
                            if (value[belongs_to][has_many]) {
                                $.each(value[belongs_to][has_many], function(belongs_index,
                                    belongs_value) {
                                    option +=
                                        `<option value="${belongs_value.id}" ${old_value == belongs_value.id ? 'selected' : ''}>${belongs_value[coloum]}</option>`;
                                });
                            } else {
                                option +=
                                    `<option value="${value[belongs_to].id}" ${old_value == value[belongs_to].id ? 'selected' : ''}>${value[belongs_to][coloum]}</option>`;
                            }
                        } else {
                            option +=
                                `<option value="${value.id}" ${old_value == value.id ? 'selected' : ''}>${value[coloum]}</option>`;
                        }
                    });
                    append_selector.html(option);
                }

            } else {
                console.error('Please fill up all argument carefully');
            }
        }
    });
}
