
<div class="row">
	<div class="col-md-12">

		<div id="comments-heading" class="border-bottom my-3">
			<b>Comments</b>
		</div>

		@if(Auth::check())
		<div class="comment-strip">
			<img align="left" src="{{Auth::user()->avatar}}" alt="Profile Picture" class="pp-r pp-md mr-3">
			<div style="overflow: hidden">
				<form id="comment-form">
					<input type="hidden" id="pageid" value="{{$page_id}}">
					<div class="form-group">
						<div id="comment-message"></div>
						<textarea id="inputComment" name="text" class="form-control custom-control" placeholder="What is your view?"></textarea>
					</div>
					<div id="comment-btn-span" style="display: none">
						<button type="button" id="btn-comment" class="btn btn-secondary float-right">
							Post Comment
						</button>	
					</div>
				</form>
			</div>
		</div>
		@else 
			<p>
				You need to 
				<a href="#" data-toggle="modal" data-target="#loginModal">log in</a> 
				to post your comments
			</p>

		@endif
	</div>
</div>

		
<div class="row">
	<div class="col-md-12">
		<div id="comments-block"></div>
	</div>
</div>