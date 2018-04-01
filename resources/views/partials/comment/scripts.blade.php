<script>
	let lastComment = '';

	// handy function to generate a single comment strip
	function generateCommentStrip (userName, userProfile, userAvatar, comment, ago = null)
	{
		return '<div class="comment-strip my-2 py-2 border-top">'
				+ '<img class="pp-r pp-sm mr-3" alt="Profile Pic" align="left" src="' 
					+ (userAvatar === null? '/img/no-dp.png': userAvatar) 
				+ '"/>'
				+ '<div style="overflow: hidden">' 
						+ '<div class="text-muted w-100">'
							+ '<a href="' + userProfile + '"><b>' + userName + '</b></a>'
							+ '<span class="post-time float-right' 
								+ (ago===null?' saving">Saving...':'">' + ago)
							+ '</span>'
						+ '</div>'
						+ '<div class="w-100">'
							+ '' 
							+ comment 
						+ '</div>'
				+ '</div>'
			+'</div>';
	}

	// This is triggered when comment save button is clicked
	@if(Auth()->check())
		$('#btn-comment').click (function(){ 

			// let us save the comment in a global variable
			// so that we can use it later to repopulate the
			// textarea if comment saving fails this time.
			// that way, user will not have to type it again
			// if server fails to save.
			lastComment = $('#inputComment').val();

			// reject if comment is too short
			if(lastComment.length <= 1) {
				alert('Comment too short for posting');
				return;
			}

			// create the saving related parameters
			savingsParams.data = {
				"text": lastComment,     // no need to escape HTML during ingestion
				"pageid": $('#pageid').val(),
			};

			// add the comment immediately to the comment block
			let strip = generateCommentStrip("{{{Auth::user()->name}}}", 
				"{{{Auth::user()->url}}}", 
				"{{{Auth::user()->avatar}}}", 
				escapeHTML(lastComment)); // escaping required as comment is dynamically added to the page

			$(strip).addClass('highlighter').prependTo('#comments-block').hide().slideDown();

			// empty out the commenting box 
			$('#inputComment').val('');
			
			
			// then make actual ajax request to save the comment in server
			makeAjaxRequest(savingsParams); 
		});
	@endif

	$(document).ready(function () {

		// Shows the comment post button only when
		// comments are typed in the comment box
		$('#inputComment')
			.click(function(){$('#comment-btn-span').slideDown();});
		
		// Enable loading of comments when user scrolls the page
		// to make the comments-block visible
		runOnceInView($("#comments-block"), function () { 
			makeAjaxRequest(retrieveParams); 
		});
	});

	function displayComments (comments, el) {
		el = $(el);
		let buff = '';
		for (let i = 0, l = comments.length; i < l; i++) {
			let comment = comments[i];
			buff += generateCommentStrip (comment.user.name, comment.user.profile, comment.user.avatar, comment.text, comment.when);
		}
		el.html(buff);
	}

	var bs = function () {
		$('#btn-icon').removeClass('fa-comment-o').addClass('fa-spinner');
		$('#btn-comment').addClass('disabled');
		$('.error-strip').parent().parent().remove();
	}

	
	let e = function (r) {
		$('#btn-comment').removeClass('disabled');
		$('#btn-icon').addClass('fa-comment-o').removeClass('fa-spinner');
		let e = $('.saving');
		e.html('<i class="fa fa-exclamation-triangle text-danger"></i> Failed to save. Please retry.')
		 .addClass('error-strip')
		 .removeClass('saving');

		// re-populate the textarea with the last comment
		$('#inputComment').val(lastComment);
	}

	let s = function (r) {
		$('#btn-comment').removeClass('disabled');
		$('#btn-icon').addClass('fa-comment-o').removeClass('fa-spinner');
		let e = $('.saving');
		e.html('<i class="fa fa-clock-o"></i>&nbsp;Saved successfully');
		setTimeout(function(){
		  e.html('<i class="fa fa-clock-o"></i>&nbsp;Just now')
		   .removeClass('saving');
		}, 1000);
	}

	let savingsParams = {
			method: 'post',
			to: "{{route('comments-store')}}",
			before: bs,
			success: s,
			error: e,
	};

	let retrieveParams = {
		method: 'get',
		to: "{{route('comments-on-page', $page_id)}}",
		before: function () {
		$('#comments-heading').html('Fetching article comments...');	
		},
		success: function (r) {
			displayComments (r, '#comments-block');
			$('#comments-heading').html('<b>Comments</b>');
		},
		error: function () {
			$('#comments-heading').html('Failed to load comments from server');
			alert('Error retrieving comments of this page');},
	}
		
</script>