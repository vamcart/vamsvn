<?php
/*
If you wish to change CaRP's default configuration values, we recommeng doing
it in this file rather than modifying carp.php. That way, when you upgrade to
a new version, you won't need to copy your override settings into the new
version.

See the online documentation for details.
http://www.geckotribe.com/rss/carp/manual/
*/
defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
function MyCarpConfReset($set='default') {
	global $carpconf;
	CarpConfReset();
	
	// Override any settings you wish to change here
	
	
	
	// Create alternative configuration sets here
	if ($set=='default') {
		
	} else if ($set=='style1') {
		
	}
}
MyCarpConfReset();
?>