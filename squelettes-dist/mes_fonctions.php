<?php 
function get_lang(){
	return $GLOBALS['spip_lang'] ? $GLOBALS['spip_lang'] : 'fr';
}

function format_article($text,$mode=''){
	static $array;
	$output="";
	if(!isset($array)) $array=_split_text_elmts($text);
	switch($mode){
		case 'projet_haut':
			$begin=1;$end=3;
		break;
		case 'projet_bas':
			$begin=4;$end=999;
		break;
		default:$begin=1;$end=999;break;
	}
	foreach($array['p'] as $k=>$t){
		if($k<$begin || $k>$end) continue;
		if($k==1 && $mode!="chercheur") $output .= "<div class='col-md-12 intro blue'><h2>".$array['titres'][$k-1]."</h2>$t</div>\r\n";
		elseif($t || $k>0) $output .= "<div class='colonne ".($k%2 ? 'col-md-4' : 'col-md-4')."'><h2>".$array['titres'][$k-1]."</h2>$t</div>\r\n";
		if($k % 2==0 && $mode=='chercheur') $output.="<div class='clear'></div>";
	}
	return $output;
}

function get_citation_realisation($text,$mode=''){
	static $array;
	$output="";
	if(!isset($array)) $array=_split_text_elmts($text);
	$begin=1;$end=3;
	foreach($array['p'] as $k=>$t){
		if($k<$begin || $k>$end) continue;
		if($k==1) $output .= $t;
	}
	return $output;
}

function get_content_realisation($text,$mode=''){
	static $array;
	$output="";
	if(!isset($array)) $array=_split_text_elmts($text);
	$begin=1;$end=3;
	foreach($array['p'] as $k=>$t){
		if($k<$begin || $k>$end) continue;
		if($k==1 && $mode!="chercheur") $output .= "";
		elseif($t || $k>0) $output .= "<div class='colonne ".($k%2 ? 'col-md-4' : 'col-md-4')."'><h2>".$array['titres'][$k-1]."</h2>$t</div>\r\n";
	}
	return $output;
}



function format_page($text){
	$output="";
	$array=_split_text_elmts($text);
	foreach($array['p'] as $k=>$t){
		if($t || $k>0) $output .= "<div class='col-md-3'><h2>".$array['titres'][$k-1]."</h2>$t</div>\r\n";
	}
	return $output;
}

function format_diaporama($text){
	$text=str_replace(array('<p>','</p>'),'',$text);
	$text=preg_replace('|<br([^>]*)>|',"__br__",$text);
	$t=explode('__br__',$text);
	$text="<div class='dates'>".$t[0]."</div>";
	array_shift($t);
	$text.="<div class='text'>".implode("<br/>",$t)."</div>";
	return $text;
}

function _split_text_elmts($text){
	preg_match_all("|<h3([^>]*)>(.*?)</h3>|i",$text,$array);
	$text=preg_replace("|<h3([^>]*)>(.*?)</h3>|i","SFDLNIUFSDIFULNHVFSYV7678",$text);
	$tmp=explode('SFDLNIUFSDIFULNHVFSYV7678',$text);
	return array('titres'=>$array[2],'p'=>$tmp);
}

function unsub_link($id){
	if($_GET['link']) {
		unset($_GET['var_mode']);
		$l=$_GET['link'];unset($_GET['link']);
		foreach($_GET as $k=>$v) $l.=preg_replace("([^a-zA-Z0-9\ \-\_\@\.\=\?\&\/])","","&$k=$v");
		return $l;
	} else return "[[UNSUB_LINK_FR]]";
}


function calendarAdd($titre,$url,$debut,$fin){
	global $calendarLabex;
	if(!isset($calendarLabex)) $calendarLabex=array();
	$t=explode(' ',$debut);
	$debut=strtotime($t[0]);
	$t=explode(' ',$fin);
	$fin=strtotime($fin)+$t[0];
	$titre=str_replace('"','&quot;',$titre);

	while($debut<$fin){
		$date=date('j/n/Y',$debut);
		if(!$calendarLabex[$date]) $calendarLabex[$date]=array('link'=>$url,'texts'=>array());
		$calendarLabex[$date]['texts'][]="<a href='$url'>$titre</a>";
		$debut+=86400;
	}
}

function calendarDump(){
	global $calendarLabex;
	$output=array();
	if(count($calendarLabex)) foreach($calendarLabex as $date=>$infos){

		$output[]='{date:"'.$date.'",content:"<p>'.implode('', $infos['texts']).'</p>"'.(count($infos['texts'])==1?',link: "'.$infos['link'].'"':'').'}';
	}
	return implode(',',$output);
}

function conferences_get_date($tring){
	if(is_numeric($_GET['id_mot'])) return $_GET['id_mot'];
}



 ?>