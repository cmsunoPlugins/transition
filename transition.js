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
				td=document.createElement('td');if(v.cla1+v.sty1!='')td.innerHTML='<span style="color:#2F4F4F">'+v.cla1+'</span><br><span style="color:#8B4513">'+v.sty1+'</span>';else td.innerHTML='&nbsp;';tr.appendChild(td);
				td=document.createElement('td');if(v.cla2+v.sty2!='')td.innerHTML='<span style="color:#2F4F4F">'+v.cla2+'</span><br><span style="color:#8B4513">'+v.sty2+'</span>';tr.appendChild(td);
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
		'img':document.getElementById("transitionImg").value,
		'cla1':document.getElementById("transitionCL1").value,
		'cla2':document.getElementById("transitionCL2").value,
		'sty1':document.getElementById("transitionST1").value,
		'sty2':document.getElementById("transitionST2").value
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
