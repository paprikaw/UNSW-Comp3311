<?php
require("../../course.php");
const SHOW_ANSWERS = true;
echo startPage("Week 02 Tutorial","q+a", "Data Modelling, ER Model,<br>Relational Model");
?>

<ol>

<br><li>
Meet the other members of your tute.
If you have a microphones and are willing,
say a little bit about yourself
(e.g what degree you're doing, how much DB experience you have,
what you hope to get out of this course).
If you can't speak, post on the Chat.
</li>

<br><li>
<p>
In the context of database application development (aka <q>database
engineering</q>), what are the aims of <b>data modelling</b>?
</p>

<br><li>
<p>
Describe the similarities and differences between the following similarly-named concepts:
</p>
<ol type='a'>
<p><li> <b>relationship</b> in the entity-relationship data model
<p><li> <b>relation</b> in the relational data model
</ol>

<br><li>
<p>
What kind of data, relationships and constraints exist in this scenario?
</p>
<ul>
<li> for each person, we need to record their tax file number (TFN),
        their real name, and their address
<li> everyone who earns money in Australia has a distinct tax file number
<li> authors write books, and may publish books using a ``pen-name''
	(a name which appears as the author of the book and is different
	to their real name)
<li> editors ensure that books are written in a manner that is
	suitable for publication
<li> every editor works for just one publisher
<li> editors and authors have quite different skills; someone who is
	an editor cannot be an author, and vice versa
<li> a book may have several authors, just one author, or no authors
	(published anonymously)
<li> every book has one editor assigned to it, who liaises with the
	author(s) in getting the book ready for publication
<li> each book has a title, and an edition number (e.g. 1st, 2nd, 3rd)
<li> each published book is assigned a unique 13-digit number (its ISBN);
	different editions of the same book will have different ISBNs
<li> publishers are companies that publish (market/distribute) books
<li> each publisher is required to have a unique
	Australian business number (ABN)
<li> a publisher also has a name and address that need to be recorded
<li> a particular edition of a book is published by exactly one publisher
</ul>
</p>

<br><li>
<p>
Consider some typical operations in the myUNSW system ...
</p>
<ul>
<li> student enrols in a lab class
<li> student enrols in a course
<li> system prints a student transcript
</ul>
<p>
For each of these operations:
</p>
<ol type='a'> 
<li> identify what data items are required
<li> consider relationships between these data items
<li> consider constraints on the data and relationships
</ol>
</p>

<br><li>
<p>
Researchers work on different research projects, and the connection
between them can be modelled by a <tt>WorksOn</tt> relationship.
Consider the following two different ER diagrams to represent this
situation.
<p><center><img src="Pics/workson.png"></center><p>
Describe the different semantics suggested by each of these diagrams.
</p>

<br><li>
<p>
Draw an ER diagram for the following application from
the manufacturing industry:
</p>
<ul>
<li> Each supplier has a unique name.
<li> More than one supplier can be located in the same city. 
<li> Each part has a unique part number. 
<li> Each part has a colour. 
<li> A supplier can supply more than one part. 
<li> A part can be supplied by more than one supplier. 
<li> A supplier can supply a fixed quantity of each part.
</ul>

<br><li>
<p>
The following two ER diagrams give alternative design choices
for associating a person with their favourite types of food.
Explain when you might choose to use the second rather than the
first:
</p>
<center><img src="Pics/liked-cuisines.png"></center>

<br><li>
<p>
<small>[Based on RG 2.2]</small>
Consider a relationship <tt>Teaches</tt> between teachers and courses.
For each situation described below, give an ER diagram that accurately
models that situation:
<ol type=a>
<p><li> Teachers may teach the same course in several semesters,
	and each must be recorded
<p><li> Teachers may teach the same course in several semesters,
	but only the current offering needs to be recorded
	(assume this in the following parts)
<p><li> Every teacher must teach some course
<p><li> Every teacher teaches <em>exactly</em> one course
<p><li> Every teacher teaches <em>exactly</em> one course,
	and every course must be taught by some teacher
<p><li> A course may be taught jointly by a team of teachers
</ol>
<p>
You may assume that the only attribute of interest for teachers is
their staff number while for courses it is the course code (e.g. COMP3311).
You may introduce any new attributes, entities and relationships that
you think are necessary.
</p>

