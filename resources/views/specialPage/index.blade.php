@extends('layouts.admin')

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
			<h3>Special Pages</h3>
			<p>Special pages for your website</p>
		</div>
	</div>    
</div>

<div class="row">

    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title">About</h5>
                    </div>
                    <div class="col-6">
                        <input class="radio-switch float-right" type="checkbox" id="enable-about" @if(!empty($meta['enable-about'])) checked @endif /><label for="enable-about">Enable</label>
                    </div>
                </div>
                <p class="card-text">Write something about you. Let people know about the person(s) behind this beautiful blog.</p>
                <a class="card-link" href="{{ route('special-pages-about') }}">Edit</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title">Contact</h5>
                    </div>
                    <div class="col-6">
                        <input class="radio-switch float-right" type="checkbox" id="enable-contact" @if(!empty($meta['enable-contact'])) checked @endif /><label for="enable-contact">Enable</label>
                    </div>
                </div>
                <p class="card-text">Create or Edit contact page for your blog so that your visitors can reach out to you.</p>
                <a class="card-link float-left" href="{{ route('special-pages-contact') }}">Edit</a>
                
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title">Privacy</h5>
                    </div>
                    <div class="col-6">
                        <input class="radio-switch float-right" type="checkbox" id="enable-privacy" @if(!empty($meta['enable-privacy'])) checked @endif /><label for="enable-privacy">Enable</label>
                    </div>
                </div>
                <p class="card-text">Let your visitors know just how protected their personal information is when they visit your site. Remain compliant with FTC, COPPA and other legislators.</p>
                <a class="card-link float-left" href="{{ route('special-pages-privacy') }}">Edit</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title">Terms</h5>
                    </div>
                    <div class="col-6">
                        <input class="radio-switch float-right" type="checkbox" id="enable-terms" @if(!empty($meta['enable-terms'])) checked @endif /><label for="enable-terms">Enable</label>    
                    </div>
                </div>
                <p class="card-text">Enable Terms of Use to prevent abuse of your contents and limit liability.</p>
                <a class="card-link float-left" href="{{ route('special-pages-terms') }}">Edit</a>
            </div>
        </div>
    </div>
</div>
	
@endsection



@section('page.script')
    <script>

        var updateConfig = function () {
            var enable = false, e = $(this), value = {};
            value[this.id] = e.is(":checked")?1:0;
            var param = {
                    "method": "POST",
                    "to": "{{ route('set-config', 'blog') }}",
                    "data": {
                        "value": value
                    },
                    "before": function () {
                        e.addClass('disabled');
                    }, 
                    "success": function () {
                        e.removeClass('disabled');
                    }, 
                    "error": function () {
                        showError ("Could not save the configuration to the server. Try later.")
                        e.removeClass('disabled');
                    }                    
                };
            // console.log(param);
            
            makeAjaxRequest(param);
        }

        $(document).ready(function () { $('input[type=checkbox]').click (updateConfig) });

    </script>

@endsection