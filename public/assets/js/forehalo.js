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
 ===============================================================================
 */

$(function () {

    $(document).click(function (e) {

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
    $(document).on('click', '.collapsible-header', function () {
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
    $(document).on('click', '.tag-chip', function () {
        var old = $('.post-list.active');
        var clickedTag = $(this);
        var target = $('#' + clickedTag.html());

        clickToShow(old, target);
    });


    // date-month click event.
    $(document).on('click', '.date-month', function () {
        var old = $('.post-list.active');
        var clickedMonth = $(this);
        var target = $('#' + clickedMonth.attr('target-list'));

        clickToShow(old, target);
    });

    // favorite post.
    $(document).on('click', '.favorite-btn', function () {
        var btn = $(this);
        var id = $(this).attr('id').substr(9);
        var token = $('input[name="_token"]:first').attr('value');
        var favoriteCount = parseInt(btn.children('span').html()) + 1;
        $.ajax({
            url: '/posts/' + id + '/favorite',
            type: 'put',
            data: '_token=' + token
        }).done(function () {
            btn.hide().parent().append('<a href="javascript:void(0)"><i class="material-icons">favorite</i><span>' + favoriteCount +'</span></a>');
            Materialize.toast('Thanks for your encouragement!', 3000);
        }).fail(function(){
            Materialize.toast('Cannot access now!', 3000);
        });
    });
})
;


$(function () {
    runPreview = function () {
        var replyContent = $("#reply_content");
        var oldContent = replyContent.val();
        console.log(oldContent);

        if (oldContent) {
            marked(oldContent, function (err, content) {
                $('#preview-box').html(content);
            });
        }
    };

    $("#reply_content").on("keyup", function () {
        runPreview();
    });

    $("#reply_content").focus(function (event) {
        $("#preview-box").css("display", 'block');
    });


});