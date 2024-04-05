var base_url = window.location.origin;
function serviceSubmit() {
    var country = $("#country").val();
    if (country == "") {
        $("#errorcountry").removeClass("gu-hide");
        return false;
    } else {
        $("#errorcountry").addClass("gu-hide");
    }
    var company = $("#company").val();
    if (company == "") {
        $("#errorcompany").removeClass("gu-hide");
        return false;
    } else {
        $("#errorcompany").addClass("gu-hide");
    }
    var operator = $("#operator").val();
    if (operator == "") {
        $("#erroroperator").removeClass("gu-hide");
        return false;
    } else {
        $("#erroroperator").addClass("gu-hide");
    }

    var servicename = $("#servicename").val();
    if (servicename == "") {
        $("#errorservicename").removeClass("gu-hide");
        return false;
    } else {
        $("#errorservicename").addClass("gu-hide");
    }
    var subkeyword = $("#subkeyword").val();
    if (subkeyword == "") {
        $("#errorsubkeyword").removeClass("gu-hide");
        return false;
    } else {
        $("#errorsubkeyword").addClass("gu-hide");
    }
    var short_code = $("#short_code").val();
    if (short_code == "") {
        $("#errorshort_code").removeClass("gu-hide");
        return false;
    } else {
        $("#errorshort_code").addClass("gu-hide");
    }

    var account_manager = $("#account_manager").val();
    if (account_manager == "") {
        $("#erroraccount_manager").removeClass("gu-hide");
        return false;
    } else {
        $("#erroraccount_manager").addClass("gu-hide");
    }
    var pmo = $("#pmo").val();
    if (pmo == "") {
        $("#errorpmo").removeClass("gu-hide");
        return false;
    } else {
        $("#errorpmo").addClass("gu-hide");
    }
}

function checkOperatorType() {}
function aggregratorYes() {
    // $("#aggregrator").removeAttr(readonly)
    $("#aggregrator").attr("readonly", false);
}
function aggregratorNo() {
    $("#aggregrator").val("");
    $("#aggregrator").attr("readonly", true);
}
function cyclePermission() {
    var daily = $("input[name=cycleDaily]:checked").val();
    if (typeof daily === "undefined") {
        // $("#changeCycleDailyPermission").addClass("gu-hide");
        $("#changeCycleDaily").attr("disabled", true);
    } else {
        // $("#changeCycleDailyPermission").removeClass("gu-hide");
        $("#changeCycleDaily").attr("disabled", false);
    }
    var weekly = $("input[name=cycleWeekly]:checked").val();
    console.log(weekly);
    if (typeof weekly === "undefined") {
        // $("#changeCycleWeeklyPermission").addClass("gu-hide");
        $("#changeCycleWeekly").attr("disabled", true);
    } else {
        // $("#changeCycleWeeklyPermission").removeClass("gu-hide");
        $("#changeCycleWeekly").attr("disabled", false);
    }
    var monthly = $("input[name=cycleMonthly]:checked").val();
    if (typeof monthly === "undefined") {
        // $("#changeCycleMonthlyPermission").addClass("gu-hide");
        $("#changeCycleMonthly").attr("disabled", true);
    } else {
        // $("#changeCycleMonthlyPermission").removeClass("gu-hide");
        $("#changeCycleMonthly").attr("disabled", false);
    }
}
function freemiumYes() {
    // $("#freemiumSelect").removeClass("gu-hide");
    $("#freemiumDays").attr("disabled", false);
}
function freemiumNo() {
    // $("#freemiumSelect").addClass("gu-hide");
    $("#freemiumDays").attr("disabled", true);
    // $("input").attr("disabled", true);
}

function serviceEdit() {
    var country = $("#country").val();
    if (country == "") {
        $("#errorcountry").removeClass("gu-hide");
        return false;
    } else {
        $("#errorcountry").addClass("gu-hide");
    }
    var company = $("#company").val();
    if (company == "") {
        $("#errorcompany").removeClass("gu-hide");
        return false;
    } else {
        $("#errorcompany").addClass("gu-hide");
    }
    var operator = $("#operator").val();
    if (operator == "") {
        $("#erroroperator").removeClass("gu-hide");
        return false;
    } else {
        $("#erroroperator").addClass("gu-hide");
    }

    var servicename = $("#servicename").val();
    if (servicename == "") {
        $("#errorservicename").removeClass("gu-hide");
        return false;
    } else {
        $("#errorservicename").addClass("gu-hide");
    }
    var subkeyword = $("#subkeyword").val();
    if (subkeyword == "") {
        $("#errorsubkeyword").removeClass("gu-hide");
        return false;
    } else {
        $("#errorsubkeyword").addClass("gu-hide");
    }
    var short_code = $("#short_code").val();
    if (short_code == "") {
        $("#errorshort_code").removeClass("gu-hide");
        return false;
    } else {
        $("#errorshort_code").addClass("gu-hide");
    }

    [];
}



// When the user clicks on the button, open the modal
$("#operatorType").click(function () {
    $("#commonModal").modal('show');
});


$("#newOperatorSave").click(function () {

    var url = base_url + "service/operator/create";
    var country = $("#country").val();
    if (country == "") {
       alert('Please select country')
        return false;
    }
    var operator= $('#ScOperator').val();
    var operatorName = $("#operatorName").val();
    if (operatorName == "" && operator=="") {
        alert('Please enter operator name');
        return false;
    }

    $.ajax({
        url: url,
        data: {
            country: country,
            operator: operator,
            operatorName: operatorName,
        },
        type: "POST",
        success: function (response) {
            $("#operator").append('<option value="'+response.id_operator+'" selected>'+response.operator_name+'</option>');
            console.log(response);
        },
    });
    $('#commonModal').modal('hide');
});

function operaterSelect(){
    var operator= $('#ScOperator').val();
    if(operator!=''){
        $("#operatorName").attr("readonly", true);
    }else{
        $("#operatorName").attr("readonly", false);
    }
}

function pivotUserSubmit(){

    var type = $("input[name='type[]']:checked").val();
    if (typeof type === "undefined") {
        $("#errortype").removeClass("gu-hide");
        return false;
    } else {
        $("#errortype").addClass("gu-hide");
    }
    var data = $("input[name='data[]']:checked").val();
    if (typeof data === "undefined") {
        $("#errordata").removeClass("gu-hide");
        return false;
    } else {
        $("#errordata").addClass("gu-hide");
    }
    var data = $("#date").val();
    if (data == '') {
        $("#errordate").removeClass("gu-hide");
        return false;
    } else {
        $("#errordate").addClass("gu-hide");
    }
}
function productSubmit(){
    var name = $("#name").val();
    if (name == "") {
        $("#errorname").removeClass("gu-hide");
        return false;
    } else {
        $("#errorname").addClass("gu-hide");
    }
    var doman = $("#doman").val();
    if (doman == "") {
        $("#errordoman").removeClass("gu-hide");
        return false;
    } else {
        $("#errordoman").addClass("gu-hide");
    }
    var analytical_id = $("#analytical_id").val();
    if (analytical_id == "") {
        $("#erroranalytical_id").removeClass("gu-hide");
        return false;
    } else {
        $("#erroranalytical_id").addClass("gu-hide");
    }
}
