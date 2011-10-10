
<h1><?php echo Kohana::lang('forwardreport.forwardreport');?></h1>
<h4> 
	<br/> <?php echo Kohana::lang('forwardreport.forwardreport_description');?>
<h4>
<br/>
<br/>


	<?php
	if ($form_error) {
	?>
		<!-- red-box -->
		<div class="red-box">
			<h3><?php echo Kohana::lang('ui_main.error');?></h3>
			<ul>
			<?php
			foreach ($errors as $error_item => $error_description)
			{
				// print "<li>" . $error_description . "</li>";
				print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
			}
			?>
			</ul>
		</div>
	<?php
			}
			?>

	<?php  if ($form_saved) {?>
		<!-- green-box -->
		<div class="green-box">
		<h3><?php echo Kohana::lang('ui_main.configuration_saved');?></h3>
		</div>
	<?php } ?>



				<!-- tabs -->
				<div class="tabs">
					<!-- tabset -->
					<a name="add"></a>
					<ul class="tabset">
						<li><a href="#" class="active" onclick="show_addedit(true)"><?php echo Kohana::lang('ui_main.add_edit');?></a></li>
					</ul>
					<!-- tab -->
					<div class="tab" id="addedit" style="">
						<?php print form::open(NULL,array('enctype' => 'multipart/form-data', 
							'id' => 'newForwardReport', 'name' => 'newForwardReport')); ?>
						<input type="hidden" id="forwardReport_id" name="forwardReport_id" value="0" />
						<input type="hidden" name="action" id="action" value="a"/>
						<div class="tab_form_item">
							<strong><?php echo Kohana::lang('forwardreport.name');?>:</strong><br />
							<?php print form::input('name', "", ' class="text"'); ?><br/>
						</div>

						<div class="tab_form_item">
							<strong><?php echo Kohana::lang('forwardreport.url');?>:</strong><br />
							<?php print form::input('url', "", ' class="text"'); ?>
						</div>
						<div class="tab_form_item">
							<strong><?php echo Kohana::lang('forwardreport.simplegroup_name');?>:</strong><br />
							<?php print form::input('simplegroup_name', "", ' class="text"'); ?>
						</div>
						<div style="clear:both"></div>
						<div class="tab_form_item">
							&nbsp;<br />
							<input type="image" src="<?php echo url::file_loc('img'); ?>media/img/admin/btn-save.gif" class="save-rep-btn" />
						</div>
						<?php print form::close(); ?>			
					</div>
				</div>



<table class="table">
	
	<tr>
		<th class="col-2">
			<?php echo Kohana::lang("forwardreport.name"); ?>
		</th>
		<th class="col-2">
			<?php echo Kohana::lang("forwardreport.url")?>
		</th>
		<th class="col-2">
			<?php echo Kohana::lang("forwardreport.simplegroup_name")?>
		</th>
		<th class="col-2">
			<?php echo Kohana::lang("forwardreport.actions")?>
		</th>
	</tr>

	<?php foreach($forwardreports as $forwardreport) {?>
		<tr>
			<td>
				<?php print $forwardreport->name; ?>
			</td>
			<td>
				<?php print $forwardreport->url; ?>
			</td>
			<td>
				<?php print $forwardreport->simplegroup_name; ?>
			</td>
			<td>
				<a href="#" onclick="fillFields('<?php print $forwardreport->id; ?>', 
					'<?php print $forwardreport->name; ?>', 
					'<?php print $forwardreport->url; ?>',
					'<?php print $forwardreport->simplegroup_name; ?>' );"><?php echo Kohana::lang("forwardreport.edit")?></a>
				<a href="#" onclick="catAction('d','Delete', '<?php echo $forwardreport->id; ?>');"><?php echo Kohana::lang("forwardreport.delete")?></a>
			</td>
		</tr>	
	<?php }?>
</table>

<br/><br/>

<input type="image" src="<?php echo url::base() ?>media/img/admin/btn-save-settings.gif" class="save-rep-btn" style="margin-left: 0px;" />


