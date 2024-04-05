/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(function () {
    commonLoader();
});
$(document).ready(function() {
    var baseUrl = window.location.origin + "/";
    
    $('#select-all').on('click', function() {
        // e.preventDefault();
        var myArray = $('.selected_staff').val();
        if(myArray !=""){
           myArray = myArray.split(',');

        }else{
            myArray = [];
        }
        
        $(".sub_chk").prop('checked', $(this).is(':checked'));



        $( '.sub_chk' ).each( function(e) {
            if ($(this).prop('checked') == true){ 

                
                if(jQuery.inArray($( this ).val(), myArray) != -1) {
                    console.log("is in array");
                } else {
                    myArray.push($( this ).val())
                } 
            }else{
               if(jQuery.inArray($( this ).val(), myArray) != -1) {
                    myArray.splice( $.inArray($( this ).val(), myArray), 1 );
                }  
            }
        });
        // console.log(myArray)
        $('.selected_staff').val(myArray);
        console.log(myArray)
    });


    




    $('.sub_chk').on('click', function() {
        // var newarray = [];
        // $(this).prop('checked', $(this).is(':checked'));

        var already_selected = $('.selected_staff').val();
        if(already_selected !=""){
           already_selected = already_selected.split(',');

        }else{
            already_selected = [];
        }
        console.log(already_selected)
        if ($(this).prop('checked') == true){ 
            console.log("yes");
            if(jQuery.inArray($( this ).val(), already_selected) != -1) {
                console.log("is in array");
            } else {
                already_selected.push($( this ).val())
            } 

        }else{
            console.log("no");
            console.log($( this ).val());
            if(jQuery.inArray($( this ).val(), already_selected) != -1) {
                already_selected.splice( $.inArray($( this ).val(), already_selected), 1 );
            } 
            //console.log($( this ).val());

        }
        $('.selected_staff').val(already_selected)
        console.log(already_selected);
        
    });



    // $('.sub_chk_edit').on('click', function() {
    //     var checkboxes = document.querySelectorAll("input[type=checkbox]");
    //     var checked = [];

    //     for (var i = 0; i < checkboxes.length; i++) {
    //         var checkbox = checkboxes[i];
    //         if (checkbox.checked) 
    //         checked.push(checkbox.value);
    //     }
    //     $('.selected_staff_edit').val(checked);
    //     console.log(checked);
    // });






    var previousSupervisorData = [];
    var previousOfficerData = [];

    $('.supervisor_name').on('change', function() {
        var selectedSupervisor = this.value;
        var exists = 0 != $('.officer_name option[value='+selectedSupervisor+']').length;
        var exists = false;
        if(previousSupervisorData != ''){
            $('.officer_name option').each(function(){
                if (this.value == selectedSupervisor) {
                    exists = true;
                    $(".officer_name").children("option[value^=" + previousSupervisorData + "]").show();
                    return false;
                }
            });
        }
        $('.officer_name option').each(function(){
            if (this.value == selectedSupervisor) {
                exists = true;
                previousSupervisorData = selectedSupervisor;
                $(".officer_name").children("option[value^=" + selectedSupervisor + "]").hide();
                return false;
            }
        });
        // var valuetake = $('.supervisor_name').val();
        // if(valuetake !=""){
        //     console.log(valuetake);
        //  $('#dept_officer_name').val(valuetake);
        // }
        // console.log(valuetake);
    });


    $('.officer_name').on('change', function() {
        var selectedOffisor = this.value;
        var Oexists = 0 != $('.supervisor_name option[value='+selectedOffisor+']').length;
        var Oexists = false;
        if(previousOfficerData != ''){
            $('.supervisor_name option').each(function(){
                if (this.value == selectedOffisor) {
                    Oexists = true;
                    $(".supervisor_name").children("option[value^=" + previousOfficerData + "]").show();
                    return false;
                }
            });
        }else{
                $('.supervisor_name option').each(function(){
                if (this.value == selectedOffisor) {
                    Oexists = true;
                    previousOfficerData = selectedOffisor;
                    $(".supervisor_name").children("option[value^=" + selectedOffisor + "]").hide();
                    return false;
                }
            }); 
        }
    });


    $('.next').on('click', function(e) {
        // e.preventDefault();
        if($('#dept_name').val() == ''){
            $('.requireNameMsg').show();
        }else{
            $('.requireNameMsg').hide();
            $('.step_1').hide();
            $('.step_2').show();
        }
        
        
    });

    $('.click_fpswrd').on('click', function(e) {
        // e.preventDefault();
        $('.error_msg_fpswrd').show();
    });

    // $('#dept_submit').on('click', function(e) {
    //     // e.preventDefault();
    //     if($('#selected_staff').val() == ''){
    //         $('.requireStaffMsg').show();
    //     }else{
    //         $('.requireStaffMsg').hide();
    //         // $('.step_1').hide();
    //         // $('.step_2').show();
    //     }
        
        
    // });
    // var checkboxes = $(".sub_chk"),
    // submitButt = $("#dept_submit");

    // checkboxes.click(function() {
    //     submitButt.attr("disabled", !checkboxes.is(":checked"));
    // });

    $('.back').on('click', function(e) {
        // e.preventDefault();
        $('.step_2').hide();
        $('.step_1').show();
    });


    $('.clickme').click(function() {
       // if(confirm("Are you sure you want to navigate away from this page?"))
       // {
          history.go(-1);
       // }        
       return false;
    });


    $(document).on('click', "#edit-item", function() {
        $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

        //     var supervisor_name = $('.supervisor_name').val();
        //     var officer_name = $('.officer_name').val();
        var options = {
            'backdrop': 'static'
        };
        $('#edit-modal').modal(options)

    })


    // on modal show
    $('#edit-modal').on('show.bs.modal', function() {

        var el = $(".edit-item-trigger-clicked");
        // alert(el); // See how its usefull right here? 
        var row = el.closest(".data-row");
        // alert(row);

        // get the data
        var id = el.data('item-id');
        var name = row.children(".dept_name").text();
        // alert(name);
        // console.log(name);
        // return false;
        var description = row.children(".description").text();

        // fill the data in the input fields
        $("#modal-input-id").val(id);
        $("#modal-input-name").val(name);
        $("#modal-input-description").val(description);


         var dept_name = $('#dept_name').val();
         var officer_name = jQuery(".officer_name option:selected").text();
         var supervisor_name = jQuery(".supervisor_name option:selected").text();
         // alert(officer_name);
         // alert(supervisor_name);
         // var dept_name = $('#dept_name').val();
         localStorage.setItem(dept_name,dept_name);
         localStorage.setItem(officer_name,officer_name);
         localStorage.setItem(supervisor_name,supervisor_name);
        $('#modal-dept_name').val(localStorage.getItem(dept_name));
        $('#modal-officer_name').val(localStorage.getItem(officer_name));
        $('#modal-supervisor_name').val(localStorage.getItem(supervisor_name));

    })


     // on modal hide
    $('#edit-modal').on('hide.bs.modal', function() {
        $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
        $("#edit-form").trigger("reset");
    });
    $('.close_new').on('click', function(e) {
        // e.preventDefault();
        $('.modal_pre').hide();
        // $('.step_1').show();
    });

});

