<?php

function send_whatsapp ($phone_number) {

if (ENABLE_WHATSAPP == 'false') return;

	    //Send whatsapp message

	    //Смотрим статус аккаунта whatsapp, что б отправка работала, статус должен быть authenticated
	    //$curl = curl_init();
	    //curl_setopt($curl, CURLOPT_URL, CHATAPI_URL.'status?token='.CHATAPI_TOKEN);
	    //curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    //$data = curl_exec($curl);
	    
	    //curl_close($curl);
	    
	    //$data = json_decode($data);
	    
       $vamTemplate = new vamTemplate;
	    $whatsapp_phone = preg_replace("/[^0-9]/", "",$phone_number);
	    $whatsapp_phone = substr_replace($whatsapp_phone, '7', 0, 1); 
	    
	    //if ($data->accountStatus == 'authenticated') {	    

	    // Смотрим номер телефона, зарегистрирован ли в whatsapp и как давно был активен
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, CHATAPI_URL.'checkPhone?phone='.$whatsapp_phone.'&token='.CHATAPI_TOKEN);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    
	    $data = json_decode($data);
	    
	    if (isset($data->result) && $data->result == 'exists') {

	    	//echo 'номер не зарегистрирован в whatsapp';

    //$datetime1 = new DateTime(date("Y-m-d H:i:s", $data->lastSeen));
    //$datetime2 = new DateTime();
    //$interval = $datetime1->diff($datetime2);
    //$days_ago = $interval->format('%a');	    	
	    	
	    	//if (isset($data->lastSeen) && $days_ago < 10) {
	    	//if (isset($data->lastSeen)) {

	    	//echo 'не было больше 10 дней в whatsapp';

	    	//} else {

	    	//echo 'всё хорошо, номер зарегистрирован, был в онлайне в последние 10 дней.';

    $request = array(
    
                     'phone' => $whatsapp_phone,
					      'body' => $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail_whatsapp.html')
					      
					     );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, CHATAPI_URL.'sendMessage?token='.CHATAPI_TOKEN);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 5);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $data = curl_exec($curl);
    
    curl_close($curl);
    if($data === false)
    {
	//return 'error';
    }
    
    $js = json_decode($data, $assoc=true);

	    //echo var_dump($js);

	    //echo var_dump($js['sent']);


	    }

	    
//}

}

function check_whatsapp ($phone_number) {

if (ENABLE_WHATSAPP == 'false') return;

	    $whatsapp_phone = preg_replace("/[^0-9]/", "",$phone_number);
	    $whatsapp_phone = substr_replace($whatsapp_phone, '7', 0, 1); 

	    // Смотрим номер телефона, зарегистрирован ли в whatsapp
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, CHATAPI_URL.'checkPhone?phone='.$whatsapp_phone.'&token='.CHATAPI_TOKEN);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    
	    $data = json_decode($data);
	    
	    if (isset($data->result) && $data->result == 'exists') {
	    	return true;
	    } else {
	    	return false;
	    }

}