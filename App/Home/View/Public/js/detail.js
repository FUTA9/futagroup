$(function(){
	$('#addCart').click(function(){
		var url = $(this).attr('url');
		$.ajax({
			url:url,
			dataType:'html',
			success:function(result){
           		var result = eval('(' + result + ')'); 
                if(result.status === true){
					alert('添加到购物车成功！');
				}else{
					alert('添加购物车失败！');
				}
			}
		})
	
	})
	
	$('#addCollect').click(function(){
		if(!'userIsLogin === false'){
			alert('请先登录！');
			return false;
		}
		var url = $(this).attr('url');
		$.ajax({
			url:url,
			dataType:'json',
			success:function(result){
				if(result.status === true){
					'showInfoWindow(collectSucc)';
					alert('收藏成功');
				}else{
					alert('添加收藏失败！');
				}
			}
		})
	
	})


})




/**
 * 显示信息提示框
 * @param html
 */
function showInfoWindow(html){
	$('#infoWindow').show().css({
		top:$(window).scrollTop()+Math.floor(($(window).height()-$('#infoWindow').innerHeight())/2)
	})
	$('#cover').show().css({
		width:$(window).width(),
		height:$(document).height(),
		position:'absolute',
		left:0,
		top:0,
		background:'#333',
		opacity:0.3,
		zIndex:10000
	})
	$('#infoWindow').html(html);
}
/**
 * 隐藏信息提示框
 */
function hideInfoWindow(){
	$('#infoWindow').hide();
	$('#cover').hide();
}



//刪除評論
$(function(){
	$('body').on('click','#delCommentss',function(){
		var url = $(this).attr('delCommentView');
		var commentID = $(this).attr('delCommentId');
		$.ajax({
			url:url,
			data:'comment='+commentID,
			dataType:'json',
			type:'post',
			success:function(result){
				var result = eval('(' + result + ')');
				if(result.status == true){
					$(self).parents('li').remove();
				}else{
					alert('刪除失敗！');
				}
			}
		})
	})
})