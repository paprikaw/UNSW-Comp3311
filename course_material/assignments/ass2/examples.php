<? require("../../course.php"); require("defs.php"); ?>
<?=startPage("Assignment 2","","Example Test Cases")?>
<?=updateBlurb().scriptMenu($menu)?>

<br>
<p>
The following give some sample inputs and outputs that you can use to
estimate the correctness of your views and functions.
These examples are by no means exhaustive, and more cases will be used
in the auto-marking, so it is up to you to perform comprehensive checking
of your solution.
</p>
<p class="brown">
Note that the default behaviour when your raise an error is to print
a line giving you the <tt>CONTEXT</tt> in the PLpgSQL code where the
error was raised. We did not show the <tt>CONTEXT</tt> message in the
examples below. For you to prevent the message, use the <tt>psql</tt>
command:
</p>
<pre class="brown">
\set verbosity terse
</pre>
<p class="brown">
Of course, this will probably prevent the <tt>CONTEXT</tt> message
appearing if your code has a genuine error, so rather than turning
the message off, you could always just ignore it.
Whether it's on or off does not affect the auto-marking.
</p>

<h3>Examples for <tt>mymy1</tt></h3>

<pre>
mymy=# <b>select * from q1 order by unswid;</b>
 unswid  |         name         
---------+----------------------
 3012907 | Jordan Sayed
 3101627 | Yiu Man
 3137719 | Vu-Minh Samarasekera
 3139456 | Minna Henry-May
 3158621 | Sanam Sam
 3163349 | Kerry Plant
 3193072 | Ivan Tsitsiani
 3195354 | Marliana Sondhi
(8 rows)


mymy=# <b>select * from q2;</b>
 nstudents | nstaff | nboth 
-----------+--------+-------
     31361 |  24405 |     0
(1 row)


mymy=# <b>select * from q3 order by name;</b>
    name     | ncourses 
-------------+----------
 Susan Hagon |      248
(1 row)


mymy=# <b>select * from q4a order by id;</b>
   id    |        name         
---------+---------------------
 3040773 | Tonny Andrewartha
 3124015 | Shudo Suzuki Cheung
 3124711 | Irene Van Saane
 3126551 | Adrian Andary
 3128290 | Nathan Asplet
 3131729 | Yilu Zhang Ying
 3144015 | Ayako Kao
 3159387 | Demyan Holczer
 3172526 | Janet Sutcliffe
 3173265 | Michael Maclachlan
 3183655 | Rachael Dunkley
 3192680 | Luke De Luca
(12 rows)

<span class="comment">-- there is no data from 2017 in mymy1</span>
mymy=# <b>select * from q4b order by id;</b>
 id | name 
----+------
(0 rows)

mymy=# <b>select * from q5 order by name;</b>
          name          
------------------------
 Faculty of Engineering
(1 row)


mymy=# <b>select q6(3012907);</b>  <span class="comment">-- people.unswid</span>
      q6      
--------------
 Jordan Sayed
(1 row)

mymy=# <b>select q6(1076226);</b>  <span class="comment">-- people.id</span>
      q6      
--------------
 Jordan Sayed
(1 row)

mymy=# <b>select q6(9334555);</b>  <span class="comment">-- people.unswid</span>
      q6       
---------------
 John Shepherd
(1 row)

mymy=# <b>select q6(5035569);</b>  <span class="comment">-- people.id</span>
      q6       
---------------
 John Shepherd
(1 row)

mymy=# <b>select (q6(12345) is null) as q6;</b>
 q6 
----
 t
(1 row)


mymy=# <b>select * from q7('COMP1711') order by term;</b>
  subject | term |     convenor     
----------+------+------------------
 COMP1711 | 03s1 | Richard Buckland
(1 row)

mymy=# <b>select * from q7('COMP1511') order by term;</b>
 subject | term | convenor 
---------+------+----------
(0 rows)

mymy=# <b>select * from q7('COMP3311') order by term;</b>
  subject | term |   convenor    
----------+------+---------------
 COMP3311 | 03s1 | John Shepherd
 COMP3311 | 03s2 | Kwok Wong
 COMP3311 | 06s1 | Wei Wang
 COMP3311 | 06s2 | John Shepherd
 COMP3311 | 07a1 | John Shepherd
 COMP3311 | 07a2 | Wei Wang
 COMP3311 | 08s1 | John Shepherd
 COMP3311 | 09s1 | John Shepherd
 COMP3311 | 10s1 | Xuemin Lin
 COMP3311 | 11s1 | John Shepherd
 COMP3311 | 12s1 | John Shepherd
 COMP3311 | 13s2 | John Shepherd
(12 rows)

mymy=# <b>select * from q7('MATH1131') order by term;</b>
  subject | term |       convenor       
----------+------+----------------------
 MATH1131 | 07a1 | Michael Hirschhorn
 MATH1131 | 07a2 | David Crocker
 MATH1131 | 08s1 | Peter Blennerhassett
 MATH1131 | 08s2 | David Crocker
 MATH1131 | 09s1 | Peter Blennerhassett
 MATH1131 | 09s2 | David Angell
 MATH1131 | 10s1 | Peter Blennerhassett
 MATH1131 | 10s2 | Milan Pahor
 MATH1131 | 11s1 | Gary Froyland
 MATH1131 | 11s2 | Dennis Trenerry
 MATH1131 | 12s1 | Thomas Britz
 MATH1131 | 12s2 | Thomas Britz
 MATH1131 | 13s1 | John Murray
 MATH1131 | 13s2 | Milan Pahor
