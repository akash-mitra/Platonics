@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu', ["design" => true])
@endsection


@section('header')
		@include('partials.admin.breadcrumb', ['leafPage' => 'Design'])
@endsection


@section('main')
<div class="row mb-5">
	<div class="col-md-12">
        <h4>How do you want your blog to look like?</h4>  
        
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true">General</a>
                <a class="nav-item nav-link" id="nav-layout-tab" data-toggle="tab" href="#nav-layout" role="tab" aria-controls="nav-layout" aria-selected="false">Layout</a>
                <a class="nav-item nav-link active" id="nav-color-tab" data-toggle="tab" href="#nav-color" role="tab" aria-controls="nav-color" aria-selected="false">Color</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">

            <!-- GENERAL SECTION STARTS -->
            <div class="tab-pane fade" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
                <div class="card">
                    <div class="card-header">
                        Blog Name and Title
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="inputBlogName">Blog Name</label>
                                <input name="blogName" type="text" class="form-control" id="inputBlogName" aria-describedby="blogNameHelp" placeholder="What do you call your blog?" value="{{ (isset($meta['blogName'])? $meta['blogName'] : '') }}">
                                <small id="blogNameHelp" class="form-text text-muted">Think about something sweet and short, ideally within 30 characters. This can be same as your domain name.</small>
                            </div>
                            <div class="form-group">
                                <label for="inputBlogDescription">Description</label>
                                <textarea name="blogDesc" class="form-control" id="inputBlogDescription" aria-describedby="blogDescHelp" rows="3">{{ (isset($meta['blogDesc'])? $meta['blogDesc'] : '') }}</textarea>
                                <small id="blogDescHelp" class="form-text text-muted">Blog description is used as the default meta description of your blog pages</small>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button id="btnSaveBlogName" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
            <!-- GENERAL SECTION ENDS -->

            <!-- LAYOUT SECTION STARTS -->
            <div class="tab-pane fade" id="nav-layout" role="tabpanel" aria-labelledby="nav-layout-tab">
                <div class="card">
                    <div class="card-header">
                        Blog layout 
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4 text-center">
                                <h4>Content Left</h4>
                                <i class="flaticon-layout-2" style="font-size: 100px"></i>
                                <br>
                                <p>
                                    Contents will be placed on the left side whereas the right column
                                    will be used to place secondary contents.
                                </p>
                                @if(isset($meta['layout']) && $meta['layout'] == 'left')
                                    <button data-layout="left" class="btn btn-success disabled selected-layout">Selected</button>
                                @else
                                    <button data-layout="left" class="btn btn-outline-primary layout">Select</button>
                                @endif
                            </div>

                            <div class="col-md-4 text-center">
                                <h4>Content Center</h4>
                                <i class="flaticon-layout mx-auto" style="font-size: 100px"></i>
                                <br>
                                <p>
                                    Contents will be placed in the center. 2 columns
                                    on the sides can be used to place secondary contents or left blank
                                </p>
                                @if(isset($meta['layout']) && $meta['layout'] == 'center')
                                    <button data-layout="center" class="btn btn-success disabled selected-layout">Selected</button>
                                @else
                                    <button data-layout="center" class="btn btn-outline-primary layout">Select</button>
                                @endif
                            </div>

                            <div class="col-md-4 text-center">
                                <h4>Content Right</h4>
                                <i class="flaticon-layout-1" style="font-size: 100px"></i>
                                <br>
                                <p>
                                    Contents will be placed on the right side whereas the left column
                                    will be used to place secondary contents.
                                </p>
                                @if(isset($meta['layout']) && $meta['layout'] == 'right')
                                    <button data-layout="right" class="btn btn-success disabled selected-layout">Selected</button>
                                @else
                                    <button data-layout="right" class="btn btn-outline-primary layout">Select</button>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- LAYOUT SECTION ENDS -->

            <!-- COLOR SECTION STARTS -->
            <div class="tab-pane fade show active" id="nav-color" role="tabpanel" aria-labelledby="nav-color-tab">
                <div class="card">
                    <div class="card-header">
                        Select the color scheme for your blog
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Primary Background Color</h5>
                                <p>
                                    This color is meant to be used as the basic underlying color of your blog.
                                    It is applied via the CSS class <code>bg-color-primary</code>, which is used 
                                    in the HTML <code>body</code> of the page. 
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="row d-flex justify-content-center">
                                    <div data-color="#FFFFFF" class="col-2 border bg-color-primary @if(isset($meta['bg-color-primary']) && $meta['bg-color-primary'] === '#FFFFFF') border-primary @endif m-1" style="height: 5rem; background-color: #FFFFFF; cursor: pointer"></div>
                                    <div data-color="#F9F9F9" class="col-2 border bg-color-primary @if(isset($meta['bg-color-primary']) && $meta['bg-color-primary'] === '#F9F9F9') border-primary @endif m-1" style="height: 5rem; background-color: #F9F9F9; cursor: pointer"></div>
                                    <div data-color="#F7F8F9" class="col-2 border bg-color-primary @if(isset($meta['bg-color-primary']) && $meta['bg-color-primary'] === '#F7F8F9') border-primary @endif m-1" style="height: 5rem; background-color: #F7F8F9; cursor: pointer"></div>
                                    <div data-color="#EDEFF0" class="col-2 border bg-color-primary @if(isset($meta['bg-color-primary']) && $meta['bg-color-primary'] === '#EDEFF0') border-primary @endif m-1" style="height: 5rem; background-color: #EDEFF0; cursor: pointer"></div>    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- COLOR SECTION ENDS -->


            <!-- <div class="tab-pane fade" id="nav-color" role="tabpanel" aria-labelledby="nav-color-tab">...</div> -->
        </div>


	</div>
