<? require("../../course.php"); require("defs.php"); ?>
<?=startPage("Assignment 2","","Queries and Functions on MyMyUNSW")?>
<?=updateBlurb().scriptMenu($menu)?>

<h2>Aims</h2>
<p>
This assignment aims to give you practice in
</p>
<ul>
<li> reading and understanding a moderately large relational schema (MyMyUNSW)
<li> implementing SQL queries and views to satisfy requests for information
<li> implementing PLpgSQL functions to aid in satisfying requests for information
</ul>
<p>
The goal is to build some useful data access operations on the MyMyUNSW
database,
which contains a wealth of information about what happens at UNSW.
One aim of this assignment is to use SQL queries (packaged
as views) to extract such information.
Another is to build PlpgSQL functions that can support
higher-level activities, such as might be needed in a Web
interface.
</p>
</p>
<p>
A theme of this assignment is "dirty data". As I was building the database,
using a collection of reports from UNSW's information systems and the
database for the academic proposal system (MAPPS), I discovered
that there were some inconsistencies in parts of the data (e.g. duplicate
entries in the table for UNSW buildings, or students who
were mentioned in the student data, but had no enrolment records, and, worse,
enrolment records with marks and grades for students who did not exist in
the student data). I removed most of these problems as I discovered them,
but no doubt missed some. Some of the exercises below aim to uncover such
anomalies; please explore the database and let me know if you find
other anomalies.
</p>

<h2>Summary</h2>
<p>
<table cellpadding="8">
<tr valign="top">
<td> <b>Submission</b>: </td>
<td> Login to Course Web Site &gt; Assignments
	&gt; Assignment 2 &gt; [Submit] &gt; upload <tt>ass2.sql</tt><br>
	or, on a CSE server, <tt>give cs3311 ass2 ass2.sql</tt> </td>
</tr>
<tr valign="top">
<td> <b>Required Files</b>: </td>
<td> <tt>ass2.sql</tt> &nbsp; <small>(contains both SQL views and PLpgSQL functions)</small> </td>
</tr>
<tr valign="top">
<td> <b>Deadline</b>: </td>
<td> 15:00 Monday 2 November </td>
</tr>
<tr valign="top">
<td> <b>Marks</b>: </td>
<td> <b>16 marks</b> toward your total mark for this course </td>
</tr>
<tr valign="top">
<td> <b>Late Penalty</b>: </td>
<td> 0.1 <i>marks</i> off the ceiling mark for each hour late </td>
</tr>
</table>
<p>
How to do this assignment:
</p>
<ul>
<li> read this specification carefully and completely
<li> create a directory for this assignment
<li> copy the supplied files into this directory
<li> login to <tt>grieg</tt> and run your PostgreSQL server
<li> load the database and start exploring
<li> complete the tasks below by editing <tt>ass2.sql</tt>
<li> submit <tt>ass2.sql</tt> via WebCMS or <tt>give</tt>
</ul>
<p>
Details of the above steps are given below. Note that you can
put the files wherever you like; they do not have to be under
your <tt>/srvr</tt> directory. You also edit your SQL files
on hosts other than <tt>grieg</tt>. The only time that
you need to use <tt>grieg</tt> is to manipulate your database.
</p>

<h2>Introduction</h2>

<p>
All Universities require a significant information infrastructure in order
to manage their affairs. This typically involves a large commercial DBMS
installation.
UNSW's student information system sits behind the MyUNSW web site.
MyUNSW provides an interface to a PeopleSoft enterprise management
system with an underlying Oracle database. This back-end system
(Peoplesoft/Oracle) is sometimes called NSS. The specific version of
PeopleSoft that we use is called Campus Solutions.
</p>
<p>
Despite its successes, however, MyUNSW/NSS still has a number of
deficiencies, including:
<ul>
<li> no easy way to swap classes once enrolled
<li> no representation for degree program structures
<li> poor integration with the UNSW Online Handbook
</ul>
The first point is inconvenient, since it means that the only way for
a student to change tute classes is to drop the course and re-enrol
into the course, selecting th new tute. If the course is already full,
students would be unwilling to drop the course in case someone else
grabs their place before they can re-enrol.
<p>
The second point prevents MyUNSW/NSS from being used for three
important operations that would be extremely helpful to students
in managing their enrolment:
</p>
<ul>
<li> finding out how far they have progressed through their degree
    program, and what remains to be completed
