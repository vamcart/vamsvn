<?php
/* -----------------------------------------------------------------------------------------
   $Id: print_order.php 1185 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (print_order.php,v 1.5 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (print_order.php,v 1.5 2003/08/24); xt-commerce.com
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

// include needed functions
require_once (DIR_FS_INC.'xtc_get_order_data.inc.php');
require_once (DIR_FS_INC.'xtc_get_attributes_model.inc.php');

class inwords { 

var $diw=Array(    0 =>    Array(    0  => Array( 0=> "����",    1=>1), 
                1  => Array( 0=> "",        1=>2), 
                2  => Array( 0=> "",        1=>3), 
                3  => Array( 0=> "���",        1=>0), 
                4  => Array( 0=> "������",    1=>0), 
                5  => Array( 0=> "����",    1=>1), 
                6  => Array( 0=> "�����",    1=>1), 
                7  => Array( 0=> "����",    1=>1), 
                8  => Array( 0=> "������",    1=>1), 
                9  => Array( 0=> "������",    1=>1), 
                10 => Array( 0=> "������",    1=>1), 
                11 => Array( 0=> "����������",    1=>1), 
                12 => Array( 0=> "����������",    1=>1), 
                13 => Array( 0=> "����������",    1=>1), 
                14 => Array( 0=> "������������",1=>1), 
                15 => Array( 0=> "����������",    1=>1), 
                16 => Array( 0=> "�����������",    1=>1), 
                17 => Array( 0=> "����������",    1=>1), 
                18 => Array( 0=> "������������",1=>1), 
                19 => Array( 0=> "������������",1=>1) 
            ), 
        1 =>    Array(    2  => Array( 0=> "��������",    1=>1), 
                3  => Array( 0=> "��������",    1=>1), 
                4  => Array( 0=> "�����",    1=>1), 
                5  => Array( 0=> "���������",    1=>1), 
                6  => Array( 0=> "����������",    1=>1), 
                7  => Array( 0=> "���������",    1=>1), 
                8  => Array( 0=> "�����������",    1=>1), 
                9  => Array( 0=> "���������",    1=>1)  
            ), 
        2 =>    Array(    1  => Array( 0=> "���",        1=>1), 
                2  => Array( 0=> "������",    1=>1), 
                3  => Array( 0=> "������",    1=>1), 
                4  => Array( 0=> "���������",    1=>1), 
                5  => Array( 0=> "�������",    1=>1), 
                6  => Array( 0=> "��������",    1=>1), 
                7  => Array( 0=> "�������",    1=>1), 
                8  => Array( 0=> "���������",    1=>1), 
                9  => Array( 0=> "���������",    1=>1) 
            ) 
); 

var $nom=Array(    0 => Array(0=>"�������",  1=>"������",    2=>"���� �������", 3=>"��� �������"), 
        1 => Array(0=>"�����",    1=>"������",    2=>"���� �����",   3=>"��� �����"), 
        2 => Array(0=>"������",   1=>"�����",     2=>"���� ������",  3=>"��� ������"), 
        3 => Array(0=>"��������", 1=>"���������", 2=>"���� �������", 3=>"��� ��������"), 
        4 => Array(0=>"���������",1=>"����������",2=>"���� ��������",3=>"��� ���������"), 
/* :))) */ 
        5 => Array(0=>"���������",1=>"����������",2=>"���� ��������",3=>"��� ���������") 
); 

var $out_rub; 

function get($summ){ 
 if($summ>=1) $this->out_rub=0; 
 else $this->out_rub=1; 
 $summ_rub= doubleval(sprintf("%0.0f",$summ)); 
 if(($summ_rub-$summ)>0) $summ_rub--; 
 $summ_kop= doubleval(sprintf("%0.2f",$summ-$summ_rub))*100; 
 $kop=$this->get_string($summ_kop,0); 
 $retval=""; 
 for($i=1;$i<6&&$summ_rub>=1;$i++): 
  $summ_tmp=$summ_rub/1000; 
  $summ_part=doubleval(sprintf("%0.3f",$summ_tmp-intval($summ_tmp)))*1000; 
  $summ_rub= doubleval(sprintf("%0.0f",$summ_tmp)); 
  if(($summ_rub-$summ_tmp)>0) $summ_rub--; 
  $retval=$this->get_string($summ_part,$i)." ".$retval; 
 endfor; 
 if(($this->out_rub)==0) $retval.=" ������"; 
 return $retval." ".$kop; 
} 

