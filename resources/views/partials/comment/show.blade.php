<hr>
<div class="row">
	<div class="col-md-12">
		<h2>
			Comments
			<br>
			<small>
				Share your opinion. Join the discussion.
			</small>
		</h2>
		@if(Auth::check())
			<div class="comment-strip">
				<img align="left" src="{{Auth::user()->avatar}}">
				<div style="overflow: hidden">
					<form id="comment-form">
						<input type="hidden" id="pageid" value="{{$page->id}}">
						<div class="form-group">
						    <div id="comment-message"></div>
						    <textarea 
						    	class="form-control custom-control" 
						    	id="inputComment" 
						    	placeholder="What is your view?"
						    	name="text"></textarea>
						</div>
						<div id="comment-btn-span" style="display: none">
							<a id="btn-comment" class="btn btn-success pull-right">
								<i id="btn-icon" class="fa fa-comment-o fa-fw"></i>&nbsp;
								Post 
							</a>	
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