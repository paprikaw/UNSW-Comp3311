<? require("../../course.php"); require("defs.php"); ?>
<?=startPage("Assignment 3","","Sample Outputs")?>
<?=updateBlurb().scriptMenu($menu)?>

<br>
<p>
The following give some sample inputs and outputs that you can use to
estimate the correctness of your scripts
These examples are by no means exhaustive, and more cases will be used
in the auto-marking, so it is up to you to perform comprehensive checking
of your solution.
</p>
<p>
Warning: sometimes, non-ascii characters don't render the same on
this web page as they do in a terminal window.
</p>

<pre>
# Highest Rated Movies (best)

grieg$ <b>./best</b>
9.8 Randhawa (2019)
9.6 Fan (2019)
9.6 Mama's Heart. Gongadze (2017)
9.5 Ananthu V/S Nusrath (2018)
9.5 Family of Thakurganj (2019)
9.5 Hare Krishna! The Mantra, the Movement and the Swami Who Started It All (2017)
9.5 Yeh Suhaagraat Impossible (2019)
9.4 Eghantham (2018)
9.4 Jibon Theke Neya (1970)
9.4 Shibu (2019)

grieg$ <b>./best 20</b>
9.8 Randhawa (2019)
9.6 Fan (2019)
9.6 Mama's Heart. Gongadze (2017)
9.5 Ananthu V/S Nusrath (2018)
9.5 Family of Thakurganj (2019)
9.5 Hare Krishna! The Mantra, the Movement and the Swami Who Started It All (2017)
9.5 Yeh Suhaagraat Impossible (2019)
9.4 Eghantham (2018)
9.4 Jibon Theke Neya (1970)
9.4 Shibu (2019)
9.4 The Chaos Class (1975)
9.3 That Vitamin Movie (2016)
9.3 The Shawshank Redemption (1994)
9.3 Truth and Justice (2019)
9.3 Wheels (2014)
9.2 Aloko Udapadi (2017)
9.2 Ardaas Karaan (2019)
9.2 Aynabaji (2016)
9.2 CM101MMXI Fundamentals (2013)
9.2 Dokyala Shot (2019)

grieg$ <b>./best xyz</b>
Usage: best [N]


# Alternative Releases (aliases) for a Movie (rels)

grieg$ <b>./rels</b>
Usage: rels 'PartialMovieTitle'

grieg$ <b>./rels xyzzy</b>
No movie matching 'xyzzy'

grieg$ <b>./rels ocean</b>
Movies matching 'ocean'
===============
711 Ocean Drive (1950)
Ocean's 11 (1960)
The Deep End of the Ocean (1999)
Ocean's Eleven (2001)
Ocean's Twelve (2004)
Ocean's Thirteen (2007)
Oceans (2009)
Ocean Heaven (2010)
Planet Ocean (2012)
A Plastic Ocean (2016)
The Light Between Oceans (2016)
Ocean's Eight (2018)

grieg$ <b>./rels "Ocean's Eleven"</b>
Ocean's Eleven (2001) was also released as
'11' (region: US)
'O11' (region: US)
'Ocean's 11' (region: US)
'I symmoria ton enteka' (region: GR)
'La gran estafa' (region: UY)

grieg$ <b>./rels 'Lemonade Joe'</b>
Lemonade Joe (1964) was also released as
'Joe, o lemonadas' (region: GR)
'Joe, o tromokratis' (region: GR)
'Konská opera' (region: CSHH, language: cs)
'Limonadovy Joe' (region: CSHH, language: cs)
'Lemonade Joe or Horse Opera' (region: XWW, language: en)
'Revolveras iz Arizone' (region: XYU, language: sr)

grieg$ <b>./rels 'Ne Zha'</b>
Ne Zha (2019) was also released as
'Nezha' (region: XWW, language: en)
'Nezha: Birth of the Demon Child' (region: XWW, language: en)
'Nezha' (region: HK, language: en)
'Nezha' (region: XAS, language: en)
'Naazaa' (region: CN, language: yue)
'Nezha' (region: XAS, language: cmn)
'Nezha' (region: US)
'Nezha' (region: CA, language: en)
'Nezha' (region: MY, language: cmn)
'Nezha' (region: TW)
'Nezha' (region: HK, language: cmn)
'Nezha' (region: SG, language: cmn)
'Naazaa' (region: HK, language: yue)
'Nezha' (region: CN, language: cmn)
'Birth of the Demon Child Nezha' (region: XWW, language: en)


# Movie Information (minfo)

grieg$ <b>./minfo xyzzy</b>
No movie matching 'xyzzy'

grieg$ <b>./minfo 'Avatar'</b>
Avatar (2009)
===============
Starring
 Sam Worthington as Jake Sully
 Zoe Saldana as Neytiri
 Sigourney Weaver as Dr. Grace Augustine
 Michelle Rodriguez as Trudy Chacón
and with
 James Cameron: Director
 James Cameron: Writer
 Jon Landau: Producer
 James Horner: Composer
 Mauro Fiore: Cinematographer
 John Refoua: Editor
 Stephen E. Rivkin: Editor

grieg$ <b>./minfo 'The Ring'</b>
Movies matching 'The Ring'
===============
The Ring (1952)
Again the Ringer (1965)
The Ring-necked Dove (1970)
The Lord of the Rings (1978)
The Lord of the Rings: The Fellowship of the Ring (2001)
The Lord of the Rings: The Two Towers (2002)
The Ring (2002)
The Lord of the Rings: The Return of the King (2003)
The Ring Finger (2005)
Closing the Ring (2007)

