/// <reference path="jquery-1.4.4.min.js" />
/*
* jQuery扩展
*
* Last Modified 2012/11/25
* By hongfei
*/
(function () {
    var host = "http://" + location.host;
    if (!window.UrlContext) {
        window.UrlContext = {};
    }
    if (!window.ApiContext) {
        window.ApiContext = {};
    }
    if (!window.siteDomain) {
        window.siteDomain = "";
    }
    if (!window.siteImgHost) {
        window.siteImgHost = "";
    }
    $.extend({
        config: {
            oriDomain: document.domain,
            domain: window.siteDomain,
            host: {
                web: host || '',
                misc: window.miscHost || '',
                img: window.siteImgHost || '',
                curr: window.currHost || ''
            },
            urlContext: UrlContext,
            apiContext: ApiContext,
            ie6CrossDomainUrl: window.siteImgHost + "/domain"  // 需要跨域上传时，设置为目标上传站点的跨域页面，“/domain”
        },
        tmp: {}
    });
    UrlContext = null;
    ApiContext = null;
})();

(function () {

    /*=======================================================================*/
    /* 定时执行,使用方法： Baidu OR Google jquery timer插件。
    /*=======================================================================*/
    jQuery.fn.extend({
        everyTime: function (interval, label, fn, times) {
            return this.each(function () {
                jQuery.timer.add(this, interval, label, fn, times);
            });
        },
        oneTime: function (interval, label, fn) {
            return this.each(function () {
                jQuery.timer.add(this, interval, label, fn, 1);
            });
        },
        stopTime: function (label, fn) {
            return this.each(function () {
                jQuery.timer.remove(this, label, fn);
            });
        }
    });

    jQuery.extend({
        timer: {
            global: [],
            guid: 1,
            dataKey: "jQuery.timer",
            regex: /^([0-9]+(?:\.[0-9]*)?)\s*(.*s)?$/,
            powers: {
                // Yeah this is major overkill...
                'ms': 1,
                'cs': 10,
                'ds': 100,
                's': 1000,
                'das': 10000,
                'hs': 100000,
                'ks': 1000000
            },
            timeParse: function (value) {
                if (value == undefined || value == null)
                    return null;
                var result = this.regex.exec(jQuery.trim(value.toString()));
                if (result[2]) {
                    var num = parseFloat(result[1]);
                    var mult = this.powers[result[2]] || 1;
                    return num * mult;
                } else {
                    return value;
                }
            },
            add: function (element, interval, label, fn, times) {
                var counter = 0;

                if (jQuery.isFunction(label)) {
                    if (!times)
                        times = fn;
                    fn = label;
                    label = interval;
                }

                interval = jQuery.timer.timeParse(interval);

                if (typeof interval != 'number' || isNaN(interval) || interval < 0)
                    return;

                if (typeof times != 'number' || isNaN(times) || times < 0)
                    times = 0;

                times = times || 0;

                var timers = jQuery.data(element, this.dataKey) || jQuery.data(element, this.dataKey, {});

                if (!timers[label])
                    timers[label] = {};

                fn.timerID = fn.timerID || this.guid++;

                var handler = function () {
                    if ((++counter > times && times !== 0) || fn.call(element, counter) === false)
                        jQuery.timer.remove(element, label, fn);
                };

                handler.timerID = fn.timerID;

                if (!timers[label][fn.timerID])
                    timers[label][fn.timerID] = window.setInterval(handler, interval);

                this.global.push(element);

            },
            remove: function (element, label, fn) {
                var timers = jQuery.data(element, this.dataKey), ret;

                if (timers) {

                    if (!label) {
                        for (label in timers)
                            this.remove(element, label, fn);
                    } else if (timers[label]) {
                        if (fn) {
                            if (fn.timerID) {
                                window.clearInterval(timers[label][fn.timerID]);
                                delete timers[label][fn.timerID];
                            }
                        } else {
                            for (var fn in timers[label]) {
                                window.clearInterval(timers[label][fn]);
                                delete timers[label][fn];
                            }
                        }

                        for (ret in timers[label]) break;
                        if (!ret) {
                            ret = null;
                            delete timers[label];
                        }
                    }

                    for (ret in timers) break;
                    if (!ret)
                        jQuery.removeData(element, this.dataKey);
                }
            }
        }
    });




    // ie6缓存背景图
    if ($.browser.msie && $.browser.version < 7) {
        try {
            document.execCommand("BackgroundImageCache", false, true);
        } catch (e) { }
    }
    /*=======================================================================*/
    /* 扩展jQuery对象 */
    /*=======================================================================*/
    $.fn.extend({
        // textarea闪烁背景
        // 必须给textarea的background-color设置默认值，才可兼容全浏览器
        blogError: function (endColor) {
            if (this.attr('tagName') != 'TEXTAREA') {
                return;
            }
            this.animate({ backgroundColor: 'pink' }, 200)
                .animate({ backgroundColor: endColor }, 200)
                .animate({ backgroundColor: 'pink' }, 200)
                .animate({ backgroundColor: endColor }, 200);
            return this;
        },
        // 限制input:text，textarea的最大中文输入长度
        // 长度超过时将自动截断
        chnMaxLength: function (length) {
            function limit(e) {
                var $input = $(this);
                $.chnSubString($input, length);
            }
            this.keyup(limit);
            this.blur(limit);
            return this;
        },
        readonly: function () {
            this.css({
                "backgroundColor": "#f0f0f0",
                "color": "#000"
            });
            return this.attr('readonly', 'readonly');
        },
        disable: function () {
            this.css({
                "backgroundColor": "#f0f0f0",
                "color": "#000"
            });
            // TODO 还需区分input，textarea 与 自定义按钮
            return this.attr('disabled', 'disabled');
        },
        enable: function () {
            // TODO 还需区分input，textarea 与 自定义按钮
            return this.
                removeAttr('readonly').
                removeAttr('disabled').
                css({
                    "backgroundColor": "#fff"
                });
        },
        // 点击回车事件
        enter: function (func) {
            this.keyup(function (e) {
                if (e.keyCode == $.ui.keyCode.ENTER) {
                    return func(e);
                }
            });
            return this;
        },
        // 数字输入限制
        numberInput: (function () {
            var defaults = {
                decimal: false
            };
            function bindEvent($dom) {
                $dom.keydown(function (e) {
                    var $input = $(this);
                    var option = $input.data('numberInput_data');

                    // 屏蔽组合键
                    if (e.ctrlKey === true || e.shiftKey === true) {
                        return false;
                    }
                    var keyCode = e.keyCode;
                    if ((keyCode >= 48 && keyCode <= 57) ||
                        (keyCode >= 96 && keyCode <= 105) ||
                        (keyCode >= 33 && keyCode <= 40) ||
                        (keyCode >= 8 && keyCode <= 9) ||
                        (keyCode == 46) ||
                        (keyCode == 13)) {
                        return;
                    }

                    if (option.decimal === true &&
                        (keyCode == 190 || keyCode == 110)) {
                        return;
                    }

                    return false;
                });
            }
            return function (obj) {
                this.data('numberInput_data', $.mergeObject(defaults, obj));
                bindEvent(this);
            };
        })(),
        // 判断元素是否出现了x方向的滚动条
        isXScroll: function () {
            return this.attr('scrollWidth') > this.attr('clientWidth');
        },
        // 判断元素是否出现了y方向的滚动条
        isYScroll: function () {
            return this.attr('scrollHeight') > this.attr('clientHeight');
        },
        // 判断元素是否可见
        visible: function () {
            return this.is(':visible');
        },
        // 清除defaultvalue的样式
        clearDefaultValueStyle: function () {
            $.clearDefaultValueStyle(this);
            return this;
        },
        // 清除defaultvalue的值
        clearDefaultValue: function () {
            $.clearDefaultValue(this);
            return this;
        },
        // input出错时的提示    
        error: function (text, className) {
            $.inputErrorValue(
                this,
                text,
                (className == undefined ? 'ipt_error' : className));
            return this;
        },
        // input的默认提示
        tip: function (text, className, dontChangeClass) {
            $.inputDefaultValue(
                this,
                text,
                (className == undefined ? 'ipt_tip' : className),
                dontChangeClass);
            return this;
        }
    });

    /*=======================================================================*/
    /* 扩展jQuery本身*/
    /*=======================================================================*/

    $.extend({
        // 获取中文字符串长度
        // 参数str：待测量的字符串
        chnLength: function (str) {
            var byteLen = 0, i = 0, num = str.length;
            for (; i < num; i++, byteLen++) {
                if (str.charCodeAt(i) > 255) {
                    byteLen++;
                }
            }
            return byteLen;
        },
        // 截取中文长度
        // 参数source：待截取的字符串，或input：text
        // 参数length：截取长度
        chnSubString: function (source, length, curChnLength) {
            if (length <= 0) {
                return '';
            }
            var isInput = typeof source == 'string' ? false : true;
            var str = isInput ? source.val().trim() : source;
            length = length * 2;
            var byteLen = 0;
            var result = '';
            var needChange = false;
            var tmp = '';
            var i = 0, len = str.length;
            for (; i < len; i++) {
                byteLen++;
                tmp = 1;
                if (str.charCodeAt(i) > 255) {
                    byteLen++;
                    tmp++;
                }
                if (byteLen <= length) {
                    result += str.charAt(i);
                }
                if (byteLen > length) {
                    needChange = true;
                    byteLen = byteLen - tmp;
                    break;
                }
            }
            if (curChnLength) {
                curChnLength.length = Math.ceil(byteLen / 2);
            }
            if (needChange) {
                isInput && source.val(result);
            }
            return result;
        },
        // 清空input:file的值
        // 参数$file：input:file的jq对象
        clearFileInput: function ($file) {
            var file = $file[0];
            if (file.outerHTML) {
                try {
                    file.outerHTML = file.outerHTML;
                } catch (e) {
                    file.value = '';
                }
            } else {
                file.value = '';
            }
        },
        // 克隆对象
        // 参数obj：   待克隆的对象
        // 参数deep：  是否深度克隆
        cloneObject: function (obj, deep) {
            if (obj === null) {
                return null;
            }
            var con = new obj.constructor();
            var name;
            for (name in obj) {
                if (!deep) {
                    con[name] = obj[name];
                } else {
                    if (typeof (obj[name]) == "object") {
                        con[name] = $.cloneObject(obj[name], deep);
                    } else {
                        con[name] = obj[name];
                    }
                }
            }
            return con;
        },
        // 确保传入值为正数
        // 如果传入的参数小于0则返回0
        confirmPositive: function (val) {
            return val < 0 ? 0 : val;
        },
        // 获取字符串格式的当前时间
        getNow: function () {
            return $.dateFormat(null, "YYYY-MM-DD hh:mm:ss");
        },
        // 格式化日期: 'arg' is Date() obj, 'format' like "YYYY-MM-DD hh:mm:ss" or "YY-M-D h:m:s",
        dateFormat: function (arg, format) {
            if (!arg) {
                arg = new Date();
            }
            var Y = format.match(/[Y]+/);
            var M = format.match(/[M]+/);
            var D = format.match(/[D]+/);
            var h = format.match(/[h]+/);
            var m = format.match(/[m]+/);
            var s = format.match(/[s]+/);
            var year = Y == null ? "" : Y[0].length == 2 ? String(arg.getFullYear()).substring(2) : arg.getFullYear();
            var month = M == null ? "" : M[0].length == 1 ? (arg.getMonth() + 1) : (arg.getMonth() + 1) < 10 ? "0" + (arg.getMonth() + 1) : (arg.getMonth() + 1);
            var day = D == null ? "" : D[0].length == 1 ? arg.getDate() : arg.getDate() < 10 ? "0" + arg.getDate() : arg.getDate();
            var hour = h == null ? "" : h[0].length == 1 ? arg.getHours() : arg.getHours() < 10 ? "0" + arg.getHours() : arg.getHours();
            var min = m == null ? "" : m[0].length == 1 ? arg.getMinutes() : arg.getMinutes() < 10 ? "0" + arg.getMinutes() : arg.getMinutes();
            var sec = s == null ? "" : s[0].lentgh == 1 ? arg.getSeconds() : arg.getSeconds() < 10 ? "0" + arg.getSeconds() : arg.getSeconds();
            return format
                .replace(/[Y]+/, year)
                .replace(/[M]+/, month)
                .replace(/[D]+/, day)
                .replace(/[h]+/, hour)
                .replace(/[m]+/, min)
                .replace(/[s]+/, sec);
        },
        // 创建委托
        delegate: function (func, context) {
            if ($.isFunction(func)) {
                return func.delegate(context);
            } else {
                return $.noop;
            }
        },
        // 如果传入参数是函数，则以window为上下文执行，并返回结果
        // 否则返回undefined
        // 暂不支持带参数的函数
        exec: function (obj) {
            if ($.isFunction(obj)) {
                return obj.call(window);
            } else {
                return undefined;
            }
        },
        // img图片预载
        imgPreLoad: function () {
            var len = arguments.length;
            var $wrap = $('#img_pre_load_wrap');
            if ($wrap.length == 0) {
                $wrap = $('<div id="img_pre_load_wrap" style="display:none;" />').appendTo('body');
            }
            var html = [];
            for (var i = 0; i < len; i++) {
                html.push('<img src="' + arguments[i] + '" />');
            }
            $wrap.append(html.join(''));
        },
        // 验证url是否合法
        isUrl: function (str_url) {
            var strRegex = '(((^http)|(^https)|(^ftp)):\/\/)?(\\w)+\\.(\\w)+';
            var re = new RegExp(strRegex);
            return re.test(str_url);
        },
        // 验证email是否合法
        isEmail: function (str_email) {
            var strRegex = '^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+[\.a-zA-Z]+$';
            var re = new RegExp(strRegex);
            return re.test(str_email);
        },
        // 验证字符串是否是纯数字
        isAllNumber: function (str) {
            var strRegex = '^[0-9]*$';
            var re = new RegExp(strRegex);
            return re.test(str);
        },
        // 验证昵称是否有效
        isValidNickName: function (str) {
            var strRegex = '^[\u4e00-\u9fa5A-Za-z0-9_]+$';
            var re = new RegExp(strRegex);
            return re.test(str);
        },
        // 合并两个object
        // obj1为标准值
        // 返回合并后的object
        mergeObject: function (obj1, obj2) {
            if (!obj2) {
                return obj1;
            }
            if (arguments.length != 2) {
                alert('必须为mergeObject传入两个参数！');
                return;
            }
            function merge(o1, o2) {
                var o = {};
                var name;
                for (name in o1) {
                    if (o1.hasOwnProperty(name)) {
                        if (o2 && o2.hasOwnProperty(name)) {
                            if (o1[name] &&
                                o1[name].constructor == Object &&
                                !o1[name].jquery) {
                                o[name] = merge(o1[name], o2[name]);
                            } else {
                                o[name] = o2[name];
                            }
                        } else {
                            o[name] = o1[name];
                        }
                    }
                }
                return o;
            }
            return merge(obj1, obj2);
        },
        // 将obj2的值覆盖至obj1
        coverObject: function (obj1, obj2) {
            var o = $.cloneObject(obj1, false);
            var name;
            for (name in obj2) {
                if (obj2.hasOwnProperty(name)) {
                    o[name] = obj2[name];
                }
            }
            return o;
        },
        // 根据事件参数e，获取鼠标在页面上的位置
        mousePos: function (e) {
            var e = e || window.event;
            return {
                x: e.clientX + $.scrollLeft(),
                y: e.clientY + $.scrollTop()
            };
        },
        // 获取flash对象
        movie: function (movieName) {
            if (navigator.appName.indexOf("Microsoft") != -1) {
                return window[movieName];
            } else {
                return document[movieName];
            }
        },
        // 获取视口高度
        pageHeight: function () {
            if ($.browser.msie) {
                return document.compatMode == "CSS1Compat" ?
                    document.documentElement.clientHeight :
                    document.body.clientHeight;
            } else {
                return self.innerHeight;
            }
        },
        // 获取视口宽度
        pageWidth: function () {
            if ($.browser.msie) {
                return document.compatMode == "CSS1Compat" ?
                    document.documentElement.clientWidth :
                    document.body.clientWidth;
            } else {
                return self.innerWidth;
            }
        },
        // 获取url中的参数
        queryString: function (key, url) {
            if (url == null) {
                url = location;
            }
            if (url == -1) {
                url = document.referrer;
            }
            url += "#";
            //return is Array
            var urlArgs = url.match(/\?.+?#/);
            if (!urlArgs) {
                return null;
            }
            //check the index of 1 equals "#" sign
            if (urlArgs[0][1] == "#") {
                return null;
            }
            urlArgs = urlArgs[0].slice(1, -1);
            var result = getValByKey(urlArgs, key, "=", "&");
            return result == null ?
                null :
                decodeURIComponent(result);
        },
        // 跳转至登录页
        login: function () {
            function findFramePage(win) {
                if (win.self == win.top) {
                    return win;
                } else {
                    win = win.parent;
                    return findFramePage(win);
                }
            }
            function goToLogin() {
                if (self == top) {
                    location.href = "/Login/";
                }
                findFramePage(window).location.href = "/Login/";
            }
            goToLogin();
        },
        // 跳转至错误页
        error: function () {
            window.location.href = "/error/notfound";
        },
        // 跳转至无权限页面
        noRight: function () {
            window.location.href = "/error/noright";
        },
        // 刷新当前页面
        refresh: function () {
            window.location.href = window.location.href.split('#')[0];
        },
        scrollLeft: function () {
            return (document.documentElement.scrollLeft || window.pageXOffset) || 0;
        },
        scrollTop: function () {
            return (document.documentElement.scrollTop || window.pageYOffset) || 0;
        },
        // stringformat
        strFormat: function () {
            if (arguments.length == 0) {
                return '';
            }
            var strResult = arguments[0];
            var i = 1, num = arguments.length;
            for (; i < num; i++) {
                strResult = strResult.replace(eval("/\\{" + (i - 1) + "\\}/g"), arguments[i]);
            }
            return strResult;
        },
        // json对象转换为字符串，同json2str
        toJSON: function (object) {
            return $.JSON.stringify(object);
        },
        // 与jquery.ui的写法方法保持一致
        // 按键代码
        ui: {
            keyCode: {
                ALT: 18,
                BACKSPACE: 8,
                CAPS_LOCK: 20,
                COMMA: 188,
                COMMAND: 91,
                COMMAND_LEFT: 91,
                COMMAND_RIGHT: 93,
                CONTROL: 17,
                DELETE: 46,
                DOWN: 40,
                END: 35,
                ENTER: 13,
                ESCAPE: 27,
                F5: 116,
                HOME: 36,
                INSERT: 45,
                LEFT: 37,
                MENU: 93,
                NUMPAD_ADD: 107,
                NUMPAD_DECIMAL: 110,
                NUMPAD_DIVIDE: 111,
                NUMPAD_ENTER: 108,
                NUMPAD_MULTIPLY: 106,
                NUMPAD_SUBTRACT: 109,
                PAGE_DOWN: 34,
                PAGE_UP: 33,
                PERIOD: 190,
                RIGHT: 39,
                SHIFT: 16,
                SPACE: 32,
                TAB: 9,
                UP: 38,
                WINDOWS: 91
            }
        }
    });

    function getValByKey(arg, key, sA, sB) {
        if (!sB) {
            if (getKeyAndVal(arg, sA).key == key) {
                return getKeyAndVal(arg, sA).val;
            }
            return null;
        }
        var kvArr = arg.split(sB);
        for (var i = 0, num = kvArr.length; i < num; i++) {
            if (getKeyAndVal(kvArr[i], sA).key == key) {
                return getKeyAndVal(kvArr[i], sA).val;
            }
        }
        return null;
    };

    function getKeyAndVal(arg, s) {
        var key = arg.indexOf(s) == -1 ? arg : arg.substring(0, arg.indexOf(s));
        var val = arg.indexOf(s) == -1 ? null : arg.substring(arg.indexOf(s) + 1);
        return {
            key: key,
            val: val
        };
    };

    /*=======================================================================*/
    /* 为背景色增加动画 */
    /*=======================================================================*/

    // We override the animation for all of these color styles
    jQuery.each(['backgroundColor', 'borderBottomColor', 'borderLeftColor', 'borderRightColor', 'borderTopColor', 'color', 'outlineColor'], function (i, attr) {
        jQuery.fx.step[attr] = function (fx) {
            if (fx.state <= 0.045) {
                fx.start = getColor(fx.elem, attr);
                fx.end = getRGB(fx.end);
            }

            fx.elem.style[attr] = "rgb(" + [
				Math.max(Math.min(parseInt((fx.pos * (fx.end[0] - fx.start[0])) + fx.start[0]), 255), 0),
				Math.max(Math.min(parseInt((fx.pos * (fx.end[1] - fx.start[1])) + fx.start[1]), 255), 0),
				Math.max(Math.min(parseInt((fx.pos * (fx.end[2] - fx.start[2])) + fx.start[2]), 255), 0)
            ].join(",") + ")";
        }
    });

    // Color Conversion functions from highlightFade
    // By Blair Mitchelmore
    // http://jquery.offput.ca/highlightFade/

    // Parse strings looking for color tuples [255,255,255]
    function getRGB(color) {
        var result;

        // Check if we're already dealing with an array of colors
        if (color && color.constructor == Array && color.length == 3)
            return color;

        // Look for rgb(num,num,num)
        if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color))
            return [parseInt(result[1]), parseInt(result[2]), parseInt(result[3])];

        // Look for rgb(num%,num%,num%)
        if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color))
            return [parseFloat(result[1]) * 2.55, parseFloat(result[2]) * 2.55, parseFloat(result[3]) * 2.55];

        // Look for #a0b1c2
        if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color))
            return [parseInt(result[1], 16), parseInt(result[2], 16), parseInt(result[3], 16)];

        // Look for #fff
        if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color))
            return [parseInt(result[1] + result[1], 16), parseInt(result[2] + result[2], 16), parseInt(result[3] + result[3], 16)];

        // Otherwise, we're most likely dealing with a named color
        return colors[jQuery.trim(color).toLowerCase()];
    }

    function getColor(elem, attr) {
        var color;

        do {
            color = jQuery.curCSS(elem, attr);

            // Keep going until we find an element that has color, or we hit the body
            if (color != '' && color != 'transparent' || jQuery.nodeName(elem, "body"))
                break;

            attr = "backgroundColor";
        } while (elem = elem.parentNode);

        return getRGB(color);
    };

    // Some named colors to work with
    // From Interface by Stefan Petre
    // http://interface.eyecon.ro/
    var colors = {
        white: [255, 255, 255],
        pink: [255, 192, 203],
        blog: [247, 247, 247]
    };

    /*===================================*/
    /* 枚举 */
    /*===================================*/

    $.extend({
        // 枚举
        // enum属未来保留字，在ie下使用会报错，改为Enum
        Enum: {
            renderMode: {
                standard: 'standard',
                ie6: 'ie6'
            },
            // 位置类型
            position: {
                left_top: 'left_top',
                left_middle: 'left_middle',
                left_bottom: 'left_bottom',
                right_top: 'right_top',
                right_middle: 'right_middle',
                right_bottom: 'right_bottom',
                center_top: 'center_top',           // 水平居中、垂直居上
                center_middle: 'center_middle',     // 水平、垂直居中
                center_bottom: 'center_bottom'      // 水平居中、垂直居下
            },
            // 对话框类型
            dialogType: {
                confirm: 'confirm',                 // 确认框
                message: 'message'                  // 消息框
            },
            // 风格类型
            dialogStyle: {
                blue: 'blue',
                yellow: 'yellow',
                red: 'red',
                grey: 'grey',
                black: 'black'
            },
            // ajax请求并发类型
            concurrencyType: {
                None: 'none',
                Queue: 'queue',
                Break: 'break',
                Cancel: 'cancel'
            },
            // 表单页状态
            pageStatus: {
                none: 0,
                browse: 1,
                create: 2,
                update: 3
            },
            // 表单页模型状态
            modelStatus: {
                normal: 1,
                unNormal: 0,
                deleted: -1
            }
        }
    });

    /*===================================*/
    /* 异步请求 */
    /*===================================*/

    var _ajax = $.ajax;
    var _ajaxWrap = (function () {
        var needRefresh = false;
        var newAjax = function (rData) {
            var success = rData.success;
            var notLogin = rData.notLogin;
            var requireLogin = rData.requireLogin === false ? false : true;
            if ($.isFunction(success) && requireLogin === true) {
                rData.success = function (result) {
                    if (result && result.loggedIn === 0) {
                        if (notLogin) {
                            if ((notLogin.delegate(this))(result) !== false) {
                                $.login();
                            }
                        } else {
                            $.login();
                        }
                    } else if (result && result.noRight === 1) {
                        $.noRight();
                    } else {
                        (success.delegate(this))(result);
                        // 请求成功之后，判断是否刷新页面
                        if (needRefresh) {
                            $.refresh();
                        }
                    }
                };
            }
            // 添加防伪凭证
            if (rData.type == "post") {
                if (!rData.data) {
                    rData.data = {};
                }
                rData.data.__RequestVerificationToken = $("#requestVerificationToken input").val();
            }
            return _ajax(rData);
        };
        newAjax.bindRefresh = function (bind) {
            needRefresh = !!bind;
        };
        return newAjax;
    })();

    $.extend({
        // 处理ajax时，显示提示信息
        // 调用方法：显示提示信息 $.ajaxInfo.show('提示信息内容');
        //           隐藏提示信息 $.ajaxInfo.hide();
        //           渐隐提示信息 $.ajaxInfo.fadeOut();
        ajaxInfo: (function () {
            return {
                show: function (text) {
                    var $progress = $('#progress');
                    if ($progress.length == 0) {
                        $progress = $('<div id="progress" style="background-color:#DE0000;color:#FFFFFF;display:none;font-size:12px;padding:2px 4px 2px 4px;position:fixed;right:0;top:0;z-index:60000;"><p style="margin:0;padding:0;">' + text + '</p></div>');
                        $('body').append($progress);
                    } else {
                        $progress.html('<p style="margin:0;padding:0;">' + text + '</p>');
                    }
                    if ($.browser.msie && $.browser.version < 7) {
                        $progress.css({
                            position: 'absolute',
                            top: $.scrollTop()
                        });
                    }
                    $progress.show();
                    return this;
                },
                hide: function () {
                    $('#progress').hide();
                    return this;
                },
                fadeOut: function (time) {
                    time = time ? time : 0;
                    setTimeout(function () {
                        $('#progress').fadeOut(1000)
                    }, time);
                    return this;
                }
            }
        })(),
        // 1）封装$.ajax
        // 2) 增加requireLogin参数来验证登录
        // 3) notLogin：如果用户未登录则调用，只有在传入了notLogin参数，且notLogin返回false的情况下，才不跳向登录页面
        // 5) 如果needRefresh被设置为true，则会在当前异步调用结束之后刷新页面
        ajax: (function () {
            return function (rData) {
                rData.concurrencyType = (rData.concurrencyType == undefined || rData.concurrencyType == null) ? $.Enum.concurrencyType.None : rData.concurrencyType;
                switch (rData.concurrencyType) {
                    case $.Enum.concurrencyType.None:
                    default:
                        _ajaxWrap(rData);
                        break;
                    case $.Enum.concurrencyType.Queue:
                        $.ajaxQueue(rData);
                        break;
                    case $.Enum.concurrencyType.Break:
                        $.ajaxBreak(rData);
                        break;
                    case $.Enum.concurrencyType.Cancel:
                        $.ajaxCancel(rData);
                        break;
                }
            };
        })(),
        // 1）实现异步请求队列，只有当上一个$.ajaxQueue请求结束之后，
        //    才会发起下一个$.ajaxQueue请求
        // 2）调用方法：
        // $.ajaxQueue(param);
        // 参数 param：写法同 $.ajax(param)
        ajaxQueue: (function () {
            var concurrencyList = {
                'global': []
            };
            function push(rData) {
                if (!concurrencyList[rData.concurrencyId]) {
                    concurrencyList[rData.concurrencyId] = [];
                }
                concurrencyList[rData.concurrencyId].push(rData);
            }
            // 如果当前队列中存在一个请求，并且不存在上一个未完成的请求，则发起新的异步请求
            // 如果队列中存在多个请求，则在上一个请求完成后发起下一个请求
            function exec(concurrencyId) {
                var curList = concurrencyList[concurrencyId];
                if (curList.length >= 1 && (!curList[0].request)) {
                    var rData = curList[0];
                    var success = rData.success;
                    var error = rData.error;
                    rData.success = function (result) {
                        if ($.isFunction(success)) {
                            // 如果回调方法返回false，则清空队列
                            if (success(result) === false) {
                                clear(concurrencyId);
                                return false;
                            }
                        }
                        curList.shift();
                        exec.delay([concurrencyId], window, 0);
                    };
                    rData.error = function (result) {
                        if ($.isFunction(error)) {
                            if (error(result) === false) {
                                clear(concurrencyId);
                                return false;
                            }
                        }
                        curList.shift();
                        exec.delay([concurrencyId], window, 0);
                    };
                    rData.request = _ajaxWrap(rData);
                }
            }
            // 清除排队中的ajax请求，但不会中断执行中的请求
            function clear(concurrencyId) {
                concurrencyList[concurrencyId || 'global'] = [];
            }
            // 中断执行中的请求，并清除排队中的ajax请求
            function stopAndClear(concurrencyId) {
                concurrencyId = concurrencyId || 'global';
                clear(concurrencyId);
                if (concurrencyList[concurrencyId].length > 0 &&
                    concurrencyList[concurrencyId][0] &&
                    concurrencyList[concurrencyId][0].request) {
                    concurrencyList[concurrencyId][0].request.abort();
                }
            }
            // 发起请求
            function _ajaxQueue(rData) {
                rData.concurrencyId = (rData.concurrencyId == undefined || rData.concurrencyId == null) ? 'global' : rData.concurrencyId;
                push(rData);
                exec(rData.concurrencyId);
            }
            _ajaxQueue.clear = clear;
            _ajaxQueue.stopAndClear = stopAndClear;
            return _ajaxQueue;
        })(),
        // 1）只允许同时存在一个$.ajaxCancel异步请求
        //    如果发起新的$.ajaxCancel请求时，上一个$.ajaxCancel还未返回，
        //    则取消当前请求
        // 2）调用方法：
        // $.ajaxCancel(param);
        ajaxCancel: (function () {
            var concurrencyList = {
                'global': null
            };
            function onProcess(concurrencyId) {
                if (concurrencyList[concurrencyId] == null ||
                    concurrencyList[concurrencyId].readyState == 4) {
                    return false;
                } else {
                    return true;
                }
            }
            function push(concurrencyId, request) {
                concurrencyList[concurrencyId] = request;
            }
            var _ajaxCancel = function (rData) {
                rData.concurrencyId = (rData.concurrencyId == undefined || rData.concurrencyId == null) ? 'global' : rData.concurrencyId;
                if (onProcess(rData.concurrencyId)) {
                    return;
                }
                push(rData.concurrencyId, _ajaxWrap(rData));
            };
            return _ajaxCancel;
        })(),
        // 1）只允许同时存在一个$.ajaxBreak异步请求
        //    如果发起新的$.ajaxBreak请求时，上一个$.ajaxBreak还未返回，
        //    则会中断上一个请求，并发起新的请求
        // 2）调用方法：
        // $.ajaxBreak(param);
        ajaxBreak: (function () {
            var concurrencyList = {
                'global': null
            };
            function abort(concurrencyId) {
                concurrencyList[concurrencyId] && concurrencyList[concurrencyId].abort();
            }
            function push(concurrencyId, request) {
                concurrencyList[concurrencyId] = request;
            }
            var _ajaxBreak = function (rData) {
                rData.concurrencyId = (rData.concurrencyId == undefined || rData.concurrencyId == null) ? 'global' : rData.concurrencyId;
                abort(rData.concurrencyId);
                push(rData.concurrencyId, _ajaxWrap(rData));
            };
            return _ajaxBreak;
        })(),
        // 1）input:file异步上传文件
        // 2）调用方法：
        // $.ajaxFile({
        //     input: $dom,
        //     url: "",        
        //     dataType: 'json',
        //     success: function (data) { }
        // });
        // 参数 input：               input:file（上传控件）的jq对象，该input必须定义了name属性
        // 参数 url：                 异步请求的路径
        // 参数 dataType：            返回数据的格式，支持 text、json
        // 参数 success：             成功时的回调函数
        // 3）返回数据格式：
        // <script type=\"text/javascript\">document.domain=\"im-sh.com\";</script><textarea>" + response + "</textarea>
        ajaxFile: (function () {
            $(function () {
                if ($.browser.msie && $.browser.version < 7) {
                    $('body').append('<iframe id="ansy_upload_iframe" name="ansy_upload_iframe" src="' +
                       $.config.ie6CrossDomainUrl + '" style="display:none;"/>');
                }
            });
            var req;
            var $form;
            var $tmp;
            function upload(data) {
                var req = {
                    needCrossDomain: true,
                    input: data.input || null,
                    dataType: data.dataType || 'text',
                    url: data.url || '',
                    success: data.success || $.noop
                };
                if (!req.input || req.url == '') {
                    return false;
                }
                if (!($.browser.msie && $.browser.version < 7) &&
                    ($('#ansy_upload_iframe').length == 0)) {
                    $('<iframe id="ansy_upload_iframe" name="ansy_upload_iframe" src="about:blank" style="display:none;" />')
                        .appendTo('body');
                }
                $('#ansy_upload_iframe').unbind().bind('load', ansyDone);

                $form =
                    $('<form id="ansy_upload_form" encType="multipart/form-data" method="post" target="ansy_upload_iframe" action="' +
                        req.url + '" style="display:none;"></form>')
                        .appendTo('body');

                // 必须使用原input，否则无法正确获取上传数据
                $tmp = req.input.clone(true);
                $tmp.disable();
                req.input.replaceWith($tmp);
                $form.append(req.input);

                // 安全验证
                var $token = $("#requestVerificationToken input");
                if ($token.length > 0) {
                    $form.append($token.clone(true));
                }

                // 将form提交模拟为ajax请求
                if ($form.find("input[name=SimulateAjax]").length == 0) {
                    $form.prepend("<input type='hidden' name='SimulateAjax' value='true' />");
                }

                $form.submit();

                function ansyDone() {
                    try {
                        if (req.needCrossDomain) {
                            var response = $('#ansy_upload_iframe')[0].contentWindow.document.getElementsByTagName('textarea')[0].value;
                        } else {
                            var response = $('#ansy_upload_iframe')[0].contentWindow.document.body.innerHTML.replace(/<[\/]?pre>/ig, '');
                        }

                        response = req.dataType == 'json' ? $.parseJSON(response) : response;
                    } catch (e) {
                        response = {
                            done: 0,
                            msg: e.message
                        };
                    }
                    $('#ansy_upload_iframe').unbind();
                    $form.unbind().remove();
                    $tmp.enable().unbind();
                    $.clearFileInput($tmp);
                    req.success(response);
                }
            }
            upload.cancel = function () {
                $('#ansy_upload_iframe').unbind();
                if ($form) {
                    $form.unbind().remove();
                }
                if ($tmp) {
                    $tmp.enable().unbind();
                    $.clearFileInput($tmp);
                }
                if (req) {
                    req.success = $.noop;
                }
            };
            return upload;
        })()
    });

    /*===================================*/
    /* UI */
    /*===================================*/

    $.extend({
        // 页面元素定位方法
        position: (function () {
            function width($dom) {
                return $dom.outerWidth();
            }
            function height($dom) {
                return $dom.outerHeight();
            }
            function size($dom) {
                return {
                    height: height($dom),
                    width: width($dom)
                };
            }
            // 如果目标定位元素存在，则使用绝对定位
            // 否则，使用fixed定位，ie6除外
            function adjustPos(size, position) {
                if ($target != null) {
                    return {
                        position: 'absolute',
                        left: size.left - position.left,
                        top: size.top - position.up,
                        right: 'auto',
                        bottom: 'auto'
                    }
                }
                if (($.browser.msie && $.browser.version < 7) || position.mode == $.Enum.renderMode.ie6) {
                    return {
                        position: 'absolute',
                        left: size.left + $.scrollLeft() - position.left,
                        top: size.top + $.scrollTop() - position.up,
                        right: 'auto',
                        bottom: 'auto'
                    };
                } else {
                    return {
                        position: 'fixed',
                        left: size.left - position.left,
                        top: size.top - position.up,
                        right: 'auto',
                        bottom: 'auto'
                    };
                }
            }
            var left, top, offset, $dom, $target;
            return {
                // 调整元素的绝对定位 
                // 参数：location: {                         
                //     popup: true,    // 是否以弹出层的形式显示，true则弹出，false则嵌入页面中
                //     dialog: null,   // 需要定位的元素
                //     target: null,   // target为null时，以浏览器当前窗口为target，否则，以target为定位
                //     position: $.Enum.position.center_middle,
                //     left: 0,        // 在position的基础上向左偏移，单位px
                //     up: 0           // 在position的基础上向上偏移，单位px
                // },
                adjust: function (location) {
                    $dom = location.dialog;
                    $target = location.target;

                    // 如果是以嵌入页面的方式显示
                    if (!location.popup) {
                        $dom.css({
                            position: 'static'
                        });
                        $target.append($dom);
                        return this;
                    }

                    // 如果是以弹出层的方式显示
                    switch (location.position) {
                        case $.Enum.position.left_top:
                            this._left_top(location);
                            break;
                        case $.Enum.position.left_middle:
                            this._left_middle(location);
                            break;
                        case $.Enum.position.left_bottom:
                            this._left_bottom(location);
                            break;
                        case $.Enum.position.right_top:
                            this._right_top(location);
                            break;
                        case $.Enum.position.right_middle:
                            this._right_middle(location);
                            break;
                        case $.Enum.position.right_bottom:
                            this._right_bottom(location);
                            break;
                        case $.Enum.position.center_top:
                            this._center_top(location);
                            break;
                        case $.Enum.position.center_middle:
                            this._center_middle(location);
                            break;
                        case $.Enum.position.center_bottom:
                            this._center_bottom(location);
                            break;
                    };
                    this._updatePos(location);
                    return this;
                },
                _updatePos: function (pos) {
                    $dom.css(adjustPos({
                        left: left,
                        top: top,
                        right: 'auto',
                        bottom: 'auto'
                    }, pos));
                    return this;
                },
                _left_top: function (pos) {
                    if (pos.target == null) {
                        left = 0;
                        top = 0;
                    } else {
                        offset = $target.offset();
                        left = offset.left;
                        top = offset.top - height($dom);
                    }
                    return this;
                },
                _left_middle: function (pos) {
                    if (pos.target == null) {
                        left = 0;
                        top = ($.pageHeight() - height($dom)) / 2;
                    } else {
                        offset = $target.offset();
                        left = offset.left;
                        top = offset.top + (height($target) - height($dom)) / 2;
                    }
                    return this;
                },
                _left_bottom: function (pos) {
                    if (pos.target == null) {
                        left = 0;
                        top = $.pageHeight() - height($dom);
                    } else {
                        offset = $target.offset();
                        left = offset.left;
                        top = offset.top + height($target);
                    }
                    return this;
                },
                _right_top: function (pos) {
                    if (pos.target == null) {
                        left = $.pageWidth() - width($dom);
                        top = 0;
                    } else {
                        offset = $target.offset();
                        left = offset.left + width($target) - width($dom);
                        top = offset.top - height($dom);
                    }
                    return this;
                },
                _right_middle: function (pos) {
                    if (pos.target == null) {
                        left = $.pageWidth() - width($dom);
                        top = ($.pageHeight() - height($dom)) / 2;
                    } else {
                        offset = $target.offset();
                        left = offset.left + width($target) - width($dom);
                        top = offset.top + (height($target) - height($dom)) / 2;
                    }
                    return this;
                },
                _right_bottom: function (pos) {
                    if (pos.target == null) {
                        left = $.pageWidth() - width($dom);
                        top = $.pageHeight() - height($dom);
                    } else {
                        offset = $target.offset();
                        left = offset.left + width($target) - width($dom);
                        top = offset.top + height($target);
                    }
                    return this;
                },
                _center_top: function (pos) {
                    if (pos.target == null) {
                        left = ($.pageWidth() - width($dom)) / 2;
                        top = 0;
                    } else {
                        offset = $target.offset();
                        left = offset.left + (width($target) - width($dom)) / 2;
                        top = offset.top - height($dom);
                    }
                    return this;
                },
                _center_middle: function (pos) {
                    if (pos.target == null) {
                        left = ($.pageWidth() - width($dom)) / 2;
                        top = ($.pageHeight() - height($dom)) / 2;
                    } else {
                        offset = $target.offset();
                        left = offset.left + (width($target) - width($dom)) / 2;
                        top = offset.top + (height($target) - height($dom)) / 2;
                    }
                    return this;
                },
                _center_bottom: function (pos) {
                    if (pos.target == null) {
                        left = ($.pageWidth() - width($dom)) / 2;
                        top = $.pageHeight() - height($dom);
                    } else {
                        offset = $target.offset();
                        left = offset.left + (width($target) - width($dom)) / 2;
                        top = offset.top + height($target);
                    }
                    return this;
                }
            };
        })(),
        // 设置input输入框的默认显示文字样式
        // 参数$input:   input的jq对象
        // 参数val:      默认显示文字
        // 参数className:    默认显示颜色
        // 调用示例：
        // $.inputDefaultValue($('input'), '默认文字', 'class');
        inputDefaultValue: function ($input, text, className, dontChangeClass) {
            $.clearDefaultValue($input);
            if ($input.data('className')) {
                $input.removeClass($input.data('className'));
            }
            $input
                .data({
                    needInput: true,
                    text: text,
                    className: className
                })
                .val(text);
            if (!dontChangeClass) {
                $input.addClass(className);
            }
            $input.bind('focus.tip', function () {
                if ($input.data('needInput') === true) {
                    $input.val('').removeClass($input.data('className'));
                    $input.data('needInput', false);
                }
            });
            $input.bind('blur.tip', function () {
                if ($input.val().trim() == '') {
                    $input
                        .data('needInput', true)
                        .val($input.data('text'));
                    if (!dontChangeClass) {
                        $input.addClass($input.data('className'));
                    }
                }
            });
        },
        clearDefaultValueStyle: function ($input) {
            if ($input.data('needInput') === true) {
                $input.val('').removeClass($input.data('className'));
                $input.data('needInput', false);
            }
        },
        // 清除inputDefaultValue操作
        clearDefaultValue: function ($input) {
            if ($input.data('className')) {
                $input.removeClass($input.data('className'));
            }
            $input.val('');
            $input.data({
                needInput: null,
                text: null,
                className: null
            });
            $input.unbind('focus.tip');
            $input.unbind('blur.tip');
        },
        // input输入错误时的样式
        // 参数$input:   input的jq对象
        // 参数val:      默认显示文字
        // 参数className:    默认显示颜色
        // 调用示例：
        // $.inputErrorValue($('input'), '默认文字', 'class');
        inputErrorValue: function ($input, text, className) {
            $input.data({
                defaultValue: $input.val()
            });
            $.clearDefaultValue($input);
            $input
                .blur()
                .data('needInput', true)
                .val(text)
                .removeClass(className)
                .addClass(className);

            $input.one('focus', function () {
                $input.val($input.data('defaultValue'))
                    .removeClass(className)
                    .data('needInput', false);
            });
        },
        // 公用遮罩层
        // 调用示例：
        // 显示：$.block.show();
        // 隐藏：$.block.hide();
        // 修改默认样式: $.block.css({ 'background-color', '#fff' }).show();
        // z-index：20000
        block: (function () {
            var owner = null;
            var $block = $('.ui_block');
            function init() {
                if ($('.ui_block').length == 0) {
                    $block = $('<div class="ui_block"/>')
                        .click(function () {
                            owner != null && owner.hideDropDown();
                        })
                        .appendTo('body');
                }
                fix();
            }
            function fix() {
                if ($.browser.msie && $.browser.version < 7) {
                    $block.css({
                        position: 'absolute',
                        width: $(document.body).width(),
                        height: $(document).height()
                    });
                    $('select').hide();
                }
                return this;
            }
            function hidefix() {
                if ($.browser.msie && $.browser.version < 7) {
                    $('select').show();
                }
            }
            return {
                clear: function () {
                    hidefix();
                    $block.hide();
                    owner = null;
                    return this;
                },
                clearOwner: function () {
                    owner = null;
                    return this;
                },
                css: function (style) {
                    init();
                    $block.css(style);
                    return this;
                },
                show: function () {
                    init();
                    $block.show();
                    return this;
                },
                hide: function () {
                    hidefix();
                    $block.hide();
                    return this;
                },
                getOwner: function () {
                    return owner;
                },
                setOwner: function (holder) {
                    owner = holder;
                    return this;
                }
            };
        })()
    });

    var fval = $.fn.val;

    // 重写$.fn.val以兼容$.inputDefaultValue设置过的input
    $.fn.val = function () {
        if (arguments.length == 0) {
            if (this.data('needInput') === true) {
                return '';
            } else {
                return fval.call(this);
            }
        } else {
            fval.apply(this, arguments);
            return this;
        }
    };

    // 公用对话框
    // 调用示例：
    // $.alert('显示一条消息');
    // $.warning('显示一条警告消息');
    // $.error('显示一条错误消息');
    (function () {
        var defaults = {
            type: $.Enum.dialogType.confirm,    // 对话框类型：message、confirm，默认confirm
            autoHide: false,                    // 自动隐藏对话框，只在type为message时有效
            timeout: 1500,                      // autoHide为true时，等待timeout毫秒隐藏
            modal: false,                       // 是否显示遮罩            
            clickHide: false,                   // 点击页面中非对话框区域是否关闭对话框
            dialogClass: null,                  // 给最外层元素增加的样式
            css: {                              // 直接设置样式
                'z-index': 30000
            },
            style: $.Enum.dialogStyle.blue,     // 主体色调 -- 作废            
            width: 300,                         // 留给内容区域的宽度

            // 以下定位相关  
            location: {                         // 定位信息
                popup: true,                    //   是否以弹出层的形式显示，true则弹出，false则嵌入页面中
                dialog: null,                   //   当前对话框的$dialog
                target: null,                   //   参考定位的元素的jq对象
                mode: $.Enum.renderMode.standard,   //   定位模式：标准，ie6
                position: $.Enum.position.center_middle,
                left: 0,                        //   在position的基础上向左偏移，单位px
                up: 0                           //   在position的基础上向上偏移，单位px
            },

            // 以下区域内容
            content: '',                        // 对话框内容，支持content内容为html字符串或jq对象
            okButton: null,                     // 使用传入的jq元素取代默认的ok按钮
            cancelButton: null,                 // 使用传入的jq元素取代默认的cancel按钮

            // 以下为事件相关            
            load: $.noop,                       // onload事件，在对话框初始化完毕后触发，可用于异步加载内容
            dispose: $.noop,                    // ondispose事件，调用dispose()方法时触发
            beforeOk: $.noop,                   // 确定按钮点击前事件，若返回false则不关闭对话框
            beforeCancel: $.noop,               // 取消按钮点击前事件，若返回false则不关闭对话框
            ok: $.noop,                         // 确定按钮事件，在对话框关闭后触发
            cancel: $.noop                      // 取消按钮事件，在对话框关闭后触发
        };
        var id = 0;
        // 当前页面中的对话框实例集合
        $.dialogList = [];
        var dialog = function (obj) {
            this._id = id++;
            this.inited = false;    // 是否已初始化
            this.$dialog = null;    // 对话框的jq对象
            this.$content = null;   // 内容区域的jq对象
            this.$ok = null;        // 确定按钮的jq对象
            this.$cancel = null;    // 取消按钮的jq对象

            this.options = $.mergeObject(defaults, obj);  // 合并后的参数
            this.options.css = $.coverObject(defaults.css, obj.css);
            this.timeOut = null;
            this._updateDelegate()._init();
            $.dialogList.push(this);
        };
        dialog.prototype = {
            // 指定构造函数
            constructor: dialog,
            // 显示
            show: function () {
                this._breakAutoHide();
                this._adjust()
                    ._showBlock()
                    .disableClickHide()
                    .enableClickHide()
                    ._autoHide()
                    .hideOthers();
                this.$dialog.show();
                return this;
            },
            visible: function () {
                return this.$dialog.visible();
            },
            // 隐藏
            hide: function (fadeOut) {
                if (!fadeOut) {
                    this.$dialog.hide();
                } else {
                    this.$dialog.fadeOut('slow');
                }
                this._hideBlock().disableClickHide();
                return this;
            },
            // 隐藏除当前confirm对话框外的其他confirm对话框
            hideOthers: function () {
                if (this.options.type != $.Enum.dialogType.confirm) {
                    return;
                }
                var box = this;
                $.dialogList.extendEach(function (i, item) {
                    if (item !== box && item.options.type == $.Enum.dialogType.confirm) {
                        item.forcedToHide();
                    }
                });
                return this;
            },
            // 如果clickHide为true，则被隐藏
            forcedToHide: function () {
                if (this.options.clickHide) {
                    this.hide();
                }
                return this;
            },
            // 注销
            dispose: function () {
                this.hide()._onDispose().fill('');
                this.$dialog.remove();
                this.$ok.unbind();
                this.$cancel.unbind();
            },
            // 给对话框填充填充内容
            // cnt，填充内容
            // needReplace，是否替换原有内容
            fill: function (cnt, needReplace) {
                this._onDispose();
                if (cnt.jquery) {
                    if (needReplace) {
                        this.$content.html('').append(cnt.show());
                    } else {
                        cnt.show().appendTo(this.$content);
                    }
                } else {
                    if (needReplace) {
                        this.$content.html(cnt + '');
                    } else {
                        this.$content.append(cnt + '');
                    }
                }
                return this;
            },
            updateOptions: function (obj) {
                this.options = $.mergeObject(this.options, obj);
                this._updateDelegate();
            },
            /* -- 以下方法应内部使用 -- */
            _init: function () {
                this._prepare()
                    ._bindEvents()
                    ._render()
                    .show()
                    ._onLoad.delay(this, 0);

                return this;
            },
            // 更新options时，需要重新绑定事件委托
            _updateDelegate: function () {
                this._loadDelegate = $.delegate(this.options.load, this);
                this._disposeDelegate = $.delegate(this.options.dispose, this);

                // 用户传入的事件
                this._beforeOkDelegate = $.delegate(this.options.beforeOk, this);
                this._beforeCancelDelegate = $.delegate(this.options.beforeCancel, this);
                this._okDelegate = $.delegate(this.options.ok, this);
                this._cancelDelegate = $.delegate(this.options.cancel, this);

                // 绑定至按钮的事件
                this._okEventDelegate = this._okEvent.delegate(this);
                this._cancelEventDelegate = this._cancelEvent.delegate(this);

                return this;
            },
            _prepare: function () {
                if (this.$dialog == null) {
                    this.$dialog = $('<div><div><div class="ui_dialog_content"></div></div></div>');
                    //this.$dialog = $('<div style="width:auto;margin:0 auto;"><div class="add_shouhuodi_pop_content"></div></div>');
                    this.$content = this.$dialog.find('.ui_dialog_content');
                    this.$ok = this.options.okButton ? this.options.okButton : null;
                    this.$cancel = this.options.cancelButton ? this.options.cancelButton : null;

                    if (this.options.type == $.Enum.dialogType.message) {
                        this.$dialog.addClass('ui_alert');
                    }
                    if (this.options.dialogClass) {
                        this.$dialog.addClass(this.options.dialogClass);
                    }
                    this.$dialog.css(this.options.css);
                }
                return this;
            },
            _bindEvents: function () {
                this.$ok && this.$ok.unbind().one('click', this._okEventDelegate);
                this.$cancel && this.$cancel.unbind().one('click', this._cancelEventDelegate);
                return this;
            },
            _render: function () {
                this.$dialog.css('width', this.options.width);
                //this.$content.css('width', this.options.width);
                // 支持content内容为html字符串或jq对象
                this.fill(this.options.content);
                this.$dialog.appendTo('body');
                return this;
            },
            // 在before事件中，若返回false的，则终止执行，对话框不会被关闭
            // 确定按钮事件
            _okEvent: function (e) {
                if (this._beforeOkDelegate(e) === false) {
                } else {
                    this.hide();
                    this._okDelegate(e);
                }
                this.$ok && this.$ok.one('click', this._okEventDelegate);
            },
            // 取消/关闭按钮事件
            _cancelEvent: function (e) {
                if (this._beforeCancelDelegate(e) === false) {
                } else {
                    this.hide();
                    this._cancelDelegate(e);
                }
                this.$cancel && this.$cancel.one('click', this._cancelEventDelegate);
            },
            // 对话框生成完毕后调用
            _onLoad: function () {
                this._loadDelegate();
                return this;
            },
            // 注销事件
            _onDispose: function () {
                this._disposeDelegate();
                return this;
            },
            // 自动隐藏，使用fadeOut
            _autoHide: function () {
                // 如果是消息模式，并且设置了自动消失
                if (this.options.type == $.Enum.dialogType.message && this.options.autoHide) {
                    this.timeOut = this.hide.delay([true], this, this.options.timeout);
                }
                return this;
            },
            // 中断自动隐藏
            _breakAutoHide: function () {
                if (this.timeOut) {
                    clearTimeout(this.timeOut);
                }
            },
            // 显示遮罩
            _showBlock: function () {
                this.options.modal && $.block.show();
                return this;
            },
            // 隐藏遮罩
            _hideBlock: function () {
                this.options.modal && $.block.hide();
                return this;
            },
            // 调整位置
            _adjust: function () {
                this.options.location.dialog = this.$dialog;
                $.position.adjust(this.options.location);
                return this;
            },
            // 如果设置了clickHide为true，则在点击页面中非dialog区域时，会关闭对话框
            // dialog显示时，为clickHide绑定事件
            enableClickHide: function () {
                if (this.options.clickHide) {
                    $(document).bind('click.closedialog.' + this._id, (function (e) {
                        this.hide();
                    }).delegate(this));
                    this.$dialog.bind('click.closedialog.' + this._id, function (e) {
                        e.stopPropagation();
                        //return false;
                    });
                }
                return this;
            },
            // dialog隐藏时，为clickHide解除绑定事件
            disableClickHide: function () {
                //if (this.options.clickHide) {
                $(document).unbind('click.closedialog.' + this._id);
                this.$dialog.unbind('click.closedialog.' + this._id);
                //}
                return this;
            }
        };

        // 更改消息框内容
        function fillAlertBox($html, msg, title) {
            //$html.find('.pop_title').html(title);
            $html.find('.pop_bg span').html(msg);
        }

        // 创建消息框
        function createAlertBox($html, autoHide, zIndex) {
            autoHide = (autoHide == undefined ? true : autoHide);
            return $.dialog({
                type: 'message',
                autoHide: autoHide,

                css: {
                    'z-index': zIndex ? zIndex : 31000
                },
                location: {
                    mode: $.Enum.renderMode.standard
                },
                content: $html
            });
        }

        // 创建确认框
        function createConfirmBox($html, ok) {
            return $.dialog({
                type: 'confirm',
                autoHide: false,
                modal: true,
                css: {
                    'z-index': 31000
                },
                content: $html,
                okButton: $html.find('.pop_ok'),
                cancelButton: $html.find('.pop_close'),
                ok: ok ? ok : $.noop
            });
        }

        // 基于$.dialog的扩展
        $.extend({
            // 自定义对话框
            dialog: function (obj) {
                return new dialog(obj);
            },
            // 普通消息框
            alert: (function () {
                return function (msg, title, callback) {
                    return $.messager.alert(title || "系统消息", msg, "info", $.isFunction(callback) ? callback : $.noop);
                };
            })(),
            // 操作成功框
            success: (function () {
                return function (msg, title, callback) {
                    return $.messager.alert(title || "系统消息", msg, "info", $.isFunction(callback) ? callback : $.noop);
                };
            })(),
            // 错误消息框
            error: (function () {
                return function (msg, title, callback) {
                    return $.messager.alert(title || "系统消息", msg, "error", $.isFunction(callback) ? callback : $.noop);
                };
            })(),
            // 警告消息框
            warning: (function () {
                return function (msg, title, callback) {
                    return $.messager.alert(title || "系统消息", msg, "warning", $.isFunction(callback) ? callback : $.noop);
                };
            })(),
            // 确认消息框
            confirm: (function () {
                return function (msg, title, ok, cancel) {
                    $.messager.confirm(title || "系统消息", msg, function (r) {
                        if (r) {
                            if ($.isFunction(ok)) {
                                ok();
                            }
                            return false;
                        } else {
                            if ($.isFunction(cancel)) {
                                cancel();
                            }
                            return false;
                        }
                    });
                };
            })(),
            // 加载框
            loading: (function () {
                var box = null;
                function _loading(msg, title) {
                    box = $.messager.progress({
                        title: title || "请等待",
                        msg: msg || "数据加载中..."
                    });
                };
                _loading.close = function () {
                    $.messager.progress("close");
                };
                return _loading;
            })(),
            // 关闭页面确认框
            // firefox，ie有效，opera，chrome无效
            // msg：关闭页面对话框的提示信息
            leave: function (msg) {
                window.onbeforeunload = function (event) {
                    event = event || window.event;
                    event.returnValue = '\r\n' + msg + '\r\n';
                };
            },
            // 注销关闭页面确认框
            unleave: function () {
                window.onbeforeunload = $.noop;
            }
        });
    })();

    /*===================================*/
    /* 其它 */
    /*===================================*/

    // 转换object为json字符串
    $.JSON = (function () {
        function f(n) {
            return n < 10 ? '0' + n : n
        }
        Date.prototype.toJSON = function () {
            return this.getUTCFullYear() + "-" + f(this.getUTCMonth() + 1) + "-" + f(this.getUTCDate()) + "T" + f(this.getUTCHours()) + ":" + f(this.getUTCMinutes()) + ":" + f(this.getUTCSeconds()) + "Z"
        };
        var m = {
            "\b": "\\b",
            "\t": "\\t",
            "\n": "\\n",
            "\f": "\\f",
            "\r": "\\r",
            "\"": "\\\"",
            "\\": "\\\\"
        };
        function stringify(value, _306f) {
            var a, i, k, l, r = /["\\\x00-\x1f\x7f-\x9f]/g,
                v;
            switch (typeof (value)) {
                case "string":
                    return r.test(value) ? "\"" + value.replace(r, function (a) {
                        var c = m[a];
                        if (c) {
                            return c
                        }
                        c = a.charCodeAt();
                        return "\\u00" + Math.floor(c / 16).toString(16) + (c % 16).toString(16)
                    }) + "\"" : "\"" + value + "\"";
                case "number":
                    return isFinite(value) ? String(value) : "null";
                case "boolean":
                    return value ? true : false;
                case "null":
                    return String(value);
                case "object":
                    if (!value) {
                        return "null"
                    }
                    a = [];
                    if (typeof (value.length) === "number" && !(value.propertyIsEnumerable("length"))) {
                        l = value.length;
                        for (i = 0; i < l; i += 1) {
                            a.push(stringify(value[i], _306f) || "null")
                        }
                        return "[" + a.join(",") + "]"
                    }
                    if (_306f) {
                        l = _306f.length;
                        for (i = 0; i < l; i += 1) {
                            k = _306f[i];
                            if (typeof (k) === "string") {
                                v = stringify(value[k], _306f);
                                if (v) {
                                    a.push(stringify(k) + ":" + v)
                                }
                            }
                        }
                    } else {
                        for (k in value) {
                            if (typeof (k) === "string") {
                                v = stringify(value[k], _306f);
                                if (v || v === false) {
                                    a.push(stringify(k) + ":" + v)
                                }
                            }
                        }
                    }
                    return "{" + a.join(",") + "}"
            }
        }
        return {
            stringify: stringify,
            parse: function () { }
        }
    })();

    //$.post = $.get = $.getJSON = blockPost;
    //function blockPost() {
    //    $.error('$.post，$.get 方法已被屏蔽，请使用$.ajax代替', '错误', false);
    //}

    //var defaultLoad = $.fn.load;
    //$.enableLoad = false;
    //$.fn.load = function () {
    //    if (arguments.length > 1) {
    //        if ($.enableLoad === false) {
    //            $.error('load 方法已被屏蔽，请使用$.ajax代替', '错误', false);
    //        } else {
    //            defaultLoad.apply(this, arguments);
    //        }
    //    } else {
    //        defaultLoad.apply(this, arguments);
    //    }
    //};

    /*=======================================================================*/
    /* 
        覆盖jquery内置的serializeArray方法 
        1、使checkbox在不选中时，输出false
    */
    /*=======================================================================*/

    $.fn.serializeArray = function () {
        var r20 = /%20/g,
	        rbracket = /\[\]$/,
	        rCRLF = /\r?\n/g,
	        rinput = /^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week|checkbox)$/i,
	        rselectTextarea = /^(?:select|textarea)/i;

        return this.map(function () {
            return this.elements ? jQuery.makeArray(this.elements) : this;
        })
        .filter(function () {
            return this.name && !this.disabled &&
                ((this.type == "radio" && this.checked) ||
                    rselectTextarea.test(this.nodeName) ||
                    rinput.test(this.type));
        })
        .map(function (i, elem) {
            var val = jQuery(this).val();
            if (this.type == "checkbox") {
                val = this.checked + "";
            }

            return val == null ?
                null :
                jQuery.isArray(val) ?
                    jQuery.map(val, function (val, i) {
                        return { name: elem.name, value: val.replace(rCRLF, "\r\n") };
                    }) :
					{ name: elem.name, value: val.replace(rCRLF, "\r\n") };
        }).get();
    };

    /*=======================================================================*/
    /* 扩展js内置对象 */
    /*=======================================================================*/

    String.prototype.encodeURI = function () {
        return encodeURI(this);
    };

    String.prototype.escape = function () {
        return escape(this);
    };

    String.prototype.unescape = function () {
        return unescape(this);
    };

    String.prototype.trim = function () {
        return this.replace(/(^\s*)|(\s*$)/g, '');
    };

    String.prototype.ltrim = function () {
        return this.replace(/(^\s*)/g, '');
    };

    String.prototype.rtrim = function () {
        return this.replace(/(\s*$)/g, '');
    };

    String.prototype.tinyMceTrim = function () {
        return this.replace(/((&nbsp;)*$)|((<p>(&nbsp;)*<\/p>\s*)*$)/g, '');
    };

    String.prototype.randomUrl = function () {
        _this = this;
        return [this, Math.random()].join(_this.indexOf("?") > 0 ? "&" : "?");
    };

    String.prototype.tryInt = tryInt;

    Number.prototype.tryInt = tryInt;

    function tryInt() {
        var result = 0;
        try {
            result = parseInt(this);
        } catch (e) { }
        return result;
    }

    String.prototype.tryFloat = tryFloat;

    Number.prototype.tryFloat = tryFloat;
    function tryFloat() {
        var result = 0;
        try {
            result = parseFloat(this);
        } catch (e) { }
        return result;
    }

    // 若func返回false，则中断遍历 - 与HighCharts冲突
    if (![].extendEach) {
        Array.prototype.extendEach = function (func) {
            if (!$.isFunction(func)) {
                return false;
            }
            for (var i = 0, len = this.length; i < len; i++) {
                if (func(i, this[i]) === false) {
                    break;
                }
            }
        };
    }

    // 获取选项索引
    // item:数组成员
    if (![].indexOf) {
        Array.prototype.indexOf = function (item) {
            for (var i = this.length; i-- && this[i] !== item;);
            return i;
        };
    }

    // 移除指定索引成员
    // 返回修改后的数组
    if (![].removeAt) {
        Array.prototype.removeAt = function (index) {
            if (this.splice) {
                this.splice(index, 1);
            }
        };
    }

    // 移除数组指定成员
    // 返回修改后的数组
    if (![].remove) {
        Array.prototype.remove = function (item) {
            if (this.splice) {
                this.splice(this.indexOf(item), 1);
            }
        };
    }

    // 未进行参数验证
    // 使用delay来延迟执行函数
    // 调用delay时，如果不指定参数context，原函数的上下文将被默认指定为window
    // 参数格式：1、 [arg1, arg2 ...], context, time
    //           2、 context, time
    //           3、 time
    Function.prototype.delay = function () {
        var args = [];
        var context = window;
        var time = 0;

        // 获取参数
        if (arguments.length == 1) {
            time = arguments[0];
        } else if (arguments.length == 2) {
            context = arguments[0];
            time = arguments[1];
        } else if (arguments.length == 3) {
            args = arguments[0];
            context = arguments[1];
            time = arguments[2];
        }

        var func = this;
        var timeOutObj = setTimeout(function () {
            func.apply(context, args);
        }, time);

        return timeOutObj;
    };

    // 创建委托函数
    // context：函数上下文
    Function.prototype.delegate = function () {
        var func = this;
        var context = arguments.length == 1 ? arguments[0] : window;
        return function () {
            return func.apply(context, arguments);
        };
    };

    $.extend({
        //验证邮箱
        isEmail: function (str) {
            return (new RegExp(/^([_a-zA-Z\d\-\.])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/).test(str.trim()));
        },
        //验证手机
        isMobile: function (str) {
            return (new RegExp(/^(13|14|15|17|18)\d{9}$/).test(str.trim()));
        },
        //验证座机
        isPhone: function (str) {
            return (new RegExp(/^(([0\+]\d{2,3}-)?(0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/).test(str.trim()));
        },
        //验证邮编
        isPostcode: function (str) {
            return (new RegExp(/^\d{6}$/).test(str.trim()));
        },
        //验证是否为空
        isEmpty: function (str) {
            return (str.trim() === "");
        },
        //验证是否为QQ 5-10位
        isQQ: function (str) {
            return (new RegExp(/^\+?[1-9][0-9]{4,9}$/).test(str.trim()));
        },
        //验证金钱 小数点前面最多12位（1位到12之间），小数点后最多2位（1到2位）
        isMoney: function (str) {
            return (new RegExp(/^\d{1,12}(?:\.\d{1,2})?$/).test(str.trim()));
        }
    });

})();