var baseUrl = window.location.origin + "/";

function show_toastr(title, message, type) {
    var o, i;
    var icon = '';
    var cls = '';

    if (type == 'success') {
        icon = 'fas fa-check-circle';
        cls = 'success';
    } else {
        icon = 'fas fa-times-circle';
        cls = 'danger';
    }

    $.notify({icon: icon, title: " " + title, message: message, url: ""}, {
        element: "body",
        type: cls,
        allow_dismiss: !0,
        placement: {
            from: 'top',
            align: toster_pos
        },
        offset: {x: 15, y: 15},
        spacing: 10,
        z_index: 1080,
        delay: 2500,
        timer: 2000,
        url_target: "_blank",
        mouse_over: !1,
        animate: {enter: o, exit: i},
        template: '<div class="alert alert-{0} alert-icon alert-group alert-notify" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"><span class="alert-group-icon"><i data-notify="icon"></i></span></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
    });
}

$(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
    var title = $(this).data('title');
    var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
    var url = $(this).data('url');

    $("#commonModal .modal-title").html(title);
    $("#commonModal .modal-dialog").addClass('modal-' + size);

    $.ajax({
        url: url,
        success: function (data) {
            $('#commonModal .modal-body').html(data);
            $("#commonModal").modal('show');
            commonLoader();
        },
        error: function (data) {
            data = data.responseJSON;
            show_toastr('Error', data.error, 'error')
        }
    });

});