</div>



<div class="row mb-5">
	<div class="col-md-12">
		
        
        
	</div>
</div>
@endsection


@section('page.script')

    <script>

        /**
         * Handy function to update blog config
         */
        var updateBlogConfig = function (arrayValue, before, success, error) {
            var param = {
                    "method": "POST",
                    "to": "{{ route('set-config', 'blogmeta') }}",
                    "data": {"value": arrayValue},
                    "before": before, 
                    "success": success, 
                    "error": error                 
                };

            makeAjaxRequest (param)
        }


        /**
         * Saves the blog description and name
         */
        var saveBlogInfo = function () {
            var btn = $(this);
            var before = function () {btn.addClass('disabled').text('Saving...')},
                success = function () {btn.removeClass('disabled').text('Save')},
                error = function () {
                    showError ("Could not save the blog info to server. Try later."); 
                    btn.removeClass('disabled').text('Save')
                };

            updateBlogConfig ({
                "blogName": $('#inputBlogName').val(),
                "blogDesc": $('#inputBlogDescription').val()
            }, before, success, error)
        }


        /**
         * Saves blog layout
         */
        var changeLayout = function () {
            var btn = $(this);
            var before = function () {btn.addClass('disabled').text('Saving...')},
            success = function () {
                $('.selected-layout').removeClass('btn-success selected-layout disabled').addClass('btn-outline-primary layout').text('select');
                btn.removeClass('btn-outline-primary layout').addClass('btn-success selected-layout').text('selected');
            },
            error = function () {
                showError ("Could not save the setting to server. Try later.")
                btn.removeClass('disabled').text('Select');
            };
            updateBlogConfig ({
                "layout": btn.data("layout")
            }, before, success, error);
        }


        /**
         * Saves background color of the blog
         */
        var changeColorCode = function () {
            var item = $(this);
            var before = function () {$(".bg-color-primary").removeClass('border-primary').text('Wait...')},
                success = function () {$(".bg-color-primary").text(''); item.addClass('border-primary')},
                error = function () { 
                    showError ("Could not save the blog info to server. Try later."); 
                    $(".bg-color-primary").text("Error");
                }   
            updateBlogConfig ({
                "bg-color-primary": item.data('color')
            }, before, success, error);
        }



        $(document).ready(function () {
            $('#btnSaveBlogName').click(saveBlogInfo); 
            $(".layout, .selected-layout").click (changeLayout);
            $(".bg-color-primary").click (changeColorCode);
        })
    </script>
@endsection