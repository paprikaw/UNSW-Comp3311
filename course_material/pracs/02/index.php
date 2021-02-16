<? require("../../course.php"); $exID = "02";?>
<? $exWeb = WEBHOME."/pracs/$exID"; $exDir = HOMEDIR."/pracs/$exID";?>
<?=startPage("Prac Exercise $exID","","PostgreSQL: a client-server RDBMS")?>
<!--
<?=updateBlurb()?>
-->

<h3>Aims</h3>

This exercise aims to get you to:
<ul>
<li> install your PostgreSQL database server at CSE
<li> create, populate and examine a very small database
</ul>
<p>
You ought to get it done by end of Week 2,
since you'll need it for Assignment 1 (to be released in Week 3).
</p>

<h3>Background</h3>

<p>
PostgreSQL runs on most platforms, but the installation instructions
will be different for each one.
There are downloadable binaries for many platforms, but they place
restrictions on how your server is configured.
Other installations come with a GUI front-end; I think this moves you
too far away from the server, and simply gets in the way ... but
maybe thta's just me.
</p>
<p>
On Linux and MacOS, I have found it best to install from source code;
the installation is relatively straightforward and you can specify
precisely where on your filesystem you want the PostgreSQL files
to be located.
If you don't want to run PostgreSQL on your own machine, this Prac
Exercise describes how to set it up on your CSE account.
You can still work from home by accessing your server through VLab
or <tt>ssh</tt>.
</p>
<p>
If you <em>do</em> want to install PostgreSQL on your home machine,
you'll need to work out how to do that yourself.
There are plenty of online resources describing how to do this for
different operating systems (type "install postgresql" at Google).
It probably doesn't matter if you use a slightly different version
at home, since we'll be using a subset of SQL and PLpgSQL that
hasn't changed for a while; version 12.x is preferable, v11.x or
v10.x should be ok for the prac work. 
</p>
<p>
The practical work for the assignments can be carried out on the
CSE machines by running a PostgreSQL server for which you are
effectively the database administrator.
You must run this server on the host called <code>grieg</code>,
which has been configured to run large numbers* of PostgreSQL
servers
You should <i>not</i> use other login servers such as <tt>wagner</tt>
and <tt>weill</tt> for running PostgreSQL; if you do, your PostgreSQL
server will most likely be terminated automatically not long after
it starts.
</p>
<p>
*Note that "large numbers" is around 200. If you leave your
work to the last minute, and find 400 other students all trying
to run PostgreSQL on Grieg, performance will be sub-optimal.
Of course, you can avoid this potential bottleneck by
installing and running PostgrSQL on your home machine.
</p>
<div class="note">
Reminder:
You should <em>always</em> test your work on the CSE
machines before you submit assignments, since that's
where we'll be running our tests to award your marks.
</div>
<p>
What <tt>grieg</tt> provides is a large amount of storage and
compute power that is useful for students studying databases.
You should have access to <code>grieg</code> because you're
enrolled in COMP3311.
You should be able to <code>ssh</code> onto the <code>grieg</code>
server, and run the command <code>priv srvr</code> on
<code>grieg</code>.
If you can't do either of these, let us know. 
</p>
<p>
In the examples below, we have used the <code>$</code> sign to represent
the prompt from the command interpreter (shell). In fact, the prompt may
look quite
different on your machine (e.g., it may contain the name of the machine
you're using, or your username, or the current directory name).
All of the things that the computer types are in <code>this font</code>.
The commands that <b>you</b> are supposed to type are in
<code><b>this bold font</b></code>.
Some commands use <code>$USER</code> as a placeholder for your
CSE username.
</p>

<h3>Exercises</h3>

<h4>Stage 1: Getting to Grieg and making your <tt>/srvr/</tt> Directory</h4>

<p>
Log in to <tt>grieg.cse.unsw.edu.au</tt>. If you're not logged into
<code>grieg</code> nothing that follows will work.
</p>
<p>
You can log into <code>grieg</code> from a command-line (shell) window
on any CSE machine (including <tt>vlab</tt>) via the command:
</p>
<pre>
$ <b>ssh grieg</b>
</pre>
<p>
If you're doing this exercise from home, you can use any <code>ssh</code>
client, but you'll need to refer to <code>grieg</code> via its fully-qualified
name:
</p>
<pre>
$ <b>ssh CSEUsername@grieg.cse.unsw.edu.au</b>
</pre>
<p>
From home, an alternative is to use VLab. This requires a VNC client
(e.g. <a href="https://tigervnc.org/">TigerVNC</a>). Use the VNC server
</p>
<pre>
vlab.cse.unsw.edu.au:5920
</pre>
<p>
This will log you into one of CSE's <tt>vx<i>N</i></tt> servers.
Once you're there, create an Xterm and log in to <tt>grieg</tt> as above.
</p>
<p>
You can check whether you're actually logged in to <code>grieg</code>
by using the command:
</p>
<pre>
$ <b>hostname</b>
</pre>
<p>
Once you're logged into <code>grieg</code>, run the command:
</p>
<pre>
$ <b>priv srvr</b>
</pre>

<p>
You only need to do this once. It creates a new
directory (<code>/srvr/$USER/</code>) to hold
your PostgreSQL server files.
</p>
<p>
The <tt>/srvr/$USER/</tt> directory is initially empty,
but will eventually contain all of
the data files for your PostgreSQL server.
You can also place other COMP3311-related files under this directory.
Make sure, however, that any directories containing assignment work
are not accessible to other people.
</p>

<h4>Stage 2: Setting up your PostgreSQL Server</h4>

<p>
Once the <code>/srvr/$USER/</code> directory exists,
you are ready to set up your PostgreSQL server.
Change into the <code>/srvr/$USER/</code> directory
if you're not already there.
Then set up the PostgreSQL server by running the command:
</p>
<pre>
$ <b>~cs3311/bin/pginit</b>
</pre>
<p>
This command will create a subdirectory called <code>pgsql</code>
in your <code>/srvr/$USER/</code> directory, and also place
a file called <code>env</code> in the <code>/srvr/$USER/</code>
directory.
</p>
<div class="note">
The <code>pginit</code> script checks for every error that I could
think of, but I'm sure you'll find some others, so let me know if
you get any error messages when you run <code>pginit</code>. The
script <em>does</em> produce some messages from PostgreSQL when
it's creating things, but these are <em>not</em> errors.
Even the warnings are nothing to worry about (for this course).
</div>
<p>
The output from <code>pginit</code> should look something like:
</p>
<pre>
$ <b>~cs3311/bin/pginit</b>
Installing environment setup script ...
successful.

Each time you log in you need to set your enviornment by running:
   source /srvr/$USER/env
Note that you *must* use the full path name for this file.

Installing PostgreSQL data directories ...
The files belonging to this database system will be owned by user "$USER".
This user must also own the server process.
<span class="comment">...
a whole lot more stuff which you can ignore
as long as it doesn't have any ERRORs
...</span>
server stopped
PostgreSQL installed ok.
To start the server:
* log in to grieg
* source the '/srvr/$USER/env' file
* run the command 'pg start'
To stop the server:
* run the command 'pg stop'
</pre>
<p>
where, obviously, your login name will appear in place of
<code>$USER</code>.
</p>
<p>
You can ignore any WARNINGs which may appear in the <code>pginit</code>
output.  They have no effect on the usefulness
of your PostgreSQL server. In general, however, you should not ignore
WARNING messages and should never ignore ERROR messages from PostgreSQL.
</p>
<p>
You only need to run the <code>pginit</code> command <em>once</em>
(unless you need
to completely reinstall your PostgreSQL server from scratch).
</p>
<div class="note">
<p>
One place where PostgreSQL is less space efficient than it might be
is in the size of its transaction logs. These logs live in the directory
<code>pgsql/data/pg_wal</code> and are essential for the functioning of
your PostgreSQL server. If you remove any files from this directory,
you will render your server inoperable. Similarly, manually changing
the files under <code>pgsql/data/base</code> and its subdirectories will
probably break your PostgreSQL server.
</p>
<p>
If you mess up your PostgreSQL server badly enough, it will need to
be re-installed. If such a thing happens, all of your databases are
useless and all of the data in them is irretrievable. You will need
to completely remove the
<code>/srvr/$USER/pgsql</code> directory and re-install using
<code>pginit</code>.
</p>
<p>
If you need to remove the <code>pgsql</code> directory, then all of
your databases and any data in them are gone forever.
This is not a problem if you set up your databases by loading new
views, functions, data, etc. from a file, but if you type <code>create</code>
commands directly into the database, then the created objects will be
lost.
The best way to avoid such catastrophic loss of data is to type your
SQL <code>create</code> statements into a file and load them into the
database from there. Alternatively, you'd need to do regular
back-ups of your databases using the <code>pg_dump</code> command.
</p>
</div>
<p>
The <code>env</code> file that <code>pginit</code> places in your
<code>/srvr/$USER/</code> directory contains a bunch of
environment settings that need to be active before the servers
will work. Since these environment settings need to affect your
<code>grieg</code> login shell, you must <b>source</b> the <code>env</code>
file, not execute it. You could do this, once you're logged in to
<code>grieg</code>, via:
</p>
<pre>
$ <b>source /srvr/$USER/env</b>
</pre>
<p>
Remembering to do this each time you log in to <code>grieg</code>
is slightly annoying. You can simplify things so that the
environment gets set up automatically when you login to
<code>grieg</code>.
To do this, add the following at the end of your shell's login script,
which would be called something like
<code>.bashrc</code> or <code>.bash_profile</code> file or <code>.zshrc</code>,
etc.
</p>
<pre>
source /srvr/$USER/env
</pre>
<p>
If you don't modify your login script, then you will
need to run the above command manually each time you
login and want to use PostgreSQL.
</p>

<h4>Stage 3: Using your PostgreSQL Server</h4>

<p>
When you want to do some work with PostgreSQL: login to Grieg,
start your server, do your work, and then stop the server
before logging off Grieg.
</p>
<p>
<span class="red"><b>Do not leave your PostgreSQL server running
while you are not using it.</b></span>
</p>
<p>
The command for controlling your PostgreSQL
server is:
</p>
<pre>
$ <b>~cs3311/bin/pg</b>
</pre>
<p>
Once you've set up your environment properly, you should be able to
invoke this command simply by typing <code>pg</code>.
</p>
<p>
Each time you want to use your PostgreSQL server, you'll need to do
the following:
</p>
<pre>
$ <b>ssh grieg</b>                <i>log in to grieg</i>
<span class="comment">... starts a new login session on Grieg ... </span>
$ <b>source /srvr/$USER/env</code></b>     <i>set up your environment</i>
$ <b>pg start</b>                <i>start the PostgreSQL server</i>
</pre>
<p>
Remember to do all of the above each time you login to the CSE
machines to do some work with PostgreSQL.
</p>
<div class="note">
<p>
If you ever get an error message like this:
</p>
<pre>
$ <b>pg start</b>
-bash: pg: command not found
</pre>
<p>
then you probably haven't set up your shell <code>PATH</code> properly.
<p>
If you see the above, you need to <code>source</code> your <code>env</code>
file.
</p>
</div>
</center>
<p>
You can check whether your server is running via the command:
</p>
<pre>
$ <b>pg status</b>
</pre>
<p>
If you do have a server running, this command will give you output from
the Unix <code>ps</code> command showing the PostgreSQL processes that
you currently have running. There should be one process that looks like:
</p>
<pre>
bin/postgres
</pre>
<p>
and a couple of PostgreSQL <code>writer</code> processes.
If this does not show at least one <code>postgres</code> process,
then your PostgreSQL server is not running.
</p>
<p>
You can stop your server via the command:
</p>
<pre>
$ <b>pg stop</b>
</pre>
<p>
Try checking, stopping, and starting the server a few times.
</p>
<p>
Things occasionally go wrong, and knowing how to deal with them will save
you lots of time. There's a discussion of common problems at the end of
this document; make sure that you read and understand it.
</p>
<p>
Once your PostgreSQL server is running, you can access your PostgreSQL
databases via the <code>psql</code> command.
You normally invoke this command by specifying the name of a database,
e.g.
</p>
<pre>
$ <b>psql <i>MyDatabase</i></b>
</pre>
<p>
If you type <code>psql</code> command without any arguments, it assumes
that you are trying to access a database with the same name as your login
name. Since you probably won't have created such a database, you're likely
to get a message like:
</p>
<pre>
psql: FATAL:  database "<i>${USER}</i>" does not exist
</pre>
<p>
You will get a message like this any time that you try to access a
database that does not exist.
</p>
<p>
If you're not sure what databases you have created, <code>psql</code>
can tell you via the <code>-l</code> option
(that's lower-case 'L' not the digit '1' (one)), e.g.
</p>
<pre>
$ <b>psql -l</b>
</pre>
<p>
If you run this command now, you ought to see output that looks like:
</p>
<pre>
SET
                              List of databases
   Name    | Owner | Encoding |  Collate   |    Ctype    | Access privileges 
-----------+-------+----------+------------+-------------+-------------------
 postgres  | jas   | UTF8     | C          | en_AU.UTF-8 | 
 template0 | jas   | UTF8     | C          | en_AU.UTF-8 | =c/jas           +
           |       |          |            |             | jas=CTc/jas
 template1 | jas   | UTF8     | en_US.utf8 | en_US.utf8  | 
(3 rows)
</pre>
<p>
Of course, it will be <i>your</i> username, and not <tt>jas</tt>.
</p>
<p>
Note that PostgreSQL commands like <code>psql</code> and <tt>createdb</tt>
are a lot noisier than normal Linux commands.
In particular, they all seem to print <code>SET</code> when they
run; you can ignore this.
Similarly, if you see output like <nobr><code>INSERT 0 1</code></nobr>,
you can ignore that as well.
</p>
<p>
The above three databases are created for use by the PostgreSQL server;
you should not modify them.
At this stage, you don't need to worry about the contents of the other
columns in the output.
As long as you see at least three databases when you run the
<code>psql -l</code> command, it means that your PostgreSQL
server is up and running ok.
</p>
<p>
The way we have set up the PostgreSQL servers on <code>grieg</code>,
each student is the administrator for their own server.
This means that you can create as many databases as
you like (until you run out of disk quota), and make any other
changes that you want to the server configuration.
</p>
<p>
From within <code>psql</code>, the fact that you are an administrator
is indicated by a prompt that looks like
</p>
<pre>
<i>dbName</i>=#
</pre>
<p>
rather than the prompt for database users
</p>
<pre>
<i>dbName</i>=>
</pre>
<p>
which you may have seen in textbooks or notes.
</p>
<p>
Note that you can only access databases created as above
while you're logged into <code>grieg</code>.
In other words, you must run the <code>psql</code>
command on <code>grieg</code>.
</p>
<p>
Note that the <b>only</b> commands that you should run on
<code>grieg</code> are the <code>pg</code> command (to start and stop
the server), the <code>psql</code> command to start an interactive
session with a database, and the other PostgreSQL clients such as
<code>createdb</code>.
Do not run other processes such as web
browsers, drawing programs or editors on <code>grieg</code>. If you
do, <code>grieg</code> will eventually be overwhelmed and you'll
effectively be a contributor to a Denial of Service attack.
</p>
<p>
If you need to edit files while you're using your PostgreSQL server,
run another terminal window on the local machine (not Grieg), and do
the editing there. Note that you can access the files under
<code>/srvr/$USER/</code> from any CSE machine.
</p>
<p>
All of the PostgreSQL client applications are documented in the
<a target="_new" href="http://www.postgresql.org/docs/12/index.html">PostgreSQL manual</a>,
in the "PostgreSQL Client Applications" section.
While there are quite a few PostgreSQL client commands,
<code>psql</code> will be the one that you will mostly use.
</p>
<div class="note">
<p>
<b>Mini-Exercise:</b> a quick way to check whether your PostgreSQL server
is running is to try the command:
</p>
<pre>
$ <b>psql -l</b>
</pre>
<p>
Try this command now.
</p>
<p>
If you get a response like:
</p>
<pre>
psql: command not found
</pre>
<p>
then you haven't set up your environment properly; <code>source</code> the
<code>env</code> file.
</p>
<p>
If you get a response like:
</p>
<pre>
psql: could not connect to server: No such file or directory
        Is the server running locally and accepting
        connections on Unix domain socket "....s.PGSQL.5432"?
</pre>
then the server isn't running.
</p>
<p>
If you get a list of databases, like the example above, then this
means your server is running ok and ready for use.
</p>
</div>

<h4>Cleaning up</h4>

<p>
After you've finished a session with PostgreSQL,
it's essential that you shut your PostgreSQL server down
(to prevent overloading <code>grieg</code>).
You can do this via the command:
</p>
<pre>
$ <b>pg stop</b>
</pre>
<p>
which must be run on <code>grieg</code>.
</p>
<p>
PostgreSQL generates log files that can potentially
grow quite large. If you start your server using
<code>pg</code>, the log file is called
</p>
<pre>
/srvr/$USER/pgsql/Log
</pre>
<p>
It would be worth checking every so often to see how large
it has become.
To clean up the log, simply stop the server and remove the file.
Note: if you remove the logfile while the server is running, you
may not remove it at all; its link in the filesystem will be gone,
but the disk space will continue to be used and grow until the
server stops.
</p>
<div class="note">
<p>
<b>Mini-Exercise:</b>
Try starting and stopping the server a few times, and running
<code>psql</code> both when the server is running and when it's
not, just to see the kinds of messages you'll get.
</p>
</div>


<h4>Summary</h4>

<p>
A typical session with your virtual host and your
PostgreSQL server would be something like:
</p>
<pre>
... <i>on any CSE workstation</i> ...
$ <b>ssh grieg</b>
<span class="comment">... <i>grieg login stuff</i> ...</span>
<span class="comment">... <i>the following are all on grieg</i> ...</span>
$ <b>source /srvr/$USER/env</b>
$ <b>pg start</b>
$ <b>psql <i>MyDatabase</i></b>
... <i>use another xterm for editting</i> ...
$ <b>pg stop</b>
$ <b>logout</b>
<span class="comment">... <i>back to your original workstation</i> ...</span>
</pre>


<h4>Exercise #1: Making a database</h4>

<p>
Once the PostgreSQL server is running, try creating a database by
running the command:
</p>
<pre>
$ <b>createdb mydb</b>
</pre>
<p>
which will create the database, or give an error message if it
can't create it for some reason. (A typical reason for failure would be
that your PostgreSQL server is not running.)
<p>
Now use the <code>psql -l</code> command to check that the new database exists.
</p>
<p>
You can access the database by running the command:
</p>
<pre>
$ <b>psql mydb</b>
</pre>
<p>
which should give you a message like
</p>
<pre>
SET
psql (12.3 (Debian 12.3-1.pgdg80+1))
Type "help" for help.

mydb=# 
</pre>
<p>
Note that <code>psql</code> lets you execute two kinds of commands:
SQL queries and updates, and <code>psql</code> <q>meta</q>-commands.
The <code>psql</code> <q>meta</q>-commands allow you to examine the
database schema, and control various aspects of <code>psql</code>
itself, such as where it writes its output and how it formats tables.
</p>
<p>
Getting back to the <code>psql</code> session that you just started,
the <code>mydb</code> database is empty, so there's not much you can do
with it.
The <code>\d</code> (describe) command allows you to check what's in
the database.
If you type it now, you get the unsurprising response
</p>
<pre>
mydb=# <b>\d</b>
No relations found.
</pre>
<p>
About the only useful thing you can do at the moment
is to quit from <code>psql</code> via the <code>\q</code> command.
</p>
<pre>
mydb=# <b>\q</b>
$ ... <i>now waiting for you to type Linux commands</i> ...
</pre>
<p>
Note: it is common to forget which prompt you're looking at and sometimes
type Linux commands to <code>psql</code> or to type SQL queries to the
Linux shell. It usually becomes apparent fairly quickly
what you've done wrong, but can initially be confusing when you think that
the command/query is not behaving as it should.
Here are examples of making the above two mistakes:
</p>
<pre>
$ ... <i>Linux command interpreter</i> ...
$ <b>select * from table;</b>
-bash: syntax error near unexpected token `from'
$ <b>psql mydb</b>
... <i>change context to PostgreSQL</i> ...
mydb=# <b>ls -l</b>
mydb-# ... <i>PostgreSQL waits for you to complete what it thinks is an SQL query</i> ...
mydb-# <b>;</b>    ... <i>because semi-colon finishes and then executes an SQL query</i> ...
ERROR:  syntax error at or near "ls"
LINE 1: ls -l
        ^
mydb=# <b>\q</b>
$ ... <i>back to Linux command interpreter</i> ...
</pre>

<h4>Exercise #2: Populating a database</h4>

<p>
Once the <code>mydb</code> database exists, the following command
will create the schemas (tables) and populate them with tuples:
</p>
<pre>
$ <b>psql mydb -f <?=$exDir?>/mydb.sql</b>
</pre>
<p>
Note that this command produces quite a bit of output, telling you
what changes it's making to the database. The output should look like:
</p>
<pre>
SET
CREATE TABLE
INSERT 0 1
INSERT 0 1
INSERT 0 1
CREATE TABLE
INSERT 0 1
INSERT 0 1
INSERT 0 1
INSERT 0 1
INSERT 0 1
INSERT 0 1
CREATE TABLE
INSERT 0 1
INSERT 0 1
INSERT 0 1
CREATE TABLE
INSERT 0 1
INSERT 0 1
INSERT 0 1
INSERT 0 1
INSERT 0 1
INSERT 0 1
INSERT 0 1
INSERT 0 1
INSERT 0 1
</pre>
<p>
The lines containing <code>CREATE TABLE</code> are, obviously, related
to PostgreSQL creating new database tables (there are four of them).
The lines containing <code>INSERT</code> are related to PostgreSQL
 adding new tuples into those tables.
</p>
<p>
Clearly, if we were adding hundreds of tuples to the tables, the output
would be very long. You can get PostgreSQL to stop giving you the
<code>INSERT</code> messages by using the <code>-q</code> option to
the <code>psql</code> command.
</p>
<p>
PostgreSQL's output can be verbose during database loading. If you want
to ignore everything <em>except</em> error messages, you could use a
command like:
</p>
<pre>
$ <b>psql mydb -f <?=$exDir?>/mydb.sql 2>&1 | grep ERROR</b>
</pre>
<p>
If you don't understand the fine details of the above, take a look at the
documentation for the Linux/Unix shell.
</p>
<p>
The <code>-f</code> option to <code>psql</code> tells it to read its input
from a file, rather than from standard input (normally, the keyboard).
If you look in the <a href="mydb.sql"><code>mydb.sql</code></a> file, you'll find a mix of table
(relation) definitions and statements to insert tuples into the database.
We don't expect you to understand the contents of the file at this stage.
</p>
<p>
If you try to run the above command again, you will generate a heap of
error messages, because you're trying to insert the same collection of
tables and tuples into the database, when they've already been inserted.
</p>
<p>
Note that the tables and tuples are now permanently stored on disk.
If you switch your PostgreSQL server off, when you restart it
the contents of the <code>mydb</code> database will be available,
in whatever state you left them from the last time you used the database.
</p>


<h4>Exercise #3: Examining a database</h4>

<p>
One simple way to manipulate PostgreSQL databases
is to use the <code>psql</code> command (which is a "shell"
like the <tt>sqlite3</tt> command in the first prac exercise).
A useful way to start exploring a database is to find out what
tables it has. We saw before that you can do this with the
</code>\d</code> (describe) command. Let's try that on the
newly-populated <code>mydb</code> database.
</p>
<pre>
mydb=# <b>\d</b>
         List of relations
 Schema |   Name    | Type  | Owner 
--------+-----------+-------+-------
 public | courses   | table | $USER
 public | enrolment | table | $USER
 public | staff     | table | $USER
 public | students  | table | $USER
(4 rows)
</pre>
<p>
You can ignore the <code>Schema</code> column for the time being.
The <code>Name</code> column tells you the names of all tables
(relations) in the current database instance. The <code>Type</code>
column is obvious, and, you may think, unnecessary. It's there because
<code>\d</code> will list all objects in the database, not just tables;
it just happens that there are only tables in this simple database.
The <code>Owner</code> should be your username, for all tables.
</p>
<p>
One thing to notice is that the table names are all in lower-case,
whereas in the <a href="mydb.sql"><code>mydb.sql</code></a> file, they had an initial
upper-case letter.
The SQL standard says that case does not matter in unquoted identifiers
and so <code>Staff</code> and <code>staff</code> and <code>STAFF</code>
and even <code>StAfF</code> are all equivalent.
To deal with this, PostgreSQL simply maps <em>identifiers</em>
into all lower case internally. You can still use <code>Staff</code>
when you're typing in SQL commands; it will be mapped automatically
before use.
</p>
<div class="note">
<p>
There are, however, advantages to using all lower case whenever
you're dealing with <code>psql</code>. For one thing, it means
that you don't have to keep looking for the shift-key. More
importantly, <code>psql</code> provides table name and field name
completion (you type an initial part of a table name, then type
the TAB key, and <code>psql</code> completes the name for you if
it has sufficient context to determine this unambiguously),
but it only works when you type everything in lower case.
The <code>psql</code> interface has a number of other features
(e.g. history, command line editing) that make it very nice to
use.
</p>
</div>
<p> 
If you want to find out more details about an individual table,
you can use:
</p>
<pre>
mydb=# <b>\d Staff</b>
             Table "public.staff"
  Column  |         Type          | Modifiers 
----------+-----------------------+-----------
 userid   | character varying(10) | not null
 name     | character varying(30) | 
 position | character varying(20) | 
 phone    | integer               | 
Indexes:
    "staff_pkey" PRIMARY KEY, btree (userid)
Referenced by:
    TABLE "courses" CONSTRAINT "courses_lecturer_fkey" FOREIGN KEY (lecturer) REFERENCES staff(userid)
</pre>
<p>
As you can see, the complete name of the table is <code>public.staff</code>,
which includes the schema name. PostgreSQL has the notion of a <q>current
schema</q> (which is the schema called <code>public</code>, by default), and
you can abbreviate table names by omitting the current schema name, which is
what we normally do.
The types of each column look slightly different to what's in the
<code>mydb.sql</code> file; these are just PostgreSQL's internal
names for the standard SQL types in the schema file.
You can also see that the <code>userid</code> field is not allowed to be
null; this is because it's the primary key (as you can see from the index
description) and primary keys may not contain null values.
The index description also tells you that PostgreSQL has built a B-tree
index on the <code>userid</code> field.
</p>
<p>
The final line in the output tells you that one of the other tables in
the database (<code>Courses</code>) has a foreign key that refers to the
primary key of the <code>Staff</code> table, which you can easily see
by looking at the <a href="mydb.sql"><code>mydb.sql</code></a> file.
This is slightly useful for a small database, but becomes extremely
useful for larger databases with many tables.
</p>
<p>
The next thing we want to find out is what data is actually contained in
the tables.
This requires us to use the SQL query language, which you may not know
yet, so we'll briefly explain the SQL statements that we're using, as
we do them.
</p>
<p>
We could find out all the details of staff members as follows:
</p>
<pre>
mydb=# <b>select * from Staff;</b>
  userid  |     name      |    position     | phone 
----------+---------------+-----------------+-------
 jingling | Jingling Xue  | Professor       | 54889
 jas      | John Shepherd | Senior Lecturer | 56494
 andrewt  | Andrew Taylor | Senior Lecturer | 55525
(3 rows)
</pre>
<p>
The SQL statement says, more or less, <q>tell me everything (*)
about the contents of the <code>Staff</code> table</q>.
Each row in the output below the heading represents a tuple
in the table.
</p>
<p>
Note that the SQL statement ends with a semi-colon.
The meta-commands that we've seen previously didn't require this,
but SQL statements can be quite large, and so, to allow you to
type them over several lines, the system requires you to type a
semi-colon to mark the end of the SQL statement.
</p>
<p>
If you forget to put a semi-colon, the prompt changes subtly:
</p>
<pre>
mydb=# <b>select * from Staff</b>
mydb-# 
</pre>
<p>
This is PostgreSQL's way of telling you that you're in the middle
of an SQL statement and that you'll eventually need to type a semi-colon.
If you then simply type a semi-colon to the second prompt, the
SQL statement will execute as above.
</p>
<div class="note">
<b>Mini-Exercise</b>: find out the contents of the other tables.
<p>
Here are some other SQL statements for you to try out. You don't need
to understand their structure yet, but they'll give you an idea of
the kind of capabilities that the SQL language offers.
</p>
<ul>
<li> Which students are studying for a CS degree (3778)?
<pre>
select * from Students where degree=3778;
</pre>
<li> How many students are studying for a CS degree?
<pre>
select count(*) from Students where degree=3778;
</pre>
<li> Who are the professors?
<pre>
select * from Staff where position ilike '%professor%';
</pre>
<li> How many students are enrolled in each course?
<pre>
select course,count(*) from Enrolment group by course;
</pre>
<li> Which courses is Andrew Taylor teaching?
<pre>
select c.code, c.title
from   Courses c, Staff s
where  s.name='Andrew Taylor' and c.lecturer=s.userid;
</pre>
<p>or</p>
<pre>
select c.code, c.title
from   Courses c join Staff s on (c.lecturer=s.userid)
where  s.name='Andrew Taylor';
</ul>
<p>
The last query is laid out as we normally lay out more complex
SQL statements: with a keyword starting each line, and each
clause of the SQL statement starting on a separate line.
</p>
<p>
Try experimenting with variations of the above queries.
</p>
</div>


<h3>Sorting out Problems</h3>

<p>
It is very difficult to diagnose problems with software over email,
unless you give sufficient details about the problem.
An email that's as vague as <q>My PostgreSQL server isn't
working. What should I do?</q>, is basically useless.
Any email about problems with software should contain details of
</p>
<ul>
<li> what you were attempting to do
<li> precisely what commands you used
<li> exactly what output you got 
</ul>
<p>
One way to achieve this is to copy-and-paste the last few commands
and responses into your email.
</p>
<p>
Alternatively, you should come to a consultation where we can work
through the problem via screen sharing (which is usually very quick).
</p>

<h4>Can't shut server down?</h4>
<p>
When you use <code>pg stop</code> to shut down your PostgreSQL server,
you'll observe something like:
</p>
<pre>
$ <b>pg stop</b>
Using server in /srvr/$USER/pgsql
waiting for server to shut down....
</pre>
<p>
Dots will keep coming until the server is finally shut down, at which
point you will see:
</p>
<pre>
$ <b>pg stop</b>
Using server in /srvr/$USER/pgsql
waiting for server to shut down........ done
server stopped
</pre>
<p>
Sometimes, you'll end up waiting for a long time and the server still
doesn't shut down. This is typically because you have an <code>psql</code>
session running in some other window (the PostgreSQL server won't shut
down until all clients have disconnected from the server).
The way to fix this is to find the <code>psql</code> session and end it.
If you can find the window where it's running, simply use <code>\q</code>
to quit from <code>psql</code>.
If you can't find the window, or it's running from a different machine
(e.g. you're in the lab and find that you left a <code>psql</code> running
at home), then use <code>ps</code> to find the process id of the
<code>psql</code> session and stop it using the Linux <code>kill</code>
command.
</p>

<h4>Can't restart server?</h4>
<p>
Occasionally, you'll find that 
your PostgreSQL server was not shut down cleanly the last time you
used it and you cannot re-start it next time you try to use it.
We'll discuss how to solve that here ...
</p>
<p>
The typical symptoms of this problem are that you log in to
<code>grieg</code>, set up your environment, try to start
your PostgreSQL server and you get the message:
</p>
<pre>
PGDATA=/srvr/$USER/pgsql
pg_ctl: another server may be running; trying to start server anyway
server starting   <span class="comment">... this really means "I'm trying to start the server"</span>
!!!
The PostgreSQL server may not have started correctly.
First try the 'psql -l' command to see if it is actually working.
If it's not, then check at the end of the log file for more details.
The log file is called: /srvr/$USER/pgsql/Log
</pre>
<p>
When you go and check the log file, you'll probably find,
right at the end, something like:
</p>
<pre>
$ <b>tail -2 $PGDATA/Log</b>
FATAL:  lock file "postmaster.pid" already exists
HINT:  Is another postmaster (PID <i>NNNN</i>) running in data directory "/srvr/$USER/pgsql"?
</pre>
<p>
where <code><i>NNNN</i></code> is a number.
</p>
<p>
There are two possible causes for this: the server is already running,
or the server did not terminate properly after the last time you used it.
You can check whether the server is currently running by the command
<code>psql -l</code>. If that gives you a list of your databases, then
you simply forgot to shut the server down last time you used it and it's
ready for you to use again. If <code>psql -l</code> tells you that
there's no server running, then you'll need to do some cleaning up
before you can restart the server ...
</p>
<p>
When the PostgreSQL server is run, it keeps a record of the Unix process
that it's running as in a file called:
</p>
<pre>
$PGDATA/postmaster.pid
</pre>
<p>
Normally when your PostgreSQL server process terminates (e.g. via
<code>pg stop</code>), this file will be removed. If your PostgreSQL
server stops, and this file persists, then <code>pg</code> becomes
confused and thinks that there is still a PostgreSQL server running
even though there isn't.
</p>
The first step in cleaning up is to remove this file:
<pre>
$ <b>rm $PGDATA/postmaster.pid</b>
</pre>
<p>
You should also clean up the socket files used by the PostgreSQL
server. You can do this via the command:
</p>
<pre>
$ <b>rm $PGDATA/.s*</b>
</pre>
<p>
Once you've cleaned all of this up, then the <code>pg</code>
command ought to allow you to start your PostgreSQL server ok.
</p>
<br>
<p>
Happy PostgreSQL'ing, <i>jas</i>
