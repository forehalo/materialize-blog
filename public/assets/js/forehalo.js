var oldActive = $(".collapsible-header.active");

$(function () {
    $("body").click(function (e) {

        var active = $(".collapsible-header.active");

        if (oldActive.attr("id") != active.attr("id")) {
            if (oldActive.length > 0) {
                oldActive.children(".summary").removeClass("slideup").stop(true, false).slideDown();
            }
            oldActive = active;
        }

        var activeLi = active.parent();
        var activeLiPosition = activeLi.position();

        // when an article is active, slide up it's summary.

        if (active.length > 0) {
            var articleOpened = true;
            var summary = active.children(".summary");

            // on click at the range out of active article, remove active.
            if (e.pageY < activeLiPosition.top ||
                e.pageY > activeLiPosition.top + activeLi.height() ||
                e.pageX < activeLiPosition.left ||
                e.pageX > activeLiPosition.left + activeLi.width()) {

                active.removeClass("active").parent().removeClass("active").children('.collapsible-body').stop(true, false).slideUp(
                    {
                        duration: 350,
                        easing: "easeOutQuart",
                        queue: false,
                        complete: function () {
                            $(this).css('height', '');
                        }
                    });
                summary.removeClass("slideup").stop(true, false).slideDown();
                //console.log(2);
                articleOpened = false;
            }

            if (articleOpened) {
                if (!summary.hasClass("slideup")){
                    summary.addClass("slideup");
                    summary.stop(true, false).slideUp();
                }
            }
        }
    });
});


$(function(){
    runPreview = function() {
        var replyContent = $("#reply_content");
        var oldContent = replyContent.val();
        console.log(oldContent);

        if (oldContent) {
            marked(oldContent, function (err, content) {
                $('#preview-box').html(content);
            });
        }
    };

    $("#reply_content").on("keyup", function(){
        runPreview();
    });

    $("#reply_content").focus(function(event){
        $("#preview-box").css("display", 'block');
    });


});