$(document).on('click', 'a[data-ajax-popup-over="true"], button[data-ajax-popup-over="true"], div[data-ajax-popup-over="true"]', function () {

    var title = $(this).data('title');
    var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
    var url = $(this).data('url');

    $("#commonModalOver .modal-title").html(title);
    $("#commonModalOver .modal-dialog").addClass('modal-' + size);

    $.ajax({
        url: url,
        success: function (data) {
            $('#commonModalOver .modal-body').html(data);
            $("#commonModalOver").modal('show');
            commonLoader();
        },
        error: function (data) {
            data = data.responseJSON;
            show_toastr('Error', data.error, 'error')
        }
    });

});

function arrayToJson(form) {
    var data = $(form).serializeArray();
    var indexed_array = {};

    $.map(data, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

$(document).on("submit", "#commonModalOver form", function (e) {
    e.preventDefault();
    var data = arrayToJson($(this));
    data.ajax = true;

    var url = $(this).attr('action');
    $.ajax({
        url: url,
        data: data,
        type: 'POST',
        success: function (data) {
            show_toastr('Success', data.success, 'success');
            $(data.target).append('<option value="' + data.record.id + '">' + data.record.name + '</option>');
            $(data.target).val(data.record.id);
            $(data.target).trigger('change');
            $("#commonModalOver").modal('hide');
            commonLoader();
        },
        error: function (data) {
            data = data.responseJSON;
            show_toastr('Error', data.error, 'error')
        }
    });
});

(function ($, window, i) {
    // Bootstrap 4 Modal
    $.fn.fireModal = function (options) {
        var options = $.extend({
            size: 'modal-md',
            center: false,
            animation: true,
            title: 'Modal Title',
            closeButton: false,
            header: true,
            bodyClass: '',
            footerClass: '',
            body: '',
            buttons: [],
            autoFocus: true,
            created: function () {
            },
            appended: function () {
            },
            onFormSubmit: function () {
            },
            modal: {}
        }, options);
        this.each(function () {
            i++;
            var id = 'fire-modal-' + i,
                trigger_class = 'trigger--' + id,
                trigger_button = $('.' + trigger_class);
            $(this).addClass(trigger_class);
            // Get modal body
            let body = options.body;
            if (typeof body == 'object') {
                if (body.length) {
                    let part = body;
                    body = body.removeAttr('id').clone().removeClass('modal-part');
                    part.remove();
                } else {
                    body = '<div class="text-danger">Modal part element not found!</div>';
                }
            }
            // Modal base template
            var modal_template = '   <div class="modal' + (options.animation == true ? ' fade' : '') + '" tabindex="-1" role="dialog" id="' + id + '">  ' +
                '     <div class="modal-dialog ' + options.size + (options.center ? ' modal-dialog-centered' : '') + '" role="document">  ' +
                '       <div class="modal-content">  ' +
                ((options.header == true) ?
                    '         <div class="modal-header">  ' +
                    '           <h5 class="modal-title mx-auto">' + options.title + '</h5>  ' +
                    ((options.closeButton == true) ?
                        '           <button type="button" class="close" data-dismiss="modal" aria-label="Close">  ' +
                        '             <span aria-hidden="true">&times;</span>  ' +
                        '           </button>  '
                        : '') +
                    '         </div>  '
                    : '') +
                '         <div class="modal-body text-center text-dark">  ' +
                '         </div>  ' +
                (options.buttons.length > 0 ?
                    '         <div class="modal-footer mx-auto">  ' +
                    '         </div>  '
                    : '') +
                '       </div>  ' +
                '     </div>  ' +
                '  </div>  ';
            // Convert modal to object
            var modal_template = $(modal_template);
            // Start creating buttons from 'buttons' option
            var this_button;
            options.buttons.forEach(function (item) {
                // get option 'id'
                let id = "id" in item ? item.id : '';
                // Button template
                this_button = '<button type="' + ("submit" in item && item.submit == true ? 'submit' : 'button') + '" class="' + item.class + '" id="' + id + '">' + item.text + '</button>';
                // add click event to the button
                this_button = $(this_button).off('click').on("click", function () {
                    // execute function from 'handler' option
                    item.handler.call(this, modal_template);
                });
                // append generated buttons to the modal footer
                $(modal_template).find('.modal-footer').append(this_button);
            });
            // append a given body to the modal
            $(modal_template).find('.modal-body').append(body);
            // add additional body class
            if (options.bodyClass) $(modal_template).find('.modal-body').addClass(options.bodyClass);
            // add footer body class
            if (options.footerClass) $(modal_template).find('.modal-footer').addClass(options.footerClass);
            // execute 'created' callback
            options.created.call(this, modal_template, options);
            // modal form and submit form button
            let modal_form = $(modal_template).find('.modal-body form'),
                form_submit_btn = modal_template.find('button[type=submit]');
            // append generated modal to the body
            $("body").append(modal_template);
            // execute 'appended' callback
            options.appended.call(this, $('#' + id), modal_form, options);
            // if modal contains form elements
            if (modal_form.length) {
                // if `autoFocus` option is true
                if (options.autoFocus) {
                    // when modal is shown
                    $(modal_template).on('shown.bs.modal', function () {
                        // if type of `autoFocus` option is `boolean`
                        if (typeof options.autoFocus == 'boolean')
                            modal_form.find('input:eq(0)').focus(); // the first input element will be focused
                        // if type of `autoFocus` option is `string` and `autoFocus` option is an HTML element
                        else if (typeof options.autoFocus == 'string' && modal_form.find(options.autoFocus).length)
                            modal_form.find(options.autoFocus).focus(); // find elements and focus on that
                    });
                }
                // form object
                let form_object = {
                    startProgress: function () {
                        modal_template.addClass('modal-progress');
                    },
                    stopProgress: function () {
                        modal_template.removeClass('modal-progress');
                    }
                };
                // if form is not contains button element
                if (!modal_form.find('button').length) $(modal_form).append('<button class="d-none" id="' + id + '-submit"></button>');
                // add click event
                form_submit_btn.click(function () {
                    modal_form.submit();
                });
                // add submit event
                modal_form.submit(function (e) {
                    // start form progress
                    form_object.startProgress();
                    // execute `onFormSubmit` callback
                    options.onFormSubmit.call(this, modal_template, e, form_object);
                });
            }
            $(document).on("click", '.' + trigger_class, function () {
                $('#' + id).modal(options.modal);
                return false;
            });
        });
    }
    // Bootstrap Modal Destroyer
    $.destroyModal = function (modal) {
        modal.modal('hide');
        modal.on('hidden.bs.modal', function () {
        });
    }
})(jQuery, this, 0);

$('[data-confirm]').each(function () {
    var me = $(this),
        me_data = me.data('confirm');

    me_data = me_data.split("|");
    me.fireModal({
        title: me_data[0],
        body: me_data[1],
        buttons: [
            {
                text: me.data('confirm-text-yes') || 'Yes',
                class: 'btn btn-sm btn-danger rounded-pill',
                handler: function () {
                    eval(me.data('confirm-yes'));
                }
            },
            {
                text: me.data('confirm-text-cancel') || 'Cancel',
                class: 'btn btn-sm btn-secondary rounded-pill',
                handler: function (modal) {
                    $.destroyModal(modal);
                    eval(me.data('confirm-no'));
                }
            }
        ]
    })
});


function commonLoader() {
    if ($(".datepicker").length) {
        $('.datepicker').daterangepicker({
            locale: date_picker_locale,
            singleDatePicker: true,
        });
    }

    if ($(".daterange-picker").length) {
        $('.daterange-picker').daterangepicker({
            locale: date_picker_locale,
        });
    }
    if ($(".select2").length) {
        $(".select2").select2({
            disableOnMobile: false,
            nativeOnMobile: false
        });
    }

    if ($(".summernote-simple").length) {
        $('.summernote-simple').summernote({
            dialogsInBody: !0,
            minHeight: 200,
            toolbar: [
                ['style', ['style']],
                ["font", ["bold", "italic", "underline", "clear", "strikethrough"]],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ["para", ["ul", "ol", "paragraph"]],
            ]
        });
    }

    if ($(".jscolor").length) {
        jscolor.installByClassName("jscolor");
    }

    // for Choose file
    $(document).on('change', 'input[type=file]', function () {
        var fileclass = $(this).attr('data-filename');
        var finalname = $(this).val().split('\\').pop();
        $('.' + fileclass).html(finalname);
    });
}

