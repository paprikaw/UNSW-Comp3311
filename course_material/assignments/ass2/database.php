<? require("../../course.php"); require("defs.php"); ?>
<?=startPage("Assignment 2","","The MyMyUNSW Database")?>
<?=updateBlurb().scriptMenu($menu)?>

<h3>Introduction</h3>
<p>
This document contains a description of the data model and SQL schema
for the MyMyUNSW database.
</p>

<h3>Background</h3>
<p>
UNSW handles its administrative information using a version of the
Peoplesoft product called Campus Solutions.
This system is normally accessed via the MyUNSW portal and is
maintained by the NSS unit in UNSW IT, and so it's variously
called <q>PeopleSoft</q>, <q>Campus Solutions</q>, <q>MyUNSW</q>
and <q>NSS</q>.
The database behind the system is hosted on a large Oracle server,
and throughout this document will be referred to as the <q>NSS
database</q>.
<p>
The PeopleSoft system was installed in 2000 and has been modified/extended
over the years to encompass:
</p>
<ul>
<li> human resources (staff/employees, payroll, etc.)
<li> financials (purchases, income/expenditure, etc.)
<li> academic (students, courses, classes, enrolment, etc.)
</ul>
<p>
At the start of October 2013, it was upgraded to Campus Solutions (CS9).
</p>
<p>
The current NSS database is separate from the UNSW Handbook,
which records all of the official information related to course
and program/degree requirements.
To support on-line enrolment, NSS does represent some course
information, such as pre-requisites, co-requisites and exclusions,
as well as enrolment quotas.
However, it maintains this information independently to the Handbook,
which leads to potential inconsistency.
Worse, NSS maintains no information at all about program/degree
requirements, which means that students cannot use NSS to monitor
their progress through their degree.
</p>
<p>
The MyMyUNSW database aims to implement a superset of the contents
of the NSS database, including:
</p>
<ul>
<li> people: staff, students
<li> infrastructure: buildings, rooms, facilities
<li> organisation: faculties, schools, centres
<li> academic: programs, streams, subjects, courses, classes
</ul>
<p>
Note: there are two places in this schema where we deviate from
current UNSW terminology. A <b>stream</b> is a new term that
refers to what the current UNSW Handbook calls a <q>plan</q>
or <q>specialisation</q>.
Streams also encompass the collections of courses that comprise
<q>majors</q> and <q>minors</q> in many degrees.
Also, in our schema, we use the terms <b>subject</b> and
<b>course</b> to talk about a unit of study (subject) and a
particular offering of a subject in a given semester (course).
UNSW confusingly calls both of these a <q>course</q>, although
it also sometimes also uses the term <q>course offering</q>
for the second.
<p>
The academic information includes subject pre/co-requisites and
program/degree requirements, as well as all of the descriptive
material from the UNSW handbook.
This assemblage of information means that the MyMyUNSW database
can be used as a basis for:
</p>
<ul>
<li> on-line course and class enrolments
<li> managing room allocation and time-tabling
<li> monitoring progress through programs
<li> producing the UNSW Handbook
</ul>
<p>
Only the first, and part of the second, of these are provided
by the current PeopleSoft system.
</p>

<h3>Data Model and Schema</h3>
<p>
This section aims to give an overview of the data model.
It concentrates mainly on the entities and their relationships.
The details of attributes are provided by comments in the
<a href="schema.sql">SQL schema</a>.
</p>
<p>
Some considerations in the development of our data model:
<ul>
<li> there are two main kinds of <b>people</b> in the system: staff
	and students; all people have certain basic information
	associated with them (e.g. name); staff have additional
	information related to their employment; students have
	additional information related to the degree that they
	are studying; there are also people who are neither staff
	nor students that UNSW wants to record (e.g. members of
	the University Council)
<li> UNSW runs a number of teaching <b>terms</b> each year
	(these are also called <q>sessions</q> or <q>semesters</q>)
<li> a <b>subject</b> is a unit of study in a particular area
	(e.g. introductory programming, database systems, etc.);
	a subject is defined primarily by its syllabus
<li> a <b>course</b> is a particular offering of a subject in
	a particular teaching term; it has a course convener
	(also called lecturer-in-charge), perhaps an enrolment
	quota, and is associated with a number of classes
<li> a <b>class</b> is a teaching activity at a scheduled time
	in a scheduled place; examples of classes are lectures,
	tutorials and labs; a class is associated with a course
<li> a <b>degree</b> is an award given to a student who completes
	a specified program of study
<li> a <b>program</b> is a named program of study leading to
	one or more degrees
<li> a <b>stream</b> specifies the precise requirements for study
	in a specific area; it is used to implement the notions of
	<i>major</i> and <i>minor</i>
