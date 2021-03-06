"use strict";
// Class definition

var KTDatatableLocalSortDemo = function () {
    // Private functions
    var messages = {
        'ar': {
            'Employee': "الموظف",
            'Violation': "المخالفة",
            "Repeats": "عدد التكرارات",
            "Violation Date": "تاريخ المخالفة",
            "Absent days": "أيام الغياب",
            "Handing over the violation": "تسليم المخالفة",
            "Actions": "الاجراءات",
            "Job Number": "الرقم الوظيفي",
            'Are you sure to delete this item?': "هل انت متأكد أنك تريد مسح هذا العنصر؟",
            'Choose the delivery method made to the employee': "اختار طريقة التسليم التي تمت للموظف",
            'Item Deleted Successfully': "تم مسح العنصر بنجاح",
            'Yes, Delete!': "نعم امسح!",
            'No, cancel': "لا الغِ",
            'OK': "تم",
            'Loading...': "تحميل...",
            'Error!': "خطأ!",
            'Deleted!': "تم المسح!",
            'Show': "عرض",
            'Edit Info': "تعديل البيانات",
            'Delete': "مسح",
            'Handing over the violation': "تسليم المخالفة",
            'Saudi Post': "البريد السعودي",
            'Email': "البريد الإلكتروني",
            'Hand': "التسليم باليد",
            'Select a delivered': "إختر طريقة التسليم",
            'delivered!': "تم حفظ العملية",
            'Repeat': "تكرار المخالفة",
            'Discount Status': "حالة الحسم",
            'Discounted': 'تم الحسم',
            'I have an acceptable excuse': 'لدية عذر مقبول',
            'pardon from the director': 'عفو من المدير',
        }
    };

    var locator = new KTLocator(messages);

    // basic demo
    var demo = function () {

        var datatable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/dashboard/employees_violations',
                    },
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: false,
                serverSorting: true,
                saveState: tablesSaveStatus,
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false, // display/hide footer
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#generalSearch'),
                delay: 400,
            },
            rows: {
                afterTemplate: function (row, data, index) {
                    row.find('.delete-item').on('click', function () {
                        swal.fire({
                            buttonsStyling: false,

                            html: locator.__("Are you sure to delete this item?"),
                            type: "info",

                            confirmButtonText: locator.__("Yes, Delete!"),
                            confirmButtonClass: "btn btn-sm btn-bold btn-brand",

                            showCancelButton: true,
                            cancelButtonText: locator.__("No, cancel"),
                            cancelButtonClass: "btn btn-sm btn-bold btn-default"
                        }).then(function (result) {
                            if (result.value) {
                                swal.fire({
                                    title: locator.__('Loading...'),
                                    onOpen: function () {
                                        swal.showLoading();
                                    }
                                });
                                $.ajax({
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: '/dashboard/employees_violations/' + data.id,
                                    error: function (err) {
                                        if (err.hasOwnProperty('responseJSON')) {
                                            if (err.responseJSON.hasOwnProperty('message')) {
                                                swal.fire({
                                                    title: locator.__('Error!'),
                                                    text: locator.__(err.responseJSON.message),
                                                    type: 'error'
                                                });
                                            }
                                        }
                                        console.log(err);
                                    }
                                }).done(function (res) {
                                    swal.fire({
                                        title: locator.__('Deleted!'),
                                        text: locator.__(res.message),
                                        type: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: locator.__("OK"),
                                        confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                                    });
                                    datatable.reload();
                                });
                            }
                        });
                    });

                    row.find('.send-item').on('click', function () {
                        Swal.fire({
                            title: locator.__('Select a delivered'),
                            input: 'select',
                            inputOptions: {
                                'Saudi Post': locator.__('Saudi Post'),
                                'Email': locator.__('Email'),
                                'Hand': locator.__('Hand'),
                            },
                            inputPlaceholder: locator.__('Select a delivered'),
                            showCancelButton: true,
                            inputValidator: (value) => {
                                if (value) {
                                    //console.log(value + " " + data.id);
                                    $.ajax({
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: '/dashboard/employees_violations_delivery/' + data.id + "/" + value,
                                        error: function (err) {
                                            if (err.hasOwnProperty('responseJSON')) {
                                                if (err.responseJSON.hasOwnProperty('message')) {
                                                    swal.fire({
                                                        title: locator.__('Error!'),
                                                        text: locator.__(err.responseJSON.message),
                                                        type: 'error'
                                                    });
                                                }
                                            }
                                            console.log(err);
                                        }
                                    }).done(function (res) {
                                        console.log(res);
                                        swal.fire({
                                            title: locator.__('delivered!'),
                                            type: 'success',
                                            buttonsStyling: false,
                                            confirmButtonText: locator.__("OK"),
                                            confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                                        });
                                        datatable.reload();
                                    });
                                }
                            }
                        })

                    });

                    row.find('.discount_status').on('click', function () {
                        Swal.fire({
                            title: locator.__('Discount Status'),
                            input: 'select',
                            inputOptions: {
                                'Discounted': locator.__('Discounted'),
                                'I have an acceptable excuse': locator.__('I have an acceptable excuse'),
                                'pardon from the director': locator.__('pardon from the director'),
                            },
                            inputPlaceholder: locator.__('Discount Status'),
                            showCancelButton: true,
                            inputValidator: (value) => {
                                if (value) {
                                    //console.log(value + " " + data.id);
                                    $.ajax({
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: '/dashboard/employees_violations_discount_status/' + data.id + "/" + value,
                                        error: function (err) {
                                            if (err.hasOwnProperty('responseJSON')) {
                                                if (err.responseJSON.hasOwnProperty('message')) {
                                                    swal.fire({
                                                        title: locator.__('Error!'),
                                                        text: locator.__(err.responseJSON.message),
                                                        type: 'error'
                                                    });
                                                }
                                            }
                                            console.log(err);
                                        }
                                    }).done(function (res) {
                                        console.log(res);
                                        swal.fire({
                                            title: locator.__('delivered!'),
                                            type: 'success',
                                            buttonsStyling: false,
                                            confirmButtonText: locator.__("OK"),
                                            confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                                        });
                                        datatable.reload();
                                    });
                                }
                            }
                        })

                    });

                }
            },

            // columns definition
            columns: [{
                field: 'id',
                title: '#',
                sortable: 'asc',
                width: 30,
                type: 'number',
                selector: false,
                textAlign: 'center',
            }, {
                field: 'employee.name_in_arabic',
                title: locator.__('Employee'),
                textAlign: 'center',
                template: function (row) {
                    return '\
		                  \
		                      \
		                          \
		                            <a href="/dashboard/employees/' + row.employee.id + '">' + employeeName(row.employee) + '</a>\
		                          \
		                      \
		                  \
                        ';
                }
            }, {
                field: 'employee.job_number',
                title: locator.__('Job Number'),
                textAlign: 'center',
            }, {
                field: 'violation.reason_in_arabic',
                title: locator.__('Violation'),
                textAlign: 'center',
                template: function (row) {
                    return (appLang === 'ar') ? row.violation.reason_in_arabic : row.violation.reason_in_english;
                }
            }, {
                field: 'repeats',
                title: locator.__('Repeats'),
                textAlign: 'center',
            }, {
                field: 'date',
                title: locator.__('Violation Date'),
                textAlign: 'center',
            }, {
                field: 'absence_days',
                title: locator.__('Absent days'),
                textAlign: 'center',
            }, {
                field: 'delivered',
                title: locator.__('Handing over the violation'),
                textAlign: 'center',
            }, {
                field: 'discount_status',
                title: locator.__('Discount Status'),
                textAlign: 'center',
            }, {
                field: 'Actions',
                title: locator.__('Actions'),
                sortable: false,
                width: 110,
                overflow: 'visible',
                autoHide: false,
                textAlign: 'center',
                template: function (row) {
                    return '\
		                  <div class="dropdown">\
		                      <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
		                          <i class="la la-ellipsis-h"></i>\
		                      </a>\
		                      <div class="dropdown-menu dropdown-menu-right">\
		                          <a class="dropdown-item" href="/dashboard/employees_violations/' + row.id + '/edit"><i class="la la-pencil-square-o"></i>' + locator.__('Edit Info') + '</a>\
		                          <a class="dropdown-item" href="/dashboard/employees_violations/' + row.id + '"><i class="la la-eye"></i>' + locator.__('Show') + '</a>\
		                          <a class="dropdown-item delete-item" href="#"><i class="la la-trash">      </i>' + locator.__('Delete') + '</a>\
		                          <a class="dropdown-item " href="/dashboard/employees_violations/repeat/' + row.id + '/" ><i class="la la-copy"> </i>' + locator.__("Repeat") + '</a>\
		                          <a class="dropdown-item send-item" href="#" ><i class="la la-comment-o"> </i>' + locator.__("Handing over the violation") + '</a>\
		                          <a class="dropdown-item discount_status" href="#" ><i class="la la-legal"> </i>' + locator.__("Discount Status") + '</a>\
		                      </div>\
		                  </div>\
                        ';
                }
            }],
        });

        $('#kt_form_status').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });
        $('#kt_form_status,#kt_form_type').selectpicker();

    };

    return {
        // public functions
        init: function () {
            demo();
        },
    };
}();

jQuery(document).ready(function () {
    KTDatatableLocalSortDemo.init();
});