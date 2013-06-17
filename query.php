<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroQuery Plugin
 *
 * Use MySQL Queries in your PyroCMS template
 *
 * @package		PyroQuery
 * @version		1.2
 * @author		Adam Fairholm
 * @copyright	Copyright (c) 2011-2013 Adam Fairholm
 * @link		https://github.com/adamfairholm/PyroQuery
 */
class Plugin_query extends Plugin
{
	/**
	 * Query
	 *
	 * Runs a MySQL query
	 *
	 * Usage:
	 * {{ query:run query="SELECT * FROM table" }}
	 * 	{{ field_name }}
	 * {{ /query:run }}
	 *
	 * @return	array
	 */
	public function run()
	{
		// No going apeshit for an error
		$this->db->db_debug = false;

		$results = $this->db->query($this->attribute('query'))->result();

		// -------------------------------------
		// Error Handling
		// -------------------------------------
		
		if ( ! $db_obj) {
		
			if ($this->attribute('debug', 'off') == 'on') {
		
				// Debugging is on. Get the error.
				return mysql_error();
			}
			else {
				
				// We want to go quietly.
				return;
			}
		}

		// -------------------------------------
		// Query Loop Prep
		// -------------------------------------
				
		$return = array();
		
		$count = 0;
		
		$total = count($results);

		// -------------------------------------
		// Run Through Results
		// -------------------------------------
		
		foreach ($results as $row) {
		
			foreach ($row as $slug => $value) {		
				$return[$count][$slug] = $value;
			}
			
			// Odd/Even
			(($count-1)%2) == 0 ? $return[$count]['query.odd_even'] = 'even' : $return[$count]['query.odd_even'] = 'odd';
						
			// Last Item			
			$count+1 == $total ? $return[$count]['query.last_row'] = 'yes' : $return[$count]['query.last_row'] = 'no';
					
			$count++;
		}
		
		return $return;
	}
}