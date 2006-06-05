<?php
/*
CaRP GPL v3.5.6
Copyright (c) 2002-5 Antone Roundy

This program may be copied, modified and redistributed under the terms of the
GNU General Public License. This program is distributed with NO WARRANTY
WHATSOEVER, including the implied warranty of merchantability or fitness for
a particular purpose.
See http://www.gnu.org/copyleft/gpl.html for details.

A commercial version of the program with additional features is available
via our website.

http://www.geckotribe.com/rss/carp/
Installation & Configuration Manual: http://www.geckotribe.com/rss/carp/manual/
Also available as a remotely hosted service for sites that cannot run
scripts. See http://www.geckotribe.com/rss/jawfish/
*/
defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
class RSSParser {
	var $insideitem=0;
	var $insidechannel=0;
	var $tag='';
	var $title='';
	var $description='';
	var $link='';
	var $pubdate='';
	var $dcdate='';
	var $ctitle='';
	var $cdescription='';
	var $clink='';
	var $clastbuilddate='';
	var $cpubdate='';
	var $cdcdate='';
	var $itemcount=0;
	var $itemindex=0;
	var $top='';
	var $bottom='';
	var $body='';
	var $showit;
	var $tagpairs;
	var $filterin;
	var $filterout;
	var $filterinfield;
	var $filteroutfield;
	var $linktargets=array('',' target="_blank"',' target="_top"');
	var $channelborder;
	var $channelaorder;
	var $itemorder;
	
	
	function SetItemOrder($iord) {
		$this->itemorder=explode(',',preg_replace('/[^a-z0-9,]/','',strtolower($iord)));
	}

	
	function CheckFilter($lookfor,$field) {
		if (strlen($field)) {
			if (strpos(strtolower($this->$field),$lookfor)!==false) return 1;
		} else {
			if (strpos(strtolower($this->title.' '.$this->description),$lookfor)!==false) return 1;
		}
		return 0;
	}
	
	function FormatLink($title,$link,$class,$style,$maxtitle,$atrunc,$btitle,$atitle,$deftitle,$titles) {
		global $carpconf;

		$fulltitle=$title=trim(preg_replace("/<.*?>/",'',$title));
		if ($didTrunc=(strlen($title)>$maxtitle))
			$title=substr($title,0,$maxtitle-strlen(preg_replace("/<.*?>/",'',$atrunc))).$atrunc;
		if (!strlen($title)) $title=$deftitle;
		
		$rv=$btitle.
			(strlen($link=trim(str_replace('"','&quot;',str_replace('&','&amp;',$link))))?(
				"<a href=\"$link\"".$this->linktargets[$carpconf['linktarget']].
				((($titles&&$didTrunc)||($titles==2))?" title=\"".str_replace('"','&quot;',$fulltitle)."\"":'')
			):(strlen($class.$style)?'<span':'')).
			(strlen($class)?(' class="'.$class.'"'):'').
			(strlen($style)?(' style="'.$style.'"'):'').
			(strlen($link.$class.$style)?'>':'').
			$title.
			(strlen($link)?'</a>':(strlen($class.$style)?'</span>':'')).
			$atitle."\n";
		return $rv;
	}

	
	function FormatSimpleField($val,$ci,$name,$fixamp=0) {
		global $carpconf;
		if ($fixamp) $val=str_replace('&','&amp;',$val);
		$rv=strlen($val)?($carpconf["b$ci$name"].$val.$carpconf["a$ci$name"]."\n"):'';
		return $rv;
	}
	
