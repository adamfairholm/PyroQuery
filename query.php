<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroQuery Plugin
 *
 * Use MySQL Queries in your PyroCMS template
 *
 * @package		PyroQuery
 * @version		2.0
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
	 * {{ query:run select="*" from="my_table" where="column = 2" }}
	 * 	{{ field_name }}
	 * {{ /query:run }}
	 *
	 * @return	array
	 */
	public function run()
	{
		// No going apeshit for an error
		$this->db->db_debug = false;

		// -------------------------------------
		// Build basic query
		// -------------------------------------

		$where = '';
		if ($this->attribute('where')) {
			$where = ' WHERE '.$this->attribute('where');
		}

		$limit = ($this->attribute('limit')) ? $this->attribute('limit') : null;
		$offset = $this->attribute('offset', 0);

		$limitStatement = null;
		if ($limit) {
			$limitStatement = " LIMIT $offset, $limit";
		}

		$orderBy = null;
		if ($this->attribute('orderBy')) {
			$orderBy = ' ORDER BY '.$this->attribute('orderBy').' '.$this->attribute('sort', 'desc');
		}

		$from = $this->db->dbprefix($this->attribute('from'));
		$select = $this->attribute('select', '*');

		$query = "
		SELECT $select
		FROM $from
		$where
		$limitStatement
		";

		$results = $this->db->query($query)->result();

		// -------------------------------------
		// Error Handling
		// -------------------------------------
		
		if ( ! $results) {
		
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
			(($count-1)%2) == 0 ? $return[$count]['odd_even'] = 'even' : $return[$count]['odd_even'] = 'odd';
						
			// Last Item			
			$count+1 == $total ? $return[$count]['last_row'] = 'yes' : $return[$count]['last_row'] = 'no';
					
			$count++;
		}
		
		return $return;
	}
}