<?require("../course.php");?>
<?=startPage("COMP3311 DB Access Library")?>
<h1>Introduction to psycopg2</h1>
<p>
This document describes <a href="https://pypi.org/project/psycopg2/">psycopg2</a>, a simple programatic interface to PostgreSQL
databases from Python that we'll use in COMP3311. A number of interfaces exist,
but this interface is simple to learn with basic python knowledge.

<p>
Many psycopg2 tutorials can be found online, including <a href="https://wiki.postgresql.org/wiki/Psycopg2_Tutorial">this one</a>.
</p>


</p>
<h2>Installation</h2>
<p>
psycopg2 is python module that can be installed with pip.
</p>
<p><b>On CSE machines</b>, psycopg2 binary is already installed</p>
<p><b>On your own unix machine</b>, psycopg2 binary can be installed with pip:
<pre>pip install psycopg2-binary</pre></p>
<p><b>For a full installation</b>, or other kinds of installation, you can view the <a href="http://initd.org/psycopg/docs/install.html#install-from-source">installation docs</a></p>

<h2>Examples</h2>

<h3>Connecting</h3>

<p>This is assuming a database with credentials:</p>
<ul>
 <li>username: john</li>
 <li>password: sheperd</li>
 <li>host: localhost</li>
 <li>database: comp3311</li>
</ul>

For any operations with the database you will need a valid connection handle. In our examples we will use the variable <b>conn</b>. The connection to the database will be omitted from all remaining examples, even though if you were to test it out you need to include it.

<pre>import psycopg2

try:
    conn = psycopg2.connect("dbname='myDatabaseName' user='john' host='localhost' password='shepherd'")
except Exception as e:
    print("Unable to connect to the database")
    print(e)

# =================
# DO DATABASE STUFF
# =================

conn.close() # Close the DB connection</pre>

<h3>CREATE</h3>
<p>We will use psycopg2 to create a table</p>

<pre>cur = conn.cursor()
try:
    cur.execute("CREATE TABLE Person (id serial PRIMARY KEY, name varchar, age integer);")
except Exception as e:
    print("Error creating table User")
    print(e)

cur.close() # No longer need the cursor
conn.commit() # Need to commit changes to the DB</pre>

<br />
This will create a table in the database that looks like this (empty because no rows have been added)
<table border="1">
  <tr>
    <th>id</th><th>name</th><th>age</th>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>

<h3>INSERT</h3>

<p>Note: When running an insert query, note that you may have to manually include apostrophe's such as the example below when dealing with non-numerical types</p>

<pre>cur = conn.cursor()
try:
    cur.execute("INSERT INTO Person (name, age) VALUES ('{}', {})".format("John Shepherd", 38))
    cur.execute("INSERT INTO Person (name, age) VALUES ('{}', {})".format("Andrew Taylor", 20))
except Exception as e:
    print("Error inserting into Person table")
    print(e)

cur.close() # No longer need the cursor
conn.commit() # Need to commit changes to the DB</pre>

<p>After this has been inserted, the current database will look like</p>
<table border="1">
  <tr>
    <th>id</th><th>name</th><th>age</th>
  </tr>
  <tr>
    <td>1</td>
    <td>John Shepherd</td>
    <td>38</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Andrew Taylor</td>
    <td>20</td>
  </tr>
</table>

<h3>UPDATE</h3>

<pre>cur = conn.cursor()
try:
    cur.execute("UPDATE Person SET age = {} WHERE name LIKE '%{}%'".format(50,"John"))
except Exception as e:
    print("Error updating Person table")
    print(e)

cur.close() # No longer need the cursor
conn.commit() # Need to commit changes to the DB</pre>

<p>After this operation the table will now look like</p>
<table border="1">
  <tr>
    <th>id</th><th>name</th><th>age</th>
  </tr>
  <tr>
    <td>1</td>
    <td>John Shepherd</td>
    <td>50</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Andrew Taylor</td>
    <td>20</td>
  </tr>
</table>

<h3>SELECT</h3>

<pre>cur = conn.cursor()
try:
    cur.execute("SELECT * FROM Person WHERE age > 10")
except Exception as e:
    print("Error updating Person table")
    print(e)

rows = cur.fetchall()
for row in rows:
    	print(row)

cur.close() # No longer need the cursor</pre>

This program will print the following:

<pre>(1, John Shepherd, 50)
(2, Andrew Taylor, 20)</pre>

<p>Note: We don't need <b>conn.commit()</b> since nothing transactional is happening and no writing is occurring</p>

<h3>REMOVE</h3>

<pre>cur = conn.cursor()
try:
    cur.execute("DELETE FROM Person WHERE age >= {}".format(30))
except Exception as e:
    print("Error deleting from Person table")
    print(e)

cur.close() # No longer need the cursor
conn.commit() # Need to commit changes to the DB</pre>

<p>After this operation, the table will now look like</p>
<table border="1">
  <tr>
    <th>id</th><th>name</th><th>age</th>
  </tr>
   <tr>
    <td>2</td>
    <td>Andrew Taylor</td>
    <td>20</td>
  </tr>
</table>

<?=endPage()?>
