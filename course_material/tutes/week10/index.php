<?php
require("../../course.php");
const SHOW_ANSWERS = true;
echo startPage("Week 10","q+a","Relational Algebra, Transaction Processing");
?>

<h3>Relational Algebra</h3>

<ol>

<li>
<p>
Relational algebra operators can be <i>composed</i>.
What precisely does this mean? And why is it important?
</p>

<li>
<p>
The natural join ( <i>R</i> Join <i>S</i> ) joins two tables on
their common attributes.
Consider a theta-join ( <i>R</i> Join[<i>C</i>] <i>S</i> ) where
the join condition <i>C</i> is a conjunction of <i>R.A</i> = <i>S.A</i>
for each attribute <i>A</i> appearing in the schemas of both <i>R</i>
and <i>S</i> (i.e. it joins on the common attributes).
What is the difference between the above natural join and theta join?
</p>

<li>
<p>
The definition of relational algebra in lectures was based on <em>sets</em>
of tuples. In practice, commercial relational database management systems
deal with <em>bags</em> (or <em>multisets</em>) of tuples.
<p>
Consider the following relation that describes a collection of PCs
<p>
<center>
<b>PCs</b>
<table border=1 cellpadding=4>
<tr><th>Model</th><th>Speed</th><th>RAM</th><th>Disk</th><th>Price</th><tr>
<tr><td>1001</td><td>700</td><td>64</td><td>10</td><td>799</td></tr>
<tr><td>1002</td><td>1500</td><td>128</td><td>60</td><td>2499</td></tr>
<tr><td>1003</td><td>1000</td><td>128</td><td>20</td><td>1499</td></tr>
<tr><td>1004</td><td>1000</td><td>256</td><td>40</td><td>1999</td></tr>
<tr><td>1005</td><td>700</td><td>64</td><td>30</td><td>999</td></tr>
</table>
</center>
<p>
Consider a projection of this relation on the processor speed
attribute, i.e. <code>Proj[speed](PCs)</code>.
<ol type="a">
<li> What is the value of the projection as a set?
<li> What is the value of the projection as a bag?
<li> What is the average speed if the projection is a set?
<li> What is the average speed if the projection is a bag?
<li> Is the minimum/maximum speed different between the bag and set representation?
</ol>
</p>

<li>
<p>
Consider the following two relations:
<p>
<center>
<table border=0 cellpadding=10>
<tr>
<td valign=top align=center>
   <b>R</b>
   <table border=1 cellpadding=4>
   <tr><th>A</th><th>B</th><th>C</th></tr>
   <tr><td>a1</td><td>b1</td><td>c1</td></tr>
   <tr><td>a1</td><td>b2</td><td>c2</td></tr>
   <tr><td>a2</td><td>b1</td><td>c1</td></tr>
   </table>
</td>
<td> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td>
<td valign=top align=center>
   <b>S</b>
   <table border=1 cellpadding=4>
   <tr><th>B</th><th>C</th></tr>
   <tr><td>b1</td><td>c1</td></tr>
   <tr><td>b2</td><td>c2</td></tr>
   </table>
</td>
</tr>
</table>
</center>
<p>
Give the relation that results from each of the following
relational algebra expressions on these relations:
</p>

