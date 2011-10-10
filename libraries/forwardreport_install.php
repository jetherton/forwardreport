<?php
/**
 * Forward Reports - Install
 *
 * @author	   John Etherton
 * @package	   Forward Reports
 */

class Forwardreport_Install {

	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db = Database::instance();
	}

	/**
	 * Creates the required database tables for the actionable plugin
	 */
	public function run_install()
	{
		// Create the database tables.
		// Also include table_prefix in name
		$this->db->query('CREATE TABLE IF NOT EXISTS `'.Kohana::config('database.default.table_prefix').'forwardreports` (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) DEFAULT NULL,
				  `url` varchar(255) DEFAULT NULL,
				  `simplegroup_name` varchar(255) DEFAULT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
		
		
		$this->db->query('CREATE TABLE IF NOT EXISTS `'.Kohana::config('database.default.table_prefix').'forwardreports_history` (
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `date` datetime DEFAULT NULL,
						  `forwardreports_id` int(10) unsigned DEFAULT NULL,
						  `user_id` int(10) unsigned DEFAULT NULL,
						  `incident_id` int(11) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
		
		
	}

	/**
	 * Deletes the database tables for the actionable module
	 */
	public function uninstall()
	{
		
		$this->db->query('DROP TABLE `'.Kohana::config('database.default.table_prefix').'forwardreports`');
	}
}