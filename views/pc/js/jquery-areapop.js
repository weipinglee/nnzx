(function(window, $, undefined) {
    var uuid = 0;

    var hasOwnProperty = ({}).hasOwnProperty;

    var Util = {
        getters: [],

        //首字母大写
        capitalize: function(str) {
            var result = $.trim(str || "");
            if (result) {
                result = result.charAt(0).toUpperCase() + result.substring(1);
            }
            return result;
        },

        //判断是否不支持链式
        isNotChained: function(method, otherArgs) {
            var length = otherArgs.length;
            if (method == 'option' && (length === 0 || (length === 1 && typeof otherArgs[0] == 'string'))) {
                return true;
            }
            return !!~$.inArray(method, Util.getters);
        }
    };

    //地区选择弹层
    var AreaPop = function(options) {
        this._init(options);
    };

    $.extend(AreaPop.prototype, {
        //默认配置
        _defaults: {
            hiddens: {
                city: "city_id",
                province: "province_id"
            }
        },

        //初始化
        _init: function(options) {
            var that = this;

            options = that._options = $.extend(true, {}, that._defaults, options);
            if (options.$wrapper && options.$wrapper.length) {
                that._cacheParam()
                    ._bindEventListener();
            } else {
                $.error("请传入$wrapper参数");
            }
        },

        //销毁
        destroy: function() {
            var that = this;
            that._$wrapper.off(that._prefix).removeData();
            $.each(["city", "province"], function(i, item) {
                that["_$" + item + "AreaPop"].remove(); //移除弹层
                that["_$" + item + "AreaPop"] = null;
            });
            for (var i in that) {
                if (hasOwnProperty.call(that, i)) {
                    that[i] = null;
                    delete that[i];
                }
            }
        },

        //获取/设置配置项
        option: function(name, value) {
            var result,
                that = this,
                length = arguments.length;

            if (!length) {
                return $.extend(true, {}, that._options); //深拷贝
            }
            if (length === 1) {
                if ($.isPlainObject(name)) {
                    $.extend(true, that._options, result);
                } else {
                    result = that._options[name + ""];
                    return $.isPlainObject(result) ? $.extend(true, {}, result) : result;
                }
            }
            if (length === 2) {
                result[name] = value;
                $.extend(true, that._options, result);
            }
        },

        //缓存常用变量
        _cacheParam: function() {
            var $parent,
                $wrapper,
                that = this,
                options = that._options;

            for (var i in options) {
                if (hasOwnProperty.call(options, i)) {
                    that["_" + i] = options[i];
                }
            }
            that._promise = {};
            that._uuid = uuid++;
            $wrapper = that._$wrapper;
            that._prefix = ".zslAreaPop" + that._uuid;
            $.each(["city", "province"], function(i, item) {
                $parent = that["_$" + item + "Wrapper"] = $wrapper.find("[data-target=\"" + item + "\"]");
                that["_$" + item + "AreaPop"] = $parent.find(".area_pop");
                that["_$" + item + "Name"] = $parent.find("input:text");
            });
            that._generateHidden();

            return that;
        },

        //生成隐藏域
        _generateHidden: function() {
            var $hidden,
                $wrapper,
                that = this;

            $.each(that._hiddens, function(type, hidden) {
                $wrapper = that["_$" + type + "Wrapper"] || that["_$cityWrapper"];
                $hidden = $wrapper.find("input:hidden[name=\"" + hidden + "\"]");
                that["_$" + type + Util.capitalize("id")] = $hidden.length ? $hidden : $("<input type=\"hidden\" name=\"" + hidden + "\">").appendTo($wrapper);
            });
            $hidden = $wrapper = null;

            return that;
        },

        //创建地区选择弹层
        _createAreaPop: function(type, param, $wrapper, autoShow) {
            var url,
                html,
                promise,
                isAborted,
                that = this,
                $areaPop = that["_$" + type + "AreaPop"];

            autoShow = autoShow == null ? true : autoShow;
            if (that._promise[type]) {
                that._promise[type].abort();
                that._promise[type] = null;
            }
            promise = that._promise[type] = $.getJSON(that._url[type], param)
                .done(function(data) {
                    if (data && data.length) {
                        html = ["<div class=\"area_pop " + (type + "_pop") + "\"><ul class=\"clearfix\">"];
                        $.each(data, function(i, item) {
                            html.push("<li class=\"fl\" data-id=\"" + item.city_id + "\" data-value=\"" + item.city + "\"" + (item.area_id != null ? (" data-areaid=\"" + item.area_id + "\"") : "") + "><a href=\"#\">" + item.city + "</a></li>");
                        });
                        html.push("</ul></div>");
                    }
                })
                .fail(function(jqXHR, textStatus) {
                    if (textStatus === "abort") {
                        isAborted = true;
                    }
                })
                .always(function() {
                    if (!isAborted) {
                        if (html) {
                            if ($areaPop && $areaPop.length) {
                                $areaPop.remove();
                            }
                            $areaPop = that["_$" + type + "AreaPop"] = $(html.join("")).appendTo($wrapper); //重新生成areapop
                            autoShow && $areaPop.show();
                        } else {
                            alert("请求后台数据失败，请稍后重试");
                        }
                    }
                    that._promise[type] = html = promise = autoShow = null;
                });

            return that;
        },

        _hideAreaPop: function($areaPop) {
            var that = this;
            $areaPop.hide();
            return that;
        },

        //绑定事件
        _bindEventListener: function() {
            var that = this,
                prefix = that._prefix,
                $wrapper = that._$wrapper,
                eventCallback = that._eventCallback;

            $wrapper
                .on("click" + prefix, ".areapop_input", function(e) {
                    eventCallback.loadAreaDataByType.call(that, e, $(this));
                })
                .on("focusin" + prefix, ".areapop_input", function(e) {
                    this.blur();
                    e.preventDefault();
                })
                .on("click" + prefix, ".area_pop li", function(e) {
                    eventCallback.selectAreaData.call(that, e, $(this));
                });
            /*.on("mouseleave", ".area_pop", function(e) {
                    eventCallback.mouseleaveAreaPop.call(that, e, $(this));
                })*/

            //先移除点击事件防止多次绑定
            $(document)
                .off("click.zslAreaPop")
                .on("click.zslAreaPop", function(e) {
                    eventCallback.toggleAreaPop.call(that, e, $(e.target));
                });

            return that;
        },

        //事件回调
        _eventCallback: {
            //加载地区信息
            loadAreaDataByType: function(e, $target) {
                var that = this,
                    $wrapper = $target.closest(".parent_div");

                that._eventCallback["show" + Util.capitalize($wrapper.data("target"))].call(that, e, $wrapper);
            },

            //选中地区
            selectAreaData: function(e, $target) {
                var that = this,
                    id = $target.attr("data-id"),
                    name = $target.attr("data-value"),
                    $wrapper = $target.closest(".parent_div"),
                    type = $wrapper.data("target");

                if (type === "province") {
                    that._$provinceId && that._$provinceId.val(id);
                    that._$provinceName && that._$provinceName.val(name);
                    that._$cityName && that._$cityName.val("");
                    that._$cityId && that._$cityId.val("");
                    that._$areaId && that._$areaId.val("");
                    that._$cityAreaPop.remove();
                    that._$cityAreaPop = null;
                    that._createAreaPop("city", {
                        parentId: id
                    }, that._$cityWrapper, false);
                } else {
                    that._$cityName && that._$cityName.val(name);
                    that._$cityId && that._$cityId.val(id);
                    that._$areaId && that._$areaId.val($.trim($target.attr("data-areaid")));
                }
                this._hideAreaPop($wrapper.find(".area_pop"));
                e.preventDefault();
            },

            //显示省
            showProvince: function(e, $target) {
                var that = this,
                    $provinceAreaPop = that._$provinceAreaPop;

                that._$cityAreaPop.hide();
                if ($provinceAreaPop && $provinceAreaPop.length) {
                    $provinceAreaPop.show();
                } else {
                    that._createAreaPop("province", null, $target, true);
                }
            },

            //显示市
            showCity: function(e, $target) {
                var that = this,
                    $cityAreaPop = that._$cityAreaPop,
                    provinceId = $.trim(that._$provinceId.val());

                that._$provinceAreaPop.hide();
                if ($cityAreaPop && $cityAreaPop.length) {
                    $cityAreaPop.show();
                } else {
                    if (provinceId) {
                        that._createAreaPop("city", {
                            parentId: provinceId
                        }, $target, true);
                    } else {
                        alert("请先选择省份");
                    }
                }
            },

            //移出地区选择框
            mouseleaveAreaPop: function(e, $target) {
                this._hideAreaPop($target);
            },

            toggleAreaPop: function(e, $target) {
                var $areaPop;
                if (!$target.closest(".parent_div").length) {
                    $areaPop = $target.closest(".area_pop");
                    if ($areaPop.length) {
                        $(".area_pop").each(function() {
                            if (this !== $areaPop[0]) {
                                $(this).hide();
                            }
                        });
                    } else {
                        $(".area_pop").hide();
                    }
                }
            }
        }
    });
    $.fn.areaPop = function(options) {
        var instance,
            $first = this.eq(0),
            otherArgs = ([]).slice.call(arguments, 1);

        //get方法
        if (Util.isNotChained(options, otherArgs)) {
            if (!(instance = $first.data("areapop"))) {
                $.error("请先初始化");
            }
            if (!(options.charAt(0) === "_") && instance[options]) {
                return instance[options].apply(instance, otherArgs);
            } else {
                $.error("不存在" + options + "方法");
            }
        }

        return this.each(function(i, item) {
            var $wrapper = $(this),
                instance = $wrapper.data("areapop");

            if (typeof(options) === "string") {
                if (!instance) {
                    $.error("请先初始化");
                }
                if (!(options.charAt(0) === "_") && instance[options]) {
                    //调用其他方法
                    instance[options].apply(instance, otherArgs);
                } else {
                    $.error("不存在" + options + "方法");
                }
            } else {
                //若已初始化则先销毁
                if (instance) {
                    instance.destroy();
                }
                //初始化方法
                instance = new AreaPop($.extend(true, {}, options, {
                    $wrapper: $wrapper
                }));
                $wrapper.data("areapop", instance);
            }
        });
    };
})(this, jQuery);