(14 rows)

<span class="comment">-- Q8 ... transcripts</span>

mymy=# <b>select * from q8(7654321);</b>
ERROR:  Invalid student 7654321

mymy=# <b>select * from q8(3011082);</b>
   code   | term | prog |         name         | mark | grade | uoc 
----------+------+------+----------------------+------+-------+-----
 ATAX0401 | 03s1 | 9250 | Tax Policy           |   58 | PS    |   6
 ATAX0411 | 03s1 | 9250 | Taxation of Capital  |   57 | PS    |   6
 ATAX0420 | 03s2 | 9250 | Principles of Aust I |   67 | CR    |   6
          |      |      | Overall WAM/UOC      |   61 |       |  18
(4 rows)

mymy=# <b>select * from q8(3320756);</b>
   code   | term | prog |         name         | mark | grade | uoc 
----------+------+------+----------------------+------+-------+-----
 BENV1080 | 10s1 | 3624 | Enabling Skills      |   50 | PS    |   6
 ENGG1000 | 10s1 | 3624 | Engineering Design   |   64 | PS    |   6
 MATH1141 | 10s1 | 3624 | Higher Mathematics 1 |   96 | HD    |   6
 PHYS1121 | 10s1 | 3624 | Physics 1A           |   88 | HD    |   6
 CVEN1300 | 10s2 | 3620 | Engineering Mechanic |   87 | HD    |   6
 CVEN2101 | 10s2 | 3620 | Engineering Construc |   66 | CR    |   6
 MATH1231 | 10s2 | 3620 | Mathematics 1B       |   80 | DN    |   6
 MATS1101 | 10s2 | 3620 | Engineering Material |   70 | CR    |   6
 CVEN2301 | 11s1 | 3620 | Mechanics of Solids  |   86 | HD    |   6
 CVEN2501 | 11s1 | 3620 | Principles of Water  |   85 | HD    |   6
 ENGG1811 | 11s1 | 3620 | Computing for Engine |   55 | PS    |   6
 MATH2019 | 11s1 | 3620 | Engineering Mathemat |   72 | CR    |   6
 CVEN2002 | 11s2 | 3620 | Engineering Computat |   61 | PS    |   6
 CVEN2201 | 11s2 | 3620 | Soil Mechanics       |   71 | CR    |   6
 CVEN2302 | 11s2 | 3620 | Materials and Struct |   70 | CR    |   6
 ECON1101 | 11s2 | 3620 | Microeconomics 1     |   63 | PS    |   6
 CVEN3201 | 12s1 | 3620 | Applied Geotechnics  |   73 | CR    |   6
 CVEN3301 | 12s1 | 3620 | Structural Analysis  |   79 | DN    |   6
 CVEN3401 | 12s1 | 3620 | Transport &amp; Highway  |   67 | CR    |   6
 CVEN3501 | 12s1 | 3620 | Water Resources Engi |   62 | PS    |   6
 CVEN3031 | 12s2 | 3620 | Civil Engineering Pr |   55 | PS    |   6
 CVEN3101 | 12s2 | 3620 | Engineering Operatio |   75 | DN    |   6
 CVEN3302 | 12s2 | 3620 | Structural Design    |   75 | DN    |   6
 CVEN3502 | 12s2 | 3620 | Water &amp; Wastewater E |   62 | PS    |   6
          |      |      | Overall WAM/UOC      |   71 |       | 144
(25 rows)

mymy=# <b>select * from q8(1053721);</b>
   code   | term | prog |         name         | mark | grade | uoc 
----------+------+------+----------------------+------+-------+-----
 SAHT1102 | 07a2 | 4800 | Beyond Modernities   |   82 | DN    |   6
 SART1501 | 07a2 | 4800 | Painting             |   75 | DN    |   6
 SART1601 | 07a2 | 4800 | Sculpture            |   85 | HD    |   6
 SOMA1521 | 07a2 | 4800 | Introduction to Anal |   73 | CR    |   6
 SAHT1101 | 08s1 | 4800 | Narratives of Modern |      | T     |   6
 SART1502 | 08s1 | 4800 | Drawing              |      | T     |   6
 SOMA2521 | 08s1 | 4800 | Intro to Studio Ligh |   87 | HD    |   6
 SOMA3858 | 08s2 | 4800 | Advanced Studio Ligh |   77 | DN    |   6
 SART2842 | 09s1 | 4800 | Metal Casting        |   92 | HD    |   6
 SOMA2321 | 09s1 | 4800 | Photomedia 2A        |   74 | CR    |   6
 SOMA2341 | 09s1 | 4800 | Photomedia 2B        |   87 | HD    |   6
 SAHT3211 | 09s2 | 4800 | Art Since 1990       |   69 | CR    |   6
 SOMA2331 | 09s2 | 4800 | Photomedia 3A        |   83 | DN    |   6
 SOMA2351 | 09s2 | 4800 | Photomedia 3B        |   89 | HD    |   6
 GENL1062 | 10x1 | 4800 | Understanding Human  |   71 | CR    |   6
 SOMA3341 | 10s1 | 4800 | Photomedia 4A        |   78 | DN    |   6
 SOMA3616 | 10s1 | 4800 | Professional Practic |   81 | DN    |   6
 SAHT2668 | 10s2 | 4800 | Photography's Histor |   63 | PS    |   6
 SOMA3351 | 10s2 | 4800 | Photomedia 5A        |   71 | CR    |   6
 SOMA3361 | 11s1 | 4800 | Photomedia 4B        |   78 | DN    |   6
 SOMA3371 | 11s2 | 4800 | Photomedia 5B        |   80 | DN    |   6
          |      |      | Overall WAM/UOC      |   79 |       | 126