<ol type='a'>
<li>
<p>
<i>R</i> Div <i>S</i>
</p>
<li>
<p>
<i>R</i> Div (Sel[B != b1](<i>S</i>))
</p>
<li>
<p>
<i>R</i> Div (Sel[B != b2](<i>S</i>))
</p>
<li>
<p>
<i>R</i> &times; <i>S</i>) - (Sel[R.C=S.C](<i>R</i> Join[B=B] <i>S</i>)
</p>
</ol>

<li>
<p>
Consider two relations <i>R1</i> and <i>R2</i>, where <i>R1</i> contains
<i>N1</i> tuples and <i>R2</i> contains <i>N2</i> tuples, and 
<i>N1</i> &gt; <i>N2</i> &gt; 0.
Give the minimum and maximum possible sizes (in tuples) for the
result relation produced by each of the following relational algebra
expressions.
In each case state any assumptions about the schemas of <i>R1</i> and
<i>R2</i> that are needed to make the expression meaningful.
<p>
<ol type="a">
<li> <i>R1</i> Union <i>R2</i>
<li> <i>R1</i> Intersect <i>R2</i>
<li> <i>R1</i> - <i>R2</i>
<li> <i>R1</i> &times; <i>R2</i>
<li> Sel<small>[a=5]</small>(<i>R1</i>)
<li> Proj<small>[a]</small>(<i>R1</i>)
<li> <i>R1</i> Div <i>R2</i>
</ol>
</p>

<li>
<p>
<small>(Date, exercise 6.11)</small>
Let <i>A</i> and <i>B</i> be two arbitrary relations.
In terms of the keys of <i>A</i> and <i>B</i>, state
the keys for each of the following RA expressions.
Assume in each case that <i>A</i> and <i>B</i> meet the requirements
of the operation (e.g. they are union-compatible for the Union and
Intersect operations).
</p>

<ol type='a'>
<li>
<p>
Sel<small>[<i>cond</i>]</small>(<i>A</i>),
	&nbsp;  where <i>cond</i> is any condition
</p>
<li>
<p>
Proj<small>[<i>attrs</i>]</small>(<i>A</i>), 
	&nbsp; where <i>attrs</i> is any set of atributes
</p>
<li>
<p>
<i>A</i> &times; <i>B</i>
</p>
<li>
<p>
<i>A</i> Union <i>B</i>
</p>
<li>
<p>
<i>A</i> Intersect <i>B</i>
</p>
<li>
<p>
<i>A</i> - <i>B</i>
</p>
<li>
<p>
<i>A</i> Div <i>B</i>
</p>
</ol>

<li>
<p>Consider the following relational schema:</p>
<pre>
   Suppliers(<b>sid</b>, sname, address)
   Parts(<b>pid</b>, pname, colour)
   Catalog(<b><i>supplier</i></b>, <b><i>part</i></b>, cost)
</pre>
<p>
Assume that the ids are integers,
that <code>cost</code> is a real number,
that all other attributes are strings,
that the <code><b><i>supplier</i></b></code> field 
is a foreign key containing a supplier id,
and
that the <b><i>part</i></b> field is a foreign key
containing a part id.
Write a relational algebra expression to answer each
of the following queries:
</p>
<ol type='a'>
<li>
<p>
Find the <i>names</i> of suppliers who supply some red part.
</p>
<li>
<p>
Find the <i>sids</i> of suppliers who supply some red or green part.
</p>
<li>
<p>
Find the <i>sids</i> of suppliers who supply some red part or
whose address is 221 Packer Street.
</p>
<li>
<p>
Find the <i>sids</i> of suppliers who supply some red part and some green part.
</p>
<li>
<p>
Find the <i>sids</i> of suppliers who supply every part.
</p>
<li>
<p>
Find the <i>sids</i> of suppliers who supply every red part.
</p>
<li>
<p>
Find the <i>sids</i> of suppliers who supply every red or green part.
</p>
<li>
<p>
Find the <i>sids</i> of suppliers who supply every red part
or supply every green part.
</p>
<li>
<p>
Find the <i>pids</i> of parts that are supplied by at least two
different suppliers.
</p>
<li>
<p>
Find pairs of <i>sids</i> such that the supplier with the first <i>sid</i>
charges more for some part than the supplier with the second sid.
</p>
<li>
<p>
Find the <i>pids</i> of the most expensive part(s) supplied by suppliers
named "Yosemite Sham".
</p>
<li>
<p>
Find the <i>pids</i> of parts supplied by every supplier at a price less
than 200 dollars (if any supplier either does not supply the part or charges
more than 200 dollars for it, the part should not be selected).
</p>
</ol>

<li>
<p>
Using the Suppliers-Parts-Catalog schema from the previous question,
state what the following relational algebra expressions compute:
</p>
<ol type='a'>
<li>
<pre>
Proj<small>[sname]</small>(
	Proj<small>[sid]</small>(Sel<small>[colour='red']</small>(Parts))
	Join
	Sel<small>[cost&lt;100]</small>(Catalog)
	Join
	Suppliers
)
</pre>
<li>
<pre>
Proj<small>[sname]</small>(
	Proj<small>[sid]</small>(
		Sel<small>[colour='red']</small>(Parts)
		Join
		Sel<small>[cost&lt;100]</small>(Catalog)
		Join
		Suppliers
	)
)
</pre>
<li>
<pre>
Proj<small>[sname]</small>(
	Sel<small>[colour='red']</small>(Parts)
	Join
	Sel<small>[cost&lt;100]</small>(Catalog)
	Join
	Suppliers
)
Intersect
Proj<small>[sname]</small>(
	Sel<small>[colour='green']</small>(Parts)
	Join
	Sel<small>[cost&lt;100]</small>(Catalog)
	Join
	Suppliers
)
</pre>
<li>
<pre>
Proj<small>[sid]</small>(
	Sel<small>[colour='red']</small>(Parts)
	Join
	Sel<small>[cost&lt;100]</small>(Catalog)
	Join
	Suppliers
)
Intersect
Proj<small>[sid]</small>(
	Sel<small>[colour='green']</small>(Parts)
	Join
	Sel<small>[cost&lt;100]</small>(Catalog)
	Join
	Suppliers
)
</pre>
<li>
<pre>
Proj<small>[sid,sname]</small>(
	Proj<small>[sid,sname]</small>(
		Sel<small>[colour='red']</small>(Parts)
		Join
		Sel<small>[cost&lt;100]</small>(Catalog)
		Join
		Suppliers
	)
	Intersect
	Proj<small>[sid,sname]</small>(
		Sel<small>[colour='green']</small>(Parts)
		Join
		Sel<small>[cost&lt;100]</small>(Catalog)
		Join
		Suppliers
	)
)
</pre>
</ol>

<li>
<p>
Consider the following relational schema containing flight, aircraft
and pilot information for an airline:
</p>
<pre>
Flights(<b>flno</b>, from, to, distance, departs, arrives)
Aircraft(<b>aid</b>, aname, cruisingRange)
Certified(<b><i>employee</i></b>, <b><i>aircraft</i></b>)
Employees(<b>eid</b>, ename, salary)
</pre>
<p>
The <code>Flights</code> relation describes a particular timetabled
fight from a source (city) to a destination (city) at a particular time
each week.
Note that this schema doesn't model which specific aircraft makes
the flight.
The <code>Aircraft</code> relation describes individual planes,
with the <code>aname</code> field containing values like
<code>'Boeing 747'</code>, <code>'Airbus A300'</code>, etc.
The <code>Certified</code> relation indicates which pilots (who
are employees) are qualified to fly which aircraft.
The <code><b><i>employee</i></b></code> field contains the <i>eid</i> of the
pilot, while the <code><b><i>aircraft</i></b></code> field contains
Finally, the <code>Employees</code> relation contains information
about all of the employees of the airline, including the pilots.
</p>
<p>
Write, where possible, a relational algebra expression
to answer each of the following queries.
If it is not possible to express any query in relational
algebra, suggest what extra mechanisms might make it possible.
</p>
<ol type='a'>
<li>
<p>
Find the <i>ids</i> of pilots certified for 'Boeing 747' aircraft.
</p>
<li>
<p>
Find the <i>names</i> of pilots certified for 'Boeing 747' aircraft.
</p>
<li>
<p>
Find the <i>ids</i> of all aircraft that can be used on non-stop
flights from New York to Los Angeles.
</p>
<li>
<p>
Identify the flights that can be piloted by a pilot whose salary
is more than $100,000.
</p>
<li>
<p>
Find the names of pilots who can operate planes with a range greater
than 3000 miles, but are not certified on 'Boeing 747' aircraft.
</p>
<li>
<p>
Find the total amount paid to employees as salaries.
</p>
<li>
<p>
Find the <i>ids</i> of employees who make the highest salary.
</p>
<li>
<p>
Find the <i>ids</i> of employees who make the second highest salary.
</p>
<li>
<p>
Find the <i>ids</i> of employees who are certified for the largest
number of aircraft.
</p>
<li>
<p>
Find the <i>ids</i> of employees who are certified for exactly three
aircraft.
</p>
<li>
<p>
Find if there is any non-stop or single-stop way to travel by air
from Sydney to New York.
</p>
<li>
<p>
Is there a sequence of flights from Sydney to Timbuktu (somewhere 
in the middle of Africa)? Each flight in the sequence is required
to depart from the destination of the previous flight; the first
flight must leave Sydney, and the last flight must arrive in
Timbuktu, but there is no restriction on the number of intermediate
flights.
</p>
</ol>
</li>

</ol>

<h3>Transaction Processing</h3>

<ol start="10">

<li>
<p>
<small>[based on Ramakrishnan, ex.17.1]</small><br>
Give a brief definition for each of the following terms:
</p>
<ol type="a">
<li> transaction
<li> serializable schedule
<li> conflict-serializable schedule
<li> view-serializable schedule
</ol>


<li>
<p>
Draw the precedence graph for the following schedule (where <tt>C</tt> means "commit"):
</p>
<pre>
T1:      R(A) W(Z)                C
T2:                R(B) W(Y)        C
T3: W(A)                     W(B)     C
</pre>

<li>
<p>
<small>[based on Ramakrishnan, ex.17.2]</small><br>
Consider the following incomplete schedule <i>S</i>:
</p>
<pre>
T1: R(X) R(Y) W(X)           W(X)
T2:                R(Y)           R(Y)
T3:                     W(Y)
</pre>
<ol type="a">
<p><li>
Determine (by using a precedence graph) whether the schedule is conflict-serializable
<p><li>
Modify <i>S</i> to create a complete schedule that is conflict-serializable
</ol>

<li>
<p>
<small>[based on Ramakrishnan, ex.17.3]</small><br>
For each of the following schedules, state whether it is
conflict-serializable and/or view-serializable.
If you cannot decide whether a schedule belongs to either
class, explain briefly.
The actions are listed in the order they are scheduled,
and prefixed with the transaction name.
</p>
<ol type="a">
<p><li> <code>T1:R(X) T2:R(X) T1:W(X) T2:W(X)</code>
<p><li> <code>T1:W(X) T2:R(Y) T1:R(Y) T2:R(X)</code>
<p><li> <code>T1:R(X) T2:R(Y) T3:W(X) T2:R(X) T1:R(Y)</code>
<p><li> <code>T1:R(X) T1:R(Y) T1:W(X) T2:R(Y) T3:W(Y) T1:W(X) T2:R(Y)</code>
<p><li> <code>T1:R(X) T2:W(X) T1:W(X) T3:W(X)</code>
<!--
<p><li> <code>T1:R(X) T2:W(X) T1:W(X) T2:Abort T1:Commit</code>
<p><li> <code>T1:R(X) T2:W(X) T1:W(X) T2:Commit T1:Commit</code>
<p><li> <code>T1:W(X) T2:R(X) T1:W(X) T2:Abort T1:Commit</code>
<p><li> <code>T1:W(X) T2:R(X) T1:W(X) T2:Commit T1:Commit</code>
<p><li> <code>T1:W(X) T2:R(X) T1:W(X) T2:Commit T1:Abort</code>
-->
</ol>

<li>
<p>
Is the following schedule serializable? Show your working.
</p>
<pre>
T1:             R(X)W(X)W(Z)        R(Y)W(Y)
T2: R(Y)W(Y)R(Y)            W(Y)R(X)        W(X)R(V)W(V)
</pre>

</ol>

</body>
</html>
