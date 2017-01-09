/*邮箱正则*/
                         $(function(){
                         $(":input[name='email']").blur(function(){
                        var email = $(this).val();
                        var reg = /\w+[@]{1}\w+[.]\w+/;
                       if(reg.test(email)){
                        $(":input[name='check']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='check']").val("输入错误，请输入正确的email地址");
                              }
                           });
                        });
                       

/*真实姓名正则*/
                         $(function(){
                         $(":input[name='realname']").blur(function(){
                        var realname = $(this).val();
                        var reg =/^[\u4E00-\u9FA5]{2,5}(?:·[\u4E00-\u9FA5]{2,5})*$/;
                       if(reg.test(realname)){
                        $(":input[name='checka']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checka']").val("输入错误，包括2-5个汉字");
                              }
                           });
                        });
                      
/*用户名正则*/

                         $(function(){
                         $(":input[name='username']").blur(function(){
                        var username = $(this).val();
                        var reg =/^\w{4,16}$/;
                       if(reg.test(username)){
                        $(":input[name='checkb']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkb']").val("输入错误，4-16位字符,英文 数字 下划线的组合");
                              }
                           });
                        });
                       
/*原始密码正则*/
                         $(function(){
                         $(":input[name='origin_password']").blur(function(){
                        var origin_password = $(this).val();
                        var reg =/^[a-zA-Z]{1}([a-zA-Z0-9]|[*_ # @ % $ &  = +]){4,14}[a-zA-Z0-9]{1}$/;
                       if(reg.test(origin_password)){
                        $(":input[name='checkc']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkc']").val("输入错误，6-16个字符,包括数字 下划线 字母和常用特殊字符");
                              }
                           });
                        });
                       

/*新密码正则*/
                         $(function(){
                         $(":input[name='new_password']").blur(function(){
                        var new_password = $(this).val();
                        var reg =/^[a-zA-Z]{1}([a-zA-Z0-9]|[*_ # @ % $ &  = +]){4,14}[a-zA-Z0-9]{1}$/;
                       if(reg.test(new_password)){
                        $(":input[name='checkd']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkd']").val("输入错误，6-16个字符,包括数字 下划线 字母和常用特殊字符");
                              }
                           });
                        });
                                             
/*确认新密码正则*/
                         $(function(){
                         $(":input[name='firm_password']").blur(function(){
                        var firm_password = $(this).val();
                        var reg =/^[a-zA-Z]{1}([a-zA-Z0-9]|[*_ # @ % $ &  = +]){4,14}[a-zA-Z0-9]{1}$/;
                       if(reg.test(firm_password)){
                        $(":input[name='checke']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checke']").val("输入错误，6-16个字符,包括数字 下划线 字母和常用特殊字符");
                              }
                           });
                        });
/*交易号*/
                         $(function(){
                         $(":input[name='tran_saction']").blur(function(){
                        var tran_saction = $(this).val();
                        var reg =/^[A-Za-z0-9]+$/
                       if(reg.test(tran_saction)){
                        $(":input[name='checkee']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkee']").val("输入错误，只能输入字母,数字或字母数字组合");
                              }
                           });
                        });
                       
/*汉语名*/
                         $(function(){
                         $(":input[name='name_china']").blur(function(){
                        var name_china = $(this).val();
                        var reg =/^[\u4E00-\u9FA5]{2,6}$/;
                       if(reg.test(name_china)){
                        $(":input[name='checkf']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkf']").val("输入错误，只能是汉字并且在2-6位之间");
                              }
                           });
                        });
                       
/*英文名*/
                         $(function(){
                         $(":input[name='name_eng']").blur(function(){
                        var name_eng = $(this).val();
                        var reg =/^\S+[a-z A-Z]$/;  
                       if(reg.test(name_eng)){
                        $(":input[name='checkg']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkg']").val("输入错误，不能为空 不能有空格 只能是英文字母 ");
                              }
                           });
                        });
                       
/*手机号*/
                         $(function(){
                         $(":input[name='mobile_no']").blur(function(){
                        var mobile_no = $(this).val();
                        var reg =/^1[3|4|5|7|8][0-9]\d{4,8}$/;  
                       if(reg.test(mobile_no)){
                        $(":input[name='checkh']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkh']").val("输入错误，不是完整的11位手机号或者正确的手机号前七位");
                              }
                           });
                        });
                      
/*发布商品手机号*/
                         $(function(){
                         $(":input[name='mobile_num']").blur(function(){
                        var mobile_num = $(this).val();
                        var reg =/^1[3|4|5|7|8][0-9]\d{4,8}$/;  
                       if(reg.test(mobile_num)){
                        $(":input[name='checkt']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkt']").val("输入错误，不是正确的手机号");
                              }
                           });
                        });

/*电话号*/
                         $(function(){
                         $(":input[name='phone_no']").blur(function(){
                        var phone_no = $(this).val();
                        var reg =/^(\(\d{3,4}\)|\d{3,4}-)?\d{7,8}$/;  
                       if(reg.test(phone_no)){
                        $(":input[name='checki']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checki']").val("您输入的电话号码错误!");
                              }
                           });
                        });
                           
/*年龄*/
                         $(function(){
                         $(":input[name='age_no']").blur(function(){
                        var age_no = $(this).val();
                        var reg =/^([0-9]|[0-9]{2}|100)$/;  
                       if(reg.test(age_no)){
                        $(":input[name='checkj']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkj']").val("输入错误，年龄在0-100之间!");
                              }
                           });
                        });
                             
/*QQ号码*/
                         $(function(){
                         $(":input[name='qq_no']").blur(function(){
                        var qq_no = $(this).val();
                        var reg =/^[1-9]\d{4,10}$/;
                       if(reg.test(qq_no)){
                        $(":input[name='checkk']").val("恭喜！QQ号码输入正确");
                       }else{
                         $(":input[name='checkk']").val("对不起，您输入的QQ号码格式错误!");
                              }
                           });
                        });
                               
/*公司名称*/
                         $(function(){
                         $(":input[name='company_name']").blur(function(){
                        var company_name = $(this).val();
                        var reg =/^[\u4E00-\u9FA5]{5,30}(?:·[\u4E00-\u9FA5]{5,30})*$/;
                       if(reg.test(company_name)){
                        $(":input[name='checkl']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkl']").val("输入错误，请输入正确公司名称");
                              }
                           });
                        });
                          
 /*联系人名称*/
                         $(function(){
                         $(":input[name='link_name']").blur(function(){
                        var link_name = $(this).val();
                        var reg =/^[\u4E00-\u9FA5]{2,5}(?:·[\u4E00-\u9FA5]{2,5})*$/;
                       if(reg.test(link_name)){
                        $(":input[name='checkm']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkm']").val("输入错误，包括2-5个汉字");
                              }
                           });
                        });
                     
/*代理商名称*/
                         $(function(){
                         $(":input[name='shang_agent']").blur(function(){
                        var shang_agent = $(this).val();
                        var reg =/^[\u4E00-\u9FA5]{5,30}(?:·[\u4E00-\u9FA5]{5,30})*$/;
                       if(reg.test(shang_agent)){
                        $(":input[name='checkn']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkn']").val("输入错误，请输入正确代理商名称");
                              }
                           });
                        });
 /*单价*/                     
                      $(function(){
                         $(":input[name='unit_price']").blur(function(){
                        var unit_price = $(this).val();
                        var reg =/^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/;
                       if(reg.test(unit_price)){
                        $(":input[name='checko']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checko']").val("输入错误，小于等于99999999.99 的数字");
                              }
                           });
                        });
/*传真*/                 
                      $(function(){
                         $(":input[name='fax_no']").blur(function(){
                        var fax_no = $(this).val();
                        var reg =/^((\+?[0-9]{2,4}\-[0-9]{3,4}\-)|([0-9]{3,4}\-))?([0-9]{7,8})(\-[0-9]+)?$/;
                       if(reg.test(fax_no)){
                        $(":input[name='checkp']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkp']").val("对不起，您输入的传真号码格式错误");
                              }
                           });
                        });
/*邮编号*/             
                     $(function(){
                         $(":input[name='zip_no']").blur(function(){
                        var zip_no = $(this).val();
                        var reg =/^[1-9][0-9]{5}$/;
                       if(reg.test(zip_no)){
                        $(":input[name='checkq']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkq']").val("对不起，您输入的邮政编码格式错误");
                              }
                           });
                        }); 
 /*货名*/                               
                     $(function(){
                         $(":input[name='warename']").blur(function(){
                        var warename = $(this).val();
                        var reg =/^\S+$/gi; 
                       if(reg.test(warename)){
                        $(":input[name='checkr']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checkr']").val("输入错误，不允许有空格");
                              }
                           });
                        });         
/*供货总量*/                               
                     $(function(){
                         $(":input[name='weight']").blur(function(){
                        var weight = $(this).val();
                        var reg =/^\S+$/gi; 
                       if(reg.test(weight)){
                        $(":input[name='checks']").val("恭喜！输入正确");
                       }else{
                         $(":input[name='checks']").val("输入错误，不允许有空格");
                              }
                           });
                        });                              