var JPlaceHolder = {
    //ºÏ≤‚
    _check: function () {
        return 'placeholder' in document.createElement('input');
    },
    //≥ı ºªØ
    init: function () {
        if (!this._check()) {
            this.fix();
        }
    },
    //–ﬁ∏¥
    fix: function () {
        jQuery(':input[placeholder]').each(function (index, element) {
            var self = $(this), txt = self.attr('placeholder');
            self.wrap($('<div></div>').css({ position: 'relative', zoom: '1', border: 'none', background: 'none', padding: 'none', margin: 'none' }));
            var pos = self.position(), h = self.outerHeight(true), paddingleft = self.css('padding-left');

            //top: pos.top,
            var holder = $('<i></i>').text(txt).css({ position: 'absolute', left: pos.left, height: h,"line-height":+h+'px', paddingLeft: paddingleft, color: '#aaa' }).appendTo(self.parent());
            self.focusin(function (e) {
                holder.hide();
            }).focusout(function (e) {
                if (!self.val()) {
                    holder.show();
                }
            });
            holder.click(function (e) {
                holder.hide();
                self.focus();
            });
        });
    }
};
//÷¥––
jQuery(function () {
    JPlaceHolder.init();
});