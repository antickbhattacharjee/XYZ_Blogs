$(document).ready(function() {
    $('.like-btn').click(function(e) {
        e.preventDefault();
        
        var $btn = $(this);
        var postId = $btn.data('post-id');
        var $likeCount = $btn.find('.like-count');
        var $icon = $btn.find('i');

        $.ajax({
            url: 'like_post.php',
            type: 'POST',
            data: { post_id: postId },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    $likeCount.text(response.likes);
                    
                    if(response.action === 'liked') {
                        $icon.removeClass('far').addClass('fas');
                    } else {
                        $icon.removeClass('fas').addClass('far');
                    }
                } else if(response.status === 'unauthorized') {
                    alert('You must be logged in to like posts.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
});
