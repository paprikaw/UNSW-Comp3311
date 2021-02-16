<? require("../../course.php");

//echo startPage("Exercises 10","q","Transaction Processing, Concurrency Control");

echo startPage("Exercises 09","q+a","Transaction Processing, Concurrency Control");


?>

<ol>

<li>
<p>
<small>[based on Ramakrishnan, ex.17.1]</small><br>
Give a brief definition for each of the following terms:
</p>
<ol type="a">
<li> transaction
<li> dirty read
<li> serializable schedule
<li> conflict-serializable schedule
<li> view-serializable schedule
<li> two-phase locking protocol
</ol>


<li>
<p>
Draw the precedence graph for the following schedule (where <tt>C</tt> means "commit"):
</p>
<pre>
T1:      R(A) W(Z)                C
T2:                R(B) W(Y)        C
T3: W(A)                     W(B)     C
</pre>

<li>
<p>
<small>[based on Ramakrishnan, ex.17.2]</small><br>
Consider the following incomplete schedule <i>S</i>:
</p>
<pre>
T1: R(X) R(Y) W(X)           W(X)
T2:                R(Y)           R(Y)
T3:                     W(Y)
</pre>
<ol type="a">
<p><li>
Determine (by using a precedence graph) whether the schedule is serializable
<p><li>
Modify <i>S</i> to create a complete schedule that is conflict-serializable
</ol>

<li>
<p>
<small>[based on Ramakrishnan, ex.17.3]</small><br>
For each of the following schedules, state whether it is
conflict-serializable and/or view-serializable.
If you cannot decide whether a schedule belongs to either
class, explain briefly.
The actions are listed in the order they are scheduled,
and prefixed with the transaction name.
</p>
<ol type="a">
<p><li> <code>T1:R(X) T2:R(X) T1:W(X) T2:W(X)</code>
<p><li> <code>T1:W(X) T2:R(Y) T1:R(Y) T2:R(X)</code>
<p><li> <code>T1:R(X) T2:R(Y) T3:W(X) T2:R(X) T1:R(Y)</code>
<p><li> <code>T1:R(X) T1:R(Y) T1:W(X) T2:R(Y) T3:W(Y) T1:W(X) T2:R(Y)</code>
<p><li> <code>T1:R(X) T2:W(X) T1:W(X) T3:W(X)</code>
<!--
<p><li> <code>T1:R(X) T2:W(X) T1:W(X) T2:Abort T1:Commit</code>
<p><li> <code>T1:R(X) T2:W(X) T1:W(X) T2:Commit T1:Commit</code>
<p><li> <code>T1:W(X) T2:R(X) T1:W(X) T2:Abort T1:Commit</code>
<p><li> <code>T1:W(X) T2:R(X) T1:W(X) T2:Commit T1:Commit</code>
<p><li> <code>T1:W(X) T2:R(X) T1:W(X) T2:Commit T1:Abort</code>
-->
</ol>

<li>
<p>
Is the following schedule serializable? Show your working.
</p>
<pre>
T1:             R(X)W(X)W(Z)        R(Y)W(Y)
T2: R(Y)W(Y)R(Y)            W(Y)R(X)        W(X)R(V)W(V)
</pre>

<li>
<p>
Consider the following two transactions:
</p>
<pre>
      T1               T2
 ------------     ------------
 read(A)          read(B)
 A := 10*A+4      B := 2*B+3
 write(A)         write(B)
 read(B)          read(A)
 B := 3*B         A := 100-A
 write(B)         write(A)
</pre>
<ol type="a">
<li>
Write versions of the above two transactions that use two-phase locking.
<li>
Is there a non-serial schedule for <i>T1</i> and <i>T2</i> that is
serializable? Why?
<li>
Can a schedule for <i>T1</i> and <i>T2</i> result in deadlock?
If so, give an example schedule. If not, explain why not.
</ol>

</ol>

</body>
</html>
