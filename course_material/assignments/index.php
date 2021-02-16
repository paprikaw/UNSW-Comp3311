<? require("../course.php");
echo startPage("Assignments");
showContents(array(
array("ass1/index.php","Assignment 1: Mapping ER to SQL"),
array("ass2/index.php","Assignment 2: SQL, PLpgSQL"),
array("ass3/index.php","Assignment 3: Python, SQL, psycopg2"),
));
echo endPage();
?>
