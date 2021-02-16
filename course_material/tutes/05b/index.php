<? require("../../course.php");

//echo startPage("Exercises 06","q","Constraints, Triggers, Aggregates, and Catalogs");
//alternativeViews();


echo startPage("Exercises 05b","q+a","Constraints, Triggers, and Aggregates");
//alternativeViews();

?>

<ol>

<li>
<p>
What is the SQL command used in PostgreSQL to define a trigger?
And what is the SQL command to remove it?
</p>
<?=startAnswer()?>
<p>
Trigger functions are defined using the SQL <tt>CREATE FUNCTION</tt>
command. A trigger function should be defined as accepting no arguments, and
returns a value of the special <tt>TRIGGER</tt> data type.
The syntax for defining a PLpgSQL function is:
</p>
<pre>
CREATE FUNCTION <i>function_name</i> () RETURNS trigger
AS $$
   DECLARE
      <i>declarations</i>;
      [...]
   BEGIN
      <i>statements</i>;
      [...]
   END;
$$ LANGUAGE plpgsql;
</pre>
<p>
A trigger is defined with the SQL CREATE TRIGGER command with syntax as:
<pre>
CREATE TRIGGER <i>trigger_name</i>
               BEFORE <i>operation</i>
               ON <i>table_name</i> FOR EACH ROW
               EXECUTE PROCEDURE <i>function_name()</i>;
</pre>
or
<pre>
CREATE TRIGGER <i>trigger_name</i>
               AFTER <i>operation</i>
               ON <i>table_name</i> FOR EACH ROW
               EXECUTE PROCEDURE <i>function_name()</i>;
</pre>
<p>
where <tt><i>operation</i></tt> is one of
<tt>INSERT</tt> or <tt>DELETE</tt> or <tt>UPDATE</tt>
</p>
<p>
You can assign one trigger to several operations via
</p>
<pre>
(BEFORE|AFTER) <i>op<sub>1</sub></i> OR <i>op<sub>2</sub></i> OR ...
</pre>
<p>
Triggers are removed via the SQL statement:
</p>
<pre>
DROP TRIGGER <i>trigger_name</i> ON <i>table_name</i>;
</pre>
<p>
Note that this does not remove any past effects caused by the trigger.
</p>
<?=endAnswer()?>

<li>
<p>
Give examples of when you might use a trigger <tt>BEFORE</tt>
and <tt>AFTER</tt> ... 
</p>
<ol type="a">
<li><p>
an insert operation 
</p>
<?=startAnswer()?>
<ul>
<li> a trigger <em>before</em> an insert might check for valid values
	of the fields (e.g. referential integrity checks),
	or perhaps generate additional values, such
	as timestamps, to be included in the newly-inserted tuple
<li> a trigger <em>after</em> an insert might perform additional database
	updates to ensure semantic consistency of the database, such
	as enforcing inter-table dependencies (e.g. installing a
	count of tuples in one relation into another)
</ul>
<?=endAnswer()?>
<li><p>
an update operation 
</p>
<?=startAnswer()?>
<ul>
<li> a trigger <em>before</em> an update might check for valid values
	of the modified fields, or generate a new timestamp to be
	included in the modified tuple
<li> a trigger <em>after</em> an update might do similar maintenance
	of database consistencies as an insert trigger
</ul>
<?=endAnswer()?>
<li><p>
a delete operation 
</p>
<?=startAnswer()?>
<ul>
<li> a trigger <em>before</em> a delete might check referential integrity
	constraints (e.g. can't delete a tuple because it has tuples
	in other relations referring to it)
<li> a trigger <em>after</em> a delete might do similar maintenance
	of database consistencies as an insert/update trigger
</ul>
<?=endAnswer()?>
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
<?=startAnswer()?>
<p>
Note: in the solution below, <tt>TG_OP</tt> is a special variable
that tell the trigger function which operation caused it to be
invoked. This is useful when a trigger is defined to act on more
than one type of operation (as in the trigger below, which acts
for delete and update).
</p>
<pre>
create trigger R_pk_check before insert or update on R
for each row execute procedure R_pk_check();

