<?php
/*
Plugin Name: Random Rhythm
Plugin URI: http://www.woodymood-dev.net/cms/wordpress/en/2009/04/26/generateur-aleatoire-rythmes-de-guitare/
Description: Random generator of guitar rhythms 
Version: 0.4
Author: Anthony Dubois
Author URI: http://www.woodymood-dev.net/cms/wordpress/en/lauteur/
*/

/*  Copyright 2009-2010  ANTHONY DUBOIS  (email : dev@woodymood-dev.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/*******************************************************************


				template tag


********************************************************************/

if ( function_exists('random_rhythm') == false ) { 

	function random_rhythm($ajax = false) {
	
		$path = substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
		$path = substr($path,0,strlen($path)-7) . 'images/';
		
		// un tableau avec les images des figures rythmiques sur 1 temps
		$images = array();
		$images['I'] = '<img src="' . $path . 'noire.png" width="25" height="46" />';
		$images['II'] = '<img src="' . $path . 'croche_croche.png" width="30" height="46" />';
		$images['_II'] = '<img src="' . $path . 'crocheliee_croche.png" width="32" height="46" />';
		$images['I;'] = '<img src="' . $path . 'croche_demisoupir.png" width="30" height="46" />';
		$images[';I'] = '<img src="' . $path . 'demisoupir_croche.png" width="30" height="46" />';
		$images['IDD'] = '<img src="' . $path . 'croche_double_double.png" width="36" height="46" />';
		$images['DDI'] = '<img src="' . $path . 'double_double_croche.png" width="36" height="46" />';
		$images['DDDD'] = '<img src="' . $path . 'double_double_double_double.png" width="41" height="46" />';
		$images['DID'] = '<img src="' . $path . 'double_croche_double.png" width="34" height="46" />';
		$images['DD;'] = '<img src="' . $path . 'double_double_demisoupir.png" width="36" height="46" />';
		$images[';DD'] = '<img src="' . $path . 'demisoupir_double_double.png" width="36" height="46" />';
		
		// un tableau de correspondance entre les chiffres et les images
		$types_cellules = array(
		"5"=>'I', 
		"1"=>'_II', 
		"7" => "II", 
		"a" => "I;", 
		"4" => ";I", 
		"0" => "IDD", 
		"6" => "DDI", 
		"2" => "DDDD",
		"8" => "DID",
		"9" => "DD;",
		"3" => ";DD"
		);
		
		// la durée de la mesure est fixée à 4, pourrait etre une option du plugin
		$duree_mesure = 4;
		
		// le nombre total de possibilités
		//                   base                    exposant
		$possibilites = pow(sizeof($types_cellules),$duree_mesure);
		
		$ret = "\n<!-- $possibilites possibilites -->";
		
		// on prend un nombre au hasard parmis les possibilites
		$t = mt_rand(0, ($possibilites-1));
		
		$ret .= "\n<!-- $t nombre au hasard -->";
			
		if ( sizeof($types_cellules) == 1 ) {
			$str = '0';
		}
		else {
			// on va compter dans une autre base
			// conversion de nombre from    to
			$new_base = sizeof($types_cellules);
			$str = base_convert($t, 10, $new_base);
			$ret .= "\n<!-- $t en base $new_base donne $str -->";
		}
		
		// ajouter les zeros
		// le nombre dans sa base aura autant de chiffres qu'on a de mesures
		$reste = $duree_mesure - strlen($str);		
		$ajout = '';		
		for ( $i=1; $i<=$reste; $i++ ) {
			$ajout .= '0';
		}		
		$str = $ajout . $str;
		$ret .= "\n<!-- avec les zeros ça donne $str -->";
		// fin ajout des zeros
		
		
		$part1 = 
		'
		<style type="text/css">
		#randomrhythm {
			margin:0px; padding:0px;
		}
		#randomrhythm table {
			margin:0px; padding:0px; border:none; height:46px; background:url(' . $path . 'bg_grille.png); background-repeat: repeat-x; background-position: left top;	
		}
		#randomrhythm table tr td {
			padding:0px; height:46px;	
		}
		#randomrhythm p {
			font-size:smaller;
		}
		</style>
		<div id="randomrhythm">
		<table cellpadding="0" cellspacing="0" border="0" height="46">
		<tr height="46">
		<td align="left" valign="top">
		<div id="randomrhythminner">';
		
		
		$part2 = '<img src="' . $path . 'barre.png" width="1" height="46" /><img src="' . $path . '44.png" width="15" height="46" />';
		
		
		// boucle sur le nombre de temps
		for( $i=0; $i<$duree_mesure; $i++ ) {
			$car = $str[$i];
			$part2 .= $images[$types_cellules[$car]];
		}
		
		
		$part2 .= '<img src="' . $path . 'barre.png" width="1" height="46" />';
		
		$part3 = '
		</div>
		</td>
		</tr>
		</table>
		<p><a href="#randomrhythmrefresh" onclick="random_rhythm_refresh();">Refresh</a></p>
		</div>
		';
		
		if ( $ajax == true ) return $part2;
		else return $part1 . $part2 . $part3;
	
	}
	
}
?>