<? require("../../course.php"); require("defs.php"); ?>
<?=startPage("Assignment 3","","The IMDB Database")?>
<?=updateBlurb().scriptMenu($menu)?>

<h3>Introduction</h3>
<p>
This document contains a description of the data model 
for the IMDB database.
Note that schema is simplified from the original
downloadable data available on line, and contains
substantially less data.
We consider only movies that were made after 1959 and
have a reasonable rating. The original data contains
a variety of other media types (e.g. TV series) and
considers movies from the late 1800's onwards, even
junk ones with low ratings.
</p>

<h3>Data Model and Schema</h3>
<p>
This section aims to give an overview of the data model.
It concentrates mainly on the entities and their relationships.
The details of attributes are provided by comments in the
<a href="schema.php">SQL schema</a>.
</p>
<p>
Treat the ER data model description below as an overview,
and consult the
<a href="schema.php">SQL Schema</a> for full details.
The SQL schema makes some deviations from the ER design:
</p>
<ul>
<li> entity names are singular here, but plural in the SQL schema
<li> attribute names are often shortened in the SQL schema
<li> the Aliases entity is given as a weak entity here, <br>
     but has its own id (i.e strong entity) in the SQL schema
</ul>
<p>
To make the presentation clearer, the data model is presented in a
number of sections.
</p>

<h3 class="entity">"People"</h3>
<p>Entities and relationships related to people and other entities
who appear in movies.
<div align="center">
<img src="Pics/names.png">
</div>
Comments:
<ul>
<li> xxx
</ul>


<h3 class="entity">Movies and Aliases</h3>
<p>Entities and relationships linking people and the unit they work in ...</p>
<div align="center">
<img src="Pics/movies.png">
&nbsp; &nbsp; &nbsp;
&nbsp; &nbsp; &nbsp;
<img src="Pics/aliases.png">
</div>
Comments:
<ul>
<li> xxx
</ul>

<h3 class="entity">Overview</h3>
<p>All entities (without attributes) and relationships between them
<div align="center">
<img src="Pics/imdb.png">
</div>
Comments:
<ul>
<li> xxx
</ul>

<?=endPage()?>
