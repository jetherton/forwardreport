<?php defined('SYSPATH') or die('No direct script access.');
/**
 *  Forward Reports - sets up the hooks
 *
 * @author	   John Etherton
 * @package	   Forward Reports
 */

class forwardreport {
	
	/**
	 * Registers the main event add method
	 */
	 
	 
	public function __construct()
	{
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
		
			
		// Set Table Prefix
		$this->table_prefix = Kohana::config('database.default.table_prefix');		
		$this->group_name = "";
	}
	
	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
		
		if(Router::$controller == "reports")
		{
			//make sure this is just regular users,no groups or other special stuff
			if(strpos(url::current(), "admin/reports") === 0)
			{
				Event::add('ushahidi_action.report_extra_admin', array($this, 'add_forward_to_instance'));
				Event::add('ushahidi_action.header_scripts_admin', array($this, 'add_js'));
			}
		}
		Event::add('forward_report_action.set_group_name', array($this, 'set_group_name'));
		Event::add('ushahidi_api_library_action.report_task_add_parameter', array($this, 'add_group_name'));
	}
	
	public function set_group_name()
	{
		$this->group_name = event::$data;
	}
	
	/**
	 * Adds the simple group name into the equation
	 * Enter description here ...
	 */
	public function add_group_name()
	{
		$query_str = event::$data;
		$query_str['sgn'] = $this->group_name;
		event::$data = $query_str;
	}
	
	/**
	 * Add the java script that lets us forward messages.
	 * Enter description here ...
	 */
	public function add_js()
	{
		$view = view::factory("forwardreport/forward_report_js");
		$view->render(true);
	}
	
	/**
	 * Creates the forward to link
	 */
	public function add_forward_to_instance()
	{
		$incident = event::$data;
		//get the forwarded to history if any
		$history = ORM::factory("forwardreports_history")
			->where("incident_id", $incident->incident_id)
			->find_all();
				
		//get list of places you can forward this report to
		$forward_to_q = ORM::factory("forwardreport")->find_all();
		//convert to array
		$forward_to = array();
		foreach($forward_to_q as $q)
		{
			$forward_to[$q->id] = $q->name;
		}
		
		$view = view::factory("forwardreport/report_forwarder");
		$view->history = $history;
		$view->incident = $incident;
		$view->forward_to = $forward_to;
		$view->render(TRUE);
		
		
	}
	
	
}//end class

new forwardreport;