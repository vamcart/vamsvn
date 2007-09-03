<?php

require_once (DIR_WS_INCLUDES . 'external/smarty/Smarty.class.php');

class vamTemplate extends Smarty {

   function vamTemplate()
   {

        $this->Smarty();

        $this->template_dir = HOME_DIR . '/templates/test/';
        $this->compile_dir = HOME_DIR . '/templates_c/';
        $this->config_dir   = HOME_DIR . '/configs/';
        $this->cache_dir    = HOME_DIR . '/cache/';
        $this->plugins_dir = array(
        HOME_DIR . '/includes/external/smarty/plugins',
        HOME_DIR . '/includes/external/smarty/plugins_vam',
        );

        $this->assign('app_name', 'vamTemplate');
   }

}

$vamTemplate = new vamTemplate;

?>