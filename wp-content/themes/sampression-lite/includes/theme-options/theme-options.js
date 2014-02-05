/**
Author: Sampression
Author URI: sampression.com
This Script helps in Theme Options to make the Browse button functional and like wise...
*/
var regmails = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,6}$/;
jQuery(document).ready(function() {
// Upload Files
jQuery('.upload_image_button').click(function() {
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			if(imageholder){
				imageholder.attr('src',imgurl);
			}
			formvar.val(imgurl);
			tb_remove();
		}
		formfield = jQuery(this).prev('.upload_image').attr('name');
		formvar = jQuery(this).prev('.upload_image');
		imageholder = jQuery(this).parent().find('.image-holder img');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});	

/* Simple Tabination */	
//Default Action
	jQuery(".tab_content").hide(); //Hide all content
	
	if( jQuery.cookie("active-tab")!=null){		
		var lastActiveTab = jQuery.cookie("active-tab"); //retriving cookie value
		//alert(lastActiveTab);
		jQuery("ul.tabs li a[href="+lastActiveTab+"]").parent().addClass("active"); //Activate tab from cookie value
		jQuery(lastActiveTab).show();
	} else {		
		jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
		jQuery(".tab_content:first").show(); //Show first tab content
	} 
	
	//On Click Event
	jQuery("ul.tabs li").click(function() {
		jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
		jQuery(this).addClass("active"); //Add "active" class to selected tab
		jQuery(".tab_content").hide(); //Hide all tab content
		var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		jQuery(activeTab).fadeIn(); //Fade in the active content
		jQuery.cookie("active-tab", activeTab, { expires: 1 });
		return false;
	});
	
	jQuery(".tab_container input[type='checkbox']").click(function(){
		var $chkbox = jQuery(this),
			$hiddenbox = $chkbox.next("input[type='hidden']");
		if($chkbox.is(':checked')){
			jQuery($hiddenbox).val('yes');
		}else{
			jQuery($hiddenbox).val('no');
		}
	});
});

function trigger(obj){
	jQuery.cookie("active", obj , { expires: 1 });
}

// Theme Option: 
function load_theme_action(act) {
	window.document.getElementById('sampression_theme_action').value = act;
	if(act == 'restore') {
		var ans = confirm("You are about to re-store default settings.\nDo you want to continue?");
		if(ans) {
			window.document.frm_theme_option.submit();
		} else {
			return false;
		}
		return false;
	} else if (act == 'support') {
		with(window.document.frm_theme_option) {
			window.document.getElementById('support_error_msg').innerHTML="";
			if(isEmpty(fullname, "Please enter your full name.", 'support_error_msg')) {
				return false;
			}
			if(!regmails.test(emailadd.value)) {
				window.document.getElementById('support_error_msg').innerHTML="Please enter your valid Email Id.";
				emailadd.select();
				return false;
			}
			if(isEmpty(emailsubj, "Please enter your email subject.", 'support_error_msg')) {
				return false;
			}
			if(isEmpty(emailmsg, "Please enter your message.", 'support_error_msg')) {
				return false;
			}
		}
		window.document.frm_theme_option.submit();
	} else {
		window.document.frm_theme_option.submit();
	}
}

function check_frontend_logo() {
	if(window.document.getElementById('logo_front_end').checked == true) {
		window.document.getElementById('sam_use_logo').value = 'yes';
	} else {
		window.document.getElementById('sam_use_logo').value = 'no';
	}
}

function isEmpty(formElement, message, res_id) {
	formElement.value = trim(formElement.value);
	var _isEmpty = false;
	if (formElement.value == '') {
		_isEmpty = true;
		//alert(message);
		window.document.getElementById(res_id).innerHTML=message;
		formElement.focus();
	}
	return _isEmpty;
}
function trim(str) {
	return str.replace(/^\s+|\s+$/g,'');
}