create function R_pk_check() returns trigger
as $$
begin
	if (new.a is null or new.b is null) then
		raise exception 'Partially specified primary key for R';
	end if;
	if (TG_OP = 'UPDATE' and old.a=new.a and old.b=new.b) then
		return;
	end if;
	select * from R where a=new.a and b=new.b;
	if (found) then
		raise exception 'Duplicate primary key for R';
	end if;
end;
$$ language plpgsql;
</pre>
<?=endAnswer()?>
<li><p>
foreign key constraint between <code>T.j</code> and <code>S.x</code>
</p>
<?=startAnswer()?>
<pre>
create trigger T_fk_check before insert or update on T
for each row execute procedure T_fk_check();

create function T_fk_check() returns trigger
as $$
begin
	select * from S where x=new.k;
	if (not found) then
		raise exception 'Non-existent S.x key in T';;
	end if;
end;
$$ language plpgsql;

-- assuming that we do *not* want "on delete cascade" semantics

create trigger S_refs_check before delete or update on S
for each row execute procedure S_refs_check();

create function S_refs_check() returns trigger
as $$
begin
	if (TG_OP = 'UPDATE' and old.x=new.x) then
		return;
	end if;
	select * from T where k=old.<font color=red>x</font>;
	if (found) then
		raise exception 'References to S.x from T';;
	end if;
