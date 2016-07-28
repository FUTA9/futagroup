$(function(){
	$('.reduce').click(function(){
        var oGoodsNum = $(this).parent().find('.goodsNum');
        var goodsNum = Number(oGoodsNum.val())-1;
		ajaxUpdateGoodsNum(goodsNum,oGoodsNum)
	})
	$('.add').click(function(){
		var oGoodsNum  = $(this).parent().find('.goodsNum');
		var goodsNum =  Number(oGoodsNum.val())+1;
		ajaxUpdateGoodsNum(goodsNum,oGoodsNum);
	})

	/*
	 异步更新购物车数量
	*/
	function ajaxUpdateGoodsNum(goodsNum,oGoodsNum){
		if(goodsNum <=0){
			return false;
		}
		var url = oGoodsNum.attr('url');
        var gid = oGoodsNum.attr('gid');
        $.ajax({
           url:url,
           type:'POST',
           data:'gid='+gid+'&num='+goodsNum,
           dataType:'json',
           success:function(result){
               if(result.status === true){
					oGoodsNum.val(result.num);
				}
           }
        })
	}



	//订单点击更新总价
	$('#reduce').click(function(){
		
		var oldGoodsNum = $('#goods_num').val();
		var oldPrice = $('#goodsPrice').text();
		var allPrice = parseInt(oldPrice)*oldGoodsNum;
		$('#allPrice').text(allPrice);

		/*
		var oldGoodsNum = goods_num.value;
		var oldPrice = document.getElementById('goodsPrice').value;
		var allGoodsNum = Number(oldGoodsNum)*Number(oldPrice); 
		document.getElementById("allPrice").innerHTML = allGoodsNum;
		*/
	})

	$('#add').click(function(){
		var oldGoodsNum = $('#goods_num').val();
		var oldPrice = $('#goodsPrice').text();
		var allPrice = parseInt(oldPrice)*oldGoodsNum;
		$('#allPrice').text(allPrice);
		/*
		var oldGoodsNum = goods_num.value;
		var oldPrice = document.getElementById('goodsPrice').value;
		var allGoodsNum = Number(oldGoodsNum)*Number(oldPrice); 
		document.getElementById("allPrice").innerHTML = allGoodsNum;
		*/
	})

	
	
	//购物车更新总价
	$('#reduces').click(function(){
		if($('.goodsNum').val() == 1){
			return;
		}
		var oldGoodsNum = $('.goodsNum').val();
		oldGoodsNum--;
		var oldPrice = $('#goodsPrice').text();
		var allPrice = parseInt(oldPrice)*oldGoodsNum;
		$('#allPrices').text(allPrice);
		$('#allPrice').text(allPrice);
		/*
		if(goods_num.value == 1){
			return;
		}
		var oldGoodsNum = goods_num.value-1;
		var oldPrice = document.getElementById('goodsPrice').value;
		var allGoodsNum = Number(oldGoodsNum)*Number(oldPrice); 
		document.getElementById("allPrices").innerHTML = allGoodsNum;
		document.getElementById("allPrice").innerHTML = allGoodsNum;
		*/
	
	})

	$('#adds').click(function(){
		var number = $('.goodsNum').val();
		number++;
		var price = $('#goodsPrice').text();
		var allPrice = parseInt(price) * number;
		$('#allPrices').text(allPrice);
		$('#allPrice').text(allPrice);
		// var oldGoodsNum = goods_num.value;
		// var addss = Number(oldGoodsNum)+ 1
		// alert(goods_num.value);
		// var oldPrice = document.getElementById('goodsPrice').value;
		// var allGoodsNum = Number(addss)*Number(oldPrice); 
		// document.getElementById("allPrices").innerHTML = allGoodsNum;
		// document.getElementById("allPrice").innerHTML = allGoodsNum;
	})
	

})