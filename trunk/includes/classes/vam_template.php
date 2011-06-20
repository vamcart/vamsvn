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

   function vamTemplate()
   {

        $this->Smarty();

        $this->template_dir = DIR_FS_CATALOG . 'templates';
        $this->compile_dir = DIR_FS_CATALOG . 'cache';
        $this->config_dir   = DIR_FS_CATALOG . 'lang';
        $this->cache_dir    = DIR_FS_CATALOG . 'cache';
        $this->plugins_dir = array(
        DIR_FS_CATALOG.'includes/external/smarty/plugins',
        DIR_FS_CATALOG.'includes/external/smarty/plugins_vam',
        );

        $this->assign('app_name', 'vamTemplate');

   }

}

?>