<?php
require("../../course.php");
const SHOW_ANSWERS = true;
echo startPage("Week 08","q+a","Python/Psycopg2");
?>

<ol>

<li>
<p>
What is the difference between a <i>connection</i> and a <i>cursor</i>
in Psycopg2?
How do you create each?
</p>
</li>

<li>
<p>
<small>[Question courtesy of Clifford Sesel]</small>
The following Python script (in a executable file called <tt>opendb</tt>)
aims to open a connection to a database
whose name is specified on the command line:
</p>
<?=codeString(<<<_Py_
#!/usr/bin/python3
import sys
import psycopg2
if len(sys.argv) < 2:
    print("Usage: opendb DBname")
    exit(1)
db = sys.argv[1]
try:
    conn = psycopg2.connect(f"dbname={db}")
    print(conn)
    cur = conn.cursor()
except psycopg2.Error as err:
    print("database error: ", err)
finally:
    if conn is not None:
        conn.close()
    print("finished with the database")
_Py_
,"python")?>
<p>
When invoked with an existing database, it behaves as follows
</p>
<pre>
$ <b>./opendb beers2</b>
&lt;connection object at 0x7fac401799f0; dsn: 'dbname=beers2', closed: 0&gt;
finished with the database
</pre>
<p>
but when invoked with a non-existent database it produces
</p>
<pre>
$ <b>./opendb nonexistent</b>
database error:  FATAL:  database "nonexistent" does not exist

Traceback (most recent call last):
  File "./opendb", line 16, in <module>
    if conn :
NameError: name 'conn' is not defined
</pre>
<p>
rather than
</p>
<pre>
$ <b>./opendb nonexistent</b>
database error:  FATAL:  database "nonexistent" does not exist

finished with the database
</pre>
<p>
What is the problem? And how can we fix it?
</li>

<li>
<p>
Using the <tt>mymy2</tt> databasae,
write a Python script called <tt>class-roll</tt> that takes
two command-line arguments (subject code and term code) and
produces a list of students enrolled in that course.
Each line should contain: studentID, name.
The name should appear as "familyName, givenNames" and the
list should be ordered by familyName then by givenName. e.g.
</p>
<p>
Some examples of use:
</p>
<pre>
$ <b>./class-roll COMP1521</b>
Usage: class-roll subject term

$ <b>./class-roll COMP1511 16s1</b>
COMP1511 16s1
No students

$ <b>./class-roll COMP1151 16s1</b>
COMP1151 17s1
No students

$ <b>./class-roll COMP1511 17s1</b>
COMP1511 17s1
3144615 Abd Hapiz, Chung Yan Stanley
3053189 Abdul Razak, Daniel Wynne
3205604 Allen, Vivian Wing-Man
3263923 Ann, Dah Chuang
3160983 Anusaitis, Artemij
3176663 Au Yeung, Wing Yee Yester
3035742 Bach, Catherine Lydia
3031314 Bagot, Diana Edith
<span class="comment">... plus many more students ...</span>
</pre>
</li>

<li>
<p>
The script in the previous question was a little bit sloppy in its
error detection, and the messages did not distinguish between a
real course with no students and a bad value for either the subject
code or the term code, or a valid pair of codes for which there was
no course offering.
The script should also now print the long name of the subject.
Improve the script so it behaves as follows:
</p>
<pre>
$ <b>./class-roll1 COMP1151 15s1</b>
Invalid subject COMP1151

$ <b>./class-roll1 COMP1511 88xx</b>
Invalid term 88xx

$ <b>./class-roll1 COMP1511 15s1</b>
No offering: COMP1511 15s1

$ <b>./class-roll1 COMP3331 18s2</b>
COMP3331 18s2 Computer Networks and Applications
3053189 Abdul Razak, Daniel Wynne
3075924 Arneman, Natasha Katherine
3117492 Atkins, Tong-Cheng
3110022 Balasubramanian, Alexander Ian
3173929 Barany, Wilson Ka-Chuen
3185371 Barling, Jason Wei
<span class="comment">... plus many more students ...</span>
</pre>
</li>

</ol>

</body>
</html>