<li> in a particular program, students choose at least one stream
	from a range of possible streams (in a double degree, they
	will choose two streams, one from each set of streams for
	the constituent degrees); the program will specify precisely
	what are the allowed/required combinations of streams
<li> to satisfy the requirements of the program, a student must
	satisfy the requirements of all the streams that they
	enrol in from the program; in addition, there may be
	requirements from the program itself (e.g. general
	education, total units of credit completed, etc.)
<li> there are several different types of requirements:
<ul>
<li> subject requirements (core subject, electives, limitations)
<li> stream requirements (e.g. must take one from the BCom majors)
<li> program requirements (e.g. must be enrolled in 3648 to take SENG1010)
<li> UOC requirements (e.g. overall plan needs at least 144 UC)
<li> WAM requirements (e.g. must have WAM of at least 65 for Hons)
<li> stage requirements (e.g. must be in stage 2 of program to take COMP2 courses)
<li> stream requirements (e.g. complete one major from a set of majors)
<li> miscellaneous requirements (e.g. industrial training)
</ul>
<li> in specifying requirements, we frequently need to deal with sets
	of academic objects (either programs or streams or subjects);
	we call these (generically) <b>academic groupings</b>
<li> we use <b>subject groups</b> in specifying subject requirements;
	each subject group has a name (e.g. "level 3/4 COMP courses")
	and an associated set of subjects
<li> similarly for <b>stream groups</b> (e.g. "set of BA majors") and
	<b>program groups</b> (e.g. "all programs offeed by CSE")
<li> a <b>subject requirement</b> specifies: a subject group, a number of
	UOC associated with the group, whether this number is a minimum
	or maximum requirement; this is flexible enough to allow us to
	describe:
	<ul>
	<li> core requirements (group size 1, must complete 1 course from the group)
	<li> alternatives (several related courses, must complete 1 of them)
	<li> professional electives (set of courses from one area, must complete <i>k</i> of them)
	<li> limitations (e.g. no more than 72 UC of level 1 courses)
	</ul>
<li> in terms of the ideas above, programs and streams are defined as
	collections of requirements; a particular student must satisfy
	all of the requirements before they are regarded as having
	completed the program or stream
