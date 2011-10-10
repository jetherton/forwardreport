<script type="text/javascript" charset="utf-8">
function reportForwardToInstance(r_id)
{
	//get the id of the instance to forward to
	var i_id = $("#forwardreport_instance_" + r_id).val();

	//start spinner
	$("#reportForward_time_"+r_id).html('<img src="<?php echo url::base() . "media/img/loading_g.gif"; ?>">');
	
	//now run some post stuff		
	$.post("<?php echo url::site() . 'admin/forwardreport/forward' ?>", { instance_id: i_id, report_id: r_id },
			function(data){

				if (data == 'ERROR'){
					alert("<?php echo Kohana::lang("forwardreport.error_forwarding");?>");
				} else {
					$("#forwardreport_history_" + r_id).append(data);
				}
				//stop spinner
				$("#reportForward_time_"+r_id).html('');
		  	});
}
</script>

