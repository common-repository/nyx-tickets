jQuery(document).ready(function ($) {

    /**
     * Loop over all nyx event placeholders on page and populate them.
     */
    $('body .nyx-event-placeholder').each(function () {

        var ctx = $(this);

        var url = new URL(ajaxurl);

        url.searchParams.append('action', 'nyx_ticket_view');
        url.searchParams.append('post', $(this).attr('data-post-id'));
        url.searchParams.append('view', $(this).attr('data-view'));

        $.get(url).done(function (res) {
            ctx.html(res);
        });

    });
	
	
	$(document).on('click','.show-more-events',function() {

		$(this).closest('.nyx-event-placeholder').find('.nyx-event').css('display','block');
		
		$(this).remove();
	});

});