<br><li>
<p>
Assume there is a <tt>Person</tt> entity type.
Each person has a home address.
More than one person can live at the same home address. 
<ol type=a>
<p><li>
Create two, different ER diagrams to depict <tt>Person</tt>s
and their addresses, one with <tt>Address</tt> as an attribute,
the other with <tt>Address</tt> as an entity.
<p><li> Why would we choose one rather than the other?
<p><li>
Assume that we have a <tt>ElectricCompany</tt> entity type.
Only one of these companies supplies power to each home address. 
Add that information to each ER diagram. 
</ol> 
</p>

<br><li>
<p>
<small>[Based on GUW 2.1.3]</small>
Give an ER design for a database recording information about
teams, players, and their fans, including:
<ol type=a>
<p><li> For each team, its name, its players, its captain
	(one of its players) and the colours of its uniform.
<p><li> For each player, their name and team.
<p><li> For each fan, their name, favourite teams, favourite players,
	and favourite colour.
</ol>
</p>
</p>

<br><li>
<p>
A trucking company called <q>Truckers</q> is responsible for picking up
shipments from the warehouses of a retail chain
called <q>Maze Brothers</q> and delivering the shipments to individual
retail store locations of <q>Maze Brothers</q>.  Currently there are 6
warehouse locations and 45 <q>Maze Brothers</q> retail stores. A truck may
carry several shipments during a single trip, which is identified by a
Trip#, and delivers those shipments to multiple stores. Each shipment
is identified by a Shipment# and includes data on shipment volume,
weight, destination, etc. Trucks have different capacities for both
the volumes they can hold and the weights they can carry. The <q>Truckers</q>
company currently has 150 trucks, and a truck makes 3 to 4 trips each
week. A database - to be used by both <q>Truckers</q> and <q>Maze Brothers</q> -
is being designed to keep track of truck usage and deliveries and
to help in scheduling trucks to provide timely deliveries to the stores.
<p>
Design an ER model for the above application.
State all assumptions.
</p>

<br><li>
<p>
Give an ER design for a University administration database that
records information about faculties, schools, lecturers, students,
courses, classes, buildings, rooms, marks.
The model needs to include:
<ol type=a>
<p><li> for each faculty, its name, its schools and its dean
<p><li> for each school, its name, the location of its school office,
	its head and its academic staff
<p><li> for each lecturer, their names, bithdate, position, staff number,
	school, office, the courses they have convened, and the classes
	they have run
<p><li> for each student, their names, birthdate, student number, degree
	enrolled in, courses studied, and marks for each course
<p><li> for each course, its code, its name, the session it was offered,
	its lecturer(s), its students, its classes
<p><li> for each class, what kind of class (lecture, tutorial, lab class,
	...), its day and time (starting and finishing), who teaches it,
	which students attend it, where it's held
<p><li> for each building, its name and map reference
<p><li> for each room, its name, its capacity, type of room (office,
	lecture theatre, tutorial room, laboratory, ...) and the building
	where it is located
</ol>
<p>
An assumption: staff and student numbers are unique over the union of
the sets of staff and student numbers (i.e. each person has a unique
identifying number within the University).
<p>
Another assumption: the lecturer who <q>convenes</q> a course would be
called <q>lecturer-in-charge</q> at UNSW; lecturers typically teach
classes in the courses they convene; they may also teach classes in
other courses; a given class is only taught by one lecturer.
<p>
State all other assumptions.
</p>

<br><li>
<p>
Give an ER design to model the following scenario ...
<ul>
<li> for each person, we need to record their tax file number (TFN),
        their real name, and their address
<li> everyone who earns money in Australia has a distinct tax file number
<li> authors write books, and may publish books using a ``pen-name''
	(a name which appears as the author of the book and is different
	to their real name)
<li> editors ensure that books are written in a manner that is
	suitable for publication
<li> every editor works for just one publisher
<li> editors and authors have quite different skills; someone who is
	an editor cannot be an author, and vice versa
<li> a book may have several authors, just one author, or no authors
	(published anonymously)
<li> every book has one editor assigned to it, who liaises with the
	author(s) in getting the book ready for publication