end;
$$ language plpgsql;
</pre>
<?=endAnswer()?>
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
<?=startAnswer()?>
<p>
There is no effective difference in the action of the two
triggers for this case. The update only effects one tuple,
and so each trigger is activated once for that tuple.
</p>
<?=endAnswer()?>
<li><p>
<code>update S set y = y + 1 where x &gt; 5;</code>
</p>
<?=startAnswer()?>
<p>
Trigger <code>updateS1</code> will cause <code>updateS()</code>
to be executed on each of the affected tuples (the ones with
primary key values (6,7,8,9)).
</p>
<p>
Trigger <code>updateS2</code> will cause <code>updateS()</code>
to be executed once, after all of the affected tuples have been
modified, but before the updates have been committed.
</p>
<p>
In both cases, if the function fails, none of the updates will
take place (i.e. they are not committed).
</p>
<?=endAnswer()?>
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
<?=startAnswer()?>
The problem with these triggers occurs on either an insert on
<code>Table1</code> or an update on <code>Table2</code>.
When either trigger is activated, it unconditionally executes
an SQL statement that will activate the other trigger, leading
to an infinite sequence of trigger activations.
<?=endAnswer()?>

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
<?=startAnswer()?>
<pre>
drop if exists table emp;
create table emp (
    empname text primary key,
    salary integer,
    last_date timestamp,
    last_user text

create or replace function emp_stamp () returns trigger
as $$
begin
    -- Check that empname and salary are given
    if new.empname is null then
        raise exception 'empname cannot be NULL value';
    end if;
    if new.salary is null then
        raise exception '% cannot have NULL salary', new.empname;
    end if;

    -- Who would works if they had to pay to do it?
    if new.salary < 0 then
        raise exception '% cannot have a negative salary', new.empname;
    end if;

    -- Remember who changed the payroll when
    new.last_date := now();
    new.last_user := user();
    return new;
end;
$$ language plpgsql;

create trigger emp_stamp before insert or update on emp
    for each row execute procedure emp_stamp();
</pre>
<p>
If these were used in a sample database called <tt>mydb</tt>,
with an initially empty <tt>emp</tt> table, the effect would
appear like this:
</p>
<pre>
mydb=> insert into emp values ('John',50000);
INSERT 478005 1
mydb=> select * from emp; 
 empname | salary |           last_date           | last_user 
---------+--------+-------------------------------+-----------
 John    |  50000 | 2002-09-16 17:30:38.613018+10 | jas
(1 row)

mydb=> update emp set salary=60000 where empname='John';
UPDATE 1
mydb=> select * from emp; 
 empname | salary |           last_date           | last_user 
---------+--------+-------------------------------+-----------
 John    |  60000 | 2002-09-16 17:31:33.141904+10 | jas
(1 row)
</pre>
<?=endAnswer()?>

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
<?=startAnswer()?>
<pre>
create or replace function ins_stu() returns trigger as $$
begin
	update course set numStudes=numStudes+1 where code=new.course;
	return new; -- return value is ignore for AFTER triggers
end;
$$ language plpgsql;

create or replace function del_stu() returns trigger as $$
begin
   	update course set numStudes=numStudes-1 where code=old.course;  
	return old; -- return value is ignore for AFTER triggers
end;
$$ language plpgsql;

create or replace function upd_stu() returns trigger as $$
begin
	update course set numStudes=numStudes+1 where code=new.course;
	update course set numStudes=numStudes-1 where code=old.course; 
	return new; -- return value is ignore for AFTER triggers
end;
$$ language plpgsql;

create or replace function chk_quo() returns trigger as $$
declare
	quota_filled boolean;
begin 
        select into quota_filled (numStudes >= quota)
        from Course where code = new.course;
        if (quota_filled) then
                raise exception 'Class % is full', new.course;
        end if;
	return new;
end;
$$ language plpgsql;

create trigger ins_stu after insert on enrolment
    for each row execute procedure ins_stu();

create trigger del_stu after delete on enrolment
    for each row execute procedure del_stu();

create trigger upd_stu after update on enrolment
    for each row execute procedure upd_stu();

create trigger chk_quo before insert or update on enrolment
    for each row execute procedure chk_quo();
</pre>
<?=endAnswer()?>

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
It should also calaculate a new shipment ID (one higher than the
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
<?=startAnswer()?>
<pre>
create function new_shipment() returns trigger as $$
declare
    cust_id     integer;    -- customer ID
    book_isbn   text;       -- isbn of new book
    shipment_id integer;    -- shipment ID number
    right_now   timestamp;  -- current time
begin
    -- If there is no matching customer id number, raise an exception.
    select into cust_id id from customers where id = new.customer_id;
    if not found then
      raise exception 'Invalid customer ID number.';
    end if;
    
    -- If there is no matching ISBN, raise an exception.
    select into book_isbn isbn from editions where isbn = new.isbn;
    if not found then
      raise exception 'Invalid ISBN.';
    end if;
    
    -- If the previous checks succeeded, update the stock amount
    -- for INSERT commands.
    if TG_OP = 'INSERT' then
       update Stock set numInStock=numInStock-1 where isbn = new.isbn;
    elsif new.isbn <> old.isbn THEN
       update Stock set numInStock=numInStock+1 where isbn = OLD.isbn;
       update Stock set numInStock=numInStock-1 where isbn = new.isbn;
    end if;
     
     -- Set the current time variable to current time.
    right_now := now();
     
     -- Generate a new shipment_id
    select into shipment_id max(id) from shipments order by id desc;
    shipment_id := shipment_id + 1;

    -- Set the values in the new tuple
    new.id := shipment_id;
    new.ship_date := right_now;
    
    return new;
end;
$$ language plpgsql;

create trigger check_shipment before insert or update
on Shipments for each row execute procedure shipment_addition();
</pre>
<?=endAnswer()?>

<li>
<p>
Suggest a PostgreSQL <tt>CREATE TABLE</tt> definition that would
ensure that all of the effects in the previous question happened
automatically.
</p>
<?=startAnswer()?>
<p>
The above triggers implement referential integrity checks and 
introduce default values. The same effect could be achieved via:
</p>
<pre>
create table Shipments (
    id        serial    primary key,
    -- or id  integer   default netxval('Shipments_id_seq') primary key
    customer  integer   references Customer(id),
    isbn      text      references Editions(id),
    ship_date timestamp default now()
</pre>
<?=endAnswer()?>

</body>
</html>
