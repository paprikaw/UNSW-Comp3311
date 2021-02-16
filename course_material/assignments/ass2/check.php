<? require("../../course.php"); require("defs.php"); ?>
<?=startPage("Assignment 2","","Checking Script")?>
<?=updateBlurb().scriptMenu($menu)?>

<p>
An SQL script is available to assist with testing:
</p>
<pre>
/web/cs3311/20T3/assignments/ass2/check1.sql
</pre>
<p>
<span class="red">Warning:</span>
this script creates a bunch of functions and tables
in your MyMyUNSW database.
The functions are called <tt>ass2_XXX</tt> or <tt>check_qXX</tt>
and the tables are called <tt>qXX_expected</tt>.
If you have any functions or tables with names like these, you will
need to edit the <tt>check1.sql</tt> file and change the names to
avoid name clashes.
</p>
<p>
In order to use the testing framework, first load the script
into your MyMyUNSW database via e.g.
</p>
<pre>
$ <b>cd <i>/my/ass2/directory</i></b>
$ <b>cp /web/cs3311/20T3/assignments/ass2/check1.sql <big>.</big></b>
$ <b>psql mymy -f check1.sql</b>
</pre>
<p>
or, alternatively,
</p>
<pre>
$ <b>psql mymy -f /web/cs3311/20T3/assignments/ass2/check1.sql</b>
</pre>
<p>
If you're working on your home machine, download the <tt>check1.sql</tt>
onto your home machine and load it from there.
</p>
<p>
The first time you do this, you'll receive a bunch of notices like:
</p>
<pre>
CREATE FUNCTION
CREATE FUNCTION
CREATE FUNCTION
CREATE FUNCTION
CREATE FUNCTION
CREATE FUNCTION
psql:check.sql:140: NOTICE:  type "testingresult" does not exist, skipping
DROP TYPE
CREATE TYPE
CREATE FUNCTION
CREATE FUNCTION
psql:check.sql:182: NOTICE:  table "q1_expected" does not exist, skipping
DROP TABLE
CREATE TABLE
COPY 8
<i>... plus a lot more lines ...</i>
</pre>
<p>
The <tt>NOTICE</tt>s are harmless, and will not appear if you reload
the script.
If you get any <tt>ERROR</tt> messages, let us know.
</p>
<p>
Once the functions and tables are loaded, you can run tests by
invoking the checking functions, e.g.
</p>
<pre>
mymy=# <b>select check_q1();</b>
 check_q1 
----------
 correct
(1 row)

mymy=# <b>select check_q6b();</b>
 check_q6b 
-----------
 correct
(1 row)
</pre>
<p>
If a test fails, you can check the expected results via, e.g.
</p>
<pre>
mymy=# <b>select * from q2_expected;</b>
 nstudents | nstaff | nboth 
-----------+--------+-------
     31361 |  24405 |     0
(1 row)

mymy=# <b>select * from q9a_expected;</b>
 objtype | objcode 
---------+---------
 stream  | BINFA1
(1 row)
</pre>
<p>
You can also get a better feel for the differences, especially
if they look similar visually, by doing e.g.
</p>
<pre>
mymy=# <b>(select * from q8(3202320)) except (select * from q8c_expected);</b>
INFO:  11337 / 216
   code   | term | prog |         name         | mark | grade | uoc 
----------+------+------+----------------------+------+-------+-----
 COMP4920 | 12s2 | 3645 | Professional Issues  |   41 | FL    |    
          |      |      | Overall WAM          |   52 |       | 141
(2 rows)
</pre>
<p>
The above actually highlighted a bug in the initial version of
<tt>check.sql</tt> where the trailing space at the end of
COMP4920's title had been omitted. The problem with the other
tuple is that it uses <tt>WAM</tt> rather than <tt>WAM/UOC</tt>.
</p>
<p>
Note that the checks use result <em>sets</em>, so the order of
tuples does not matter.
This is problematic for <tt>q8()</tt> where the tuples are
expected to be in a particular order.
However, if you get a <tt>correct</tt> message on the <tt>check_q8X()</tt>
tests, at least you know that you got the correct set of tuples.
</p>
<p>
If you want to run all of the tests, you can do it via:
</p>
<pre>
mymy=# <b>select * from check_all();</b>
 test |                 result                 
------+----------------------------------------
 q1   | correct
 q2   | correct
 q3   | correct
 q4a  | correct
 q4b  | correct
 q5   | correct
 q6a  | No q6 function; did it load correctly?
 q6b  | No q6 function; did it load correctly?
 q6c  | No q6 function; did it load correctly?
 q7a  | incorrect result tuples
 q7b  | correct
 q7c  | correct
 q8a  | incorrect result tuples
 q8b  | incorrect result tuples
 q8c  | incorrect result tuples
 q9a  | correct
 q9b  | correct
 q9c  | correct
 q10a | correct
 q10b | correct
 q10c | correct
(21 rows)
</pre>
<p>
This may take a while, especially if some of your queries are slow.
</p>
<p>
Note that it checks for missing functions and also gives
feedback about incorrect results.
It has messages other than <tt>incorrect result tuples</tt>;
it also checks for missing or extraneous result tuples.
</p>
<p>
If you have errors, you can always look at the expected
results and compare them manually to your results.
</p>
<p>
If you think that any of our expected results tables are
incorrect, let us know and we can make a new version of
<tt>check1.sql</tt> that you can reload.
</p>

<?=endPage()?>