(22 rows)

mymy=# <b>select * from q8(3124015);</b>
   code   | term | prog |         name         | mark | grade | uoc 
----------+------+------+----------------------+------+-------+-----
 ACCT1501 | 04s1 | 3978 | Accounting &amp; Financi |   55 | PS    |   6
 COMP1711 | 04s1 | 3978 | Higher Computing 1A  |   62 | PS    |   6
 MATH1081 | 04s1 | 3978 | Discrete Mathematics |   64 | PS    |   6
 MATH1141 | 04s1 | 3978 | Higher Mathematics 1 |   76 | DN    |   6
 BENV1043 | 04s2 | 3978 | Multimedia in Des Pr |   86 | HD    |   6
 COMP1721 | 04s2 | 3978 | Higher Computing 1B  |   90 | HD    |   6
 COMP9311 | 04s2 | 3978 | Database Systems     |   72 | CR    |   6
 MATH1241 | 04s2 | 3978 | Higher Mathematics 1 |   72 | CR    |   6
 COMP2021 | 05s1 | 3978 | Digital System Struc |   80 | DN    |   6
 COMP2041 | 05s1 | 3978 | Software Constructio |   88 | HD    |   6
 COMP2711 | 05s1 | 3978 | Higher Data Organisa |   66 | CR    |   6
 GENC7002 | 05s1 | 3978 | Getting Into Busines |   61 | PS    |   6
 GENT0404 | 05s1 | 3978 | Gods, Heroines and H |   69 | CR    |   3
 COMP3441 | 05s2 | 3978 | Security Engineering |   75 | DN    |   6
 COMP2920 | 06s1 | 3978 | Professional Issues  |   68 | CR    |   3
 COMP3111 | 06s1 | 3978 | Software Engineering |   79 | DN    |   6
 COMP3331 | 06s1 | 3978 | Computer Networks&amp;Ap |   76 | DN    |   6
 COMP3821 | 06s1 | 3978 | Ext Algorithms&amp;Prog  |   56 | PS    |   6
 COMP3891 | 06s1 | 3978 | Ext Operating System |   78 | DN    |   6
 COMP3421 | 06s2 | 3978 | Computer Graphics    |   63 | PS    |   6
 COMP4431 | 07a1 | 3978 | Game Design Workshop |   79 | DN    |   6
 COMP4905 | 07a1 | 3978 | Industrial Training  |      | SY    |  15
 COMP3171 | 07a2 | 3978 | Object-Oriented Prog |   63 | PS    |   6
 COMP9321 | 07a2 | 3978 | Web Applications Eng |   85 | HD    |   6
 GEND1209 | 07a2 | 3978 | Black and White Phot |   82 | DN    |   3
 COMP3411 | 08s1 | 3978 | Artificial Intellige |   50 | PS    |   6
 COMP3161 | 08s2 | 3978 | Concepts of Programm |   69 | CR    |   6
          |      |      | Overall WAM/UOC      |   72 |       | 162
(28 rows)

mymy=# <b>select * from q8(3202320);</b>
  code   | term | prog |         name         | mark | grade | uoc 
