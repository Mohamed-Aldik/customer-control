"use strict";
// Class definition

var KTDatatableLocalSortDemo = function() {
    // Private functions
    var messages = {
        'ar': {
            'Employee': "الموظف",
            "Total Deductions":"إجمالي الحسومات",
            "Net Salary":"صافي الراتب",
            // "Net Pay":"صافي المبلغ",
            "Work Days":"ايام العمل",
            "Actions":"اجراءات",
            "Financial Move":"حركة مالية",
            "extra_hours":"ساعات إضافية",

        }
    };

    var locator = new KTLocator(messages);

    // basic demo
    var demo = function() {

        var datatable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/dashboard/payrolls/' + payroll_id,
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
                scroll: true, // enable/disable datatable scroll both horizontal and vertical when needed.
                height: 550,
                footer: false, // display/hide footer
            },

            // column sorting
            sortable: false,

            pagination: true,

            search: {
                input: $('#generalSearch'),
            },
            rows: {
                autoHide: false,
            },
            // columns definition
            columns: [
                 {
                    field: 'job_number',
                    title: locator.__('Job Number'),
                     autoHide: false,
                },{
                    field: "employee",
                    title: locator.__("Employee"),
                    width: 200,
                    autoHide: false,
                    // callback function support for column rendering
                    template: function(data) {
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

                        output = '<div class="kt-user-card-v2">\
								<div class="kt-user-card-v2__details">\
									<a href="/dashboard/employees/' + data.employee_id + '" class="kt-user-card-v2__name">' + data.employee_name + '</a>\
								</div>\
							</div>';

                        return output;
                    }
                }, {
                    field: 'nationality',
                    title: locator.__('Nationality'),
                    autoHide: false,
                }, {
                    field: 'salary',
                    title: locator.__('Salary'),
                    autoHide: false,
                }, {
                    field: 'officialWorkingHours',
                    title: locator.__('Official Working Hours'),
                    autoHide: false,
                }, {
                    field: 'hra',
                    title: locator.__('Housing'),
                    autoHide: false,
                }, {
                    field: 'transfer',
                    title: locator.__('Transfer'),
                    autoHide: false,
                }, {
                    field: 'other_allowances',
                    title: locator.__('Other Allowances'),
                    autoHide: false,
                }, {
                    field: 'financial_movement',
                    title: locator.__('Financial Move'),
                    autoHide: false,
                },
                {
                    field: "extra_hours",
                    title: locator.__("extra_hours"),

                    template: function(data) {
                        var output = '';
                        output = `<span class='get_info_extra_hours' data-id='${data.extra_hours.id}'>${data.extra_hours.value}</span>`;

                        return output;
                    }
                }
                ,  {
                    field: 'gosi_deduction',
                    title: locator.__('GOSI Deduction'),
                    autoHide: false,
                    template:function(row){
                        return '<span class="kt-font-danger">' + row.gosi_deduction + '</span>';
                    }
                }, {
                    field: 'total_deduction',
                    title: locator.__('Total Deductions'),
                    autoHide: false,
                    template:function(row){
                        return '<span class="kt-font-danger">' + row.total_deduction + '</span>';
                    }
                }, {
                    field: 'net_pay',
                    title: locator.__('Net Pay'),
                    autoHide: false,
                    template:function(row){
                        
                        return '<span class="kt-font-primary">' +   row.net_pay   + '</span>';
                    }
                },{
                    field: "Actions",
                    title: locator.__("Actions"),
                    sortable: false,
                    autoHide: false,
                    overflow: 'visible',
                    template: function(row) {
                        return '\
		                  <a href="/dashboard/salaries/' + row.id + '" class="btn btn-sm btn-default btn-font-sm" title="Edit details">\
		                      <i class="flaticon2-document"></i> ' + locator.__('Details') +'\
		                  </a>';
                    },
                }]
        });

        $('#kt_form_supervisor').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'supervisor');
        });
        $('#kt_form_nationality').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'nationality');
        });

        $('#kt_form_department').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'department');
        });

        $('#kt_form_provider').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'provider');
        });

        $('#kt_form_section').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'section');
        });


    };


    return {
        // public functions
        init: function() {
            demo();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableLocalSortDemo.init();
});
