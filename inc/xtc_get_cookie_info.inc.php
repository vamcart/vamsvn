<?php
/* -----------------------------------------------------------------------------------------
$Id: xtc_get_cookies_info.inc.php 1535 2006-11-26 21:38:20Z mz $

@author Andrey Chorniy
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

/**
 * Enter description here...
 *
 * @return cookie info array, which
 */
function xtc_get_cookie_info () {

    if (defined('HTTP_COOKIE_DOMAIN')){
        $cookie_domain = HTTP_COOKIE_DOMAIN;
    } else {
        //use alternative way to determine domain
        $request_type = (getenv('HTTPS') == '1' || getenv('HTTPS') == 'on') ? 'SSL' : 'NONSSL';
        $current_domain = (($request_type == 'NONSSL') ? HTTP_SERVER : HTTPS_SERVER);
        if (strpos($current_domain, '://')) {
            $parsed_url = parse_url($current_domain);
            $current_domain = $parsed_url['host'];
        } else {
            //try to parse not fully configured domain string
            $parsed_url = parse_url($current_domain);
            if ($parsed_url){
                $current_domain = $parsed_url['host'];
            }
        }
        $domain_array = explode('.', $current_domain);
        if (sizeof($domain_array) > 1){
            $cookie_domain = $current_domain;
        } else {
            $cookie_domain = '';
        }
    }
    
    if (!xtc_not_null($cookie_domain)){
        $cookie_domain = '';
    }


    if (defined('HTTP_COOKIE_PATH')){
        $cookie_path = HTTP_COOKIE_PATH;
    } else {
        //use default cookie path
        $cookie_path = '/';
    }

    
    $cookie_info = array('cookie_domain' => $cookie_domain,
                         'cookie_path' => $cookie_path);

    return $cookie_info;
}
?>