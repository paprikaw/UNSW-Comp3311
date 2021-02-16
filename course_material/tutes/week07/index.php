<?php
require("../../course.php");
const SHOW_ANSWERS = true;
echo startPage("Week 07","q+a","Constraints, Triggers, and Aggregates");
?>

<ol>

<li>
<p>
Consider a schema for an organisation
</p>
<pre>
Employee(<b>id</b>:integer, name:text, <i>works_in</i>:integer, salary:integer, ...)
Department(<b>id</b>:integer, name:text, <i>manager</i>:integer, ...)
</pre>
<p>
Where <tt>works_in</tt> is a foreign key indicating which Department
an Employee works in, and <tt>manager</tt> is a foreign key indicating
which Employee is the manager of a Department.
</p>
<p>
A manager must work in the Department they manage. Can this be checked
by standard SQL table constraints? If not, why not?
</p>
<p>
If it cannot be checked by standard SQL constraints, write an assertion
to ensure that each manager also works in the department they manage.
Define using a standard SQL assertion statement like:
</p>
<pre>
create assertion manager_works_in_department
check  ...
</pre>
</li>

<li>
<p>
Using the same schema from the previous question,
write an assertion to ensure that no employee in a department
earns more than the manager of their department.
Define using a standard SQL assertion statement like:
</p>
<pre>
create assertion employee_manager_salary
check  ...
</pre>

<li>
<p>
What is the SQL command used in PostgreSQL to define a trigger?
And what is the SQL command to remove it?
</p>
</li>

<li>
<p>
Trigers can be defined as <tt>BEFORE</tt> or <tt>AFTER</tt>.
What exactly are they <i>before</i> or <i>after</i>?
</p>
</li>

<li>
<p>
Give examples of when you might use a trigger <tt>BEFORE</tt>
and <tt>AFTER</tt> ... 
</p>
<ol type="a">
<li><p>
an insert operation 
</p>
<li><p>
an update operation 
</p>
<li><p>
a delete operation 
</p>
</ol>

<li>
<p>
Consider the following relational schema:
</p>
<pre>
create table R(a int, b int, c text, primary key(a,b));
create table S(x int primary key, y int);
create table T(j int primary key, k int references S(x));
</pre>
</p>
State how you could use triggers to implement the following
constraint checking
(hint: revise the material on Constraint Checking from the Relational Data Model and ER-Relational Mapping extended notes)
</p>
<ol type="a">
<li><p>
primary key constraint on relation <code>R</code>
</p>
<li><p>
foreign key constraint between <code>T.j</code> and <code>S.x</code>
</p>
</ol>

<li>
<p>
Explain the difference between these triggers
</p>
<pre>
   create trigger updateS1 after update on S
   for each row execute procedure updateS();

   create trigger updateS2 after update on S
   for each statement execute procedure updateS();
</pre>
<p>
when executed with the following statements.
Assume that <code>S</code> contains primary keys (1,2,3,4,5,6,7,8,9).
</p>
<ol type="a">
<li><p>
<code>update S set y = y + 1 where x = 5;</code>
</p>
<li><p>
<code>update S set y = y + 1 where x &gt; 5;</code>
</p>
</ol>

<li>
<p>
What problems might be caused by the following pair of triggers?
</p>
<pre>
create trigger T1 after insert on Table1
for each row execute procedure T1trigger();

create trigger T2 after update on Table2
for each row execute procedure T2trigger();

create function T1trigger() returns trigger
as $$
begin
update Table 2 set Attr1 = ...;
end; $$ language plpgsql;

create function T2trigger() returns trigger
as $$
begin
insert into Table1 values (...);
end; $$ language plpgsql;
</pre>
</p>

<li>
<p>
Given a table:
</p>
<pre>
   Emp(<b>empname</b>:text, salary:integer, last_date:timestamp, last_usr:text)
</pre>
<p>
Define a trigger that ensures that any time a row is inserted or updated in
the table, the current user name and time are stamped into the row. The trigger
should also ensure that an employee's name is given and that the salary has
a positive value.
</p>
<p>
The two PostgreSQL builtin functions <tt>user()</tt> and <tt>now()</tt>
will provide the values that you need for the <q>stamp</q>.
</p>

<li>
<p>
Consider the following relational schema:
</p>
<pre>
   Enrolment(<b>course</b>:char(8), <b>sid</b>:integer, mark:integer)
   Course(<b>code</b>:char(8), lic:text, quota:integer, numStudes:integer);
</pre>
<p>
Define triggers which keep the <tt>numStudes</tt> field in the
<tt>Course</tt> table consistent with the number of enrolment
records for that course in the <tt>Enrolment</tt> table, and
also ensure that new enrolment records are rejected if they
would cause the quota to be exceeded.
</p>

<li>
<p>
Consider the following (partial) relational schema:
</p>
<pre>
   Shipments(<b>id</b>:integer, <i>customer</i>:integer, <i>isbn</i>:text, ship_date:timestamp)
   Editions(<b>isbn</b>:text, title:text, <i>publisher</i>:integer, published:date, ...)
   Stock(<b><i>isbn</i></b>:text, numInStock:integer, numSold:integer)
   Customer(<b>id</b>:integer, name:text, ...)
</pre>
<p>
Define a PLpgSQL trigger function <tt>new_shipment()</tt>
which is called after each <tt>INSERT</tt> or <tt>UPDATE</tt> operation
is performed on the <tt>Shipments</tt> table. 
</p>
<p>
The <tt>new_shipment()</tt> function should check to make sure
that each added shipment contains a valid customer ID number and
a valid ISBN. It should then update the stock information:
<ul>
<li> for an <tt>INSERT</tt>, subtract one from the total amount of stock
	and add one to the number sold
<li> for an <tt>UPDATE</tt>, if the change involves the book, then
	restore the <tt>Stock</tt> entry for the old book and update
	the <tt>Stock</tt> entry for the new book
</ul>
<p>
It should also calculate a new shipment ID (one higher than the
previous highest) and ensure that it is placed in the
<tt>shipment_id</tt> field of the new tuple.
It should also set the time-stamp for the new tuple to the current time.
<p>
Under this scheme, tuples would be inserted into the <tt>Shipments</tt>
table as:
</p>
<pre>
insert into Shipments(customer,isbn) values (9300035,'0-8053-1755-4');
</pre>

<li>
<p>
Suggest a PostgreSQL <tt>CREATE TABLE</tt> definition that would
ensure that all of the effects in the previous question happened
automatically.
</p>
</li>

<li>
<p>
Consider the following typical components of a PostgreSQL
user-defined aggregate definition:
</p>
<pre>
CREATE AGGREGATE AggName(BaseType) (
    stype     = ...,
    initcond  = ...,
    sfunc     = ...,
    finalfunc = ...,
);
</pre>
<p>
Explain what each one does, and how they work together to
produce the aggregation result.
</p>
</li>

<li>
<p>
Imagine that PostgreSQL did not have an <tt>avg()</tt> aggregate
to compute the mean of a column of <tt>numeric</tt> values.
How could you implement it using a PostgreSQL user-defined
aggregation definition (called <tt>mean</tt>)?
Assume that it ignores <tt>null</tt> values.
If the column is empty (has no values) return <tt>null</tt>.
</p>
</li>

<li>
<p>
How could you get the mean of a column of values without having
to write your own aggregation operation?
Assume a simple table with schema: <tt>R(...,a:integer,...)</tt>.
</p>
</li>

</ol>

</body>
</html>