/*=======================================================================*/
/* 操作cookie */
/*=======================================================================*/
(function ($) {
    $.extend({
        'cookie': function (name, value, options) {
            if (typeof value != 'undefined') { // name and value given,
                // set cookie
                options = options || {};
                if (value === null) {
                    value = '';
                    options.expires = -1;
                }
                var expires = '';
                if (options.expires
						&& (typeof options.expires == 'number' || options.expires.toUTCString)) {
                    var date;
                    if (typeof options.expires == 'number') {
                        date = new Date();
                        date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
                    } else {
                        date = options.expires;
                    }
                    expires = '; expires=' + date.toUTCString(); // use
                    // expires
                    // attribute,
                    // max-age
                    // is
                    // not
                    // supported
                    // by
                    // IE
                }
                var path = options.path ? '; path=' + options.path : '';
                var domain = options.domain ? '; domain=' + options.domain : '; domain=' + siteDomain;
                var secure = options.secure ? '; secure' : '';
                document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
            } else { // only name given, get cookie
                var cookieValue = null;
                if (document.cookie && document.cookie != '') {
                    var cookies = document.cookie.split(';');
                    for (var i = 0; i < cookies.length; i++) {
                        var cookie = jQuery.trim(cookies[i]);
                        // Does this cookie string begin with the name
                        // we want?
                        if (cookie.substring(0, name.length + 1) == (name + '=')) {
                            cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                            break;
                        }
                    }
                }
                return cookieValue;
            }
        },
        'getCookie': function (name) {
            var start = document.cookie.indexOf(name + "=");
            var len = start + name.length + 1;
            if ((!start) && (name != document.cookie.substring(0, name.length))) {
                return null;
            }
            if (start == -1) return null;
            var end = document.cookie.indexOf(';', len);
            if (end == -1) end = document.cookie.length;
            return unescape(document.cookie.substring(len, end));
        }
    });
})(jQuery);

















