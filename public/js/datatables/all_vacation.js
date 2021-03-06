"use strict";
// Class definition

var KTDatatableLocalSortDemo = function () {
    // Private functions
    var messages = {
        'ar': {
            'Date': "تاريخ طلب الأجازة",
            "Actions": "الاجراءات",
            'Are you sure to delete this item?': "هل انت متأكد أنك تريد مسح هذا العنصر؟",
            'Item Deleted Successfully': "تم مسح العنصر بنجاح",
            'Yes, Delete!': "نعم امسح!",
            'No, cancel': "لا الغِ",
            'OK': "تم",
            'Loading...': "تحميل...",
            'Error!': "خطأ!",
            'Deleted!': "تم المسح!",
            'Show': "عرض",
            'Delete': "حذف",
            'Job Number': "الرقم الوظيفي",
            "Attendance Forgotten": "نسيان تسجيل الحضور",
            "Vacation Request": "طلب اجازة",
            'Pending': "تحت اﻹجراء",
            "Employee": "الموظف",
            "Request Type": "نوع الطلب",
            "Status": "الحاله",
            'Finished': "تم الرد",
            'vacation type': "نوع الاجازة",
            'vacation days': "عدد الايام",
            'start date': "تاريخ البداية",
            'return date': "تاريخ العودة",
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
                        url: '/dashboard/requests/all_vacation',
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
                                    url: '/dashboard/requests/all_vacation/' + data.id,
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
                    field: 'employee',
                    title: locator.__('Employee'),
                    textAlign: 'center',

                    template: function (data) {
                        var output = '';
                        var stateNo = KTUtil.getRandomInt(0, 6);
                        var states = [
                            'success',
                            'brand',
                            'danger',
                            'success',
                            'warning',
                            'primary',
                            'info'
                        ];
                        var state = states[stateNo];
                        let employee = data.employee
                        let name = employeeName(employee);
                        output = '<div class="kt-user-card-v2">\
								<div class="kt-user-card-v2__pic">\
									<div class="kt-badge kt-badge--xl kt-badge--' + state + '">' + name.substring(0, 2) + '</div>\
								</div>\
								<div class="kt-user-card-v2__details">\
									<a href="/dashboard/employees/' + data.employee_id + '" class="kt-user-card-v2__name">' + name + '</a>\
								</div>\
							</div>';

                        return output;
                    }

                }, {
                    field: 'employee_id',
                    title: locator.__('Job Number'),
                    textAlign: 'center',
                    template: function (data) {
                        return data.employee.job_number;
                    }

                }, {
                    field: 'vacation.vacation_type',
                    title: locator.__('vacation type'),
                    textAlign: 'center',
                    template: function (data) {
                        return vacationName(data.vacation.vacation_type);
                    }

                }, {
                    field: 'vacation.total_days',
                    title: locator.__('vacation days'),
                    textAlign: 'center',
                    template: function (data) {
                        return data.vacation.total_days;
                    }

                },
                {
                    field: 'vacation.start_date',
                    title: locator.__('start date'),
                    textAlign: 'center',
                    template: function (data) {
                        return data.vacation.start_date;
                    }

                },
                {
                    field: 'vacation.end_date',
                    title: locator.__('return date'),
                    textAlign: 'center',
                    template: function (data) {
                        return data.vacation.end_date;
                    }

                }, {
                    field: 'created_at',
                    title: locator.__('Date'),
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
                                  <a class="dropdown-item" href="/dashboard/requests/' + row.id + '"><i class="la la-eye"></i>' + locator.__('Show') + '</a>\
                                  <a class="dropdown-item delete-item" href="#"><i class="la la-trash"></i>' + locator.__('Delete') + '</a>\
                              </div>\
                          </div>\
                            ';
                    }
                }
            ],

        });




        $('#kt_form_request').on('change', function () {
            datatable.search($(this).val(), 'requestable_type');
        });



        $('#kt_form_request').selectpicker();


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