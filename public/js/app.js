var gebi = function (id) { return document.getElementById(id); };

/*
 |--------------------------------------------------------------------------
 | This function is used to validate a bootstrap based
 | form in the brwoser. The form element needs to be 
 | passed as an argument to this function. If the
 | form contains fields having "data-validation"
 | data attribute, then those fields will be
 | tested for mandatory / non-blank checks. 
 | It returns false if validation fails.
 |--------------------------------------------------------------------------
 */
function validate (e) 
{
	let fields = $(e).find('[data-validation="required"]'), is_valid = true,
	msg = '<span class="help-block"><strong>This is a required field</strong></span>';

	for (let i = 0; i < fields.length; i++)
	{
		// validation check
		if (fields[i].value.length == 0) {
			is_valid = false;
			let p = fields[i].parentElement;
			p.className += ' has-error';
			p.insertAdjacentHTML('beforeend', msg);

			// add a event handler to remove validation messages
			// when field values are changed
			fields[i].addEventListener("keyup", function (e) {
				// remove this event handler for future
				e.target.removeEventListener(e.type, arguments.callee);
				p.classList.remove ('has-error');
				p.removeChild(p.querySelectorAll('span.help-block')[0]);
			});
		} // if
	} // for
	return is_valid;
}


/*
 |--------------------------------------------------------------------------
 | This function populates a "select" list using the data received from
 | ajax request to an API endpoint. A third parameter, p can be given
 | to indicate the name of the attribute used for key and value of
 | the ajax response data.
 |--------------------------------------------------------------------------
 */
function populateSelect (e, url, p, defValue, exclusionList)
{
	if (typeof p === 'undefined') p = {"key": "record", "value": "label"};
	if (typeof exclusionList === 'undefined') exclusionList = [];
	$.get(url, function (data) {
		let l = data.length;
		if (l != 0) 
		{
			let fragment = document.createDocumentFragment();
    			for (i = 0; i < l; i++) {
    				if (exclusionList.indexOf(data[i][p.key]) !== -1) 
    					{ continue; }

        			let opt = document.createElement('option');
        			opt.innerHTML = data[i][p.value];
        			opt.value = data[i][p.key];
        			if (data[i][p.key] == defValue) opt.selected = true;
        			fragment.appendChild(opt);
    			}
    			document.querySelector(e).appendChild(fragment);
    		}
    	});
}


/*
 |--------------------------------------------------------------------------
 |  reference: https://stackoverflow.com/questions/12022614
 |--------------------------------------------------------------------------
 */
function stripHTML(str) {
  var strippedText = $("<div/>").html(str).text();
  return strippedText;
}

function escapeHTML(str) {
  var escapedText = $("<div/>").text(str).html();
  return escapedText;
}

/*
 |--------------------------------------------------------------------------
 |  
 |--------------------------------------------------------------------------
 */
function makeAjaxRequest (param)
{
	if (typeof param.data === 'undefined') param.data = {};
	param.data['_token'] = $('meta[name="csrf-token"]').attr('content');
	
	$.ajax ({
		method: param.method,
		url: param.to,
		data: param.data,
		beforeSend: (typeof param.before === 'undefined'? waitWheel("Talking to the server...") : param.before),
		success: (typeof param.success === 'undefined'? ajaxSuccess : param.success),
		error: (typeof param.error === 'undefined'? ajaxError : param.error),
	});
	
}

function ajaxSuccess ()
{
	$('#loadingDiv').remove();
	//console.log('1');	
}

function ajaxError ()
{
	let msg = '<div class="alert alert-danger"><strong>Error!</strong> Error occurred!</div>'
	$('#loadingDivMsg').html (msg);
	//console.log('2');
}

function waitWheel (msg)
{
	let content = '<div id="loadingDiv"><div><h7 id="loadingDivMsg"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>&nbsp;' + msg + '</h7></div></div>';
	$("body").append(content);
}


function getIconByUserType(type)
{
	if (type == 'Registered') 
		return '<i class="fa fa-user-o"></i>&nbsp';
	else if (type === 'Author')
		return '<i class="fa fa-pencil"></i>&nbsp';
	else if (type === 'Editor')
		return '<i class="fa fa-scissors"></i>&nbsp';
	else 
		return '<i class="fa fa-dot-circle-o"></i>&nbsp';
}


