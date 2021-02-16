<? require("../../course.php");

echo startPage("Exercises 07","q+a","Relational Design Theory");
//alternativeViews();

//echo startPage("Exercises 08","q","Relational Design Theory");
//alternativeViews();

?>

<br>
<center>
<table width=80% border=1 cellpadding=6><tr>
<td style='font-size:75%'>
<p>
<b>Notation:</b> in the relational schemas below,
primary key attributes are shown in &nbsp; <code><b>bold</b></code> &nbsp; font,
foreign key attributes are shown in &nbsp; <code><i>italic</i></code> &nbsp; font,
and primary key attributes that are also foreign keys are
shown in &nbsp; <code><b><i>bold italic</i></b></code> &nbsp; font.
</p>
Example:
<pre>
   Student(<u>id</u>, name, <i>degreeCode</i>)
   Degree(<u>code</u>, name, requirements)
   Subject(<u>code</u>, name, syllabus)
   Marks(<i><u>studentId</u></i>, <i><u>subjectCode</u></i>, <u>session</u>, mark)
</pre>
<p>
In their respective relations, the student id, the degree code
and the subject code are primary keys.
In the Student relation, the degree code is a foreign key.
In the Marks relation, the three attributes student id, subject
code and session together form the primary key; the first two
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
<?=startAnswer()?>
<p>
<i>X</i> functionally determines all of the other attributes
(i.e. <i>X</i> &rarr; <i>R-X</i>)
<?=endAnswer()?>
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
<?=startAnswer()?>
<p>
The tuples (a,1,x) and (a,1,y) ensure that
<i>A &rarr; C</i>
and
<i>B &rarr; C</i>
and
<i>AB &rarr; C</i>
do not hold.
<br>
The tuples (a,1,x) and (d,2,x) ensure that
<i>C &rarr; B</i>
and
<i>C &rarr; A</i>
do not hold.
<br>
The tuples (a,1,x) and (c,1,z) ensure that
<i>B &rarr; A</i>
and
<i>B &rarr; C</i>
do not hold.
<br>
Note that <i>C &rarr; A</i>
is not disproved by (a,1,x) and (a,1,y) or (b,2,y) and (b,2,z).
For other combinations of <i>ABC</i> there is only one instance
in the relation and so we cannot infer anything about dependency.
</p>
<?=endAnswer()?>
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
<?=startAnswer()?>
<p>
The <i>A &rarr; B</i> tells us
that every <i>A</i> value in <i>R</i> has exactly one corresponding
<i>B</i> value, and similarly
<i>B &rarr; A</i>
tells us that every <i>B</i> value has exactly one corresponding
<i>A</i> value.
In other words, the relationship must be 1:1.
</p>
<?=endAnswer()?>
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
<?=startAnswer()?>
Derivation of A<sup>+</sup> ...
<br> given {A}
... using A &rarr; B gives {A,B}
... no further attributes can be added
<br> =>  A<sup>+</sup> = {A,B}
</p>
<?=endAnswer()?>
<li> <p><i>ACEG<sup>+</sup></i></p>
<?=startAnswer()?>
<p>
Derivation of ACEG<sup>+</sup>
<br> given {A,C,E,G}
... using A &rarr; B gives {A,B,C,E,G}
... using BC &rarr; F gives {A,B,C,E,F,G}
... no more
<br> ACEG<sup>+</sup> = {A,B,C,E,F,G}
</p>
<?=endAnswer()?>
<li> <p><i>BD<sup>+</sup></i></p>
<?=startAnswer()?>
<p>
Derivation of BD<sup>+</sup>
<br> given {B,D}
... using BD &rarr; EG gives {B,D,E,G}
... using  BEG &rarr; FA gives {A,B,D,E,F,G}
... using AD &rarr; C gives {A,B,C,D,E,F,G}
... no more
<br> BD<sup>+</sup> = {A,B,C,D,E,F,G}
</p>
<?=endAnswer()?>
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
<?=startAnswer()?>
<p>
A candidate key is any set <i>X</i>, such that <i>X<sup>+</sup> = R</i>
and there is no <i>Y</i> subset of <i>X</i> such that <i>Y<sup>+</sup> = R</i>.
</p>
<p>
In this case, the candidate keys are &nbsp; <i>CDE</i>, &nbsp; <i>ACD</i>,
&nbsp; <i>BCD</i>.
</p>
<?=endAnswer()?>
<li> <p>Is <i>R</i> in third normal form (3NF)?</p>
<?=startAnswer()?>
<p>
Yes, because the right hand sides of all dependencies (i.e. <i>B</i>,
<i>E</i>, <i>A</i>) are parts of keys.
</p>
<?=endAnswer()?>
<li> <p>Is <i>R</i> in Boyce-Codd normal form (BCNF)?</p>
<?=startAnswer()?>
<p>
No, because none of the left hand sides (i.e. <i>A</i>, <i>BC</i>, <i>ED</i>)
contains a key.
</p>
<?=endAnswer()?>
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
<?=startAnswer()?>
<ol type=a>
<li> Candidate keys: &nbsp; <i>B</i>
<li> Not BCNF ... e.g. in <i>C &rarr; A</i>, <i>C</i> does not contain a key
<li> Not 3NF ... e.g. in <i>C &rarr; A</i>, <I>C</i> does not contain a key, <i>A</i> is not part of a key
</ol><br>
<?=endAnswer()?>
<li>
<i>
B &rarr; C, &nbsp;
D &rarr; A
</i>
<?=startAnswer()?>
<ol type='a'>
<li> Candidate keys: &nbsp; <i>BD</i>
<li> Not 3NF ... neither right hand side is part of a key
<li> Not BCNF ... neither left hand side contains a key
</ol><br>
<?=endAnswer()?>
<li>
<i>
ABC &rarr; D, &nbsp;
D &rarr; A
</i>
<?=startAnswer()?>
<ol type='a'>
<li> Candidate keys: &nbsp; <i>ABC</i> &nbsp; <i>BCD</i>
<li> 3NF ... <i>ABC &rarr; D</i> is ok, and even <i>D &rarr; A</i> is ok,
because <i>A</i> is a single attribute from the key
<li> Not BCNF ... e.g. in <i>D &rarr; A</i>, <i>D</i> does not contain a key
</ol><br>
<?=endAnswer()?>
<li>
<i>
A &rarr; B, &nbsp;
BC &rarr; D, &nbsp;
A &rarr; C
</i>
<?=startAnswer()?>
<ol type='a'>
<li> Candidate keys: &nbsp; <i>A</i>
<li> Not 3NF ... e.g. in <i>A &rarr; C</i>, <i>C</i> is not part of a key
<li> Not BCNF ... e.g. in <i>BC &rarr; D</i>, <i>BC</i> does not contain a key
</ol><br>
<?=endAnswer()?>
<li>
<i>
AB &rarr; C, &nbsp;
AB &rarr; D, &nbsp;
C &rarr; A, &nbsp;
D &rarr; B
</i>
<?=startAnswer()?>
<ol type='a'>
<li> Candidate keys: &nbsp; <i>AB</i> &nbsp; <i>BC</i> &nbsp; <i>CD</i> &nbsp; <i>AD</i>
<li> 3NF ... for <i>AB</i> case, first two fd's are ok,
and the others are also ok because the RHS is a single attribute from the key
<li> Not BCNF ... e.g. in <i>C &rarr; A</i>, <i>C</i> does not contain a key
</ol><br>
<?=endAnswer()?>
<li>
<i>
A &rarr; BCD
</i>
<?=startAnswer()?>
<ol type='a'>
<li> Candidate keys: &nbsp; <i>A</i>
<li> 3NF ... all left hand sides are superkeys
<li> BCNF ... all left hand sides are superkeys
</ol><br>
<?=endAnswer()?>
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
<?=startAnswer()?>
<p>
Functional dependencies:
</p>
<ul>
<li><tt>Team ...
	name &rarr; captain
    </tt>