	function FormatDescription($description,$maxdesc,$b,$a,$atrunc) {
		global $carpconf;
		if (strlen($description)) {
			if (strlen($carpconf['desctags'])) {
				$adddesc=trim(preg_replace("#<(?!".$carpconf['desctags'].")(.*?)>#is",
					($carpconf['removebadtags']?'':"&lt;\\1\\2&gt;"),$description));
				$adddesc=preg_replace('/(<.*?)\bon[a-z]+\s*=\s*"[^"]*"(.*?>)/i',"\\1\\2",$adddesc);
			} else $adddesc=trim(preg_replace("#<(.*?)>#s",($carpconf['removebadtags']?'':"&lt;\\1&gt;"),$description));
			if ($maxdesc&&(strlen(preg_replace("/<.*?>/",'',$adddesc))>$maxdesc)) {
				$didTrunc=1;
				for ($gotchars=$i=0,$add='';$gotchars<$maxdesc;) {
					$add.=substr($adddesc,$i,($j=$maxdesc-$gotchars));
					$k=0;
					if ((($fo=strrpos($add,'<'))>($fc=strrpos($add,'>')))||(($fo!==false)&&($fc===false)))
						$add.=substr($adddesc,$i+$j,$k=(1+strpos(substr($adddesc,$i+$j),'>')));
					$i+=$j+$k;
					$gotchars=strlen(preg_replace("/<.*?>/",'',$add));
					
				}
				$adddesc=$add;
			} else $didTrunc=0;
			if ((($fo=strrpos($adddesc,'<'))>($fc=strrpos($adddesc,'>')))||(($fo!==false)&&($fc===false)))
				$adddesc=substr($adddesc,0,strrpos($adddesc,'<'));
			
			preg_match_all("#<(/?\w*).*?>#",$adddesc,$matches);
			$opentags=$matches[1];
			for ($i=0;$i<count($opentags);$i++) {
				$tag=strtolower($opentags[$i]);
				if (strcmp(substr($tag,0,1),'/')) {
					$baretag=$tag;
					$isClose=0;
				} else {
					$baretag=substr($tag,1);
					$isClose=1;
				}
				if (!isset($this->tagpairs["$baretag"])) {
					array_splice($opentags,$i,1);
					$i--;
				} else if ($isClose) {
					array_splice($opentags,$i,1);
					$i--;
					for ($j=$i;$j>=0;$j--) {
						if (!strcasecmp($opentags[$j],$baretag)) {
							array_splice($opentags,$j,1);
							$i--;
							$j=-1;
						}
					}
				}
			}
			if (strlen($adddesc)) {
				$adddesc=$b.$adddesc.(($didTrunc)?$atrunc:'');
				for ($i=count($opentags)-1;$i>=0;$i--) $adddesc.="</$opentags[$i]>";
				$adddesc.="$a\n";
			}
		} else $adddesc='';
		return $adddesc;
	}
	
	function startElement($parser,$tagName,$attrs) {
		$this->tag=$tagName;
		if ($this->insidechannel) $this->insidechannel++;
		if ($this->insideitem) $this->insideitem++;
		if ($tagName=="ITEM") {
			$this->insideitem=1;
			$this->title=$this->description=$this->link=$this->pubdate=$this->dcdate='';
		} else if ($tagName=="CHANNEL") {
			$this->insidechannel=1;
			$this->ctitle=$this->cdescription=$this->clink=$this->clastbuilddate=$this->cpubdate=$this->cdcdate='';
		}
	}

	function endElement($parser,$tagName) {
		global $carpconf;
		if ($tagName=="ITEM") {
			if ($this->itemcount<$carpconf['maxitems']) {
				$filterblock=0;

				if (count($this->filterin)) {
					$filterblock=1;
					for ($i=count($this->filterin)-1;$i>=0;$i--) {
						if ($this->CheckFilter($this->filterin[$i],$this->filterinfield[$i])) {
							$filterblock=0;
							break;
						}
					}
				}
				if (count($this->filterout)&&!$filterblock) {
					for ($i=count($this->filterout)-1;$i>=0;$i--) {
						if ($this->CheckFilter($this->filterout[$i],$this->filteroutfield[$i])) {
							$filterblock=1;
							break;
						}
					}
				}
				if (!$filterblock) {
						$thisitem=$carpconf['bi'];
						
						$this->pubdate=CarpDecodeDate(strlen($this->pubdate)?$this->pubdate:$this->dcdate);

						for ($ioi=0;$ioi<count($this->itemorder);$ioi++) {
							switch ($this->itemorder[$ioi]) {
							case "link":
							case "title":
								$thisitem.=$this->FormatLink($this->title,(($this->itemorder[$ioi]=='link')?$this->link:''),
								$carpconf['ilinkclass'],$carpconf['ilinkstyle'],$carpconf['maxititle'],$carpconf['atruncititle'],
								$carpconf['bilink'],$carpconf['ailink'],$carpconf['defaultititle'],$carpconf['ilinktitles']); break;
							case "url": $thisitem.=$this->FormatSimpleField($this->link,'i','url',1); break;
							case "desc":
								$thisitem.=$this->FormatDescription($this->description,
									$carpconf['maxidesc'],$carpconf['bidesc'],$carpconf['aidesc'],$carpconf['atruncidesc']);
								break;
							}
						}					
						$thisitem.=$carpconf['ai'];
						$this->itemcount++;
						if ($this->showit) $this->body.=$thisitem."\n";
						else $this->body.=(
								$this->pubdate?$this->pubdate:(($cdate=CarpDecodeDate($this->$cdate))?
									($cdate-$this->itemcount):(($carpconf['lastmodified']>0)?($carpconf['lastmodified']-$this->itemcount):0)
								)
							).
							': :'.preg_replace("/\n/",' ',$thisitem)."\n";
				}
			}
			$this->insideitem=0;
			$this->itemindex++;
		} else if ($tagName=="CHANNEL") {
			$this->insidechannel=0;
		}
		if ($this->insidechannel) $this->insidechannel--;
		if ($this->insideitem) $this->insideitem--;
	}

