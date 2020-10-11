/*
 *
 *   INSPINIA - Responsive Admin Theme
 *   version 2.2
 *
 */

$(document).ready(function () {

    // Add body-small class if window less than 768px
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }

  // add a hash to the URL when the user clicks on a tab
  $('a[data-toggle="tab"]').on('click', function(e) {
    window.location.href = $(this).attr('href');
  });
  // if (location.hash != '') {
  //  var activebsTab = $('.nav-tabs a[href=' + location.hash + ']');
  //    if (activebsTab.length) {
  //      activebsTab.tab('show');
  //    } else {
  //      $('.nav-tabs a:first').tab('show');
  //    }
  //   }
  // navigate to a tab when the history changes
  /*window.addEventListener("popstate", function(e) {
    var activeTab = $('[href=' + location.hash + ']');
    if (activeTab.length) {
      activeTab.tab('show');
    } else {
      $('.nav-tabs a:first').tab('show');
    }
  });*/

    // MetsiMenu
    $('#side-menu').metisMenu();

    // Collapse ibox function
    $('.collapse-link').click( function() {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.find('div.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('.close-link').click( function() {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Close menu in canvas mode
    $('.close-canvas-menu').click( function() {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
    });

    // Open close right sidebar
    $('.right-sidebar-toggle').click(function(){
        $('#right-sidebar').toggleClass('sidebar-open');
    });

    // Initialize slimscroll for right sidebar
    $('.sidebar-container').slimScroll({
        height: '100%',
        railOpacity: 0.4,
        wheelStep: 10
    });

    // Open close small chat
    $('.open-small-chat').click(function(){
        $(this).children().toggleClass('fa-comments').toggleClass('fa-remove');
        $('.small-chat-box').toggleClass('active');
    });

    // Initialize slimscroll for small chat
    $('.small-chat-box .content').slimScroll({
        height: '234px',
        railOpacity: 0.4
    });

    // Small todo handler
    $('.check-link').click( function(){
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });

    // Minimalize menu
    $('.navbar-minimalize').click(function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();

    });

    $(document).tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    // Move modal to body
    // Fix Bootstrap backdrop issu with animation.css
    $('.modal').appendTo("body");

    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarHeigh = $('nav.navbar-default').height();
        var wrapperHeigh = $('#page-wrapper').height();

        if(navbarHeigh > wrapperHeigh){
            $('#page-wrapper').css("min-height", navbarHeigh + "px");
        }

        if(navbarHeigh < wrapperHeigh){
            $('#page-wrapper').css("min-height", $(window).height()  + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            $('#page-wrapper').css("min-height", $(window).height() - 60 + "px");
        }

    }
    fix_height();

    // Fixed Sidebar
    $(window).bind("load", function () {
        if ($("body").hasClass('fixed-sidebar')) {
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }
    })

    // Move right sidebar top after scroll
    $(window).scroll(function(){
        if ($(window).scrollTop() > 0 && !$('body').hasClass('fixed-nav') ) {
            $('#right-sidebar').addClass('sidebar-top');
        } else {
            $('#right-sidebar').removeClass('sidebar-top');
        }
    });

    $(window).bind("load resize scroll", function() {
        if(!$("body").hasClass('body-small')) {
            fix_height();
        }
    });

    $("[data-toggle=popover]")
        .popover();

    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    });

    $('.chosen-select').chosen();

    /*
    * Competitions
    */
    $('body').on('click', '[data-action="competition-delete"]', function(e) {
        e.preventDefault();

        var t = $(this);
        var com_id = $(this).attr('data-competition-id');
        swal({
            title: t.attr('data-competition-name'),
            text: L_COMP_DELETE_CONFIRM,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ec4758",
            confirmButtonText: L_ANOV,
            cancelButtonText: L_ZRUSIT,
            closeOnConfirm: false,
            html: true,
        }, function () {
            $.ajax({
                url: S_HOST+'/ajax/load.php',
                type: "POST",
                data: 'data='+JSON.stringify({"mode":"competitionDelete", "com_id":com_id}),
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.status == 100) {
                        swal(L_COMP_DELETED, "", "success");
                        t.closest('table').find('tr[data-competition-id="'+com_id+'"]').fadeOut(200, function() {
                            $(this).next('.footable-row-detail').remove();
                            $(this).remove();
                        });
                    } else if (data.status == 200) {
                        swal("{L_CHYBA}", data.msg, "error");
                    } else {
                        alert(data.msg);
                    }
                },
                error : function (e) {
                    console.log(e.responseText);
                }
            });


        });
    });

    /*
    * Groups
    */
    $('body').on('click', '[data-action="group-delete"]', function(e) {
        e.preventDefault();

        var t = $(this);
        var group_id = $(this).attr('data-group-id');
        swal({
            title: t.attr('data-group-name'),
            text: L_GROUP_DELETE_CONFIRM,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ec4758",
            confirmButtonText: L_ANOV,
            cancelButtonText: L_ZRUSIT,
            closeOnConfirm: false,
            html: true,
        }, function () {
            $.ajax({
                url: S_HOST+'/ajax/load.php',
                type: "POST",
                data: 'data='+JSON.stringify({"mode":"groupDelete", "group_id":group_id}),
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.status == 100) {
                        swal(L_GROUP_DELETED, "", "success");
                        t.closest('table').find('tr[data-group-id="'+group_id+'"]').fadeOut(200, function() {
                            $(this).next('.footable-row-detail').remove();
                            $(this).remove();
                        });
                    } else if (data.status == 200) {
                        swal("{L_CHYBA}", data.msg, "error");
                    } else {
                        alert(data.msg);
                    }
                },
                error : function (e) {
                    console.log(e.responseText);
                }
            });


        });
    });

    /*
    * Shows
    */
    $('body').on('click', '[data-action="show-delete"]', function(e) {
        e.preventDefault();

        var t = $(this);
        var show_id = $(this).attr('data-show-id');
        swal({
            title: t.attr('data-show-name'),
            text: L_SHOW_DELETE_CONFIRM,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ec4758",
            confirmButtonText: L_ANOV,
            cancelButtonText: L_ZRUSIT,
            closeOnConfirm: false,
            html: true,
        }, function () {
            $.ajax({
                url: S_HOST+'/ajax/load.php',
                type: "POST",
                data: 'data='+JSON.stringify({"mode":"showDelete", "show_id":show_id}),
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.status == 100) {
                        swal(L_SHOW_DELETED, "", "success");
                        t.closest('table').find('tr[data-show-id="'+show_id+'"]').fadeOut(200, function() {
                            $(this).next('.footable-row-detail').remove();
                            $(this).remove();
                        });
                    } else if (data.status == 200) {
                        swal("{L_CHYBA}", data.msg, "error");
                    } else {
                        alert(data.msg);
                    }
                },
                error : function (e) {
                    console.log(e.responseText);
                }
            });


        });
    });

    $('body').on('click', '[data-action="signup-mark-paid"]', function(e) {
        e.preventDefault();

        var t = $(this);
        var sign_id = $(this).attr('data-signup-id');
            t.prop('disabled', true);

        $.ajax({
            url: S_HOST+'/ajax/load.php',
            type: "POST",
            data: 'data='+JSON.stringify({"mode":"signupPaid", "signup_id":sign_id}),
            dataType: 'json',
            success: function (data) {
                if (data.status == 100) {
                    var row = t.closest('table').find('tr[data-signup-id="'+sign_id+'"]');
                        row.find('[data-action="signup-mark-paid"]').toggleClass('btn-primary btn-danger');

                    var state = row.find('[data-ajax="paidState"]');
                    state.html('<span class="label label-'+data.class+'">'+data.state+'</span>');
                    $('[data-ajax="stats-paid"]').html(data.stats.paid);
                    $('[data-ajax="stats-sum"]').html(data.stats.sum);
                    $('[data-ajax="stats-percentage"]').css('width', data.stats.percentage + '%');
                } else if (data.status == 200) {
                    console.log(data);
                    swal(L_ERROR, data.msg, "error");
                } else {
                    console.log(data.status);
                    alert(data.msg);
                }

                t.prop('disabled', false);
            },
            error : function (e) {
                console.log(e);
                t.prop('disabled', false);
            }
        });
    });

    $('body').on('click', '[data-action="signup-delete"]', function(e) {
        e.preventDefault();

        var t = $(this);
        var sign_id = $(this).attr('data-signup-id');
        var show_id = $(this).attr('data-show-id');
        swal({
            title: t.attr('data-signup-name'),
            text: L_CHOREO_DELETE_CONFIRM.replace(/%s/g, t.attr('data-signup-group')),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ec4758",
            confirmButtonText: L_ANOV,
            cancelButtonText: L_ZRUSIT,
            closeOnConfirm: false,
            html: true,
        }, function () {
            $.ajax({
                url: S_HOST+'/ajax/load.php',
                type: "POST",
                data: 'data='+JSON.stringify({"mode":"signUpDelete", "sign_id":sign_id, "show_id":show_id}),
                dataType: 'json',
                success: function (data) {
                    if (data.status == 100) {
                        swal(L_CHOREO_ODSTRANENA, "", "success");
                        t.closest('table').find('tr[data-signup-id="'+sign_id+'"]').fadeOut(200, function() {
                            $(this).next('.footable-row-detail').remove();
                            $(this).remove();
                        });
                        $('[data-ajax="stats-paid"]').html(data.stats.paid);
                        $('[data-ajax="stats-sum"]').html(data.stats.sum);
                        $('[data-ajax="stats-percentage"]').css('width', data.stats.percentage + '%');
                    } else if (data.status == 200) {
                        swal("{L_CHYBA}", data.msg, "error");
                    } else {
                        alert(data.msg);
                    }
                },
                error : function (e) {
                    console.log(e.responseText);
                }
            });
        });
    });



    $('body').on('click', '[data-login-as-another-user]', function(e) {
        e.preventDefault();

        var t = $(this);
        var another_user_id = $(this).attr('data-login-as-another-user');
        $.ajax({
            url: S_HOST+'/ajax/load.php',
            type: "POST",
            data: 'data='+JSON.stringify({"mode":"loginAsAnotherUser", "userId":another_user_id}),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.status == 100) {
                    location.reload();
                } else if (data.status == 200) {
                    swal('L_CHYBA', data.msg, "error");
                } else {
                    alert(data.msg);
                }
            },
            error : function (e) {
                console.log(e.responseText);
            }
        });
    });

    $('[data-popover-show="true"]').popover('show');

});

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