----------+------+------+----------------------+------+-------+-----
 COMP1917 | 09s1 | 3645 | Computing 1          |   83 | DN    |   6
 ENGG1000 | 09s1 | 3645 | Engineering Design   |   65 | CR    |   6
 MATH1131 | 09s1 | 3645 | Mathematics 1A       |   46 | PC    |   6
 PHYS1121 | 09s1 | 3645 | Physics 1A           |   31 | FL    |    
 COMP1927 | 09s2 | 3645 | Computing 2          |   67 | CR    |   6
 ELEC1111 | 09s2 | 3645 | Elec & Telecomm Eng  |   51 | PS    |   6
 MATH1231 | 09s2 | 3645 | Mathematics 1B       |   52 | PS    |   6
 PHYS1121 | 09s2 | 3645 | Physics 1A           |   55 | PS    |   6
 PHYS1221 | 10x1 | 3645 | Physics 1B           |   37 | FL    |    
 COMP2121 | 10s1 | 3645 | Microprocessors & In |   55 | PS    |   6
 COMP2911 | 10s1 | 3645 | Eng. Design in Compu |   70 | CR    |   6
 ELEC2134 | 10s1 | 3645 | Circuits and Signals |   25 | FL    |    
 MATH2069 | 10s1 | 3645 | Mathematics 2A       |   42 | FL    |    
 COMP3222 | 10s2 | 3645 | Digital Circuits and |   50 | PS    |   6
 ELEC2134 | 10s2 | 3645 | Circuits and Signals |   51 | PS    |   6
 MATH2099 | 10s2 | 3645 | Mathematics 2B       |   35 | FL    |    
 PHYS1221 | 10s2 | 3645 | Physics 1B           |   28 | FL    |    
 GENC3003 | 11x1 | 3645 | Personal Financial P |   62 | PS    |   3
 PHYS1221 | 11x1 | 3645 | Physics 1B           |   40 | FL    |    
 COMP3211 | 11s1 | 3645 | Computer Architectur |   61 | PS    |   6
 COMP3231 | 11s1 | 3645 | Operating Systems    |   55 | PS    |   6
 COMP3311 | 11s1 | 3645 | Database Systems     |   59 | PS    |   6
 MATH2069 | 11s1 | 3645 | Mathematics 2A       |   45 | FL    |    
 COMP3171 | 11s2 | 3645 | Object-Oriented Prog |   65 | CR    |   6
 COMP3331 | 11s2 | 3645 | Computer Networks&Ap |   67 | CR    |   6
 COMP3601 | 11s2 | 3645 | Design Project A     |   76 | DN    |   6
 GENS4010 | 11s2 | 3645 | Science and Religion |   60 | PS    |   6
 MATH2099 | 11s2 | 3645 | Mathematics 2B       |   59 | PS    |   6
 PHYS1221 | 12x1 | 3645 | Physics 1B           |   33 | FL    |    
 TELE3113 | 12x1 | 3645 | Analogue and Digital |   42 | FL    |    
 COMP4001 | 12s1 | 3645 | Object-Oriented Soft |   25 | FL    |    
 COMP9321 | 12s1 | 3645 | Web Applications Eng |   74 | CR    |   6
 COMP9333 | 12s1 | 3645 | Advanced Computer Ne |   89 | HD    |   6
 MATH2069 | 12s1 | 3645 | Mathematics 2A       |   32 | FL    |    
 COMP4920 | 12s2 | 3645 | Professional Issues  |   41 | FL    |    
 COMP9322 | 12s2 | 3645 | Service-Oriented Arc |   56 | PS    |   6
 COMP9323 | 12s2 | 3645 | e-Enterprise Project |   57 | PS    |   6
          |      |      | Overall WAM/UOC      |   52 |       | 141
(38 rows)

<span class="comment">-- Non-existent group ID </span>
mymy=# <b>select * from q9(1234);</b>
ERROR:  No such group 1234

<span class="comment">-- Program Groups --</span>

<span class="comment">-- enumerated program groups</span>

mymy=# <b>select * from q9(20026);</b>
 objtype | objcode 
---------+---------
 program | 3403
(1 row)

mymy=# <b>select * from q9(113111) order by objcode;</b>
 objtype | objcode 
---------+---------
 program | 3408
 program | 4054
 program | 4055
(3 rows)

mymy=# <b>select * from q9(113167) order by objcode;</b>
 objtype | objcode 
---------+---------
 program | 3648
 program | 3651
 program | 3652
 program | 3653
 program | 3749
 program | 3982
(6 rows)

mymy=# <b>select * from q9(116990) order by objcode;</b>
 objtype | objcode 
---------+---------
 program | 4405
 program | 4421
 program | 4422
 program | 4423
 program | 4424
 program | 4425
 program | 4430
 program | 4437
 program | 4445
(9 rows)

<span class="comment">-- pattern-based program groups</span>

mymy=# <b>select * from q9(115901);</b>
 objtype | objcode 
---------+---------
 program | 3426
(1 row)

mymy=# <b>select * from q9(117030) order by objcode;</b>
 objtype | objcode 
---------+---------
 program | 5740
 program | 9200
 program | 9210
 program | 9220
 program | 9230
(5 rows)

mymy=# <b>select * from q9(116738) order by objcode;</b>
 objtype | objcode 
---------+---------
 program | 4400
 program | 4405
 program | 4421
 program | 4422
 program | 4423
 program | 4424
 program | 4441
 program | 4442
 program | 4443
 program | 4445
(10 rows)


<span class="comment">-- Stream Groups --</span>

<span class="comment">-- there are no pattern-based stream groups</span>

<span class="comment">-- enumerated stream groups</span>

mymy=# <b>select * from q9(1530) order by objcode;</b>
 objtype | objcode 
---------+---------
 stream  | BINFA1
(1 row)

mymy=# <b>select * from q9(6793) order by objcode;</b>
 objtype | objcode 
---------+---------
 stream  | ECONA1
 stream  | ECONE1
 stream  | ECONJ1
(3 rows)

mymy=# <b>select * from q9(5181) order by objcode;</b>
 objtype | objcode 
---------+---------
 stream  | ANATA1
 stream  | BIOCA1
 stream  | BIOCC1
 stream  | BIOCE1
 stream  | BIOSG1
 stream  | BIOTA1
 stream  | FOODH1
 stream  | GEOGG1
 stream  | MATHM1
 stream  | MATHN1
 stream  | MATHT1
 stream  | MATSB1
 stream  | MICRB1
 stream  | MICRC1
 stream  | NEURS1
 stream  | PATHA1
 stream  | PHARA1
 stream  | PHSLA1
 stream  | PSYCA1
 stream  | VISNA1
(20 rows)


<span class="comment">-- Subject Groups --</span>

