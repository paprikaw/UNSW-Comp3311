<?php
require("../../course.php");
const SHOW_ANSWERS = true;
echo startPage("Week 09","q+a","Relational Design Theory");
?>

<br>
<center>
<table width=80% border=1 cellpadding=6><tr>
<td style='font-size:80%'>
<p>
<b>Notation:</b> in the relational schemas below,
primary key attributes are underlined
(e.g. <big><code><u>pk</u></code></big>),
foreign key attributes are shown in italic font
(e.g. <big><code><i>fk</i></code></big>)
and primary key attributes that are also foreign keys are
underlined and in italic font
(e.g. <big><code><u><i>pk+fk</i></u></code></big>).
</p>
Example:
<pre>
<big>Student(<u>id</u>, name, <i>degreeCode</i>)
Degree(<u>code</u>, name, requirements)
Subject(<u>code</u>, name, syllabus)
Marks(<i><u>studentId</u></i>, <i><u>subjectCode</u></i>, <u>teachingTerm</u>, mark)</big>
</pre>
<p>
In their respective relations, the student id, the degree code
and the subject code are primary keys.
In the Student relation, the degree code is a foreign key.
In the Marks relation, the three attributes student id, subject
code and teaching term together form the primary key; the first two
(student id and subject code) are also foreign keys.
</p>
</tr></td></table>
</center>

<ol>

<li>
<p>
Functional dependencies.
</p>
<ol type='a'>
<li><p>
What functional dependencies are implied if we know that a set of
attributes <i>X</i> is a candidate key for a relation <i>R</i>?
</p>
<li><p>
What functional dependencies can we infer <em>do not hold</em>
by inspection of the following relation?
</p>
<center>
<table width=30% border=1 cellpadding=3>
<tr align=center> <td><b>A</b></td> <td><b>B</b></td> <td><b>C</b></td> </tr>
<tr align=center> <td>a</td> <td>1</td> <td>x</td> </tr>
<tr align=center> <td>b</td> <td>2</td> <td>y</td> </tr>
<tr align=center> <td>c</td> <td>1</td> <td>z</td> </tr>
<tr align=center> <td>d</td> <td>2</td> <td>x</td> </tr>
<tr align=center> <td>a</td> <td>1</td> <td>y</td> </tr>
<tr align=center> <td>b</td> <td>2</td> <td>z</td> </tr>
</table>
</center>
<li>
<p>
Suppose that we have a relation schema <i>R(A,B,C)</i> representing
a relationship between two entity sets <i>E</i> and <i>F</i>
with keys <i>A</i> and <i>B</i> respectively, and suppose that
<i>R</i> has (at least) the functional dependencies
<i>A &rarr; B</i> and
<i>B &rarr; A</i>.
Explain what this tells us about
the relationship between <i>E</i> and <i>F</i>.
</p>
</ol>

<li>
<p>
Consider the relation <i>R(A,B,C,D,E,F,G)</i> and the
set of functional dependencies
<i>F = { 
A &rarr; B,
BC &rarr; F,
BD &rarr; EG,
AD &rarr; C,
D &rarr; F,
BEG &rarr; FA
}
</i>
compute the following:
<p>
<ol type='a'>
<li> <p><i>A<sup>+</sup></i></p>
<li> <p><i>ACEG<sup>+</sup></i></p>
<li> <p><i>BD<sup>+</sup></i></p>
</ol>

<li>
<p>
Consider the relation <i>R(A,B,C,D,E)</i> and the set
set of functional dependencies
<i>F = { 
A &rarr; B,
BC &rarr; E,
ED &rarr; A
}
</i>
</p>
<ol type='a'>
<li> <p>List all of the candidate keys for <i>R</i>.</p>
<li> <p>Is <i>R</i> in third normal form (3NF)?</p>
<li> <p>Is <i>R</i> in Boyce-Codd normal form (BCNF)?</p>
</ol>

<li>
<p>
Consider a relation <i>R(A,B,C,D)</i>.
For each of the following sets of functional dependencies,
assuming that those are the only dependencies that hold for
<i>R</i>, do the following:
</p>
<ol type='a'>
<li> <p>List all of the candidate keys for <i>R</i>.</p>
<li> <p>Show whether <i>R</i> is in Boyce-Codd normal form (BCNF)?</p>
<li> <p>Show whether <i>R</i> is in third normal form (3NF)?</p>
</ol>
<p>
<ol type='i'>
<li>
<p><i>
C &rarr; D, &nbsp;
C &rarr; A, &nbsp;
B &rarr; C
</i></p>
<li>
<i>
B &rarr; C, &nbsp;
D &rarr; A
</i>
<li>
<i>
ABC &rarr; D, &nbsp;
D &rarr; A
</i>
<li>
<i>
A &rarr; B, &nbsp;
BC &rarr; D, &nbsp;
A &rarr; C
</i>
<li>
<i>
AB &rarr; C, &nbsp;
AB &rarr; D, &nbsp;
C &rarr; A, &nbsp;
D &rarr; B
</i>
<li>
<i>
A &rarr; BCD
</i>
</ol>

