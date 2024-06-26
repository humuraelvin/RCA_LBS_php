 ! function(a) {
    "use strict";
    "function" == typeof define && define.amd ? define(a) : window.Ply = a()
}(function() {
    "use strict";

    function a(a) {
        if (Q) return new Q(a);
        var b = N.Deferred();
        return a(b.resolve, b.reject), b
    }

    function b(a) {
        return Q ? Q.all(a) : N.when.apply(N, a)
    }

    function c(b) {
        return a(function(a) {
            return a(b)
        })
    }

    function d(a) {
        return a && a.then ? a : c(a)
    }

    function e(a) {
        return "function" == typeof a
    }

    function f(a, b) {
        if (a)
            for (var c in a) a.hasOwnProperty(c) && b(a[c], c, a)
    }

    function g(a) {
        var b = {};
        return f(a, function(a, c) {
            b[c] = e(a) ? a : a instanceof Object ? g(a) : a
        }), b
    }

    function h(a) {
        for (var b = Array.prototype.slice, c = b.call(arguments, 1), d = 0, e = c.length; e > d; d++) f(c[d], function(b, c) {
            a[c] = b
        });
        return a
    }

    function i(a, b) {
        try {
            return (b || H).querySelector(a)
        } catch (c) {
            return N(a, b)[0]
        }
    }

    function j(a, b) {
        return a.getElementsByTagName(b)
    }

    function k(a, b) {
        try {
            a && b && a.appendChild(b)
        } catch (c) {}
    }

    function l(a) {
        a && a.parentNode && a.parentNode.removeChild(a)
    }

    function m(a, b, c) {
        var d = c.handle = c.handle || function(b) {
            b.target || (b.target = b.srcElement || H), 3 === b.target.nodeType && (b.target = b.target.parentNode), b.preventDefault || (b.preventDefault = function() {
                b.returnValue = !1
            }), b.stopPropagation || (b.stopPropagation = function() {
                b.cancelBubble = !0
            }), c.call(a, b)
        };
        a.addEventListener ? a.addEventListener(b, d, !1) : a.attachEvent("on" + b, d)
    }

    function n(a, b, c) {
        var d = c.handle;
        d && (a.removeEventListener ? a.removeEventListener(b, d, !1) : a.detachEvent("on" + b, d))
    }

    function o(a) {
        if (null == a && (a = "div"), a.appendChild) return a;
        if (a.skip) return H.createDocumentFragment();
        "string" == typeof a && (a = {
            tag: a
        });
        var b, c = a.children,
            d = S.exec(a.tag || "");
        return delete a.children, a.tag = d[1] || "div", a.id = a.id || (d[2] || "").substr(1), d = (d[3] || "").split("."), d[0] = a.className || "", a.className = d.join(" "), b = H.createElement(a.tag), delete a.tag, f(a, function(c, d) {
            if (c)
                if ("css" === d) r(b, a.css);
                else if ("text" === d) null != c && k(b, H.createTextNode(c));
            else if ("html" === d) null != c && (b.innerHTML = c);
            else if ("ply" === d) b.setAttribute(M, c);
            else if (d in b) try {
                b[d] = c
            } catch (e) {
                b.setAttribute(d, c)
            } else /^data-/.test(d) && b.setAttribute(d, c)
        }), c && c.appendChild ? k(b, c) : f(c, function(a, c) {
            a && ("string" == typeof a ? a = {
                text: a
            } : "object" != typeof a && (a = {}), "string" == typeof c && (a.tag = a.tag || c), k(b, o(a)))
        }), b
    }

    function p(a) {
        for (var b, c, d = j(a, "input"), e = 0, f = d.length; f > e; e++)
            if (b = d[e], "submit" === b.type) !c && (c = b);
            else if (!/hidden|check|radio/.test(b.type) && "" == b.value) {
            c = b;
            break
        }
        c || (c = j(a, "button")[0]);
        try {
            c.focus()
        } catch (g) {}
    }

    function q(b) {
        return s(!0), a(function(a) {
            for (var c, d = j(b, "img"), e = d.length, f = e, g = function() {
                    if (--f <= 0) {
                        for (e = d.length; e--;) c = d[e], n(c, "load", g), n(c, "error", g);
                        s(!1), a()
                    }
                }; e--;) c = d[e], c.complete ? f-- : (m(c, "load", g), m(c, "error", g));
            !f && g()
        })
    }

    function r(a, b, c) {
        if (a && a.style && b)
            if (b instanceof Object)
                for (var d in b) r(a, d, b[d]);
            else {
                if (void 0 === c) return H.defaultView && H.defaultView.getComputedStyle ? c = H.defaultView.getComputedStyle(a, "") : a.currentStyle && (c = a.currentStyle), void 0 === b ? c : c[b];
                T[b] ? T[b](a.style, c) : a.style[K[b] || b] = c
            }
    }

    function s(a) {
        var b = s.get();
        clearTimeout(s.pid), s.pid = a ? I(function() {
            k(H.body, b)
        }, 100) : I(function() {
            l(b)
        }, 100)
    }

    function t(a, b) {
        return o({
            css: h({
                padding: "20px 20px 40px",
                display: "inline-block",
                position: "relative",
                textAlign: "left",
                whiteSpace: "normal",
                verticalAlign: "middle",
                transform: "translate3d(0, 0, 0)"
            }, b.wrapper),
            children: b.baseHtml ? [{
                ply: ":layer",
                tag: ".ply-layer",
                className: b.mod,
                css: h({
                    overflow: "hidden",
                    position: "relative",
                    backfaceVisibility: "hidden"
                }, b.layer),
                children: [b.flags.closeBtn && {
                    ply: ":close",
                    tag: ".ply-x",
                    text: J.cross
                }, {
                    tag: ".ply-inside",
                    children: a
                }]
            }] : a
        })
    }

    function u(a) {
        return o({
            ply: ":overlay",
            tag: ".ply-overlay",
            css: {
                top: 0,
                left: 0,
                right: 0,
                bottom: 0,
                position: "fixed"
            },
            children: [{
                tag: "div",
                css: h({
                    width: "100%",
                    height: "100%"
                }, a)
            }]
        })
    }

    function v(a, b, c) {
        a.wrapEl = o({
            tag: b.rootTag,
            css: {
                whiteSpace: "nowrap",
                zIndex: b.zIndex
            },
            method: "post",
            action: "/"
        }), c || (a.overlayEl = u(b.overlay), a.overlayBoxEl = a.overlayEl.firstChild, k(a.wrapEl, a.overlayEl));
        var d = o();
        r(d, {
            height: "100%",
            display: "inline-block",
            verticalAlign: "middle"
        }), k(a.wrapEl, d);
        var e = b.el;
        return a.el = e && e.cloneNode ? b.clone ? e.cloneNode(!0) : e : o({
            html: e || ""
        }), a.layerEl = t(a.el, b), a.contentEl = w(a.layerEl), a.context = new y(a.layerEl), k(a.wrapEl, a.layerEl), a.bodyEl = b.body && i(b.body) || H.body, a.wrapEl.tabIndex = -1, r(a.wrapEl, {
            top: 0,
            left: 0,
            right: 0,
            bottom: 0,
            position: "fixed",
            textAlign: "center",
            overflow: "auto",
            outline: 0
        }), a
    }

    function w(a) {
        return a.firstChild.lastChild.firstChild
    }

    function x(a, b) {
        b = a instanceof Object ? a : b || {}, b.el = b.el || a;
        var d = this;
        d.cid = "c" + E++, O.zIndex++, d.options = b = h({}, O, b), b.flags = h({}, O.flags, b.flags), v(d, b), d.setEffect(b.effect), d.fx = function(a) {
            return !(d.fx.queue = d.fx.queue.then(a, a).then(function() {
                return d
            }))
        }, d.fx.queue = c(), d.on("click", ":overlay", function() {
            d.hasFlag("closeByOverlay") && d.closeBy("overlay")
        }), d.on("click", ":close", function(a, b) {
            a.preventDefault(), d.closeBy("BUTTON" === b.nodeName ? "cancel" : "x")
        }), d.options.oninit(this)
    }

    function y(a) {
        this.el = a
    }

    function z(a) {
        return a && a.appendChild
    }

    function A(a, b) {
        return null == a ? {
            skip: !0
        } : ("string" == typeof a && (a = {
            text: a
        }), "object" == typeof a && (a.name = a.name || b), a)
    }

    function B(a, b, c) {
        var d, e = B[a];
        return e || (a = a.split(/\s+/).slice(0, -1).join(" "), e = b && (B[a + " [name=" + b.name + "]"] || B[a + " [type=" + b.type + "]"]) || B[a + " *"] || B[":default"]), d = o(e(b, c)), b && b.name && d.setAttribute(M + "-name", b.name), d.className += " ply-ui", d
    }

    function C(b, c) {
        C["_" + b] = c, C[b] = function(b, d) {
            return a(function(a, e) {
                c(b, d, a, e)
            }).then(function(a) {
                return z(a) || (a = B(":root", a)), a
            })
        }
    }

    function D(a, b, c, d) {
        return b.mod = a, b.effect = b.effect || "slide", b.flags = h({
            closeBtn: !1
        }, b.flags), {
            header: c.title,
            content: c.form ? {
                "dialog-form": {
                    children: c.form
                }
            } : {
                el: c.text || c
            },
            ctrls: {
                ok: c.ok || d.ok,
                cancel: c.cancel === !1 ? null : c.cancel || d.cancel
            }
        }
    }
    var E = 1,
        F = function() {},
        G = window,
        H = G.document,
        I = G.setTimeout,
        J = {
            ok: "TAMAM",
            cancel: "Cancel",
            cross: "✖"
        },
        K = function() {
            var a = {},
                b = H.createElement("div").style,
                c = "opacity transition transform perspective transformStyle transformOrigin backfaceVisibility".split(" "),
                d = ["Webkit", "Moz", "O", "MS"];
            return f(c, function(c, e) {
                if (a[c] = c in b && c, !a[c])
                    for (e = 0; 4 > e; e++) {
                        var f = d[e] + c.charAt(0).toUpperCase() + c.substr(1);
                        if (a[c] = f in b && f) break
                    }
            }), a
        }(),
        L = {
            esc: 27
        },
        M = "data-ply",
        N = window.jQuery || window.Zepto || window.ender || window.$,
        O = {
            clone: !0,
            zIndex: 1e4,
            rootTag: "form",
            baseHtml: !0,
            layer: {},
            wrapper: {},
            overlay: {
                opacity: .6,
                backgroundColor: "rgb(0, 0, 0)"
            },
            flags: {
                closeBtn: !0,
                bodyScroll: !1,
                closeByEsc: !0,
                closeByOverlay: !0,
                hideLayerInStack: !0,
                visibleOverlayInStack: !1
            },
            oninit: F,
            onopen: F,
            onclose: F,
            ondestroy: F,
            onaction: F
        },
        P = window.Promise,
        Q = window.Deferred || P,
        R = c();
    P && !R.always && (Q = function(a) {
        var b = new P(a);
        return b.__proto__ = this.__proto__, b
    }, Q.prototype = Object.create(P.prototype), Q.prototype.constructor = Q, Q.prototype.then = function(a, b) {
        var c = P.prototype.then.call(this, a, b);
        return c.__proto__ = this.__proto__, c
    }, Q.prototype.done = function(a) {
        return this.then(a), this
    }, Q.prototype.fail = function(a) {
        return this["catch"](a), this
    }, Q.prototype.always = function(a) {
        return this.then(a, a), this
    }, ["all", "cast", "reject", "resolve"].forEach(function(a) {
        Q[a] = P[a]
    }));
    var S = /^(\w+)?(#\w+)?((?:\.[\w_-]+)*)/i,
        T = {
            opacity: !K.opacity && function(a, b) {
                a.zoom = 1, a.filter = "alpha(opacity=" + 100 * b + ")"
            }
        };
    s.get = function() {
        return s.el || (s.el = o({
            tag: ".ply-global-loading",
            children: {
                ".ply-loading-spinner": !0
            }
        }))
    }, x.fn = x.prototype = {
        constructor: x,
        _activate: function() {
            if (!this.hasFlag("bodyScroll")) {
                var a = this.bodyEl,
                    b = o({
                        css: {
                            overflow: "auto",
                            visibility: "hidden",
                            height: "5px"
                        },
                        children: [{
                            tag: "div",
                            css: {
                                height: "100px"
                            }
                        }]
                    });
                this.__overflow = r(a, "overflow"), this.__paddingRight = r(a, "paddingRight"), k(a, b), r(a, {
                    overflow: "hidden",
                    paddingRight: b.offsetWidth - b.firstChild.offsetWidth + "px"
                }), l(b)
            }
            m(this.wrapEl, "submit", this._getHandleEvent("submit"))
        },
        _deactivate: function() {
            this.hasFlag("bodyScroll") || r(this.bodyEl, {
                overflow: this.__overflow,
                paddingRight: this.__paddingRight
            }), n(this.layerEl, "submit", this._getHandleEvent("submit"))
        },
        _getHandleEvent: function(a) {
            var b = this,
                c = b.__handleEvent || (b.__handleEvent = {});
            return c[a] || (c[a] = function(c) {
                b._handleEvent(a, c)
            }), c[a]
        },
        _handleEvent: function(a, b) {
            b.preventDefault(), this.closeBy(a)
        },
        $: function(a) {
            return N(a, this.layerEl)
        },
        find: function(a) {
            return i(a, this.layerEl)
        },
        applyEffect: function(a, b, c) {
            return a = this[a] || a, a.nodeType || (c = b, b = a, a = this.layerEl), c = x.effects.get(c || this.effects), x.effects.apply.call(c, a, b)
        },
        closeBy: function(a) {
            var b = this,
                c = {
                    by: a,
                    state: "submit" === a,
                    data: this.context.toJSON(),
                    widget: this,
                    context: this.context
                },
                e = (this.el, this.options.onaction(c));
            this.__lock || (this.__lock = !0, this.el.className += " ply-loading", d(e).done(function(a) {
                a !== !1 && (b.result = c, b.close())
            }).always(function() {
                b.__lock = !1, b.el.className = b.el.className.replace(/\s?ply-loading/, "")
            }))
        },
        on: function(a, b, c) {
            var d = this;
            return c || (c = b, b = ":layer"), c["_" + b] = function(a) {
                var e = a.target;
                do
                    if (1 === e.nodeType && e.getAttribute(M) === b) return c.call(d, a, e);
                while (e !== d.wrapEl && (e = e.parentNode))
            }, m(d.wrapEl, a, c["_" + b]), d
        },
        off: function(a, b, c) {
            return c || (c = b, b = "layer"), n(this.wrapEl, a, c["_" + b] || F), this
        },
        hasFlag: function(a) {
            return !!this.options.flags[a]
        },
        setEffect: function(a) {
            return this.effects = x.effects.get(a), this
        },
        _toggleState: function(a, c) {
            var d = this,
                e = a ? "open" : "close",
                f = x.stack.last;
            return d.visible != a && (d.visible = a, d[a ? "_activate" : "_deactivate"](), x.stack[a ? "add" : "remove"](d), d.fx(function() {
                return q(d.wrapEl).then(function() {
                    var g = x.stack.length === (a ? 1 : 0),
                        h = f && f.hasFlag("hideLayerInStack"),
                        i = g || d.hasFlag("visibleOverlayInStack");
                    return a ? (!i && l(d.overlayBoxEl), k(d.bodyEl, d.wrapEl), d.wrapEl.focus(), p(d.layerEl), h && f.applyEffect("close.layer", c).then(function() {
                        l(f.layerEl)
                    })) : (f = x.stack.last) && (k(f.wrapEl, f.layerEl), f.hasFlag("hideLayerInStack") && f.applyEffect("open.layer", c).then(function() {
                        p(f.el)
                    })), b([d.applyEffect(e + ".layer", c), i && d.applyEffect("overlayEl", e + ".overlay", c)]).then(function() {
                        a || (l(d.wrapEl), k(d.overlayEl, d.overlayBoxEl)), d.options["on" + e](d)
                    })
                })
            })), d.fx.queue
        },
        open: function(a) {
            return this.result = null, this._toggleState(!0, a)
        },
        close: function(a) {
            return this._toggleState(!1, a)
        },
        _swap: function(a, c, d, e, f) {
            var g = this;
            return g.visible ? g.fx(function() {
                return q(c).then(function() {
                    return e(), b([g.applyEffect(a, "close.layer", d), g.applyEffect(c, "open.layer", d)]).then(function() {
                        l(a), f(), g.wrapEl.focus(), p(c)
                    })
                })
            }) : f(), g.fx.queue
        },
        swap: function(a, b) {
            a = h({}, this.options, a);
            var c = this,
                d = v({}, a, !0),
                e = b || a.effect ? x.effects.get(b || a.effect) : c.effects,
                f = c.layerEl,
                g = d.layerEl;
            return c._swap(f, g, e, function() {
                k(c.bodyEl, c.wrapEl), k(c.bodyEl, d.wrapEl)
            }, function() {
                l(d.wrapEl), k(c.wrapEl, g), c.el = d.el, c.layerEl = g, c.contentEl = w(g), c.context.el = g
            })
        },
        innerSwap: function(a, b) {
            a = h({}, this.options, a);
            var c = this,
                d = v({}, a, !0),
                e = b || a.effect ? x.effects.get(b || a.effect) : c.effects,
                f = i(".ply-inside", d.layerEl),
                g = i(".ply-inside", c.layerEl);
            return c._swap(g, f, e, function() {
                r(g, {
                    width: g.offsetWidth + "px",
                    position: "absolute"
                }), k(g.parentNode, f)
            }, F)
        },
        destroy: function() {
            l(this.wrapEl), this._deactivate(), x.stack.remove(this), this.visible = !1, this.options.ondestroy(this)
        }
    };
    var U = [],
        V = U.push,
        W = U.splice;
    return x.stack = {
        _idx: {},
        last: null,
        length: 0,
        _pop: function(a) {
            var b = x.stack.last;
            a.keyCode === L.esc && b.hasFlag("closeByEsc") && b.closeBy("esc")
        },
        add: function(a) {
            var b = V.call(this, a);
            this.last = a, this._idx[a.cid] = b - 1, 1 === b && m(H, "keyup", this._pop)
        },
        remove: function(a) {
            var b = this._idx[a.cid];
            b >= 0 && (W.call(this, b, 1), delete this._idx[a.cid], this.last = this[this.length - 1], this.last || n(H, "keyup", this._pop))
        }
    }, x.effects = {
        defaults: {
            duration: 300,
            open: {
                layer: null,
                overlay: null
            },
            close: {
                layer: null,
                overlay: null
            }
        },
        setup: function(a) {
            this.defaults = this.get(a)
        },
        set: function(a) {
            h(this, a)
        },
        get: function(a) {
            function b(a) {
                var b = /^([\w_-]+)(?::(\d+%?))?(\[[^\]]+\])?/.exec(a) || [];
                return {
                    name: b[1] || a,
                    duration: b[2] || null,
                    args: JSON.parse(b[3] || "null") || {}
                }
            }

            function c(c, d, e) {
                var f = b(d),
                    g = c[f.name] || e || {},
                    h = f.duration || g.duration || c.duration || a.duration;
                return "string" == typeof g && (g = b(g), delete g.args), /%/.test(g.duration) && (g.duration = parseInt(g.duration, 10) / 100 * h), g.duration = 0 | (g.duration || h), g
            }
            var d = g(this.defaults);
            if ("string" == typeof a) {
                var e = b(a);
                a = g(this[e.name] || {
                    open: {},
                    close: {}
                }), a.duration = e.duration || a.duration, a.open.args = e.args[0], a.close.args = e.args[1]
            } else if (a instanceof Array) {
                var f = b(a[0]),
                    h = b(a[1]),
                    i = this[f.name],
                    j = this[h.name];
                a = {
                    open: g(i && i.open || {
                        layer: a[0],
                        overlay: a[0]
                    }),
                    close: g(j && j.close || {
                        layer: a[1],
                        overlay: a[1]
                    })
                }, a.open.args = f.args[0], a.close.args = h.args[0]
            } else a instanceof Object || (a = {});
            a.duration = 0 | (a.duration || d.duration);
            for (var k in {
                    open: 0,
                    close: 0
                }) {
                var l = a[k] || d[k] || {};
                "string" == typeof l && (l = {
                    layer: l
                }), l.layer = c(l, "layer", d[k].layer), l.overlay = c(l, "overlay", d[k].overlay), void 0 === l.args && delete l.args, a[k] = l
            }
            return a
        },
        apply: function(b, d) {
            d = d.split(".");
            var h, i, j = this[d[0]],
                k = b.firstChild,
                l = [b.getAttribute("style"), k && k.getAttribute("style")];
            return K.transition && j && (i = j[d[1]]) && (h = x.effects[i.name]) && (h.to || h.from) ? (h = g(h), r(b, "transition", "none"), r(k, "transition", "none"), f(h.to, function(a, c, d) {
                "&" === a && (d[c] = r(b, c))
            }), e(h.from) ? h.from(b, j.args) : h.from && r(b, h.from), a(function(a) {
                h.width = b.offsetWidth, r(b, "transition", "all " + i.duration + "ms"), r(k, "transition", "all " + i.duration + "ms"), e(h.to) ? h.to(b, j.args) : r(b, h.to), I(a, i.duration)
            }).then(function() {
                b.setAttribute("style", l[0]), k && k.setAttribute("style", l[1])
            })) : c()
        }
    }, x.effects.set({
        fade: {
            open: {
                layer: "fade-in:80%",
                overlay: "fade-in:100%"
            },
            close: {
                layer: "fade-out:60%",
                overlay: "fade-out:60%"
            }
        },
        scale: {
            open: {
                layer: "scale-in",
                overlay: "fade-in"
            },
            close: {
                layer: "scale-out",
                overlay: "fade-out"
            }
        },
        fall: {
            open: {
                layer: "fall-in",
                overlay: "fade-in"
            },
            close: {
                layer: "fall-out",
                overlay: "fade-out"
            }
        },
        slide: {
            open: {
                layer: "slide-in",
                overlay: "fade-in"
            },
            close: {
                layer: "slide-out",
                overlay: "fade-out"
            }
        },
        "3d-flip": {
            open: {
                layer: "3d-flip-in",
                overlay: "fade-in"
            },
            close: {
                layer: "3d-flip-out",
                overlay: "fade-out"
            }
        },
        "3d-sign": {
            open: {
                layer: "3d-sign-in",
                overlay: "fade-in"
            },
            close: {
                layer: "3d-sign-out",
                overlay: "fade-out"
            }
        },
        inner: {
            open: {
                layer: "inner-in"
            },
            close: {
                layer: "inner-out"
            }
        },
        "fade-in": {
            from: {
                opacity: 0
            },
            to: {
                opacity: "&"
            }
        },
        "fade-out": {
            to: {
                opacity: 0
            }
        },
        "slide-in": {
            from: {
                opacity: 0,
                transform: "translateY(20%)"
            },
            to: {
                opacity: "&",
                transform: "translateY(0)"
            }
        },
        "slide-out": {
            to: {
                opacity: 0,
                transform: "translateY(20%)"
            }
        },
        "fall-in": {
            from: {
                opacity: 0,
                transform: "scale(1.3)"
            },
            to: {
                opacity: "&",
                transform: "scale(1)"
            }
        },
        "fall-out": {
            to: {
                opacity: 0,
                transform: "scale(1.3)"
            }
        },
        "scale-in": {
            from: {
                opacity: 0,
                transform: "scale(0.7)"
            },
            to: {
                opacity: "&",
                transform: "scale(1)"
            }
        },
        "scale-out": {
            to: {
                opacity: 0,
                transform: "scale(0.7)"
            }
        },
        rotate3d: function(a, b, c, d, e) {
            r(a, {
                perspective: "1300px"
            }), r(a.firstChild, {
                opacity: b,
                transform: "rotate" + c + "(" + d + "deg)",
                transformStyle: "preserve-3d",
                transformOrigin: e ? "50% 0" : "50%"
            })
        },
        "3d-sign-in": {
            from: function(a) {
                x.effects.rotate3d(a, 0, "X", -60, "50% 0")
            },
            to: function(a) {
                r(a.firstChild, {
                    opacity: 1,
                    transform: "rotateX(0)"
                })
            }
        },
        "3d-sign-out": {
            from: function(a) {
                x.effects.rotate3d(a, 1, "X", 0, "50% 0")
            },
            to: function(a) {
                r(a.firstChild, {
                    opacity: 0,
                    transform: "rotateX(-60deg)"
                })
            }
        },
        "3d-flip-in": {
            from: function(a, b) {
                x.effects.rotate3d(a, 0, "Y", b || -70)
            },
            to: function(a) {
                r(a.firstChild, {
                    opacity: 1,
                    transform: "rotateY(0)"
                })
            }
        },
        "3d-flip-out": {
            from: function(a) {
                x.effects.rotate3d(a, 1, "Y", 0)
            },
            to: function(a, b) {
                r(a.firstChild, {
                    opacity: 0,
                    transform: "rotateY(" + (b || 70) + "deg)"
                })
            }
        },
        "inner-in": {
            from: function(a) {
                r(a, "transform", "translateX(100%)")
            },
            to: function(a) {
                r(a, "transform", "translateX(0%)")
            }
        },
        "inner-out": {
            from: function(a) {
                r(a, "transform", "translateX(0%)")
            },
            to: function(a) {
                r(a, "transform", "translateX(-100%)")
            }
        }
    }), y.fn = y.prototype = {
        constructor: y,
        getEl: function(a) {
            return this.el ? i("[" + M + '-name="' + a + '"]', this.el) : void 0
        },
        val: function(a, b) {
            var c = "string" == typeof a ? this.getEl(a) : a;
            return c && null == c.value && (c = j(c, "input")[0] || j(c, "textarea")[0] || j(c, "select")[0]), c && null != b && (c.value = b), c && c.value || ""
        },
        toJSON: function() {
            for (var a, b = this.el.querySelectorAll("[" + M + "-name]"), c = {}, d = b.length; d--;) a = b[d], c[a.getAttribute(M + "-name")] = this.val(a);
            return c
        }
    }, B.factory = function(a, b, c) {
        B[a.replace(/^\s+|\s+$/g, "").replace(/\s+/g, " ")] = function(d, e) {
            var g, i = H.createDocumentFragment();
            return null != d || ":root" === a ? (d = c ? d : A(d), f(c ? d : d.children, function(b, c) {
                var d = ((e || a) + " " + c).replace(/^:\w+\s+/, ""),
                    f = z(b) ? b : B(d, A(b, c), d);
                k(i, f)
            }), c || delete d.children, g = b(d, i), z(g) || h(g, d), g) : i
        }
    }, B.factory(":default", function(a, b) {
        return a.children = b, a
    }), B.factory(":root", function(a) {
        return {
            tag: ".ply-form",
            className: a.mod,
            children: [B(":header", a.header), B(":content", a.content), a.ctrls && B(":default", {
                tag: "div.ply-footer",
                children: a.ctrls
            })]
        }
    }), B.factory(":header", function(a, b) {
        return {
            tag: ".ply-header",
            text: a.text,
            children: b
        }
    }), B.factory(":content", function(a, b) {
        return {
            tag: ".ply-content",
            children: b
        }
    }, !0), B.factory("ok", function(a) {
        return {
            ply: ":ok",
            tag: "button.ply-ctrl.ply-ok",
            text: a === !0 ? J.ok : a
        }
    }), B.factory("cancel", function(a) {
        return {
            ply: ":close",
            tag: "button.ply-ctrl.ply-cancel",
            type: "reset",
            text: a === !0 ? J.cancel : a
        }
    }), C.use = function(a, b, c, d, e) {
        C["_" + a](b, c, d, e)
    }, C("default", function(a, b, c) {
        c(b || {})
    }), C("base", function(a, b, c) {
        c(D("base", a, b))
    }), C("alert", function(a, b, c) {
        c(D("alert", a, b, {
            ok: !0
        }))
    }), C("confirm", function(a, b, c) {
        c(D("confirm", a, b, {
            ok: !0,
            cancel: !0
        }))
    }), C("prompt", function(a, b, c) {
        c(D("prompt", a, b, {
            ok: !0,
            cancel: !0
        }))
    }), B.factory("dialog-form *", function(a) {
        return {
            tag: "input.ply-input",
            type: a.type || "text",
            name: a.name,
            value: a.value,
            required: !0,
            placeholder: a.hint || a.text
        }
    }), x.create = function(a, b, d) {
        if (z(a)) return c(new x(h(b || {}, {
            el: a
        })));
        d || (d = b, b = {});
        var e = C[a] || C["default"];
        return e(b, d).then(function(a) {
            return new x(h(b, {
                el: a
            }))
        })
    }, x.open = function(a, b, c) {
        return x.create(a, b, c).then(function(a) {
            return a.open()
        })
    }, x.dialog = function(b, c, d) {
        return b instanceof Object && !z(b) ? (c = c || {}, a(function(a, d) {
            var e, g, i, j = c.initState,
                k = b,
                l = {},
                m = function(a, b) {
                    (c.progress || F)(h({
                        name: e.$name,
                        index: e.$index,
                        length: o,
                        stack: k,
                        current: e,
                        widget: b
                    }, a), l)
                },
                n = function(a, b, c) {
                    var d = JSON.parse(JSON.stringify(a.data));
                    e = a, i = !0, (a.prepare || F)(d, l), x.create(a.ui || "alert", a.options || {}, d).then(function(d) {
                        var e;
                        g ? e = g[/^inner/.test(b) ? "innerSwap" : "swap"](d, b) : (g = d, e = g.open()), e.then(function() {
                            l[a.$name].el = g.layerEl, i = !1
                        }), c(g)
                    })
                },
                o = 0;
            f(k, function(a, b) {
                j = j || b, a.effects = a.effects || {}, a.$name = b, a.$index = o++, l[b] = new x.Context
            }), k.$length = o, n(k[j], null, function(b) {
                m({}, b), g.options.onaction = function(b) {
                    if (i) return !1;
                    var c = b.state || "next" === e.back,
                        f = k[e[c ? "next" : "back"]];
                    return f ? (n(f, e[c ? "nextEffect" : "backEffect"], function(a) {
                        m(b, a)
                    }), !1) : void(b.state ? a : d)(b, l)
                }
            })
        })) : (d || z(b) || (d = c || {}, c = {}), x.open(b, c, d).then(function(b) {
            return a(function(a, c) {
                b.options.onclose = function() {
                    (b.result.state ? a : c)(b.result)
                }
            })
        }))
    }, x.ui = B, x.factory = C, x.lang = J, x.css = r, x.cssHooks = T, x.keys = L, x.noop = F, x.each = f, x.extend = h, x.promise = a, x.Promise = Q, x.support = K, x.defaults = O, x.attrName = M, x.Context = y, x.dom = {
        build: o,
        append: k,
        remove: l,
        addEvent: m,
        removeEvent: n
    }, x.version = "0.6.1", x
});