<?php

require_once (DIR_WS_INCLUDES . 'external/smarty/Smarty.class.php');

class vamTemplate extends Smarty {

   function vamTemplate()
   {

        $this->Smarty();

        $this->template_dir = DIR_FS_CATALOG . 'templates';
        $this->compile_dir = DIR_FS_CATALOG . 'templates_c';
        $this->config_dir   = DIR_FS_CATALOG . 'lang';
        $this->cache_dir    = DIR_FS_CATALOG . 'cache';
        $this->plugins_dir = array(
        DIR_WS_INCLUDES . 'includes/external/smarty/plugins',
        DIR_WS_INCLUDES . 'includes/external/smarty/plugins_vam',
        );

        $this->assign('app_name', 'vamTemplate');
   }

}

?>