<? require("../course.php");
echo startPage("Prac Work");
showContents(array(
array("01/index.php","01: SQLite: a simple DBMS"),
array("02/index.php","02: PostgreSQL: a client-server RDBMS"),
array("03/index.php","03: Schema definition; data constraints"),
array("04/index.php","04: SQL queries, views, aggregates (i)"),
array("05/index.php","05: SQL queries, views, aggregates (ii)"),
array("06/x.php","06: Functions, user-defined aggregates"),
array("07/x.php","07: Assignment 2 via SQLite"),
array("08/x.php","08: Updates and triggers"),
array("09/x.php","09: Python, SQL, psycopg2"),
));
echo endPage();
?>
