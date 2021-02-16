<?
define("CCODE","COMP3311");
define("CTERM","21T1");
define("CNAME","Database Systems");
define("HOME","https://www.cse.unsw.edu.au/~cs3311/".CTERM."/");
//define("HOME","http://localhost:8080/cs3311/".CTERM);
define("HOMEDIR","/home/cs3311/web/".CTERM);
//define("HOMEDIR","/Users/jas/srvr/apps/cs3311/".CTERM);
define("PGDOC","https://www.postgresql.org/docs/12/index.html");
define("SQDOC","https://www.sqlite.org/docs.html");

function endPage() { return "</body>\n</html>\n"; }

function startPage($title,$doctype="",$subTitle="",$style="")
{
$home = HOME; $ccode = CCODE; $cterm = CTERM; $cname = CNAME;
if (empty($style)) $style=HOME."/course.css";
$titl = str_replace("<br>"," - ",$title);
$html = <<<xxHTMLxx
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>$ccode $cterm - $titl</title>
<link rel='stylesheet' type='text/css' href='$style'>
xxHTMLxx
;
if (strpos($doctype,"q+a") !== false) {
$html .= <<<xxHTMLxx
<script language="JavaScript">
function changeText(el, newText) {
  // Safari work around
  if (el.innerText)
    el.innerText = newText;
  else if (el.firstChild && el.firstChild.nodeValue)
    el.firstChild.nodeValue = newText;
}
function toggleVisible(elid) {
  el1 = document.getElementById(elid);
  el2 = document.getElementById(elid+"a");
  if (el1.style.display == "") {
     el1.style.display = "none";
     changeText(el2,"show answer");
  }
  else {
     el1.style.display = "";
     changeText(el2,"hide answer");
  }
}
</script>
xxHTMLxx
;
}
$home = HOME;
$html .= <<<xxHTMLxx
</head>
<body>
<div align='center'>
<table width='100%' border='0'>
<tr valign='top'>
<td align='left' width='25%'>
  <span class='tiny'><a href="$home">$ccode $cterm</a></span>
</td>
<td align='center' width='50%'>
  <span class='heading'>$title</span><br>
  <span class='subheading'>$subTitle</span>
</td>
<td align='right' width='25%'>
  <span class='tiny'><a href="$home">$cname</a></span>
</td>
</table>
</div>
xxHTMLxx
;
if (strpos($doctype,"draft") !== false) {
$html .= <<<xxHTMLxx
<div style='color:red;font-size:20pt;text-align:center'>Draft</div>
xxHTMLxx
;
}
return $html;
}

function courseURL($path) { return HOME."/$path"; }
function courseFile($path) { return HOMEDIR."/$path"; }

function href($url, $label, $new_win=true)
{
	if (strpos($url,"http://") === false) $url = "http://$url";
	$target = $new_win ? "target=\"_blank\"" : "";
	return "<a $target href=\"$url\">$label</a>";
}

function scriptMenu($menu)
{
	$scriptFile = $_SERVER['SCRIPT_FILENAME'];
	$items = array();
	foreach ($menu as $script => $title) {
		if (strpos($scriptFile,$script) !== false)
			$items[] = "<b>[$title]</b>";
		else
			$items[] = "<a href='$script'>[$title]</a>";
	}
	return "<p style='text-align:center'>".join("&nbsp;&nbsp;",$items)."</p>
\n";
}

function showContents($contents)
{
	$nmissing = 0; $nfound = 0;
	echo "<center>\n";
	foreach ($contents as $item) {
		if (!preg_match('/^https?:/',$item[0]) && !file_exists($item[0]))
			$nmissing++;
		else {
			$nfound++;
			echo "<p><span class='contentLink'> ",
				"<a href='$item[0]'>$item[1]</a></span>";
			if (count($item) > 2)
				echo "<br><span class='contentNote'>($item[2])</span>";
			echo "</p>\n";
		}
	}
	if ($nfound == 0 || $nmissing > 0) echo "<p>More to come ...</p>\n";
	echo "</center>\n";
}

