<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="{root:js/jquery/jquery-1.7.2.min.js}"></script>
    <script type="text/javascript" src="{root:js/ajaxfileupload.js}"></script>
</head>

<body>
<form action='{url:/fund/doFundIn}' method='post' enctype="multipart/form-data" />
金额<input type='text' name='recharge'>
<input type='radio' name='payment_id' value='1' />线下
<input type='radio' name='payment_id' value='3' />银联
<input type='radio' name='payment_id' value='8' />支付宝
<br />
<input type='file' name='proot' />
<input type='submit' value='tijiao'>
</form>
</body>
</html>