<span class="comment">-- pattern is 'FREE2###'</span>
mymy=# <b>select * from q9(1053);</b>
 objtype | objcode 
---------+---------
(0 rows)

<span class="comment">-- pattern is 'all/F=ARTSC'</span>
mymy=# <b>select * from q9(1045);</b>
 objtype | objcode 
---------+---------
(0 rows)

<span class="comment">-- pattern is 'GENG####'</span>
omymy=# <b>select * from q9(1371);</b>
 objtype | objcode 
---------+---------
(0 rows)

<span class="comment">-- pattern is indivdual course codes, except CEIC100[01]</span>
mymy=# <b>select * from q9(1117) order by objcode;</b>
 objtype |   objcode   
---------+-------------
 subject | BABS1201
 subject | BIOM1010
 subject | BIOS1301
 subject | CEIC1000
 subject | CEIC1001
 subject | CHEM1011
 subject | CHEM1021
 subject | CHEM1031
 subject | CHEM1041
 subject | COMP1921
 subject | CVEN1300
 subject | CVEN1701
 subject | ELEC1111
 subject | GEOS1111
 subject | GEOS3321
 subject | GMAT1110
 subject | GMAT1400
 subject | MATH1081
 subject | MATS1101
 subject | MINE1010
 subject | MINE1300
 subject | MMAN1130
 subject | MMAN1300
 subject | PHYS1231
 subject | PSYC1001
 subject | PTRL1010
 subject | SOLA1070
(27 rows)

<span class="comment">-- pattern is 'COMP3###'</span>
mymy=# <b>select * from q9(1023) order by objcode;</b>
 objtype | objcode  
---------+----------
 subject | COMP3111
 subject | COMP3120
 subject | COMP3121
 subject | COMP3131
 subject | COMP3141
 subject | COMP3151
 subject | COMP3152
 subject | COMP3153
 subject | COMP3161
 subject | COMP3171
 subject | COMP3211
 subject | COMP3221
 subject | COMP3222
 subject | COMP3231
 subject | COMP3241
 subject | COMP3311
 subject | COMP3331
 subject | COMP3411
 subject | COMP3421
 subject | COMP3431
 subject | COMP3441
 subject | COMP3511
 subject | COMP3601
 subject | COMP3710
 subject | COMP3711
 subject | COMP3720
 subject | COMP3821
 subject | COMP3881
 subject | COMP3891
 subject | COMP3901
 subject | COMP3902
 subject | COMP3931
(32 rows)

<span class="comment">-- enumerated subject groups</span>

mymy=# <b>select * from q9(7571);</b>
 objtype | objcode  
---------+----------
 subject | ARTS2090
(1 row)

mymy=# <b>select * from q9(7499);</b>
 objtype | objcode  
---------+----------
 subject | COMP1917
 subject | COMP1911
 subject | ENGG1811
(3 rows)

<span class="comment">-- subject groups with child groups</span>

mymy=# <b>select * from q9(1144) order by objcode;</b>
 objtype | objcode  
---------+----------
 subject | CHEM1011
 subject | CHEM1031
 subject | COMP1911
 subject | ENGG1000
 subject | ENGG1811
 subject | MATH1131
 subject | MATH1141
 subject | MATH1231
 subject | MATH1241
 subject | MATS1101
 subject | PHYS1121
 subject | PHYS1131
(12 rows)


mymy=# <b>select * from q9(1166) order by objcode;</b>
 objtype | objcode  
---------+----------
 subject | BIOM1010
 subject | BIOS1301
 subject | CEIC1000
 subject | CEIC1001
 subject | CHEM1011
 subject | CHEM1021
 subject | CHEM1031
 subject | CHEM1041
 subject | COMP1921
 subject | CVEN1300
 subject | CVEN1701
 subject | ELEC1111
 subject | GEOS1111
 subject | GEOS3321
 subject | GMAT1110
 subject | GMAT1400
 subject | MATH1081
 subject | MATS1101
 subject | MINE1010
 subject | MINE1300
 subject | MMAN1130
 subject | MMAN1300
 subject | PHYS1231
 subject | PTRL1010
 subject | SOLA1070
(25 rows)

<span class="comment">-- Pre-reqs</span>

<span class="comment">-- not a pre-req for anything</span>
mymy=# select * from q10('COMP9318') order by q10;
 q10 
-----
(0 rows)

mymy=# select * from q10('COMP9321') order by q10;
   q10    
----------
 COMP9322
(1 row)

mymy=# <b>select * from q10('COMP3311') order by q10;</b>
   q10    
----------
 COMP4314
 COMP9315
 COMP9318
 COMP9321
(4 rows)

mymy=# <b>select * from q10('MMAN2600') order by q10;</b>
   q10    
----------
 AERO3630
 MECH3204
 MECH3540
 MECH3601
 MECH3602
 MECH3610
 MECH9620
 MECH9720
 MECH9751
 MMAN3210
 NAVL3610
(11 rows)

mymy=# <b>select * from q10('COMP1927') order by q10;</b>
   q10    
----------
 BINF3020
 COMP2121
 COMP2911
 COMP3111
 COMP3121
 COMP3141
 COMP3151
 COMP3152
 COMP3153
 COMP3222
 COMP3231
 COMP3311
 COMP3331
 COMP3411
 COMP3891
 COMP3931
 COMP4141
 COMP4181
 COMP6752
 COMP9319
 COMP9417
 COMP9444
 COMP9517
 COMP9844
