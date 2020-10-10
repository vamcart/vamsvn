<?php

// склоняет окончания (дня, дней)
function vam_format_by_count($count, $form1, $form2, $form3)
{
    $count = abs($count) % 100;
    $lcount = $count % 10;

    if ($count >= 11 && $count <= 19) return($form3);
    if ($lcount >= 2 && $lcount <= 4) return($form2);
    if ($lcount == 1) return($form1);
	
    return $form3;
}