<?php
/* -----------------------------------------------------------------------------------------
   $Id: selfpickup.php 1306 2007-02-06 21:19:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(freeamount.php,v 1.01 2002/01/24); www.oscommerce.com 
   (c) 2003	 nextcommerce (freeamount.php,v 1.12 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (freeamount.php,v 1.12 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   selfpickup         	Autor:	sebthom

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

class selfpickup
{
    var $code, $title, $description, $icon, $enabled;

    function selfpickup()
    {

      global $order;

        $this->code        = 'selfpickup';
        $this->title       = MODULE_SHIPPING_SELFPICKUP_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_SELFPICKUP_TEXT_DESCRIPTION;
        $this->icon        = '';   // change $this->icon =  DIR_WS_ICONS . 'shipping_ups.gif'; to some freeshipping icon
        $this->tax_class = MODULE_SHIPPING_SELFPICKUP_TAX_CLASS;
        $this->sort_order  = MODULE_SHIPPING_SELFPICKUP_SORT_ORDER;
        $this->enabled = ((MODULE_SHIPPING_SELFPICKUP_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_SELFPICKUP_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_SELFPICKUP_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = vam_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

    function quote($method = '')
    {
        $this->quotes = array(
            'id' => $this->code,
            'module' => MODULE_SHIPPING_SELFPICKUP_TEXT_TITLE
        );

        $this->quotes['methods'] = array(array(
            'id'    => $this->code,
            'title' => MODULE_SHIPPING_SELFPICKUP_TEXT_WAY,
            'cost'  => 0
        ));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

        if(vam_not_null($this->icon))
        {
            $this->quotes['icon'] = vam_image($this->icon, $this->title);
        }

        return $this->quotes;
    }

    function check()
    {
        $check = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_SELFPICKUP_STATUS'");
        $check = vam_db_num_rows($check);

        return $check;
    }

    function install() 
    {
        vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_SELFPICKUP_STATUS', 'True', '6', '7', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
        vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SELFPICKUP_ALLOWED', '', '6', '0', now())");
        vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_SELFPICKUP_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
        vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_SELFPICKUP_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
        vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SELFPICKUP_SORT_ORDER', '0', '6', '4', now())");
    }

    function remove()
    {
        vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys()
    {
        return array('MODULE_SHIPPING_SELFPICKUP_STATUS','MODULE_SHIPPING_SELFPICKUP_SORT_ORDER','MODULE_SHIPPING_SELFPICKUP_ALLOWED','MODULE_SHIPPING_SELFPICKUP_TAX_CLASS','MODULE_SHIPPING_SELFPICKUP_ZONE');
    }
}
?>