	function DoEndChannel(&$data,&$order,&$b,&$a) {
		global $carpconf;
		
		for ($coi=0;$coi<count($order);$coi++) {
			switch ($order[$coi]) {
			case "link":
			case "title":
				$data.=$this->FormatLink($this->ctitle,(($order[$coi]=='link')?$this->clink:''),
				$carpconf['clinkclass'],$carpconf['clinkstyle'],$carpconf['maxctitle'],$carpconf['atruncctitle'],
				$carpconf['bctitle'],$carpconf['actitle'],'',$carpconf['clinktitles']); break;
			case "url": $data.=$this->FormatSimpleField($this->clink,'c','url',1); break;
			case "desc":
				$data.=$this->FormatDescription($this->cdescription,
					$carpconf['maxcdesc'],$carpconf['bcdesc'],$carpconf['acdesc'],$carpconf['atrunccdesc']);
				break;
			}
		}
		if (strlen($data)) $data=$b.$data.$a;
		if (!$this->showit) $data=preg_replace("/\n/",' ',$data);
	}
		
	function characterData($parser,$data) {
		global $carpconf;
		if ($this->insideitem) {
			if ($this->itemcount==$carpconf['maxitems']) return;

			if ($this->insideitem==2) {
				switch ($this->tag) {
				case "TITLE": $this->title.=$data; break;
				case "DESCRIPTION": $this->description.=$data; break;
				case "LINK": $this->link.=$data; break;
				case "PUBDATE": $this->pubdate.=$data; break;
				case "DC:DATE": $this->dcdate.=$data; break;
				}
			}
		} else if ($this->insidechannel==2) {
			switch ($this->tag) {
			case "TITLE": $this->ctitle.=$data; break;
			case "DESCRIPTION": $this->cdescription.=$data; break;
			case "LINK": $this->clink.=$data; break;
			case "LASTBUILDDATE": $this->clastbuilddate.=$data; break;
			case "PUBDATE": $this->cpubdate.=$data; break;
			case "DC:DATE": $this->cdcdate.=$data; break;
			}
		}
	}
	
	function PrepTagPairs($tags) {
		$this->tagpairs=$findpairs=array();
		$temptags=explode('|',strtolower(preg_replace("/\\\\b/",'',$tags)));
		for ($i=count($temptags)-1;$i>=0;$i--) {
			$tag=$temptags[$i];
			if (strcmp(substr($tag,0,1),'/')) {
				$searchpre='/';
				$baretag=$tag;
			} else {
				$searchpre='';
				$baretag=substr($tag,1);
			}
			if (isset($findpairs["$searchpre$baretag"])) {
				$this->tagpairs["$baretag"]=1;
				$findpairs["$baretag"]=$findpairs["/$baretag"]=2;
			} else $findpairs["$tag"]='1';
		}
	}
}

function CarpDecodeDate($val) {
	global $carpconf;
	if (strlen($val)) {
		if (
			(($rv=strtotime($val))==-1)&&
			(($rv=strtotime(preg_replace("/([0-9]+\-[0-9]+\-[0-9]+)T(.*)(?:Z|([-+][0-9]{1,2}):([0-9]{2}))/","$1 $2 $3$4",$val)))==-1)
		) $rv=0;
	} else $rv=0;
	return $rv+($carpconf['timeoffset']*60);
}

