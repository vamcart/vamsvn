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
require_once (DIR_FS_INC.'vam_get_order_data.inc.php');
require_once (DIR_FS_INC.'vam_get_attributes_model.inc.php');

class inwords { 

var $diw=Array(    0 =>    Array(    0  => Array( 0=> text_zero,    1=>1), 
                1  => Array( 0=> "",        1=>2), 
                2  => Array( 0=> "",        1=>3), 
                3  => Array( 0=> text_three,        1=>0), 
                4  => Array( 0=> text_four,    1=>0), 
                5  => Array( 0=> text_five,    1=>1), 
                6  => Array( 0=> text_six,    1=>1), 
                7  => Array( 0=> text_seven,    1=>1), 
                8  => Array( 0=> text_eight,    1=>1), 
                9  => Array( 0=> text_nine,    1=>1), 
                10 => Array( 0=> text_ten,    1=>1), 
                11 => Array( 0=> text_eleven,    1=>1), 
                12 => Array( 0=> text_twelve,    1=>1), 
                13 => Array( 0=> text_thirteen,    1=>1), 
                14 => Array( 0=> text_fourteen,1=>1), 
                15 => Array( 0=> text_fifteen,    1=>1), 
                16 => Array( 0=> text_sixteen,    1=>1), 
                17 => Array( 0=> text_seventeen,    1=>1), 
                18 => Array( 0=> text_eighteen,1=>1), 
                19 => Array( 0=> text_nineteen,1=>1) 
            ), 
        1 =>    Array(    2  => Array( 0=> text_twenty,    1=>1), 
                3  => Array( 0=> text_thirty,    1=>1), 
                4  => Array( 0=> text_forty,    1=>1), 
                5  => Array( 0=> text_fifty,    1=>1), 
                6  => Array( 0=> text_sixty,    1=>1), 
                7  => Array( 0=> text_seventy,    1=>1), 
                8  => Array( 0=> text_eighty,    1=>1), 
                9  => Array( 0=> text_ninety,    1=>1)  
            ), 
        2 =>    Array(    1  => Array( 0=> text_hundred,        1=>1), 
                2  => Array( 0=> text_two_hundred,    1=>1), 
                3  => Array( 0=> text_three_hundred,    1=>1), 
                4  => Array( 0=> text_four_hundred,    1=>1), 
                5  => Array( 0=> text_five_hundred,    1=>1), 
                6  => Array( 0=> text_six_hundred,    1=>1), 
                7  => Array( 0=> text_seven_hundred,    1=>1), 
                8  => Array( 0=> text_eight_hundred,    1=>1), 
                9  => Array( 0=> text_nine_hundred,    1=>1) 
            ) 
); 

var $nom=Array(    0 => Array(0=> text_penny,  1=> text_kopecks,    2=> text_single_kopek, 3=> text_two_penny), 
        1 => Array(0=> text_ruble,    1=> text_rubles,    2=> text_one_ruble,   3=> text_two_rubles), 
        2 => Array(0=> text_thousands,   1=> text_thousand,     2=> text_one_thousand,  3=> text_two_thousand), 
        3 => Array(0=> text_million, 1=> text_millions, 2=> text_one_million, 3=> text_two_million), 
        4 => Array(0=> text_billion, 1=> text_billions, 2=> text_one_billion, 3=> text_two_billion), 
/* :))) */ 
        5 => Array(0=> text_trillion, 1=> text_trillions, 2=> text_one_trillion, 3=>text_two_trillion) 
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
 if(($this->out_rub)==0) $retval.=' ' . text_rubles; 
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

$vamTemplate = new vamTemplate;

// check if custmer is allowed to see this order!
$order_query_check = vam_db_query("SELECT
  					customers_id
  					FROM ".TABLE_ORDERS."
  					WHERE orders_id='".(int) $_GET['oID']."'");
$oID = (int) $_GET['oID'];
$order_check = vam_db_fetch_array($order_query_check);

  $company_query = vam_db_query("SELECT * FROM ".TABLE_COMPANIES."
  					WHERE orders_id='".(int)$_GET['oID']."'");
  					
  $company = vam_db_fetch_array($company_query);

	$vamTemplate->assign('company_name', $company['name']);
	$vamTemplate->assign('company_telephone', $company['telephone']);
	$vamTemplate->assign('company_fax', $company['fax']);
	$vamTemplate->assign('company_inn', $company['inn']);
	$vamTemplate->assign('company_kpp', $company['kpp']);
	$vamTemplate->assign('company_ogrn', $company['ogrn']);
	$vamTemplate->assign('company_okpo', $company['okpo']);
	$vamTemplate->assign('company_rs', $company['rs']);
	$vamTemplate->assign('company_bank_name', $company['bank_name']);
	$vamTemplate->assign('company_bik', $company['bik']);
	$vamTemplate->assign('company_ks', $company['ks']);
	$vamTemplate->assign('company_address', $company['address']);
	$vamTemplate->assign('company_yur_address', $company['yur_address']);
	$vamTemplate->assign('company_fakt_address', $company['fakt_address']);
	$vamTemplate->assign('company_director', $company['name']);
	$vamTemplate->assign('company_accountant', $company['accountant']);

if ($_SESSION['customer_id'] == $order_check['customers_id']) {
	// get order data

	include (DIR_WS_CLASSES.'order.php');
	$order = new order($oID);
	$vamTemplate->assign('address_label_customer', vam_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
	$vamTemplate->assign('address_label_shipping', vam_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
	$vamTemplate->assign('address_label_payment', vam_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
	$vamTemplate->assign('csID', $order->customer['csID']);
	// get products data
	$order_total = $order->getTotalData($oID); 
	$vamTemplate->assign('order_data', $order->getOrderData($oID));
	$vamTemplate->assign('order_total', $order_total['data']);

	$vamTemplate->assign('1', MODULE_PAYMENT_SCHET_1);
	$vamTemplate->assign('2', MODULE_PAYMENT_SCHET_2);
	$vamTemplate->assign('3', MODULE_PAYMENT_SCHET_3);
	$vamTemplate->assign('4', MODULE_PAYMENT_SCHET_4);
	$vamTemplate->assign('5', MODULE_PAYMENT_SCHET_5);
	$vamTemplate->assign('6', MODULE_PAYMENT_SCHET_6);
	$vamTemplate->assign('7', MODULE_PAYMENT_SCHET_7);
	$vamTemplate->assign('8', MODULE_PAYMENT_SCHET_8);
	$vamTemplate->assign('9', MODULE_PAYMENT_SCHET_9);
	$vamTemplate->assign('10', MODULE_PAYMENT_SCHET_10);
	$vamTemplate->assign('11', MODULE_PAYMENT_SCHET_11);
	$vamTemplate->assign('12', MODULE_PAYMENT_SCHET_12);
	$vamTemplate->assign('13', $order->customer['firstname']);
	$vamTemplate->assign('14', $order->customer['lastname']);

   $iw=new inwords; 

	$vamTemplate->assign('summa', $iw->get($order->info['total_value']));

	// assign language to template for caching
	$vamTemplate->assign('language', $_SESSION['language']);
   $vamTemplate->assign('charset', $_SESSION['language_charset']); 
	$vamTemplate->assign('oID', (int) $_GET['oID']);
	if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
		include (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
		$payment_method = constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
	}
	$vamTemplate->assign('PAYMENT_METHOD', $payment_method);
	$vamTemplate->assign('COMMENT', $order->info['comments']);
	$vamTemplate->assign('DATE', vam_date_short($order->info['date_purchased']));
	$path = DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/';
	$vamTemplate->assign('tpl_path', $path);

	// dont allow cache
	$vamTemplate->caching = false;

	$vamTemplate->display(CURRENT_TEMPLATE.'/module/packingslip.html');
} else {

	$vamTemplate->assign('ERROR', 'You are not allowed to view this order!');
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/error_message.html');
}
?>