<li> each book has a title, and an edition number (e.g. 1st, 2nd, 3rd)
<li> each published book is assigned a unique 13-digit number (its ISBN);
	different editions of the same book will have different ISBNs
<li> publishers are companies that publish (market/distribute) books
<li> each publisher is required to have a unique
	Australian business number (ABN)
<li> a publisher also has a name and address that need to be recorded
<li> a particular edition of a book is published by exactly one publisher
</ul>
<p>
State all assumptions used in developing your data model.
</p>

<br><li>
<p>
Give an ER design to model the following scenario ...
<ul>
<li> a <em>driver</em> has an employee id, a name and a birthday
<li> a <em>bus</em> has a make, model, registration number and capacity <br>
        <small>(e.g. a Volvo 425D bus which can carry 60 passengers, with registration MO-3235)</small>
<li> a <em>bus</em> may also have features
        <small>(e.g. air-conditioned, disabled access, video screens, etc.)</small>
<li> a <em>bus-stop</em> (normally abbreviated to simply <em>stop</em>) is
        a defined place where a bus may stop to pick up or set down passengers
<li> each stop has a name, which is displayed on the timetable
        <small>(e.g. ``Central Station'')</small>
<li> each <em>stop</em> also has a location (street address)
        <small>(e.g. ``North side of Eddy Avenue'')</small>
<li> a <em>route</em> describes a sequence of one or more stops that a bus will follow
<li> each <em>route</em> has a number
        <small>(e.g. route 372, from Coogee to Circular Quay)</small>
<li> each <em>route</em> has a direction: ``inbound'' or ``outbound'' <br>
        <small>(e.g. 372 Coogee to Circular Quay is ``inbound'',
                372 Circular Quay to Coogee is ``outbound'')</small>
<li> for each stop on a route, we note how long it should take to reach
        that stop from the first stop
<li> the time-to-reach the first stop on a route is zero
<li> stops may be used on several routes; some stops may not (currently) be used on any route
<li> a <em>schedule</em> specifies an instance of a route
        <small>(e.g. the 372 departing Circular Quay at 10:05am)</small>
<li> schedules are used to produce the timetables displayed on bus-stops
<li> a <em>service</em> denotes a specific bus running on a specific
        schedule on a particular day with a particular driver
<li> services are used internally by the bus company to keep track of
        bus/driver allocations
<li> the number of minutes that each bus service arrives late at its
        final stop needs to be recorded
</ul>
<p>
State all assumptions used in developing your data model.
</p>

<br><li>
<p>
Describe each of the following core components of the relational
model:
</p>
<ol type='a'>
<li>attribute </li>
<li>domain</li>
<li>relation schema</li>
<li>relational schema</li>
<li>tuple</li>
<li>relation</li>
<li>key</li>
<li>foreign key</li>
</ol>

<br><li>
<p>
Why are duplicate tuples not allowed in relations?
</p>

<br><li>
<p>
Consider the following simple relational schema:
</p>
<pre>
R(<u>a1</u>, a2, a3, a4)
S(<u>b1</u>, <u>b2</u>, b3)
</pre>
<p>
which of the following tuples are not legal in this schema?
Explain why the iillegal tuples are invalid.
</p>
<pre>
R(1, a, b, c)  R(2, a, b, c)  R(1, x, y, z)

R(3, x, NULL, y)  R(NULL, x, y, z)

S(1, 2, x)  S(1, NULL, y)  S(2, 1, z)
</pre>

<br><li>
<p>
Consider the following relations which form a tiny part of the schema
for the MyUNSW database:
</p>
<pre>
Person(zID, zPass, familyName, givenName, dateOfBirth, countryOfBirth, ...)
Student(zID, degreeCode, WAM, ...)
Staff(zID, office, phone, position, ...)
Course(cID, code, term, title, UOC, convenor)
Room(rID, code, name, building, capacity)
Enrolment(course, student, mark, grade)
</pre>
<p>
Identify all of the primary keys and foreign keys, and suggest 
suitable domains for each attribute.
You can introduce new relations if you think would likely be
used to represent objects not in the current tables.
Discuss which attributes could have NULL values, and the
circumstances under which this might occur.
</p>

</ol>

<?=endPage()?>