(24 rows)

</pre>

<h3>Examples for <tt>mymy2</tt></h3>

<pre>
<span class="comment">-- nobody takes so many courses these days</span>

mymy2=# <b>select * from q1;</b>
 unswid | name 
--------+------
(0 rows)


mymy2=# <b>select * from q2;</b>
 nstudents | nstaff | nboth 
-----------+--------+-------
     31361 |  24407 |     0
(1 row)


<span class="comment">-- Susan Hagon retired</span>

mymy2=# select * from q3;
      name       | ncourses 
-----------------+----------
 David Lovell    |      140
 Duncan Chalmers |      140
(2 rows)

mymy2=# select * from q4a;
 id | name 
----+------
(0 rows)

<span class="comment">-- 3778 students in 17s1</span>

mymy2=# <b>select * from q4b;</b> 
   id    |          name          
---------+------------------------
 3267637 | Manling Wang Jing
 3247384 | Warren Sadaka
 3168864 | Kejiao Xing
 6952177 | Amelia Ongel
 3121598 | Gregory Minion
 3266162 | Monica-Nicole Mahfoud
 3091426 | Nasir Fortuna
 3031941 | Sunny Mar
 3262889 | Tara Eva
 3200416 | Praveen Jagadesan
 3312220 | Craig Stromer
 3276884 | Jaimi Blume-Poulton
 3254840 | Gera Marzotto
 3221869 | Christopher Haisell
 3290500 | Tracey Schreter
 3304648 | Byron Bergseng
 3269018 | Zhi-Cheng Xiao
 3284796 | Crystal Zhang Lingqing
 3371806 | Timothy Harb
 3223173 | Robin Kalinowski
 3197686 | Venetia Soo Kee
 3216260 | Alexandra Sarian
 3223684 | Shaun De Rooy
 3152489 | Moses Mamat
 3224604 | Hana Berntsen
 3213623 | Harumi Wilson
 3279041 | Ronak Pangasa
 3185124 | Muhammad Fung
 3207679 | Jennifer Dix
 3237106 | Oliver Oliver
 3270124 | Florian Kruetzen
 3267046 | Michael Gronlund
(32 rows)


mymy2=# <b>select * from q5;</b>
          name          
------------------------
 Faculty of Engineering
 Faculty of Law
(2 rows)


mymy2=# <b>select * from q6(5011111);</b>
     q6     
------------
 Ian Jacobs
(1 row)

mymy2=# <b>select * from q6(3333456);</b>
    q6     
-----------
 Marc Chee
(1 row)



mymy2=# <b>select * from q7('COMP1511') order by term;</b>
  course  | term |     convenor     
----------+------+------------------
 COMP1511 | 17s1 | Andrew Taylor
 COMP1511 | 17s2 | Angela Finlayson
 COMP1511 | 18s1 | Andrew Taylor
 COMP1511 | 18s2 | Ashesh Mahidadia
 COMP1511 | 19T1 | Marc Chee
 COMP1511 | 19T2 | Marc Chee
 COMP1511 | 19T3 | Marc Chee
(7 rows)

mymy2=# <b>select * from q7('COMP3311') order by term;</b>
  course  | term |   convenor    
----------+------+---------------
 COMP3311 | 03s1 | John Shepherd
 COMP3311 | 03s2 | Raymond Wong
 COMP3311 | 06s1 | Wei Wang
 COMP3311 | 06s2 | John Shepherd
 COMP3311 | 07a1 | John Shepherd
 COMP3311 | 07a2 | Wei Wang
 COMP3311 | 08s1 | John Shepherd
 COMP3311 | 09s1 | John Shepherd
 COMP3311 | 10s1 | Xuemin Lin
 COMP3311 | 11s1 | John Shepherd
 COMP3311 | 12s1 | John Shepherd
 COMP3311 | 13s2 | John Shepherd
 COMP3311 | 15s1 | Xuemin Lin
 COMP3311 | 16s1 | Xuemin Lin
 COMP3311 | 17s1 | Xuemin Lin
 COMP3311 | 18s1 | Raymond Wong
 COMP3311 | 19T1 | Raymond Wong
 COMP3311 | 19T3 | John Shepherd
(18 rows)


mymy2=# select * from q8(3003876);
   code   | term | prog |         name         | mark | grade | uoc 
