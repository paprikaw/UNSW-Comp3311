<?php require("../course.php");
echo startPage("Exercises");
showContents(array(
array("week02/index.php","Data Modelling, ER Model, Relational Model"),
array("week03/index.php","Relational Model, SQL DDL, ER&rightarrow;SQL Mapping"),
array("week04/index.php","SQL: Constraints, Updates, Queries, Views"),
array("week05/index.php","Stored Functions in SQL and PLpgSQL"),
array("week07/index.php","Constraints, Triggers, Aggregates, Catalogs"),
array("week08/index.php","Programming with Databases (Python)"),
array("week09/index.php","Relational Design Theory, Normalization"),
array("week10/index.php","Relational Algebra, Query Execution"),
array("week11/index.php","Transactions, Concurrency"),
));
echo endPage();
?>
