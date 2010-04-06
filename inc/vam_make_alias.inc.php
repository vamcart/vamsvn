<?php
	function make_alias ($alias)
	{

		//Replace cyrillic symbols to translit
		$trdic = array(
		"ё"=>"jo",
		"ж"=>"zh",
		"ф"=>"ph",
		"х"=>"kh",
		"ц"=>"ts",
		"ч"=>"ch",
		"ш"=>"sh",
		"щ"=>"sch",
		"э"=>"je",
		"ю"=>"ju",
		"я"=>"ja",
		
		"а"=>"a",
		"б"=>"b",
		"в"=>"v",
		"г"=>"g",
		"д"=>"d",
		"е"=>"e",
		"з"=>"z",
		"и"=>"i",
		"й"=>"j",
		"к"=>"k",
		"л"=>"l",
		"м"=>"m",
		"н"=>"n",
		"о"=>"o",
		"п"=>"p",
		"р"=>"r",
		"с"=>"s",
		"т"=>"t",
		"у"=>"u",
		"х"=>"h",
		"ц"=>"c",
		"ы"=>"y",
		
		"Ё"=>"E",
		"Ж"=>"ZH",
		"Ф"=>"PH",
		"Х"=>"KH",
		"Ц"=>"TS",
		"Ч"=>"CH",
		"Ш"=>"SH",
		"Щ"=>"SCH",
		"Э"=>"JE",
		"Ю"=>"JU",
		"Я"=>"JA",
		
		"А"=>"A",
		"Б"=>"B",
		"В"=>"V",
		"Г"=>"G",
		"Д"=>"D",
		"Е"=>"E",
		"З"=>"Z",
		"И"=>"I",
		"Й"=>"J",
		"К"=>"K",
		"Л"=>"L",
		"М"=>"M",
		"Н"=>"N",
		
		"О"=>"O",
		"П"=>"P",
		"Р"=>"R",
		"С"=>"S",
		"Т"=>"T",
		"У"=>"U",
		"Х"=>"H",
		"Ц"=>"C",
		"Ы"=>"Y",
		
		// -----------------------
		"Ъ" => "",
		"Ь" => "",
		"ъ" => "",
		"ь" => ""
		);			

						if($alias == "")
							$alias = rand(1000,9999);
							
						$alias = trim($alias);
						$alias = strtolower($alias);
						$alias = str_replace(' ','-',$alias);
						//Replace cyrillic symbols to translit
						$alias = strtr(stripslashes($alias), $trdic);
						$alias = preg_replace("/[^a-zA-Z0-9-s]/", "", $alias);						
						
                  $alias = $alias.'.html';
                
		return $alias;
	}
?>