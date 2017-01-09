/*插入省市区三级联动*/
window.onload=function(){
    setup();
    preselect('');
    promptinfo();
}

 function promptinfo(){
  var address = document.getElementById('address');
  var s1 = document.getElementById('s1');
  var s2 = document.getElementById('s2');
  var s3 = document.getElementById('s3');
  address.value = s1.value + s2.value + s3.value;
}
/*插入省市区三级联动*/