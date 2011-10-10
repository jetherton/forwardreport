<br/>
<div id="reportForward_time_<?php echo $incident->incident_id; ?>"></div>
<?php echo Kohana::lang("forwardreport.forwardreportto"); ?>: 
<?php print form::dropdown('forwardreport_instance_' . $incident->incident_id,$forward_to,'standard'); ?>
<a href="#" onclick="reportForwardToInstance(<?php echo $incident->incident_id; ?>); return false;" style="border: #d1d1d1 1px solid; background-color:#F2F7Fa; color: #5c5c5c; padding: 0px 9px; line-height:24px; text-decoration:none;"><?php echo Kohana::lang("forwardreport.forward")?></a>
<div>
	<ul id="forwardreport_history_<?php echo $incident->incident_id;?>">
		<?php 
			foreach($history as $h)
			{
				$user = ORM::factory("user")->where("id", $h->user_id)->find();
				$view = view::factory("forwardreport/forwardreport_history");
				$view->user = $user->name;
				$view->date = $h->date;
				$view->instance_name = $forward_to[$h->forwardreports_id];
				$view->render(TRUE);
			}
		?>
	</ul>
</div>