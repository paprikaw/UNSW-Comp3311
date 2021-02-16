<? require("../../course.php"); require("defs.php"); ?>
<?=startPage("Assignment 2","","Fixes and Updates")?>
<?=updateBlurb().scriptMenu($menu)?>

<br>
<p>
This file will contain descriptions for any fixes to solve minor bugs that
people might find in the supplied code/database.
Each fix is tagged with a timestamp, which is when I fixed it in the
supplied code. If you collected the code/database after that time,
it will already have the relevant fix included.
</p>

<h3>
Fix #5: complete schema.sql
&nbsp; <span class='tiny'>(Sat 17 Oct 3:30pm)</span>
</h3>
<p>
Added tables that were in the database (mymy1.dump) but not in schema.sql.
</p>

<h3>
Fix #4: Q8 description
&nbsp; <span class='tiny'>(Sat 17 Oct 3:30pm)</span>
</h3>
<p>
The definition for the transcipt function was incomplete (very incomplete).
It is now complete and hopefully unambiguous and internally consistent.
</p>

<h3>
Fix #4: test cases for Q4[ab]
&nbsp; <span class='tiny'>(Fri 16 Oct 11:30pm)</span>
</h3>
<p>
The test cases for Q4[ab] were missing the "name" column that the view should return by the view
The contents of the "name" columns have now been added.
</p>


<h3>
Fix #3: terminology in Q7
&nbsp; <span class='tiny'>(Fri 16 Oct 3:45pm)</span>
</h3>
<p>
I was sucked in by UNSW terminology. Most of the uses of "course"
in the Q7 description and template have been changed to "subject".
</p>

<h3>
Fix #2: Q4 needs two views, one for each database instance
&nbsp; <span class='tiny'>(Fri 16 Oct 1:45pm)</span>
</h3>
<p>
Realised that the mymy2 database instance will not have 05s2
data, so split into two views: one for 05s2 and the other for 17s1.
Probably would have been better to make it into an SQL function.
Oh well.
</p>

<h3>
Fix #1: miscellaneous typos / old references in spec
&nbsp; <span class='tiny'>(Fri 16 Oct 1:41pm)</span>
</h3>
<p>
Removed references to PHP and ass3 from the "How to do" section.
</p>

<!--
<h3>
Fix #N: xxx
&nbsp; <span class='tiny'>(Day DD May HH:MMpm)</span>
</h3>
<p>
xxx
</p>
-->

<?=endPage()?>
