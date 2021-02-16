<?php require("../../course.php"); ?>
<?=startPage("Assignment 1","","Mapping ER Designs to SQL")?>
<?=updateBlurb()?>
</div>

<h3>Aims</h3>
<p>
The aims of this assignment are to:
</p>
<ul>
<li> read and understand an ER data model
<li> translate the ER model to an SQL schema
</ul>

<h2>Admin</h2>
<table cellpadding="6">
<tr valign="top">
<td><b>Submission:</b></td>
<td>use the command &nbsp; <tt>give cs3311 ass1 schema.sql</tt> &nbsp; or use Webcms3
</tr>
<tr valign="top">
<td><b>Deadline:</b></td>
<td><font color="red"><b>Sunday 11th October 23:59</b></font>
</tr>
<tr valign="top">
<td><b>Marks:</b></td>
<td>contributes 12% of the final mark</td>
</tr>
<tr valign="top">
<td><b>Late&nbsp;Penalty:</b></td>
<td>
Late submissions will have marks deducted from the maximum achievable mark at the rate of 0.08 marks <em>per hour</em> that they are late (i.e., around 2 marks per day).
</td>
</p></tr>
</table>

<h3>Description</h3>

<h3>Assessment</h3>
<p>
The aim of this assignment is to take a given ER design and convert it
to a database schema expressed in the SQL data definition language.
In some sense, this comes in part-way through the database development
process; you would nomally start with requirements and develop an ER model
and then convert it to SQL. We have done the first bit for you.
</p>
<p>
This assignment is worth a total of <b>12 marks</b>.
You will be assessed automatically (with scope for manual override)
according to how completely and accurately your SQL schema translates
the ER design.
Part of "accuracy" involves following the naming conventions we give
below (under <b>Your Task</b>).
Please try to restrain your boundless creativity and use the
naming scheme that we suggest.
There are other rules for the translation in <b>Your Task</b> apart
from  naming; please follow these as well.
</p>

<h3>The Problem Domain</h3>
<p>
Online calendars are now essential for managing activities in most
organisations.
UNSW uses Outlook to provide a global calendar system; other
online calendars include Google Calendar and Apple's Calendar.
For example, here is my Google calendar for one week:
</p>
<center>
<img border="1" src="Pics/cal1.png" alt="Google Calendar">
</center>
<p>
You can see in the above example that the calendar contains
various kinds of events; some are one-offs (e.g. CSE Seminar)
while others are repeating (e.g. COMP3311 Online Sessions
(despite the time for the Wednesday session being incorrect))
Events are also coloured, because they are drawn from different
calendar sources and merged into this single view.
</p>
<p>
Most calendar apps provide a similar set of functionalities.
For example, the following Outlook calendar shows a different
mix of repeating and one-off events:
</p>
<center>
<img border="1" src="Pics/cal2.png" alt="Outlook Calendar">
</center>
<p>
Since a real calendar app would have a significant amout of
complexity, we have distilled the requirement for our app
down to a minimum useful set.
</p>