<li> checking what are their enrolment options for next semester
    (e.g. get a list of <q>suggested</q> courses)
<li> determining when they have completed all of the requirements
    of their degree program and are eligible to graduate
</ul>
<p>
In this assignment, you will be working with two instances
of a database to hold information about academic matters at
UNSW.
The first database instance contains data from 2000 to 2015.
The second database instance will contain data from 2014 to 2019.
Note that all <tt>People</tt> data about students, and much of the
<tt>People</tt> data about staff is synthetic.
</p>

<h2>Doing this Assignment</h2>

<p>
The following sections describe how to carry out this assignment.
Some of the instructions must be followed exactly; others require
you to exercise some discretion. The instructions are targetted at
people doing the assignment on Grieg. If you plan to work on this
assignment at home on your own computer, you'll need to adapt the
instructions to <q>local conditions</q>.
</p>
<p>
If you're doing your assignment on the CSE machines,
some commands must be carried out on <tt>grieg</tt>,
while others can (and probably should) be done on a
CSE machine other than <tt>grieg</tt>.
In the examples below, we'll use <tt>grieg$</tt> to
indicate that the comand must be done on <tt>grieg</tt>
and <tt>cse$</tt> to indicate that it can be done elsewhere.
</p>

<h3>Setting Up</h3>
<p>
The first step in setting up this assignment is to set up a
directory to hold your files for this assignment.
</p>
<pre>
cse$ <b>mkdir /my/dir/for/ass2</b>
cse$ <b>cd /my/dir/for/ass2</b>
cse$ <b>cp <?="$asDir/ass2.sql"?> ass2.sql</b>
</pre>
<p>
Note that the database dump is quite large.
It's not worth copying it into your assignment directory
on the CSE servers, because you only need to read it
once to build your database (see below).
If you're working at home, you will need to copy it
onto your home machine to load the database.
</p>
<p>
The next step is to set up your database:
</p>
<pre>
<span class="comment">... login to Grieg and source env as usual ...</span>
grieg$ <b>dropdb mymy</b>  <span class="comment">... if you already had such a database</span>
grieg$ <b>createdb mymy</b>
grieg$ <b>bzcat <?="$asDir/mymy1.dump.bz2"?> | psql mymy</b>
grieg$ <b>psql mymy</b>
<span class="comment">... examine the database contents ...</span>
</pre>
<p>
The database loading should take less than 60 seconds on Grieg, assuming
that Grieg is not under heavy load.
(If you leave your assignment until the last minute, loading the database
on Grieg will be considerably slower, thus delaying your work even more.
The solution: at least load the database <em>Right Now</em>, even if you
don't start using it for a while.)
(Note that the <tt>mymyunsw.dump</tt> file is 50MB in size; copying it under
your home directory or your <tt>srvr/</tt> directory is not a good idea).
</p>
<p>
If you have other large databases under your PostgreSQL server on Grieg
or you have large files under your <tt>/srvr/<i>YOU</i>/</tt> directory,
it is possible that you will exhaust your Grieg disk quota. In particular,
you will not be able to store two copies of the MyMyUNSW database under
your Grieg server. The solution: remove any existing databases before
loading your MyMyUNSW database.
</p>
<p>
If you're running PostgreSQL at home, the file
<a href="ass2.zip"><tt>ass2.zip</tt></a> contains
copies of the files: <tt>mymy1.dump.bz2</tt>, <tt>ass2.sql</tt>
to get you started.
You can grab the <tt>check1.sql</tt> script separately,
once it becomes available.
If you copy <tt>ass2.zip</tt> to your home computer, unzip it,
and perform commands analogous to the above, you should have a
copy of the MyMyUNSW database that you can use at home to do this
assignment.
</p>
<p>
Think of some questions you could ask on the database (e.g. like
the ones in the Online Problem-solving Sessions) and work out
SQL queries to answer them.
</p>
<p>
One useful query is
</p>
<pre>
mymy=# <b>select * from dbpop();</b>
</pre>
<p>
This will give you a list of tables and the number of tuples in each.
Some tables are empty, and are not relevant to this assignment.
They are included for the sake of "completeness", i.e. to show
what kinds of data might be stored in a real database to replace
MyUNSW/NSS.
</p>

<h2>Your Tasks</h2>
<p>
Answer each of the following questions by typing SQL or PLpgSQL
into the <tt>ass2.sql</tt> file.
You may find it convenient to work on each question in a temporary
file, so that you don't have to keep loading <em>all</em> of the
other views and functions each time you change the one you're
working on.
Note that you can add as many auxuliary views and functions to
<tt>ass2.sql</tt> as you want.
However, make sure that <em>everything</em> that's required to
make all of your views and functions work ends up in the
<tt>ass2.sql</tt> file before you submit.
</p>


<h3>Q1 <span class='marks'>(1 mark)</span></h3>

<p>
Define an SQL view <tt>Q1(unswid,name)</tt> that gives the student id
and name of any student who has studied more than 65 courses at UNSW.
The name should be take from the <tt>People.name</tt> field for the
student, and the student id should be taken from <tt>People.unswid</tt>.
</p>


<h3>Q2 <span class='marks'>(2 marks)</span></h3>

<p>
Define an SQL view <tt>Q2(nstudents,nstaff,nboth)</tt> which produces a
table with a single row containing counts of:
</p>
<ul>
<li> the total number of students (who are not also staff)
<li> the total number of staff (who are not also students)
<li> the total number of people who are both staff and student
</ul>


<h3>Q3 <span class='marks'>(2 marks)</span></h3>

<p>
Define an SQL view <tt>Q3(name,ncourses)</tt> that prints the name of
the person(s) who has been lecturer-in-charge (LIC) of the most courses
at UNSW and the number of courses they have been LIC for. In the database,
the LIC has the role of "Course Convenor".
</p>


<h3>Q4 <span class='marks'>(2 marks)</span></h3>

<p>
For the mymy1 database instance ... 
Define SQL view <tt>Q4a(id,name)</tt> which gives the student IDs and names of
all students enrolled in in the old Computer Science (3978) degree in 05s2.
</p>
<p>
For the mymy2 database instance ... 
Define an SQL view <tt>Q4b(id,name)</tt> which gives the student IDs
and names of all students enrolled in in the Computer Science (3778) degree
in 17s1.
</p>
<p>
Note: the student IDs are the UNSW id's (i.e. student numbers) defined in
the <tt>People.unswid</tt> field.
</p>
<p>
Each of the views will return an empty result in the database for which
it was not designed.
</p>


<h3>Q5 <span class='marks'>(3 marks)</span></h3>

<p>
Define an SQL view <tt>Q5(name)</tt> which gives the faculty with the
maximum number of committees. Include in the count for each faculty,
both faculty-level committees and also the committees under the
schools within the faculty. You can use the <tt>facultyOf()</tt> function
to help with this (the function is already available in the database).
You can assume that committees are defined only at the faculty and school
level.
</p>
<p>
Use the <tt>OrgUnits.name</tt> field as the faculty name.</span>
</p>


<h3>Q6 <span class='marks'>(1 mark)</span></h3>

<p>
Define an SQL function (SQL, <i>not</i> PLpgSQL) called <tt>Q6(id integer)</tt>
that takes as parameter either a <tt>People.id</tt> value (i.e. an
internal database identifier) or a <tt>People.unswid</tt> value
(i.e. a UNSW student ID), and returns the name of that person.
If the id value is invalid, return
<span class="red">NULL as the result</span>. You can assume
that <tt>People.id</tt> and <tt>People.unswid</tt> values come from
disjoint sets, so you should never return multiple names.
(It turns out that the sets aren't quite disjoint,
but I won't test any of the cases where the id/unswid sets overlap)
</p>
<p>
The function must use the following interface:
</p>
<pre>
create or replace function Q6(id integer) returns text ...
</pre>


<h3>Q7 <span class='marks'>(2 marks)</span></h3>

<p>
Define an SQL function (<i>not</i> PLpgSQL) called <tt>Q7(subject text)</tt>
that takes as parameter a UNSW subject code (e.g. 'COMP1917') and
returns a list of all offerings of the subject for which a
Course Convenor is known.
</p>
<p>
Note that this means
just the Course Convenor role, not Course Lecturer or any other role
associated with the course. Also, if there happen to be several
Course Convenors, they should all be returned (in separate tuples).
If there is no Course Convenor registered for a particular offering
of the course, then that course offering should not appear in the result.</span>
</p>
<p>
The function must use the following interface:
</p>
<pre>
create or replace function Q7(subject text) 
  returns table (subject text, term text, convenor text)
</pre>
<p>
The <tt>course</tt> field in the result tuples should be the UNSW
course code (i.e. that same thing that was used as the parameter).
If the parameter does not correspond to a known UNSW course,
then simply return an empty result set.
</p>

<h3>Q8 <span class='marks'>(5 marks)</span></h3>

<p>
Define a PLpgSQL function <tt>Q8(zid integer)</tt>, which
takes a student id and produces a transcript as a table of
<tt>TranscriptRecord</tt>s.
Each transcript record should contain information about
the student's attempt at a course.
Records should appear ordered by term; within a term, they
should be ordered by subject code.
</p>
<p>
Use the following definition for the transcript tuples:
</p>
<pre>
create type TranscriptRecord as (
        code  char(8), -- UNSW-style course code (e.g. COMP1021)
        term  char(4), -- semester code (e.g. 98s1)
        prog  char(4), -- program being studied in this semester
        name  text,    -- <span class="red">shortened</span> name of the course's subject
        mark  integer, -- numeric mark acheived
        grade char(2), -- grade code (e.g. FL,UF,PS,CR,DN,HD)
        uoc   integer  -- units of credit available for the course
);
</pre>
<p>
Note that this type is already defined in the database.
</p>
<p class="red">
All subject names should be truncated to 20 characters (hint: use
PostgreSQL's <tt>substr()</tt> function).
</p>
<p>
If no <tt>mark</tt> or <tt>grade</tt> is available for a course,
set those fields as null in the <tt>TranscriptRecord</tt>.
Only display a UOC value if the student actually passed the
course (i.e. has a grade from the set
{SY, PT, PC, PS, CR, DN, HD, A, B, C})
<span class="red">or has an XE grade (for credit from exchange) or a T grade
(transferred credit) or a PE grade (professional experience) or a RC or RS
grade (research courses)).</span>
Otherwise, leave the <tt>uoc</tt> field as null.
A null grade or any grade other than those just mentioned should not
be treated as a pass.
</p>
<p>
At the end of the transcript, add an extra <tt>TranscriptRecord</tt>
which contains
</p>
<pre>
(null, null, null, 'Overall WAM/UOC', <i>wamValue</i>, null, <i>UOCpassed</i>)
</pre>
<p>
where the <tt><i>wamValue</i></tt> and <tt><i>UOCpassed</i></tt>
are computed as follows:
<pre>
wamValue = weightedSumOfMarks / totalUOCattempted
UOCpassed = sum of UOC for all subjects passed
totalUOCattempted = sum of UOC for all subjects in transcript
weightedSumOfMarks = sum of mark*UOC for all subjects in transcript
</pre>
<p>
Do not include in the WAM calculations any course that has a null grade.
If a course <s>has a null mark but</s>
has a <span class="red">SY or XE T or PE</spann>
grade, include the UOC in the UOCpassed only.
Round the WAM value to the nearest integer.
</p>
<p>
If no courses have been completed, add the following tuple
at the end of the transcript:
</p>
<pre>
(null, null, null, 'No WAM available', null, null, null)
</pre>
<p>
If a student switches degrees part-way through their study,
just treat the transcript as all being related to a single program.
Even if they credit transferred from the first to the second program
(entries with a T grade) just count them all towards the total UOC.
</p>
<p>
How can you find interesting transcripts to look at?
The answer is to think of some properties of a transcript that
might make it interesting, and then ask a query to get information
about any students who have these kinds of transcripts.
I used the following query to find some students.
Work out what it does and then try variations to find other kinds
of "interesting" students:
</p>
<pre>
select p.unswid,pr.code,termName(min(pe.term)),count(*)
from   People p
         join Program_enrolments pe on (pe.student=p.id)
         join Programs pr on (pe.program=pr.id)
where  pr.code like '3%'
group  by p.unswid,pr.code
having count(*) &gt; 5;
</pre>

<h3>Q9 <span class='marks'>(5 marks)</span></h3>

<p>
An important part of defining academic rules in MyMyUNSW is the ability
to define groups of academic objects (e.g. groups of subjects, streams
or programs)
In MyMyUNSW, groups can be defined in three different ways:
</p>
<ul>
<li> <tt>enumerated</tt> by giving a list of objects in a <tt><i>X</i>_members</tt> table
<li> <tt>pattern</tt> by giving a pattern that identifies all relevant objects
<li> <tt>query</tt> by storing an SQL query which returns a set of object ids
</ul>
<p>
In all cases, the result is a set of academic objects of a specific type
(given in the <tt>gtype</tt> attribute).
</p>
<p>
Write a PLpgSQL function <tt>Q8(gid integer)</tt> that takes the internal
ID of an academic object group and returns the codes for all members
of the academic object group, including any child groups.
Associated with each code should be the
type of the corresponding object, either <tt>subject</tt>, <tt>stream</tt>
or <tt>program</tt>.
</p>
<p>
You should return distinct codes (i.e. ignore multiple
versions of any object), and there is no need to check whether the academic
object is still being offered.
</p>
<p>
The function is defined as follows:
</p>
<pre>
create or replace function Q9(gid integer) returns setof AcObjRecord
</pre>
<p>
where <tt>AcObjRecord</tt> is already defined in the database as follows:
</p>
<pre>
create type AcObjRecord as (
	objtype text,  -- academic object's type e.g. subject, stream, program
	objcode text   -- academic object's code e.g. COMP3311, SENGA1, 3978
);
</pre>
<p>
Groups of academic objects are defined in the tables:
</p>
<ul>
<li> <tt>acad_object_groups(id, name, gtype, glogic, gdefby, negated, parent, definition)</tt> <br>
where the most important fields are:
<ul>
<li> <tt>gtype</tt> ... what kind of objects in the group
<li> <tt>gdefby</tt> ... how the group is defined
<li> <tt>definition</tt> ... where queries or patterns are given
</ul>
<li> <tt>program_group_members(program, ao_group)</tt> ... for enumerated program groups
<li> <tt>stream_group_members(stream, ao_group)</tt> ... for enumerated stream groups
<li> <tt>subject_group_members(subject, ao_group)</tt> ... for enumerated subject groups
</ul>
<p>
There are a wide variety of patterns. You should explore the <tt>acad_object_groups</tt>
table yourself to see what's available. To give you a head start, here are some
existing patterns and what they mean:
</p>
<ul>
<li> <tt>COMP2###</tt> ... any level 2 computing course (e.g. COMP2911, COMP2041)
<li> <tt>COMP[34]###</tt> ... any level 3 or 4 computing course (e.g. COMP3311, COMP4181)
<li> <tt>####1###</tt> ... any level 1 course at UNSW
<li> <tt>(COMP|SENG|BINF)2###</tt> ... any level 2 course from CSE
<li> <tt>COMP1917,COMP1927</tt> ... core first year computing courses
<li> <tt>COMP1###,COMP2###</tt> ... same as <tt>COMP[12]###</tt>
</ul>
<p>
You do <em>not</em> need to handle any of the following types of academic object groups:
<ul>
<li> any groups defined using a query (<tt>gdefby='query'</tt>)
<li> any groups defined using negation (<tt>negated=true</tt>)
<li> any groups defined by a pattern which includes <tt>'FREE'</tt>, <tt>'GEN'</tt> or <tt>'F='</tt> as a substring
</ul>
<p>
For any group like the above, simply return no reults (zero rows).
You can also ignore the <tt>glogic</tt> field; treat them all as <tt>or</tt>
groups.
</p>
<p class="red">
If any group has a child group containing FREE, ignore just the child group.
For pattern groups, you do not need to check whether codes used in the
pattern correspond to real objects in the relevant table (e.g. a pattern
string may contain a subject code which does not exist in the <tt>Subjects</tt>
table)
</p>
<p>
Your function should be able to expand any pattern element from the above classes
of patterns (i.e. pattern elements that include <tt>#</tt>, <tt>[...]</tt> and
<tt>(...|...)</tt>).
If patterns include <tt>{xxx;yyy;zzz}</tt> alternatives, include all of the
alternatives as group members (i.e. as if they were <tt>xxx,yyy,zzz</tt>).
If patterns have child patterns, include all of the acdemic objects in the
child patterns.
You can recognise that a group with <tt>id=X</tt> has child groups,
by the existnce of other academic groups with <tt>parent=X</tt>.
</p>
<p>
<b>Hint:</b> In order to solve this, you'll probably need to look in the
PostgreSQL manual at Section 9.4 "String Functions and Operators" and
Section 42.5.4 "Executing Dynamic Commands".
</p>

<h3>Q10 <span class='marks'><span class='red'>(4 marks)</span></span></h3>

<p>
Define a PLpgSQL function that takes a subject code and
returns the set of all subjects that include this subject
in their pre-reqs.
This kind of function could help in planning what courses
you could study in subsequent semesters.
</p>
<p>
The function is defined as follows:
</p>
<pre>
create or replace function Q10(code text) returns setof text ...
</pre>
<p class="red">
You only need to consider literal subject codes (e.g. COMP1234) in the pre-reqs.
If a pre-req object group contains a pattern, ignore the pattern.
</p>
<p>
Hint: This function can probably make use of (a variation of) the
<tt>Q9()</tt> function.
</p>


<h3>Submission and Testing</h3>
<p>
We will test your submission as follows:
</p>
<ul>
<li>
create a testing subdirectory
<li>
create a new database <tt><i>TestingDB</i></tt> and initialise it with <code>mymy1.dump</code>
<li>
run the command: &nbsp; <code>psql <i>TestingDB</i> -f ass2.sql</code> &nbsp; (using your <tt>ass2.sql</tt>)
<li>
load and run the tests in the <tt>check1.sql</tt> script
<li>
repeat the above for <code>mymy2.dump</code> and <tt>check2.sql</tt>
</ul>
</p>
<p class="red">
Note that there is a time-limit on the execution of queries.
If any query takes longer than 3 seconds to run (you can check
this using the <b>\timing</b> flag) your mark for that query
wiil be reduced.
</p>
<p>
Your submitted code must be <em>complete</em> so that when we do the
above, your <tt>ass2.sql</tt> will load without errors.
If your code does not work when installed for testing as described
above and the reason for the failure is that your <tt>ass2.sql</tt>
did not contain all of the required definitions,
you will be penalised by a 3 mark administrative penalty.
</p>
<p>
Before you submit, it would be useful to test out whether
the files you submit will work by following a similar
sequence of steps to those noted above.
</p>

<br>
<p>Have fun, <i>jas</i></p>

<?=endPage()?>
