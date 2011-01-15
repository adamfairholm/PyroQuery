<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroQuery Plugin
 *
 * Use MySQL Queries in Your Layouts
 *
 * @package		PyroQuery
 * @author		Addict Addons
 * @copyright	Copyright (c) 2011, Addict Addons
 * @link		https://github.com/addict-addons/PyroQuery
 */
class Plugin_query extends Plugin
{
	/**
	 * Query
	 *
	 * Runs a MySQL query
	 *
	 * Usage:
	 * {pyro:query:run query="SELECT * FROM table"}
	 * 		{field_name}
	 * {/pyro:query:run}
	 *
	 * @access	public
	 * @return	array
	 */
	public function run()
	{
		$db_obj = $this->db->query( $this->attribute('query') );
		
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