<li>
<p>
Specify the non-trivial functional dependencies for each of
the relations in the following Teams-Players-Fans schema
and then show whether the overall schema is in BCNF.
</p>
<pre>
Team(<u>name</u>, <i>captain</i>)
Player(<u>name</u>, <i>teamPlayedFor</i>)
Fan(<u>name</u>, address)
TeamColours(<u><i>teamName</i></u>, <u>colour</u>)
FavouriteColours(<u><i>fanName</i></u>, <i><u>colour</u></i>)
FavouritePlayers(<u><i>fanName</i></u>, <u><i>playerName</i></u>)
FavouriteTeams(<u><i>fanName</i></u>, <u><i>teamName</i></u>)
</pre>

<li>
<p>
Specify the non-trivial functional dependencies for each of
the relations in the following Trucks-Shipments-Stores schema
and then show whether the overall schema is in BCNF.
</p>
<pre>
Warehouse(<u>warehouse#</u>, address)
Source(<i><u>trip</u></i>, <i><u>warehouse</u></i>)
Trip(<u>trip#</u>, date, <i>truck</i>)
Truck(<u>truck#</u>, maxvol, maxwt)
Shipment(<u>shipment#</u>, volume, weight, <i>trip</i>, <i>store</i>)
Store(<u>store#</u>, storename, address)
</pre>

<li>
<p>
For each of the sets of dependencies in question 4:
<p>
<ol type='i'>
<li> <p>if <i>R</i> is not already in 3NF, decompose it into a set of 3NF relations</p>
<li> <p>if <i>R</i> is not already in BCNF, decompose it into a set of BCNF relations</p>
</ol>
<ol type='a'>
<li><p>
<i>
C &rarr; D, &nbsp;
C &rarr; A, &nbsp;
B &rarr; C
</i>
</p>
<li><p>
<i>
B &rarr; C, &nbsp;
D &rarr; A
</i>
<p>
<li><p>
<i>
ABC &rarr; D, &nbsp;
D &rarr; A
</i>
</p>
<li><p>
<i>
A &rarr; B, &nbsp;
BC &rarr; D, &nbsp;
A &rarr; C
</i>
</p>
<li><p>
<i>
AB &rarr; C, &nbsp;
AB &rarr; D, &nbsp;
C &rarr; A, &nbsp;
D &rarr; B
</i>
</p>
<li><p>
<i>
A &rarr; BCD
</i>
</p>
</ol>

<li>
<p>
Consider (yet another) banking application that contains information
about accounts, branches and customers.
Each account is held at a specific branch, but a customer may hold more
than one account and an account may have more than one associated
customer.
</p>
<p>
Consider an unnormalised relation containing all of the attributes that
are relevant to this application:
</p>
<ul>
<li> <i>acct#</i> - unique account indentifier
<li> <i>branch#</i> - unique branch identifier
<li> <i>tfn</i> - unique customer identifier (<b>t</b>ax <b>f</b>ile <b>n</b>umber)
<li> <i>kind</i> - type of account (savings, cheque, ...)
<li> <i>balance</i> - amount of money in account
<li> <i>city</i> - city where branch is located
<li> <i>name</i> - customer's name
</ul>
<p>
i.e. consider the relation <i>R(acct#, branch#, tfn, kind, balance, city, name)</i>
</p>
<p>
Based on the above description:
<ol type='a'>
<li> <p>Devise a suitable set of functional dependencies among these attributes.</p>
<li> <p>Using these functional dependencies, decompose <i>R</i> into a set of 3NF relations.</p>
<li> <p>State whether the new relations are also in BCNF.</p>
</ol>

<li>
<p>
Consider a schema representing projects within a company, containing
the following information:
<p>
<ul>
<li> <i>pNum</i> - project's unique identifying number
<li> <i>pName</i> - name of project
<li> <i>eNum</i> - employee's unique identifying number
<li> <i>eName</i> - name of employee
<li> <i>jobClass</i> - type of job that employee has on this project
<li> <i>payRate</i> - hourly rate, dependent on the kind of job being done
<li> <i>hours</i> - total hours worked in this job by this employee
</ul>
<p>
This schema started out life as a large spreadsheet and now the
company wants to put it into a database system.
</p>
<p>
As a spreadsheet, its schema is:
<i>R(pNum, pName, eNum, eName, jobClass, payRate, hours)</i>
</p>
<p>
Based on the above description:
<ol type='a'>
<li> Devise a suitable set of functional dependencies among these attributes.
<li> Using these functional dependencies, decompose <i>R</i> into a set
	of BCNF relations.
<li> State whether the new relations are also in 3NF.
</ol>

<li>
<p>
Real estate agents conduct visits to rental properties
<ul>
<li> need to record which property, who went, when, results
<li> each property is assigned a unique code (P#, e.g. PG4)
<li> each staff member has a staff number (S#, e.g. SG43)
<li> staff members use company cars to conduct visits
<li> a visit occurs at a specific time on a given day
<li> notes are made on the state of the property after each visit
</ul>
The company stores all of the associated data in a spreadsheet.
<p>
Describe any functional dependencies that exist in this data.
The table of sample data below below may give some ideas:
<pre>
<b>P</b>#  | <b>W</b>hen        | <b>A</b>ddress    | <b>N</b>otes         | <b>S</b>#   | Na<b>m</b>e  | <b>C</b>arReg
----+-------------+------------+---------------+------+-------+-------
PG4 | 03/06 15:15 | 55 High St | Bathroom leak | SG44 | Rob   | ABK754
PG1 | 04/06 11:10 | 47 High St | All ok        | SG44 | Rob   | ABK754
PG4 | 03/07 12:30 | 55 High St | All ok        | SG43 | Dave  | ATS123
PG1 | 05/07 15:00 | 47 High St | Broken window | SG44 | Rob   | ABK754
PG2 | 13/07 12:00 | 12 High St | All ok        | SG42 | Peter | ATS123
PG1 | 10/08 09:00 | 47 High St | Window fixed  | SG42 | Peter | ATS123
PG3 | 11/08 14:00 | 99 High St | All ok        | SG41 | John  | AAA001
PG4 | 13/08 10:00 | 55 High St | All ok        | SG44 | Rob   | ABK754
PG3 | 05/09 11:15 | 99 High St | Bathroom leak | SG42 | Peter | ATS123
</pre>
<p>
State assumptions used in determining the functional dependencies.
</p>

<li>
<p>
Consider a company supplying temporary employees to hotels:
</p>
<ul>
<li> the company has contracts with different hotels
<li> it may have several contracts with a given hotel
<li> contracts are identified by a code (e.g. C12345)
<li> staff work at different hotels as needed
<li> staff have tax file #'s (TFN, e.g. T123)
<li> hotels have Aus business #'s (ABN, e.g. H234)
</ul>
Describe any functional dependencies that exist in this data.
The table of sample data below below may give some ideas:
<pre>
<b>C</b>ontract | <b>T</b>FN  | <b>N</b>ame       | H<b>r</b>s | <b>A</b>BN  | <b>H</b>otel
---------+------+------------+-----+------+-------------
C12345   | T311 | John Smith |  12 | H765 | Four Seasons
C18765   | T255 | Brad Green |  12 | H234 | Crown Plaza
C12345   | T311 | John Smith |  12 | H765 | Four Seasons
C12345   | T255 | Brad Green |  10 | H765 | Four Seasons
C14422   | T311 | John Smith |   6 | H222 | Sheraton
C14422   | T888 | Will Smith |   9 | H222 | Sheraton
C18477   | T123 | Clair Bell |  15 | H222 | Sheraton
</pre>
<p>
State assumptions used in determining the functional dependencies.
</p>

<li>
<p>
What functional dependencies exist in the following table:
</p>
<pre>
  A  |  B  |  C  |  D
-----+-----+-----+-----
  1  |  a  |  6  |  x
  2  |  b  |  7  |  y
  3  |  c  |  7  |  z
  4  |  d  |  6  |  x
  5  |  a  |  6  |  y
  6  |  b  |  7  |  z
  7  |  c  |  7  |  x
  8  |  d  |  6  |  y
</pre>
<p>
How is this case different to the previous two?
</p>

<li>
<p>
Compute a minimal cover for:
<p>
<i>
F &nbsp; = &nbsp; { B &rarr; A,&nbsp;
D &rarr; A,&nbsp;
AB &rarr; D
}
</i>

<li>
<p>
Using the functional dependencies you produced in Q10,
convert the real-estate inspection spreadsheet (single
table), into a BCNF relational schema.
</p>

<li>
<p>
Consider the schema <i>R</i> and set of fds <i>F</i>
<p>
<i>R &nbsp;=&nbsp;  ABCDEFGH
<br>
F &nbsp;=&nbsp; { ABH &rarr; C,&nbsp; A &rarr; DE,&nbsp; BGH &rarr; F,&nbsp; F &rarr; ADH,&nbsp; BH &rarr; GE }
</i>
<p>
Produce a BCNF decomposition of <i>R</i>.
</p>

<li>
<p>
Using the functional dependencies you produced in Q10,
convert the real-estate inspection spreadsheet (single
table), into a 3NF relational schema.

<li>
<p>
Consider the schema <i>R</i> and set of fds <i>F</i>
</p>
<p>
<i>
R &nbsp;=&nbsp; ABCDEFGH
<br>
F &nbsp;=&nbsp; { ABH &rarr; C,&nbsp; A &rarr; D,&nbsp; C &rarr; E,&nbsp;
BGH &rarr; F,&nbsp; F &rarr; AD,&nbsp; E &rarr; F,&nbsp; BH &rarr; E }
<br>
F<sub>c</sub> &nbsp;=&nbsp; { BH &rarr; C,&nbsp; A &rarr; D,&nbsp; C &rarr; E,&nbsp;
F &rarr; A,&nbsp; E &rarr; F,&nbsp; BH &rarr; E }
</i>
<p>
Produce a 3NF decomposition of <i>R</i>.
</ol>

</ol>
</body>
</html>
