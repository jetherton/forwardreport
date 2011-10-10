<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Forward Reports - Administrative Controller
 *
 * @author	   John Etherton
 * @package	   Forward Reports
 */

class Forwardreport_settings_Controller extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'settings';

		// If this is not a super-user account, redirect to dashboard
		if(!$this->auth->logged_in('admin') && !$this->auth->logged_in('superadmin'))
		{
			url::redirect('admin/dashboard');
		}
	}
	
	public function index()
	{
		
		$this->template->content = new View('forwardreport/forwardreport_admin');
		$this->template->js = new View('forwardreport/forwardreport_js');
		
		$form_saved = false;
		$form_error = false;
		$errors = array();
		
		
		// check, has the form been submitted if so check the input values and save them
		if ($_POST)
		{
				
			$post = Validation::factory($_POST)
						->pre_filter('trim', TRUE);
			
			
			// Add validation for the add/edit action
			if ($post->action == 'a')
			{
				$post->add_rules('url', 'url');
			}
			
			// forward report instance for the operation
			$fr = (intval($post->forwardReport_id) > 0 )
			? new Forwardreport_Model(intval($post->forwardReport_id))
			: new Forwardreport_Model();
			
			// Check the specified action
			if ($post->action == 'a')
			{
				// Test to see if things passed the rule checks
				if ($post->validate())
				{
					$fr->name = $post->name;
					$fr->url = $post->url;
					$fr->simplegroup_name = $post->simplegroup_name;
					$fr->save();
				}
				else
				{
					// populate the error fields, if any
					$errors =  $post->errors();
					$form_error = TRUE;
				}	
			}
			elseif ($post->action == 'd')
			{
				ORM::factory('forwardreport')
				->delete($fr->id);
			}	
		}
		
		//get the list of layers for display to the user
		$forwardreports = ORM::factory("forwardreport")
				->find_all();
				
		$this->template->content->forwardreports = $forwardreports;	
		$this->template->content->form_saved = $form_saved;
		$this->template->content->form_error = $form_error;
		$this->template->content->errors = $errors;
		
	}//end index method
	
	

	
}