<li><tt>Player ...
	name &rarr; teamPlayedFor
    </tt>
<li><tt>Fan ...
	name &rarr; address
    </tt>
<li><tt>TeamColours</tt> ... no non-trivial <i>fd</i>s
<li><tt>FavouriteColours</tt> ... no non-trivial <i>fd</i>s
<li><tt>FavouritePlayers</tt> ... no non-trivial <i>fd</i>s
<li><tt>FavouriteTeams</tt> ... no non-trivial <i>fd</i>s
</ul>
<p>
For each relation, every non-trivial <i>fd</i> has a left hand side
which is a super key &rArr; each
relation is in BCNF and the whole schema is in BCNF.
</p>
<?=endAnswer()?>

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
<?=startAnswer()?>
<p>
Functional dependencies:
</p>
<ul>
<li><tt>Warehouse ...
	warehouse# &rarr; address
    </tt>
<li><tt>Source</tt> ... no non-trivial <i>fd</i>s
<li><tt>Trip ...
	trip# &rarr; date,truck
    </tt>
<li><tt>Truck ...
	truck# &rarr; maxvol,maxwt
    </tt>
<li><tt>Shipment ...
	truck# &rarr; volume,weight,trip,store
    </tt>
<li><tt>Store ...
	store# &rarr; storename,address
    </tt>
