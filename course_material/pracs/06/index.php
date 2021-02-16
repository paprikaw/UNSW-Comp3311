<? require("../../course.php"); $exID = "06";?>
<? $exWeb = HOME."/pracs/$exID"; $exDir = HOMEDIR."/pracs/$exID";?>
<?=startPage("Prac Exercise $exID","","Psycopg2 - Using Python with SQL")?>
<!--
<?=updateBlurb()?>
-->

<h1>Aims</h1>

This exercise aims to give you practice in:
<ul>
<li> implementing Python scripts to manipulate databases
</ul>
This exercise will <b>not</b> explain how
to do everything in fine detail. Part of the aim of the exercise is that you
explore how to use python with PostgreSQL.

<h1>Background</h1>
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

<p>For any operations with the database you will need a valid connection handle. In our examples we will use the variable <b>conn</b>. The connection to the database will be omitted from all remaining examples, even though if you were to test it out you need to include it.</p>

<p>When connecting to a psql server on CSE's grieg, the connection string required to be passed to <b>psycopg2.connect()</b> is simply <pre>dbname='myDatabaseName'</pre> where myDatabaseName is the name of your database (for example "ass2")</p>

<p>If you are running psql on your own machine, you will likely need to provide additional credentials. An example string that would be passed to psycopg2.connect() would be: <pre>dbname='myDatabaseName' user='john' host='localhost' password='shepherd'</pre></p>

<p>This is assuming a database with credentials:</p>
<ul>
 <li>username: john</li>
 <li>password: sheperd</li>
 <li>host: localhost</li>
 <li>database: comp3311</li>
</ul>

<pre>import psycopg2

try:
    conn = psycopg2.connect("dbname='myDatabaseName'")
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





<h1>Exercises</h1>
<h2>Database Setup
You can use your database from assignment 2 for these exercises. If you need instructions on setup, please go see that.

<h2>cs3311.py</h2>
<p>Our solutions to the prac exercises all import a common file <b>cs3311.py</b>. This file is there to abstract the common step of connecting to the DB that all files require. You could easily put the connection step explicitly in every file, if you really wanted to.</p>

<h2>Questions</h2>

<h3>Question 1</h3>
Produce a list of names, and for each name, what their mostly highly rated title they've acted in is. If they haven't acted in a title, exclude them from the list.
<h4>Expected result</h4>
<p>Result is too long to display, simply use the script in solutions</p>

<h3>Question 2</h3>
Give 1 integer argument (argv), produce a histogram of all birth years of people with first names less than 4 characters and their frequency. Exclude any birth years where no names fit that criteria
<h4>Expected result</h4>
<p>When running <b>python3 q2.py</b>
<pre>1953: ['Ty Henderson']
1955: ['Ed Blakely', 'Jo Gilbert', 'Al Dobalo']
1951: ['Pj Torokvei', 'Mo Claridge', 'Al Cowens']
1956: ['Zé Pedro', 'Ze Ze Ngambi']
1971: ['DJ Screw']
1967: ['Ro Gorski']
1950: ['Ko Murobushi', 'Om Puri', 'Ed Turner', 'Ad Tamboer', 'Al Moller', 'Bo Rather']
1952: ['de los Reyes', 'La Donna Mabry', 'Ed Blaylock', 'Bi Skaarup']
1966: ['Ed Forsdick', 'Bo von Der Lippe']
1969: ['Jo Dunne']
1976: ['Mo Collins', 'Yu Li']
1961: ['Os', '3 Steps Ahead']
1963: ['Al Fritsch']
1958: ['Jo Schmidt', 'El Texano', 'Ed Cray', 'Ai Saotome']
1957: ['Al Ashton', 'Ed Crabtree', 'Bo Griffin', 'Ed Dolan']
1954: ['Jo Andres', 'La Marca', 'Ed Schultz', 'El Hortelano', 'Ab Harrewijn']
1964: ['La Veneno']
1962: ['El Gaucho Bataraz']
1968: ['El Hadji Samba Sarr']
1973: ['Ai Iijima', 'DJ AM']
1972: ['Ed Vassallo', 'De Laurentis', 'Vu Anh']
1983: ['Jo Dreihann-Holenia']
1974: ['RJ Rosales', 'Jo Cox']
1978: ['DJ Megatron']
1988: ['Bo Hu']
1990: ['Jo Maycock']
1993: ['AJ Perez']</pre>

<h3>Question 3</h3>
Given a name, produce a filmography:<br />
<br />
Name (born: birth_year, [died: death_year])<br />
\t Movie1 title (year): [role(s) (i.e. actor, director,...)]<br />
\t Movie2 title (year): [role(s) (i.e. actor, director,...)]<br />
etc. etc.<br />
<br />
ordered by year, then title<br />
<h4>Expected result</h4>
<p>When running for example <b>python3 q3.py "Ro Gorski"</b>
<pre>Ro Gorski (born: 1967, died: 2008)</pre>

<h3>Question 4</h3>
Given a movie name, produce a list of principals<br />
<br />
Movie title (start_year)<br />
\t Name 1, role(s) (i.e. actor, director,...)<br />
\t Name 2, role(s) (i.e. actor, director,...)<br />
etc. etc.<br />
<br />
Using the ordering field from the Principals table<br />
<h4>Expected result</h4>
<p>When running for example <b>python3 q4.py "All Male, All Nude"</b>
<pre>All Male, All Nude (start_year: 2017)
    Steven Marchi: ['self']</pre>

<h3>Question 5</h3>
Write a function that, given part of a title, shows the full title and the total size of the cast and crew
<h4>Expected result</h4>
<p>When running for example <b>python3 q4.py "All Male, All Nude"</b>
<pre>All Male, All Nude has 1 cast and crew</pre>

<h3>Question 6</h3>
Write python that, when given a crew member's name, the title they crewed for, and their new job, it updates the database by creating a new role to describe the relationship between the crew member and the title. If an invalid name or title is given, terminate.
<h4>Expected result</h4>
<p>Since this is an update, play around with the solution</p>

<h2>Solutions</h2>
You should attempt the above exercises before looking at the
<a href="solutions/">sample solutions</a>.
</p>
</body>
</html>
