<? require("../../course.php"); require("defs.php"); ?>
<?=startPage("Assignment 3","","Python, Psycopg2 and IMDB")?>
<?=updateBlurb().scriptMenu($menu)?>

<h2>Aims</h2>
<p>
This assignment aims to give you practice in
</p>
<ul>
<li> manipulating a moderately large database (IMDB)
<li> implementing SQL views to satisfy requests for information
<li> implementing PLpgSQL functions to satisfy requests for information
<li> implementing Python scripts to extract and display data
</ul>
<p>
The goal is to build some useful data access operations on the
Internet Movie Database (IMDB),
which contains a wealth of information about movies, actors, etc.
You need to write Python scripts, using the Psycopg2 database
connectivity module, to extract and display information from
this database.
</p>

<h2>Summary</h2>
<p>
<table cellpadding="8">
<tr valign="top">
<td> <b>Submission</b>: </td>
<td> Login to Course Web Site &gt; Assignments
	&gt; Assignment 3 &gt; [Submit] &gt; upload required files, or <br>
	on a CSE server, <tt>give cs3311 ass3 <i>RequiredFiles</i></tt> </td>
</tr>
<tr valign="top">
<td> <b>Required Files</b>: </td>
<td> <tt>xtras.sql</tt> &nbsp; <tt>helpers.py</tt> &nbsp; <tt>best</tt> &nbsp; <tt>rels</tt> &nbsp; <tt>minfo</tt> &nbsp; <tt>bio</tt>
</tr>
<tr valign="top">
<td> <b>Deadline</b>: </td>
<td> 15:00 Monday 23 November </td>
</tr>
<tr valign="top">
<td> <b>Marks</b>: </td>
<td> <b>14 marks</b> toward your total mark for this course </td>
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
<li> unpack the supplied files into this directory
<li> login to <tt>grieg</tt> and run your PostgreSQL server
<li> remove your Assignment 2 database
<li> set up a copy of the supplied database (must be called <span class="red"<tt>imdb</tt></span>)
<li> complete the tasks below by editing the files
<ul>
 <li> <tt>xtras.sql</tt> ... put any views or functions here
 <li> <tt>helpers.py</tt> ... put Python helper functions here
 <li> <tt>best</tt> ... Python script to list best movies
 <li> <tt>rels</tt> ... Python script to show world releases for a Movie
 <li> <tt>minfo</tt> ... Python script to show cast+crew for a Movie
 <li> <tt>bio</tt> ... Python script to show biography/filmography of a Name
</ul>
<li> submit these files via WebCMS <small>(you can submit multiple times)</small>
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
The Internet Movie Database (IMDB) is a huge collection of
information about all kinds of video media.
It has data about most movies since the dawn of cinema, but
also a vast amount of information about TV series, documentaries,
short films, etc.
Similarly, it holds information about the people who worked
on and starred in these video artefacts.
It also hold viewer ratings and crticis reviews for video artefacts
as well as a host of other trivia (e.g. bloopers).
</p>
<p>
The full IMDB database is way too large to let you all build copies
of it, so we have have created a cut-down version of the
database that deals with well-rated movies from the last 60 years.
You can find more details on the database schema in the
<a href="database.php">[Database Design]</a> page.
</p>
<p>
Some comments about the data in our copy of IMDB:
there seems to be preponderance of recent Bollywood movies;
some of the aliases look incorrect (e.g. for "Shawshank Redemption");
the data only goes to mid 2019, so you won't find recent blockbusters.
</p>


<h2>Doing this Assignment</h2>

<p>
This section describes how to carry out this assignment.
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
<p>
The first step in setting up this assignment is to set up a
directory to hold your files for this assignment.
</p>
<pre>
cse$ <b>mkdir /my/dir/for/ass3</b>
cse$ <b>cd /my/dir/for/ass3</b>
cse$ <b>unzip <?="$asDir/ass3.zip"?></b>
Archive: <?="$asDir/ass3.zip"?>

  inflating: best                    
  inflating: bio                     
  inflating: helpers.py              
  inflating: minfo                   
  inflating: rels                    
  inflating: xtras.sql               
