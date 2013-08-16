<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Forward Reports - Administrative Controller
 *
 * @author	   John Etherton
 * @package	   Forward Reports
 */

class Forwardreport_Controller extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'settings';

		// If this is not a super-user account, redirect to dashboard
		if(!$this->auth->logged_in('admin') && !$this->auth->logged_in('superadmin'))
		{
			echo "FAILED";
			return;
		}
	}
	
	public function forward()
	{
		$this->auto_render = FALSE;
		$this->template = "";
		
		
		if($_POST && isset($_POST['instance_id']) &&  isset($_POST['report_id']))
		{
			$instance_id = $_POST['instance_id'];
			$report_id = $_POST['report_id'];
			
			$report = ORM::factory('incident')->where("id",$report_id)->find();
			
			//get category info for this report
			$cat_str = "";
			foreach($report->category as $cat)
			{
				if($cat_str != "")
				{
					$cat_str .= ", ";
				}
				$cat_str.= $cat->category_title;
			}
			
			$cat_str = "This report was forwarded from ". Kohana::config('settings.site_name') ." where it was categorized under the following: \n".$cat_str; 
			
			//$report->incident_description = $report->incident_description . "<br/><br/>". $cat_str;
			
			$instance = new Forwardreport_Model($instance_id);
			$instance_url = $instance->url;
                        if (substr("$instance_url", -1) != "/") $instance_url .= "/";
			$simplegroup_name = $instance->simplegroup_name;
			event::run('forward_report_action.set_group_name', $simplegroup_name);
			
			$UshApiLib_Site_Info = new UshApiLib_Site_Info($instance_url ."api");
			$reportParams = UshApiLib_Report_Task_Parameter::fromORM($report);
			$reportParams->setIncident_description($report->incident_description . "\n- - - \n". $cat_str);
			$reportParams->setIncident_title($report->incident_title . ' ('. Kohana::lang('forwardreport.reported_to'). ' '. Kohana::config('settings.site_name'). ')' );
			
			//This is a bit of a hack that I don't really like, but Ushahidi requires
			//every report have at least one category, and since we don't really know
			//the IDs of the categories on the targer instance(I don't have the time to
			//use API to query the other site, figure out what categories they have, and then
			//ask the user what category it should default to. I've got more important things to do
			//right now), so we're just going to use the "trusted report" category since that's the most generic.
			//I know it's a hack, my apologies. 
			$reportParams->setIncident_category("4");
			
			
			$reportTask = new UshApiLib_Report_Task($reportParams, $UshApiLib_Site_Info);
			$response = $reportTask->execute();
			
			//echo "error code: " . $response->getError_code();
			//echo "<br/><br/> error message: " . $response->getError_message();
			//echo "<br/><br/>Json: " . $reportTask->getJson();
			if($response->getError_code() != "0")
			{
				
				
				echo "ERROR";
				return;
			}
			
			//update the history
			$history = new Forwardreports_history_Model();
			$history->date = date("c");
			$history->forwardreports_id = $instance->id;
			$history->incident_id = $report_id;
			$history->user_id = $this->user->id;
			$history->save();
			
			$view = view::factory("forwardreport/forwardreport_history");
			$view->date = date("Y-m-d G:i");
			$view->user = $this->user->name;
			$view->instance_name = $instance->name;
			$view->render(TRUE);
		}	
		else
		{
			echo "ERROR";
			return;
		}	
	}//end index method
	
	

	
}
