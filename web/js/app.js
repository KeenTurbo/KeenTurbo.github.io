$('.action-cancel-comment').on('click', function () {
    $('.post .quote').remove();
    $('#comment_parent_id').removeAttr('value');
});