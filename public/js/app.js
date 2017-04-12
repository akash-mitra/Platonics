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
	let fields = $(e).find('[data-validation="required"]'), error = false,
	msg = '<span class="help-block"><strong>This is a required field</strong></span>';

	for (let i = 0; i < fields.length; i++)
	{
		// validation check
		if (fields[i].value.length == 0) {
			error = true;
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
	return !error;
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
 |  
 |--------------------------------------------------------------------------
 */
function makeAjaxRequest (param)
{
	param.data['_token'] = $('meta[name="csrf-token"]').attr('content');
	// console.log(param);
	$.ajax ({
		method: param.method,
		url: param.to,
		data: param.data,
		beforeSend: (typeof param.before === 'undefined'? waitWheel("Talking to the server...") : param.before),
		success: (typeof param.success === 'undefined'? ajaxSuccess : param.success),
		error: (typeof param.success === 'undefined'? ajaxError : param.error),
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