</ul>
<p>
For each relation, every non-trivial <i>fd</i> has a left hand side
which is a super key &rArr; each
relation is in BCNF and the whole schema is in BCNF.
</p>
<p>
This just goes to show that ER design generally leads to well-structured
relational designs.
</p>
<?=endAnswer()?>

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
<?=startAnswer()?>
<p>
<ol type='i'>
<p><li> application of the 3NF algorithm decomposes <i>R</i> into
	three relations based on the dependencies
	(<i>R<sub>1</sub>(CD)</i>, <i>R<sub>2</sub>(CA)</i>, <i>R<sub>3</sub>(BC)</i>);
	this decomposition leaves enough "connectivity" between the
	relations that no extra "candidate key" relation is needed
	to make them join-preserving
	(from now on, we denote a relation like <i>R<sub>1</sub>(CD)</i>
	 simply by <i>CD</i>)
<p><li> the above 3NF decomposition is also in BCNF
</ol>
<?=endAnswer()?>
<li><p>
<i>
B &rarr; C, &nbsp;
D &rarr; A
</i>
<p>
<?=startAnswer()?>
<ol type='i'>
<p><li> application of the 3NF algorithm decomposes <i>R</i> into
	<i>BC, AD</i> (using the dependencies), but also requires
	the addition of a "linking" relation <i>BD</i> containing
	the candidate key
<p><li> this is the same decomposition that would be reached by
	following the BCNF algorithm, although it would proceed
	by first producing <i>AD, BCD</i> and then decomposing
	<i>BCD</i> further into <i>BC, BD</i>
</ol>
<?=endAnswer()?>
<li><p>
<i>
ABC &rarr; D, &nbsp;
D &rarr; A
</i>
</p>
<?=startAnswer()?>
<ol type='i'>
<p><li> <i>R</i> is already in 3NF
<p><li> applying the BCNF algorithm means decomposition to "fix"
	the violation caused by
	<i>D &rarr; A</i>
	giving <i>AD, BCD</i>
	(note that this does not preserve the dependency
	<i>ABC &rarr; D</i>,
	and, in fact, it is not possible to find a BCNF decomposition
	which does preserve it)
</ol>
<?=endAnswer()?>
<li><p>
<i>
A &rarr; B, &nbsp;
BC &rarr; D, &nbsp;
A &rarr; C
</i>
</p>
<?=startAnswer()?>
<ol type='i'>
<p><li> the standard algorithm produces <i>AB, BCD, AC</i>, which contains
	enough connectivity to not require a "linking" relation
<p><li> <i>BC &rarr; D</i> violates BCNF
	because <i>BC</i> does not contain a key, so we split <i>R</i>
	into <i>BCD, ABC</i>, and this is now BCNF
</ol>
<?=endAnswer()?>
<li><p>
<i>
AB &rarr; C, &nbsp;
AB &rarr; D, &nbsp;
C &rarr; A, &nbsp;
D &rarr; B
</i>
</p>
<?=startAnswer()?>
<ol type='i'>
<p><li> <i>R</i> is already in 3NF
<p><li> applying the standard BCNF decomposition algorithm requires us
	to "fix" the BCNF violations caused by 
	<i>C &rarr; A</i> and
	<i>D &rarr; B</i>; this could
	be achieved by decomposing <i>R</i> into <i>AC</i> and <i>BCD</i>,
	but this does not preserve the other dependencies; to achieve
	dependency preservation requires the following decomposition:
	<i>AC, BD, CD, ABC, ABD</i> <small>(but the methods for doing
	this were not covered in lectures)</small>
