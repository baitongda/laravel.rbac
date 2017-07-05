/**
 * 后台公共JS函数库
 *
 */

function confirmurl(url,message,is_ajax=false) {
	window.top.art.dialog.confirm(message, function(){
		if(is_ajax)
			ajax(url)
		else
			redirect(url);
	}, function(){
	    return true;
	});
	//if(confirm(message)) redirect(url);
}

/**
 * @param url 跳转链接 如果当前 跳转地址 == 预跳转链接 就刷新页面
 */
function redirect(url) {
	if(url == location.href)
		window.location.reload();
	else
		location.href = url;
}

/**
 * 全选checkbox,注意：标识checkbox id固定为为check_box
 * @param string name 列表check名称,如 uid[]
 */
function selectall(name) {
	if ($("#check_box").attr("checked")=='checked') {
		$("input[name='"+name+"']").each(function() {
  			$(this).attr("checked","checked");
			
		});
	} else {
		$("input[name='"+name+"']").each(function() {
  			$(this).removeAttr("checked");
		});
	}
}
function openwinx(url,name,w,h) {
	if(!w) w=screen.width-4;
	if(!h) h=screen.height-95;
    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=no");
}

//表单提交时弹出确认消息
function submit_confirm(id,msg,w,h){
	if(!w) w=250;
	if(!h) h=100;
	  window.top.art.dialog({
      content:msg,
      lock:true,
      width:w,
      height:h,
      ok:function(){
        $("#"+id).submit();
        return true;
      },
      cancel: true
    });
}

/**
 *成功
 * @param mess 信息
 * @param afterHidden 回调函数
 */
function success(mess,afterHidden) {
	toast('Success',mess,'success',afterHidden,2000);
}

/**
 *错误
 * @param mess 信息
 * @param afterHidden 回调函数
 */
function error(mess,afterHidden) {
	toast('Error',mess,'error',afterHidden,3000);
}

/**
 * 警告
 * @param mess
 * @param afterHidden
 */
function warn(mess,afterHidden) {
	toast('Warn',mess,'warning',afterHidden,2000);
}

/**
 *
 * @param heading
 * @param mess
 * @param icon
 * @param afterHidden 回调函数
 * @param hideAfter 停留时间
 */
function toast(heading,mess,icon,afterHidden,hideAfter) {
	window.top.$.toast({heading: heading, showHideTransition: 'slide', hideAfter: hideAfter, text: mess,icon: icon,position: 'top-right',afterHidden:afterHidden})
}

/**
 * 表单请求函数
 * @param form_id
 * @returns {boolean}
 */
function ajax_form(form_id) {
	if(!form_id) return false;
	$('.bginput').attr("disabled","disabled");//禁止重复提交表单
	$("#" + form_id).ajaxSubmit({
		success : function (data) {
			if(data.code == 1) {success(data.msg,function() {if(data.url) {redirect(data.url);}$('.bginput').removeAttr("disabled");})}
			else if(data.code == 2) {warn(data.msg,function() {if(data.url) {redirect(data.url);}})}
			else {error(data.msg,function() {if(data.url) {redirect(data.url);}$('.bginput').removeAttr("disabled");});}
		},
		error : function(XmlHttpRequest, textStatus, errorThrown){var json = JSON.parse(XmlHttpRequest.responseText);for(var i in json) {error(json[i][0],function() {});$('.bginput').removeAttr("disabled");}}
	});
}

/**
 * ajax请求函数
 * @param url
 * @param data
 * @param method
 */
function ajax(url,data=[],method='get') {
	$.ajax({
		url : url,
		method : method,
		data : data,
		success : function (data) {
			if(data.code == 1) {success(data.msg,function() {if(data.url) {redirect(data.url);}})}
			else if(data.code == 2) {warn(data.msg,function() {if(data.url) {redirect(data.url);}})}
			else {error(data.msg,function() {if(data.url) {redirect(data.url);}});}
		},
		error : function(XmlHttpRequest, textStatus, errorThrown){var json = JSON.parse(XmlHttpRequest.responseText);for(var i in json) {error(json[i][0],function() {});}}
	});
}