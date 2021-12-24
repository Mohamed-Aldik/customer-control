$(function () {
    let violation_select = $("select[name=violation_id]");
    let minutesLate = $("#minutes_late");
    let absenceDays = $("#absence_days");
    let absenceDaysInput = $("input[name='absence_days']");
    let minutesLateInput = $("input[name='minutes_late']");


    getType(violation_select.val());
    violation_select.change(function () {
        let violation_id = violation_select.val();
        getType(violation_id);
    });

    function getType(violation_id) {
        if (violation_select.val() != null && violation_select.val() !== '') {
            $.ajax({
                url: '/dashboard/violations/' + violation_id + '/additions',
                success: function (data) {
                    switch (data.additions) {
                        case 'minutes_deduc': // lateness
                            minutesLate.fadeIn();
                            minutesLateInput.prop('required', true);
                            absenceDays.fadeOut();
                            break;
                        case 'leave_days': // leave work
                            absenceDays.fadeIn();
                            absenceDaysInput.prop('required', true);
                            minutesLate.fadeOut();
                            break;
                        default:
                            absenceDays.fadeOut();
                            minutesLate.fadeOut();
                            absenceDaysInput.prop('required', false);
                            minutesLateInput.prop('required', false);
                            break;
                    }
                },
            });

        }
    }
});


function checkValidate() {
    var fruits = [22, 24, 25];
    var employee_id = $("#employee_id").val();

    var violation_id = $("#violation_id").val();
    var date_violation = $("#date_violation").val();
    var ids = [22, 23, 24, 25, 28, 29, 30, 31];

    /*
    if (employee_violation.includes(parseInt(violation_id))) {
        alert("{{ __('He passed the 4 violation') }}");
    }
    var employee_violation = $("#employee_id option:selected").data('violation');
    */


    if (employee_id > 0 && violation_id > 0 && date_violation != '') {
        if (ids.includes(parseInt(violation_id))) {
            $("#subbutton").attr("disabled", "disabled");
            checkminutes();
        } else {
            $("#subbutton").removeAttr('disabled');
        }


    } else {
        $("#subbutton").attr("disabled", "disabled");
    }
    //console.log(employee_id);
}

function checkminutes() {
    console.log('check');
    var violation_id = $("#violation_id").val();
    var minutes_late = $("#minutes_late2").val();
    var absence_days = $("#absence_days2").val();

    if (parseInt(violation_id) == 22 && minutes_late > 30 && minutes_late <= 60) {
        $("#subbutton").removeAttr('disabled');
    }
    if (parseInt(violation_id) == 23 && minutes_late > 60) {
        $("#subbutton").removeAttr('disabled');
    }
    if (parseInt(violation_id) == 24 && minutes_late <= 15) {
        $("#subbutton").removeAttr('disabled');
    }
    if (parseInt(violation_id) == 25 && minutes_late > 15) {
        $("#subbutton").removeAttr('disabled');
    }

    if (parseInt(violation_id) == 28 && absence_days >= 2 && absence_days <= 6) {
        $("#subbutton").removeAttr('disabled');
    }

    if (parseInt(violation_id) == 29 && absence_days >= 7 && absence_days <= 10) {
        $("#subbutton").removeAttr('disabled');
    }

    if (parseInt(violation_id) == 30 && absence_days >= 11 && absence_days <= 14) {
        $("#subbutton").removeAttr('disabled');
    }

    if (parseInt(violation_id) == 31 && absence_days >= 16) {
        $("#subbutton").removeAttr('disabled');
    }

}