<?php
require("../../course.php");
const SHOW_ANSWERS = true;
echo startPage("Week 05","q+a","Stored Functions in SQL and PLpgSQL");
?>

<ol>

<li>
<p>
Write a simple PLpgSQL function that returns the square
of its argument value. It is used as follows:
</p>
<pre>
mydb=> <b>select sqr(4);</b>
 sqr 
-----
  16
(1 row)

mydb=> <b>select sqr(1000);</b>
   sqr 
---------
 1000000
(1 row)
</pre>
<p>
Could we use this function in any of the following ways?
</p>
<pre>
select sqr(5.0);
select(5.0::integer);
select sqr('5');
</pre>
<p>
If not, how could we write a function to achieve this?
</p>

<li>
<p>
Write a PLpgSQL function that <q>spreads</q> the letters
in some text. It is used as follows:
</p>
<pre>
mydb=> <b>select spread('My Text');</b>
     spread
----------------
 M y   T e x t
(1 row)
</pre>
<p>
</p>


<li>
<p>
Write a PLpgSQL function to return a table of the first <i>n</i> positive
integers.
</p>
<p>
The fuction  has the following signature:
</p>
<pre>
create or replace function seq(n integer) returns setof integer
</pre>
<p>
and is used as follows:
</p>
<pre>
mydb=> <b>select * from seq(5);</b>
 seq
-----
  1
  2
  3
  4
  5
(5 rows)
</pre>

<li>
<p>
Generalise the previous function so that it returns a table of
integers, starting from <i>lo</i> up to at most <i>hi</i>, with an
increment of <i>inc</i>. The function should also be able to count
down from <i>lo</i> to <i>hi</i> if the value of <i>inc</i> is
negative. An <i>inc</i> value of 0 should produce an empty table.
Use the following function header:
</p>
<pre>
create or replace function seq(lo int, hi int, inc int) returns setof integer
</pre>
<p>
and the function would be used as follows:
</p>
<pre>
mydb=> select * from seq(2,7,2);
 val
-----
  2
  4
  6
(3 rows)
</pre>
<p>
Some other examples, in a more compact representation:
</p>
<pre>
seq(1,5,1)   <i>gives</i>   1  2  3  4  5
seq(5,1,-1)  <i>gives</i>   5  4  3  2  1
seq(9,2,-3)  <i>gives</i>   9  6  3
seq(2,9,-1)  <i>gives</i>   empty
seq(1,5,0)   <i>gives</i>   empty
</pre>
<p>
</p>

<li>
<p>
Re-implement the <code>seq(int)</code> function from above
as an <b>SQL function</b>, and making use of the generic
<code>seq(int,int,int)</code> function defined above.
</p>


<li>
<p>
Create a factorial function based on
the above sequence returning functions.
</p>
<pre>
create function fac(n int) returns integer
</pre>
<p>
Implement it as an <b>SQL function</b> (not a PLpgSQL function).
The obvious solution to this problem requires a
<code>product</code> aggregate, analogous to the <code>sum</code>
aggregate.
PostgreSQL does not actually have a <code>product</code> aggregate,
but for the purposes of this question, you can assume that it does,
and has the following interface:
</p>
<pre>
product(<i>list of integers</i>) returns integer
</pre>

</ol>

<br>
<div class="note">
<p>
Use the <a href="beer.dump">old Beers/Bars/Drinkers</a> database
in answering the following questions.
A summary schema for this database:
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
Primary key attributes are in <tt><b>bold</b></tt>. 
Foreign key attributes are in <tt><b><i>bold italic</i></b></tt>.
</p>
<p>
The examples below assume that the user is connected to a database
called <code>beer</code> containing an instance of the above schema.
</p>
</div>

<ol start='7'>

<li>
<p>
Write a PLpgSQL function called <tt>hotelsIn()</tt>
that takes a single argument giving the name of a suburb,
and returns a text string containing the names of all hotels
in that suburb, one per line.
</p>
<pre>
create function hotelsIn(_addr text) returns text
</pre>
<p>
The function is used as follows:
</p>
<pre>
beer=> <b>select hotelsIn('The Rocks');</b>
    hotelsin     
