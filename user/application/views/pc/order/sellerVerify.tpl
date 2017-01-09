<style type="text/css">
	div#verify{width: 50%;margin:0 auto;padding: 50px;height: 200px;border: 1px solid;}
	div#verify>p{width: 100%;line-height: 30px;}
	
	div#verify>a {
    margin: 50px 0 0 50px;
    text-align: center;
      font-size: 16px;
      color: #fff;
      background: #D61515;
      display: block;
      float:left;
      width: 120px;
      height: 35px;
      line-height: 35px;
      border: 0px;
}
</style>

<div id='verify'>
	<p>扣减金额：&emsp;{$data['reduce_amount']}</p>
	<p>说明&emsp;&emsp;：&emsp;{$data['reduce_remark']}</p>

  <a href="{url:/Order/sellerVerify?order_id=$data['id']}" confirm>同意</a> 
	<a href="{url:/Order/sellerVerify?order_id=$data['id']&disagree=1}" confirm>不同意</a>	
</div>   