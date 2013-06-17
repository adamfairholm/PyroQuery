h1. PyroQuery 2.0

Allows you to make MySQL queries in layouts and output the resulting data.

h2. Installation

Drop the query.php file into your _addons/default/plugins_ folder and you're ready to go!

h2. Usage

	{{ query:run from="groups" limit="2" where="name='user'" }}
		{{ name }}
	{{ /query:run }}

	{{ query:run select="name" from="groups" limit="2" offset="1" }}
		{{ name }}
	{{ /query:run }}

The only required parameter is *from*.

In addition, PyroQuery returns two special variables:

h3. {{ odd_even }}

Returns "odd" or "even" based on the row being displayed.

h3. {{ last_row }}

Returns "yes" or "no" based on whether the row being displayed is the last one.

h3. Debugging

If PyroQuery encounters a MySQL error, it will, by default, just return nothing. However, if you pass a *debug* parameter set to "on", PyroQuery will display the database error.

{{ query:run from="groups" debug="on" }}
	{{ name }}
{{ /query:run }}

This would return:

You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'SECT * FROM table' at line 1