<h3>Requirements</h3>
<p>
<p>
The first thing we need to do in database development is to
analyse the requirements and build a data model based on them.
The following set of requirements focusses on the entities in
the system.
Operational issues are mentioned, but only to inform
thinking on what data might need to be stored in the back-end
of a calendar app:
<dl>
<dt class="item">Users</dt>
<dd> <ul>
<li> individuals who use the calendar
<li> we need to know at least their name and email address
<li> they also have a non-empty password for authentication
<li> some (very few) users have administration privileges <br>
	<small>(we don't need to specify what these privileges are in the data model)</small>
</ul> </dd>
<dt class="item">Groups</dt>
<dd> <ul>
<li> named collections of individual users
<li> useful as shorthand for scheduling events for specific groups
<li> each group is owned by a user, who maintains the list of members
</ul> </dd>
<dt class="item">Calendars</dt>
<dd> <ul>
<li> named collections of events (e.g. "John's Weekly Meetings/Classes")
<li> each event is attached to a specific calendar
<li> each calendar has accessibility restrictions (per user and default) <br>
	<small>(e.g. some users have read/write, some have read-only,
		some have no access)</small>
<li> if a user has read permission on a calendar, they see private event titles instead of "Busy"
<li> each calendar is owned by a user; a user may own many calendars;
<li> users may subscribe to other peoples' calendars (if they can read them)
<li> each calendar has a colour (set by its owner); a subscriber may set a different colour for their own view
</ul> </dd>
<dt class="item">Events</dt>
<dd> <ul>
<li> there are various kinds of events
<ul>
<li> associated with a particular day/date (e.g. birthday)
<li> scheduled at a given time on a given day (e.g. a meeting)
<li> recurring on a regular basis (e.g. a COMP3311 lecture)
</ul>
<li> each event is owned by the individual user who creates it
<li> each event has a title and visibility (public, private)
<ul>
<li> a private event is shown simply as "Busy" in the interface
</ul>
<li> an event may be associated with a location (where it will occur)
<li> an event may be associated with a set of individual users (invitees)
<li> an event may recur in a number of ways
<ul>
<li> on a particular day of the week (Mon,Tue,Wed,Thu,Fri,Sat,Sun)
<li> weekly, every 2/3/4 weeks
<li> monthly (on same date of month), every 2/3/.../11 months
<li> on the first/second/third/last Xday of each month
<li> for a fixed number of times (e.g. 10 times)
<li> annually
</ul>
<li> a recurring event will have a starting date and may have an ending date
<li> at specified times before each event an alarm event can be triggered
<li> there may be multiple alarms associated with an event <br>
	<small>(e.g. 15 mins before, 5 mins before, 1 minute before)</small>
<li> an event can have an associated list of users who are invited <br>
	<small>(we don't associate events with groups; groups are used to generate a list of invited users whne the event is created)</small>
<ul>
<li> users on the list can be flagged as "Invited", "Accepted", or "Declined"
</ul>
</ul> </dd>
</dl>

<h3>ER Design</h3>
<p>
Based on the above list of requirements, we have developed an
entity-relationship (ER) data model for the calendar app.
</p>
<h4>User and Group Entities</h4>
<center>
<img src="Pics/user-group.png" alt="ER of users and groups">
</center>
<h4>Calendar Entity</h4>
<center>
<img src="Pics/calendar.png" alt="ER of calendars">
</center>
<h4>Event Entity Classes</h4>
<center>
<img src="Pics/event.png" alt="ER of events">
</center>
<h4>Recurring Event Entity Classes</h4>
<center>
<img src="Pics/event2.png" alt="ER of events">
</center>
<h4>Relationships</h4>
<center>
<img src="Pics/relationships.png" alt="ER of relationships">
</center>
<p>
Only includes relationships not covered in previous diagrams.
</p>

<h3>Your Task</h3>
<p>
Note that some of the potential primary keys (e.g. User.email)
are useful for an abstract design like ER, but  are not useful in a database.
For each entity containing such a potential primary key, we have added
an extra attribute
called <tt>id</tt> to be the primary key. All such <tt>id</tt> attributes
should be defined as <tt>serial</tt>.
</p>
<p>
After doing the above, you should convert the above design into an
SQL schema, using the following rules:
</p>
<ul>
<li> all tables based on entities are given plural names
<li> attributes in entities are given the same name in ER and SQL
<li> attributes in relationships are given the same name in ER and SQL
<li> multi-valued attributes typically have pluralised names,<br>
	in the SQL schema these names should be written in singular form
<li> names containing multiple words, should use underscores to separate the words
<li> ER key attributes are defined using <tt>primary key</tt>
<li> give attribute constraints where useful
<li> do not add <tt>NOT NULL</tt> if the attribute should be able to be null
<li> add <tt>UNIQUE</tt> if it is clear that the attribute will never contain duplicate values
<li> text-based attributes are defined with type <tt>text</tt>, <br>
    unless there is a size which is obvious from the context
<li> attribute domains can be PostgreSQL-specific types where useful
<li> identify and add declarations for all primary and foreign keys.
<li> foreign keys within entity tables are named after the relationship
<li> foreign keys in relationship tables are named <tt><i>table</i>_id</tt>
<li> implement all class hierarchies by the ER mapping
</ul>
<p>
Follow these rules as closely as you can, as well as following the standard
ER&rightarrow;SQL mapping strategies from the slides.
</p>
<p>
If you think that some aspect of the ER design cannot be expressed in SQL,
add a comment to you schema to explain.
</p>
<p>
One thing you should not do is try to second-guess the requireents or the
ER design, come up with your own ER, and implement that.
This would be like taking some specs from your boss and implementing
something that you thought was better than the specs.
</p>
<p>
Feel free to discuss the supplied ER model in the forum, and propose
a "better" solution. 
If you propose something that is genuinely better, or you clarify some
ambuguity or unclearness in the spec,
and you do this <i>by Monday 28 September</i>,
we will consider changing the spec.
</p>

<h3>Doing the Work</h3>
<p>
Type your SQL schema into a single file called <tt>schema.sql</tt>.
A template for this file is available, which already contains some
obvious SQL declarations.
</p>
<pre>
<a href="<?=HOME?>/assignments/ass1/schema.sql"><?=HOMEDIR?>/assignments/ass1/schema.sql</a>
</pre>
<p>
Unfortunately, we cannot give you sample tuples to check your schema.
If we did, we'd effectively be giving you most the schema that we want
you to build.
</p>

<h3>Submission and Testing</h3>
<p>
You should ensure that <tt>schema.sql</tt> is syntactically correct and
will load in a single pass into a newly-created database.
We will test your schema as follows:
</p>
<pre>
... <i>we will login to grieg an run a PostgreSQL server</i> ...
$ <b>dropdb cal</b>
$ <b>createdb cal</b>
$ <b>psql cal -f schema.sql</b>
... we will run our auto-marking script to analyse the contents of the database ...
</pre>
<p>
Make sure that you run the three middle commands yourself on Grieg before
submitting your assignment.
</p>

<h3>Assessment</h3>
<p>
10/12 marks come from the automatic assessment of your <tt>schema.sql</tt>
<p>
2/12 marks come from manual assessment of your coding style, e.g. consistent
naming strategy, cnsistent and readable layout.
</p>
<p>
The auto-marking script will examine properties of your loaded schema, such as:
appropriate mapping of tables for entities and relationships, correct
subclass mapping, defining apropriate primary and foreign keys, correct use
of NOT NULL definitions, naming that follows the above requirments, etc.
</p>
<p>
If your schema has errors when loading into an empty database, you will
receive a 3 mark penalty. If the errors aren't widespread, we will attempt
to fix them and reload <tt>schema.sql</tt>.  The penalty is deducted from
whatever mark you receive after it <i>does</i> load.
</p>

<p>
Have fun, <i>jas</i>
</p>
</body>
</html>
