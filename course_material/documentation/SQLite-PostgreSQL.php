<? require("../course.php");
echo startPage("SQLite vs PostgreSQL","","Differences between the two systems");
//updateBlurb();
?>

<p>
A summary of the differences between PostgreSQL and SQLite.
</p>
<p>
The dialect of the SQL query language used by both systems is almost identical.
The SQL data definition languages have some minor differences
(e.g., no <tt>CREATE DOMAIN</tt> in SQLite), but these are not relevant for the exam.
In general, SQLite's SQL is a subset of PostgreSQL's SQL.
</p>
<h3>
Commands executed at the command line:
</h3>
<table cellpadding="5" cellspacing="0" border="1">
<tr>
<td><b>Feature</b></td> <td><b>PostgreSQL</b></td> <td><b>SQLite</b></td>
</tr>
<tr>
<td>Getting a list of databases</td>
<td><tt>psql -l</tt></td>
<td><tt>ls</tt></td>
</tr>
<tr>
<td>Connect to a database to ask SQL queries</td>
<td><tt>psql <i>DatabaseName</i></tt></td>
<td><tt>sqlite3 <i>DatabaseName</i></tt></td>
</tr>
<tr>
<td>Create a database</td>
<td><tt>createdb <i>DatabaseName</i></tt></td>
<td><tt>sqlite3 <i>DatabaseName</i></tt></td>
</tr>
<tr>
<td>Remove a database</td>
<td><tt>dropdb <i>DatabaseName</i></tt></td>
<td><tt>rm <i>DatabaseName</i></tt></td>
</tr>
</table>
<h3>
Commands executed within the SQL shell (<tt>psql</tt> or <tt>sqlite</tt>):
</h3>
<table>
<table cellpadding="5" cellspacing="0" border="1">
<tr>
<td><b>Feature</b></td> <td><b>PostgreSQL</b></td> <td><b>SQLite</b></td>
</tr>
<tr>
<td>Exit the SQL shell</td>
<td><tt>\q</tt></td>
<td><tt>.quit</tt></td>
</tr>
<tr>
<td>Get a list of tables/views in a database</td>
<td><tt>\d</tt></td>
<td><tt>.schema</tt></td>
</tr>
<tr>
<td>Execute an SQL statement</td>
<td><tt>select * from <i>TableName</i>;</tt></td>
<td><tt>select * from <i>TableName</i>;</tt></td>
</tr>
<tr>
<td>Excecute SQL commands from a file</td>
<td><tt>\i <i>FileName</i></tt></td>
<td><tt>.read <i>FileName</i></tt></td>
</tr>
<tr>
<td>Edit a file and reload</td>
<td><tt>\ef <i>FileName</i></tt></td>
<td>No equivalent; use two windows<br>
One for <tt>sqlite3</tt> and one for an editor</td>
</tr>
<tr>
<td>Go to previous command</td>
<td>Up-arrow</td>
<td>Up-arrow</td>
</tr>
<tr>
<td>Create a view</td>
<td><tt>create or replace V(a,b,c)<br>
as select x,y,z ...</tt><br>&ddagger; <small>Note that the SQLite version<br>also works in PostgreSQL</small></td>
<td><tt>drop view if exists V;<br>
create view V <br>
as select x as a, b as y, z as c ...</tt></td>
</tr>
<tr>
<td>Temporary tables via <tt>WITH</tt></td>
<td><tt>with tab as (select...) ...</tt></td>
<td>Not available; define a view</tt>
</tr>
<tr>
<td>Union, Intersect, Difference</td>
<td><tt>(<i>SelectStatement<sub>1</sub></i>) union (<i>SelectStatement<sub>2</sub></i>)</tt><br>
or  <tt><i>SelectStatement<sub>1</sub></i> union <i>SelectStatement<sub>2</sub></i></tt></td>
<td><tt><i>SelectStatement<sub>1</sub></i> union <i>SelectStatement<sub>2</sub></i></tt></td>
</table>
<h3>
Built-in functions:
</h3>
<table cellpadding="5" cellspacing="0" border="1">
<tr>
<td><b>Feature</b></td> <td><b>PostgreSQL</b></td> <td><b>SQLite</b></td>
</tr>
<tr>
<td>Case-insensitive SQL pattern-matching</td>
<td><tt><i>Attribute</i> ilike <i>Pattern</i></td>
<td><tt><i>Attribute</i> like <i>Pattern</i></td>
</tr>
<tr>
<td>Regular expression pattern matching</td>
<td><tt><i>Attribute</i> ~ <i>Pattern</i></td>
<td>Not available in CSE's SQLite</td>
</tr>
</table>

</body>
</html>
