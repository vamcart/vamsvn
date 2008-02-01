<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_show_category.inc.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com
   (c) 2003	 nextcommerce (vam_show_category.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (vam_show_category.inc.php,v 1.4 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------------------------------- 
	GUNNART "SHOW_CATEGORY ADVANCED"
	
	erweiterte Kategorien-Navigation fьr xt:Commerce 3.04 SP1 / SP2.1

 	Proudly togetherfummeled by Gunnar Tillmann
 	http://www.gunnart.de
 	Version 0.3 Beta / 12. Juli 2007 
 	- Bugfix 1, Danke fьr's Testen, Sandi 
 	- Bugfix 2, Danke fьr den Hinweis, Krischan 
   --------------------------------------------------------------------

   
   --------------------------------------------------------------------
	1) BESONDERHEITEN
	
	Mit dieser neuen Kategorien-Navigation fьr xt:Commerce kann man 
	a) Leere Kategorien verstecken
	b) Bestimmen, wie weit der Kategorien-Baum von Anfang an 
	   "ausgeklappt" sein soll
	c) Festlegen, ob sich der Kategorien-Baum trotz einer festgelegten
	   "Beschrдnkung" unterhalb von aktiven Kategorien weiter
	   ausklappen kann
	
	Die HTML-Ausgabe erfolgt als hierarchische Liste
   --------------------------------------------------------------------

   
   --------------------------------------------------------------------
	2) ANLEITUNG / KONFIGURATION
	
	Sie kцnnen die Navigation nach Ihren Wьnschen anpassen. 
	In den Zeilen 96 bis 98 finden Sie 3 Variablen, mit denen das 
	Verhalten der Kategorien-Liste bestimmt werden kann.
   --------------------------------------------------------------------
	a) "TIEFE" DER NAVIGATION BESTIMMEN 

		$MaxLevel 	=	Zahl von 1 bis 5 oder false
	
		false:		=	Alle Kategorie-Ebenen werden angezeigt
		3:			=	Es werden alle Kategorien bis einschlieЯlich  
						der "dritten Ebene" gezeigt
   --------------------------------------------------------------------
	b) LEERE KATEGORIEN VERSTECKEN:
	
		$HideEmpty	=	true oder false
	
		true		= 	Leere Kategorien werden nicht angezeigt
		false		= 	Leere Kategorien werden angezeigt
   --------------------------------------------------------------------
	c) "UNTERKATEGORIEN AKTIVER KATEGORIEN" ANZEIGEN:
	
		$ShowAktSub	=	true oder false
	
		true		= 	Wenn man seine Kategorien z.B. bis zur zweiten 
						Ebene "aufklappt" und dann eine Kategorie der 
						zweiten Ebene anwдhlt, werden die enthaltenen
						Unterkategorien der dritten Ebene angezeigt
		false		= 	Es werden NUR die Kategorie-Ebenen angezeigt, 
						die man mit $MaxLevel bestimmt hat
   --------------------------------------------------------------------

   
   --------------------------------------------------------------------
	BITTE BEACHTEN SIE: 

	1) Der Einsatz dieser Kategorien-Navi geschieht auf eigene Gefahr! 
	2) Jegliche Haftung fьr Schдden an Ihrem System oder Verdienst-
	Ausfдlle wird abgelehnt 
	3) Ich empfehle dringend, diese Erweiterung VOR einem produktiven
	Einsatz zunдchst an einem Test-System auszuprobieren!
   --------------------------------------------------------------------

   
   --------------------------------------------------------------------
	IN EIGENER SACHE:
	
	Diese Funktionen wurden kostenlos und ohne Anspruch auf Gegen-
	leistung zur Verfьgung gestellt. Ich bitte allerdings darum, den 
	Autoren-Hinweis intakt zu lassen bzw. bei Bearbeitungen mit zu 
	ьbernehmen. 
	
	Ein Backlink zu meiner Website http://www.gunnart.de wьrde mich 
	natьrlich auch freuen.
	
	Vielen Dank
	
	Gunnar Tillmann 
   --------------------------------------------------------------------
	Feedback is Welcome: http://www.gunnart.de?p=311
   --------------------------------------------------------------------
*/

// KONFIGURATION
global $MaxLevel, $HideEmpty, $ShowAktSub;

	$MaxLevel = 1;
	$HideEmpty = false;
	$ShowAktSub = true;

