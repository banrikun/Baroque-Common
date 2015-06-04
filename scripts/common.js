var br = {
    //添加事件
    addEL: function(e, type, fun) {
        if (e.addEventListener) {
            e.addEventListener(type, fun, false);
        } else if (e.attachEvent) {
            e.attachEvent('on' + type, fun);
        } else {
            e['on' + type] = fun;
        }
    },

    //设置输入框属性
    setVal: function(e, val) {
        e.value = val;
        br.addEL(e, 'focus', function() {
            if (this.value === val) {
                this.value = '';
            }
        })
        br.addEL(e, 'blur', function() {
            if (this.value === '') {
                this.value = val;
            }
        })
    },

    //移动端隐藏头部
    hideHd: function(e) {
        var hd = document.getElementById('header');

        if (document.documentElement.clientWidth < 1000) {
            br.addEL(e, 'focus', function() {
                hd.style.display = 'none';
            })
            br.addEL(e, 'blur', function() {
                hd.style.display = null;
            })
        }
    },

    //快捷键提交
    prsKey: function(e) {
        var sub = document.getElementById('submit');

        br.addEL(e, 'keydown', function(event) {
            if ((event.metaKey && event.keyCode == 13) || (event.ctrlKey && event.keyCode == 13)) {
                sub.click();
            }
        })
    }
}

//切换菜单
! function() {
    var btn = document.getElementById('toggle'),
        nav = document.getElementById('nav'),
        hei = nav.getElementsByTagName('a').length * 40;

    br.addEL(btn, 'click', function() {
        if (btn.className === 'show-btn') {
            btn.className = null;
            nav.style.height = null;
        } else {
            btn.className = 'show-btn';
            nav.style.height = hei + 'px';
        }
    })
}()

//表单相关
! function() {
    var form = document.getElementById('comment-form');

    if (form) {
        var input = form.getElementsByTagName('input'),
            area = document.getElementById('textarea'),
            len = input.length,
            i;

        for (i = 0; i < len; i++) {
            if (len > 0 && !('placeholder' in input[0])) {
                var pla = input[i].getAttribute('placeholder');

                br.setVal(input[i], pla);
            }
            br.hideHd(input[i]);
        }
        br.hideHd(area);
        br.prsKey(form);
    }
}()