</pre>
<p>
Note that the database dump is quite large.
Do not copy into your assignment directory
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
grieg$ <b>dropdb imdb</b>  <span class="comment">... if you already had such a database</span>
grieg$ <b>createdb imdb</b>
grieg$ <b>bzcat <?="$asDir/database/imdb.dump.bz2"?> | psql imdb</b>
grieg$ <b>psql imdb</b>
<span class="comment">... examine the database contents ...</span>
</pre>
<p>
Note the database contains non-ascii characters, and so you will
need to make sure that your PostgreSQL server uses <tt>UTF8</tt> encoding
(and corresponding collation) before it will load.
</p>
<p>
Loading the database should take less than 10 seconds on Grieg, assuming
that Grieg is not under heavy load.
(If you leave your assignment until the last minute, loading the database
on Grieg will be considerably slower, thus delaying your work even more.
The solution: at least load the database <em>Right Now</em>, even if you
don't start using it for a while.)
(Note that the <tt>imdb.dump</tt> file is 20MB in size; copying the
compressed version under your home directory or your <tt>srvr/</tt> directory,
and then decompressing it, is not a good idea).
</p>
<p>
If you have other large databases under your PostgreSQL server on Grieg
or you have large files under your <tt>/srvr/<i>YOU</i>/</tt> directory,
it is possible that you will exhaust your Grieg disk quota. In particular,
you will not be able to store a copy of the MyMyUNSW database as well as
the IMDB database under your Grieg server.
The solution: remove any existing databases before
loading your IMDB database.
</p>
<p>
If you're running PostgreSQL at home, the file
<a href="ass3.zip"><tt>ass3.zip</tt></a> contains
copies of the required files, but not the database,
to get you started.
You will need to download the
<a href="database/imdb.dump.bz2">database dump file</a>
separately.
If you copy <tt>ass3.zip</tt> and <tt>imdb.dump.bz2</tt>
to your home computer, unzip it,
and perform commands analogous to the above, you should have a
copy of the IMDB database that you can use at home to do this
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
imdb=# <b>select * from dbpop();</b>
</pre>
<p>
This will give you a list of tables and the number of tuples in each.
</p>

<h2>Your Tasks</h2>
<p>
Answer each of the following questions by writing a Python/Psycopg2
script.
You can add any SQL views or PLpgSQL functions that are used in your
Python scripts into the file <tt>xtras.sql</tt>
You can add any functions that you want to share among the Python
scripts into the file <tt>helpers.py</tt>.
If you want to use any other Python modules, make sure that they
are available on Grieg; your submitted code has to run on Grieg
using the Python installation there.
You can change the indentation from the two-space indent in the
templates.
</p>
<p>
Hint: use PostgreSQL's case-insensitive regular expression pattern
matching operator (<tt>~*</tt>) for matching partial names and titles.
If you do this, it has the added advantage that your command-line
arguments can be in any case you like, and you can even put regular
expression chars into them.
</p>
<p class="brown">
Some of the questions below require you to display crew roles.
In the database, these are stored as all lower-case with underscores
replacing spaces, e.g. "<tt>production_manager</tt>".
When these are displayed, the first letter should be capitalised
and each underscore should be replaced by a space character.
</p>


<h3>Q1 <span class='marks'>(3 marks)</span></h3>
<p>
Complete the script called "<tt>best</tt>" so that it prints
a list of the top <i>N</i> highest-rating movies (default <i>N</i> = 10).
The script takes a single command-line argument which specifies how
many movies should appear in the list.
Movies should be ordered from highest to lowest rating, and should
be displayed as, e.g.
</p>
<pre>
$ <b>./best 5</b>
9.8 Randhawa (2019)
9.6 Fan (2019)
9.6 Mama's Heart. Gongadze (2017)
9.5 Ananthu V/S Nusrath (2018)
9.5 Family of Thakurganj (2019)
</pre>
<p>
Within groups of movies with the same rating, movies should be ordered
by title.
<span class="brown">If the user supplies a number less than 1, print a usage
message and exit.</span>
For more examples of how the script behaves, see
<a href="examples.php">[Sample Outputs]</a>.
</p>


<h3>Q2 <span class='marks'>(4 marks)</span></h3>
<p>
Complete the script called "<tt>rels</tt>" so that it prints
a list of the different releases (different regions, different
languages) for a movie.
The script takes a single command-line argument which gives
a part of a movie name (could be the entire name).
If there are no movies matching the supplied partial-name,
then you should print a message to this effect and quit the
program, e.g.
</p>
<pre>
grieg$ ./rels xyzzy
No movie matching 'xyzzy'
</pre>
<p>
If the partial-name matches multiple movies, simply print a list
of matching movies, <span class="brown">ordered by year of release and
then by title</span>, e.g.
</p>
<pre>
grieg$ <b>./rels mothra</b>
Movies matching 'mothra'
===============
Mothra (1961)
Mothra vs. Godzilla (1964)
Godzilla and Mothra: The Battle for Earth (1992)
Godzilla, Mothra and King Ghidorah: Giant Monsters All-Out Attack (2001)
</pre>
<p>
If the partial name matches exactly one movie,
then print that movie's title and year,
and then print a list of all of the other releases (aliases)
of the movie.
<span class="brown">
If there are no aliases, print "<i>Title</i> (<i>Year</i>) has no alternative releases".
</span>
For each alias, show at least the title. If a region exists,
add this, and if a language is spcified, add it as well, e.g.
</p>
<pre>
grieg$ <b>./rels 2001</b>
2001: A Space Odyssey (1968) was also released as
'2001' (region: XWW, language: en)
'Two Thousand and One: A Space Odyssey' (region: US)
'2001: Odisea del espacio' (region: UY)
'2001: Een zwerftocht in de ruimte' (region: NL)
</pre>
<p>
Movie releases should be ordered accoring to the <tt>ordering</tt>
attribute in the <tt>Aliases</tt> table.
</p>
<p class="brown">
If an alias has no region or language, then put the string
in the <tt>extra_info</tt> field in the parentheses.
If it has neither region, language or extra info, just
print the local title.
</p>
<p>
Note that if there are two movies with exactly the same
original title, you will not be able to view their releases,
since the title alone does not distinguish them.
We consider this problem in the next question.
</p>
<p>
For more examples of how the script behaves, see
<a href="examples.php">[Sample Outputs]</a>.
</p>


<h3>Q3 <span class='marks'>(5 marks)</span></h3>
<p>
Complete the script called "<tt>minfo</tt>" so that it prints
a list of cast and crew for a movie.
The script takes a command-line argument which gives
a part of a movie name (could be the entire name).
It also takes an optional command-line argument, which
is a year and can be used to distinguish movies with
the same title (or, at least, titles which match the
partial movie name).
</p>
<pre>
grieg $ <b>./minfo</b>
Usage: minfo 'MovieTitlePattern' [Year]
</pre>
<p>
If there are no movies matching the supplied partial-name,
then you should print a message to this effect and quit the
program, e.g.
</p>
<pre>
grieg$ ./minfo xyzzy
No movie matching 'xyzzy'
</pre>
<p>
If the partial-name matches multiple movies, simply print a list
of matching movies, the same as in Q2.
If you need to disambiguate, either use a larger partial-name
or add a year to the command line.
If a longer partial-name and year still doesn't disambiguate,
print a list of matching movies as above.
</p>
<p>
If the command-line arguments identify a single movie, then print
the movie details (title and year), followed by a list of the
principal actors and their roles, followed by a list of the principal
crew members and their roles.
The list of actors should be sorted according to the <tt>ordering</tt>
attribute in the <tt>Principals</tt> table (i.e the biggest star
comes first) <span class="brown">and then by the name of the role
they played if the <tt>ordering</tt> attribute is equal
(i.e. one actor plays
multiple roles).</span>
The list of crew members should also be sorted according to the
<tt>ordering</tt> attribute in the <tt>Principals</tt> table
<span class="brown">and then by role name, if the <tt>ordering</tt>
attribute is the same (e.g. one person has multiple crew roles).</span>
</p>
<p>
For more examples of how the script behaves, see
<a href="examples.php">[Sample Outputs]</a>.
</p>

<h3>Q4 <span class='marks'>(6 marks)</span></h3>
<p>
Complete the script called "<tt>bio</tt>" so that it prints
a filmography for a given person (<tt>Name</tt>), showing
their roles in each of the movies they are associated with.
The script takes a command-line argument which gives
a part of a person's name (could be the entire name).
It also takes an optional command-line argument, which
is a year (their birth year) and which can be used to
distinguish people with similar names.
</p>
<pre>
grieg$ <b>./bio</b>
Usage: bio 'NamePattern' [Year]
</pre>
<p>
If the name pattern doesn't match anyone in the <tt>Names</tt>
table, then you should print a message to this effect and quit the
program, e.g.
</p>
<pre>
grieg$ <b>./bio Smmith</b>
No name matching 'Smmith'
</pre>
<p>
If the name pattern matches more than one person, then print
a list of the matching people, with the years they were born
and died in parentheses afer the name.
</p>
<pre>
grieg: ./bio rooney
Names matching 'rooney'
===============
Darrell Rooney (???)
Frank Rooney (1913-)
Jennie Rooney (???)
Mickey Rooney (1920-2014)
Nancy Rooney (???)
Rooney Mara (1985-)
Sharon Rooney (1988-)
</pre>
<p class="brown">
If two people have the same name and birth year, put them
in order of their <tt>Name.id</tt> value.
</p>
</p>
<p>
Note that some people do not have death years or birth years.
</p>
<p>
If the name pattern, optionally combined with a year, matches
a single person, then you should print their name and birth
and death years, followed by a list of all the films they have
been a principal in.
Films should be in chronological order; if there are multiple
films in a given year, order them by title within the year.
For each film, show first any acting roles they had, including
the role they played, and then any production crew roles they
had.
</p>
<p class="brown">
Note that one person could be both and actor and director in the
same movie.
If a person has multiple roles as an actor in one movie,
then show the records in order of the role name.
Similarly for multiple roles as a crew member; order by
role name.
<p>
<pre>
grieg$ <b>./bio 'spike lee'</b>
Filmography for Spike Lee (1957-)
===============
She's Gotta Have It (1986)
 playing Mars Blackmon     <span class="comment">-- acting role</span>
 as Director               <span class="comment">-- crew role</span>
 as Writer
School Daze (1988)
 as Director
 as Writer
Do the Right Thing (1989)
 as Director
 as Writer
Mo' Better Blues (1990)
 playing Giant
 as Director
 as Writer
... etc. etc. etc. ...
</pre>
<p>
For more examples of how the script behaves, see
<a href="examples.php">[Sample Outputs]</a>.
</p>

<h3>Style <span class='marks'>(2 marks)</span></h3>
<p>
Your programming style will be marked according to the following criteria
</p>
<ul>
<li> consistent indentation (somewhat forced by Python)
<li> meaningful variable/function names
<li> effective abstraction (use of functions)
<li> efficient use of the database
</ul>
<p>
There is a performance requirement in each of the tasks.
Any task that takes longer than 2 seconds on any of our test cases
will be penalised for that case, even if it eventually produces
the correct result.
</p>

<h3>Submission and Testing</h3>
<p>
We will test your submission as follows:
</p>
<ul>
<p><li>
create a testing subdirectory containing your <tt>xtras.sql</tt> and Python scripts
<p><li>
create a new database <span class="red"><tt>imdb</tt></span> and initialise it with <code>imdb.dump.bz2</code>
<p><li>
run the command: &nbsp; <code>psql <span class="red">imdb</span> -f xtras.sql</code> &nbsp; (using your <tt>xtras.sql</tt>)
<p><li>
load and run the tests in the <tt>check</tt> script
</ul>
</p>
<p>
Your submitted code must be <em>complete</em> so that when we do the
above, your <tt>xtras.sql</tt> will load without errors.
You should throgouhly test your scripts before you submit them.
If you Python or SQL scripts generate load-time errors and/or
have missing definitions,
you will be penalised by a 2 mark administrative penalty.
</p>
<p>
Before you submit, it would be useful to test out whether
the files you submit will work by following a similar
sequence of steps to those noted above.
</p>

<br>
<p>Have fun, <i>jas</i></p>

<?=endPage()?>