function vam_show_category($cid, $level, $foo, $cpath) {

	global $old_level, $categories_string; //, $HTTP_GET_VARS; // Brauchen wir nicht
	global $MaxLevel, $HideEmpty, $ShowAktSub;

	// 1) Ьberprьfen, ob Kategorie Produkte enthдlt
	$Empty = true;
	$pInCat = vam_count_products_in_category($cid);
	if ($pInCat > 0)
		$Empty = false;
	
	// 2) Ьberprьfen, ob Kategorie gezeigt werden soll
	$Show = false;
	if ($HideEmpty) {
		if (!$Empty)
			$Show = true;
	} else {
		$Show = true;
	}

	// 3) Ьberprьfen, ob Unterkategorien gezeigt werden sollen
	$ShowSub = false;
	if ($MaxLevel) {
		if ($level < $MaxLevel)
			$ShowSub = true;
	} else {
		$ShowSub = true;
	}
				
	if($Show) { // Wenn Kategorie gezeigt werden soll ....
	
		if ($cid != 0) {
			
			// 24.06.2007 BugFix
			// Auf "product_info"-Seiten wurde Kategorie nicht erkannt 
			// $category_path = explode('_',$HTTP_GET_VARS['cPath']);
			$category_path = explode('_',$GLOBALS['cPath']); 
			$in_path = in_array($cid, $category_path);
			$this_category = array_pop($category_path);
		
			for ($a = 0; $a < $level; $a++)                           ;
			
			// Produktzдhlung
			$ProductsCount = false;
			// Lange gerдtselt, aber das ist tatsдchlich 
			// ein String und kein Boolean.                                                                                
			if (SHOW_COUNTS == 'true') 
				$ProductsCount = ' <em>(' . $pInCat . ')</em>';	
                                                  
			// Aktiv - Nicht Aktiv
			$Aktiv = false;
			if ($this_category == $cid) 
				// Wenn Kategorie aktiv ist
				$Aktiv = ' Current'; 
			elseif ($in_path) 
				// Wenn Oberkategorie aktiv ist
				$Aktiv = ' CurrentParent'; 
	
			// Hat ein SubMenue - hat kein SubMenue
			// CSS-Klasse festlegen
			$SubMenue = false;
			if (vam_has_category_subcategories($cid)) 
				$SubMenue = " SubMenue";
			
			// Listenpunkt
			// CSS-Klasse festlegen
			$MainStyle = 'CatLevel'.$level;
			
			// Quelltext einrьcken
			$Tabulator = str_repeat("\t",$level-1);
	
			// Navigations-Liste ist jetzt hierarchisch!
			if($old_level) { 
				if ($old_level < $level) {
					$Pre = "\n<ul>";
					$Pre = str_replace("\n","\n".$Tabulator, $Pre)."\n";
				} else {
					$Pre = "</li>\n";
					if ($old_level > $level) {
						// Listenpunkte schlieЯen
						// Quelltext einrьcken
						for ($counter = 0; $counter < $old_level - $level; $counter++) {
							$Pre .= str_repeat("\t", $old_level - $counter -1)."</ul>\n".str_repeat("\t", $old_level - $counter- 2)."</li>\n";
						}
					}
				} 
			}
				
			// Listenpunkte zusammensetzen
			$categories_string .=	$Pre.$Tabulator.
									'<li class="'.$MainStyle.$SubMenue.$Aktiv.'">'.
									// Bugfix, 12. Juli 2007
									//'<a href="' . vam_href_link(FILENAME_DEFAULT, 'cPath=' . $cpath . $cid) . '">'.
									'<a href="' . vam_href_link(FILENAME_DEFAULT, vam_category_link($cid, $foo[$cid]['name']) ) . '">'.
									$foo[$cid]['name'].$ProductsCount.
									'</a>';
		}
		
		// fьr den nдchsten Durchgang ...
		$old_level = $level;
	
		// Unterkategorien durchsteppen
		foreach ($foo as $key => $value) {
	
			if ($foo[$key]['parent'] == $cid) {
					
				// Sollen Unterkategorien gezeigt werden?
				if ($ShowAktSub && $Aktiv)
					$ShowSub = true;
				
				if ($ShowSub) 
					vam_show_category($key, $level+1, $foo, ($level != 0 ? $cpath . $cid . '_' : ''));
			} 
		}
	} // Ende if($Show)
} 		
?>