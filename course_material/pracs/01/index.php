<? require("../../course.php"); $exID = "01";?>
<? $exWeb = HOME."/pracs/$exID"; $exDir = HOMEDIR."/pracs/$exID";?>
<?=startPage("Prac Exercise $exID","","SQLite: a simple RDBMS")?>
<!--
<?=updateBlurb()?>
-->

<h3>Aims</h3>

<p>
This exercise aims to introduce you to:
</p>
<ul>
<li> the use of a database management system (DBMS)
<li> data models and SQL schemas
<li> SQL queries and DBMS meta-commands
</ul>
<p>
This exercise contains a lot of reading and deals with some concepts
that won't be covered until weeks 2 and 3 in lectures. We try to explain
all of the ideas informally, but we don't expect you to understand
everything here just yet. However, it is still worth doing the simple
exercises (even if just by copy-and-paste). You should probably return
to this prac several times over the next few weeks as we gradually
cover everything.
</p>

<h3>Background</h3>

<p>
Database Management Systems (DBMSs) are software systems that maintain
and provide access to <b><i>database instances</i></b> and their
<b><i>meta-data</i></b>.
So, what's a <i>database instance</i>?
A useful working definition might be a <q>collection of inter-related
data items</q>.
<i>Meta-data</i> is information that describes what the data items
represent (i.e. it's data about data).
In terms of these, a <b><i>database</i></b> would then be a pair (meta-data,
database-instance).
A DBMS allows you to describe the structure of a database by reading
and storing meta-data, and allows you to <q>populate</q> the database
by reading and storing data items that fit this structure.
</p>
<p>
In fact, there are several different <q>styles</q> of databases and
DBMSs.
In this course, we will be primarily concerned with one particular
style of database, <b><i>relational databases</i></b>, and their software
systems, <b><i>relational database management systems</i></b> (RDBMSs).
Relational databases are, in some senses, the <q>classical</q> style
of database, but they are also extremely popular, extremely useful
and have a simple, elegant theory which translates neatly to a
practical implementation (a characteristic which is, unfortunately,
rare in computer science).
</p>
<p>
But before we get too abstract, let's consider a concrete scenario... 
</p>
<p>
Imagine that we are movie buffs and want to build a system that's
better than <a target="_new" href="http://www.imdb.com/">IMDb: the Internet Movie
Database</a>.
What kind of information do we need to store? Some obvious ones are
movies and actors/actresses. What about others? Producers, directors,
crew, plot, popularity, genre, bloopers, etc. etc. The list could go
on almost endlessly,
so let's focus on just the following: movies, genres, directors, actors, and
information about the roles that actors play in movies.
</p>
<p>
The next question is: what kind of information do we want to store
about movies? Once again, there are some obvious things like the movie's
title and the year it was made. Storing the year would be useful to
distinguish two movies with the same title e.g. the original 1933 version
of <q>King Kong</q>, the 1976 version (think: Jessica Lange), and Peter
Jackson's 2005 version. It might also be useful to know what kind of
movie it is (i.e. its genre, e.g. Sci-Fi). In fact, some movies could
belong to several genres e.g. a Sci-Fi Horror movie (think <q>Alien</q>).
</p>
<p>
What information do we want to store about actors?
Clearly, their name, and perhaps their birthday and other biographical
information (which, like a movie's year, might help to distinguish two
actors with the same name). If we're going to treat actors and actresses
the same, we might not care about their gender ... but when it comes to
Oscars time, it's important to know who's the Best Actress and who's the
Best Actor, so we probably do need to represent the gender somehow.
For directors, we probably want similar information to actors (after all,
they're both people and, in fact, some actors (e.g. Clint Eastwood) go
on to become successful directors).
</p>
<p>
Information about roles played by actors in movies is different to data
objects like movies, actors and directors, because it involves a
relationship between a movie and an actor. That is, an actors plays a
particular role in the context of some movie. Note that they may play more
than one role in a given movie, or might play the same role in several
movies.
Another similar example is describing the director of a movie; this is a
relationship between the movie and the person who directed it. If we assume
that each movie has only one director, then this relationship is actually
simpler than that between actors, movies and roles.
<p>
Let's put all of this together into some kind of data structure.
If we were to code the database in C, our meta-data might look
something like:
</p>
<pre>
typedef struct Movie {
	char *title;     // e.g. "Avatar"
	int   yearMade;  // sometime after 1850
	char *genre;     // what kind of movie is it
} Movie;

typedef struct Actor {
	char *name;      // e.g. "Clint Eastwood"
	int   yearBorn;  // sometime after 1850
	char  gender;    // i.e. 'm' or 'f'
} Actor;

typedef struct Director {
	char *name       // e.g. "Steve Spielberg" or "Clint Eastwood"
	int   yearBorn;  // sometime after 1850
} Director;
</pre>
<p>
Note that have a gender for actors, but not for directors. Since there
are not separate awards for male and female directors, the gender is
not an issue in this context. (Although, if there were Best Director and
Best Directoress awards, James Cameron would have rightfully gotten a Best
Director award for <q>Avatar</q> :-)
</p>
<p>
The above doesn't deal with the relationships between actors and movies
and directors and movies.
If we consider the director/movie case, the relationship could potentially
be implemented via:
</p>
<pre>
typedef struct Movie {
	char *title;     // e.g. "Avatar"
	int   yearMade;  // sometime after 1850
	char *director;  // e.g. "James Cameron"
} Movie;
</pre>
<p>
This works ok as long as each movie has only one director <em>and</em>
all directors have different names.
Ignoring multiple-director movies for the time being, here is an
alternative which ensures that the movie is connected to exactly
the right director:
</p>
<pre>
typedef struct Movie {
	char *title;        // e.g. "Avatar"
	int   yearMade;     // sometime after 1850
	char *genre;        // what kind of movie is it
	Director *director; // e.g. ref to "James Cameron"
} Movie;
</pre>
<p>
For the relationship describing an actor's role in a movie, we have
a bigger challenge.
Since an actor can have many roles in many movies, we need a data
structure to represent multiple relationships.
The following structure might work:
</p>
<pre>
typedef struct Role {
	Movie *movie;  // e.g. ref to "Wall Street"
	char  *role;   // e.g. "Gordon Gekko"
	struct Role *next;
} Role;

typedef struct Actor {
	char *name;      // e.g. "Clint Eastwood"
	int   yearBorn;  // sometime after 1850
	char gender;     // i.e. 'm' or 'f'
	Role *roles;     // linked list of Roles
} Actor;
</pre>
<p>
An alternative structure would be to put a linked list of (actor,role) pairs
into each <tt>Movie</tt> struct.
We have a similar issue if we want to allow a movie to be classified under
several genres. We <i>could</i> implement this via a comma-separated string
(e.g. <tt>"Sci-Fi,Horror"</tt>), but a more typical approach would be to
have a linked list of genres for each movie:
</p>
<pre>
typedef struct Genre {
	char *name;
	struct Genre *next;
} Genre;

typedef struct Movie {
	char *title;        // e.g. "Avatar"
	int   yearMade;     // sometime after 1850
	Genre *genre;       // linked list of Genres
	Director *director; // e.g. ref to "James Cameron"
} Movie;
</pre>
<p>
If we wanted to allow the multiple-director case, that could be handled
in a manner similar to genres, via a linked list of directors.
</p>
<p>
An important point to note is that, in this model, movies, actors and
directors can be uniquely identified by using a pointer to a struct for that object.
We don't need to use the year of their creation to disambuiguate objects
with the same name.
</p>
<p>
Of course, the above discussion has nothing directly to do with relational
databases, but it does raise some issues that they need to deal with, and
we consider those now as we develop a relational data model for the above
scenario.
</p>
<p>
We have suggested that a first step in developing relational schemas
is to develop an ER design for the scenario, and then map that to a
relational schema. The following ER diagram would represent the scenario
that we have described above in C:
</p>
<center><img src="Pics/er-schema.png"></center>
<p>
The rest of the discussion assumes that we work from the above
diagram to produce a relational schema expressed in SQL DDL.
<p>
First, though, recall that relational databases have only two
simple structuring mechanisms: relations and tuples.
A <b><i>relation</i></b> is a set of <b><i>tuples</i></b>, where each tuple
contains a set of values related to a single object or relationship.
A tuple is somewhat similar to a C struct in that it has a collection
of heterogeneous data values, where each value has a name and a type.
The elements of a tuple are called <b><i>fields</i></b>.
Relations can be conveniently thought of as tables, where each row of
the table is a tuple, and each column contains the values for one
field.
</p>
<div class="note">
Don't be confused by the two terms <i>relation</i> and <i>relationship</i>.
They may sound similar, but they are not the same thing. A <i>relation</i>
is as we defined it above: a set of tuples. A <i>relationship</i>
represents an association between two objects e.g. John <i>works at</i> UNSW,
you <i>are enrolled in</i> COMP3311. Now that that's clear, we'll muddy
the waters again by pointing out that relations are often used to
<em>represent</em> relationships ... but more on that below.
</div>
<p>
In the above example, some obvious potential relations are Movies,
Actors, Directors. If we consider the fields for these relations,
we could come up with a description like:
</p>
<pre>
Movies(title, yearMade, director)
Actors(name, yearBorn, gender)
Directors(name, yearBorn)
</pre>
<p>
Note that one of the fields <tt>director</tt> in the <tt>Movies</tt>
relation is actually representing the relationship <q>director <i>directed</i>
Movie</q>.
The other relationships, between actors and movies, cannot be represented
in the relational model in the same way as they are in the C struct above,
because the relational model has no equivalent to an array or linked list.
Since all it has are relations and tuples, we end up introducing new
relations to represent the relationships.
And if we want to allow the more reaslistic possibility of a movie being
directed by several people, we have a similar issue with the relationship
between movies and directors.
</p>
<p>
The above considerations lead to the following data model:
</p>
<pre>
<span class="comment">// relations representing "objects"</span>
Movies(title, yearMade)
Actors(name, yearBorn, gender)
Directors(name, yearBorn)
<span class="comment">// relations representing relationships</span>
BelongsTo(movie, genre)
AppearsIn(actor, movie, role)
Directs(director, movie)
</pre>
<p>
We can now completely represent all of the different objects and relationships
in our scenario.
However, we're still not quite done, because the fields like <tt>actor</tt>
in the <tt>AppearsIn</tt> relation (which we will denote from now on as
<tt>AppearsIn.actor</tt>) requires that we specify a particular actor, but
simply giving the name may not do this if their are two actors with the
same name. Similar considerations apply to <tt>AppearsIn.movie</tt>,
<tt>Directs.director</tt>, <tt>Directs.movie</tt> and <tt>BelongsTo.movie</tt>.
</p>
<p>
The above essentially tells us that the implicit assumption that
we made when defining keys (that names could unqiuely identify
moves and people) was inadequate.
This issue arises because relational databases do not have pointers or
object IDs, and so a value-based mechanism is used to
establish the identity of objects. In RDBMSs, we can either use a subset
of the data values, or introduce a new field to contain an ID for the
tuple which uniquely identifes that tuple within the table. Examples of
this approach are common e.g. your student number, your tax file number,
etc.
If we call all the ID fields in the different tables <tt>id</tt>, just
to simplify things, we end up with a data model like:
</p>
<pre>
<span class="comment">// relations representing "objects"</span>
Movies(id, title, yearMade)
Actors(id, name, yearBorn, gender)
Directors(id, name, yearBorn)
<span class="comment">// relations representing relationships</span>
BelongsTo(movieID, genre)
AppearsIn(actorID, movieID, role)
Directs(directorID, movieID)
</pre>
<p>
Once we can uniquely identify objects via an ID, the <tt>yearMade</tt>
and <tt>yearBorn</tt> fields become less critical. We will now make the
somewhat arbitrary decision to drop the <tt>Actors.yearBorn</tt> and
<tt>Directors.yearBorn</tt> fields (maybe we're not interested in any
biographical information), but to keep the <tt>Movies.yearMade</tt> field
(because it's useful to distinguish <q>King Kong (1933)</q> from
<q>King Kong (2005)</q> when talking about movies).
This leads to the following refinement of our data model:
</p>
<pre>
<span class="comment">// relations representing "objects"</span>
Movies(id, title, yearMade)
Actors(id, name, gender)
Directors(id, name)
<span class="comment">// relations representing relationships</span>
BelongsTo(movieID, genre)
AppearsIn(actorID, movieID, role)
Directs(directorID, movieID)
</pre>
<p>
One final refinement to the model is also based on user interface
considerations. If we ever need to present a list of people's names,
it's useful to do it in alphabetical order on their family name.
Unless the name is written as <tt>"Spielberg, Steve"</tt>, sorting
based on family name is tricky to achieve, so we decide to break
the names into two components:
</p>
<pre>
<span class="comment">// relations representing "objects"</span>
Movies(id, title, yearMade)
Actors(id, familyName, givenName, gender)
Directors(id, familyName, givenName)
<span class="comment">// relations representing relationships</span>
BelongsTo(movieID, genre)
AppearsIn(actorID, movieID, role)
Directs(directorID, movieID)
</pre>
<p>
The above data model is still somewhat abstract, but we can envisage
tuples such as the following appearing in the database instance.
</p>
<pre>
Movies(61,"Intolerable Cruelty",2003)
Actor(2999,"Zeta-Jones","Catherine","f")
AppearsIn(2999,61,"Marylin")
</pre>
<p>
Before we can use this data model, we need to render it in a language
that an RDBMS can understand. This requires us to make some concrete
decisions about the precise types of the fields, and which combinations
of fields are unique over all tuples in each relation.
The <b><i>SQL</i></b> language is best known as a query language, but
the SQL standard also defines a data definition language to allow us
to describe data models for RDBMSs.
SQL data models are typically called <b><i>schemas</i></b> (or
<i>schemata</i> by linguistic pedants).
We present an SQL implementation (schema) of the above data model, and then explain
the bits that do not appear in abstract data model above.
</p>
<pre>
create table Movies (
	id          integer,
	title       varchar(256),
	year        integer check (year &gt;= 1900),
	primary key (id)
);

create table BelongsTo (
	movie       integer references Movies(id),
	genre       varchar(32),
	primary key (movie,genre)
);

create table Actors (
	id          integer,
	familyName  varchar(64),
	givenNames  varchar(64),
	gender      char(1),
	primary key (id)
);

create table AppearsIn (
	actor       integer references Actors(id),
	movie       integer references Movies(id),
	role        varchar(64),
	primary key (movie,actor,role)
);

create table Directors (
	id          integer,
	familyName  varchar(64),
	givenNames  varchar(64),
	primary key (id)
);

create table Directs (
	director    integer references Directors(id),
	movie       integer references Movies(id),
	primary key (director,movie)
);
</pre>
<p>
A copy of this schema is available in the file
</p>
<pre>
<a href="<?="$exWeb/schema.sql"?>"><?="$exDir/schema.sql"?></a>
</pre>
<p>
The first thing to note is that the  relations and fields have almost
exactly the same names as in our abstract data model, except that we've
dropped the <tt>ID</tt> from names like <tt>movieID</tt>.
We introduce a new relation via the <tt>create table</tt> statement,
which requires us to provide a name for the relation and then give
the details of all of its fields. We can also specify which combination
of fields is unique within the table via the <tt>primary key</tt>
statement.
</p>
<p>
One clear difference with abstract relational model is that we need
to specify types for each field.
Note also that types can be specified more precisely than in C,
where we can only state in the <tt>struct</tt> definition that the
<tt>yearMade</tt> field is an integer value (although you should note
that we changed the name of the field from <tt>yearMade</tt> to
<tt>year</tt>).
The <tt>check</tt> in SQL enforces that the <tt>yearMade</tt> value
(actually <tt>year</tt>)
is not only an integer, but it must be greater than 1899 (assuming
that no movies were made before 1900).
</p>
<p>
String data types are different in SQL than they are in C. There
are actually two different kinds of string: fixed-length (<tt>char</tt>)
and variable-length (<tt>varchar</tt>). In both cases, we need to
specify a maximum string length. Any <tt>char</tt> values that are
shorter than the maximum length are blank padded to be exactly the
specific length. Any <tt>varchar</tt> values that are shorter than
the specified length are stroed in the DBMS exactly as written.
Another important difference between C strings and SQL strings,
is that SQL strings are written in single quotes (e.g. <tt>'a string'</tt>)
and do not support C's escape characters (e.g. <tt>\n</tt>).
</p>
<p>
One final point of explanation on the schema ... a line such as
</p>
<pre>
movie       integer references Movies(id),
</pre>
<p>
tells the DBMS that there is a field called <tt>movie</tt> which contains
an integer value. However, it cannot be just any old integer value; it
must contain an integer that occurs in the <tt>id</tt> field of a tuple
in the <tt>Movies</tt> table. Hopefully, it's reasonably clear that
this is how we <q>link</q> tuples together.
</q>
<p>
We could load the above schema into an RDBMS, and it would give us a
collection of empty tables. In order to do fun and useful things, we
need some data. There is a large file containing SQL statements to
add tuples to the tables in this database:
</p>
<pre>
<a href="<?="$exWeb/data.sql"?>"><?="$exDir/data.sql"?></a>
</pre>
<p>
You can look at this if you want, but a more interesting way to
interact with the data is via an RDBMS. In this prac, we are going
to use the <a href="http://www.sqlite.org/">SQLite</a> DBMS.
Like most DBMSs it stores both meta-data and database instances.
It also provides the SQL query language for looking at the data.
And, like other DBMSs, it provides a set of meta-commands for
doing things like reading SQL from files, looking at the meta-data,
and so on.
</p>
<p>
Unlike other databases, however, SQLite is not a client-server
systems.
This means that, unlike larger DBMSs like PostgreSQL, we don't need
to go to all the trouble of setting up and running a server before
we can start playing with the data.
</p>
<p>
For the remainder of this prac exercise, we will largely
be playing with an SQLite instance of the movies database described
above.
</p>

<h3>Exercise</h3>

<p>
If you're logged in to a CSE workstation, you can start an SQLite
interactive shell to work on our database via the command:
</p>
<pre>
$ <b>sqlite3 <?="$exDir/movies.db"?></b>
</pre>
<p>
This should produce a response something like:
</p>
<pre>
SQLite version 3.27.2 2019-02-25 16:06:06
Enter ".help" for usage hints.
sqlite>
</pre>
<p>
The specific vesion of SQLite may be different depending on which machine
you happen to be using, but as long as it is version <tt>3.*</tt>
the examples below should work.
</p>
<div class="note">
In the sample interactions in these prac exericses, we show anything that you
are supposed to type in <b><tt>bold font</tt></b>. Anything that the
computer is going to type at you will be in <tt>normal font</tt>.
The Linux shell prompt is denoted by a <tt>$</tt>.
</div>
<p>
Note that you can't read the <tt>movies.db</tt> file using the <tt>cat</tt>
command or by using a text editor, because it contains binary
data representing the structures of the database, along with some text data
representing the stored values.
You normally interact with such files using the <tt>sqlite3</tt> command.
The Linux <tt>file</tt> command will tell you what kind of file it is:
</p>
<pre>
$ <b>file <?="$exDir/movies.db"?></b>
movies.db: SQLite 3.x database ...
</pre>
<p>
Returning to the SQLite command that you just ran, the <tt>sqlite&gt;</tt>
is SQLite's prompt. In response to this prompt, you can type either SQL
statements or SQLite meta-commands. To find out what meta-commands are
available type:
</p>
<pre>
sqlite> <b>.help</b>
.archive ...             Manage SQL archives
.auth ON|OFF             Show authorizer callbacks
.backup ?DB? FILE        Backup DB (default "main") to FILE
.bail on|off             Stop after hitting an error.  Default OFF
<span class="comment">etc. etc. etc.</span>
.tables ?TABLE?          List names of tables matching LIKE pattern TABLE
.testcase NAME           Begin redirecting output to 'testcase-out.txt'
.timeout MS              Try opening locked tables for MS milliseconds
.timer on|off            Turn SQL timer on or off
.trace ?OPTIONS?         Output each SQL statement as it is run
.vfsinfo ?AUX?           Information about the top-level VFS
.vfslist                 List all available VFSes
.vfsname ?AUX?           Print the name of the VFS stack
.width NUM1 NUM2 ...     Set column widths for "column" mode
sqlite> 
</pre>
<p>
Note that all of the meta-commands begin with a period (<tt>'.'</tt>) character.
The most useful meta-command at this stage is <tt>.quit</tt>, which allows
us to escape from SQlite:
</p>
<pre>
sqlite> <b>.quit</b>
$ 
</pre>
<p>
Now, restart SQLite and try this command:
</p>
<pre>
sqlite> <b>.schema</b>
</pre>
<p>
SQLite will give you a list of tables in the database. This list should
match the list above, although the tables may not be in the same order
as in the schema above. Another difference is that the <tt>create table</tt>
is capitalized. The two words <tt>create</tt> and <tt>table</tt> are SQL
keywords and SQL keywords are case-insensitive. Unquoted identifiers in SQL
are also case insensitive, so we could write the name of the <tt>Movies</tt>
table as <tt>movies</tt> or even as <tt>MoViEs</tt>. If you insist on
making identifiers case-sensitive or if you want to use keywords (e.g.
"<tt>table</tt>") as identifiers, you need to enclose them in double-quotes.
</p>
<p>
Now let's try some data analysis. We know that there's a table called
<tt>Directors</tt> in the database, but what directors do we actually
know about? We can find out their names via the SQL statement:
</p>
<pre>
sqlite> <b>select givenNames,familyName from Directors;</b>
James|Cameron
Lars|von Trier
Chan-wook|Park
Steven|Spielberg
David|Lynch
Joel|Coen
sqlite> 
</pre>
<p>
The above SQL statement asks SQLite to show you the two name fields
from every tuple in the <tt>Directors</tt> table. The names look
a bit strange because SQLite displays the field values in each tuple
separated by a bar/pipe (<tt>'|'</tt>) character.
If we wanted to make the names look more <q>normal</q>, we could
use SQL's string concatentation operator (<tt>||</tt>) to join the
two name components together, separated by a space:
</p>
<pre>
sqlite> <b>select givenNames||' '||familyName from Directors;</b>
James Cameron
Lars von Trier
Chan-wook Park
Steven Spielberg
David Lynch
Joel Coen
sqlite> 
</pre>
<p>
Remember that one reason we split the names was so that we could sort
them alphabetically on family name, so let's do that:
</p>
<pre>
sqlite> <b>select givenNames||' '||familyName from Directors order by familyName;</b>
James Cameron
Joel Coen
David Lynch
Chan-wook Park
Steven Spielberg
Lars von Trier
sqlite> 
</pre>
<p>
Now let's consider the entire contents of the <tt>Movies</tt> table.
In SQL, we can ask for all fields in each tuple to be displayed by using
a <tt>*</tt> instead of a list of field names, as in:
</p>
<pre>
sqlite> select * from Directors;
1|Cameron|James
2|von Trier|Lars
3|Park|Chan-wook
4|Spielberg|Steven
5|Lynch|David
6|Coen|Joel
</pre>
<p>
Each tuple now has all three fields displayed, the ID, the family name and
the given names.
Note that all of the ID values are distinct, so that a given ID identifies
one specific director.
</p>
<p>
As well as giving information about individual tuples, SQL can also compute
summary data on tables.
For example, if I was too lazy to count that there were six directors from
the above output, I could get SQL to tell me:
</p>
<pre>
sqlite> <b>select count(*) from Directors;</b>
6
</pre>
<p>
Before getting you to play around with some queries, a couple of other
comments on the SQLite interactive interface are needed.
You no doubt noticed that each of the SQL statements above ends with a
semi-colon. Because SQL statements can extend over multiple lines, you
need some way of indicating "Ok, this SQL statement is finished. Please
execute it for me." That's what a semi-colon does.
</p>
<p>
If you end a line without a semi-colon, SQLite assumes that you have more
to type for the current SQL statement and changes the prompt to
<q><tt>...></tt></q>. For example:
</p>
<pre>
sqlite> <b>select</b>
   ...> <b>count(*)</b>
   ...> <b>from Directors;</b>
6
</pre>
<p>
This behaviour can be important if you get halfway through an SQL statement
and then decide that you want to quit. SQLite will ignore meta-commands until
you finish off the SQL statement with a semi-colon:
</p>
<pre>
sqlite> <b>select count(*)</b>
   ...> <b>from</b>
   ...> <b>.quit</b>
   ...> <b>.quit</b>
   ...> <b>;</b>
Error: near ".": syntax error
sqlite> <b>.quit</b>
$ 
</pre>
<p>
Armed with above information, try to think of SQL queries to answer
the following data retrieval problems:
</p>
<ol>
<li><p>
How many movies are in the database?
</p></li>
<li><p>
What are the titles of all movies in the database?
</p></li>
<li><p>
What is the earliest year that film was made (in this database)? <small>(Hint: there is a <tt>min()</tt> summary function)</small>
</p></li>
<li><p>
How many actors are there (in this database)?
</p></li>
<li><p>
Are there any actors whose family name is <q>Zeta-Jones</q>? <small>(case-sensitive)</small>
</p></li>
<li><p>
What genres are there?
</p></li>
<li><p>
What movies did Spielberg direct? (title+year)
</p></li>
<p><li>
Which actor has acted in all movies (in this database)?
</p></li>
<p><li>
Are there any directors in the database who don't direct any movies?
</p></li>
</ol>
<p>
Note that we don't expect you to be able to answer all of these at this stage
(week 1). However, by week 4 you should be able to answer most of them.
</p>
<p>
Note: If you <em>can</em> solve all of the above, then you ought to consider
applying for exemption from this course.
</p>
<p>
If you <em>have</em> tried to answer the above, then you can check
your answers against the <a href="soln.sql">sample solutions</a>.

</body>
</html>