/*
 |--------------------------------------------------------------------------
 |  This function activates the Markddown editor on any textarea
 |--------------------------------------------------------------------------
 */
function Editor (input, preview) {
	this.update = function () {
		var md = new Remarkable({
			html: true,         // Enable HTML tags in source
			xhtmlOut: true,     // Use '/' to close single tags (<br />)
			typographer: true,  // provides some common replacements
		});
          	preview.innerHTML = md.render(input.value);
        };
        input.editor = this;
        this.update();
}



/*
 |--------------------------------------------------------------------------
 |  Handy functions to determine if an object is partially/fully visible
 |--------------------------------------------------------------------------
 */
function isElementPartiallyInViewport (el)
{
    //special bonus for those using jQuery
    if (typeof jQuery !== 'undefined' && el instanceof jQuery) el = el[0];
    
    var rect = el.getBoundingClientRect();
    // DOMRect { x: 8, y: 8, width: 100, height: 100, top: 8, right: 108, bottom: 108, left: 8 }
    var windowHeight = (window.innerHeight || document.documentElement.clientHeight);
    var windowWidth = (window.innerWidth || document.documentElement.clientWidth);

    // http://stackoverflow.com/questions/325933/determine-whether-two-date-ranges-overlap
    var vertInView = (rect.top <= windowHeight) && ((rect.top + rect.height) >= 0);
    var horInView = (rect.left <= windowWidth) && ((rect.left + rect.width) >= 0);

    return (vertInView && horInView);
}


// http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
function isElementInViewport (el) 
{
    //special for jQuery
    if (typeof jQuery !== 'undefined' && el instanceof jQuery) el = el[0];


    var rect = el.getBoundingClientRect();
    var windowHeight = (window.innerHeight || document.documentElement.clientHeight);
    var windowWidth = (window.innerWidth || document.documentElement.clientWidth);

    return (
           (rect.left >= 0)
        && (rect.top >= 0)
        && ((rect.left + rect.width) <= windowWidth)
        && ((rect.top + rect.height) <= windowHeight)
    );

}


// function onVisibilityChange (el, callback, type) {
//     var old_visible;
//     return function () {
//         var visible = (type == 'false'? isElementPartiallyInViewport(el) : isElementInViewport(el));
//         if (visible != old_visible) {
//             old_visible = visible;
//             if (typeof callback == 'function') {
//                 callback();
//             }
//         }
//     }
// }

function runOnceInView (el, callback)
{
	//special for jQuery
    	if (typeof jQuery !== 'undefined' && el instanceof jQuery) el = el[0];

	var handler = function () {
		if (isElementPartiallyInViewport(el) && isDuplicateCallback (el, callback) === false)
			callback ();
	}

	if (window.addEventListener) {
	    addEventListener('DOMContentLoaded', handler, false); 
	    addEventListener('load', handler, false); 
	    addEventListener('scroll', handler, false); 
	    addEventListener('resize', handler, false); 
	} else if (window.attachEvent)  {
	    attachEvent('onDOMContentLoaded', handler); // IE9+ :(
	    attachEvent('onload', handler);
	    attachEvent('onscroll', handler);
	    attachEvent('onresize', handler);
	}
}

let triggerCallbackSet = [];
function isDuplicateCallback (el, callback)
{
	// since the callback needs to be called 
	// only once per element visibility, we 
	// need to maintain a list of all calls
	let registeredCallbacks = triggerCallbackSet[el];

	if (typeof registeredCallbacks === 'undefined') {
		// no callback has been registered against this element
		// so, set the current callback against the element
		triggerCallbackSet[el] = [callback];
		return false;
	}

	// there is some callback registered against this element
	if (registeredCallbacks.indexOf(callback) === -1) {
		// but current callbak is not part of registered callbacks
		// so, add the current callback to the list
		triggerCallbackSet[el].push(callback);
		return false;
	}
	
	// current callback is part of the registered callbacks
	// so, don't do anything more
	return true;
}


// jQuery.fn.highlight = function (duration=2000) {
//     $(this).each(function() {
//         var el = $(this);
//         el.before("<div/>")
//         el.prev()
//             .width(el.width())
//             .height(el.height())
//             .addClass("highlighter");
//             // .fadeOut(duration);
//     });
// }