-----------------
 Australia Hotel+
 Lord Nelson    +
 
(1 row)
</pre>
<p>Can you explain what the <tt>'+'</tt>at the end of each line is?
And why it says <tt>(1 row)</tt>?
<p>
Note that the output from functions returning a single
<code>text</code> string and
looks better if you turn off <tt>psql</tt>'s output alignment
(via <code>psql</code>'s <code><b>\a</b></code> command)
and column headings
(via <code>psql</code>'s <code><b>\t</b></code> command).
<p>
Compare the aligned output above to the unaligned output below:
</p>
<pre>
beer=> <b>\a</b>
Output format is unaligned.
beer=> <b>\t</b>
Showing only tuples.
beer=> <b>select hotelsIn('The Rocks');</b>
Australia Hotel
Lord Nelson

</pre>
<p>
From now on, sample outputs for functions returning <code>text</code>
will assume that we have used <code><b>\a</b></code> and
<code><b>\t</b></code>.
</p>

<li>
<p>
Write a new PLpgSQL function called <tt>hotelsIn()</tt>
that takes a single argument giving the name of a suburb
and returns the names of all hotels in that suburb.
The hotel names should all appear
on a single line, as in the following examples:
</p>
<pre>
beer=> <b>select hotelsIn('The Rocks');</b>
Hotels in The Rocks:  Australia Hotel  Lord Nelson 

beer=> <b>select hotelsIn('Randwick');</b>
Hotels in Randwick:  Royal Hotel 

beer=> <b>select hotelsIn('Rendwik');</b>
There are no hotels in Rendwik
</pre>

<li>
<p>
Write a PLpgSQL procedure <code>happyHourPrice</code> that accepts
the name of a hotel, the name of a beer and the number of dollars
to deduct from the price, and returns a new price.
The procedure should check for the following errors:
</p>
<ul>
<li> non-existent hotel (invalid hotel name)
<li> non-existent beer (invalid beer name)
<li> beer not available at the specified hotel
<li> invalid price reduction (e.g. making reduced price negative)
</ul>
<p>
Use <code>to_char(price,'$9.99')</code> to format the prices.
</p>
<pre>
beer=> <b>select happyHourPrice('Oz Hotel','New',0.50);</b>
There is no hotel called 'Oz Hotel'

beer=> <b>select happyHourPrice('Australia Hotel','Newer',0.50);</b>
There is no beer called 'Newer'

beer=> <b>select happyHourPrice('Australia Hotel','New',0.50);</b>
The Australia Hotel does not serve New

beer=> <b>select happyHourPrice('Australia Hotel','Burragorang Bock',4.50);</b>
Price reduction is too large; Burragorang Bock only costs $ 3.50

beer=> <b>select happyHourPrice('Australia Hotel','Burragorang Bock',1.50);</b>
Happy hour price for Burragorang Bock at Australia Hotel is $ 2.00
</pre>
<p>
</p>

<li>
<p>
The <code>hotelsIn</code> function above returns a formatted string
giving details of the bars in a suburb. If we wanted to return a
table of records for the bars in a suburb, we could use a view as
follows:
</p>
<pre>
beer=> <b>create or replace view HotelsInTheRocks as</b>
    -> <b>select * from Bars where addr = 'The Rocks';</b>
CREATE VIEW
beer=> <b>select * from HotelsInTheRocks;</b>
      name       |   addr    | license 
-----------------+-----------+---------
 Australia Hotel | The Rocks |  123456
 Lord Nelson     | The Rocks |  123888
(2 rows)
</pre>
<p>
Unfortunately, we need to specify a suburb in the view definition.
It would be more useful if we could define a <q>parameterised view</q>
which we could use to generate a table for any suburb, e.g.
</p>
<pre>
beer=> <b>select * from HotelsIn('The Rocks');</b>
      name       |   addr    | license 
-----------------+-----------+---------
 Australia Hotel | The Rocks |  123456
 Lord Nelson     | The Rocks |  123888
(2 rows)
beer=> <b>select * from hotelsIn('Coogee');</b>
       name       |  addr  | license 
------------------+--------+---------
 Coogee Bay Hotel | Coogee |  966500
(1 row)
</pre>
<p>
Such a parameterised view can be implemented via an SQL function,
defined as:
</p>
<pre>
create or replace function hotelsIn(text) returns setof Bars
as $$ ... $$ language sql;
</pre>
<p>
Complete the definition of the SQL function.
</p>

<li>
<p>
The function for the previous question can also be implemented in
PLpgSQL. Give the PLpgSQL definition. It would be used in the same
way as the above.
</p>

</ol>

<div class="note">
<p>
Use the
<a href="bank/index.html">Bank Database</a>
in answering the following questions.
A summary schema for this database:
</p>
<pre>
Branches(<b>location</b>:text, address:text, assets:real)
Accounts(<i><b>holder</b></i>:text, <i><b>branch</b></i>:text, balance:real)
Customers(<b>name</b>:text, address:text)
Employees(<b>id</b>:integer, name:text, salary:real)
</pre>
<p>
The examples below assume that the user is connected to a database
called <code>bank</code> containing an instance of the above schema.
</p>
</div>


<ol start='12'>

<li>
<p>
For each of the following, write both an SQL and a PLpgSQL
function to return the result:
</p>

<ol type='a'>
<li><p>
salary of a specified employee
</p>

<li><p>
all details of a particular branch
</p>

<li><p>
names of all employees earning more than $<i>sal</i>
</p>

<li><p>
all details of highly-paid employees
</p>
</ol>

<li>
<p>
Write a PLpgSQL function to produce a report giving
details of branches:
<ul>
<li> name and address of branch
<li> list of customers who hold accounts at that branch
<li> total amount in accounts held at that branch
</ul>
Use the following format for each branch:
</p>
<pre>
Branch: Clovelly, Clovelly Rd.
Customers:  Chuck Ian James
Total deposits: $   8860.00
</pre>
<p>
</p>

</ol>

<div class="note">
<p>
Use the following database schema, which is somehwat similar to the
schema for Assignment 2.
The schema is too large to give a complete summary here, but we provide
some details for some tables:
</p>
<pre>
Term(<b>id</b>:integer, year:integer, session:('S1','S2','X1','X2'), ...)
Subject(<b>id</b>:integer, code:text, ..., name:text, ... uoc:integer, ...)
Course(<b>id</b>:integer, <i>subject</i>:integer, <i>term</i>:integer, <i>lic</i>:integer, ...)
OrgUnit(<b>id</b>, <i>utype</i>, name, longname, ...)
OrgUnitType(<b>id</b>, name)
Person(<b>id</b>:integer, ..., name:text, ...)
Student(<i><b>id</b></i>:integer, sid:integer, stype:('local','intl'))
Staff(<i><b>id</b></i>:integer, sid:integer, <i>office</i>:integer, ...)
StaffRole(<b>id</b>, descript)
Affiliation(<b><i>staff</i></b>, <b><i>orgunit</i></b>, <i>role</i>, fraction)
</pre>
<p>
Note that there is an example database <a href="unsw.dump">unsw.dump</a>
(3.5MB)
that you could load into a newly created database to help with these
problems, although you should be able to solve them without reference
to a specific database instance.
Note that all of the people data in this database is synthetic and
the various enrolment tables have been cleared to save space.
</p>
<p>
The examples below assume that the user is connected to a database
called <code>unsw</code> containing an instance of the above schema.
</p>
</div>

<ol start='14'>

<li>
<p>
Write a PLpgSQL function to produce the complete name of an
organisational unit (aka OrgUnit), given the OrgUnit's internal
id:
</p>
<pre>
function unitName(_ouid integer) returns text
</pre>
<p>
This will need to make use of the <tt>OrgUnit</tt> and <tt>OrgUnitType</tt>
tables.
The <tt>OrgUnitType</tt> table contains a list of unit types (e.g.
faculty, school, institute) via <i>(id,name)</i> tuples.
The <tt>OrgUnit</tt> table has a foreign key to the <tt>OrgUnitType</tt>
table to indicate what kind of unit it is.
The <tt<longname</tt> attribute contains the useful name of the unit
(the <tt>name</tt> attribute is a very abbreviated version of the unit's name).
The <tt>longname</tt> attribute for faculties already contains the words
"Faculty of". For other kinds of <tt>OrgUnit</tt>, you need to prepend
the name of its <tt>OrgUnitType</tt>.
</p>
<p>
The function returns the complete name using the rules:
<ul>
<li> the university is denoted by UNSW
<li> a faculty is denoted using its base name <small>(not all faculty names start with Faculty)</small>
<li> a school is denoted School of XYZ
<li> a department is denoted Department of XYZ
<li> a centre is denoted Centre for XYZ
<li> an institute is denoted Institute of XYZ
<li> other kinds of OrgUnits are treated as having no name (i.e. return null)
</ul>
<p>
Some examples of usage (assuming <tt>\a</tt> and <tt>\t</tt>):
</p>
<pre>
unsw=> select unitName(0);
UNSW

unsw=> select unitName(2);
Faculty of Arts and Social Sciences

unsw=> select unitName(4);
Faculty of Law

unsw=> select unitName(9);
Faculty of Engineering

unsw=> select unitName(11);
Faculty of Science

unsw=> select unitName(36);
School of Chemistry

unsw=> select unitName(44);
School of Computer Science and Engineering

unsw=> select unitName(75);
Centre for Human Geography

unsw=> select unitName(92);
Department of Korean Studies

unsw=> select unitName(999);
ERROR:  No such unit: 999
</pre>


<li>
<p>
In the previous question, you needed to know the internal ID of
an <tt>OrgUnit</tt>. This is unlikely, so write a function that
takes part of an <tt>OrgUnit.longname</tt> and returns the ID
or <tt>NULL</tt> if there is no such unit.
If there is more than one matching unit, return the ID of the
first matching  unit.
Implement this as an SQL function, which allows case-insensitive
matching:
</p>
<pre>
create or replace function unitID(partName text) returns integer
as $$ ... $$ language sql;
</pre>
<p>
Examples of usage:
</p>
<pre>
unsw=> select unitName(unitID('law'));
Faculty of Law

unsw=> select unitName(unitID('arts'));
Faculty of Arts and Social Sciences

unsw=> select unitName(unitID('information'));
School of Information Management

unsw=> select unitName(unitID('information sys'));
School of Information Systems

unsw=> select unitName(unitID('chem'));
Department of Biochemistry

unsw=> select unitName(unitID('computer'));
School of Computer Science (ADFA)

unsw=> select unitName(unitID('comp%sci%eng'));
School of Computer Science and Engineering

unsw=> select unitName(unitID('korean'));
Department of Korean Studies
</pre>
<p>
We use <tt>unitName()</tt> as a way of checking the result
Note that such a simple text-based search can produce unexpected results.
</p>

<li>
<p>
Write a PLpgSQL function which takes the numeric identifier of
a given OrgUnit and returns the numeric identifier of the parent
faculty for the specified OrgUnit:
</p>
<pre>
function facultyOf(_ouid integer) returns integer
</pre>
<p>
Note that a faculty is treated as its own parent. Note also that
some OrgUnits don't belong to any faculty; such OrgUnits should
return a null result from the function.
</p>
<p>
Examples of use:
</p>
<pre>
unsw=> select unitName(facultyof(2));
Faculty of Arts and Social Sciences

unsw=> select unitName(facultyof(9));
Faculty of Engineering

unsw=> select unitName(facultyof(36));
Faculty of Science

unsw=> select unitName(facultyof(44));
Faculty of Engineering

unsw=> select unitName(facultyof(75));
Faculty of Science

unsw=> select unitName(facultyof(92));
Faculty of Arts and Social Sciences

unsw=> select unitName(facultyof(999));
ERROR:  No such unit: 999
</pre>

</body>
</html>

