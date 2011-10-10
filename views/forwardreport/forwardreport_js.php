/**
 * forward reports js file.
 * 
 * Handles javascript stuff related to forward report plugin.
 */


    

// Categories JS
function fillFields(id, name, url, simpleGroupName)
{
	show_addedit();
	$("#forwardReport_id").attr("value", unescape(id));
	$("#name").attr("value", unescape(name));
	$("#url").attr("value", unescape(url));
	$("#simplegroup_name").attr("value", unescape(simpleGroupName));
}

// Ajax Submission
function catAction ( action, confirmAction, id )
{
	var statusMessage;
	var answer = confirm('<?php echo Kohana::lang('ui_admin.are_you_sure_you_want_to'); ?> ' + confirmAction + '?')
	if (answer){
		// Set Category ID
		$("#forwardReport_id").attr("value", id);
		// Set Submit Type
		$("#action").attr("value", action);
		// Submit Form
		$("#newForwardReport").submit();
	}
}