jQuery(function ($) {


    //  ----------project common works > bootstrap tooltip(hover text)
    $('[data-toggle="tooltip"]').tooltip();
    // top navbar checkbox work  
    $('.particular_msglist_check').click(function () {
        $('.particular_msglist_check').not(this).prop('checked', false);
    });
    // ----------------mailbox ---------------------------------------------
    //msg list pagination------------------

    $('#data').before('<div id="my_pagination"></div>');
    var rowsShown = 5;
    var rowsTotal = $('#data tbody tr').length;
    console.log("rowsTotal:", rowsTotal);
    var numPages = rowsTotal / rowsShown;

    for (i = 0; i < numPages; i++) {
        var pageNum = i + 1;
        $('#my_pagination').append('<a href="#" rel="' + i + '">' + pageNum + '</a> ');
    }
    $('#data tbody tr').hide();
    $('#data tbody tr').slice(0, rowsShown).show();
    $('#my_pagination a:first').addClass('active');

    if (($("#my_pagination a:first").is(".active")) && ($("#my_pagination a:last").is(".active"))) {

        $("#prev").addClass('disabled');
        $("#next").addClass('disabled');

    } else if (($("#my_pagination a:first").is(".active")) && (!($("#my_pagination a:last").is(".active")))) {
        $("#prev").addClass('disabled');

        $('#next').on('click', function () {
            if (!($("#my_pagination a:last").is(".active"))) {
                $("#prev").removeClass('disabled');

                if ($("#my_pagination a.active").length) {

                    $('#my_pagination a.active').removeClass('active').next().addClass('active');
                    var currPage = $('#my_pagination a.active').attr('rel');
                    var startItem = currPage * rowsShown;
                    var endItem = startItem + rowsShown;
                    $('#data tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).
                        css('display', 'table-row').animate({ opacity: 1 }, 300);
                    // recent page number print
                    var recent_page = $('#my_pagination a.active').html();
                    $('.my_recent_page').text(recent_page);
                }
            }
        });

        $('#prev').on('click', function () {
            if (!($("#my_pagination a:first").is(".active"))) {

                if ($("#my_pagination a.active").length) {
                    $('#my_pagination a.active').removeClass('active').prev().addClass('active');

                    var currPage = $('#my_pagination a.active').attr('rel');
                    var startItem = currPage * rowsShown;
                    var endItem = startItem + rowsShown;
                    $('#data tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).
                        css('display', 'table-row').animate({ opacity: 1 }, 300);
                    // recent page number print
                    var recent_page = $('#my_pagination a.active').html();
                    $('.my_recent_page').text(recent_page);
                }

            }

        });
    }


    //1,2,3,4 clickable pagination(hidden in view page)
    $('#my_pagination a').on('click', function () {

        $('#my_pagination a').removeClass('active');
        $(this).addClass('active');
        var currPage = $(this).attr('rel');
        var startItem = currPage * rowsShown;
        var endItem = startItem + rowsShown;
        $('#data tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).
            css('display', 'table-row').animate({ opacity: 1 }, 300);
    });
    // recent page number print
    var recent_page = $('#my_pagination a.active').html();
    $('.my_recent_page').text(recent_page);
    // total pagecount print
    $('.my_ceil_totalpage').html(pageNum);
    // var ceil_totalpage = Math.ceil(numPages);


    //-----------------pagination-end----------------------//



    //---------------- inbox --------------------------------
    // jQuery('.msg_trash').hide();
    // .on("click", function () {
    jQuery('body').on('click', '#msg_mark', function (event) {
        var clicks = $('#msg_mark').data('clicks');
        if (clicks) {
            // odd /1st clicks
            jQuery('.checkbox').hide();
            jQuery('.msg_trash').addClass('display_none');
        } else {
            // even /1st clicks
            jQuery('.checkbox').show();
            jQuery('.msg_trash').removeClass('display_none');
        }
        $('#msg_mark').data("clicks", !clicks);
    });

    jQuery('body').on('click', '.refresh', function (event) {
        location.reload();
    });
    jQuery('body').on('click', '.alarm', function (event) {
        jQuery('.date_field').toggle();
    });
    $('body').on('mouseenter', '.per_msg_perent', function () {
        $(this).find(".hover_msg_trash").show(0);
        $(this).find(".date_hide").hide(0);
    }).on('mouseleave', '.per_msg_perent', function () {
        $(this).find(".hover_msg_trash").hide(0);
        $(this).find(".date_hide").show();
    });

    //--------msg_box page---------------------------------
    $('body').on('mouseenter', '.msg_view', function () {
        $(this).find(".msg_view_trash").show(0);
    }).on('mouseleave', '.msg_view', function () {
        $(this).find(".msg_view_trash").hide(0);
    });
    $('body').on('mouseenter', '.chatting_lines_sender', function () {
        $(this).find(".msg_view_trash").show(0);
    }).on('mouseleave', '.chatting_lines_sender', function () {
        $(this).find(".msg_view_trash").hide(0);
    });
    $('body').on('mouseenter', '.chatting_lines_receiver', function () {
        $(this).find(".msg_view_trash").show(0);
    }).on('mouseleave', '.chatting_lines_receiver', function () {
        $(this).find(".msg_view_trash").hide(0);
    });
    //
    //--------msg_box > msg_box_popup> hide/show
    //$(".msg_box_popup").addClass("display_none");
    jQuery('body').on('click', '#msg_box_popup_btn', function (event) {
        console.log('hit');
        $(".msg_box_popup_parent .msg_box_popup").removeClass('display_none');
        $("#msg_box_popup_btn").hide();
    });
    //msg_box > msg_box_popup_btn >close icon
    jQuery('body').on('click', '.popup_close', function (event) {
        $(".msg_box_popup_parent .msg_box_popup").addClass('display_none');
        $("#msg_box_popup_btn").show()
    });
    /////////////////////////////////////

    jQuery('body').on('click', '.hi', function (event) {
        var reply_text_line = $(this).text();
        $('#reply_box_summernote').summernote('editor.insertText', reply_text_line);
        $(this).hide();
        // alert(reply_text_line);
        //$('#reply_box_summernote').summernote('insertText', '<p>Hello, world</p>');
        //$("#reply_box_summernote").summernote("pasteHTML", reply_text_line);
        //$("#reply_box_summernote").summernote("code", reply_text_line);
        //$("#reply_box_summernote").code(reply_text_line);
    });

    jQuery('body').on('click', '.collapse_icon', function (event) {
        $(".last_two_reply").hide();
    });
    // end of msg_box page

    //----------- profile page------------------------ //
    $('.info_edit_disabled').addClass('disabled_with_background');
    jQuery('body').on('click', '#edit', function (event) {
        var clicks = $('#edit').data('clicks');
        if (clicks) {
            // odd /1st clicks
            $('.info_edit_disabled').addClass('disabled_with_background');
        } else {
            // even /1st clicks
            $('.info_edit_disabled').removeClass('disabled_with_background');
        }
        $('#edit').data("clicks", !clicks);
    });
    $('.password_edit_disabled').addClass('disabled_with_background');
    jQuery('body').on('click', '#edit_password', function (event) {
        var clicks = $('#edit_password').data('clicks');
        if (clicks) {
            // odd /1st clicks
            $('.password_edit_disabled').addClass('disabled_with_background');
        } else {
            // even /1st clicks
            $('.password_edit_disabled').removeClass('disabled_with_background');
        }
        $('#edit_password').data("clicks", !clicks);
    });
    // nid work
    const id_type = $('#id_type')[0];
    // $('#id_type')[0];  returns a HTML DOM Object like document.getElementById('id_type');
    if (id_type) {
        id_type_first_option = $('#id_type option:nth-child(1)').val();
        console.log(id_type_first_option);
        id_type_selected_option = $('#id_type').find(":selected").val();
        console.log(id_type_selected_option);
        $('#select_alert').on("click", function () {
            if (id_type_first_option == id_type_selected_option) {
                alert("Please Choose ID type");
            } else {
                $("#id_type_click").removeClass('id_type_mandatory');
            }
        });
        $('#id_type').on('change', function (e) {
            id_type_first_option = $('#id_type option:nth-child(1)').val();
            console.log(id_type_first_option);
            id_type_selected_option = $('#id_type').find(":selected").val();
            console.log(id_type_selected_option);

            if (id_type_first_option != id_type_selected_option) {
                $("#id_type_click").removeClass('id_type_mandatory');
            }

        });
    }
    // Residential work
    const ra_type = $('#ra_type')[0];
    // $('#ra_type')[0];  returns a HTML DOM Object like document.getElementById('ra_type');
    if (ra_type) {
        ra_type_first_option = $('#ra_type option:nth-child(1)').val();
        console.log(ra_type_first_option);
        ra_type_selected_option = $('#ra_type').find(":selected").val();
        console.log(ra_type_selected_option);
        $('#select_alert2').on("click", function () {
            if (ra_type_first_option == ra_type_selected_option) {
                alert("Choose document type");
            } else {
                $("#ra_type_click").removeClass('ra_type_mandatory');
            }
        });
        $('#ra_type').on('change', function (e) {
            ra_type_first_option = $('#ra_type option:nth-child(1)').val();
            console.log(ra_type_first_option);
            ra_type_selected_option = $('#ra_type').find(":selected").val();
            console.log(ra_type_selected_option);

            if (ra_type_first_option != ra_type_selected_option) {
                $("#ra_type_click").removeClass('ra_type_mandatory');
            }

        });
    }


    //  ------------------------------------------------- //
    //   -----------(old works)app.blade> popup modal work--------------
    jQuery('body').on('click', '#mypopupBtn', function (event) {
        $("#modal_position_middle").addClass('modal_position');
        $('#modal_position_middle').removeClass('modal_position_reply').removeClass('modal_position_middle');;
        $('.modal-dialog').find(".modal-body").removeClass('reply_modal_body');
        $(".modal-dialog").find("#from").show();
        $(".modal-dialog").find("#text_cc").show();
        $(".modal-dialog").find("#text_bcc").show();
        $(".modal-dialog").find("#subject").show();
        $(".modal-dialog").find(".modal_header").show();

    });
    jQuery('body').on('click', '#large', function (event) {
        $('#modal_position_middle').addClass('modal_position_middle').removeClass('modal_position_reply').removeClass('modal_position');
    });
    jQuery('body').on('click', '#mini', function (event) {
        $('#modal_position_middle').addClass('modal_position').removeClass('modal_position_middle');
    });

    // -----------composer work

    $(".modal-dialog").find("#cc").hide();
    jQuery('body').on('click', '#text_cc', function (event) {
        jQuery('#cc').toggle();
    });
    $(".modal-dialog").find("#bcc").hide();
    jQuery('body').on('click', '#text_bcc', function (event) {
        jQuery('#bcc').toggle();
    });




});


//$("#me").replaceWith("<h6 class='abc'");

// $("#me").each(function () {
//     $("<tr id='me' @if($mail->quick_reply)></tr @endif>").append(this.childNodes).insertBefore(this);
//     $(this).remove();
// });

// $('#me').each(function() {
//     $(this).replaceWith("<tr id='me' @if($mail->quick_reply)>" + $(this).html() + "</tr @endif>");
// });
// check=$(".msg_sender .hidden_msg_quick_reply").text();
// console.log(check);
// if($(".msg_sender .hidden_msg_quick_reply").val()){
//     $(this).html("hi");
//    // $(this).html=("_quickReply");
// }

$('.hidden_msg_quick_reply').each(function (index) {
    if ($(this).text().trim().length) {
        $(this).html("@quickReply");
    }
});
$('.hidden_msg_remainder').each(function (index) {
    if ($(this).text().trim().length) {
        $(this).html("@remainder");
    }
});
$('.hidden_msg_reply_status').each(function (index) {
    console.log('val', $(this).text());
    if ($(this).text() == '') {
        $(this).html("@replyStatus");
    }
});

$('body').on('click', '#quick_reply_check', function (event) {
    if ($("#quick_reply_check").prop('checked') == true) {
        // $("#search").val("@quickReply");
        var value_onclick = $("#search").val() + "@quickReply";
        $(".my_msg_table tr").filter(function () {
            $(this).toggle($(this).text().indexOf(value_onclick) > -1)

        });
    } else {
        var value_onclick = $("#search").val() + " ";
        $(".my_msg_table tr").filter(function () {
            $(this).toggle($(this).text().indexOf(value_onclick) > -1)

        });

    }
});

$('body').on('click', '#no_reply_check', function (event) {
    if ($("#no_reply_check").prop('checked') == true) {
        var value_onclick = $("#search").val() + "@replyStatus";
        console.log(value_onclick);
        $(".my_msg_table tr").filter(function () {
            $(this).toggle($(this).text().indexOf(value_onclick) > -1)

        });
    } else {
        var value_onclick = $("#search").val() + " ";
        $(".my_msg_table tr").filter(function () {
            $(this).toggle($(this).text().indexOf(value_onclick) > -1)

        });

    }
});
$('body').on('click', '#reminder_check', function (event) {
    if ($("#reminder_check").prop('checked') == true) {
        var value_onclick = $("#search").val() + "@remainder";

        $(".my_msg_table tr").filter(function () {
            $(this).toggle($(this).text().indexOf(value_onclick) > -1)

        });
    } else {
        var value_onclick = $("#search").val() + " ";
        $(".my_msg_table tr").filter(function () {
            $(this).toggle($(this).text().indexOf(value_onclick) > -1)

        });

    }

});