----------+------+------+----------------------+------+-------+-----
 COMP1911 | 15s1 | 3707 | Computing 1A         |   67 | CR    |   6
 ENGG1000 | 15s1 | 3707 | Engineering Design   |   78 | DN    |   6
 MATH1131 | 15s1 | 3707 | Mathematics 1A       |   66 | CR    |   6
 PHYS1121 | 15s1 | 3707 | Physics 1A           |   69 | CR    |   6
 COMP1921 | 15s2 | 3707 | Computing 1B         |   65 | CR    |   6
 ELEC1111 | 15s2 | 3707 | Elec & Telecomm Eng  |   64 | PS    |   6
 MATH1231 | 15s2 | 3707 | Mathematics 1B       |   59 | PS    |   6
 MMAN1300 | 15s2 | 3707 | Engineering Mechanic |   76 | DN    |   6
 MARK1012 | 16s1 | 3707 | Marketing Fundamenta |   69 | CR    |   6
 MATH2019 | 16s1 | 3707 | Engineering Mathemat |   77 | DN    |   6
 MMAN2130 | 16s1 | 3707 | Design and Manufactu |   82 | DN    |   6
 MMAN2400 | 16s1 | 3707 | Mechanics of Solids  |   71 | CR    |   6
 ECON1101 | 16s2 | 3707 | Microeconomics 1     |   61 | PS    |   6
 MMAN2100 | 16s2 | 3707 | Engineering Design 2 |   94 | HD    |   6
 MMAN2300 | 16s2 | 3707 | Engineering Mechanic |   51 | PS    |   6
 MTRN2500 | 16s2 | 3707 | Comp for MTRN        |   56 | PS    |   6
 COMP2121 | 17s1 | 3707 | Microprocessors & In |   53 | UF    |    
 ELEC2141 | 17s1 | 3707 | Digital Circuit Desi |   50 | PS    |   6
 MATH2089 | 17s1 | 3707 | Numerical Methods &  |   70 | CR    |   6
 MMAN3200 | 17s1 | 3707 | Linear Systems and C |   52 | PS    |   6
 MMAN3000 | 17s2 | 3707 | Prof. Eng. and Comm. |   64 | PS    |   6
 MMAN4410 | 17s2 | 3707 | Finite Element Metho |   68 | CR    |   6
 MTRN3020 | 17s2 | 3707 | Model & Cont of Mech |   70 | CR    |   6
 MTRN3500 | 17s2 | 3707 | Comp Appl in Mechato |   69 | CR    |   6
 MANF4611 | 18s1 | 3707 | Process Modelling &  |   68 | CR    |   6
 MMAN4010 | 18s1 | 3707 | Thesis A             |   81 | DN    |   6
 MTRN4010 | 18s1 | 3707 | Advanced Autonomous  |   65 | CR    |   6
 MTRN4110 | 18s1 | 3707 | Robot Design         |   83 | DN    |   6
 MMAN4020 | 18s2 | 3707 | Thesis B             |   95 | HD    |   6
 MTRN4030 | 18s2 | 3707 | Optim. Methods for E |   95 | HD    |   6
 MTRN4230 | 18s2 | 3707 | Robotics             |   80 | DN    |   6
 COMP2121 | 19T1 | 3707 | Microprocessors & In |   64 | PS    |   6
 MANF4430 | 19T1 | 3707 | Management for Engin |   70 | CR    |   6
          |      |      | Overall WAM/UOC      |   70 |       | 192
(34 rows)

mymy2=# <b>select * from q8(3206530);</b>
   code   | term | prog |         name         | mark | grade | uoc 
----------+------+------+----------------------+------+-------+-----
 ELEC2134 | 15s1 | 3707 | Circuits and Signals |   62 | PS    |   6
 MATH2069 | 15s1 | 3707 | Mathematics 2A       |   63 | PS    |   6
 SOLA2051 | 15s1 | 3707 | Project in PV and SE |      | SY    |   6
 SOLA2060 | 15s1 | 3707 | Intro to Elec Device |   73 | CR    |   6
 MATH2089 | 15s2 | 3707 | Numerical Methods &  |   58 | PS    |   6
 SOLA2052 | 15s2 | 3707 | Project in PV and SE |   76 | DN    |   6
 SOLA2053 | 15s2 | 3707 | Sust. & Renew. En. T |   67 | CR    |   6
 SOLA2540 | 15s2 | 3707 | Applied PV           |   71 | CR    |   6
 PHYS1160 | 16x1 | 3707 | Introduction to Astr |   85 | HD    |   6
 PHYS1221 | 16x1 | 3707 | Physics 1B           |   65 | CR    |   6
 MATH2019 | 16s1 | 3707 | Engineering Mathemat |   67 | CR    |   6
 SOLA3507 | 16s1 | 3707 | Solar Cells          |   58 | PS    |   6
 SOLA4012 | 16s1 | 3707 | Grid-Connect PV Syst |   67 | CR    |   6
 SOLA5057 | 16s1 | 3707 | Energy Efficiency    |   83 | DN    |   6
 GENC3004 | 16s2 | 3707 | Personal Finance     |   73 | CR    |   6
 SOLA3010 | 16s2 | 3707 | Low Energy Buildings |   68 | CR    |   6
 SOLA3020 | 16s2 | 3707 | PV Technology & Manu |   52 | PS    |   6
 SOLA5054 | 16s2 | 3707 | PV Stand-Alone Sys.  |   79 | DN    |   6
 ELEC3115 | 17s1 | 3707 | Electromagnetic Engi |   56 | PS    |   6
 ELEC9714 | 17s1 | 3707 | Electricity Industry |   79 | DN    |   6
 SOLA4910 | 17s1 | 3707 | Thesis Part A        |      | SY    |   6
 ELEC4122 | 17s2 | 3707 | Strategic Leadership |   65 | CR    |   6
 SOLA4911 | 17s2 | 3707 | Thesis Part B        |   90 | HD    |   6
 SOLA5051 | 17s2 | 3707 | Life Cycle Assessmen |   52 | PS    |   6
          |      |      | Overall WAM/UOC      |   69 |       | 144
(25 rows)

