$(function () {
    // check for anchor tag
    hash = window.location.hash.substring(1);

    if (hash.indexOf('cms') >= 0) {
        $(".cms-content").addClass('cms-content-highlight');
        $(".cms-content").addClass('clickable');
        $(".cms-content").click(function () {
            console.log($(this).attr('data-cms-id'));
        });
        $('.cms-identifier').show();
    }
});