</ol>
<?=endAnswer()?>
<li><p>
<i>
A &rarr; BCD
</i>
</p>
<?=startAnswer()?>
<ol type='i'>
<p><li> <i>R</i> is already in 3NF
<p><li> <i>R</i> is already in BCNF
</ol>
<?=endAnswer()?>
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
<?=startAnswer()?>
<p>  <i>acct# &rarr; kind, balance, branch#</i>
<br> <i>branch# &rarr; city</i>
<br> <i>tfn &rarr; name</i>
<p>
These all come from the semantics of the problem (e.g. each account has
exactly one type and balance, and is held at a specific branch).
</p>
<?=endAnswer()?>
<li> <p>Using these functional dependencies, decompose <i>R</i> into a set of BCNF relations.</p>
<?=startAnswer()?>
<p>
In this case, the 3NF decomposition from applying the above three <i>fd</i>s
produces a BCNF decomposition as well. This is the simplest and most natural
decomposition of the problem.
</p>
<pre>
Account(<u>acct#</u>, kind, balance, <i>branch</i>)
Branch(<u>branch#</u>, city)
Customer(<u>tfn</u>, name)
CustAcc(<u><i>customer</i></u>, <u><i>account</i></u>)
</pre>
<p>
The first three relations come directly from the dependencies;
the last relation comes from the final check for a relation with a
candidate key for <i>R</i> in the 3NF algorithm.
</p>
<?=endAnswer()?>
<li> <p>State whether the new relations are also in 3NF.</p>
<?=startAnswer()?>
<p>
Since we produced the new relations using the 3NF decomposition method,
then they must be in 3NF.
</p>
<?=endAnswer()?>
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
<?=startAnswer()?>
<p>
<i>pNum &rarr; pName</i>
<br> <i>eNum &rarr; eName</i>
<br> <i>jobClass &rarr; payRate</i>
<br> <i>pNum,eNum &rarr; jobClass,payRate,hours</i>
<p>
The above implies that <i>pNum,eNum</i> is a key for this relation (these
attributes determine all of the others).
<p>
Based on semantics given in the descriptions <em>and</em> on some
further assumptions, such as:
<ul>
<li> one employee can work on several projects
<li> they may be doing a different job in each project
</ul>
<p>
<?=endAnswer()?>
<li> Using these functional dependencies, decompose <i>R</i> into a set
	of BCNF relations.
<?=startAnswer()?>
<p>
Following the BCNF decomposition algorithm ...
</p>
<ul>
<li> <i>pNum &rarr; pName</i> is a dependency on part of the key <br>
to fix: decompose to <i>R1(pNum,eNum,eName,jobClass,payRate,hours)</i> and <i>R2(pNum,pName)</i>
<li> <i>eNum &rarr; eName</i> is a dependency on part of the key <br>
to fix: decompose to <i>R1(pNum,eNum,jobClass,payRate,hours)</i> and <i>R2(pNum,pName)</i> and <i>R3(eNum,eName)</i>
<li> <i>jobClass &rarr; payRate</i> is a dependency on a non-key attribute <br>
to fix: decompose to <i>R1(pNum,eNum,jobClass,hours)</i> and <i>R2(pNum,pName)</i> and <i>R3(eNum,eName)</i> and <i>R4(jobClass,payRate)</i>
</ul>
<p>
The relevant functional dependencies are now:
<p>  <i>pNum &rarr; pName</i>
<br> <i>eNum &rarr; eName</i>
<br> <i>jobClass &rarr; payRate</i>
<br> <i>pNum,eNum &rarr; jobClass,hours</i>
<p>
With these dependencies there are no violations of BCNF, so the schema is
now in BCNF, and we could rename the relations as:
</p>
<pre>
Project(<u>pNum</u>, pName)
Employee(<u>eNum</u>, eName)
AwardRates(<u>jobClass</u>, payRate)
Assignment(<u><i>pNum</i></u>, <u><i>eNum</i></u>, <i>jobClass</i>, hours)
</pre>
<p>
<?=endAnswer()?>
<li> State whether the new relations are also in 3NF.
<?=startAnswer()?>
<p>
The new schema is <em>not</em> in 3NF because we have lost the
dependency: <i>pNum,eNum &rarr; payRate</i>
</p>
<?=endAnswer()?>
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
<?=startAnswer()?>
<ul>
<li> <i>P &rarr; A</i> ... the property code identifies a particular address
<li> <i>PW &rarr; N</i> ... notes are based on a particular visit to a property
<li> <i>PW &rarr; S</i> ... one staff member carries out each property visit
<li> <i>S &rarr; M</i> ... the staff number determines the staff member's name
<li> <i>S &rarr; C</i> ... each staff member uses a particular car (from table)
</ul>
<p>
Other dependencies are possible (e.g. <i>M &rarr; S</i>), but they appear
less plausible, given the semantics of the application.
</p>
<?=endAnswer()?>

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
<?=startAnswer()?>
<p>
Describe any functional dependencies that exist in this data.
</p>
<ul>
<li> <i>C &rarr; AH</i> ... a contract is with a particular hotel
<li> <i>A &rarr; H</i> ... each hotel has a unique ABN
<li> <i>T &rarr; N</i> ... each employee has a unique TFN
<li> <i>CT &rarr; R</i> ... each employee works specified hours on a contract
</ul>
<p>Other potential dependencies that <b>do not</b> apply:</p>
<ul>
<li> <i>C &rarr; T</i> ... because many employees can work on a contract
<li> <i>H &rarr; A</i> ... two different hotels may have the same name (e.g. Hilton)
</ul>
<?=endAnswer()?>

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
<?=startAnswer()?>
<p>
Since <i>A</i> has a different value in every tuple, it determines all
other attributes:
</p>
<p>
<i>A &rarr; B, A &rarr; C, A &rarr; D &nbsp; or &nbsp; A &rarr; BCD</i>
</p>
<p>
Also, <i>A</i> in combination with any other subset of attributes
determines all the others.
</p>
<p>
Similar reasoning could be applied to the combination <i>BCD</i>, since
it's unique over all tuples.
</p>
<p>
It also appears that <i>B &rarr; C</i>, but not <i>C &rarr; B</i>.
</p>
<p>
This case is different to the previous two because
there are no application semantics to draw on to determine reasonableness
of choice of FDs. All you can do is look for counter-examples
to eliminate certain potential dependencies.
Example: since <i>(C=6,B=a)</i> and <i>(C=6,B=d)</i> we can eliminate
<i>C &rarr; B</i>.
</p>
<?=endAnswer()?>

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
<?=startAnswer()?>
<p>
Steps in converting to a minimal cover:
</p>
<ol>
<p><li> put FDs into canonical form:
<p>
<i>B &rarr; A, D &rarr; A, AB &rarr; D</i> is already in canonical form.
<p><li> eliminate redundant attributes:
<p>
The only possible redundant attributes are <i>A</i> or <i>B</i>
in <i>AB &rarr; D</i>.
<p>
We can prove that <i>A</i> is redundant as follows:
<p>
<i>B &rarr; A &nbsp; &rArr; &nbsp; BB &rarr; AB &nbsp; &rArr; &nbsp; B &rarr; AB</i>
<p>
<i> AB &rarr; D + B &rarr; AB &nbsp; &rArr; &nbsp; B &rarr; D</i>
<p>
Since we have <i>AB &rarr; D</i> and <i>B &rarr; D</i>, <i>A</i> is redundant.
<p><li> eliminate redundant dependencies:
<p>
The above elimination leaves:
<i>B &rarr; A, D &rarr; A, B &rarr; D</i>
<p>
But <i>D &rarr; A, B &rarr; D &nbsp; &rArr; &nbsp; B &rarr; A</i>
</ol>
<p>
So, the minimal cover is: <i>B &rarr; D, D &rarr; A</i>
</p>
<?=endAnswer()?>

<li>
<p>
Using the functional dependencies you produced in Q10,
convert the real-estate inspection spreadsheet (single
table), into a BCNF relational schema.
</p>
<?=startAnswer()?>
<p>
FDs:
&nbsp; <i>P &rarr; A</i>,
&nbsp; <i>PW &rarr; NS</i>,
&nbsp; <i>S &rarr; MC</i>
&nbsp <small>(reduced from the 5 FDs given above)</small>
</p>
<ul>
<li>
We start from a schema: <i>PAWNSMC</i>, which has key <i>PW</i>
	<small>(work it out from FDs)</small>.
<li>
The FD <i>S &rarr; MC</i> violates BCNF (FD with non-key on LHS).
<li>
To fix, we need to decompose into tables <i>PAWNS</i> and <i>SMC</i>.
<li>
Key for <i>PAWNS</i> is <i>PW</i>, and key for <i>SMC</i> is <i>S</i>.
<li>
Since all attributes in <i>SMC</i> are f-dependent on whole key, <i>SMC</i> is in BCNF.
<li>
The FD <i>P &rarr; A</i> violates BCNF in <i>PAWNS</i> (FD with partial key on LHS).
<li>
To fix, we need to decompose into tables <i>PWNS</i> and <i>PA</i>.
<li>
Key for <i>PAWNS</i> is <i>PW</i>, and key for <i>SMC</i> is <i>S</i>.
<li>
In both tables, all attributes are f-depdendent on whole key &rArr; BCNF.
<li>
Final schema (with keys boldened):
&nbsp; <i><b>PW</b>NS</i>,
&nbsp; <i><b>P</b>A</i>,
&nbsp; <i><b>S</b>MC</i>
</ul>
<?=endAnswer()?>

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
<?=startAnswer()?>
<p>
This is just one of many possible decompositions.
Variations occur because of choice of candidate key (although
not in this example) and choice of non-BCNF FD to resolve at each step.
</p>
<ul>
<li>
We start from a schema: <i>ABCDEFGH</i>, with key <i>BH</i>
	<small>(work it out from FDs)</small>.
<li>
The FD <i>A &rarr; DE</i> violates BCNF (FD with non key on LHS).
<li>
To fix, we need to decompose into tables: <i>ADE</i> and <i>ABCFGH</i>.
<li>
FDs for <i>ADE</i> are <i>{ A &rarr; DE }</i>, therefore key is <i>A</i>, therefore BCNF.
<li>
FDs for <i>ABCFGH</i> are <i>{ ABH &rarr; C,&nbsp; BGH &rarr; F,&nbsp; F &rarr; AH,&nbsp; BH &rarr; G }</i>
<li>
Key for <i>ABCFGH</i> is <i>BH</i>, and FD <i>F &rarr; AH</i> violates BCNF (FD with non key on LHS).
<li>
To fix, we need to dcompose into tables: <i>AFH</i> and <i>BCFG</i>.
<li>
FDs for <i>ADE</i> are <i>{ F &rarr; AH }</i>, therefore key is <i>F</i>, therefore BCNF.
<li>
FDs for <i>BCFG</i> are <i>{ }</i>, so key is <i>BCFG</i> and table is BCNF.
<li>
Final schema (with keys boldened):
&nbsp; <i><b>A</b>DE</i>,
&nbsp; <i><b>F</b>AH</i>,
&nbsp; <i><b>BCFG</b></i>
</ul>
<?=endAnswer()?>

<li>
<p>
Using the functional dependencies you produced in Q10,
convert the real-estate inspection spreadsheet (single
table), into a 3NF relational schema.
<?=startAnswer()?>
<p>
FDs:
&nbsp; <i>P &rarr; A</i>,
&nbsp; <i>PW &rarr; N</i>,
&nbsp; <i>PW &rarr; S</i>,
&nbsp; <i>S &rarr; M</i>,
&nbsp; <i>S &rarr; C</i>
<p>
This looks like a minimal cover; no redunant attributes; no redundant FDs.
<p>
3NF is constructed directly from the minimal cover,
after combinining dependencies with a common right hand side.
<p>
<i>F<sub>c</sub></i> &nbsp; =
&nbsp; <i>P &rarr; A</i>,
&nbsp; <i>PW &rarr; NS</i>,
&nbsp; <i>S &rarr; MC</i>
<p>
Gives the following tables (with table keys in <b>bold</b>):
<p>
<i><b>P</b>A</i> &nbsp; <i><b>PW</b>NS</i> &nbsp; <i><b>S</b>MC</i>
<p>
Since <i>PW</i> is a key for the whole schema, and since a table
contains this key, the 3NF decompostion is complete:
<p>
3NF &nbsp;=&nbsp; <i><b>P</b>A</i> &nbsp; <i><b>PW</b>NS</i> &nbsp; <i><b>S</b>MC</i>
<?=endAnswer()?>

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
<?=startAnswer()?>
<p>
3NF is constructed directly from the minimal cover,
after combinining dependencies with a common right hand side where possible.
<p>
<i>F<sub>c</sub> &nbsp;=&nbsp; BH &rarr; C, &nbsp; A &rarr; D, &nbsp; C &rarr; E, &nbsp; F &rarr; A, &nbsp; E &rarr; F</i>
<p>
Gives the following tables (with table keys in <b>bold</b>):
<p>
<i><b>BH</b>C</i> &nbsp; <i><b>A</b>D</i> &nbsp;
<i><b>C</b>E</i> &nbsp; <i><b>F</b>A</i> &nbsp; <i><b>E</b>F</i>
<p>
A key for <i>R</i> is <i>BHG</i>; <i>G</i> must be included because it
appears in no function dependency.
<p>
Since no table contains the whole key for <i>R</i>,
we must add a table containing just the key, giving:
<p>
3NF = <i><b>BH</b>C</i> &nbsp; <i><b>A</b>D</i> &nbsp;
<i><b>C</b>E</i> &nbsp; <i><b>F</b>A</i> &nbsp; <i><b>E</b>F</i> &nbsp;
<i><b>BGH</b></i>
</p>
<?=endAnswer()?>
</ol>


</ol>
</body>
</html>
