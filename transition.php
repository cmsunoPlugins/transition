<?php
session_start(); 
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])!='xmlhttprequest') {sleep(2);exit;} // ajax request
if(!isset($_POST['unox']) || $_POST['unox']!=$_SESSION['unox']) {sleep(2);exit;} // appel depuis uno.php
?>
<?php
include('../../config.php');
include('lang/lang.php');
$q = file_get_contents('../../data/busy.json'); $a = json_decode($q,true); $Ubusy = $a['nom'];
// ********************* actions *************************************************************************
if (isset($_POST['action']))
	{
	switch ($_POST['action'])
		{
		// ********************************************************************************************
		case 'plugin': ?>
		<link rel="stylesheet" type="text/css" media="screen" href="uno/plugins/transition/transition.css" />
		<div class="blocForm transition">
			<h2><?php echo T_("Transition");?></h2>
			<p><?php echo T_("This plugin adds nice transitions between the chapters of the page.");?></p>
			<p><?php echo T_("It uses different tools that work independently :");?>
				<ul>
					<li>Animate.css : <?php echo T_("A pure CSS3 tool with a lot transitions.");?></li>
					<li>ImageScroll.js : <?php echo T_("A jQuery tool to create a parallax effect with images.");?></li>
				</ul>
			</p>
			<h3><?php echo T_("Set Chapters Transitions");?></h3>
			<table class="hForm">
				<tr>
					<td><label><?php echo T_("Chapter");?></label></td>
					<td>
						<select name="transitionChap" id="transitionChap">
							<?php
							$q = file_get_contents('../../data/'.$Ubusy.'/site.json'); $b = json_decode($q,true);
							foreach($b['chap'] as $k=>$v)
								{
								echo '<option value="'.$v["d"].'">'.$v["t"].'</option>';
								}
							?>
							
						</select>
					</td>
					<td><em><?php echo T_("Chapter of the page concerned by the transition.");?></em></td>
				</tr>
				<tr>
					<td><label><?php echo T_("Transition type");?></label></td>
					<td>
						<select name="transitionType" id="transitionType">
							<option value="">-</option>
							<?php
							$q = array('bounce','flash','pulse','rubberBand','shake','headShake','swing','tada','wobble','jello','bounceIn','bounceInDown','bounceInLeft','bounceInRight','bounceInUp','fadeIn','fadeInDown','fadeInDownBig','fadeInLeft','fadeInLeftBig','fadeInRight','fadeInRightBig','fadeInUp','fadeInUpBig','flipInX','flipInY','lightSpeedIn','rotateIn','rotateInDownLeft','rotateInDownRight','rotateInUpLeft','rotateInUpRight','rotateOutDownLeft','rotateOutDownRight','rotateOutUpLeft','rotateOutUpRight','hinge','rollIn','rollOut','zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp','zoomOut','zoomOutDown','zoomOutLeft','zoomOutRight','zoomOutUp','slideInDown','slideInLeft','slideInRight','slideInUp');
							// DISABLE : 'bounceOut','bounceOutDown','bounceOutLeft','bounceOutRight','bounceOutUp','fadeOut','fadeOutDown','fadeOutDownBig','fadeOutLeft','fadeOutLeftBig','fadeOutRight','fadeOutRightBig','fadeOutUp','fadeOutUpBig','flipOutX','flipOutY','lightSpeedOut','rotateOut','jackInTheBox','slideOutDown','slideOutLeft','slideOutRight','slideOutUp'
							foreach($q as $r)
								{
								echo '<option value="'.$r.'">'.$r.'</option>';
								}
							?>
							
						</select>
					</td>
					<td><em><?php echo T_("Type of content transition when arrive on the selected chapter.");?></em></td>
				</tr>
				<tr>
					<td><label><?php echo T_("Parallax image");?></label></td>
					<td style="min-width:245px;">
						<input type="text" class="input" style="max-width:180px;" name="transitionImg" id="transitionImg" value="" />
						<div class="bouton finder" style="margin-left:10px;" id="bFTransition" onClick="f_finder_select('transitionImg')" title="<?php echo T_("File manager");?>"><img src="<?php echo $_POST['udep']; ?>includes/img/finder.png" /></div>
					</td>
					<td><em><?php echo T_("Add a section above the chapter with a parallax image. JQuery needed.");?></em></td>
				</tr>
				<tr>
					<td><label><?php echo T_("DIV");?></label></td>
					<td style="min-width:245px;">
						<input type="text" class="input" style="max-width:106px;" name="transitionCL1" id="transitionCL1" placeholder="CLASS" value="" />
						<input type="text" class="input" style="max-width:106px;" name="transitionST1" id="transitionST1" placeholder="STYLE" value="" />
					</td>
					<td><em><?php echo T_("Add a DIV block with Class and/or Style that includes the chapter.");?></em></td>
				</tr>
				<tr>
					<td><label><?php echo T_("Sub-DIV");?></label></td>
					<td style="min-width:245px;">
						<input type="text" class="input" style="max-width:106px;" name="transitionCL2" id="transitionCL2" placeholder="CLASS" value="" />
						<input type="text" class="input" style="max-width:106px;" name="transitionST2" id="transitionST2" placeholder="STYLE" value="" />
					</td>
					<td><em><?php echo T_("Add a DIV block inside the previous one that includes the chapter.");?></em></td>
				</tr>
			</table>
			<div class="bouton fr" onClick="transition_save();" title="<?php echo T_("Save settings");?>"><?php echo T_("Save");?></div>
			<div class="clear"></div>
			<div id="transitionLoad">
				<table>
					<tr>
						<th><?php echo T_("Chapter");?></th>
						<th><?php echo T_("Animation");?></th>
						<th><?php echo T_("Parallax image");?></th>
						<th><?php echo T_("DIV");?></th>
						<th><?php echo T_("Sub-DIV");?></th>
					</tr>
				</table>
			</div>
			<h3><?php echo T_("Config");?></h3>
			<table class="hForm">
				<tr>
					<td><label><?php echo T_("Animation duration");?></label></td>
					<td><input type="text" class="input" style="width:50px" name="transitionDuration" id="transitionDuration" value="" /></td>
					<td><em><?php echo T_("Duration of the animation in second. Default : 1");?></em></td>
				</tr>
				<tr>
					<td><label><?php echo T_("Animation delay");?></label></td>
					<td><input type="text" class="input" style="width:50px" name="transitionDelay" id="transitionDelay" value="" /></td>
					<td><em><?php echo T_("Delay before the animation start in second. Default : 0");?></em></td>
				</tr>
				<tr>
					<td><label><?php echo T_("Parallax image height");?></label></td>
					<td><input type="text" class="input" style="width:50px" name="transitionRatio" id="transitionRatio" value="" /></td>
					<td><em><?php echo T_("Height ratio of the parallax image relative to the height of the screen. Default : 0.4");?></em></td>
				</tr>
			</table>
			<div class="bouton fr" onClick="transition_save_config();" title="<?php echo T_("Save settings");?>"><?php echo T_("Save");?></div>
			<div class="clear"></div>
		</div>
		<?php break;
		// ********************************************************************************************
		case 'load':
		$a = array("chap" => array());
		if(!file_exists('../../data/'.$Ubusy.'/transition.json')) file_put_contents('../../data/'.$Ubusy.'/transition.json', json_encode($a));
		else
			{
			$q = file_get_contents('../../data/'.$Ubusy.'/transition.json'); $a = json_decode($q,true);
			}
		$q = file_get_contents('../../data/'.$Ubusy.'/site.json'); $b = json_decode($q,true);
		$c = array(
			'duration'=>(isset($a['duration'])?$a['duration']:'1'),
			'delay'=>(isset($a['delay'])?$a['delay']:'0'),
			'ratio'=>(isset($a['ratio'])?$a['ratio']:'0.4'),
			'cla1'=>(isset($a['cla1'])?$a['cla1']:''),
			'cla2'=>(isset($a['cla2'])?$a['cla2']:''),
			'sty1'=>(isset($a['sty1'])?$a['sty1']:''),
			'sty2'=>(isset($a['sty2'])?$a['sty2']:''),
			'chap'=>array()
			);
		foreach($b['chap'] as $k=>$v)
			{
			$transition = (isset($a['chap'][$v['d']]['tr'])?$a['chap'][$v['d']]['tr']:"");
			$img = (isset($a['chap'][$v['d']]['im'])?$a['chap'][$v['d']]['im']:"");
			$cla1 = (isset($a['chap'][$v['d']]['cla1'])?$a['chap'][$v['d']]['cla1']:"");
			$cla2 = (isset($a['chap'][$v['d']]['cla2'])?$a['chap'][$v['d']]['cla2']:"");
			$sty1 = (isset($a['chap'][$v['d']]['sty1'])?$a['chap'][$v['d']]['sty1']:"");
			$sty2 = (isset($a['chap'][$v['d']]['sty2'])?$a['chap'][$v['d']]['sty2']:"");
			if($img)
				{
				$img = explode('/',$img);
				$img = $img[count($img)-1];
				}
			$c['chap'][] = array(
				"tit" => $v["t"],
				"tr" => $transition,
				"im" => $img,
				"cla1" => $cla1,
				"cla2" => $cla2,
				"sty1" => $sty1,
				"sty2" => $sty2
				);
			}
		echo stripslashes(json_encode($c)); // => jQuery Ajax
		break;
		// ********************************************************************************************
		case 'save':
		$chap = (isset($_POST['chap'])?strip_tags($_POST['chap']):false);
		$typ = (!empty($_POST['typ'])?strip_tags($_POST['typ']):'');
		$img = (!empty($_POST['img'])?strip_tags($_POST['img']):'');
		$cla1 = (!empty($_POST['cla1'])?strip_tags($_POST['cla1']):'');
		$cla2 = (!empty($_POST['cla2'])?strip_tags($_POST['cla2']):'');
		$sty1 = (!empty($_POST['sty1'])?strip_tags($_POST['sty1']):'');
		$sty2 = (!empty($_POST['sty2'])?strip_tags($_POST['sty2']):'');
		$q = file_get_contents('../../data/'.$Ubusy.'/transition.json'); $a = json_decode($q,true);
		$q = file_get_contents('../../data/'.$Ubusy.'/site.json'); $b = json_decode($q,true);
		if($chap!==false)
			{
			$a['chap'][$chap]['tr'] = $typ;
			$a['chap'][$chap]['im'] = $img;
			$a['chap'][$chap]['cla1'] = $cla1;
			$a['chap'][$chap]['cla2'] = $cla2;
			$a['chap'][$chap]['sty1'] = $sty1;
			$a['chap'][$chap]['sty2'] = $sty2;
			foreach($b['chap'] as $r)
				{
				if($r['d']==$chap)
					{
					$w = strtr(utf8_decode($r['t']),'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ','aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby');
					$w = preg_replace('/[^a-zA-Z0-9%]/s','',$w);
					$a['chap'][$chap]['na'] = $w;
					}
				}
			}
		$out = json_encode($a);
		if(file_put_contents('../../data/'.$Ubusy.'/transition.json', $out)) echo T_('Backup performed');
		else echo '!'.T_('Impossible backup');
		break;
		// ********************************************************************************************
		case 'saveConf':
		$duration = (!empty($_POST['duration'])?intval($_POST['duration']):'1');
		$delay = (!empty($_POST['delay'])?intval($_POST['delay']):'0');
		$ratio = (!empty($_POST['ratio'])?strip_tags($_POST['ratio']):'0.4');
		$q = file_get_contents('../../data/'.$Ubusy.'/transition.json'); $a = json_decode($q,true);
		$a['duration'] = $duration;
		$a['delay'] = $delay;
		$a['ratio'] = $ratio;
		$out = json_encode($a);
		if(file_put_contents('../../data/'.$Ubusy.'/transition.json', $out)) echo T_('Backup performed');
		else echo '!'.T_('Impossible backup');
		break;
		// ********************************************************************************************
		}
	clearstatcache();
	exit;
	}
?>
