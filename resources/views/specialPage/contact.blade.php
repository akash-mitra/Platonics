@extends('layouts.admin')

@section('page.css')
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@5.23.0/dist/css/themes/beagle.min.css" type="text/css" media="screen">
@endsection

@section('aside')
	@include('partials.admin.menu', ["special" => true])
@endsection

 
@section('header')
	@include('partials.admin.breadcrumb', ['leafPage' => 'Special Pages'])
@endsection


@section('main')	

<div class="row mb-1">
	<div class="col-md-12">
		<div class="float-left">
			<h3>Contact Page</h3>
			<p>How does your audience reach out to you?</p>
		</div>
    </div>
</div>

<div class="row mb-5">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
                <h5 id="pageHeader" class="border-bottom mb-5">{!! $name !!}</h5>
				<div id="pageBody" class="border-bottom mb-3">{!! $content !!}</div>

                <!-- <div class="row">
                    <div class="col-md-4">
                        <div class="bg-light p-3 my-3">
                            <h6>Email</h6>
                            <p class="border-bottom" id="email">{!! $email !!}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 my-3">
                            <h6>Twitter</h6>
                            <p class="border-bottom" id="twitter">{!! $twitter !!}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 my-3">
                            <h6>Address</h6>
                            <p class="border-bottom" id="address">{!! $address !!}</p>
                        </div>
                    </div>
                    
                </div> -->
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary" onclick="saveContents()">Save</button>
                <span id="when-updated" class="float-right">Updated {{ $updated_at }}</span>
            </div>
        </div>
    </div>
</div>

@endsection



@section('page.script')

    <script src="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js"></script>
    <script>
        var contactHead = new MediumEditor('#pageHeader', {
			toolbar: false,
			paste: { cleanPastedHTML: true, forcePlainText: true },
			placeholder: { text: 'Provide Contact Page Heading...' }
        });
        
        var contactBody = new MediumEditor('#pageBody', {
			delay: 1000,
			toolbar: {
				buttons: ['bold', 'italic', 'underline', 'anchor',  'h4'],
			},
			paste: { cleanPastedHTML: true },
			anchorPreview: { hideDelay: 300 },
			placeholder: { text: 'Provide Contact Page Details (Optional)' }
        });
        
        // var contactEmail = new MediumEditor('#email', {
		// 	toolbar: false,
		// 	paste: { cleanPastedHTML: true, forcePlainText: true },
		// 	placeholder: { text: 'Your email ID (optional)' }
        // });

        // var contactTwitter = new MediumEditor('#twitter', {
		// 	toolbar: false,
		// 	paste: { cleanPastedHTML: true, forcePlainText: true },
		// 	placeholder: { text: 'Twitter Handle (Optional)' }
        // });

        // var contactAddress = new MediumEditor('#address', {
		// 	toolbar: false,
		// 	paste: { cleanPastedHTML: true, forcePlainText: true },
		// 	placeholder: { text: 'Your address (Optional)' }
        // });



        var saveContents = function () {
            
            
			var btn = $(this);
			
			var data = {
				header: $('#pageHeader').text(),
                markup: {
                    content: contactBody.getContent()
                    // email: $('#email').text(), 
                    // twitter: $('#twitter').text(), 
                    // address: contactAddress.getContent(), 
                }
			}
            
            
			makeAjaxRequest ({
				method: "post",
				data: data,
				to: "{{route('special-pages-contact-save')}}",
				before: function () {
					btn.addClass('disabled').html('<i class="batch-icon batch-icon-compose-alt-3"></i>&nbsp;Saving...');
				},
				success: function (data) {
                        btn.removeClass('disabled').html('<i class="batch-icon batch-icon-compose-alt-3"></i>&nbsp;Save');;
                        $('#when-updated').text ('Updated ' + data.data.updated_at);
				},
				error: function (data) {
					showError("Something went wrong. Failed to save.")
				}
			})
        }
    </script>
@endsection