function OpenRSSFeed($url) {
	global $carpconf,$carpversion,$CarpRedirs;
	
	$carpconf['lastmodified']='';
	if (preg_match("#^http://#i",$url)) {
		if (strlen($carpconf['proxyserver'])) {
			$urlparts=parse_url($carpconf['proxyserver']);
			$therest=$url;
		} else {
			$urlparts=parse_url($url);
			$therest=$urlparts['path'].(isset($urlparts['query'])?('?'.$urlparts['query']):'');
		}
		$domain=$urlparts['host'];
		$port=isset($urlparts['port'])?$urlparts['port']:80;
		$fp=fsockopen($domain,$port,$errno,$errstr,$carpconf['timeout']);
		if ($fp) {
			fputs($fp,"GET $therest HTTP/1.0\r\n".
				($carpconf['sendhost']?"Host: $domain\r\n":'').
				(strlen($carpconf['proxyauth'])?('Proxy-Authorization: Basic '.base64_encode($carpconf['proxyauth']) ."\r\n"):'').
				(strlen($carpconf['basicauth'])?('Authorization: Basic '.base64_encode($carpconf['basicauth']) ."\r\n"):'').
				"User-Agent: CaRP/$carpversion\r\n\r\n");
			while ((!feof($fp))&&preg_match("/[^\r\n]/",$header=fgets($fp,1000))) {
				if (preg_match("/^Location:/i",$header)) {
					fclose($fp);
					if (count($CarpRedirs)<$carpconf['maxredir']) {
						$loc=trim(substr($header,9));
						if (!preg_match("#^http://#i",$loc)) {
							if (strlen($carpconf['proxyserver'])) {
								$redirparts=parse_url($url);
								$loc=$redirparts['scheme'].'://'.$redirparts['host'].(isset($redirparts['port'])?(':'.$redirparts['port']):'').$loc;
							} else $loc="http://$domain".(($port==80)?'':":$port").$loc;
						}
						for ($i=count($CarpRedirs)-1;$i>=0;$i--) if (!strcmp($loc,$CarpRedirs[$i])) {
							CarpError('Redirection loop detected. Giving up.');
							return 0;
						}
						$CarpRedirs[count($CarpRedirs)]=$loc;
						return OpenRSSFeed($loc);
					} else {
						CarpError('Too many redirects. Giving up.');
						return 0;
					}
				} else if (preg_match("/^Last-Modified:/i",$header))
					$carpconf['lastmodified']=CarpDecodeDate(substr($header,14));
			}
		} else CarpError("$errstr ($errno)");
	} else if ($fp=fopen($url,'r')) {
		if ($stat=fstat($fp)) $carpconf['lastmodified']=$stat['mtime'];
	} else CarpError("Failed to open file: $url");
	return $fp;
}

function OpenCacheWrite() {
	global $carpconf;
	$j=0;
	if (!file_exists($carpconf['cachefile'])) touch($carpconf['cachefile']);
	if ($f=fopen($carpconf['cachefile'],'r+')) {
		if ($a=fstat($f)) {
			flock($f,LOCK_EX); // ignore result--doesn't work for all systems and situations
			clearstatcache();
			if ($b=fstat($f)) {
				if ($a['mtime']!=$b['mtime']) {
					flock($f,LOCK_UN);
					fclose($f);
				} else $j=$f;
			} else {
				CarpError("Can't stat cache file (2).");
				fclose($f);
			}
		} else {
			CarpError("Can't stat cache file (1).");
			fclose($f);
		}
	} else CarpError("Can't open cache file.");
	return $j;
}

function CloseCacheWrite($f) {
	global $carpconf;
	ftruncate($f,ftell($f));
	fflush($f);
	flock($f,LOCK_UN);
	fclose($f);
	$carpconf['mtime']=time();
}

function CacheRSSFeed($url) {
	if ($f=OpenRSSFeed($url)) {
		if ($outf=OpenCacheWrite()) {
			while ($l=fread($f,1000)) fwrite($outf,$l);
			CloseCacheWrite($outf);
		} else CarpError("Unable to create/open RSS cache file.",0);
		fclose($f);
	}
}

function CarpReadData($fp) {
	global $carpconf;
	return $carpconf['fixentities']?
		preg_replace("/&(?!lt|gt|amp|apos|quot)(.*\b)/is","&amp;\\1\\2",preg_replace("/\\x00/",'',fread($fp,4096))):
		preg_replace("/\\x00/",'',fread($fp,4096));
}