grieg$ <b>./minfo '^The Ring$' 2002</b>
The Ring (2002)
===============
Starring
 Naomi Watts as Rachel
 Martin Henderson as Noah
 Brian Cox as Richard Morgan
 David Dorfman as Aidan
and with
 Gore Verbinski: Director
 Ehren Kruger: Writer
 Kôji Suzuki: Writer
 Hiroshi Takahashi: Writer
 Laurie MacDonald: Producer
 Walter F. Parkes: Producer

grieg$ <b>./minfo 'return of the king'</b>
The Lord of the Rings: The Return of the King (2003)
===============
Starring
 Elijah Wood as Frodo
 Viggo Mortensen as Aragorn
 Ian McKellen as Gandalf
 Orlando Bloom as Legolas
and with
 Peter Jackson: Director
 Peter Jackson: Writer
 J.R.R. Tolkien: Writer
 Fran Walsh: Writer
 Philippa Boyens: Writer
 Barrie M. Osborne: Producer
 Howard Shore: Composer

grieg$ <b>./minfo 'strangelove' 1964</b>
Dr. Strangelove or: How I Learned to Stop Worrying and Love the Bomb (1964)
===============
Starring
 Peter Sellers as Dr. Strangelove
 Peter Sellers as Group Capt. Lionel Mandrake
 Peter Sellers as President Merkin Muffley
 George C. Scott as Gen. 'Buck' Turgidson
 Sterling Hayden as Brig. Gen. Jack D. Ripper
 Keenan Wynn as Col. 'Bat' Guano
and with
 Stanley Kubrick: Director
 Stanley Kubrick: Writer
 Terry Southern: Writer
 Peter George: Writer
 Laurie Johnson: Composer
 Gilbert Taylor: Cinematographer
 Anthony Harvey: Editor

grieg$ <b>./minfo 'stars' xyzzy</b>
Usage: minfo 'MovieTitlePattern' [Year]

grieg$ <b>./minfo 'return of the king' 1234</b>
No movie matching 'return of the king' 1234

grieg$ <b>./minfo ring 2002</b>
Movies matching 'ring' 2002
===============
On the Occasion of Remembering the Turning Gate (2002)
Ringeraja (2002)
Springtime in a Small Town (2002)
The Lord of the Rings: The Two Towers (2002)
The Ring (2002)



# Biography/Filmography for a Name  (bio)

grieg$ <b>./bio</b>
Usage: bio 'NamePattern' [Year]

grieg$ <b>./bio xyzzy</b>
No name matching 'xyzzy'

grieg$ <b>./bio 'Kyle MacLachlan'</b>
Filmography for Kyle MacLachlan (1959-)
===============
Dune (1984)
 playing Paul Atreides
Blue Velvet (1986)
 playing Jeffrey Beaumont
The Hidden (1987)
 playing Lloyd Gallagher
The Boyfriend School (1990)
 playing Trout
The Doors (1991)
 playing Ray Manzarek
Rich in Love (1992)
 playing Billy McQueen
The Trial (1993)
 playing Josef K.
Touch of Pink (2004)
 playing Spirit of Cary Grant
Mao's Last Dancer (2009)
 playing Charles Foster
The House with a Clock in Its Walls (2018)
 playing Isaac Izard

grieg$ <b>./bio 'jacques tati'</b>
Filmography for Jacques Tati (1907-1982)
===============
Monsieur Hulot's Holiday (1953)
 playing Monsieur Hulot
 as Director
 as Writer
Mon Oncle (1958)
 playing Monsieur Hulot
 as Director
 as Writer
Playtime (1967)
 playing Monsieur Hulot
 as Director
 as Writer
Trafic (1971)
 playing Monsieur Hulot
 as Director
 as Writer
The Illusionist (2010)
 as Writer

grieg$ <b>./bio 'spike lee'</b>
Filmography for Spike Lee (1957-)
===============
She's Gotta Have It (1986)
 playing Mars Blackmon
 as Director
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
Jungle Fever (1991)
 playing Cyrus
 as Director
 as Writer
Malcolm X (1992)
 playing Shorty
 as Director
 as Writer
Crooklyn (1994)
 as Director
 as Writer
Clockers (1995)
 as Director
 as Writer
Get on the Bus (1996)
 as Director
4 Little Girls (1997)
 as Director
He Got Game (1998)
 as Director
 as Writer
Summer of Sam (1999)
 as Director
 as Writer
The Best Man (1999)
 as Producer
Bamboozled (2000)
 as Director
 as Writer
Love & Basketball (2000)
 as Producer
The Original Kings of Comedy (2000)
 as Director
25th Hour (2002)
 as Director
Ten Minutes Older: The Trumpet (2002)
 as Director
All the Invisible Children (2005)
 as Director
Inside Man (2006)
 as Director
Miracle at St. Anna (2008)
 as Director
Bad 25 (2012)
 as Director
Michael Jackson's Journey from Motown to Off the Wall (2016)
 as Director
Amazing Grace (2018)
 as Producer
BlacKkKlansman (2018)
 as Director
 as Writer
Pavarotti (2019)
 playing Himself
 as Archive footage

</pre>

<?=endPage()?>