mymy2=# <b>select * from q8(3216260);</b>
   code   | term | prog |         name         | mark | grade | uoc 
----------+------+------+----------------------+------+-------+-----
 COMP1511 | 17s1 | 3778 | Introduction to Prog |   92 | HD    |   6
 ENGG1000 | 17s1 | 3778 | Engineering Design   |   90 | HD    |   6
 MATH1131 | 17s1 | 3778 | Mathematics 1A       |   54 | PS    |   6
 PHYS1121 | 17s1 | 3778 | Physics 1A           |   52 | PS    |   6
 COMP1531 | 17s2 | 3778 | Software Eng Fundame |   85 | HD    |   6
 COMP2521 | 17s2 | 3778 | Data Structures and  |   87 | HD    |   6
 MATH1081 | 17s2 | 3778 | Discrete Mathematics |   76 | DN    |   6
 MATH1231 | 17s2 | 3778 | Mathematics 1B       |   83 | DN    |   6
 COMP1521 | 18s1 | 3778 | Computer Systems Fun |   76 | DN    |   6
 COMP2511 | 18s1 | 3778 | O-O Design & Program |   72 | CR    |   6
 COMP3121 | 18s1 | 3778 | Algorithms & Program |   86 | HD    |   6
 PHYS1160 | 18s1 | 3778 | Introduction to Astr |   95 | HD    |   6
 COMP3331 | 18s2 | 3778 | Computer Networks&Ap |   84 | DN    |   6
 COMP3421 | 18s2 | 3778 | Computer Graphics    |   92 | HD    |   6
 COMP9444 | 18s2 | 3778 | Neural Networks      |   95 | HD    |   6
 COMP3231 | 19T1 | 3778 | Operating Systems    |   86 | HD    |   6
 COMP3311 | 19T1 | 3778 | Database Systems     |   94 | HD    |   6
 COMP3411 | 19T1 | 3778 | Artificial Intellige |   87 | HD    |   6
 COMP6441 | 19T2 | 3778 | Security Engineering |   79 | DN    |   6
 COMP9417 | 19T2 | 3778 | Machine Learning & D |   68 | CR    |   6
 COMP9517 | 19T2 | 3778 | Computer Vision      |   81 | DN    |   6
 COMP3900 | 19T3 | 3778 | Computer Science Pro |   70 | CR    |   6
 COMP4920 | 19T3 | 3778 | Professional Issues  |   76 | DN    |   3
 COMP6733 | 19T3 | 3778 | Internet of Things   |   80 | DN    |   6
          |      |      | Overall WAM/UOC      |   81 |       | 141
(25 rows)


mymy2=# <b>select * from q9(1144) order by objcode;</b>
 objtype | objcode  
---------+----------
 subject | CHEM1011
 subject | CHEM1031
 subject | COMP1911
 subject | ENGG1000
 subject | ENGG1811
 subject | MATH1131
 subject | MATH1141
 subject | MATH1231
 subject | MATH1241
 subject | MATS1101
 subject | PHYS1121
 subject | PHYS1131
(12 rows)

mymy2=# <b>select * from q9(112270) order by objcode;</b>
 objtype | objcode 
---------+---------
 program | 5231
 program | 5499
 program | 5740
 program | 5750
 program | 7339
 program | 8619
 program | 9200
 program | 9210
 program | 9220
 program | 9230
 program | 9231
(11 rows)

mymy2=# <b>select * from q9(119393) order by objcode;</b>
 objtype | objcode  
---------+----------
 subject | DPST1013
 subject | DPST1023
 subject | MATH1131
 subject | MATH1141
 subject | PHYS1121
 subject | PHYS1131
 subject | PHYS1141
(7 rows)

mymy2=# <b>select * from q9(119460) order by objcode;</b>
 objtype | objcode  
---------+----------
 subject | CVEN1300
 subject | DPST1072
 subject | ENGG1300
 subject | MATH2011
 subject | MATH2018
 subject | MATH2019
 subject | MATH2069
 subject | MATH2111
 subject | MATH2121
 subject | MATH2221
 subject | MINE1300
 subject | MMAN1300
(12 rows)


mymy2=# <b>select q10('COMP6080') order by q10;</b>
 q10 
-----
(0 rows)

mymy2=# <b>select q10('COMP1511') order by q10;</b>
   q10    
----------
 COMP1521
 COMP1531
 COMP1927
 COMP2041
 COMP2111
 COMP2121
 COMP2521
 COMP9334
 ELEC2117
(9 rows)

mymy2=# <b>select q10('COMP3311') order by q10;</b>
   q10    
----------
 COMP4314
 COMP9313
 COMP9315
 COMP9318
 COMP9321
 COMP9323
(6 rows)

mymy2=# <b>select q10('COMP2521') order by q10;</b>
   q10    
----------
 COMP2511
 COMP2911
 COMP3121
 COMP3141
 COMP3151
 COMP3161
 COMP3231
 COMP3311
 COMP3331
 COMP3411
 COMP3431
 COMP3821
 COMP3891
 COMP3900
 COMP4141
 COMP6451
 COMP6452
 COMP6714
 COMP6721
 COMP6841
 COMP9313
 COMP9315
 COMP9318
 COMP9319
 COMP9417
 COMP9444
 COMP9517
 COMP9844
(28 rows)

</pre>
<?=endPage()?>
