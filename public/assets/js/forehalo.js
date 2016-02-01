var oldActive = $(".collapsible-header.active");

var progressDiv = '<div class="white" id="progressDiv"><div class="preloader-wrapper small active" style="left: 45%"> <div class="spinner-layer spinner-blue"> <div class="circle-clipper left"> <div class="circle"></div> </div><div class="gap-patch"> <div class="circle"></div> </div><div class="circle-clipper right"> <div class="circle"></div> </div> </div> <div class="spinner-layer spinner-red"> <div class="circle-clipper left"> <div class="circle"></div> </div><div class="gap-patch"> <div class="circle"></div> </div><div class="circle-clipper right"> <div class="circle"></div> </div> </div> <div class="spinner-layer spinner-yellow"> <div class="circle-clipper left"> <div class="circle"></div> </div><div class="gap-patch"> <div class="circle"></div> </div><div class="circle-clipper right"> <div class="circle"></div> </div> </div> <div class="spinner-layer spinner-green"> <div class="circle-clipper left"> <div class="circle"></div> </div><div class="gap-patch"> <div class="circle"></div> </div><div class="circle-clipper right"> <div class="circle"></div> </div> </div> </div></div>';

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
});


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

//$(function () {
//    $(".comment-list").append(progressDiv);
//    $.ajax({url: "http://localhost.blog/posts/1/comments", type: "get"}).done(function (data) {
//        $("#progressDiv").remove();
//        for (var i = 0; i < data.length; ++i) {
//            var comment = data[i];
//            var string = '<div id="comment-' + comment.id + '"><a href="' + comment.blog + '" class="comment-title"><i class="material-icons">person</i>' + comment.name + '</a><span> | ' + comment.created_at + ' : </span><a href="javascript:void(0)" class="reply-btn"><i class="material-icons" style="top: 6px;">reply</i></a> <div class="row"> <div class="markdown-body">';
//            if (comment.parent_id !== 0) {
//                string += 'reply <a href="javascript:void(0)" class="reply" pre-comment="' + comment.parent_id + '">@' + comment.parent_name + '</a> :<br/>'
//            }
//            string += (comment.content + '</div> </div> <div class="divider"></div> </div></div>');
//            $(".comment-list").append(string);
//        }
//        $(".reply").on("click", function () {
//            var pre_comment = $("#comment-" + $(this).attr("pre-comment"));
//            var pxToTop = pre_comment.offset().top;
//            $("html, body").animate({scrollTop: pxToTop - 100}, 100);
//            pre_comment.css("background", "#DDD");
//            pre_comment.animate({background: "#FFF"}, 2000, function () {
//                pre_comment.css("background", "#FFF")
//            });
//        });
//        $(".reply-btn").on("click", function () {
//            var hidden = $("input[name=\"parent\"]");
//            hidden.attr("value", $(this).parent().attr("id").substr(8));
//            $("html, body").animate({scrollTop: hidden.parent().offset().top - 100}, 100);
//        });
//    }).fail(function () {
//        $("#progressDiv").remove();
//        Materialize.toast("Fetch Comments Failed", 3000);
//    });
//});