// Minimalize menu when screen is less than 768px
$(window).bind("resize", function () {
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

$(window).on('load', function() {
    if(window.location.hash) {
        var hash_data = {};
        $.each(window.location.hash.replace("#", "").split("&"), function (i, value) {
            value = value.split("=");
            hash_data[value[0]] = value[1];
        });

        if(hash_data.filter !== null) {
            $('table').trigger('footable_filter', {filter:decodeURIComponent(hash_data.filter)});
        }


        if(hash_data.group_id !== null) {
            $('select[name="show_group_id"], select[name="sign_group_id"]').val(hash_data.group_id);
            $('select[name="show_group_id"], select[name="sign_group_id"]').trigger("chosen:updated").trigger('change');
        }

        if(hash_data.show_id !== null) {
            // $('select[name="show_group_id"]').val(hash_data.show_id);
            // $('select[name="show_group_id"]').trigger("chosen:updated").trigger('change');
        }

        if ($('form[name="competitionSignUp"]').length) {
            if(hash_data.group_id !== null) {
                $.ajax({
                    url: S_HOST+'/ajax/load.php',
                    type: "POST",
                    data: 'data='+JSON.stringify({"mode":"loadShows", "groupID":hash_data.group_id}),
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 100) {
                            $('select[name="sign_show_id"]').html('<option></option>');
                            $.each(data.data, function(i, item) {
                                $('select[name="sign_show_id"]').append('<option value="'+item.show_id+'">'+item.show_name+' - '+item.show_discipline+'</option>');
                            });
                                if(hash_data.show_id !== null) {
                                    $('select[name="sign_show_id"]').val(hash_data.show_id);
                                }
                            $('select[name="sign_show_id"]').trigger("chosen:updated").trigger('change');
                        } else if (data.status == 200) {
                            swal(L_CHYBA, data.msg, "error");
                        } else {
                            alert(data.msg);
                        }
                    },
                    error : function (e) {
                        console.log(e.responseText);
                    }
                });
            }
        }
    }
});

// For demo purpose - animation css script
function animationHover(element, animation){
    element = $(element);
    element.hover(
        function() {
            element.addClass('animated ' + animation);
        },
        function(){
            //wait for animation to finish before removing classes
            window.setTimeout( function(){
                element.removeClass('animated ' + animation);
            }, 2000);
        });
}

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(500);
            }, 100);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(500);
            }, 300);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

function generatePassword() {
    var length = 8,
        charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

$(document).on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed check ', 'input', function(event){
        if(event.type ==="ifChecked"){
            $(this).trigger('click');
            $('input').iCheck('update');
        }
        if(event.type ==="ifUnchecked"){
            $(this).trigger('click');
            $('input').iCheck('update');
        }
        if(event.type ==="ifDisabled"){
            // console.log($(this).attr('id')+'dis');
            $('input').iCheck('update');
        }
    }).iCheck({
        checkboxClass: 'icheckbox_minimal-green',
        radioClass: 'iradio_minimal-green'
            //increaseArea: '20%'
    });
