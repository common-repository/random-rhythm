<?php 
/*
Plugin Name: Random Rhythm
Plugin URI: http://www.woodymood-dev.net/cms/wordpress/en/2009/04/26/generateur-aleatoire-rythmes-de-guitare/
Description: Random generator of guitar rhythms 
Version: 0.3.2
Author: Anthony Dubois
Author URI: http://www.woodymood-dev.net/cms/wordpress/en/lauteur/
*/

/*  Copyright 2009  ANTHONY DUBOIS  (email : dev@woodymood-dev.net)

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

require_once('random_rhythm_func.php');

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) { 
	$results = addslashes(random_rhythm(true));
	die( "document.getElementById('randomrhythminner').innerHTML = '$results'" );
}
?>