<? require("../../course.php");

echo startPage("Exercises 06","q+a","Database Programming with PHP");
//alternativeViews();

//echo startPage("Exercises 07","q+a","Database Programming with PHP");
//alternativeViews();

?>

<p>
Use the beers/bars/drinkers database in answering the database-related
questions below:
</p>
<pre>
Beers(<b>name</b>:string, manufacturer:string)
Bars(<b>name</b>:string, address:string, license#:integer)
Drinkers(<b>name</b>:string, address:string, phone:string)
Likes(<b><i>drinker</i></b>:string, <b><i>beer</i></b>:string)
Sells(<b><i>bar</i></b>:string, <b><i>beer</i></b>:string, price:real)
Frequents(<b><i>drinker</i></b>:string, <b><i>bar</i></b>:string)
</pre>
<p>
Assume that the database is called <code>GoodPubGuide</code>.
You wil need to consult the <a href="http://php.net/manual/en/">PHP manual</a> to find out what library
functions are available. The most useful sections are:
PostgreSQL functions,
String functions,
Array functions,
and Variable functions.
</p>

<ol>

<li>
<p>
For the following sequence of PHP statements, state the type and
value of the variable <code>$x</code> after each assignment:
</p>
<pre>
$x = 3.0;
$x = (int)$x / 2;
$x = 1 + (int)$x * 2;
$x = "$x times $x";
$x = $x * 5 / 3;
$x = 'Why $x?';
$x = $x + 3.14159;
</pre>
<?=startAnswer()?>
<pre>
$x = 3.0;                 // $x == float(3.0)
$x = (int)$x / 2;         // $x == float(1.5)
$x = 1 + (int)$x * 2;     // $x == int(3)
$x = "$x times $x";       // $x == string("3 times 3")
$x = $x * 5 / 3;          // $x == int(5)
$x = 'Why $x?';           // $x == string("Why $x?")
$x = $x + 3.14159;        // $x == float(3.14159)
</pre>
<p>
You could use PHP's <code>var_dump</code> function to check these.
</p>
<?=endAnswer()?>
<li>
<p>
What is the difference between the following three PHP operators:
<code>=</code>, <code>==</code>, <code>===</code> ?
</p>
<?=startAnswer()?>

<ul>
<li>
The <code>=</code> operator represents assignment.
Its left-hand-side must be a variable, and its right-hand-side
is an expression. The expression is evaluated and cast to an
appropriate type to assign to the variable.
</li>
<li>
The <code>==</code> operator represents the equality test.
Its left-hand-side and right-hand-sides are both expressions.
Both expressions are evaluated, cast to compatible types,
and their values are compared. If the values are equal,
the result is <code>true</code>, otherwise <code>false</code>.
</li>
<li>
The <code>===</code> operator represents the exact equality test.
Its left-hand-side and right-hand-sides are both expressions.
Both expressions are evaluated, then the types of the results are
compared. If the types are different, the result is <code>false</code>.
If the types are the same, the expression values are then compared.
If the values are equal,
the result is <code>true</code>, otherwise <code>false</code>.
</li>
</ul>
<?=endAnswer()?>

<li>
<p>
What is the effect of putting an <code>@</code> character at the
start of a function call? (e.g. writing <code>@pg_connect(...)</code>
rather than <code>pg_connect(...)</code>)?
</p>
<?=startAnswer()?>
<p>
PHP normally (on grieg) produces an error message on the standard
output stream when a function fails for some reason. The message
may occur in addition to the function return a distinguished
value that indicates an error (e.g. <code>pg_connect(...)</code>
returns <code>false</code> if it cannot establish a database
connection).
In some contexts, you don't want the error message to be written
(e.g. you don't want it to appear in the middle of a Web page).
The <code>@</code> character suppresses error message for the
duration of the function call, so that can get the return value,
check for error and then handle it in a way that's appropriate
for the script.
</p>
<p>
Note that <code>@</code> has this behaviour when used at the start
of any expression, not just a function call.
If the error is a fatal run-time error, then the script will exit
without any error messages being produced. The <code>@</code>
character should be used sparingly, or not at all, during
debugging.
</p>
<?=endAnswer()?>

<li>
<p>
For each of the following PHP statements, list the possible errors that
might occur and state what value would be assigned to the variable on
the left-hand side of the assignment, if an error occurs.
</p>
<ol type='a'>
<li><p>
<code>$db = pg_connect("dbname=abc user=fred password=$secret")</code>
</p>
<?=startAnswer()?>
<ul>
<li> <code>abc</code> is not the name of a database on the PostgreSQL server
<li> <code>fred</code> is not the name of a user on the PostgreSQL server
<li> <code>$secret</code> has no value
<li> <code>$secret</code> has a value which is not <code>fred</code>'s password
<li> returns <code>false</code> on error
</ul>
<p>
<?=endAnswer()?>
<li><p>
<code>$res = pg_query($db, "select beer from Sells where price &lt; $max")</code>
</p>
<?=startAnswer()?>
<ul>
<li> value of <code>$db</code> is not be a valid database connection resource
<li> <code>$max</code> is not set (giving invalid SQL syntax for query)
<li> <code>$max</code> has a non-numeric value (giving invalid SQL syntax for qu
ery)
<li> returns <code>false</code> on error
</ul>
<p>
<?=endAnswer()?>
<li><p>
<code>$ntups = pg_num_rows($res)</code>
</p>
<?=startAnswer()?>
<ul>
<li> <code>$res</code> does not have a valid query result resource value
<li> returns <code>-1</code> on error
<br>
        (zero is valid return value ... for queries with no result tuples)
</ul>
<p>
<?=endAnswer()?>
<li><p>
<code>$tuple = pg_fetch_row($res)</code>
</p>
<?=startAnswer()?>
<ul>
<li> <code>$res</code> does not have a valid query result resource value
<li> there may be no more tuples left in the query result set <code>$res</code>
<br>
        (this is not really an error; it's a condition for terminating the query
 iteration)
<li> returns <code>null</code> on error
</ul>
<?=endAnswer()?>
</ol>

<li>
<p>
Consider the <tt>mkSQL()</tt> function for building SQL queries.
What is the output from the following PHP code?
</p>
<pre>
&lt;?
$x = 25;  $y = "O'Brien";  $z = "'%'; delete from Employees";

echo mkSQL("select * from Employees where age &gt; %d", $x);
echo "\n";
echo mkSQL("select * from Employees where name like %s", $x);
echo "\n";
echo mkSQL("select * from Employees where name = %d", $y);
echo "\n";
echo mkSQL("select * from Employees where name like %s", $y);
echo "\n";
echo mkSQL("select * from Employees where name like %s", $z);
echo "\n";
echo mkSQL("select * from Employees where salary > 50000");
echo "\n";
echo mkSQL("select * from Employees where name like %s and age = %d", $y, $x);
echo "\n";
?&gt;
</pre>
<?=startAnswer()?>
<p>
The output would look something like the following:
</p>
<pre>
select * from Employees where age > 25
select * from Employees where name like '25'
select * from Employees where name = 0
select * from Employees where name like 'O''Brien'
select * from Employees where name like '''%''; delete from Employees'
select * from Employees where salary > 50000
select * from Employees where name like 'O''Brien' and age = 25
</pre>
<p>
Notice that there are no semi-colons at the end of each query.
This doesn't matter if you intend to run the queries via
<tt>dbQuery()</tt>, but would matter if you wanted to feed them
directly into <tt>psql</tt>.
Note also that the attempted SQL injection attack is nullified
by the way <tt>mkSQL()</tt> deals with strings.
<?=endAnswer()?>

<li>
<p>
Using only the functions from the PostgreSQL library,
write PHP code that displays the <code>Bars</code> relation
in the following format:
</p>
<pre>
  # Name                      Address
 -- -------------------- ------------
  1 Australia Hotel         The Rocks
  2 Coogee Bay Hotel           Coogee
  3 Lord Nelson             The Rocks
  4 Marble Bar                 Sydney
  5 Regent Hotel            Kingsford
  6 Royal Hotel              Randwick
</pre>
<p>
The <code>#</code> field is a count value that is computed as the
entries in the relation are displayed.
PHP supports the <code>printf</code> function. The Name field
should be displayed left-justified in a field of width 20, and
the Address field should be displayed right-justified in a
field of width 12 (count the '-' above).
You can also assume that there will never be more than 99 bars.
</p>
<?=startAnswer()?>
<pre>
&lt;?
$conn = @pg_connect("dbname=GoodPubGuide");
if (!$conn)
	exit("Cannot connect to database.\\n");

$result = @pg_query($conn, "select * from Bars");
if (!$result)
	exit("Can't get result for query.\\n");

print "  # Name                      Address\\n";
print " -- -------------------- ------------\\n";
$num = pg_num_rows($result);;
for ($i = 0; $i &lt; $num; $i++){
	$tuple = pg_fetch_row($result, $i);
	$name = $tuple[0];
	$addr = $tuple[1];
	printf("%d %-20s %12s\\n", $i+1, $name, $addr);
}
?&gt;
</pre>
Note that <code>print</code> and <code>echo</code> are almost
synonymous.
I tend to use <code>echo</code> in my code, as opposed to what I
write in tutorial solutions, because it's one char less to type,
and marginally more convenient for stringing together a list of things
to be printed.
<p>
An alternative, more compact, solution for the query iteration part:
</p>
<pre>
printf("  # %-20s %12s\\n", "Name", "Address");
print " -- -------------------- ------------\\n";
for ($i = 1; $t = pg_fetch_array($result); $i++)
	printf(" %2d %-20s %12s\\n", $i, $t["name"], $t["addr"]);
</pre>
<p>
Note that this loop uses iteration starting from 1, not 0, and does
not supply and position argument to <code>pg_fetch_row</code> (which
uses an internal counter to iterate from first result to last result
if no position argument is given).
</p>
<p>
It also uses <code>pg_fetch_array()</code> rather <code>pg_fetch_row()</code>
to get the tuples. What's the difference? <code>pg_fetch_row()</code>
give you back each tuple as an array with numeric indexes; so you need
to refer to the attributes by position. <code>pg_fetch_array()</code>
give you the tuple as an array indexed both numerically and by the
attribute names, which makes it simpler to collect the value of a
specific attribute.
</p>
<p>
Yet another, even more compact, alternative for the iteration:
</p>
<pre>
$i = 0;
while ($t = pg_fetch_array($result))
	printf(" %2d %-20s %12s\\n", $i++, $name, $addr);
</pre>
<?=endAnswer()?>

<li>
<p>
Repeat the previous question, but this time using functions only
from the <code>db.php</code> library.
</p>
<?=startAnswer()?>
<pre>
&lt;?
require("db.php");

$db = dbConnect("dbname=GoodPubGuide");
$q = "select * from Bars";
$r = dbQuery($db, mkSQL($q));

echo "  # Name                      Address\\n";
echo " -- -------------------- ------------\\n";
while ($t = dbNext($r))
	printf(" %2d %-20s %12s\\n", $i, $t["name"], $t["addr"]);
?&gt;
</pre>
<?=endAnswer()?>

<li>
<p>
Comparing the solutions to the two previous questions, the code
using the <tt>db.php</tt> library seemed simpler. One reason for
this is that you don't need to add explicit code to check for the
success or otherwise of the DB connection operation. Why do you not
need this check?
</p>
<?=startAnswer()?>
One difference between <tt>pg_connect()</tt> and <tt>dbConnect()</tt>
is that <tt>dbConnect()</tt> checks for the success of the database
connection and does not return if the database cannot be connected to.
In contrast, <tt>pg_connect()</tt> returns a value that can be
interpreted as <tt>false</tt> if it cannot establish a database
connection.
<?=endAnswer()?>

<li>
<p>
Write PHP code that prints a table of average prices for beers,
in the format shown below:
<pre>
BEER                   AVG$
-------------------- ------
Burragorang Bock       3.50
New                    3.26
Old                    2.53
Old Admiral            3.75
Sparkling Ale          2.80
Three Sheets           3.75
Victoria Bitter        2.40
</pre>
The table should be printed in alphabetical order on beer name,
and the the average price should be displayed to two decimal
places.
Use the <code>printf</code> format string <code>"%-20.20s&nbsp;%6.2f"</code>
to display each line of the table.
</p>
<?=startAnswer()?>
<p>
The first solution below uses an "obvious" approach:
get the beers one-by-one; for each beer, get its average price.
However, this is a <em>poor</em> way to solve
the problem, despite the fact that it produces the correct output.
However, it does show a use for the printf-like interpolation
provided by <tt>mkSQL()</tt>.
</p>
<pre>
&lt;?
require("db.php");
$db = dbConnect("dbname=GoodPubGuide");
$q = "select name from Beers order by name";
$r = dbQuery($db, mkSQL($q));
echo "BEER                   AVG$\\n";
echo "-------------------- ------\\n";
$qq = "select avg(price) from Sells where beer = %s";
while ($t = dbNext($r)) {
	$avg = dbOneValue($db, mkSQL($qq, $t["name"]));
	printf("%-20.20s %6.2f\\n", $t["name"], $avg);
}
?&gt;
</pre>
<p>
Since there are 19 beers in the database,
the above code requires 19 separate queries, which means 19 transmissions
from the PHP engine to the database system (not a cheap operation), when
it can easily be solved using a single query. Use the database to do all
of the <q>data-crunching</q>; don't do this in PHP. You should almost never
need to use <code>dbQuery()</code> inside a loop for another query. You
should try, whereever possible, to get the required data for each PHP script
using a single query. Even if the data requires complex manipulation,
so that you can't do it in one pass from the DB, it's cheaper to load
it into a (big) PHP array and then manipulate it there, than to invoke
many queries on the database.
</p>
<p>
The following version achieves the same result in a single query,
thus making more effective use of the database.
</p>
<pre>
&lt;?
require("db.php");
$db = dbConnect("dbname=GoodPubGuide");
$q = "select beer, avg(price) from Sells group by beer order by beer";
$r = dbQuery($db, mkSQL($q));
echo "BEER                   AVG$\\n";
echo "-------------------- ------\\n";
while ($t = dbNext($r))
	printf("%-20.20s %6.2f\\n", $t["beer"], $t["avg"]);
?&gt;
</pre>
<?=endAnswer()?>

<li>
<p>
Write some PHP code that could be embedded in a Web page
to produce a list of bars and their addresses as an HTML table.
</p>
<?=startAnswer()?>
<pre>
&lt;?
require("db.php");
$db=dbConnect("dbname=GoodPubGuide");
$result = dbQuery($db, "select name,addr from Bars");
if (!is_resource($result)) exit( "Can't get result for query.\\n");
echo &lt;&lt;&lt;TableHead
&lt;table border=1 cellpadding=5 cellspacing=0&gt;
&lt;tr&gt;&lt;td&gt;#&lt;/td&gt;&lt;td&gt;&lt;b&gt;Name&lt;/b&gt;&lt;/td&gt;&lt;td align="right"&gt;&lt;b&gt;Address&lt;/b&gt;&lt;/tr&gt;\\n
TableHead;
while ($tuple = dbNext($result)) {
	list($name,$addr) = $tuple;
	echo "&lt;tr&gt;&lt;td&gt;$i&lt;/td&gt;&lt;td&gt;$name&lt;/td&gt;".
	     "&lt;td align=right&gt;$addr&lt;/td&gt;&lt;/tr&gt;\\n";
}
echo "&lt;/table&gt;\n";
?&gt;
</pre>
<p>
Note that the <q>heredoc</q> (string inside <code>TableHead</code>)
uses an explicit newline char at the end of the last line.
</p>
<?=endAnswer()?>

<li>
<p>
Write a PHP web script that accepts a single CGI parameter
giving the name of a drinker, and displays information about
that drinker: name, address, phone, beers drunk, bars frequented.
<!--Use the Assignment 2 <tt>http.php</tt> library to process the CGI parameter.-->
The script could be invoked using a URL like:
</p>
<pre>
http://...../drinker.php?drinker=John
</pre>
<?=startAnswer()?>
<p>
</p>
<pre>
&lt;?
// collect CGI parameter; fail if none provided

$v = getParams(array(
        'name' => array("string","required")
));

$db=dbConnect("dbname=GoodPubGuide");

// collec basic information about drinker
$q = "select name,addr,phone from Drinkers where name = %s";
$drinker = dbOneTuple($db, mkSQL($q, $v["drinker"]);
if (empty($drinker)) {
	echo "&lt;html&gt;&lt;body&gt;&lt;center&gt;No Such Drinker&lt;/center&gt;&lt;/body&gt;&lt;/html&gt;\\n";
	exit;
}

// collect beers liked in an array of beer names
// and then convert array to html string
$q = "select beer from Likes where drinker = %s";
$r = dbQuery($db, mkSQL($q, v["drinker"]));
$beers = array();
while ($t = dbNext($r)) $beers[] = $t["beer"];
if (count($beers &gt; 0)
	$beers = join("&lt;br&gt;",$beers);
else
	$beers = "No beers liked";

// collect bars frequented in an array of bar names
// and then convert array to html string
$q = "select bar from Frequents where drinker = %s";
$r = dbQuery($db, mkSQL($q, v["drinker"]));
$bars = array();
while ($t = dbNext($r)) $bars[] = $t["bar"];
if (count($bars &gt; 0)
	$bars = join("&lt;br&gt;",$bars);
else
	$bars = "No bars liked";

// Rest of script produces HTML
// Note the embedded PHP to produce the values computer above
?&gt;
&lt;html&gt;
&lt;head&gt;&lt;title&gt;Display Drinker Info&lt;/title&gt;&lt;/head&gt;
&lt;body&gt;
&lt;h3&gt;Drinker Information&lt;/h3&gt;
&lt;table cellpadding="10"&gt;
&lt;tr&gt;&lt;td&gt; Name &lt;/td&gt;&lt;td&gt; &lt;?=$drinker["name"]?&gt; &lt;/td&gt;&lt;tr&gt;
&lt;tr&gt;&lt;td&gt; Address &lt;/td&gt;&lt;td&gt; &lt;?=$drinker["addr"]?&gt; &lt;/td&gt;&lt;tr&gt;
&lt;tr&gt;&lt;td&gt; Phone &lt;/td&gt;&lt;td&gt; &lt;?=$drinker["phone"]?&gt; &lt;/td&gt;&lt;tr&gt;
&lt;tr&gt;&lt;td&gt; Beers Liked &lt;/td&gt;&lt;td&gt; &lt;?=$beers?&gt; &lt;/td&gt;&lt;tr&gt;
&lt;tr&gt;&lt;td&gt; Favourite Bars &lt;/td&gt;&lt;td&gt; &lt;?=$bars?&gt; &lt;/td&gt;&lt;tr&gt;
&lt;/table&gt;
&lt;/body&gt;
&lt;/html&gt;
</pre>
<?=endAnswer()?>

</body>
</html>
