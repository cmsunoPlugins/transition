//
// CMSUno
// Plugin Transition
//
function transition_load(){
	jQuery(document).ready(function(){
		jQuery.ajax({type:'POST',url:'uno/plugins/transition/transition.php',data:{'action':'load','unox':Unox},dataType:'json',async:true,success:function(r){
			jQuery("#transitionLoad table tr").slice(1).remove();
			jQuery.each(r.chap,function(k,v){
				var tr=document.createElement('tr');
				var td=document.createElement('td');td.innerHTML=v.tit;tr.appendChild(td);
				td=document.createElement('td');td.innerHTML=v.tr;tr.appendChild(td);
				td=document.createElement('td');td.innerHTML=v.im;tr.appendChild(td);
				tr.appendChild(td);
				jQuery("#transitionLoad table").append(tr);
			});
			document.getElementById("transitionDuration").value=r.duration;
			document.getElementById("transitionDelay").value=r.delay;
			document.getElementById("transitionRatio").value=r.ratio;
		}});
	});
}
function transition_save(){
	var typ=document.getElementById("transitionType"),chap=document.getElementById("transitionChap");
	jQuery.post('uno/plugins/transition/transition.php',{
		'action':'save',
		'unox':Unox,
		'chap':chap.options[chap.selectedIndex].value,
		'typ':typ.options[typ.selectedIndex].value,
		'img':document.getElementById("transitionImg").value
	},function(r){
		f_alert(r);
		transition_load();
	});
}
function transition_save_config(){
	jQuery.post('uno/plugins/transition/transition.php',{
		'action':'saveConf',
		'unox':Unox,
		'duration':parseInt(document.getElementById("transitionDuration").value),
		'delay':parseInt(document.getElementById("transitionDelay").value),
		'ratio':document.getElementById("transitionRatio").value
	},function(r){
		f_alert(r);
	});
}
//
transition_load();
