<?php require("../../course.php");
const SHOW_ANSWERS = true;
echo startPage("Week 03","q+a", "ER&rightarrow;Rel Mapping, SQL DDL, ER&rightarrow;SQL Mapping");
?>
<div class="note">
We have adopted (and violated) several conventions in the SQL schemas in these questions.
<ul>
<li>
We have suggested that all tables derived from entities should have
pluralised names (e.g Student in ER, Student in relational box-and-arrows,
Students in SQL). Our examples and solutions don't always do this.
</li>
<li>
We have suggested not using all upper-case for SQL keywords.
Many of our solutions use upper-case keywords.
</li>
<li>
We have suggested that primary and foreign keys always be defined after
the attributes, despite the fact that there are more compact ways of
defining them. We sometimes use the compact versions of key definitions.
</li>
</ul>
Note that all of the above are style conventions. Not doing them will not
make an SQL "program" incorrect, but mixing them in a single <tt>*.sql</tt>
file is bad style. We would, however, prefer that you adopt our suggestions.
</div>

<ol>

<br><li>
<p>
Why is it useful to first do an ER design and then convert this
into a relational schema?
</p>

<br><li>
<p>
Convert each of the following ER design fragments into
a relational data model expressed as a box-and-arrow diagram:
<p>
<ol type='a'>
<li> <br> <img src="Pics/teaches1.png">
<li> <br> <img src="Pics/teaches2.png">
<li> <br> <img src="Pics/teaches3.png">
</ol>
</p>

<br><li>
<p>
In the mapping from the ER model to the relational model,
there are three different ways to map class hierarchies
(ER, OO, single-table).
Show each of them by giving the mapping for the following
class hierarchy:
</p>
<img src="Pics/classes.png">
<p>
Use box-and-arrow diagrams for the relational models.
</p>

<br><li>
<p>
Now consider a variation on the above class hierarchy where
the sub-classes are disjoint.
Show the three possible mappings for the class hierarchy and
discuss how effectively they represent the semantics of the
disjoint sub-classes:
</p>
<img src="Pics/classes1.png">
<p>
Use box-and-arrow diagrams for the relational models.
</p>

<br><li>
<p>
Consider the following two relation definitions:
<ol type='a'>
<li><p> <img src="Pics/pk1.png" valign="top"></p></li>
<li><p> <img src="Pics/pk2.png" valign="top"></p></li>
</ol>
For each, show the possible ways of defining the primary
key in the corresponding SQL &nbsp;<tt>create table</tt>&nbsp; statement.
</p>

<br><li>
<p>
Discuss suitable SQL representations for each of the following
attributes, including additional domain constraints where relevant:
</p>
<ol type='a'>
<li> <p>people's names</p>
<li> <p>addresses</p>
<li> <p>ages</p>
<li> <p>dollar values</p>
<li> <p>masses of material</p>
</ol>

<br><li>
<p>
Convert the following entity into an SQL <tt>CREATE TABLE</tt>
definition:
<p>
<img src="Pics/q2a.png">
<p>
Give reasons for all choices of domain types.
</p>

<br><li>
<p>
Convert the following entity into an SQL <tt>CREATE TABLE</tt>
definition:
<p>
<img src="Pics/q2b.png">
<p>
Give reasons for all choices of domain types.
</p>

<br><li>
<p>
Convert the following ER design into a relational data model:
</p>
<img src="Pics/unier.png">
<p>
You can assume that each attributes contains (at least) a suitably-named
attribute containing a unique identifying number (e.g. the <tt>Lecturer</tt>
entity contains a <tt>LecID</tt> attribute).
</p>

<br><li>
<p>
Convert the following ER design into an SQL schema:
</p>
<img src="Pics/supplier-part.png">
<p>
Which elements of the ER design do not appear in the relational version?
</p>

<br><li>
<p>
Convert the following ER design into a relational data model
expressed first as a box-and-arrow diagram and then as a
sequence of statements in the SQL data definition language:
</p>
<img src="Pics/accidenter.png">
<p>
Which elements of the ER design do not appear in the relational version?
</p>

<br><li>
<p>
<small>[Based on GUW 2.1.3]</small>
Convert the following ER design into a relational data model
expressed first as a box-and-arrow diagram and then as a
sequence of statements in the SQL data definition language:
</p>
<img src="Pics/teamer.png">
<p>
Which elements of the ER design do not appear in the relational version?
</p>

<br><li>
<p>
Convert the following ER design into a relational data model
expressed first as a box-and-arrow diagram and then as a
sequence of statements in the SQL data definition language:
<p>
<img src="Pics/trucker.png">
<p>
Which elements of the ER design do not appear in the relational version?
</p>

<br><li>
<p>
Convert the following ER design to relational form:
<p>
<img src="Pics/emp-dept-proj.png">
<p>
Which elements of the ER design do not appear in the relational version?
</p>

<br><li>
<p>
Using this version of the Person class hierarchy,
from the Medical scenario described previously,
convert the ER design to relational form as an SQL schema:
<p>
<img src="Pics/medical1.png">
</p>
Give mappings using both the ER style and single-table-with-nulls style.
</p>

<br><li>
<p>
Convert this ER design for the medical scenario into relational form:
<p>
<img src="Pics/medical3.png">
<p>
Assume that the Person classes are mapped using the ER-style mapping.
Which elements of the ER design do not appear in the relational version?
</p>

<br><li>
<p>
Convert this ER design for the book publishing scenario into an SQL schema:
<p>
<img src="Pics/books.png">
<p>
Give two versions, one using the ER-style mapping of subclasses,
and the other using single-table-with-nulls mapping of subclasses.
</p>

</ol>
</body>
</html>
