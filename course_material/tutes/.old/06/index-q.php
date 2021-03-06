<? require("../../course.php");

echo startPage("Exercises 06","q+a","Database Programming with PHP");

//echo startPage("Exercises 07","q+a","Database Programming with PHP");

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
<li>
<p>
What is the difference between the following three PHP operators:
<code>=</code>, <code>==</code>, <code>===</code> ?
</p>

<li>
<p>
What is the effect of putting an <code>@</code> character at the
start of a function call? (e.g. writing <code>@pg_connect(...)</code>
rather than <code>pg_connect(...)</code>)?
</p>

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
<li><p>
<code>$res = pg_query($db, "select beer from Sells where price &lt; $max")</code>
</p>
<li><p>
<code>$ntups = pg_num_rows($res)</code>
</p>
<li><p>
<code>$tuple = pg_fetch_row($res)</code>
</p>
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

<li>
<p>
Repeat the previous question, but this time using functions only
from the <code>db.php</code> library.
</p>

<li>
<p>
Comparing the solutions to the two previous questions, the code
using the <tt>db.php</tt> library seemed simpler. One reason for
this is that you don't need to add explicit code to check for the
success or otherwise of the DB connection operation. Why do you not
need this check?
</p>

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

<li>
<p>
Write some PHP code that could be embedded in a Web page
to produce a list of bars and their addresses as an HTML table.
</p>

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

</body>
</html>
