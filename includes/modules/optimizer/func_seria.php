<?php
	function seria_query($fname, $q, $kind, $fields=array()){
		$r=mysql_query($q);
if (!$r) {
//echo "<BR> <B>".__FILE__." (".__LINE__.")</B><BR> <CENTER><TEXTAREA ROWS=8 style='width:90%'>".htmlspecialchars($q)."</TEXTAREA></CENTER> <BR>";
	//echo "<BR> <B>".__FILE__." (".__LINE__.")</B><BR>  ".mysql_error()." <BR>";
}

		$res=array();

		switch ($kind) {
			case 'OLD_2fields' :
				while($list=mysql_fetch_array($r)){
					$res[$list[$fields[0]]][]=array($fields[1] => $list[$fields[1]]);
				};
				break;

			case '2fields' :
			case 'fields' :
				while($list=mysql_fetch_array($r)){
					$dt=array();
					if(is_array($fields))foreach ($fields as $k => $v) {
						if(!$k) continue;
						$dt[$fields[$k]]=$list[$fields[$k]];
					}
					$res[$list[$fields[0]]][]=$dt;
				};
				break;
		

			case 'asis' :
				$c=0;
				while($list=mysql_fetch_row($r)){
					for($i=0;$i<count($list);$i++){
						$res[$c][mysql_field_name($r,$i)]=$list[$i];
					};
					$c++;
				};
				break;
		
			default :
				
				break;
		
		}

		
		/*
		while($list=mysql_fetch_array($r)){
			if($kind=='1'){

				//$id=array_shift($list);
				$res[$id]=$list[0];
			}else if($kind=='x2'){

				//$id=array_shift($list);
				$res[$id]=$list;
			}else if($kind=='2fields'){

				//$id=array_shift($list);
//				$res[$list[$fields[0]]][]=array($fields[1]);
				$res[$list[$fields[0]]][]=array($fields[1] => $list[$fields[1]]);
//				$res[$fields[1]][]=array($list[$fields[1]]);
			}else if($kind=='asis'){

				

				//$id=array_shift($list);
//				$res[$list[$fields[0]]][]=array($fields[1]);
				$res[$list[$fields[0]]][]=array($fields[1] => $list[$fields[1]]);
//				$res[$fields[1]][]=array($list[$fields[1]]);
			}else{

				$res[]=$list;
			}
		}
*/
//echo "<BR> <B>".__FILE__." (".__LINE__.")</B><BR> <CENTER><TEXTAREA ROWS=8 style='width:90%'>".htmlspecialchars($q)."</TEXTAREA></CENTER> <BR>";

//echo "<BR> <B>".__FILE__." (".__LINE__.")</B><BR><div align=left color=green><PRE>"; print_r($res); echo "</PRE></div>";
		return seria($fname, $res);
	};

	function seria($fname, $data){
//		require_once 'func_writefile.php';
		$res=writefile($fname, serialize($data));
		@chmod($fname, 0644);
		return $res;
	};

	function unseria($fname){
		return unserialize(file_get_contents($fname));
	};

/*
	function seria_query_m2($fname, $q){
		//global $db;
		$clist=querym2($q);
		return seria($fname, $clist);
	};


	function seria_query_1($fname, $q){
		//global $db;
		$clist=query_1($q);
		return seria($fname, $clist);
	};


	function querymm($query){
		$r=mysql_query($query);
		$res=array();
		while($list=mysql_fetch_row($r))
			$res[]=$list;
		return $res;
	}
*/

function writefile($fn, $text){
	if (!($fff=fopen($fn,'w'))){
		return false;
	}else{ 			
		fputs($fff, $text);
		fclose($fff);
		return true;	
	};
}


?>