function GetRSSFeed($url,$cache,$showit) {
	global $carpconf,$CarpRedirs;
	$carpconf['desctags']=preg_replace("/(^\\|)|(\\|$)/",'',preg_replace("/\\|+/","|",preg_replace("#/?(script|embed|object|applet|iframe)#i",'',$carpconf['descriptiontags'])));
	if (strlen($carpconf['desctags'])) $carpconf['desctags']=str_replace('|','\b|',$carpconf['desctags']).'\b';
	
	// 3 lines for backwards compatibility
	if ($carpconf['corder']!==false) $carpconf['cborder']=$carpconf['corder'];
	if ($carpconf['bc']!==false) $carpconf['bcb']=$carpconf['bc'];
	if ($carpconf['ac']!==false) $carpconf['acb']=$carpconf['ac'];
	
	$rss_parser=new RSSParser();
	$rss_parser->showit=$showit;
	$rss_parser->channelborder=explode(',',preg_replace('/[^a-z0-9,]/','',strtolower($carpconf['cborder'])));
	$rss_parser->channelaorder=explode(',',preg_replace('/[^a-z0-9,]/','',strtolower($carpconf['caorder'])));
	$rss_parser->SetItemOrder($carpconf['iorder']);
	
	// the next 2 lines are for backward compatibility and will eventually be removed
	if ($carpconf['ilinktarget']!='-1') $carpconf['linktarget']=$carpconf['ilinktarget'];
	else if ($carpconf['clinktarget']!='-1') $carpconf['linktarget']=$carpconf['clinktarget'];

	if (preg_match("/[^0-9]/",$carpconf['linktarget'])) $rss_parser->linktargets[$carpconf['linktarget']]=' target="'.$carpconf['linktarget'].'"';
	$rss_parser->filterinfield=array();
	if (strlen($carpconf['filterin'])) {
		$rss_parser->filterin=explode('|',strtolower($carpconf['filterin']));
		for ($i=count($rss_parser->filterin)-1;$i>=0;$i--) {
			if (strpos($rss_parser->filterin[$i],':')!==false)
				list($rss_parser->filterinfield[$i],$rss_parser->filterin[$i])=explode(':',$rss_parser->filterin[$i],2);
			else $rss_parser->filterinfield[$i]='';
		}
	} else $rss_parser->filterin=array();
	$rss_parser->filteroutfield=array();
	if (strlen($carpconf['filterout'])) {
		$rss_parser->filterout=explode('|',strtolower($carpconf['filterout']));
		for ($i=count($rss_parser->filterout)-1;$i>=0;$i--) {
			if (strpos($rss_parser->filterout[$i],':')!==false)
				list($rss_parser->filteroutfield[$i],$rss_parser->filterout[$i])=explode(':',$rss_parser->filterout[$i],2);
			else $rss_parser->filteroutfield[$i]='';
		}
	} else $rss_parser->filterout=array();

	if ($fp=OpenRSSFeed($url)) {
		$xml_parser=xml_parser_create(strtoupper($carpconf['encodingin']));

		if (strlen($carpconf['encodingout'])) xml_parser_set_option($xml_parser,XML_OPTION_TARGET_ENCODING,$carpconf['encodingout']);
		xml_set_object($xml_parser,$rss_parser);
		xml_set_element_handler($xml_parser,"startElement","endElement");
		xml_set_character_data_handler($xml_parser,"characterData");
		$CarpRedirs=array();

		$rss_parser->PrepTagPairs($carpconf['desctags']);
		while ($data=CarpReadData($fp)) {
			if (!xml_parse($xml_parser,$data,feof($fp))) {
				CarpError("XML error: ".xml_error_string(xml_get_error_code($xml_parser))." at line ".xml_get_current_line_number($xml_parser));
				fclose($fp);
				xml_parser_free($xml_parser);
				return;
			}
			$data='';
		}
		fclose($fp);

			if (strlen($rss_parser->channelborder[0])) $rss_parser->DoEndChannel($rss_parser->top,$rss_parser->channelborder,$carpconf['bcb'],$carpconf['acb']);
			if (strlen($rss_parser->channelaorder[0])) $rss_parser->DoEndChannel($rss_parser->bottom,$rss_parser->channelaorder,$carpconf['bca'],$carpconf['aca']);

		if ($showit) {
			if ($carpconf['shownoitems']&&!$rss_parser->itemcount) CarpOutput($carpconf['noitems']);
			else CarpOutput($rss_parser->top.$carpconf['bitems'].$rss_parser->body.$carpconf['aitems'].$rss_parser->bottom.$carpconf['poweredby']);
		}
		if ($cache) {
			if ($cfp=OpenCacheWrite()) {
				if ($carpconf['shownoitems']&&!$rss_parser->itemcount) fwrite($cfp,$carpconf['noitems']);
				else fwrite($cfp,($showit?($rss_parser->top.$carpconf['bitems']):('cb: :'.$rss_parser->top."\n".'ca: :'.$rss_parser->bottom."\n")).$rss_parser->body.($showit?($carpconf['aitems'].$rss_parser->bottom.$carpconf['poweredby']):''));
				CloseCacheWrite($cfp);
			} else CarpError("Unable to create/open RSS cache file.",0);
		}
		xml_parser_free($xml_parser);
	} else if ($showit&&strlen($carpconf['cachefile'])&&file_exists($carpconf['cachefile'])) CarpOutput(file($carpconf['cachefile']));
	else if ($showit) CarpError('Can\'t open remote newsfeed.',0);
}
?>