function get_string($summ,$nominal){ 
 $retval=""; 
 $nom=-1; 
 $summ=round($summ); 
 if(($nominal==0&&$summ<100)||($nominal>0&&$nominal<6&&$summ<1000)): 
  $s2=intval($summ/100); 
  if($s2>0): 
   $retval.=" ".$this->diw[2][$s2][0]; 
   $nom=$this->diw[2][$s2][1]; 
  endif; 
  $sx=doubleval(sprintf("%0.0f",$summ-$s2*100)); 
  if(($sx-($summ-$s2*100))>0) $sx--; 
  if(($sx<20&&$sx>0)||($sx==0&&$nominal==0)): 
   $retval.=" ".$this->diw[0][$sx][0]; 
   $nom=$this->diw[0][$sx][1]; 
  else: 
   $s1=doubleval(sprintf("%0.0f",$sx/10)); 
   if(($s1-$sx/10)>0)$s1--; 
   $s0=doubleval($summ-$s2*100-$s1*10); 
   if($s1>0): 
    $retval.=" ".$this->diw[1][$s1][0]; 
    $nom=$this->diw[1][$s1][1]; 
   endif; 
   if($s0>0): 
    $retval.=" ".$this->diw[0][$s0][0]; 
    $nom=$this->diw[0][$s0][1]; 
   endif; 
  endif; 
 endif; 
 if($nom>=0): 
  $retval.=" ".$this->nom[$nominal][$nom]; 
  if($nominal==1) $this->out_rub=1; 
 endif; 
 return trim($retval); 
} 

} 

$smarty = new Smarty;

// check if custmer is allowed to see this order!
$order_query_check = xtc_db_query("SELECT
  					customers_id
  					FROM ".TABLE_ORDERS."
  					WHERE orders_id='".(int) $_GET['oID']."'");
$oID = (int) $_GET['oID'];
$order_check = xtc_db_fetch_array($order_query_check);
if ($_SESSION['customer_id'] == $order_check['customers_id']) {
	// get order data

	include (DIR_WS_CLASSES.'order.php');
	$order = new order($oID);
	$smarty->assign('address_label_customer', xtc_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
	$smarty->assign('address_label_shipping', xtc_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
	$smarty->assign('address_label_payment', xtc_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
	$smarty->assign('csID', $order->customer['csID']);
	// get products data
	$order_total = $order->getTotalData($oID); 
	$smarty->assign('order_data', $order->getOrderData($oID));
	$smarty->assign('order_total', $order_total['data']);

	$smarty->assign('1', MODULE_PAYMENT_SCHET_1);
	$smarty->assign('2', MODULE_PAYMENT_SCHET_2);
	$smarty->assign('3', MODULE_PAYMENT_SCHET_3);
	$smarty->assign('4', MODULE_PAYMENT_SCHET_4);
	$smarty->assign('5', MODULE_PAYMENT_SCHET_5);
	$smarty->assign('6', MODULE_PAYMENT_SCHET_6);
	$smarty->assign('7', MODULE_PAYMENT_SCHET_7);
	$smarty->assign('8', MODULE_PAYMENT_SCHET_8);
	$smarty->assign('9', MODULE_PAYMENT_SCHET_9);
	$smarty->assign('10', MODULE_PAYMENT_SCHET_10);
	$smarty->assign('11', MODULE_PAYMENT_SCHET_11);
	$smarty->assign('12', MODULE_PAYMENT_SCHET_12);
	$smarty->assign('13', $order->customer['firstname']);
	$smarty->assign('14', $order->customer['lastname']);

   $iw=new inwords; 

	$smarty->assign('summa', $iw->get($order->info['total']));

	// assign language to template for caching
	$smarty->assign('language', $_SESSION['language']);
	$smarty->assign('oID', (int) $_GET['oID']);
	if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
		include (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
		$payment_method = constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
	}
	$smarty->assign('PAYMENT_METHOD', $payment_method);
	$smarty->assign('COMMENT', $order->info['comments']);
	$smarty->assign('DATE', xtc_date_short($order->info['date_purchased']));
	$path = DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/';
	$smarty->assign('tpl_path', $path);

	// dont allow cache
	$smarty->caching = false;

	$smarty->display(CURRENT_TEMPLATE.'/module/schet.html');
} else {

	$smarty->assign('ERROR', 'You are not allowed to view this order!');
	$smarty->display(CURRENT_TEMPLATE.'/module/error_message.html');
}
?>