function showAnswer($a)
{
	global $qid;  $qid++;
	$view = isset($_GET["view"]) ? $_GET["view"] : "";
	switch ($view) {
	case "qo":
		# questions only => nothing to show for answers
		break;
	case "all":
		echo "<div style='color:#000099;'>",
			"<p><b>Answer:</b></p>\n$a</div>\n";
		break;
	default:
		$noshow = "color:#000099;display:none";
		echo "<p><small>[<a id=\"q{$qid}a\" href=\"##\"",
			" onclick=\"toggleVisible('q$qid')\">",
			"show answer</a>]</small></p>\n",
			"<div id=\"q$qid\" style=\"$noshow\">\n",
			"$a\n</div></p>\n";
	}
}

function startAnswer()
{
	global $qid;  $qid++;
	$view = isset($_GET["view"]) ? $_GET["view"] : "";
	switch ($view) {
	case "qo":
		# questions only => nothing to show for answers
        echo "<!--\n";
		break;
	case "all":
		echo "<div style='color:#000099;'>",
			"<p><b>Answer:</b></p>\n";
		break;
	default:
		$noshow = "color:#000099;display:none";
		echo "<p><small>[<a id=\"q{$qid}a\" href=\"##\"",
			" onclick=\"toggleVisible('q$qid')\">",
			"show answer</a>]</small></p>\n",
			"<div id=\"q$qid\" style=\"$noshow\">\n";
	}
}

function endAnswer()
{
	$view = isset($_GET["view"]) ? $_GET["view"] : "";
	switch ($view) {
	case "qo":
		# questions only => nothing to show for answers
		echo "\n-->\n";
		break;
	default:
		echo "</div>\n";
		break;
	}
}

function alternativeViews()
{
	if (isset($_GET["view"])) return;
	$url = $_SERVER['SCRIPT_NAME'];
	echo "<p style='text-align:center;font-size:75%'>",
		"<a href='$url?view=qo'>[Show with no answers]</a>",
		" &nbsp; ",
		"<a href='$url?view=all'>[Show with all answers]</a>",
		"</div>\n";
}

function codeFile($fname,$label="") {
	$code = codeIn($fname);
	if ($label == "") $label = $fname;
	if (strpos($code,"Can't find code") !== false)
		return "<p>$code</p>\n";
	else
        	return "<p><span class='fname'>$label</span>".
			"<pre>$code</pre>\n";
}

function newCodeIn($fname,$language="C") {
	if (!file_exists($fname))
		return "Can't find code file $fname\n";
	else
		return codeString(file_get_contents($fname),$language);
}

function codeIn($fname,$language="C") {
	$lines = @file_get_contents($fname);
	if ($lines !== false) 
		return htmlentities($lines);
	else
		return "Can't find code file $fname\n";
}

function codeString($str,$language="C",$line_nums=true) {
/**/
	$home = HOME;
	require_once("../../lib/geshi.php");
	$g = new GeSHi($str,$language);
	if ($line_nums)
		$g->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
	return $g->parse_code();
/**/
	//return "<pre>\n".htmlentities($str)."</pre>\n";
}

function showQandA($q,$a)
{
	echo "<ol>\n";
	for ($i = 0; $i < count($q); $i++) {
		$n = $i+1; $id1 = "Q$n"; $id2 = "Q$n"."a";
		echo "<p><li>$q[$i]\n",
			"<p><small>[<a id=\"$id2\" href=\"##\"",
			" onclick=\"toggleVisible('$id1')\">",
			"show answer</a>]</small></p>\n",
			"<div id=\"$id1\" style=\"color:#000099;display:none\">\n",
			"$a[$i]\n</div></li>\n";
	}
	echo "</ol>\n";
}

function showItems($items)
{
	echo "<center><table width='95%' cellpadding='4'>\n";
	foreach ($items as $item => $info) {
		echo "<tr><td bgcolor='#66cc66'> <b>$item</b> ",
			"<small>(Posted $info[0])</small></td></tr>",
			"<tr><td>$info[1]</td></tr>\n";
	}
	echo "</table></center>\n";
}

function updateBlurb()
{
	$mtime = lastChanged();
return <<<xxHTMLxx
<div style="text-align:center;font-size:80%;color:#555555;margin-top:5px;">
Last updated: <b>$mtime</b> <br>
Most recent changes are shown in <span class="red">red</span> ...
older changes are shown in <span class="brown">brown</span>. <br>
</div>
xxHTMLxx
;
}

function lastChanged()
{
        $mtime = filemtime($_SERVER["SCRIPT_FILENAME"]);
        return date("l jS F g:ia",$mtime);
}

