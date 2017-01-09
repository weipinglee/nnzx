
function Area(){

    this.province_arr = '';
    this.city_arr     = '';
    this.district_arr = '';
    this.inputName = '';

    this.initComplexArea = function (a, k, h,area,inputName) {
        this.inputName = inputName;
        var areaData= getAreaData();
        this.province_arr = areaData[0];
        this.city_arr     = areaData[1];
        this.district_arr = areaData[2];

        var f = this.initComplexArea.arguments;
        var m = document.getElementById(a);
        var o = document.getElementById(k);
        var n = document.getElementById(h);

        var p =  this.province_arr;
        var q = this.city_arr;
        var dis_arr = this.district_arr;
        var e = 0;
        var c = 0;
        var d = 0;
        var b = 0;
        var l = 0;
        if (p != undefined) {
            if (area != undefined) {
                d = parseInt(area.substring(0,2));
                if(area.length>3) b = parseInt(area.substring(0,4));
                if(area.length>5) l = parseInt(area.substring(0,6));
                if(area!='' && l==0)
                        document.getElementById(h+'_div').style.display='none';
             }
            o[0] = new Option("请选择", 0);
            n[0] = new Option("请选择 ", 0);
            for (e = 0; e < p.length; e++) {
                if (p[e] == undefined) {
                    continue;
                }

                m[c] = new Option(p[e], e);
                if (d == e) {
                    m[c].selected = true;

                }
                c++;
            }

            if (q[d] != undefined) {

                o[0] = new Option(q[d][0], 0);
                c = 1;
                for (e = d*100; e < q[d].length; e++) {
                    if (q[d][e] == undefined) { continue; }
                     o[c] = new Option(q[d][e], e);
                    if (b == e) { o[c].selected = true }
                    c++;
                }
            }

            if(dis_arr[b]!= undefined){
                n[0] = new Option(dis_arr[b][0], 0);
                c = 1;
                for (e = b*100; e < dis_arr[b].length; e++) {
                    if (dis_arr[b][e] == undefined) { continue; }
                    n[c] = new Option(dis_arr[b][e], e);
                    if (l == e) { n[c].selected = true }
                    c++;
                }

            }
        }
    }
    this.changeComplexProvince = function (f, e, d) {
        this.setAreaInput(f);
        var k = this.city_arr;
        var c = this.changeComplexProvince.arguments; var h = document.getElementById(e);
        var g = document.getElementById(d); var b = 0; var a = 0; this.removeOptions(h); f = parseInt(f);
        if (k[f] != undefined) {
            for (b = 0; b < k[f].length; b++) {
                if (k[f][b] == undefined) { continue }
                if (c[3]) { if ((c[3] == true) && (f != 71) && (f != 81) && (f != 82)) { if ((b % 100) == 0) { continue } } }
                h[a] = new Option(k[f][b], b); a++
            }
        }
        this.removeOptions(g); g[0] = new Option("请选择 ", 0);
        if (  f == 71 || f == 81 || f == 82) {
            if ($("#" + d + "_div"))
            { $("#" + d + "_div").hide(); }
        }
        else {
            if ($("#" + d + "_div")) { $("#" + d + "_div").show(); }
        }
    }




    this.changeCity = function (c, a, t) {
        this.setAreaInput(c);
        $("#" + a).html('<option value="0" >请选择</option>');
        $("#" + a).unbind("change");
        c = parseInt(c);
        var _d = this.district_arr[c];
        if(_d){
            $("#" + a).parent('span').show();
            var str = "";
            str += "<option value='0' >请选择</option>";
            for (var i = c * 100; i < _d.length; i++) {
                if (_d[i] == undefined) continue;
                str += "<option value='" + i + "' >" + _d[i] + "</option>";
            }
            $("#" + a).html(str);
        }
        else{
            $("#" + a).parent('span').hide();
        }

    }

    this.changeDistrict = function (v){
        this.setAreaInput(v,'check');
    }

    this.removeOptions = function (c) {
        if ((c != undefined) && (c.options != undefined)) {
            var a = c.options.length;
            for (var b = 0; b < a; b++) {
                c.options[0] = null;
            }
        }
    }

    //设置input的值
    this.setAreaInput = function (v,check){
        var inputObj = $('input[name='+this.inputName+']');
        inputObj.val(v);
        if(check!=undefined)inputObj.trigger('change');
    }

    /**
     *获取地区中文
     * @param code 地区代码
     * @param sep 分隔符，默认为空
     */
    this.getAreaText = function (code,sep){
        var areaData= getAreaData();
        var pro_text = areaData[0][code.slice(0,2)];
        if(code.length>3)
            var city_text = areaData[1][code.slice(0,2)][code.slice(0,4)];
        if(code.length>5)
            var area_text = areaData[2][code.slice(0,4)][code];


        if(sep==undefined){
            sep = ' ';
        }
        if(pro_text==undefined || pro_text=='请选择'){
            return '';
        }
        else if(city_text==undefined || city_text=='请选择'){
            return pro_text+sep;
        }
        else if(area_text==undefined || area_text=='请选择'){
            return pro_text+sep+city_text;
        }
        else
        return pro_text+sep+city_text+sep+area_text;

    }


}

