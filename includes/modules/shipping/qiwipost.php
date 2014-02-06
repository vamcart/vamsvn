<?php

/*
@author Zoya Schegolihina zoya (at) qiwipost (dot) ru
*/

class qiwipost
{
	var $code, $title, $description, $icon, $enabled;

	function qiwipost()
	{
		global $order;

		$data = $this->qiwipost_get_vamshop_zones();
		foreach ( $data as $k=>$row )
		{			define( 'MODULE_SHIPPING_QIWIPOST_ZONE_'.$k.'_TITLE' , $row );
			define( 'MODULE_SHIPPING_QIWIPOST_ZONE_'.$k.'_DESC' , 'Выберите соответствие для региона '.$row );
		}

		$this->code = 'qiwipost';
		$this->title = MODULE_SHIPPING_QIWIPOST_TEXT_TITLE;
		$this->description = MODULE_SHIPPING_QIWIPOST_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_SHIPPING_QIWIPOST_SORT_ORDER;
		$this->icon = DIR_WS_ICONS . 'qiwipost.jpg';
		$this->tax_class = MODULE_SHIPPING_QIWIPOST_TAX_CLASS;
		$this->enabled = ((MODULE_SHIPPING_QIWIPOST_STATUS == 'True') ? true : false);

		if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_QIWIPOST_ZONE > 0) )
		{
			$check_flag = false;
			$check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_QIWIPOST_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");

			while ($check = vam_db_fetch_array($check_query))
			{
				if ($check['zone_id'] < 1)
				{
					$check_flag = true;
					break;
				}
				elseif ($check['zone_id'] == $order->delivery['zone_id'])
				{
					$check_flag = true;
					break;
				}
			}

			if ($check_flag == false) {
				$this->enabled = false;
			}
		}

		$check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='STORE_ZONE'");
		$check = vam_db_fetch_array($check_query);
		$own_zone_id = $check['configuration_value'];
	}

	function quote($method = '')
	{
		global $order, $cart, $shipping_weight, $own_zone_id;

		$terminal = '';
		$terminal = isset( $_SESSION[ 'qiwipost_terminal' ] ) ? $_SESSION[ 'qiwipost_terminal' ] : $terminal;
		$terminal = isset( $_POST['qiwipost_terminal'] ) ? $_POST['qiwipost_terminal'] : $terminal;

		$terminals = $this->qiwipostData();

		if ($this->tax_class > 0)
		{
			$this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
		}

		$cost = MODULE_SHIPPING_QIWIPOST_COST;

		if ( defined( 'MODULE_SHIPPING_QIWIPOST_ZONE_'.$order->delivery['zone_id'] ) )
			$city = constant( 'MODULE_SHIPPING_QIWIPOST_ZONE_'.$order->delivery['zone_id'] );
		else
			$city = '';

		$cost = ceil( file_get_contents( 'http://wt.qiwipost.ru/calc?key='.MODULE_SHIPPING_QIWIPOST_KEY.'&city='.$city.'&cost='.ceil( $order->info['total'] ).( MODULE_SHIPPING_QIWIPOST_COD == 'True' ? '&cod='.ceil( $order->info['total'] ) : '' ).( MODULE_SHIPPING_QIWIPOST_NDS == 'True' ? '&nds=1' : '' ).( MODULE_SHIPPING_QIWIPOST_TENS == 'True' ? '&tens=1' : '' ) ) );

		$options = '';
		$dterms = array();

		foreach ( $terminals as $row )
		{			if ( mb_strtolower( $row['town'], 'utf-8' ) == mb_strtolower( $city, 'utf-8' ) || mb_strtolower( $row['citygroup'], 'utf-8' ) == mb_strtolower( $city, 'utf-8' ) )
			{				$dterms[] = $row['name'];				$options .= '<option value="'.$row['name'].'"'.( $row['name'] == $terminal ? ' selected' : '' ).'>'.$row['name'].' '.$row['addr'].'</option>';
				if ( empty( $terminal ) )
				{					$terminal = $row['name'];				}
			}		}

		if ( in_array( $terminal, $dterms ) )
		{}
		elseif ( count( $dterms ) > 0 )
			$terminal = $dterms[0];
		else
			$terminal = '';

		$_SESSION[ 'qiwipost_terminal' ] = $terminal;

		$qiwipost_html = '<div id="qiwipost_container">
			Выберите нужный терминал из списка или на карте:<br><span id="qiwipost_select"><select name="qiwipost_terminal" id="qiwipost_terminal">'.$options.'</select></span><br><a href="javascript:void(0);" class="qiwipost_link">Выбрать терминал QIWI Post на карте</a><input type="hidden" id="qiwipost_id" name="qiwipost_id" value="'.( isset( $_POST['qiwipost_id'] ) ? $_POST['qiwipost_id'] : '' ).'"><input type="hidden" id="qiwipost_id_def" name="qiwipost_id_def" value="'.( isset( $_POST['qiwipost_id'] ) ? $_POST['qiwipost_id'] : '' ).'"><input type="hidden" id="qiwipost_addr" name="qiwipost_addr" value=""><input id="qiwipost_data" type="hidden" name="qiwipost_data">
		</div>
		<script type="text/javascript" src="http://geowidget-ru.easypack24.net/dropdown.php?dropdown_id=qiwipost_terminal&dropdown_name=qiwipost_terminal&field_to_update=qiwipost_id&field_to_update2=qiwipost_addr&user_function=Qiwipost.map_callback&town='.$city.'"></script>
		<script type="text/javascript" src="/jscript/qiwipost.js"></script>
		<link href="/jscript/qiwipost.css" type="text/css" rev="stylesheet" rel="stylesheet">
		<script type="text/javascript"></script>';

		if ( $method != '' )
			$title = strip_tags( $title );

		$q = array(
			'id' => $this->code,
   			'title' => ( !empty( $terminal ) && isset( $terminals[ $terminal ] ) ? 'Выбран терминал '.$terminals[$terminal]['name'].' '.$terminals[$terminal]['addr'] : 'Терминал не выбран' ),
   			'cost' => $cost
		);

		if ( !empty( $options ) )
		{
			$this->quotes = array('id' => $this->code,
				'module' => MODULE_SHIPPING_QIWIPOST_TEXT_TITLE,
				'qiwipost' => $qiwipost_html,
				'methods' => array( $q )
			);

			if (vam_not_null($this->icon))
				$this->quotes['icon'] = vam_image($this->icon, $this->title);
		}
		else
		{			$this->quotes = array();		}

		return $this->quotes;
	}

	function check()
	{
		if ( !isset($this->_check) )
		{
			$check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_QIWIPOST_STATUS'");
			$this->_check = vam_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install()
	{
		vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_QIWIPOST_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())" );
		vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_QIWIPOST_ALLOWED', '', '6', '0', now())" );
		vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_QIWIPOST_KEY', '', '6', '0', now())" );
		vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_QIWIPOST_COST', '', '6', '0', now())" );
		vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_QIWIPOST_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())" );
		vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_QIWIPOST_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())" );
		vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_QIWIPOST_SORT_ORDER', '0', '6', '0', now())" );
		vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_QIWIPOST_NDS', 'False', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())" );
		vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_QIWIPOST_TENS', 'False', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())" );
		vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_QIWIPOST_COD', 'False', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())" );

		vam_db_query( 'CREATE TABLE IF NOT EXISTS qiwipost_terminal (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(8),
			town VARCHAR(24),
			citygroup VARCHAR(24),
			addr VARCHAR(256),
			lastupd INT
		)' );

		$data = $this->qiwipost_get_vamshop_zones();
		$qdata = $this->qiwipost_get_towns();

		foreach ( $data as $k=>$row )
		{			vam_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_QIWIPOST_ZONE_".$k."', '', '6', '0', 'vam_cfg_select_option(array(\'".implode( "\', \'", $qdata )."\'), ', now())" );		}
	}

	final private function qiwipostImportTerminals()
	{
		$qpdata = $this->qiwipostApiQuery( array(), 'do=listmachines_xml', 'parse' );

		if ( isset( $qpdata->machine ) )
		{
			$sql = array();
			foreach ( $qpdata->machine as $row )
			{
				$sql[] = '(\''.mysql_escape_string( (string)$row->name ).'\', \''.mysql_escape_string( (string)$row->town ).'\', \''.mysql_escape_string( (string)$row->citygroup ).'\', \''.mysql_escape_string( (string)$row->town.' '.( isset( $row->metro ) ? 'м.'.(string)$row->metro->name[0].', ' : '' ).(string)$row->street.' '.(string)$row->buildingnumber ).'\', \''.mysql_escape_string( time() ).'\')';
			}
			$dbRes = vam_db_query( 'TRUNCATE TABLE qiwipost_terminal' );
			$dbRes = vam_db_query( 'INSERT INTO qiwipost_terminal ( name, town, citygroup, addr, lastupd ) VALUES '.implode( ', ', $sql ) );
		}

		return true;
	}

	final private function qiwipostCheckUpdate( $data )
	{
		if ( count ( $data ) > 0 )
		{
			$data = array_shift( $data );
		}
		else
		{
		}

		if ( count ( $data ) == 0 || ( isset( $data['lastupd'] ) && (int)$data['lastupd'] < time()-60*60*12 ) )
		{
			$this->qiwipostImportTerminals();
		}
		return true;
	}

	final private function qiwipostData()
	{
		$dbRes = vam_db_query( 'SELECT * FROM qiwipost_terminal ORDER BY citygroup, town, addr' );

		$data = array();
		while ( $row = vam_db_fetch_array( $dbRes ) )
		{
			$data[ $row['name'] ] =  $row;
		}

		$this->qiwipostCheckUpdate( $data );

		return $data;
	}

	function remove()
	{
		vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
		vam_db_query("DROP TABLE qiwipost_terminal");
	}

	function keys()
	{		$data = $this->qiwipost_get_vamshop_zones();

		$params = array( 'MODULE_SHIPPING_QIWIPOST_STATUS', 'MODULE_SHIPPING_QIWIPOST_COST', 'MODULE_SHIPPING_QIWIPOST_KEY', 'MODULE_SHIPPING_QIWIPOST_NDS', 'MODULE_SHIPPING_QIWIPOST_TENS', 'MODULE_SHIPPING_QIWIPOST_COD', 'MODULE_SHIPPING_QIWIPOST_TAX_CLASS', 'MODULE_SHIPPING_QIWIPOST_ZONE', 'MODULE_SHIPPING_QIWIPOST_SORT_ORDER' );

		foreach ( $data as $k=>$row )
		{
			$params[] = 'MODULE_SHIPPING_QIWIPOST_ZONE_'.$k;
		}

		return $params;
	}

	function qiwipost_get_vamshop_zones()
	{		static $data = array();

		if ( count( $data ) == 0 )
		{
			$res = vam_db_query( 'SELECT t1.countries_name, t2.zone_name, t2.zone_id FROM countries as t1, zones as t2 WHERE t1.countries_iso_code_2=\'RU\' && t1.countries_id=t2.zone_country_id ORDER BY t2.zone_name' );

			while( $row = vam_db_fetch_array( $res ) )
			{				$data[ $row[ 'zone_id' ] ] = $row[ 'zone_name' ];			}
		}

		return $data;	}

	function qiwipost_get_towns()
	{		static $data = array();

		if ( count( $data ) == 0 )
		{			$d = $this->qiwipostGETQuery( 'http://wt.qiwipost.ru/citylist' );
			if ( !empty( $d ) )
			{				$d = json_decode( $d );

				foreach ( $d as $town )
				{					if ( (int)$town->citygroup == 1 )
						$data[] = $town->name_rus;				}			}
			sort( $data );
		}

		return $data;	}

	final private function qiwipostPostQuery( $url, $post )
	{
		$ch = curl_init( $url );

		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0 );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

		return curl_exec( $ch );
		//return file_get_contents( $url );
	}

	final private function qiwipostGETQuery( $url )
	{
		$ch = curl_init( $url );

		curl_setopt( $ch, CURLOPT_POST, 0 );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0 );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

		return curl_exec( $ch );
		//return file_get_contents( $url );
	}

	final private function qiwipostApiQuery( $post, $get, $out )
	{
		$xml = self::qiwipostPostQuery( 'https://api.qiwipost.ru/?'.$get, $post );

		return $out == 'parse' ? simplexml_load_string( $xml ) : $xml;
	}
}

?>