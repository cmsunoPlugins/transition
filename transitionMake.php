<?php
if(!isset($_SESSION['cmsuno'])) exit();
?>
<?php
if(file_exists('data/'.$Ubusy.'/transition.json')) {
	$q1 = file_get_contents('data/'.$Ubusy.'/transition.json'); $a1 = json_decode($q1,true);
	$q2 = file_get_contents('data/'.$Ubusy.'/site.json'); $a2 = json_decode($q2,true);
	$visible = array();	$animate = ''; $parallax = array();
	$ratio = (isset($a1['ratio'])?$a1['ratio']:'0.4'); // div height in % of the screen
	$duration = (isset($a1['duration'])?$a1['duration']:'1'); // Duration of the animation
	$delay = (isset($a1['delay'])?$a1['delay']:'0'); // Delay before animation start
	foreach($a2['chap'] as $r2) if(empty($r2['od'])) $visible[] = $r2['d'];
	foreach($a1['chap'] as $k1=>$v1) if(in_array($k1,$visible)) {
		if(!empty($v1['tr'])) $animate .= ",'".$v1['na']."BlocChap':'".$v1['tr']."'";
		if(!empty($v1['im'])) $parallax[$v1['na']] = $v1['im'];
		$a0 = '<div id="'.$v1['na'].'BlocChap"';
		$a1 = '</div><!-- #'.$v1['na'].'BlocChap -->';
		if(!empty($v1['cla1']) || !empty($v1['sty1'])) {
			$Ucontent = str_replace($a0, '<div'.(!empty($v1['cla1'])?' class="'.$v1['cla1'].'"':'').(!empty($v1['sty1'])?' style="'.$v1['sty1'].'"':'').'>'.$a0, $Ucontent);
			$Ucontent = str_replace($a1, $a1.'</div>', $Ucontent);
		}
		if(!empty($v1['cla2']) || !empty($v1['sty2'])) {
			$Ucontent = str_replace($a0, '<div'.(!empty($v1['cla2'])?' class="'.$v1['cla2'].'"':'').(!empty($v1['sty2'])?' style="'.$v1['sty2'].'"':'').'>'.$a0, $Ucontent);
			$Ucontent = str_replace($a1, $a1.'</div>', $Ucontent);
		}
	}
	if($animate) {
		$animate = substr($animate,1);
		$Uhead .= '<link rel="stylesheet" href="uno/plugins/transition/animate.min.css">'."\r\n";
		$Ustyle .= '#pagesContent .animate__animated{animation-duration:'.$duration.'s;animation-delay:'.$delay.'s;}'."\r\n";
		$Ufoot .= "<script type=\"text/javascript\">var animate={".$animate."},k,transitionFirst=1;window.addEventListener('scroll',transitionAnimate);function transitionAnimate(){var b=(window.pageYOffset!=null?window.pageYOffset+window.innerHeight:window.document.documentElement.scrollTop+window.innerHeight)-20,a,c=0;for(k in animate){a=document.getElementById(k).offsetTop<b;if(a&&animate.hasOwnProperty(k)&&transitionFirst*c==0){if(document.getElementById(k).className.indexOf(animate[k])==-1)document.getElementById(k).className+=' animate__animated animate__'+animate[k];}++c;};transitionFirst=0;};transitionAnimate();</script>\r\n";
	}
	if(!empty($parallax)) {
		foreach($parallax as $k1=>$v1) {
			$a = '<div class="imgTransition" data-image="'.$v1.'" data-cover-ratio="'.$ratio.'"></div>';
			$a .= "\r\n".'<div id="'.$k1.'BlocChap"';
			$Ucontent = str_replace('<div id="'.$k1.'BlocChap"', $a, $Ucontent);
		}
		$Ufoot .= '<script type="text/javascript" src="uno/plugins/transition/jquery.imageScroll.min.js"></script>'."\r\n";
		$Ufoot .= "<script type=\"text/javascript\">jQuery(window).load(function(){jQuery('.imgTransition').imageScroll();});</script>\r\n";
	}
}
?>
