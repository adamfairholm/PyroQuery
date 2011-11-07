h1. PyroQuery 1.2

Allows you to make MySQL queries in layouts and output the resulting data.

h2. Installation

Drop the query.php file into your _addons/plugins_ folder (PyroCMS 1.3 and below) or your _addons/shared_addons/plugins_ folder (PyroCMS 1.3+).

h2. Usage

{{ query:run query="SELECT * FROM table" }}
	{{ field_name }}
{{ /query:run }}

Simple provide your query as the *query* parameter, and the plugin will make all the fields returned by your query available as variables.

In addition, PyroQuery returns two special variables:

h3. {{ query.odd_even }}

Returns "odd" or "even" based on the row being displayed.

h3. {{ query.last_row }}

Returns "yes" or "no" based on whether the row being displayed is the last one.

h3. Debugging

If PyroQuery encounters a MySQL error, it will, by default, just return nothing. However, if you pass a *debug* parameter set to "on", PyroQuery will display the database error.

{{ query:run query="SECT * FROM table" debug="on" }}
	{{ field_name }}
{{ /query:run }}

This would return:

You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'SECT * FROM table' at line 1