<li> how to determine whether a student has satisfied requirements
	depends on the type of requirement:
	<ul>
	<li> for UOC, use the course enrolment information
	<li> for course requirements, use the course enrolment information
	<li> for miscellaneous, must explicitly record that the student has met them<br>
		(because there's no other data that will allow us to work it out)
	</ul>
<li> at any given time, each student is <b>enrolled</b> in one program, one or
	more streams (associated with the program), and generally several
	courses and classes within those courses; we need to record all four
	kinds of enrolment
<li> for enrolment in a program, it is useful to know when the student's
	enrolment commenced, when it ended (if it has ended), and their
	current status (e.g. active, on leave, etc.)
<li> over their lifetime, students may enrol in several programs,
	each with associated streams and courses
<li> a <b>schedule</b> describes when in a stream particular courses should
	be taken; in our terms, it will relate subject groups to streams and
	associate specific (year,semester) combinations with them
<li> sometimes, we wish to allow a student to <b>vary</b> from the standard
	requirements of their degree plans;
	there are three types of substitutions:
	<ul>
	<li> substitution: replace one course by another within a program
	<li> advanced standing: get credit for a course from elsewhere (or
		from a partly-completed UNSW degree) to
		use in place of some course in a program
	<li> exemption: get recognition for having studied a course
		elsewhere so that this can be used as a pre-requisite
		for further study at UNSW
	</ul>
</ul>
<p>
<span class='red'>Treat the ER data model description below as an overview,</span>
and consult the
<a href="schema.sql">SQL Schema</a> for full details.
The ER diagrams below make a number of simplifications to the complete
SQL schema: many attributes are omitted, some names are changed (e.g.
entity names are singular here, but plural in the SQL schema).
The <a href="schema.sql">SQL Schema</a> has a detailed description
of its naming conventions, which we won't repeat here.
There is also a <a href="schema.php">summary version</a> of the
schema available, which might be useful as a quick reference once
you're familiar with the details of the schema.
</p>
<p>
To make the presentation clearer, the data model is presented in a
number of sections.
</p>

<h3 class="entity">People/Courses/Terms</h3>
<p>Entities and relationships related to students/staff/courses/terms ...</p>
<div align="center">
<img src="Pics/person+course.png">
</div>
Comments:
<ul>
<li> the Person entity would clearly have much additional data associated
	with it in a real implementation (contact details, etc.)
<li> note that the use of <tt>Subjects.id</tt> rather than <tt>Subjects.code</tt>
	as a primary key actually allows us to implement multiple versions
	of a given subject; we also need to know the period over which the
	particular version is relevant, and this is recorded in the subject
	record
<li> in reality, a course offering has a lot of other information
	associated with it (e.g. enrolment quotas, assessment schemes,
	classes); some of these appear in the database, some don't
<li> the <i>n:m</i> relationship allows multiple staff to be associated with
	the teaching of a given course offering; one of these staff is
	required to be a course convener (this could have been implemented
	via an extra field in the <tt>Courses</tt> table to force the above
	constraint, but since it's also a Role, we decided to implement it
	as such and do the constraint via a trigger)
</ul>

<h3 class="entity">Orgunits and Roles</h3>
<p>Entities and relationships linking people and the unit they work in ...</p>
<div align="center">
<img src="Pics/orgunits.png">
</div>
Comments:
<ul>
<li> OrgUnits = organisational units like schools, faculties, divisions
<li> each staff member is associated with one or more orgunits
<li> they may have a specific role in each orgunit
<li> most staff are associated with just one orgunit
<li> staff have a primary role, which is the basis for their employment
</ul>



<h3 class="entity">Programs/Streams/Degrees</h3>
<p>Entities related to programs/streams/degrees ...</p>
<div align="center">
<img src="Pics/academic-objects.png">
</div>
<p>... and relationships between them ...</p>
<div align="center">
<img src="Pics/prog+stream-relns.png">
</div>
Comments:
<ul>
<li> here, we show minimal attributes for the Program, Degree and Stream entities;
	see the schema for full details
<li> a program leads to one or more degrees (e.g. BSc, BE/BCom)
<li> a degree occurs in at least one program (e.g. straight BE, BE/BCom, BE/BSc)
<li> streams may be used in several programs (e.g. BE component of combined degrees)
<li> specific requirements may also be used in several plans
</ul>

<h3 class="entity">Rules</h3>
<p>Entities and relationships related to requirements ...</p>
<div align="center">
<img src="Pics/rules.png">
</div>
Comments:
<ul>
<li> every rule is either a
<ul>
<li> <tt>'CC'</tt>: core courses ... must complete min..max UOC of subjects from specified group
<li> <tt>'PE'</tt>: program electives ... must complete min..max UOC of subjects from specified group
<li> <tt>'FE'</tt>: free electives ... must complete min..max UOC of subjects from FREE?###
<li> <tt>'GE'</tt>: general education ... must complete min..max UOC of subjects from GEN?####
<li> <tt>'RQ'</tt>: subject pre-req ... must complete min..max UOC of subjects from group
<li> <tt>'WM'</tt>: WAM requirement ... must achieve min WAM score
<li> <tt>'LR'</tt>: limit rule ... must complete at least/most min/max UOC from a subject group
<li> <tt>'MR'</tt>: maturity rule ... must complete at least min UOC before enrolling in any member of a subject group
<li> <tt>'DS'</tt>: done stream ... must complete between min..max streams from group
<li> <tt>'RC'</tt>: recommended ... subject group, useful for suggestions in advice
<li> <tt>'IR'</tt>: information rule ... for information only, not checked

</ul>
<li> since <tt>'RC'</tt> and <tt>'IR'</tt> don't have any function, we omitted them from the ER diagram
<li> many of the rule types refer to a set of academic objects
	(e.g. set of subjects in an elective group); such sets are
	represented by the <tt>AcadObjectGroups</tt> table
<li> a rule can be negated via a flag in the rule record
<li> rules may specify minimum and maximum values (see examples above)
<li> using min, max and academic object sets allows you express requirements like
<ul>
<li> must complete between 24 and 36 UOC from COMP3* courses (subject group)
<li> must complete one major from the BA majors (stream group)
<li> must be enrolled in a CSE degree (program group)
</ul>
<li> if a rule is really a logical combination of other requirements,
	it can be expressed as a compound requirement; a compound requirement
	combines a set of requirements via logical AND or logical OR;
	compound requirements can be nested
<li> note that the sets of requirements for Programs, Streams amd Subject
	pre-requisites are implicitly conjunctive (i.e. you need to satisfy
	all of them before you have completed the Program or Stream or met
	the pre-requisite requirement for the Subject)
<li> miscellaneous requirements pick up all of the other non-course-related
	requirements that exist in various degrees (e.g. industrial training
	for Engineers); since there are no enrolments records or other kinds
	of records to check that these were completed, we need an explicit
	link between the student and the requirement to indicate this
</ul>
<p>
<b>Note:</b> there are no miscellaneous or compound rules in the <tt>mymy</tt> database.
</p>

<h3 class="entity">Academic Object Groups</h3>
<p>Groups of academic objects that are central to the definition of requirements ...</p>
<div align="center">
<img src="Pics/academic-object-groups.png">
</div>
<ul>
<li> an academic object group (<i>AcObjGroup</i>) specifies a set of
	academic objects of one type (e.g. a set of streams,
	set of programs, etc.)
<li> each <i>AcObjGroup</i> has a name which describes its purpose and is
	used for looking up groups when programs and streams are
	being defined
<li> the members of an <i>AcObjGroup</i> may be defined in three ways:
<ul>
<li> by enumeration (explicitly associating each member to the group)
<li> by giving a regexp pattern to identify the members (e.g. <tt>COMP3.*</tt>)
<li> by giving an SQL query to lookup the members and return a set of IDs
</ul>
<li> in the case of a set of requirements, you can also specify the logic
	of how the members are defined (conjunction or disjunction)
</ul>


<h3 class="entity">Enrolment</h3>
<p>Relationships for various kinds of enrolment ...</p>
<div align="center">
<img src="Pics/enrolments.png">
</div>
Comments:
<ul>
<li> students initially start at UNSW by enrolling in a program
<li> once enrolled, they choose a specific stream (or streams) to study
	within that program
<li> this requires them to enrol in courses, and they generally enrol in
	one or more classes in the course (note that NSS uses enrolment
	in the lecture class as the way of indicating that a student is
	enrolled in a course; our schema does not do this)
<li> all these notions of <q>enrolment</q> have different kinds of information
	associated with them
<li> we have used total participation for Students-EnrollIn-Program
	to indicate that they must be enrolled in at least one program;
	it's an n:m relationship because, over time, they may enrol in
	other programs (e.g. complete their undergraduate degree and
	then later do a coursework masters degree)
<li> note that the mark alone is not sufficient to determine whether
	a student has successfully completed a course; they need a
	passing grade to ensure this (the set of grades indicating a
	pass includes SY, PC, PS, CR, DN, HD ... there is also a PT
	grade which is no longer used but is included to allow us to
	deal with old data)
</ul>

<h3 class="entity">Variations</h3>
<p>Variations of meeting requirements within programs ...</p>
<div align="center">
<img src="Pics/variations.png">
</div>
Comments:
<ul>
<li> the purpose of a variation is to indicate that a student has
	effectively completed one course at UNSW, without necessarily
	having enrolled in and passed that course
<li> there are three kinds of variation: substitution, advanced standing,
	exemption
<li> a substitution might be used to replace a core course in a plan
	by some other course if the core course is not available
<li> advanced standing gives credit towards a degree, based on study towards
	a different degree either at UNSW or elsewhere (typically, advanced
	standing is only granted when the degree containing the
	course was not completed)
<li> including courses from other institutions means that we need a
	representation for them; we have used a very simple representation
<li> finally, exemptions allow us to record that a student has some
	specific background knowledge (to use as a pre-requisite for
	some other course); an exemption does not confer credit
	towards a degree, but may be used to satisfy pre-req requirements
</ul>
<p>
<b>Note:</b> there is no variation data in the <tt>mymy</tt> database.
</p>

<h3>SQL Schema</h3>
<p>
We have developed an <a href="schema.php">SQL schema</a>
based on the above data model.
With the above background, you are now in a good position
to examine this schema, keeping in mind that the schema does
not follow precisely what has been specified above in all cases.
</p>

<h3>Database Contents</h3>
<p>
The student/course/enrolment part of the database has been populated
using real data which was transformed to make it anonymous
(i.e. names changed to protect the innocent).
The subject/program part of the database was populated by scraping
the data from the UNSW Online Handbook.
The class data was populated using data from the UNSW timetable
site.
The requirements part will be populated by hand from data in the
MAPPS database.
There will also be some subsequent manual tweaking of the data to
ensure that there are interesting tuples to play with.
</p>
<p>
Note that the task of populating such a large database is extremely
time-consuming and so many parts of the database are unpopulated or
populated only very <q>thinly</q>.
Some parts have data that is close to reality, while others have data
that is a pale shadow of reality.
In order to get a feeling for what is actually present, you must spend
some time exploring the database when it is eventually populated.
</p>
<!--
<p>
Here are some pointers to potentially unexpected aspects of the data:
</p>
<ul>
<li> most courses are lectured by an anonymous academic called A Lecturer
<li> there is a special Person called UNSW who can own things where there's nobody else obvious to do it
<li> there is a special Building called UNSW where rooms that are not attached t
o a specific building can be placed
<li> the enrolment data covers the period 1998 to 2002
<li> however, there is also subject information from 2007
<li> around half the tables are currently empty
</ul>
-->

<?=endPage()?>