function diagram($pic)
{
	return "<div align='center'><img src='Pics/$pic-small.png'></div>\n";
}

class QA
{
	var $qno = 0;
	var $subqno = 0;
	var $qas = array();

	function add($q,$a=null)
	{
		$this->qno++;
		$this->subqno = 0;
		$arr = array($q,$a,null);
		$this->qas[$this->qno] = $arr;
	}
	function addSub($q,$a)
	{
		$arr = $this->qas[$this->qno];
		$subs = $arr[2];
		if (is_null($subs)) $subs = array();
		$subqa = array($q,$a);
		$subs[] = $subqa;
		$arr[2] = $subs;
		$this->qas[$this->qno] = $arr;
	}
	function show()
	{
		echo "<ol>\n"; $i = 0;
		foreach ($this->qas as $qa) {
			$i++; $id1 = "Q$i"; $id2 = "Q$i"."a";
			echo "<p><li>\n$qa[0]\n\n";
			if (!is_null($qa[2])) {
				echo "<ol type='a'>\n"; $j = 0;
				foreach ($qa[2] as $subqa) {
					$j++; $id3 = "Q$i.$j"; $id4 = "Q$i.$j"."a";
					echo
					"<li>\n$subqa[0]\n",
					"<br><span class='toggle'>[<a id=\"$id4\" href=\"##\"",
					" onclick=\"toggleVisible('$id3')\">",
					"show answer</a>]</span><p>\n",
					"<div id=\"$id3\" style=\"color:#000099;display:none\">\n",
					"$subqa[1]\n</div></li>\n";
				}
				echo "</ol>\n";
			}
			if (!is_null($qa[1])) {
				echo
				"<p><span class='toggle'>[<a id=\"$id2\" href=\"##\"",
				" onclick=\"toggleVisible('$id1')\">",
				"show answer</a>]</span></p>\n",
				"<div id=\"$id1\" style=\"color:#000099;display:none\">\n",
				"$qa[1]\n</div></li>\n";
			}


		}
		echo "</ol>\n";
	}
}

function demo($cmd,$head=0,$tail=0)
{
	$all = split("\n",shell_exec($cmd));
	$nlines = count($all);
	if ($head == 0 && $tail == 0) {
		# show all lines in command output
		# so no filtering required here
		$lines = $all;
	}
	elseif ($tail == 0) {
		if ($nlines <= $head)
			$lines = $all;
		else {
			$lines = array_slice($all,0,$head);
			$lines[] = "...\n";
		}
	}
	elseif ($head == 0) {
		if ($nlines <= $tail)
			$lines = $all;
		else {
			$t = array_slice($all,$nlines-$tail-1);
			$lines = array_merge(array("..."),$t);
		}
	}
	else {
		if ($nlines <= ($head+$tail+1))
			$lines = $all;
		else {
			$h = array_slice($all,0,$head);
			$h[] = "...";
			$t = array_slice($all,$nlines-$tail-1);
			$lines = array_merge($h,$t);
		}
	}
	$cmd = str_replace("\n","</b>\n&gt;\t<b>",$cmd);
	echo "$ <b>$cmd</b>\n";
	echo join("\n",$lines);
}

function tableOfContents($dir,$files)
{
	$html = "<table cellpadding='5' cellspacing='2'><tr valign=top>
		<td bgcolor='#CCCCCC'><b>File</b></td>
		<td bgcolor='#CCCCCC'><b>Description</b></td></tr>\n";
	foreach ($files as $name => $description) {
		if (strpos($name,".php") !== false)
			$link = "$name.txt";
		else
			$link = $name;
		if ($dir == "" || $dir == ".")
			$fileLink = "<a href='$link'>$name</a>";
		else
			$fileLink = "<a href='$dir/$name'>$dir/$name</a>";
		$html .= "<tr valign='top'><td>$fileLink</td><td>$description</td></tr>\n";
	}
	return "$html\n</table>\n";
}

function dueDate($item)
{
	$ccode = CCODE; $cterm = CTERM;
	$item = str_replace(" ","+",$item);
	$url = "http://webapps.cse.unsw.edu.au/webcms2/assessment/".
		"due_date.php?course=$ccode+$cterm&item=$item";
	$date = file_get_contents($url);
	return empty($date) ? "???" : $date;
}

?>
