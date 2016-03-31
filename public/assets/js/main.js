/**
 * global functions and variables.
 ===============================================================================
 */
// The previous active collapsible-header.
var oldActive = $(".collapsible-header.active");
// Circle progress.
var progressDiv = '<div class="white" id="progressDiv"><div class="preloader-wrapper small active" style="left: 45%"> <div class="spinner-layer spinner-blue"> <div class="circle-clipper left"> <div class="circle"></div> </div><div class="gap-patch"> <div class="circle"></div> </div><div class="circle-clipper right"> <div class="circle"></div> </div> </div> <div class="spinner-layer spinner-red"> <div class="circle-clipper left"> <div class="circle"></div> </div><div class="gap-patch"> <div class="circle"></div> </div><div class="circle-clipper right"> <div class="circle"></div> </div> </div> <div class="spinner-layer spinner-yellow"> <div class="circle-clipper left"> <div class="circle"></div> </div><div class="gap-patch"> <div class="circle"></div> </div><div class="circle-clipper right"> <div class="circle"></div> </div> </div> <div class="spinner-layer spinner-green"> <div class="circle-clipper left"> <div class="circle"></div> </div><div class="gap-patch"> <div class="circle"></div> </div><div class="circle-clipper right"> <div class="circle"></div> </div> </div> </div></div>';

// make collapsible-header inactive.
var hideActiveHeader = function (header) {
    $(header).removeClass("active").parent().removeClass("active").children('.collapsible-body').stop(true, false).slideUp(
        {
            duration: 350,
            easing: "easeOutQuart",
            queue: false,
            complete: function () {
                $(this).css('height', '');
            }
        });
    $(header).children('.summary').removeClass("slideup").stop(true, false).slideDown();
};

/**
 * Get function string used as parameter of new Function(xxx).
 *
 * You may see this fucking code. I can't help it.
 * function must be like
 *
 * function() {
 *     xxx...
 * }
 */
var funcToString = function (func) {
    var funcString = func.toString().substr(15);
    return funcString.substr(0, funcString.length - 1)
};

/**
 * Initialize components after loaded.
 */

$(function() {
    $('.button-collapse').sideNav();
    $('select').material_select();
    $('.markdown-body').find('img').addClass('materialboxed');
    $('.materialboxed').materialbox();
});

/**
 ===============================================================================
 */

$(function () {

    $(document).on('click', 'div', function (e) {

        var active = $(".collapsible-header.active");

        if (oldActive.attr("id") != active.attr("id")) {
            if (oldActive.length > 0) {
                oldActive.children(".summary").removeClass("slideup").stop(true, false).slideDown();
            }
            oldActive = active;
        }

        var activeLi = active.parent();
        var activeLiPosition = activeLi.position();

        // When an article is active, slide up it's summary.
        if (active.length > 0) {
            var articleOpened = true;
            var summary = active.children(".summary");

            // Once click at the range out of active article, remove active.
            if (e.pageY < activeLiPosition.top ||
                e.pageY > activeLiPosition.top + activeLi.height() ||
                e.pageX < activeLiPosition.left ||
                e.pageX > activeLiPosition.left + activeLi.width()) {

                hideActiveHeader(active);

                articleOpened = false;
            }

            if (articleOpened) {
                if (!summary.hasClass("slideup")) {
                    summary.addClass("slideup");
                    summary.stop(true, false).slideUp();
                }
            }
        }
    });

    // Add pageY attribute on collapsible header used to scroll up at the correct position
    $('.collapsible-header').each(function () {
        $(this).attr('pageY', $(this).offset().top);
    });

    // Scroll up
    $('.collapsible-header:not(".no-scroll")').on('click', function () {
        var pageY = $('#' + $(this).attr('id')).attr('pageY');
        var pxToTop = pageY < 200 ? 0 : pageY - 100;
        $('html, body').animate({
            scrollTop: pxToTop
        }, 100);
    });

    // Show post list function.
    var clickToShow = function (old, target) {

        if (old.length > 0) {
            if (target.css('display') == 'block') {
                old.removeClass('active').fadeOut(200);
            } else {
                old.removeClass('active').fadeOut(200, function () {
                    target.addClass('active').fadeIn(1000);
                });
            }
        } else {
            target.addClass('active').fadeIn(1000);
        }
    };

    // tag-chip click event.
    $('.tag-chip').on('click' , function () {
        var old = $('.post-list.active');
        var clickedTag = $(this);
        var target = $('#' + clickedTag.html());

        clickToShow(old, target);
    });


    // date-month click event.
    $('.date-month').on('click', function () {
        var old = $('.post-list.active');
        var clickedMonth = $(this);
        var target = $('#' + clickedMonth.attr('target-list'));

        clickToShow(old, target);
    });

    // favorite post.
    $('.favorite-btn').on('click', function () {
        var btn = $(this);
        var id = $(this).attr('id').substr(9);
        var token = $('input[name="_token"]:first').attr('value');
        var favoriteCount = parseInt(btn.children('span').html()) + 1;
        $.ajax({
            url: '/posts/' + id + '/favorite',
            type: 'put',
            data: '_token=' + token
        }).done(function () {
            btn.hide().parent().append('<a href="javascript:void(0)"><i class="material-icons">favorite</i><span>' + favoriteCount + '</span></a>');
            Materialize.toast('Thanks for your encouragement!', 3000);
        }).fail(function () {
            Materialize.toast('Cannot access now!', 3000);
        });
    });

    $('.captcha-img').on('click', function () {
        $(this).attr("src", '/captcha?' + Math.random());
    });

    $('#search-btn').on('click', function () {
        var nav = $('nav > .container');
        var form = $('.search-form');
        nav.children().fadeOut(0, function(){
            form.show(function () {
                form.find('input#search').focus();
            })
        });

    });

    $('#search').blur(function () {
        var nav = $('nav > .container');
        var form = $('.search-form');
        form.hide();
        nav.children().fadeIn();
    });


    $(':checkbox.put-chk').on('change', function () {
        var part = $('meta[name="page"]').attr('content');
        var id = $(this).attr('value');
        var name = $(this).attr('name');
        var self = $(this);
        var label = self.parent().children('label');
        var token = $('input[name="_token"]').val();

        self.hide();
        label.hide();
        self.parent().append('<i class="material-icons mi-refresh">refresh</i>');

        $.ajax({
            url: '/' + part + '/' + id + '/' + name,
            type: 'put',
            data: '_token=' + token + '&' + name + '=' + this.checked
        }).done(function () {
            $('.mi-refresh').remove();
            self.show();
            label.show();
        }).fail(function () {
            $('.mi-refresh').remove();
            self.show().prop('checked', self.is(':checked') ? null : 'checked');
            label.show();
            Materialize.toast('Toggle failed', 3000);
        });
    });
});