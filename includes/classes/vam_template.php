<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_template.php 899 2007-10-13 20:14:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
require_once (DIR_FS_CATALOG.'includes/external/smarty/Smarty.class.php');

class vamTemplate extends Smarty {

   function __construct()
   {

        // Class Constructor.
        // These automatically get set with each new instance.

        parent::__construct();

        $this->setTemplateDir(DIR_FS_CATALOG . 'templates');
        $this->setCompileDir(DIR_FS_CATALOG . 'cache');
        $this->setConfigDir(DIR_FS_CATALOG . 'lang');
        $this->setCacheDir(DIR_FS_CATALOG . 'cache');

        $this->setPluginsDir(array(
        DIR_FS_CATALOG.'includes/external/smarty/plugins',
        DIR_FS_CATALOG.'includes/external/smarty/plugins_vam',
        ));
        
        //$this->caching = Smarty::CACHING_LIFETIME_CURRENT;

        // Minify HTML
        $this->loadFilter('output', 'minify_html');

        
        $this->assign('app_name', 'vamTemplate');
   }

}
?>