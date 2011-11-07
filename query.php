<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroQuery Plugin
 *
 * Use MySQL Queries in your PyroCMS template
 *
 * @package		PyroQuery
 * @version		1.2
 * @author		Parse19
 * @copyright	Copyright (c) 2011, Parse19
 * @link		http://parse19.com/pyroquery
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
	 * @access	public
	 * @return	array
	 */
	public function run()
	{
		// No going apeshit for an error
		$this->db->db_debug = FALSE;

		$db_obj = $this->db->query( $this->attribute('query') );

		// -------------------------------------
		// Error Handling
		// -------------------------------------
		
		if( !$db_obj ):
		
			if( $this->attribute('debug', 'off') == 'on' ):
		
				// Debugging is on. Get the error.
				return mysql_error();
				
			else:
			
				// We want to go quietly.
				return;
			
			endif;
		
		endif;

		// -------------------------------------
		// Query Loop Prep
		// -------------------------------------
		
		$results = $db_obj->result();
		
		$return = array();
		
		$count = 0;
		
		$total = count($results);

		// -------------------------------------
		// Run Through Results
		// -------------------------------------
		
		foreach( $results as $row ):
		
			foreach( $row as $slug => $value ):
		
				$return[$count][$slug] = $value;
			
			endforeach;
			
			// Odd/Even
			(($count-1)%2) == 0 ? $return[$count]['query.odd_even'] = 'even' : $return[$count]['query.odd_even'] = 'odd';
						
			// Last Item			
			$count+1 == $total ? $return[$count]['query.last_row'] = 'yes' : $return[$count]['query.last_row'] = 'no';
					
			$count++;
		
		endforeach;
		
		return $return;
	}
}

/* End of file query.php */