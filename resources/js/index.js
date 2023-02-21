$(function () {
    $(".ac-child").css("display", "none");
    $(".ac-parent").on("click", function () {
        $(this).next().slideToggle();
    });
});
