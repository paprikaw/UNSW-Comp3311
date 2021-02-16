<?php require("course.php"); ?>
<?=startPage("COMP3311 21T1<br>Database Systems")?>

<p style="text-align:center">
Access to this material is normally via
<a href="https://webcms3.cse.unsw.edu.au/COMP3311/21T1/">WebCMS</a>.
<br>
This page will give you access to most of the material<br>
in the unlikely event that WebCMS isn't working.
<br>
<span style='color:#CC0000; font-size:11pt'>
Material is released onto the site gradually.</span>
</p>
<?php
showContents(array(
array("admin/index.php","Admin","Administrative documents e.g. course outline"),
array("lectures/index.html","Lecture Slides","Slides from Topic Videos"),
array("notes/index.html","Course Notes","Detailed notes (expand on lectures)"),
array("tutes/index.php","Tutorial Exercises","Tutorial exercises and solutions"),
array("pracs/index.php","Practical Exercises","Practical exercises and solutions"),
array("assignments/index.php","Assignments","Specifications and other material for the assignments"),
array("documentation/index.php","Documentation","Documentation for tools used in this course"),
array("readings/index.php","Readings","Documentation for tools, old lectures, etc."),
));
?>
<?=endPage()?>
