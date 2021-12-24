"use strict";

// Class definition
var KTContactsAdd = function () {
    // Base elements
    var wizardEl;
    var formEl;
    var validator;
    var wizard;
    var avatar;


    let messages = {
        'ar': {
            "please fill the required data": "الرجاء مليء الحقول المطلوبة",
            "The operation has been done successfully !": "لقد تمت العملية بنجاح !",
            "Failed !": "فشلت العمليه"
        }
    };

    let locator = new KTLocator(messages);

    // Private functions
    var initWizard = function () {
        // Initialize form wizard
        wizard = new KTWizard('kt_contacts_add', {
            startStep: 1, // initial active step number
            clickableSteps: true // allow step clicking
        });

        // Validation before going to next page
        wizard.on('beforeNext', function (wizardObj) {
            if (validator.form() !== true) {
                wizardObj.stop(); // don't go to the next step
            }
        })

        // Change event
        wizard.on('change', function (wizard) {
            KTUtil.scrollTop();
        });
    }

    var initValidation = function () {
        validator = formEl.validate({
            // Validate only visible fields
            ignore: ":hidden",

            // Validation rules
            rules: {
                start_date: {
                    required: true
                },
                end_date: {
                    required: true,
                },
                vacation_type_id: {
                    required: true
                }

            },

            // Display error
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();

                swal.fire({
                    "title": "",
                    "text": locator.__("please fill the required data"),
                    "type": "error",
                    "buttonStyling": false,
                    "confirmButtonClass": "btn btn-brand btn-sm btn-bold"
                });
            },

            // Submit valid form
            submitHandler: function (form) {

            }
        });
    }

    var initSubmit = function () {
        var btn = formEl.find('[data-ktwizard-type="action-submit"]');

        btn.on('click', function (e) {
            e.preventDefault();

            if (validator.form()) {
                // See: src\js\framework\base\app.js
                KTApp.progress(btn);
                //KTApp.block(formEl);

                // See: http://malsup.com/jquery/form/#ajaxSubmit
                formEl.ajaxSubmit({
                    success: function (response) {
                        KTApp.unprogress(btn);
                        //KTApp.unblock(formEl);
                        if (response.status) {
                            swal.fire({
                                "title": "",
                                "text": locator.__("The operation has been done successfully !"),
                                "type": "success",
                                "confirmButtonClass": "btn btn-secondary"
                            }).then(function () {
                                // window.location.replace("/dashboard/requests/mine");
                            });
                        } else {
                            swal.fire({
                                "title": "",
                                "text": response.message,
                                "type": "error",
                                "confirmButtonClass": "btn btn-secondary"
                            }).then(function () {
                                // window.location.replace("/dashboard/requests/mine");
                            });
                        }

                    },
                    error: function (err) {
                        let response = err.responseJSON;
                        let errors = '';
                        $.each(response.errors, function (index, value) {
                            errors += value + '\n';
                        });
                        swal.fire({
                            title: locator.__(response.message),
                            text: errors,
                            type: 'error'
                        });
                        console.log(err);
                    }
                });
            }
        });
    }

    var initAvatar = function () {
        avatar = new KTAvatar('kt_contacts_add_avatar');
    }

    return {
        // public functions
        init: function () {
            formEl = $('#kt_contacts_add_form');

            initWizard();
            initValidation();
            initSubmit();
            initAvatar();
        }
    };
}();

jQuery(document).ready(function () {

    $('#paid_in_advance:checkbox').change(
        function () {
            if ($(this).is(':checked')) {
                $(".show_if_paid_in_advance").slideDown();
            } else {
                $(".show_if_paid_in_advance").slideUp();
            }
        });


    KTContactsAdd.init();
    var existBalance = $("#vacation_balance").text();
    var startDate = $(".start_date");
    var endDate = $(".end_date");
    var endDate2 = $(".end_date2");
    var vacationTypesSelect = $("#vacationTypes");
    var employeesSelect = $("#employees");

    calculatePeriod();

    $(".start_date, .end_date").focusout(function () {
        calculatePeriod();
    });

    vacationTypesSelect.change(function () {
        var v = vacationTypesSelect.find(':selected').data('value');
        var value = vacationTypesSelect.find(':selected').data('id');
        if (v >= 1) {
            endDate.val(v);
        }
        if (value == 4) {
            $("#paid_in_advance").removeAttr('disabled');
            $("#ticket_request").removeAttr('disabled');
        } else {
            $(".show_if_paid_in_advance").slideUp();

            $("#paid_in_advance").prop('checked', false);
            $("#paid_in_advance").prop('disabled', true);

            $("#ticket_request").prop('checked', false);
            $("#ticket_request").prop('disabled', true);

        }
        calculatePeriod();
    });

    employeesSelect.change(function () {
        getLeaveBalance($(this).val())
        calculatePeriod();
    });


    function calculatePeriod() {

        var vacationID = vacationTypesSelect.val();
        if (vacationID === '0') {
            $("#reason").fadeIn()
        } else {
            $("#reason").fadeOut()
        }

        if (startDate.val() !== '' && endDate.val() !== '') {

            $.get('/dashboard/vacation_types/check_vaction2', {
                days: endDate.val(),
                startDate: startDate.val(),
                chosse: vacationTypesSelect.find(':selected').data('id')
            }, function (e) {


                endDate2.val(e.date_end);
                if (e.massage == "success") {
                    endDate2.val(e.date_end);
                    $("#return_date").hide(0).html(e.date_blus1).fadeIn();
                    $("#end_date01").hide(0).html(e.date_end).fadeIn();
                    $(".available_balance").hide(0).text(e.available_from_start_date).fadeIn();
                    $("#vacation_balance").hide(0).html(e.new_availabel_balance).fadeIn();
                    $(".show_if_paid_in_advance table").hide(0).fadeIn();
                    if (e.paid_in_advance) {
                        $(".salary_Paid_in_advance").text(e.salary_Paid_in_advance);
                    } else {
                        $(".salary_Paid_in_advance").text('- - - - -');
                    }
                } else {
                    swal.fire({
                        title: e.error,
                        type: 'error'
                    });
                    //alert(e.error);
                }

            });
        }

    }



    function getLeaveBalance(employeeID) {
        $.ajax({
            url: '/dashboard/employees/' + employeeID + '/leave_balance',
            method: 'get',
            success: function (response) {
                existBalance = response.leave_balance
                $("#vacation_balance").text(existBalance);
            }
        });
    }
});