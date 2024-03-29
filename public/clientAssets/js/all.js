var FlipClock, Base = function () {
};
Base.extend = function (t, i) {
    "use strict";
    var e = Base.prototype.extend;
    Base._prototyping = !0;
    var s = new this;
    e.call(s, t), s.base = function () {
    }, delete Base._prototyping;
    var n = s.constructor, o = s.constructor = function () {
        if (!Base._prototyping) if (this._constructing || this.constructor == o) this._constructing = !0, n.apply(this, arguments), delete this._constructing; else if (null !== arguments[0]) return (arguments[0].extend || e).call(arguments[0], s)
    };
    return o.ancestor = this, o.extend = this.extend, o.forEach = this.forEach, o.implement = this.implement, o.prototype = s, o.toString = this.toString, o.valueOf = function (t) {
        return "object" == t ? o : n.valueOf()
    }, e.call(o, i), "function" == typeof o.init && o.init(), o
}, Base.prototype = {
    extend: function (t, i) {
        if (arguments.length > 1) {
            var e = this[t];
            if (e && "function" == typeof i && (!e.valueOf || e.valueOf() != i.valueOf()) && /\bbase\b/.test(i)) {
                var s = i.valueOf();
                (i = function () {
                    var t = this.base || Base.prototype.base;
                    this.base = e;
                    var i = s.apply(this, arguments);
                    return this.base = t, i
                }).valueOf = function (t) {
                    return "object" == t ? i : s
                }, i.toString = Base.toString
            }
            this[t] = i
        } else if (t) {
            var n = Base.prototype.extend;
            Base._prototyping || "function" == typeof this || (n = this.extend || n);
            for (var o = {toSource: null}, a = ["constructor", "toString", "valueOf"], c = Base._prototyping ? 0 : 1; r = a[c++];) t[r] != o[r] && n.call(this, r, t[r]);
            for (var r in t) o[r] || n.call(this, r, t[r])
        }
        return this
    }
}, Base = Base.extend({
    constructor: function () {
        this.extend(arguments[0])
    }
}, {
    ancestor: Object, version: "1.1", forEach: function (t, i, e) {
        for (var s in t) void 0 === this.prototype[s] && i.call(e, t[s], s, t)
    }, implement: function () {
        for (var t = 0; t < arguments.length; t++) "function" == typeof arguments[t] ? arguments[t](this.prototype) : this.prototype.extend(arguments[t]);
        return this
    }, toString: function () {
        return String(this.valueOf())
    }
}), function (t) {
    "use strict";
    (FlipClock = function (t, i, e) {
        return i instanceof Object && i instanceof Date == !1 && (e = i, i = 0), new FlipClock.Factory(t, i, e)
    }).Lang = {}, FlipClock.Base = Base.extend({
        buildDate: "2014-12-12",
        version: "0.7.7",
        constructor: function (i, e) {
            "object" != typeof i && (i = {}), "object" != typeof e && (e = {}), this.setOptions(t.extend(!0, {}, i, e))
        },
        callback: function (t) {
            if ("function" == typeof t) {
                for (var i = [], e = 1; e <= arguments.length; e++) arguments[e] && i.push(arguments[e]);
                t.apply(this, i)
            }
        },
        log: function (t) {
            window.console && console.log && console.log(t)
        },
        getOption: function (t) {
            return !!this[t] && this[t]
        },
        getOptions: function () {
            return this
        },
        setOption: function (t, i) {
            this[t] = i
        },
        setOptions: function (t) {
            for (var i in t) void 0 !== t[i] && this.setOption(i, t[i])
        }
    })
}(jQuery), function (t) {
    "use strict";
    FlipClock.Face = FlipClock.Base.extend({
        autoStart: !0, dividers: [], factory: !1, lists: [], constructor: function (t, i) {
            this.dividers = [], this.lists = [], this.base(i), this.factory = t
        }, build: function () {
            this.autoStart && this.start()
        }, createDivider: function (i, e, s) {
            "boolean" != typeof e && e || (s = e, e = i);
            var n = ['<span class="' + this.factory.classes.dot + ' top"></span>', '<span class="' + this.factory.classes.dot + ' bottom"></span>'].join("");
            s && (n = ""), i = this.factory.localize(i);
            var o = ['<span class="' + this.factory.classes.divider + " " + (e || "").toLowerCase() + '">', '<span class="' + this.factory.classes.label + '">' + (i || "") + "</span>", n, "</span>"],
                a = t(o.join(""));
            return this.dividers.push(a), a
        }, createList: function (t, i) {
            "object" == typeof t && (i = t, t = 0);
            var e = new FlipClock.List(this.factory, t, i);
            return this.lists.push(e), e
        }, reset: function () {
            this.factory.time = new FlipClock.Time(this.factory, this.factory.original ? Math.round(this.factory.original) : 0, {minimumDigits: this.factory.minimumDigits}), this.flip(this.factory.original, !1)
        }, appendDigitToClock: function (t) {
            t.$el.append(!1)
        }, addDigit: function (t) {
            var i = this.createList(t, {
                classes: {
                    active: this.factory.classes.active,
                    before: this.factory.classes.before,
                    flip: this.factory.classes.flip
                }
            });
            this.appendDigitToClock(i)
        }, start: function () {
        }, stop: function () {
        }, autoIncrement: function () {
            this.factory.countdown ? this.decrement() : this.increment()
        }, increment: function () {
            this.factory.time.addSecond()
        }, decrement: function () {
            0 == this.factory.time.getTimeSeconds() ? this.factory.stop() : this.factory.time.subSecond()
        }, flip: function (i, e) {
            var s = this;
            t.each(i, function (t, i) {
                var n = s.lists[t];
                n ? (e || i == n.digit || n.play(), n.select(i)) : s.addDigit(i)
            })
        }
    })
}(jQuery), function (t) {
    "use strict";
    FlipClock.Factory = FlipClock.Base.extend({
        animationRate: 1e3,
        autoStart: !0,
        callbacks: {destroy: !1, create: !1, init: !1, interval: !1, start: !1, stop: !1, reset: !1},
        classes: {
            active: "flip-clock-active",
            before: "flip-clock-before",
            divider: "flip-clock-divider",
            dot: "flip-clock-dot",
            label: "flip-clock-label",
            flip: "flip",
            play: "play",
            wrapper: "flip-clock-wrapper"
        },
        clockFace: "HourlyCounter",
        countdown: !1,
        defaultClockFace: "HourlyCounter",
        defaultLanguage: "english",
        $el: !1,
        face: !0,
        lang: !1,
        language: "english",
        minimumDigits: 0,
        original: !1,
        running: !1,
        time: !1,
        timer: !1,
        $wrapper: !1,
        constructor: function (i, e, s) {
            s || (s = {}), this.lists = [], this.running = !1, this.base(s), this.$el = t(i).addClass(this.classes.wrapper), this.$wrapper = this.$el, this.original = e instanceof Date ? e : e ? Math.round(e) : 0, this.time = new FlipClock.Time(this, this.original, {
                minimumDigits: this.minimumDigits,
                animationRate: this.animationRate
            }), this.timer = new FlipClock.Timer(this, s), this.loadLanguage(this.language), this.loadClockFace(this.clockFace, s), this.autoStart && this.start()
        },
        loadClockFace: function (t, i) {
            var e, s = !1;
            return t = t.ucfirst() + "Face", this.face.stop && (this.stop(), s = !0), this.$el.html(""), this.time.minimumDigits = this.minimumDigits, (e = FlipClock[t] ? new FlipClock[t](this, i) : new FlipClock[this.defaultClockFace + "Face"](this, i)).build(), this.face = e, s && this.start(), this.face
        },
        loadLanguage: function (t) {
            var i;
            return i = FlipClock.Lang[t.ucfirst()] ? FlipClock.Lang[t.ucfirst()] : FlipClock.Lang[t] ? FlipClock.Lang[t] : FlipClock.Lang[this.defaultLanguage], this.lang = i
        },
        localize: function (t, i) {
            var e = this.lang;
            if (!t) return null;
            var s = t.toLowerCase();
            return "object" == typeof i && (e = i), e && e[s] ? e[s] : t
        },
        start: function (t) {
            var i = this;
            i.running || i.countdown && !(i.countdown && i.time.time > 0) ? i.log("Trying to start timer when countdown already at 0") : (i.face.start(i.time), i.timer.start(function () {
                i.flip(), "function" == typeof t && t()
            }))
        },
        stop: function (t) {
            for (var i in this.face.stop(), this.timer.stop(t), this.lists) this.lists.hasOwnProperty(i) && this.lists[i].stop()
        },
        reset: function (t) {
            this.timer.reset(t), this.face.reset()
        },
        setTime: function (t) {
            this.time.time = t, this.flip(!0)
        },
        getTime: function (t) {
            return this.time
        },
        setCountdown: function (t) {
            var i = this.running;
            this.countdown = !!t, i && (this.stop(), this.start())
        },
        flip: function (t) {
            this.face.flip(!1, t)
        }
    })
}(jQuery), function (t) {
    "use strict";
    FlipClock.List = FlipClock.Base.extend({
        digit: 0,
        classes: {active: "flip-clock-active", before: "flip-clock-before", flip: "flip"},
        factory: !1,
        $el: !1,
        $obj: !1,
        items: [],
        lastDigit: 0,
        constructor: function (t, i, e) {
            this.factory = t, this.digit = i, this.lastDigit = i, this.$el = this.createList(), this.$obj = this.$el, i > 0 && this.select(i), this.factory.$el.append(this.$el)
        },
        select: function (t) {
            if (void 0 === t ? t = this.digit : this.digit = t, this.digit != this.lastDigit) {
                var i = this.$el.find("." + this.classes.before).removeClass(this.classes.before);
                this.$el.find("." + this.classes.active).removeClass(this.classes.active).addClass(this.classes.before), this.appendListItem(this.classes.active, this.digit), i.remove(), this.lastDigit = this.digit
            }
        },
        play: function () {
            this.$el.addClass(this.factory.classes.play)
        },
        stop: function () {
            var t = this;
            setTimeout(function () {
                t.$el.removeClass(t.factory.classes.play)
            }, this.factory.timer.interval)
        },
        createListItem: function (t, i) {
            return ['<li class="' + (t || "") + '">', '<a href="#">', '<div class="up">', '<div class="shadow"></div>', '<div class="inn">' + (i || "") + "</div>", "</div>", '<div class="down">', '<div class="shadow"></div>', '<div class="inn">' + (i || "") + "</div>", "</div>", "</a>", "</li>"].join("")
        },
        appendListItem: function (t, i) {
            var e = this.createListItem(t, i);
            this.$el.append(e)
        },
        createList: function () {
            var i = this.getPrevDigit() ? this.getPrevDigit() : this.digit;
            return t(['<ul class="' + this.classes.flip + " " + (this.factory.running ? this.factory.classes.play : "") + '">', this.createListItem(this.classes.before, i), this.createListItem(this.classes.active, this.digit), "</ul>"].join(""))
        },
        getNextDigit: function () {
            return 9 == this.digit ? 0 : this.digit + 1
        },
        getPrevDigit: function () {
            return 0 == this.digit ? 9 : this.digit - 1
        }
    })
}(jQuery), function (t) {
    "use strict";
    String.prototype.ucfirst = function () {
        return this.substr(0, 1).toUpperCase() + this.substr(1)
    }, t.fn.FlipClock = function (i, e) {
        return new FlipClock(t(this), i, e)
    }, t.fn.flipClock = function (i, e) {
        return t.fn.FlipClock(i, e)
    }
}(jQuery), function (t) {
    "use strict";
    FlipClock.Time = FlipClock.Base.extend({
        time: 0, factory: !1, minimumDigits: 0, constructor: function (t, i, e) {
            "object" != typeof e && (e = {}), e.minimumDigits || (e.minimumDigits = t.minimumDigits), this.base(e), this.factory = t, i && (this.time = i)
        }, convertDigitsToArray: function (t) {
            var i = [];
            t = t.toString();
            for (var e = 0; e < t.length; e++) t[e].match(/^\d*$/g) && i.push(t[e]);
            return i
        }, digit: function (t) {
            var i = this.toString(), e = i.length;
            return !!i[e - t] && i[e - t]
        }, digitize: function (i) {
            var e = [];
            if (t.each(i, function (t, i) {
                1 == (i = i.toString()).length && (i = "0" + i);
                for (var s = 0; s < i.length; s++) e.push(i.charAt(s))
            }), e.length > this.minimumDigits && (this.minimumDigits = e.length), this.minimumDigits > e.length) for (var s = e.length; s < this.minimumDigits; s++) e.unshift("0");
            return e
        }, getDateObject: function () {
            return this.time instanceof Date ? this.time : new Date((new Date).getTime() + 1e3 * this.getTimeSeconds())
        }, getDayCounter: function (t) {
            var i = [this.getDays(), this.getHours(!0), this.getMinutes(!0)];
            return t && i.push(this.getSeconds(!0)), this.digitize(i)
        }, getDays: function (t) {
            var i = this.getTimeSeconds() / 60 / 60 / 24;
            return t && (i %= 7), Math.floor(i)
        }, getHourCounter: function () {
            return this.digitize([this.getHours(), this.getMinutes(!0), this.getSeconds(!0)])
        }, getHourly: function () {
            return this.getHourCounter()
        }, getHours: function (t) {
            var i = this.getTimeSeconds() / 60 / 60;
            return t && (i %= 24), Math.floor(i)
        }, getMilitaryTime: function (t, i) {
            void 0 === i && (i = !0), t || (t = this.getDateObject());
            var e = [t.getHours(), t.getMinutes()];
            return !0 === i && e.push(t.getSeconds()), this.digitize(e)
        }, getMinutes: function (t) {
            var i = this.getTimeSeconds() / 60;
            return t && (i %= 60), Math.floor(i)
        }, getMinuteCounter: function () {
            return this.digitize([this.getMinutes(), this.getSeconds(!0)])
        }, getTimeSeconds: function (t) {
            return t || (t = new Date), this.time instanceof Date ? this.factory.countdown ? Math.max(this.time.getTime() / 1e3 - t.getTime() / 1e3, 0) : t.getTime() / 1e3 - this.time.getTime() / 1e3 : this.time
        }, getTime: function (t, i) {
            void 0 === i && (i = !0), t || (t = this.getDateObject()), console.log(t);
            var e = t.getHours(), s = [e > 12 ? e - 12 : 0 === e ? 12 : e, t.getMinutes()];
            return !0 === i && s.push(t.getSeconds()), this.digitize(s)
        }, getSeconds: function (t) {
            var i = this.getTimeSeconds();
            return t && (60 == i ? i = 0 : i %= 60), Math.ceil(i)
        }, getWeeks: function (t) {
            var i = this.getTimeSeconds() / 60 / 60 / 24 / 7;
            return t && (i %= 52), Math.floor(i)
        }, removeLeadingZeros: function (i, e) {
            var s = 0, n = [];
            return t.each(e, function (t, o) {
                t < i ? s += parseInt(e[t], 10) : n.push(e[t])
            }), 0 === s ? n : e
        }, addSeconds: function (t) {
            this.time instanceof Date ? this.time.setSeconds(this.time.getSeconds() + t) : this.time += t
        }, addSecond: function () {
            this.addSeconds(1)
        }, subSeconds: function (t) {
            this.time instanceof Date ? this.time.setSeconds(this.time.getSeconds() - t) : this.time -= t
        }, subSecond: function () {
            this.subSeconds(1)
        }, toString: function () {
            return this.getTimeSeconds().toString()
        }
    })
}(jQuery), function (t) {
    "use strict";
    FlipClock.Timer = FlipClock.Base.extend({
        callbacks: {destroy: !1, create: !1, init: !1, interval: !1, start: !1, stop: !1, reset: !1},
        count: 0,
        factory: !1,
        interval: 1e3,
        animationRate: 1e3,
        constructor: function (t, i) {
            this.base(i), this.factory = t, this.callback(this.callbacks.init), this.callback(this.callbacks.create)
        },
        getElapsed: function () {
            return this.count * this.interval
        },
        getElapsedTime: function () {
            return new Date(this.time + this.getElapsed())
        },
        reset: function (t) {
            clearInterval(this.timer), this.count = 0, this._setInterval(t), this.callback(this.callbacks.reset)
        },
        start: function (t) {
            this.factory.running = !0, this._createTimer(t), this.callback(this.callbacks.start)
        },
        stop: function (t) {
            this.factory.running = !1, this._clearInterval(t), this.callback(this.callbacks.stop), this.callback(t)
        },
        _clearInterval: function () {
            clearInterval(this.timer)
        },
        _createTimer: function (t) {
            this._setInterval(t)
        },
        _destroyTimer: function (t) {
            this._clearInterval(), this.timer = !1, this.callback(t), this.callback(this.callbacks.destroy)
        },
        _interval: function (t) {
            this.callback(this.callbacks.interval), this.callback(t), this.count++
        },
        _setInterval: function (t) {
            var i = this;
            i._interval(t), i.timer = setInterval(function () {
                i._interval(t)
            }, this.interval)
        }
    })
}(jQuery), function (t) {
    FlipClock.TwentyFourHourClockFace = FlipClock.Face.extend({
        constructor: function (t, i) {
            this.base(t, i)
        }, build: function (i) {
            var e = this, s = this.factory.$el.find("ul");
            this.factory.time.time || (this.factory.original = new Date, this.factory.time = new FlipClock.Time(this.factory, this.factory.original)), (i = i || this.factory.time.getMilitaryTime(!1, this.showSeconds)).length > s.length && t.each(i, function (t, i) {
                e.createList(i)
            }), this.createDivider(), this.createDivider(), t(this.dividers[0]).insertBefore(this.lists[this.lists.length - 2].$el), t(this.dividers[1]).insertBefore(this.lists[this.lists.length - 4].$el), this.base()
        }, flip: function (t, i) {
            this.autoIncrement(), t = t || this.factory.time.getMilitaryTime(!1, this.showSeconds), this.base(t, i)
        }
    })
}(jQuery), function (t) {
    FlipClock.CounterFace = FlipClock.Face.extend({
        shouldAutoIncrement: !1, constructor: function (t, i) {
            "object" != typeof i && (i = {}), t.autoStart = !!i.autoStart, i.autoStart && (this.shouldAutoIncrement = !0), t.increment = function () {
                t.countdown = !1, t.setTime(t.getTime().getTimeSeconds() + 1)
            }, t.decrement = function () {
                t.countdown = !0;
                var i = t.getTime().getTimeSeconds();
                i > 0 && t.setTime(i - 1)
            }, t.setValue = function (i) {
                t.setTime(i)
            }, t.setCounter = function (i) {
                t.setTime(i)
            }, this.base(t, i)
        }, build: function () {
            var i = this, e = this.factory.$el.find("ul"),
                s = this.factory.getTime().digitize([this.factory.getTime().time]);
            s.length > e.length && t.each(s, function (t, e) {
                i.createList(e).select(e)
            }), t.each(this.lists, function (t, i) {
                i.play()
            }), this.base()
        }, flip: function (t, i) {
            this.shouldAutoIncrement && this.autoIncrement(), t || (t = this.factory.getTime().digitize([this.factory.getTime().time])), this.base(t, i)
        }, reset: function () {
            this.factory.time = new FlipClock.Time(this.factory, this.factory.original ? Math.round(this.factory.original) : 0), this.flip()
        }
    })
}(jQuery), function (t) {
    FlipClock.DailyCounterFace = FlipClock.Face.extend({
        showSeconds: !0, constructor: function (t, i) {
            this.base(t, i)
        }, build: function (i) {
            var e = this, s = this.factory.$el.find("ul"), n = 0;
            (i = i || this.factory.time.getDayCounter(this.showSeconds)).length > s.length && t.each(i, function (t, i) {
                e.createList(i)
            }), this.showSeconds ? t(this.createDivider("Seconds")).insertBefore(this.lists[this.lists.length - 2].$el) : n = 2, t(this.createDivider("Minutes")).insertBefore(this.lists[this.lists.length - 4 + n].$el), t(this.createDivider("Hours")).insertBefore(this.lists[this.lists.length - 6 + n].$el), t(this.createDivider("Days", !0)).insertBefore(this.lists[0].$el), this.base()
        }, flip: function (t, i) {
            t || (t = this.factory.time.getDayCounter(this.showSeconds)), this.autoIncrement(), this.base(t, i)
        }
    })
}(jQuery), function (t) {
    FlipClock.HourlyCounterFace = FlipClock.Face.extend({
        constructor: function (t, i) {
            this.base(t, i)
        }, build: function (i, e) {
            var s = this, n = this.factory.$el.find("ul");
            (e = e || this.factory.time.getHourCounter()).length > n.length && t.each(e, function (t, i) {
                s.createList(i)
            }), t(this.createDivider("Seconds")).insertBefore(this.lists[this.lists.length - 2].$el), t(this.createDivider("Minutes")).insertBefore(this.lists[this.lists.length - 4].$el), i || t(this.createDivider("Hours", !0)).insertBefore(this.lists[0].$el), this.base()
        }, flip: function (t, i) {
            t || (t = this.factory.time.getHourCounter()), this.autoIncrement(), this.base(t, i)
        }, appendDigitToClock: function (t) {
            this.base(t), this.dividers[0].insertAfter(this.dividers[0].next())
        }
    })
}(jQuery), jQuery, FlipClock.MinuteCounterFace = FlipClock.HourlyCounterFace.extend({
    clearExcessDigits: !1,
    constructor: function (t, i) {
        this.base(t, i)
    },
    build: function () {
        this.base(!0, this.factory.time.getMinuteCounter())
    },
    flip: function (t, i) {
        t || (t = this.factory.time.getMinuteCounter()), this.base(t, i)
    }
}), function (t) {
    FlipClock.TwelveHourClockFace = FlipClock.TwentyFourHourClockFace.extend({
        meridium: !1,
        meridiumText: "AM",
        build: function () {
            var i = this.factory.time.getTime(!1, this.showSeconds);
            this.base(i), this.meridiumText = this.getMeridium(), this.meridium = t(['<ul class="flip-clock-meridium">', "<li>", '<a href="#">' + this.meridiumText + "</a>", "</li>", "</ul>"].join("")), this.meridium.insertAfter(this.lists[this.lists.length - 1].$el)
        },
        flip: function (t, i) {
            this.meridiumText != this.getMeridium() && (this.meridiumText = this.getMeridium(), this.meridium.find("a").html(this.meridiumText)), this.base(this.factory.time.getTime(!1, this.showSeconds), i)
        },
        getMeridium: function () {
            return (new Date).getHours() >= 12 ? "PM" : "AM"
        },
        isPM: function () {
            return "PM" == this.getMeridium()
        },
        isAM: function () {
            return "AM" == this.getMeridium()
        }
    })
}(jQuery), jQuery, FlipClock.Lang.Arabic = {
    years: "سنوات",
    months: "شهور",
    days: "أيام",
    hours: "ساعات",
    minutes: "دقائق",
    seconds: "ثواني"
}, FlipClock.Lang.ar = FlipClock.Lang.Arabic, FlipClock.Lang["ar-ar"] = FlipClock.Lang.Arabic, FlipClock.Lang.arabic = FlipClock.Lang.Arabic, jQuery, FlipClock.Lang.Persian = {
    years: "سال",
    months: "ماه",
    days: "روز",
    hours: "ساعت",
    minutes: "دقیقه",
    seconds: "ثانیه"
}, FlipClock.Lang.fa = FlipClock.Lang.Persian, FlipClock.Lang["fa-fa"] = FlipClock.Lang.Persian, FlipClock.Lang.persian = FlipClock.Lang.Persian, jQuery, FlipClock.Lang.Danish = {
    years: "År",
    months: "Måneder",
    days: "Dage",
    hours: "Timer",
    minutes: "Minutter",
    seconds: "Sekunder"
}, FlipClock.Lang.da = FlipClock.Lang.Danish, FlipClock.Lang["da-dk"] = FlipClock.Lang.Danish, FlipClock.Lang.danish = FlipClock.Lang.Danish, jQuery, FlipClock.Lang.German = {
    years: "Jahre",
    months: "Monate",
    days: "Tage",
    hours: "Stunden",
    minutes: "Minuten",
    seconds: "Sekunden"
}, FlipClock.Lang.de = FlipClock.Lang.German, FlipClock.Lang["de-de"] = FlipClock.Lang.German, FlipClock.Lang.german = FlipClock.Lang.German, jQuery, FlipClock.Lang.English = {
    years: "Years",
    months: "Months",
    days: "Days",
    hours: "Hours",
    minutes: "Minutes",
    seconds: "Seconds"
}, FlipClock.Lang.en = FlipClock.Lang.English, FlipClock.Lang["en-us"] = FlipClock.Lang.English, FlipClock.Lang.english = FlipClock.Lang.English, jQuery, FlipClock.Lang.Spanish = {
    years: "Años",
    months: "Meses",
    days: "Días",
    hours: "Horas",
    minutes: "Minutos",
    seconds: "Segundos"
}, FlipClock.Lang.es = FlipClock.Lang.Spanish, FlipClock.Lang["es-es"] = FlipClock.Lang.Spanish, FlipClock.Lang.spanish = FlipClock.Lang.Spanish, jQuery, FlipClock.Lang.Finnish = {
    years: "Vuotta",
    months: "Kuukautta",
    days: "Päivää",
    hours: "Tuntia",
    minutes: "Minuuttia",
    seconds: "Sekuntia"
}, FlipClock.Lang.fi = FlipClock.Lang.Finnish, FlipClock.Lang["fi-fi"] = FlipClock.Lang.Finnish, FlipClock.Lang.finnish = FlipClock.Lang.Finnish, jQuery, FlipClock.Lang.French = {
    years: "Ans",
    months: "Mois",
    days: "Jours",
    hours: "Heures",
    minutes: "Minutes",
    seconds: "Secondes"
}, FlipClock.Lang.fr = FlipClock.Lang.French, FlipClock.Lang["fr-ca"] = FlipClock.Lang.French, FlipClock.Lang.french = FlipClock.Lang.French, jQuery, FlipClock.Lang.Italian = {
    years: "Anni",
    months: "Mesi",
    days: "Giorni",
    hours: "Ore",
    minutes: "Minuti",
    seconds: "Secondi"
}, FlipClock.Lang.it = FlipClock.Lang.Italian, FlipClock.Lang["it-it"] = FlipClock.Lang.Italian, FlipClock.Lang.italian = FlipClock.Lang.Italian, jQuery, FlipClock.Lang.Latvian = {
    years: "Gadi",
    months: "Mēneši",
    days: "Dienas",
    hours: "Stundas",
    minutes: "Minūtes",
    seconds: "Sekundes"
}, FlipClock.Lang.lv = FlipClock.Lang.Latvian, FlipClock.Lang["lv-lv"] = FlipClock.Lang.Latvian, FlipClock.Lang.latvian = FlipClock.Lang.Latvian, jQuery, FlipClock.Lang.Dutch = {
    years: "Jaren",
    months: "Maanden",
    days: "Dagen",
    hours: "Uren",
    minutes: "Minuten",
    seconds: "Seconden"
}, FlipClock.Lang.nl = FlipClock.Lang.Dutch, FlipClock.Lang["nl-be"] = FlipClock.Lang.Dutch, FlipClock.Lang.dutch = FlipClock.Lang.Dutch, jQuery, FlipClock.Lang.Norwegian = {
    years: "År",
    months: "Måneder",
    days: "Dager",
    hours: "Timer",
    minutes: "Minutter",
    seconds: "Sekunder"
}, FlipClock.Lang.no = FlipClock.Lang.Norwegian, FlipClock.Lang.nb = FlipClock.Lang.Norwegian, FlipClock.Lang["no-nb"] = FlipClock.Lang.Norwegian, FlipClock.Lang.norwegian = FlipClock.Lang.Norwegian, jQuery, FlipClock.Lang.Portuguese = {
    years: "Anos",
    months: "Meses",
    days: "Dias",
    hours: "Horas",
    minutes: "Minutos",
    seconds: "Segundos"
}, FlipClock.Lang.pt = FlipClock.Lang.Portuguese, FlipClock.Lang["pt-br"] = FlipClock.Lang.Portuguese, FlipClock.Lang.portuguese = FlipClock.Lang.Portuguese, jQuery, FlipClock.Lang.Russian = {
    years: "лет",
    months: "месяцев",
    days: "дней",
    hours: "часов",
    minutes: "минут",
    seconds: "секунд"
}, FlipClock.Lang.ru = FlipClock.Lang.Russian, FlipClock.Lang["ru-ru"] = FlipClock.Lang.Russian, FlipClock.Lang.russian = FlipClock.Lang.Russian, jQuery, FlipClock.Lang.Swedish = {
    years: "År",
    months: "Månader",
    days: "Dagar",
    hours: "Timmar",
    minutes: "Minuter",
    seconds: "Sekunder"
}, FlipClock.Lang.sv = FlipClock.Lang.Swedish, FlipClock.Lang["sv-se"] = FlipClock.Lang.Swedish, FlipClock.Lang.swedish = FlipClock.Lang.Swedish, jQuery, FlipClock.Lang.Chinese = {
    years: "年",
    months: "月",
    days: "日",
    hours: "时",
    minutes: "分",
    seconds: "秒"
}, FlipClock.Lang.zh = FlipClock.Lang.Chinese, FlipClock.Lang["zh-cn"] = FlipClock.Lang.Chinese, FlipClock.Lang.chinese = FlipClock.Lang.Chinese;
!function (e, n, o) {
    var t = e();
    e.fn.dropdownHover = function (o) {
        return "ontouchstart" in document ? this : (t = t.add(this.parent()), this.each(function () {
            var r, a, i = e(this), d = i.parent(), s = {
                    delay: e(this).data("delay"),
                    hoverDelay: e(this).data("hover-delay"),
                    instantlyCloseOthers: e(this).data("close-others")
                }, u = "show.bs.dropdown",
                l = e.extend(!0, {}, {delay: 500, hoverDelay: 0, instantlyCloseOthers: !0}, o, s);

            function h(e) {
                i.parents(".navbar").find(".navbar-toggle").is(":visible") || (n.clearTimeout(r), n.clearTimeout(a), a = n.setTimeout(function () {
                    t.find(":focus").blur(), !0 === l.instantlyCloseOthers && t.removeClass("open"), n.clearTimeout(a), i.attr("aria-expanded", "true"), d.addClass("open"), i.trigger(u)
                }, l.hoverDelay))
            }

            d.hover(function (e) {
                if (!d.hasClass("open") && !i.is(e.target)) return !0;
                h(e)
            }, function () {
                n.clearTimeout(a), r = n.setTimeout(function () {
                    i.attr("aria-expanded", "false"), d.removeClass("open"), i.trigger("hide.bs.dropdown")
                }, l.delay)
            }), i.hover(function (e) {
                if (!d.hasClass("open") && !d.is(e.target)) return !0;
                h(e)
            }), d.find(".dropdown-submenu").each(function () {
                var o, t = e(this);
                t.hover(function () {
                    n.clearTimeout(o), t.children(".dropdown-menu").show(), t.siblings().children(".dropdown-menu").hide()
                }, function () {
                    var e = t.children(".dropdown-menu");
                    o = n.setTimeout(function () {
                        e.hide()
                    }, l.delay)
                })
            })
        }))
    }, e(document).ready(function () {
        e('[data-hover="dropdown"]').dropdownHover()
    })
}(jQuery, window);
/**
 * Single Page Nav Plugin
 * Copyright (c) 2014 Chris Wojcik <hello@chriswojcik.net>
 * Dual licensed under MIT and GPL.
 * @author Chris Wojcik
 * @version 1.2.0
 */
if (typeof Object.create !== "function") {
    Object.create = function (e) {
        function t() {
        }

        t.prototype = e;
        return new t
    }
}
(function (e, t, n, r) {
    "use strict";
    var i = {
        init: function (n, r) {
            this.options = e.extend({}, e.fn.singlePageNav.defaults, n);
            this.container = r;
            this.$container = e(r);
            this.$links = this.$container.find("a");
            if (this.options.filter !== "") {
                this.$links = this.$links.filter(this.options.filter)
            }
            this.$window = e(t);
            this.$htmlbody = e("html, body");
            this.$links.on("click.singlePageNav", e.proxy(this.handleClick, this));
            this.didScroll = false;
            this.checkPosition();
            this.setTimer()
        }, handleClick: function (t) {
            var n = this, r = t.currentTarget, i = e(r.hash);
            t.preventDefault();
            if (i.length) {
                n.clearTimer();
                if (typeof n.options.beforeStart === "function") {
                    n.options.beforeStart()
                }
                n.setActiveLink(r.hash);
                n.scrollTo(i, function () {
                    if (n.options.updateHash && history.pushState) {
                        history.pushState(null, null, r.hash)
                    }
                    n.setTimer();
                    if (typeof n.options.onComplete === "function") {
                        n.options.onComplete()
                    }
                })
            }
        }, scrollTo: function (e, t) {
            var n = this;
            var r = n.getCoords(e).top;
            var i = false;
            n.$htmlbody.stop().animate({scrollTop: r}, {
                duration: n.options.speed,
                easing: n.options.easing,
                complete: function () {
                    if (typeof t === "function" && !i) {
                        t()
                    }
                    i = true
                }
            })
        }, setTimer: function () {
            var e = this;
            e.$window.on("scroll.singlePageNav", function () {
                e.didScroll = true
            });
            e.timer = setInterval(function () {
                if (e.didScroll) {
                    e.didScroll = false;
                    e.checkPosition()
                }
            }, 250)
        }, clearTimer: function () {
            clearInterval(this.timer);
            this.$window.off("scroll.singlePageNav");
            this.didScroll = false
        }, checkPosition: function () {
            var e = this.$window.scrollTop();
            var t = this.getCurrentSection(e);
            this.setActiveLink(t)
        }, getCoords: function (e) {
            return {top: Math.round(e.offset().top) - this.options.offset}
        }, setActiveLink: function (e) {
            var t = this.$container.find("a[href$='" + e + "']");
            if (!t.hasClass(this.options.currentClass)) {
                this.$links.removeClass(this.options.currentClass);
                t.addClass(this.options.currentClass)
            }
        }, getCurrentSection: function (t) {
            var n, r, i, s;
            for (n = 0; n < this.$links.length; n++) {
                r = this.$links[n].hash;
                if (e(r).length) {
                    i = this.getCoords(e(r));
                    if (t >= i.top - this.options.threshold) {
                        s = r
                    }
                }
            }
            return s || this.$links[0].hash
        }
    };
    e.fn.singlePageNav = function (e) {
        return this.each(function () {
            var t = Object.create(i);
            t.init(e, this)
        })
    };
    e.fn.singlePageNav.defaults = {
        offset: 0,
        threshold: 120,
        speed: 400,
        currentClass: "current",
        easing: "swing",
        updateHash: false,
        filter: "",
        onComplete: false,
        beforeStart: false
    }
})(jQuery, window, document)
/*!
 * Bootstrap v3.3.1 (http://getbootstrap.com)
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
if ("undefined" == typeof jQuery) throw new Error("Bootstrap's JavaScript requires jQuery");
+function (a) {
    var b = a.fn.jquery.split(" ")[0].split(".");
    if (b[0] < 2 && b[1] < 9 || 1 == b[0] && 9 == b[1] && b[2] < 1) throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")
}(jQuery), +function (a) {
    "use strict";

    function b() {
        var a = document.createElement("bootstrap"), b = {
            WebkitTransition: "webkitTransitionEnd",
            MozTransition: "transitionend",
            OTransition: "oTransitionEnd otransitionend",
            transition: "transitionend"
        };
        for (var c in b) if (void 0 !== a.style[c]) return {end: b[c]};
        return !1
    }

    a.fn.emulateTransitionEnd = function (b) {
        var c = !1, d = this;
        a(this).one("bsTransitionEnd", function () {
            c = !0
        });
        var e = function () {
            c || a(d).trigger(a.support.transition.end)
        };
        return setTimeout(e, b), this
    }, a(function () {
        a.support.transition = b(), a.support.transition && (a.event.special.bsTransitionEnd = {
            bindType: a.support.transition.end,
            delegateType: a.support.transition.end,
            handle: function (b) {
                return a(b.target).is(this) ? b.handleObj.handler.apply(this, arguments) : void 0
            }
        })
    })
}(jQuery), +function (a) {
    "use strict";

    function b(b) {
        return this.each(function () {
            var c = a(this), e = c.data("bs.alert");
            e || c.data("bs.alert", e = new d(this)), "string" == typeof b && e[b].call(c)
        })
    }

    var c = '[data-dismiss="alert"]', d = function (b) {
        a(b).on("click", c, this.close)
    };
    d.VERSION = "3.3.1", d.TRANSITION_DURATION = 150, d.prototype.close = function (b) {
        function c() {
            g.detach().trigger("closed.bs.alert").remove()
        }

        var e = a(this), f = e.attr("data-target");
        f || (f = e.attr("href"), f = f && f.replace(/.*(?=#[^\s]*$)/, ""));
        var g = a(f);
        b && b.preventDefault(), g.length || (g = e.closest(".alert")), g.trigger(b = a.Event("close.bs.alert")), b.isDefaultPrevented() || (g.removeClass("in"), a.support.transition && g.hasClass("fade") ? g.one("bsTransitionEnd", c).emulateTransitionEnd(d.TRANSITION_DURATION) : c())
    };
    var e = a.fn.alert;
    a.fn.alert = b, a.fn.alert.Constructor = d, a.fn.alert.noConflict = function () {
        return a.fn.alert = e, this
    }, a(document).on("click.bs.alert.data-api", c, d.prototype.close)
}(jQuery), +function (a) {
    "use strict";

    function b(b) {
        return this.each(function () {
            var d = a(this), e = d.data("bs.button"), f = "object" == typeof b && b;
            e || d.data("bs.button", e = new c(this, f)), "toggle" == b ? e.toggle() : b && e.setState(b)
        })
    }

    var c = function (b, d) {
        this.$element = a(b), this.options = a.extend({}, c.DEFAULTS, d), this.isLoading = !1
    };
    c.VERSION = "3.3.1", c.DEFAULTS = {loadingText: "loading..."}, c.prototype.setState = function (b) {
        var c = "disabled", d = this.$element, e = d.is("input") ? "val" : "html", f = d.data();
        b += "Text", null == f.resetText && d.data("resetText", d[e]()), setTimeout(a.proxy(function () {
            d[e](null == f[b] ? this.options[b] : f[b]), "loadingText" == b ? (this.isLoading = !0, d.addClass(c).attr(c, c)) : this.isLoading && (this.isLoading = !1, d.removeClass(c).removeAttr(c))
        }, this), 0)
    }, c.prototype.toggle = function () {
        var a = !0, b = this.$element.closest('[data-toggle="buttons"]');
        if (b.length) {
            var c = this.$element.find("input");
            "radio" == c.prop("type") && (c.prop("checked") && this.$element.hasClass("active") ? a = !1 : b.find(".active").removeClass("active")), a && c.prop("checked", !this.$element.hasClass("active")).trigger("change")
        } else this.$element.attr("aria-pressed", !this.$element.hasClass("active"));
        a && this.$element.toggleClass("active")
    };
    var d = a.fn.button;
    a.fn.button = b, a.fn.button.Constructor = c, a.fn.button.noConflict = function () {
        return a.fn.button = d, this
    }, a(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function (c) {
        var d = a(c.target);
        d.hasClass("btn") || (d = d.closest(".btn")), b.call(d, "toggle"), c.preventDefault()
    }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function (b) {
        a(b.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(b.type))
    })
}(jQuery), +function (a) {
    "use strict";

    function b(b) {
        return this.each(function () {
            var d = a(this), e = d.data("bs.carousel"),
                f = a.extend({}, c.DEFAULTS, d.data(), "object" == typeof b && b),
                g = "string" == typeof b ? b : f.slide;
            e || d.data("bs.carousel", e = new c(this, f)), "number" == typeof b ? e.to(b) : g ? e[g]() : f.interval && e.pause().cycle()
        })
    }

    var c = function (b, c) {
        this.$element = a(b), this.$indicators = this.$element.find(".carousel-indicators"), this.options = c, this.paused = this.sliding = this.interval = this.$active = this.$items = null, this.options.keyboard && this.$element.on("keydown.bs.carousel", a.proxy(this.keydown, this)), "hover" == this.options.pause && !("ontouchstart" in document.documentElement) && this.$element.on("mouseenter.bs.carousel", a.proxy(this.pause, this)).on("mouseleave.bs.carousel", a.proxy(this.cycle, this))
    };
    c.VERSION = "3.3.1", c.TRANSITION_DURATION = 600, c.DEFAULTS = {
        interval: 5e3,
        pause: "hover",
        wrap: !0,
        keyboard: !0
    }, c.prototype.keydown = function (a) {
        if (!/input|textarea/i.test(a.target.tagName)) {
            switch (a.which) {
                case 37:
                    this.prev();
                    break;
                case 39:
                    this.next();
                    break;
                default:
                    return
            }
            a.preventDefault()
        }
    }, c.prototype.cycle = function (b) {
        return b || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(a.proxy(this.next, this), this.options.interval)), this
    }, c.prototype.getItemIndex = function (a) {
        return this.$items = a.parent().children(".item"), this.$items.index(a || this.$active)
    }, c.prototype.getItemForDirection = function (a, b) {
        var c = "prev" == a ? -1 : 1, d = this.getItemIndex(b), e = (d + c) % this.$items.length;
        return this.$items.eq(e)
    }, c.prototype.to = function (a) {
        var b = this, c = this.getItemIndex(this.$active = this.$element.find(".item.active"));
        return a > this.$items.length - 1 || 0 > a ? void 0 : this.sliding ? this.$element.one("slid.bs.carousel", function () {
            b.to(a)
        }) : c == a ? this.pause().cycle() : this.slide(a > c ? "next" : "prev", this.$items.eq(a))
    }, c.prototype.pause = function (b) {
        return b || (this.paused = !0), this.$element.find(".next, .prev").length && a.support.transition && (this.$element.trigger(a.support.transition.end), this.cycle(!0)), this.interval = clearInterval(this.interval), this
    }, c.prototype.next = function () {
        return this.sliding ? void 0 : this.slide("next")
    }, c.prototype.prev = function () {
        return this.sliding ? void 0 : this.slide("prev")
    }, c.prototype.slide = function (b, d) {
        var e = this.$element.find(".item.active"), f = d || this.getItemForDirection(b, e), g = this.interval,
            h = "next" == b ? "left" : "right", i = "next" == b ? "first" : "last", j = this;
        if (!f.length) {
            if (!this.options.wrap) return;
            f = this.$element.find(".item")[i]()
        }
        if (f.hasClass("active")) return this.sliding = !1;
        var k = f[0], l = a.Event("slide.bs.carousel", {relatedTarget: k, direction: h});
        if (this.$element.trigger(l), !l.isDefaultPrevented()) {
            if (this.sliding = !0, g && this.pause(), this.$indicators.length) {
                this.$indicators.find(".active").removeClass("active");
                var m = a(this.$indicators.children()[this.getItemIndex(f)]);
                m && m.addClass("active")
            }
            var n = a.Event("slid.bs.carousel", {relatedTarget: k, direction: h});
            return a.support.transition && this.$element.hasClass("slide") ? (f.addClass(b), f[0].offsetWidth, e.addClass(h), f.addClass(h), e.one("bsTransitionEnd", function () {
                f.removeClass([b, h].join(" ")).addClass("active"), e.removeClass(["active", h].join(" ")), j.sliding = !1, setTimeout(function () {
                    j.$element.trigger(n)
                }, 0)
            }).emulateTransitionEnd(c.TRANSITION_DURATION)) : (e.removeClass("active"), f.addClass("active"), this.sliding = !1, this.$element.trigger(n)), g && this.cycle(), this
        }
    };
    var d = a.fn.carousel;
    a.fn.carousel = b, a.fn.carousel.Constructor = c, a.fn.carousel.noConflict = function () {
        return a.fn.carousel = d, this
    };
    var e = function (c) {
        var d, e = a(this), f = a(e.attr("data-target") || (d = e.attr("href")) && d.replace(/.*(?=#[^\s]+$)/, ""));
        if (f.hasClass("carousel")) {
            var g = a.extend({}, f.data(), e.data()), h = e.attr("data-slide-to");
            h && (g.interval = !1), b.call(f, g), h && f.data("bs.carousel").to(h), c.preventDefault()
        }
    };
    a(document).on("click.bs.carousel.data-api", "[data-slide]", e).on("click.bs.carousel.data-api", "[data-slide-to]", e), a(window).on("load", function () {
        a('[data-ride="carousel"]').each(function () {
            var c = a(this);
            b.call(c, c.data())
        })
    })
}(jQuery), +function (a) {
    "use strict";

    function b(b) {
        var c, d = b.attr("data-target") || (c = b.attr("href")) && c.replace(/.*(?=#[^\s]+$)/, "");
        return a(d)
    }

    function c(b) {
        return this.each(function () {
            var c = a(this), e = c.data("bs.collapse"),
                f = a.extend({}, d.DEFAULTS, c.data(), "object" == typeof b && b);
            !e && f.toggle && "show" == b && (f.toggle = !1), e || c.data("bs.collapse", e = new d(this, f)), "string" == typeof b && e[b]()
        })
    }

    var d = function (b, c) {
        this.$element = a(b), this.options = a.extend({}, d.DEFAULTS, c), this.$trigger = a(this.options.trigger).filter('[href="#' + b.id + '"], [data-target="#' + b.id + '"]'), this.transitioning = null, this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger), this.options.toggle && this.toggle()
    };
    d.VERSION = "3.3.1", d.TRANSITION_DURATION = 350, d.DEFAULTS = {
        toggle: !0,
        trigger: '[data-toggle="collapse"]'
    }, d.prototype.dimension = function () {
        var a = this.$element.hasClass("width");
        return a ? "width" : "height"
    }, d.prototype.show = function () {
        if (!this.transitioning && !this.$element.hasClass("in")) {
            var b, e = this.$parent && this.$parent.find("> .panel").children(".in, .collapsing");
            if (!(e && e.length && (b = e.data("bs.collapse"), b && b.transitioning))) {
                var f = a.Event("show.bs.collapse");
                if (this.$element.trigger(f), !f.isDefaultPrevented()) {
                    e && e.length && (c.call(e, "hide"), b || e.data("bs.collapse", null));
                    var g = this.dimension();
                    this.$element.removeClass("collapse").addClass("collapsing")[g](0).attr("aria-expanded", !0), this.$trigger.removeClass("collapsed").attr("aria-expanded", !0), this.transitioning = 1;
                    var h = function () {
                        this.$element.removeClass("collapsing").addClass("collapse in")[g](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse")
                    };
                    if (!a.support.transition) return h.call(this);
                    var i = a.camelCase(["scroll", g].join("-"));
                    this.$element.one("bsTransitionEnd", a.proxy(h, this)).emulateTransitionEnd(d.TRANSITION_DURATION)[g](this.$element[0][i])
                }
            }
        }
    }, d.prototype.hide = function () {
        if (!this.transitioning && this.$element.hasClass("in")) {
            var b = a.Event("hide.bs.collapse");
            if (this.$element.trigger(b), !b.isDefaultPrevented()) {
                var c = this.dimension();
                this.$element[c](this.$element[c]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1), this.$trigger.addClass("collapsed").attr("aria-expanded", !1), this.transitioning = 1;
                var e = function () {
                    this.transitioning = 0, this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")
                };
                return a.support.transition ? void this.$element[c](0).one("bsTransitionEnd", a.proxy(e, this)).emulateTransitionEnd(d.TRANSITION_DURATION) : e.call(this)
            }
        }
    }, d.prototype.toggle = function () {
        this[this.$element.hasClass("in") ? "hide" : "show"]()
    }, d.prototype.getParent = function () {
        return a(this.options.parent).find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]').each(a.proxy(function (c, d) {
            var e = a(d);
            this.addAriaAndCollapsedClass(b(e), e)
        }, this)).end()
    }, d.prototype.addAriaAndCollapsedClass = function (a, b) {
        var c = a.hasClass("in");
        a.attr("aria-expanded", c), b.toggleClass("collapsed", !c).attr("aria-expanded", c)
    };
    var e = a.fn.collapse;
    a.fn.collapse = c, a.fn.collapse.Constructor = d, a.fn.collapse.noConflict = function () {
        return a.fn.collapse = e, this
    }, a(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function (d) {
        var e = a(this);
        e.attr("data-target") || d.preventDefault();
        var f = b(e), g = f.data("bs.collapse"), h = g ? "toggle" : a.extend({}, e.data(), {trigger: this});
        c.call(f, h)
    })
}(jQuery), +function (a) {
    "use strict";

    function b(b) {
        b && 3 === b.which || (a(e).remove(), a(f).each(function () {
            var d = a(this), e = c(d), f = {relatedTarget: this};
            e.hasClass("open") && (e.trigger(b = a.Event("hide.bs.dropdown", f)), b.isDefaultPrevented() || (d.attr("aria-expanded", "false"), e.removeClass("open").trigger("hidden.bs.dropdown", f)))
        }))
    }

    function c(b) {
        var c = b.attr("data-target");
        c || (c = b.attr("href"), c = c && /#[A-Za-z]/.test(c) && c.replace(/.*(?=#[^\s]*$)/, ""));
        var d = c && a(c);
        return d && d.length ? d : b.parent()
    }

    function d(b) {
        return this.each(function () {
            var c = a(this), d = c.data("bs.dropdown");
            d || c.data("bs.dropdown", d = new g(this)), "string" == typeof b && d[b].call(c)
        })
    }

    var e = ".dropdown-backdrop", f = '[data-toggle="dropdown"]', g = function (b) {
        a(b).on("click.bs.dropdown", this.toggle)
    };
    g.VERSION = "3.3.1", g.prototype.toggle = function (d) {
        var e = a(this);
        if (!e.is(".disabled, :disabled")) {
            var f = c(e), g = f.hasClass("open");
            if (b(), !g) {
                "ontouchstart" in document.documentElement && !f.closest(".navbar-nav").length && a('<div class="dropdown-backdrop"/>').insertAfter(a(this)).on("click", b);
                var h = {relatedTarget: this};
                if (f.trigger(d = a.Event("show.bs.dropdown", h)), d.isDefaultPrevented()) return;
                e.trigger("focus").attr("aria-expanded", "true"), f.toggleClass("open").trigger("shown.bs.dropdown", h)
            }
            return !1
        }
    }, g.prototype.keydown = function (b) {
        if (/(38|40|27|32)/.test(b.which) && !/input|textarea/i.test(b.target.tagName)) {
            var d = a(this);
            if (b.preventDefault(), b.stopPropagation(), !d.is(".disabled, :disabled")) {
                var e = c(d), g = e.hasClass("open");
                if (!g && 27 != b.which || g && 27 == b.which) return 27 == b.which && e.find(f).trigger("focus"), d.trigger("click");
                var h = " li:not(.divider):visible a", i = e.find('[role="menu"]' + h + ', [role="listbox"]' + h);
                if (i.length) {
                    var j = i.index(b.target);
                    38 == b.which && j > 0 && j--, 40 == b.which && j < i.length - 1 && j++, ~j || (j = 0), i.eq(j).trigger("focus")
                }
            }
        }
    };
    var h = a.fn.dropdown;
    a.fn.dropdown = d, a.fn.dropdown.Constructor = g, a.fn.dropdown.noConflict = function () {
        return a.fn.dropdown = h, this
    }, a(document).on("click.bs.dropdown.data-api", b).on("click.bs.dropdown.data-api", ".dropdown form", function (a) {
        a.stopPropagation()
    }).on("click.bs.dropdown.data-api", f, g.prototype.toggle).on("keydown.bs.dropdown.data-api", f, g.prototype.keydown).on("keydown.bs.dropdown.data-api", '[role="menu"]', g.prototype.keydown).on("keydown.bs.dropdown.data-api", '[role="listbox"]', g.prototype.keydown)
}(jQuery), +function (a) {
    "use strict";

    function b(b, d) {
        return this.each(function () {
            var e = a(this), f = e.data("bs.modal"), g = a.extend({}, c.DEFAULTS, e.data(), "object" == typeof b && b);
            f || e.data("bs.modal", f = new c(this, g)), "string" == typeof b ? f[b](d) : g.show && f.show(d)
        })
    }

    var c = function (b, c) {
        this.options = c, this.$body = a(document.body), this.$element = a(b), this.$backdrop = this.isShown = null, this.scrollbarWidth = 0, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, a.proxy(function () {
            this.$element.trigger("loaded.bs.modal")
        }, this))
    };
    c.VERSION = "3.3.1", c.TRANSITION_DURATION = 300, c.BACKDROP_TRANSITION_DURATION = 150, c.DEFAULTS = {
        backdrop: !0,
        keyboard: !0,
        show: !0
    }, c.prototype.toggle = function (a) {
        return this.isShown ? this.hide() : this.show(a)
    }, c.prototype.show = function (b) {
        var d = this, e = a.Event("show.bs.modal", {relatedTarget: b});
        this.$element.trigger(e), this.isShown || e.isDefaultPrevented() || (this.isShown = !0, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("modal-open"), this.escape(), this.resize(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', a.proxy(this.hide, this)), this.backdrop(function () {
            var e = a.support.transition && d.$element.hasClass("fade");
            d.$element.parent().length || d.$element.appendTo(d.$body), d.$element.show().scrollTop(0), d.options.backdrop && d.adjustBackdrop(), d.adjustDialog(), e && d.$element[0].offsetWidth, d.$element.addClass("in").attr("aria-hidden", !1), d.enforceFocus();
            var f = a.Event("shown.bs.modal", {relatedTarget: b});
            e ? d.$element.find(".modal-dialog").one("bsTransitionEnd", function () {
                d.$element.trigger("focus").trigger(f)
            }).emulateTransitionEnd(c.TRANSITION_DURATION) : d.$element.trigger("focus").trigger(f)
        }))
    }, c.prototype.hide = function (b) {
        b && b.preventDefault(), b = a.Event("hide.bs.modal"), this.$element.trigger(b), this.isShown && !b.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.resize(), a(document).off("focusin.bs.modal"), this.$element.removeClass("in").attr("aria-hidden", !0).off("click.dismiss.bs.modal"), a.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", a.proxy(this.hideModal, this)).emulateTransitionEnd(c.TRANSITION_DURATION) : this.hideModal())
    }, c.prototype.enforceFocus = function () {
        a(document).off("focusin.bs.modal").on("focusin.bs.modal", a.proxy(function (a) {
            this.$element[0] === a.target || this.$element.has(a.target).length || this.$element.trigger("focus")
        }, this))
    }, c.prototype.escape = function () {
        this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", a.proxy(function (a) {
            27 == a.which && this.hide()
        }, this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal")
    }, c.prototype.resize = function () {
        this.isShown ? a(window).on("resize.bs.modal", a.proxy(this.handleUpdate, this)) : a(window).off("resize.bs.modal")
    }, c.prototype.hideModal = function () {
        var a = this;
        this.$element.hide(), this.backdrop(function () {
            a.$body.removeClass("modal-open"), a.resetAdjustments(), a.resetScrollbar(), a.$element.trigger("hidden.bs.modal")
        })
    }, c.prototype.removeBackdrop = function () {
        this.$backdrop && this.$backdrop.remove(), this.$backdrop = null
    }, c.prototype.backdrop = function (b) {
        var d = this, e = this.$element.hasClass("fade") ? "fade" : "";
        if (this.isShown && this.options.backdrop) {
            var f = a.support.transition && e;
            if (this.$backdrop = a('<div class="modal-backdrop ' + e + '" />').prependTo(this.$element).on("click.dismiss.bs.modal", a.proxy(function (a) {
                a.target === a.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus.call(this.$element[0]) : this.hide.call(this))
            }, this)), f && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !b) return;
            f ? this.$backdrop.one("bsTransitionEnd", b).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION) : b()
        } else if (!this.isShown && this.$backdrop) {
            this.$backdrop.removeClass("in");
            var g = function () {
                d.removeBackdrop(), b && b()
            };
            a.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", g).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION) : g()
        } else b && b()
    }, c.prototype.handleUpdate = function () {
        this.options.backdrop && this.adjustBackdrop(), this.adjustDialog()
    }, c.prototype.adjustBackdrop = function () {
        this.$backdrop.css("height", 0).css("height", this.$element[0].scrollHeight)
    }, c.prototype.adjustDialog = function () {
        var a = this.$element[0].scrollHeight > document.documentElement.clientHeight;
        this.$element.css({
            paddingLeft: !this.bodyIsOverflowing && a ? this.scrollbarWidth : "",
            paddingRight: this.bodyIsOverflowing && !a ? this.scrollbarWidth : ""
        })
    }, c.prototype.resetAdjustments = function () {
        this.$element.css({paddingLeft: "", paddingRight: ""})
    }, c.prototype.checkScrollbar = function () {
        this.bodyIsOverflowing = document.body.scrollHeight > document.documentElement.clientHeight, this.scrollbarWidth = this.measureScrollbar()
    }, c.prototype.setScrollbar = function () {
        var a = parseInt(this.$body.css("padding-right") || 0, 10);
        this.bodyIsOverflowing && this.$body.css("padding-right", a + this.scrollbarWidth)
    }, c.prototype.resetScrollbar = function () {
        this.$body.css("padding-right", "")
    }, c.prototype.measureScrollbar = function () {
        var a = document.createElement("div");
        a.className = "modal-scrollbar-measure", this.$body.append(a);
        var b = a.offsetWidth - a.clientWidth;
        return this.$body[0].removeChild(a), b
    };
    var d = a.fn.modal;
    a.fn.modal = b, a.fn.modal.Constructor = c, a.fn.modal.noConflict = function () {
        return a.fn.modal = d, this
    }, a(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function (c) {
        var d = a(this), e = d.attr("href"), f = a(d.attr("data-target") || e && e.replace(/.*(?=#[^\s]+$)/, "")),
            g = f.data("bs.modal") ? "toggle" : a.extend({remote: !/#/.test(e) && e}, f.data(), d.data());
        d.is("a") && c.preventDefault(), f.one("show.bs.modal", function (a) {
            a.isDefaultPrevented() || f.one("hidden.bs.modal", function () {
                d.is(":visible") && d.trigger("focus")
            })
        }), b.call(f, g, this)
    })
}(jQuery), +function (a) {
    "use strict";

    function b(b) {
        return this.each(function () {
            var d = a(this), e = d.data("bs.tooltip"), f = "object" == typeof b && b, g = f && f.selector;
            (e || "destroy" != b) && (g ? (e || d.data("bs.tooltip", e = {}), e[g] || (e[g] = new c(this, f))) : e || d.data("bs.tooltip", e = new c(this, f)), "string" == typeof b && e[b]())
        })
    }

    var c = function (a, b) {
        this.type = this.options = this.enabled = this.timeout = this.hoverState = this.$element = null, this.init("tooltip", a, b)
    };
    c.VERSION = "3.3.1", c.TRANSITION_DURATION = 150, c.DEFAULTS = {
        animation: !0,
        placement: "top",
        selector: !1,
        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: "hover focus",
        title: "",
        delay: 0,
        html: !1,
        container: !1,
        viewport: {selector: "body", padding: 0}
    }, c.prototype.init = function (b, c, d) {
        this.enabled = !0, this.type = b, this.$element = a(c), this.options = this.getOptions(d), this.$viewport = this.options.viewport && a(this.options.viewport.selector || this.options.viewport);
        for (var e = this.options.trigger.split(" "), f = e.length; f--;) {
            var g = e[f];
            if ("click" == g) this.$element.on("click." + this.type, this.options.selector, a.proxy(this.toggle, this)); else if ("manual" != g) {
                var h = "hover" == g ? "mouseenter" : "focusin", i = "hover" == g ? "mouseleave" : "focusout";
                this.$element.on(h + "." + this.type, this.options.selector, a.proxy(this.enter, this)), this.$element.on(i + "." + this.type, this.options.selector, a.proxy(this.leave, this))
            }
        }
        this.options.selector ? this._options = a.extend({}, this.options, {
            trigger: "manual",
            selector: ""
        }) : this.fixTitle()
    }, c.prototype.getDefaults = function () {
        return c.DEFAULTS
    }, c.prototype.getOptions = function (b) {
        return b = a.extend({}, this.getDefaults(), this.$element.data(), b), b.delay && "number" == typeof b.delay && (b.delay = {
            show: b.delay,
            hide: b.delay
        }), b
    }, c.prototype.getDelegateOptions = function () {
        var b = {}, c = this.getDefaults();
        return this._options && a.each(this._options, function (a, d) {
            c[a] != d && (b[a] = d)
        }), b
    }, c.prototype.enter = function (b) {
        var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);
        return c && c.$tip && c.$tip.is(":visible") ? void (c.hoverState = "in") : (c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c)), clearTimeout(c.timeout), c.hoverState = "in", c.options.delay && c.options.delay.show ? void (c.timeout = setTimeout(function () {
            "in" == c.hoverState && c.show()
        }, c.options.delay.show)) : c.show())
    }, c.prototype.leave = function (b) {
        var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);
        return c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c)), clearTimeout(c.timeout), c.hoverState = "out", c.options.delay && c.options.delay.hide ? void (c.timeout = setTimeout(function () {
            "out" == c.hoverState && c.hide()
        }, c.options.delay.hide)) : c.hide()
    }, c.prototype.show = function () {
        var b = a.Event("show.bs." + this.type);
        if (this.hasContent() && this.enabled) {
            this.$element.trigger(b);
            var d = a.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
            if (b.isDefaultPrevented() || !d) return;
            var e = this, f = this.tip(), g = this.getUID(this.type);
            this.setContent(), f.attr("id", g), this.$element.attr("aria-describedby", g), this.options.animation && f.addClass("fade");
            var h = "function" == typeof this.options.placement ? this.options.placement.call(this, f[0], this.$element[0]) : this.options.placement,
                i = /\s?auto?\s?/i, j = i.test(h);
            j && (h = h.replace(i, "") || "top"), f.detach().css({
                top: 0,
                left: 0,
                display: "block"
            }).addClass(h).data("bs." + this.type, this), this.options.container ? f.appendTo(this.options.container) : f.insertAfter(this.$element);
            var k = this.getPosition(), l = f[0].offsetWidth, m = f[0].offsetHeight;
            if (j) {
                var n = h, o = this.options.container ? a(this.options.container) : this.$element.parent(),
                    p = this.getPosition(o);
                h = "bottom" == h && k.bottom + m > p.bottom ? "top" : "top" == h && k.top - m < p.top ? "bottom" : "right" == h && k.right + l > p.width ? "left" : "left" == h && k.left - l < p.left ? "right" : h, f.removeClass(n).addClass(h)
            }
            var q = this.getCalculatedOffset(h, k, l, m);
            this.applyPlacement(q, h);
            var r = function () {
                var a = e.hoverState;
                e.$element.trigger("shown.bs." + e.type), e.hoverState = null, "out" == a && e.leave(e)
            };
            a.support.transition && this.$tip.hasClass("fade") ? f.one("bsTransitionEnd", r).emulateTransitionEnd(c.TRANSITION_DURATION) : r()
        }
    }, c.prototype.applyPlacement = function (b, c) {
        var d = this.tip(), e = d[0].offsetWidth, f = d[0].offsetHeight, g = parseInt(d.css("margin-top"), 10),
            h = parseInt(d.css("margin-left"), 10);
        isNaN(g) && (g = 0), isNaN(h) && (h = 0), b.top = b.top + g, b.left = b.left + h, a.offset.setOffset(d[0], a.extend({
            using: function (a) {
                d.css({top: Math.round(a.top), left: Math.round(a.left)})
            }
        }, b), 0), d.addClass("in");
        var i = d[0].offsetWidth, j = d[0].offsetHeight;
        "top" == c && j != f && (b.top = b.top + f - j);
        var k = this.getViewportAdjustedDelta(c, b, i, j);
        k.left ? b.left += k.left : b.top += k.top;
        var l = /top|bottom/.test(c), m = l ? 2 * k.left - e + i : 2 * k.top - f + j,
            n = l ? "offsetWidth" : "offsetHeight";
        d.offset(b), this.replaceArrow(m, d[0][n], l)
    }, c.prototype.replaceArrow = function (a, b, c) {
        this.arrow().css(c ? "left" : "top", 50 * (1 - a / b) + "%").css(c ? "top" : "left", "")
    }, c.prototype.setContent = function () {
        var a = this.tip(), b = this.getTitle();
        a.find(".tooltip-inner")[this.options.html ? "html" : "text"](b), a.removeClass("fade in top bottom left right")
    }, c.prototype.hide = function (b) {
        function d() {
            "in" != e.hoverState && f.detach(), e.$element.removeAttr("aria-describedby").trigger("hidden.bs." + e.type), b && b()
        }

        var e = this, f = this.tip(), g = a.Event("hide.bs." + this.type);
        return this.$element.trigger(g), g.isDefaultPrevented() ? void 0 : (f.removeClass("in"), a.support.transition && this.$tip.hasClass("fade") ? f.one("bsTransitionEnd", d).emulateTransitionEnd(c.TRANSITION_DURATION) : d(), this.hoverState = null, this)
    }, c.prototype.fixTitle = function () {
        var a = this.$element;
        (a.attr("title") || "string" != typeof a.attr("data-original-title")) && a.attr("data-original-title", a.attr("title") || "").attr("title", "")
    }, c.prototype.hasContent = function () {
        return this.getTitle()
    }, c.prototype.getPosition = function (b) {
        b = b || this.$element;
        var c = b[0], d = "BODY" == c.tagName, e = c.getBoundingClientRect();
        null == e.width && (e = a.extend({}, e, {width: e.right - e.left, height: e.bottom - e.top}));
        var f = d ? {top: 0, left: 0} : b.offset(),
            g = {scroll: d ? document.documentElement.scrollTop || document.body.scrollTop : b.scrollTop()},
            h = d ? {width: a(window).width(), height: a(window).height()} : null;
        return a.extend({}, e, g, h, f)
    }, c.prototype.getCalculatedOffset = function (a, b, c, d) {
        return "bottom" == a ? {
            top: b.top + b.height,
            left: b.left + b.width / 2 - c / 2
        } : "top" == a ? {
            top: b.top - d,
            left: b.left + b.width / 2 - c / 2
        } : "left" == a ? {top: b.top + b.height / 2 - d / 2, left: b.left - c} : {
            top: b.top + b.height / 2 - d / 2,
            left: b.left + b.width
        }
    }, c.prototype.getViewportAdjustedDelta = function (a, b, c, d) {
        var e = {top: 0, left: 0};
        if (!this.$viewport) return e;
        var f = this.options.viewport && this.options.viewport.padding || 0, g = this.getPosition(this.$viewport);
        if (/right|left/.test(a)) {
            var h = b.top - f - g.scroll, i = b.top + f - g.scroll + d;
            h < g.top ? e.top = g.top - h : i > g.top + g.height && (e.top = g.top + g.height - i)
        } else {
            var j = b.left - f, k = b.left + f + c;
            j < g.left ? e.left = g.left - j : k > g.width && (e.left = g.left + g.width - k)
        }
        return e
    }, c.prototype.getTitle = function () {
        var a, b = this.$element, c = this.options;
        return a = b.attr("data-original-title") || ("function" == typeof c.title ? c.title.call(b[0]) : c.title)
    }, c.prototype.getUID = function (a) {
        do a += ~~(1e6 * Math.random()); while (document.getElementById(a));
        return a
    }, c.prototype.tip = function () {
        return this.$tip = this.$tip || a(this.options.template)
    }, c.prototype.arrow = function () {
        return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
    }, c.prototype.enable = function () {
        this.enabled = !0
    }, c.prototype.disable = function () {
        this.enabled = !1
    }, c.prototype.toggleEnabled = function () {
        this.enabled = !this.enabled
    }, c.prototype.toggle = function (b) {
        var c = this;
        b && (c = a(b.currentTarget).data("bs." + this.type), c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c))), c.tip().hasClass("in") ? c.leave(c) : c.enter(c)
    }, c.prototype.destroy = function () {
        var a = this;
        clearTimeout(this.timeout), this.hide(function () {
            a.$element.off("." + a.type).removeData("bs." + a.type)
        })
    };
    var d = a.fn.tooltip;
    a.fn.tooltip = b, a.fn.tooltip.Constructor = c, a.fn.tooltip.noConflict = function () {
        return a.fn.tooltip = d, this
    }
}(jQuery), +function (a) {
    "use strict";

    function b(b) {
        return this.each(function () {
            var d = a(this), e = d.data("bs.popover"), f = "object" == typeof b && b, g = f && f.selector;
            (e || "destroy" != b) && (g ? (e || d.data("bs.popover", e = {}), e[g] || (e[g] = new c(this, f))) : e || d.data("bs.popover", e = new c(this, f)), "string" == typeof b && e[b]())
        })
    }

    var c = function (a, b) {
        this.init("popover", a, b)
    };
    if (!a.fn.tooltip) throw new Error("Popover requires tooltip.js");
    c.VERSION = "3.3.1", c.DEFAULTS = a.extend({}, a.fn.tooltip.Constructor.DEFAULTS, {
        placement: "right",
        trigger: "click",
        content: "",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }), c.prototype = a.extend({}, a.fn.tooltip.Constructor.prototype), c.prototype.constructor = c, c.prototype.getDefaults = function () {
        return c.DEFAULTS
    }, c.prototype.setContent = function () {
        var a = this.tip(), b = this.getTitle(), c = this.getContent();
        a.find(".popover-title")[this.options.html ? "html" : "text"](b), a.find(".popover-content").children().detach().end()[this.options.html ? "string" == typeof c ? "html" : "append" : "text"](c), a.removeClass("fade top bottom left right in"), a.find(".popover-title").html() || a.find(".popover-title").hide()
    }, c.prototype.hasContent = function () {
        return this.getTitle() || this.getContent()
    }, c.prototype.getContent = function () {
        var a = this.$element, b = this.options;
        return a.attr("data-content") || ("function" == typeof b.content ? b.content.call(a[0]) : b.content)
    }, c.prototype.arrow = function () {
        return this.$arrow = this.$arrow || this.tip().find(".arrow")
    }, c.prototype.tip = function () {
        return this.$tip || (this.$tip = a(this.options.template)), this.$tip
    };
    var d = a.fn.popover;
    a.fn.popover = b, a.fn.popover.Constructor = c, a.fn.popover.noConflict = function () {
        return a.fn.popover = d, this
    }
}(jQuery), +function (a) {
    "use strict";

    function b(c, d) {
        var e = a.proxy(this.process, this);
        this.$body = a("body"), this.$scrollElement = a(a(c).is("body") ? window : c), this.options = a.extend({}, b.DEFAULTS, d), this.selector = (this.options.target || "") + " .nav li > a", this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, this.$scrollElement.on("scroll.bs.scrollspy", e), this.refresh(), this.process()
    }

    function c(c) {
        return this.each(function () {
            var d = a(this), e = d.data("bs.scrollspy"), f = "object" == typeof c && c;
            e || d.data("bs.scrollspy", e = new b(this, f)), "string" == typeof c && e[c]()
        })
    }

    b.VERSION = "3.3.1", b.DEFAULTS = {offset: 10}, b.prototype.getScrollHeight = function () {
        return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
    }, b.prototype.refresh = function () {
        var b = "offset", c = 0;
        a.isWindow(this.$scrollElement[0]) || (b = "position", c = this.$scrollElement.scrollTop()), this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight();
        var d = this;
        this.$body.find(this.selector).map(function () {
            var d = a(this), e = d.data("target") || d.attr("href"), f = /^#./.test(e) && a(e);
            return f && f.length && f.is(":visible") && [[f[b]().top + c, e]] || null
        }).sort(function (a, b) {
            return a[0] - b[0]
        }).each(function () {
            d.offsets.push(this[0]), d.targets.push(this[1])
        })
    }, b.prototype.process = function () {
        var a, b = this.$scrollElement.scrollTop() + this.options.offset, c = this.getScrollHeight(),
            d = this.options.offset + c - this.$scrollElement.height(), e = this.offsets, f = this.targets,
            g = this.activeTarget;
        if (this.scrollHeight != c && this.refresh(), b >= d) return g != (a = f[f.length - 1]) && this.activate(a);
        if (g && b < e[0]) return this.activeTarget = null, this.clear();
        for (a = e.length; a--;) g != f[a] && b >= e[a] && (!e[a + 1] || b <= e[a + 1]) && this.activate(f[a])
    }, b.prototype.activate = function (b) {
        this.activeTarget = b, this.clear();
        var c = this.selector + '[data-target="' + b + '"],' + this.selector + '[href="' + b + '"]',
            d = a(c).parents("li").addClass("active");
        d.parent(".dropdown-menu").length && (d = d.closest("li.dropdown").addClass("active")), d.trigger("activate.bs.scrollspy")
    }, b.prototype.clear = function () {
        a(this.selector).parentsUntil(this.options.target, ".active").removeClass("active")
    };
    var d = a.fn.scrollspy;
    a.fn.scrollspy = c, a.fn.scrollspy.Constructor = b, a.fn.scrollspy.noConflict = function () {
        return a.fn.scrollspy = d, this
    }, a(window).on("load.bs.scrollspy.data-api", function () {
        a('[data-spy="scroll"]').each(function () {
            var b = a(this);
            c.call(b, b.data())
        })
    })
}(jQuery), +function (a) {
    "use strict";

    function b(b) {
        return this.each(function () {
            var d = a(this), e = d.data("bs.tab");
            e || d.data("bs.tab", e = new c(this)), "string" == typeof b && e[b]()
        })
    }

    var c = function (b) {
        this.element = a(b)
    };
    c.VERSION = "3.3.1", c.TRANSITION_DURATION = 150, c.prototype.show = function () {
        var b = this.element, c = b.closest("ul:not(.dropdown-menu)"), d = b.data("target");
        if (d || (d = b.attr("href"), d = d && d.replace(/.*(?=#[^\s]*$)/, "")), !b.parent("li").hasClass("active")) {
            var e = c.find(".active:last a"), f = a.Event("hide.bs.tab", {relatedTarget: b[0]}),
                g = a.Event("show.bs.tab", {relatedTarget: e[0]});
            if (e.trigger(f), b.trigger(g), !g.isDefaultPrevented() && !f.isDefaultPrevented()) {
                var h = a(d);
                this.activate(b.closest("li"), c), this.activate(h, h.parent(), function () {
                    e.trigger({type: "hidden.bs.tab", relatedTarget: b[0]}), b.trigger({
                        type: "shown.bs.tab",
                        relatedTarget: e[0]
                    })
                })
            }
        }
    }, c.prototype.activate = function (b, d, e) {
        function f() {
            g.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !1), b.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0), h ? (b[0].offsetWidth, b.addClass("in")) : b.removeClass("fade"), b.parent(".dropdown-menu") && b.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0), e && e()
        }

        var g = d.find("> .active"),
            h = e && a.support.transition && (g.length && g.hasClass("fade") || !!d.find("> .fade").length);
        g.length && h ? g.one("bsTransitionEnd", f).emulateTransitionEnd(c.TRANSITION_DURATION) : f(), g.removeClass("in")
    };
    var d = a.fn.tab;
    a.fn.tab = b, a.fn.tab.Constructor = c, a.fn.tab.noConflict = function () {
        return a.fn.tab = d, this
    };
    var e = function (c) {
        c.preventDefault(), b.call(a(this), "show")
    };
    a(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', e).on("click.bs.tab.data-api", '[data-toggle="pill"]', e)
}(jQuery), +function (a) {
    "use strict";

    function b(b) {
        return this.each(function () {
            var d = a(this), e = d.data("bs.affix"), f = "object" == typeof b && b;
            e || d.data("bs.affix", e = new c(this, f)), "string" == typeof b && e[b]()
        })
    }

    var c = function (b, d) {
        this.options = a.extend({}, c.DEFAULTS, d), this.$target = a(this.options.target).on("scroll.bs.affix.data-api", a.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", a.proxy(this.checkPositionWithEventLoop, this)), this.$element = a(b), this.affixed = this.unpin = this.pinnedOffset = null, this.checkPosition()
    };
    c.VERSION = "3.3.1", c.RESET = "affix affix-top affix-bottom", c.DEFAULTS = {
        offset: 0,
        target: window
    }, c.prototype.getState = function (a, b, c, d) {
        var e = this.$target.scrollTop(), f = this.$element.offset(), g = this.$target.height();
        if (null != c && "top" == this.affixed) return c > e ? "top" : !1;
        if ("bottom" == this.affixed) return null != c ? e + this.unpin <= f.top ? !1 : "bottom" : a - d >= e + g ? !1 : "bottom";
        var h = null == this.affixed, i = h ? e : f.top, j = h ? g : b;
        return null != c && c >= i ? "top" : null != d && i + j >= a - d ? "bottom" : !1
    }, c.prototype.getPinnedOffset = function () {
        if (this.pinnedOffset) return this.pinnedOffset;
        this.$element.removeClass(c.RESET).addClass("affix");
        var a = this.$target.scrollTop(), b = this.$element.offset();
        return this.pinnedOffset = b.top - a
    }, c.prototype.checkPositionWithEventLoop = function () {
        setTimeout(a.proxy(this.checkPosition, this), 1)
    }, c.prototype.checkPosition = function () {
        if (this.$element.is(":visible")) {
            var b = this.$element.height(), d = this.options.offset, e = d.top, f = d.bottom, g = a("body").height();
            "object" != typeof d && (f = e = d), "function" == typeof e && (e = d.top(this.$element)), "function" == typeof f && (f = d.bottom(this.$element));
            var h = this.getState(g, b, e, f);
            if (this.affixed != h) {
                null != this.unpin && this.$element.css("top", "");
                var i = "affix" + (h ? "-" + h : ""), j = a.Event(i + ".bs.affix");
                if (this.$element.trigger(j), j.isDefaultPrevented()) return;
                this.affixed = h, this.unpin = "bottom" == h ? this.getPinnedOffset() : null, this.$element.removeClass(c.RESET).addClass(i).trigger(i.replace("affix", "affixed") + ".bs.affix")
            }
            "bottom" == h && this.$element.offset({top: g - b - f})
        }
    };
    var d = a.fn.affix;
    a.fn.affix = b, a.fn.affix.Constructor = c, a.fn.affix.noConflict = function () {
        return a.fn.affix = d, this
    }, a(window).on("load", function () {
        a('[data-spy="affix"]').each(function () {
            var c = a(this), d = c.data();
            d.offset = d.offset || {}, null != d.offsetBottom && (d.offset.bottom = d.offsetBottom), null != d.offsetTop && (d.offset.top = d.offsetTop), b.call(c, d)
        })
    })
}(jQuery);
/*! WOW - v0.1.9 - 2014-05-10
* Copyright (c) 2014 Matthieu Aussaguel; Licensed MIT */
(function () {
    var a, b, c = function (a, b) {
        return function () {
            return a.apply(b, arguments)
        }
    };
    a = function () {
        function a() {
        }

        return a.prototype.extend = function (a, b) {
            var c, d;
            for (c in a) d = a[c], null != d && (b[c] = d);
            return b
        }, a.prototype.isMobile = function (a) {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(a)
        }, a
    }(), b = this.WeakMap || (b = function () {
        function a() {
            this.keys = [], this.values = []
        }

        return a.prototype.get = function (a) {
            var b, c, d, e, f;
            for (f = this.keys, b = d = 0, e = f.length; e > d; b = ++d) if (c = f[b], c === a) return this.values[b]
        }, a.prototype.set = function (a, b) {
            var c, d, e, f, g;
            for (g = this.keys, c = e = 0, f = g.length; f > e; c = ++e) if (d = g[c], d === a) return void (this.values[c] = b);
            return this.keys.push(a), this.values.push(b)
        }, a
    }()), this.WOW = function () {
        function d(a) {
            null == a && (a = {}), this.scrollCallback = c(this.scrollCallback, this), this.scrollHandler = c(this.scrollHandler, this), this.start = c(this.start, this), this.scrolled = !0, this.config = this.util().extend(a, this.defaults), this.animationNameCache = new b
        }

        return d.prototype.defaults = {
            boxClass: "wow",
            animateClass: "animated",
            offset: 0,
            mobile: !0
        }, d.prototype.init = function () {
            var a;
            return this.element = window.document.documentElement, "interactive" === (a = document.readyState) || "complete" === a ? this.start() : document.addEventListener("DOMContentLoaded", this.start)
        }, d.prototype.start = function () {
            var a, b, c, d;
            if (this.boxes = this.element.getElementsByClassName(this.config.boxClass), this.boxes.length) {
                if (this.disabled()) return this.resetStyle();
                for (d = this.boxes, b = 0, c = d.length; c > b; b++) a = d[b], this.applyStyle(a, !0);
                return window.addEventListener("scroll", this.scrollHandler, !1), window.addEventListener("resize", this.scrollHandler, !1), this.interval = setInterval(this.scrollCallback, 50)
            }
        }, d.prototype.stop = function () {
            return window.removeEventListener("scroll", this.scrollHandler, !1), window.removeEventListener("resize", this.scrollHandler, !1), null != this.interval ? clearInterval(this.interval) : void 0
        }, d.prototype.show = function (a) {
            return this.applyStyle(a), a.className = "" + a.className + " " + this.config.animateClass
        }, d.prototype.applyStyle = function (a, b) {
            var c, d, e;
            return d = a.getAttribute("data-wow-duration"), c = a.getAttribute("data-wow-delay"), e = a.getAttribute("data-wow-iteration"), this.animate(function (f) {
                return function () {
                    return f.customStyle(a, b, d, c, e)
                }
            }(this))
        }, d.prototype.animate = function () {
            return "requestAnimationFrame" in window ? function (a) {
                return window.requestAnimationFrame(a)
            } : function (a) {
                return a()
            }
        }(), d.prototype.resetStyle = function () {
            var a, b, c, d, e;
            for (d = this.boxes, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.setAttribute("style", "visibility: visible;"));
            return e
        }, d.prototype.customStyle = function (a, b, c, d, e) {
            return b && this.cacheAnimationName(a), a.style.visibility = b ? "hidden" : "visible", c && this.vendorSet(a.style, {animationDuration: c}), d && this.vendorSet(a.style, {animationDelay: d}), e && this.vendorSet(a.style, {animationIterationCount: e}), this.vendorSet(a.style, {animationName: b ? "none" : this.cachedAnimationName(a)}), a
        }, d.prototype.vendors = ["moz", "webkit"], d.prototype.vendorSet = function (a, b) {
            var c, d, e, f;
            f = [];
            for (c in b) d = b[c], a["" + c] = d, f.push(function () {
                var b, f, g, h;
                for (g = this.vendors, h = [], b = 0, f = g.length; f > b; b++) e = g[b], h.push(a["" + e + c.charAt(0).toUpperCase() + c.substr(1)] = d);
                return h
            }.call(this));
            return f
        }, d.prototype.vendorCSS = function (a, b) {
            var c, d, e, f, g, h;
            for (d = window.getComputedStyle(a), c = d.getPropertyCSSValue(b), h = this.vendors, f = 0, g = h.length; g > f; f++) e = h[f], c = c || d.getPropertyCSSValue("-" + e + "-" + b);
            return c
        }, d.prototype.animationName = function (a) {
            var b;
            try {
                b = this.vendorCSS(a, "animation-name").cssText
            } catch (c) {
                b = window.getComputedStyle(a).getPropertyValue("animation-name")
            }
            return "none" === b ? "" : b
        }, d.prototype.cacheAnimationName = function (a) {
            return this.animationNameCache.set(a, this.animationName(a))
        }, d.prototype.cachedAnimationName = function (a) {
            return this.animationNameCache.get(a)
        }, d.prototype.scrollHandler = function () {
            return this.scrolled = !0
        }, d.prototype.scrollCallback = function () {
            var a;
            return this.scrolled && (this.scrolled = !1, this.boxes = function () {
                var b, c, d, e;
                for (d = this.boxes, e = [], b = 0, c = d.length; c > b; b++) a = d[b], a && (this.isVisible(a) ? this.show(a) : e.push(a));
                return e
            }.call(this), !this.boxes.length) ? this.stop() : void 0
        }, d.prototype.offsetTop = function (a) {
            for (var b; void 0 === a.offsetTop;) a = a.parentNode;
            for (b = a.offsetTop; a = a.offsetParent;) b += a.offsetTop;
            return b
        }, d.prototype.isVisible = function (a) {
            var b, c, d, e, f;
            return c = a.getAttribute("data-wow-offset") || this.config.offset, f = window.pageYOffset, e = f + this.element.clientHeight - c, d = this.offsetTop(a), b = d + a.clientHeight, e >= d && b >= f
        }, d.prototype.util = function () {
            return this._util || (this._util = new a)
        }, d.prototype.disabled = function () {
            return !this.config.mobile && this.util().isMobile(navigator.userAgent)
        }, d
    }()
}).call(this);
$(document).ready(function () {
    $(".removeItem").click(function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        swal({
            title: 'آیا اطمینان دارید؟',
            text: "توجه کنید در صورت تایید این عمل قابل بازگشت نیست",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#54b35c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله',
            cancelButtonText: 'خیر'
        }).then(function (result) {
            if (result) {
                window.location = href;
            }
        });
    });
});
$(document).ready(function () {
    jQuery("#nav").singlePageNav({
        offset: jQuery("#nav").outerHeight(),
        filter: ":not(.external)",
        speed: 1200,
        currentClass: "current",
        easing: "easeInOutExpo",
        updateHash: !0,
    }), $(window).scroll(function () {
        $(window).scrollTop() > 0 ? ($("#navigation").css("background-color", "#e52531"), $(".logo").css("display", "none", " border:none"), $(".logo1").css("display", "block", " border:none")) : ($("#navigation").css("background-color", "rgba(0, 0, 0, 0.0)"), $(".logo").css("display", "block", " border:none"), $(".logo1").css("display", "block", " border:none"))
    });
    var e = $(window).height();
    $("#slider, .carousel.slide, .carousel-inner, .carousel-inner .item").css("height", e), $(window).resize(function () {
        $("#slider, .carousel.slide, .carousel-inner, .carousel-inner .item").css("height", e)
    }), $(".project-wrapper").mixItUp(), $(window).scroll(function () {
        $(window).scrollTop() > 400 ? $("#back-top").fadeIn(200) : $("#back-top").fadeOut(200)
    }), $("#back-top").click(function () {
        $("html, body").stop().animate({scrollTop: 0}, 1500, "easeInOutExpo")
    })
}), $("nav.menu li").hover(function () {
    $("> ul", this).stop().slideDown(200)
}, function () {
    $("> ul", this).stop().slideUp(200)
}), $(".links li.have-sub a").click(function (e) {
    var o = $(this).parent("li").hasClass("noSub");
    o || e.preventDefault(), $(this).parent("li").siblings("li").children("ul").slideUp("fast"), $(this).parent("li").toggleClass("open-li");
    var n = $(this).parent().children("ul:first");
    n.slideToggle("down")
}), $(function () {

}), $(".search").click(function () {
    $("ul").toggleClass("active"), $(".search_box").toggleClass("search_box_active")
});
var seened = false;
window.dataLayer = window.dataLayer || [];
var height = window.innerHeight;

$(document).ready(function () {
    $('#offset').tooltipster({
        plugins: ['follower']
    });
    $('#digital').tooltipster({
        plugins: ['follower']
    });
    $('#student').tooltipster({
        plugins: ['follower']
    });
    $('#gift').tooltipster({
        plugins: ['follower']
    });
    $('#offset').tooltipster('content', 'لیست قیمت چاپ افست');
    $('#digital').tooltipster('content', 'لیست قیمت چاپ دیجیتال');
    $('#student').tooltipster('content', 'لیست قیمت خدمات دانشجویی');
    $('#gift').tooltipster('content', 'تخفیف روز');
    $("#banner").modal();
    $('[data-toggle="tooltip"]').tooltip();
});
var wow = new WOW({
    boxClass: 'wow', // animated element css class (default is wow)
    animateClass: 'animated', // animation css class (default is animated)
    offset: 120, // distance to the element when triggering the animation (default is 0)
    mobile: false, // trigger animations on mobile devices (default is true)
    live: true // act on asynchronously loaded content (default is true)
});
wow.init();
$(document).ready(function () {
    function toggleNavbarMethod() {
        if ($(window).width() > 768) {
            $('.navbar .dropdown').on('mouseover', function () {
                $('.dropdown-toggle', this).trigger('click');
            }).on('mouseout', function () {
                $('.dropdown-toggle', this).trigger('click').blur();
            });
        } else {
            $('.navbar .dropdown').off('mouseover').off('mouseout');
        }
    }

    toggleNavbarMethod();
    $(window).resize(toggleNavbarMethod);
});
/*! tooltipster v4.2.5 */
!function (a, b) {
    "function" == typeof define && define.amd ? define(["jquery"], function (a) {
        return b(a)
    }) : "object" == typeof exports ? module.exports = b(require("jquery")) : b(jQuery)
}(this, function (a) {
    function b(a) {
        this.$container, this.constraints = null, this.__$tooltip, this.__init(a)
    }

    function c(b, c) {
        var d = !0;
        return a.each(b, function (a, e) {
            return void 0 === c[a] || b[a] !== c[a] ? (d = !1, !1) : void 0
        }), d
    }

    function d(b) {
        var c = b.attr("id"), d = c ? h.window.document.getElementById(c) : null;
        return d ? d === b[0] : a.contains(h.window.document.body, b[0])
    }

    function e() {
        if (!g) return !1;
        var a = g.document.body || g.document.documentElement, b = a.style, c = "transition",
            d = ["Moz", "Webkit", "Khtml", "O", "ms"];
        if ("string" == typeof b[c]) return !0;
        c = c.charAt(0).toUpperCase() + c.substr(1);
        for (var e = 0; e < d.length; e++) if ("string" == typeof b[d[e] + c]) return !0;
        return !1
    }

    var f = {
        animation: "fade",
        animationDuration: 350,
        content: null,
        contentAsHTML: !1,
        contentCloning: !1,
        debug: !0,
        delay: 300,
        delayTouch: [300, 500],
        functionInit: null,
        functionBefore: null,
        functionReady: null,
        functionAfter: null,
        functionFormat: null,
        IEmin: 6,
        interactive: !1,
        multiple: !1,
        parent: null,
        plugins: ["sideTip"],
        repositionOnScroll: !1,
        restoration: "none",
        selfDestruction: !0,
        theme: [],
        timer: 0,
        trackerInterval: 500,
        trackOrigin: !1,
        trackTooltip: !1,
        trigger: "hover",
        triggerClose: {click: !1, mouseleave: !1, originClick: !1, scroll: !1, tap: !1, touchleave: !1},
        triggerOpen: {click: !1, mouseenter: !1, tap: !1, touchstart: !1},
        updateAnimation: "rotate",
        zIndex: 9999999
    }, g = "undefined" != typeof window ? window : null, h = {
        hasTouchCapability: !(!g || !("ontouchstart" in g || g.DocumentTouch && g.document instanceof g.DocumentTouch || g.navigator.maxTouchPoints)),
        hasTransitions: e(),
        IE: !1,
        semVer: "4.2.5",
        window: g
    }, i = function () {
        this.__$emitterPrivate = a({}), this.__$emitterPublic = a({}), this.__instancesLatestArr = [], this.__plugins = {}, this._env = h
    };
    i.prototype = {
        __bridge: function (b, c, d) {
            if (!c[d]) {
                var e = function () {
                };
                e.prototype = b;
                var g = new e;
                g.__init && g.__init(c), a.each(b, function (a, b) {
                    0 != a.indexOf("__") && (c[a] ? f.debug && console.log("The " + a + " method of the " + d + " plugin conflicts with another plugin or native methods") : (c[a] = function () {
                        return g[a].apply(g, Array.prototype.slice.apply(arguments))
                    }, c[a].bridged = g))
                }), c[d] = g
            }
            return this
        }, __setWindow: function (a) {
            return h.window = a, this
        }, _getRuler: function (a) {
            return new b(a)
        }, _off: function () {
            return this.__$emitterPrivate.off.apply(this.__$emitterPrivate, Array.prototype.slice.apply(arguments)), this
        }, _on: function () {
            return this.__$emitterPrivate.on.apply(this.__$emitterPrivate, Array.prototype.slice.apply(arguments)), this
        }, _one: function () {
            return this.__$emitterPrivate.one.apply(this.__$emitterPrivate, Array.prototype.slice.apply(arguments)), this
        }, _plugin: function (b) {
            var c = this;
            if ("string" == typeof b) {
                var d = b, e = null;
                return d.indexOf(".") > 0 ? e = c.__plugins[d] : a.each(c.__plugins, function (a, b) {
                    return b.name.substring(b.name.length - d.length - 1) == "." + d ? (e = b, !1) : void 0
                }), e
            }
            if (b.name.indexOf(".") < 0) throw new Error("Plugins must be namespaced");
            return c.__plugins[b.name] = b, b.core && c.__bridge(b.core, c, b.name), this
        }, _trigger: function () {
            var a = Array.prototype.slice.apply(arguments);
            return "string" == typeof a[0] && (a[0] = {type: a[0]}), this.__$emitterPrivate.trigger.apply(this.__$emitterPrivate, a), this.__$emitterPublic.trigger.apply(this.__$emitterPublic, a), this
        }, instances: function (b) {
            var c = [], d = b || ".tooltipstered";
            return a(d).each(function () {
                var b = a(this), d = b.data("tooltipster-ns");
                d && a.each(d, function (a, d) {
                    c.push(b.data(d))
                })
            }), c
        }, instancesLatest: function () {
            return this.__instancesLatestArr
        }, off: function () {
            return this.__$emitterPublic.off.apply(this.__$emitterPublic, Array.prototype.slice.apply(arguments)), this
        }, on: function () {
            return this.__$emitterPublic.on.apply(this.__$emitterPublic, Array.prototype.slice.apply(arguments)), this
        }, one: function () {
            return this.__$emitterPublic.one.apply(this.__$emitterPublic, Array.prototype.slice.apply(arguments)), this
        }, origins: function (b) {
            var c = b ? b + " " : "";
            return a(c + ".tooltipstered").toArray()
        }, setDefaults: function (b) {
            return a.extend(f, b), this
        }, triggerHandler: function () {
            return this.__$emitterPublic.triggerHandler.apply(this.__$emitterPublic, Array.prototype.slice.apply(arguments)), this
        }
    }, a.tooltipster = new i, a.Tooltipster = function (b, c) {
        this.__callbacks = {
            close: [],
            open: []
        }, this.__closingTime, this.__Content, this.__contentBcr, this.__destroyed = !1, this.__$emitterPrivate = a({}), this.__$emitterPublic = a({}), this.__enabled = !0, this.__garbageCollector, this.__Geometry, this.__lastPosition, this.__namespace = "tooltipster-" + Math.round(1e6 * Math.random()), this.__options, this.__$originParents, this.__pointerIsOverOrigin = !1, this.__previousThemes = [], this.__state = "closed", this.__timeouts = {
            close: [],
            open: null
        }, this.__touchEvents = [], this.__tracker = null, this._$origin, this._$tooltip, this.__init(b, c)
    }, a.Tooltipster.prototype = {
        __init: function (b, c) {
            var d = this;
            if (d._$origin = a(b), d.__options = a.extend(!0, {}, f, c), d.__optionsFormat(), !h.IE || h.IE >= d.__options.IEmin) {
                var e = null;
                if (void 0 === d._$origin.data("tooltipster-initialTitle") && (e = d._$origin.attr("title"), void 0 === e && (e = null), d._$origin.data("tooltipster-initialTitle", e)), null !== d.__options.content) d.__contentSet(d.__options.content); else {
                    var g, i = d._$origin.attr("data-tooltip-content");
                    i && (g = a(i)), g && g[0] ? d.__contentSet(g.first()) : d.__contentSet(e)
                }
                d._$origin.removeAttr("title").addClass("tooltipstered"), d.__prepareOrigin(), d.__prepareGC(), a.each(d.__options.plugins, function (a, b) {
                    d._plug(b)
                }), h.hasTouchCapability && a(h.window.document.body).on("touchmove." + d.__namespace + "-triggerOpen", function (a) {
                    d._touchRecordEvent(a)
                }), d._on("created", function () {
                    d.__prepareTooltip()
                })._on("repositioned", function (a) {
                    d.__lastPosition = a.position
                })
            } else d.__options.disabled = !0
        }, __contentInsert: function () {
            var a = this, b = a._$tooltip.find(".tooltipster-content"), c = a.__Content, d = function (a) {
                c = a
            };
            return a._trigger({
                type: "format",
                content: a.__Content,
                format: d
            }), a.__options.functionFormat && (c = a.__options.functionFormat.call(a, a, {origin: a._$origin[0]}, a.__Content)), "string" != typeof c || a.__options.contentAsHTML ? b.empty().append(c) : b.text(c), a
        }, __contentSet: function (b) {
            return b instanceof a && this.__options.contentCloning && (b = b.clone(!0)), this.__Content = b, this._trigger({
                type: "updated",
                content: b
            }), this
        }, __destroyError: function () {
            throw new Error("This tooltip has been destroyed and cannot execute your method call.")
        }, __geometry: function () {
            var b = this, c = b._$origin, d = b._$origin.is("area");
            if (d) {
                var e = b._$origin.parent().attr("name");
                c = a('img[usemap="#' + e + '"]')
            }
            var f = c[0].getBoundingClientRect(), g = a(h.window.document), i = a(h.window), j = c, k = {
                available: {document: null, window: null},
                document: {size: {height: g.height(), width: g.width()}},
                window: {
                    scroll: {
                        left: h.window.scrollX || h.window.document.documentElement.scrollLeft,
                        top: h.window.scrollY || h.window.document.documentElement.scrollTop
                    }, size: {height: i.height(), width: i.width()}
                },
                origin: {
                    fixedLineage: !1,
                    offset: {},
                    size: {height: f.bottom - f.top, width: f.right - f.left},
                    usemapImage: d ? c[0] : null,
                    windowOffset: {bottom: f.bottom, left: f.left, right: f.right, top: f.top}
                }
            };
            if (d) {
                var l = b._$origin.attr("shape"), m = b._$origin.attr("coords");
                if (m && (m = m.split(","), a.map(m, function (a, b) {
                    m[b] = parseInt(a)
                })), "default" != l) switch (l) {
                    case"circle":
                        var n = m[0], o = m[1], p = m[2], q = o - p, r = n - p;
                        k.origin.size.height = 2 * p, k.origin.size.width = k.origin.size.height, k.origin.windowOffset.left += r, k.origin.windowOffset.top += q;
                        break;
                    case"rect":
                        var s = m[0], t = m[1], u = m[2], v = m[3];
                        k.origin.size.height = v - t, k.origin.size.width = u - s, k.origin.windowOffset.left += s, k.origin.windowOffset.top += t;
                        break;
                    case"poly":
                        for (var w = 0, x = 0, y = 0, z = 0, A = "even", B = 0; B < m.length; B++) {
                            var C = m[B];
                            "even" == A ? (C > y && (y = C, 0 === B && (w = y)), w > C && (w = C), A = "odd") : (C > z && (z = C, 1 == B && (x = z)), x > C && (x = C), A = "even")
                        }
                        k.origin.size.height = z - x, k.origin.size.width = y - w, k.origin.windowOffset.left += w, k.origin.windowOffset.top += x
                }
            }
            var D = function (a) {
                k.origin.size.height = a.height, k.origin.windowOffset.left = a.left, k.origin.windowOffset.top = a.top, k.origin.size.width = a.width
            };
            for (b._trigger({
                type: "geometry",
                edit: D,
                geometry: {
                    height: k.origin.size.height,
                    left: k.origin.windowOffset.left,
                    top: k.origin.windowOffset.top,
                    width: k.origin.size.width
                }
            }), k.origin.windowOffset.right = k.origin.windowOffset.left + k.origin.size.width, k.origin.windowOffset.bottom = k.origin.windowOffset.top + k.origin.size.height, k.origin.offset.left = k.origin.windowOffset.left + k.window.scroll.left, k.origin.offset.top = k.origin.windowOffset.top + k.window.scroll.top, k.origin.offset.bottom = k.origin.offset.top + k.origin.size.height, k.origin.offset.right = k.origin.offset.left + k.origin.size.width, k.available.document = {
                bottom: {
                    height: k.document.size.height - k.origin.offset.bottom,
                    width: k.document.size.width
                },
                left: {height: k.document.size.height, width: k.origin.offset.left},
                right: {height: k.document.size.height, width: k.document.size.width - k.origin.offset.right},
                top: {height: k.origin.offset.top, width: k.document.size.width}
            }, k.available.window = {
                bottom: {
                    height: Math.max(k.window.size.height - Math.max(k.origin.windowOffset.bottom, 0), 0),
                    width: k.window.size.width
                },
                left: {height: k.window.size.height, width: Math.max(k.origin.windowOffset.left, 0)},
                right: {
                    height: k.window.size.height,
                    width: Math.max(k.window.size.width - Math.max(k.origin.windowOffset.right, 0), 0)
                },
                top: {height: Math.max(k.origin.windowOffset.top, 0), width: k.window.size.width}
            }; "html" != j[0].tagName.toLowerCase();) {
                if ("fixed" == j.css("position")) {
                    k.origin.fixedLineage = !0;
                    break
                }
                j = j.parent()
            }
            return k
        }, __optionsFormat: function () {
            return "number" == typeof this.__options.animationDuration && (this.__options.animationDuration = [this.__options.animationDuration, this.__options.animationDuration]), "number" == typeof this.__options.delay && (this.__options.delay = [this.__options.delay, this.__options.delay]), "number" == typeof this.__options.delayTouch && (this.__options.delayTouch = [this.__options.delayTouch, this.__options.delayTouch]), "string" == typeof this.__options.theme && (this.__options.theme = [this.__options.theme]), null === this.__options.parent ? this.__options.parent = a(h.window.document.body) : "string" == typeof this.__options.parent && (this.__options.parent = a(this.__options.parent)), "hover" == this.__options.trigger ? (this.__options.triggerOpen = {
                mouseenter: !0,
                touchstart: !0
            }, this.__options.triggerClose = {
                mouseleave: !0,
                originClick: !0,
                touchleave: !0
            }) : "click" == this.__options.trigger && (this.__options.triggerOpen = {
                click: !0,
                tap: !0
            }, this.__options.triggerClose = {click: !0, tap: !0}), this._trigger("options"), this
        }, __prepareGC: function () {
            var b = this;
            return b.__options.selfDestruction ? b.__garbageCollector = setInterval(function () {
                var c = (new Date).getTime();
                b.__touchEvents = a.grep(b.__touchEvents, function (a, b) {
                    return c - a.time > 6e4
                }), d(b._$origin) || b.close(function () {
                    b.destroy()
                })
            }, 2e4) : clearInterval(b.__garbageCollector), b
        }, __prepareOrigin: function () {
            var a = this;
            if (a._$origin.off("." + a.__namespace + "-triggerOpen"), h.hasTouchCapability && a._$origin.on("touchstart." + a.__namespace + "-triggerOpen touchend." + a.__namespace + "-triggerOpen touchcancel." + a.__namespace + "-triggerOpen", function (b) {
                a._touchRecordEvent(b)
            }), a.__options.triggerOpen.click || a.__options.triggerOpen.tap && h.hasTouchCapability) {
                var b = "";
                a.__options.triggerOpen.click && (b += "click." + a.__namespace + "-triggerOpen "), a.__options.triggerOpen.tap && h.hasTouchCapability && (b += "touchend." + a.__namespace + "-triggerOpen"), a._$origin.on(b, function (b) {
                    a._touchIsMeaningfulEvent(b) && a._open(b)
                })
            }
            if (a.__options.triggerOpen.mouseenter || a.__options.triggerOpen.touchstart && h.hasTouchCapability) {
                var b = "";
                a.__options.triggerOpen.mouseenter && (b += "mouseenter." + a.__namespace + "-triggerOpen "), a.__options.triggerOpen.touchstart && h.hasTouchCapability && (b += "touchstart." + a.__namespace + "-triggerOpen"), a._$origin.on(b, function (b) {
                    !a._touchIsTouchEvent(b) && a._touchIsEmulatedEvent(b) || (a.__pointerIsOverOrigin = !0, a._openShortly(b))
                })
            }
            if (a.__options.triggerClose.mouseleave || a.__options.triggerClose.touchleave && h.hasTouchCapability) {
                var b = "";
                a.__options.triggerClose.mouseleave && (b += "mouseleave." + a.__namespace + "-triggerOpen "), a.__options.triggerClose.touchleave && h.hasTouchCapability && (b += "touchend." + a.__namespace + "-triggerOpen touchcancel." + a.__namespace + "-triggerOpen"), a._$origin.on(b, function (b) {
                    a._touchIsMeaningfulEvent(b) && (a.__pointerIsOverOrigin = !1)
                })
            }
            return a
        }, __prepareTooltip: function () {
            var b = this, c = b.__options.interactive ? "auto" : "";
            return b._$tooltip.attr("id", b.__namespace).css({
                "pointer-events": c,
                zIndex: b.__options.zIndex
            }), a.each(b.__previousThemes, function (a, c) {
                b._$tooltip.removeClass(c)
            }), a.each(b.__options.theme, function (a, c) {
                b._$tooltip.addClass(c)
            }), b.__previousThemes = a.merge([], b.__options.theme), b
        }, __scrollHandler: function (b) {
            var c = this;
            if (c.__options.triggerClose.scroll) c._close(b); else if (d(c._$origin) && d(c._$tooltip)) {
                var e = null;
                if (b.target === h.window.document) c.__Geometry.origin.fixedLineage || c.__options.repositionOnScroll && c.reposition(b); else {
                    e = c.__geometry();
                    var f = !1;
                    if ("fixed" != c._$origin.css("position") && c.__$originParents.each(function (b, c) {
                        var d = a(c), g = d.css("overflow-x"), h = d.css("overflow-y");
                        if ("visible" != g || "visible" != h) {
                            var i = c.getBoundingClientRect();
                            if ("visible" != g && (e.origin.windowOffset.left < i.left || e.origin.windowOffset.right > i.right)) return f = !0, !1;
                            if ("visible" != h && (e.origin.windowOffset.top < i.top || e.origin.windowOffset.bottom > i.bottom)) return f = !0, !1
                        }
                        return "fixed" == d.css("position") ? !1 : void 0
                    }), f) c._$tooltip.css("visibility", "hidden"); else if (c._$tooltip.css("visibility", "visible"), c.__options.repositionOnScroll) c.reposition(b); else {
                        var g = e.origin.offset.left - c.__Geometry.origin.offset.left,
                            i = e.origin.offset.top - c.__Geometry.origin.offset.top;
                        c._$tooltip.css({left: c.__lastPosition.coord.left + g, top: c.__lastPosition.coord.top + i})
                    }
                }
                c._trigger({type: "scroll", event: b, geo: e})
            }
            return c
        }, __stateSet: function (a) {
            return this.__state = a, this._trigger({type: "state", state: a}), this
        }, __timeoutsClear: function () {
            return clearTimeout(this.__timeouts.open), this.__timeouts.open = null, a.each(this.__timeouts.close, function (a, b) {
                clearTimeout(b)
            }), this.__timeouts.close = [], this
        }, __trackerStart: function () {
            var a = this, b = a._$tooltip.find(".tooltipster-content");
            return a.__options.trackTooltip && (a.__contentBcr = b[0].getBoundingClientRect()), a.__tracker = setInterval(function () {
                if (d(a._$origin) && d(a._$tooltip)) {
                    if (a.__options.trackOrigin) {
                        var e = a.__geometry(), f = !1;
                        c(e.origin.size, a.__Geometry.origin.size) && (a.__Geometry.origin.fixedLineage ? c(e.origin.windowOffset, a.__Geometry.origin.windowOffset) && (f = !0) : c(e.origin.offset, a.__Geometry.origin.offset) && (f = !0)), f || (a.__options.triggerClose.mouseleave ? a._close() : a.reposition())
                    }
                    if (a.__options.trackTooltip) {
                        var g = b[0].getBoundingClientRect();
                        g.height === a.__contentBcr.height && g.width === a.__contentBcr.width || (a.reposition(), a.__contentBcr = g)
                    }
                } else a._close()
            }, a.__options.trackerInterval), a
        }, _close: function (b, c, d) {
            var e = this, f = !0;
            if (e._trigger({
                type: "close", event: b, stop: function () {
                    f = !1
                }
            }), f || d) {
                c && e.__callbacks.close.push(c), e.__callbacks.open = [], e.__timeoutsClear();
                var g = function () {
                    a.each(e.__callbacks.close, function (a, c) {
                        c.call(e, e, {event: b, origin: e._$origin[0]})
                    }), e.__callbacks.close = []
                };
                if ("closed" != e.__state) {
                    var i = !0, j = new Date, k = j.getTime(), l = k + e.__options.animationDuration[1];
                    if ("disappearing" == e.__state && l > e.__closingTime && e.__options.animationDuration[1] > 0 && (i = !1), i) {
                        e.__closingTime = l, "disappearing" != e.__state && e.__stateSet("disappearing");
                        var m = function () {
                            clearInterval(e.__tracker), e._trigger({
                                type: "closing",
                                event: b
                            }), e._$tooltip.off("." + e.__namespace + "-triggerClose").removeClass("tooltipster-dying"), a(h.window).off("." + e.__namespace + "-triggerClose"), e.__$originParents.each(function (b, c) {
                                a(c).off("scroll." + e.__namespace + "-triggerClose")
                            }), e.__$originParents = null, a(h.window.document.body).off("." + e.__namespace + "-triggerClose"), e._$origin.off("." + e.__namespace + "-triggerClose"), e._off("dismissable"), e.__stateSet("closed"), e._trigger({
                                type: "after",
                                event: b
                            }), e.__options.functionAfter && e.__options.functionAfter.call(e, e, {
                                event: b,
                                origin: e._$origin[0]
                            }), g()
                        };
                        h.hasTransitions ? (e._$tooltip.css({
                            "-moz-animation-duration": e.__options.animationDuration[1] + "ms",
                            "-ms-animation-duration": e.__options.animationDuration[1] + "ms",
                            "-o-animation-duration": e.__options.animationDuration[1] + "ms",
                            "-webkit-animation-duration": e.__options.animationDuration[1] + "ms",
                            "animation-duration": e.__options.animationDuration[1] + "ms",
                            "transition-duration": e.__options.animationDuration[1] + "ms"
                        }), e._$tooltip.clearQueue().removeClass("tooltipster-show").addClass("tooltipster-dying"), e.__options.animationDuration[1] > 0 && e._$tooltip.delay(e.__options.animationDuration[1]), e._$tooltip.queue(m)) : e._$tooltip.stop().fadeOut(e.__options.animationDuration[1], m)
                    }
                } else g()
            }
            return e
        }, _off: function () {
            return this.__$emitterPrivate.off.apply(this.__$emitterPrivate, Array.prototype.slice.apply(arguments)), this
        }, _on: function () {
            return this.__$emitterPrivate.on.apply(this.__$emitterPrivate, Array.prototype.slice.apply(arguments)), this
        }, _one: function () {
            return this.__$emitterPrivate.one.apply(this.__$emitterPrivate, Array.prototype.slice.apply(arguments)), this
        }, _open: function (b, c) {
            var e = this;
            if (!e.__destroying && d(e._$origin) && e.__enabled) {
                var f = !0;
                if ("closed" == e.__state && (e._trigger({
                    type: "before", event: b, stop: function () {
                        f = !1
                    }
                }), f && e.__options.functionBefore && (f = e.__options.functionBefore.call(e, e, {
                    event: b,
                    origin: e._$origin[0]
                }))), f !== !1 && null !== e.__Content) {
                    c && e.__callbacks.open.push(c), e.__callbacks.close = [], e.__timeoutsClear();
                    var g, i = function () {
                        "stable" != e.__state && e.__stateSet("stable"), a.each(e.__callbacks.open, function (a, b) {
                            b.call(e, e, {origin: e._$origin[0], tooltip: e._$tooltip[0]})
                        }), e.__callbacks.open = []
                    };
                    if ("closed" !== e.__state) g = 0, "disappearing" === e.__state ? (e.__stateSet("appearing"), h.hasTransitions ? (e._$tooltip.clearQueue().removeClass("tooltipster-dying").addClass("tooltipster-show"), e.__options.animationDuration[0] > 0 && e._$tooltip.delay(e.__options.animationDuration[0]), e._$tooltip.queue(i)) : e._$tooltip.stop().fadeIn(i)) : "stable" == e.__state && i(); else {
                        if (e.__stateSet("appearing"), g = e.__options.animationDuration[0], e.__contentInsert(), e.reposition(b, !0), h.hasTransitions ? (e._$tooltip.addClass("tooltipster-" + e.__options.animation).addClass("tooltipster-initial").css({
                            "-moz-animation-duration": e.__options.animationDuration[0] + "ms",
                            "-ms-animation-duration": e.__options.animationDuration[0] + "ms",
                            "-o-animation-duration": e.__options.animationDuration[0] + "ms",
                            "-webkit-animation-duration": e.__options.animationDuration[0] + "ms",
                            "animation-duration": e.__options.animationDuration[0] + "ms",
                            "transition-duration": e.__options.animationDuration[0] + "ms"
                        }), setTimeout(function () {
                            "closed" != e.__state && (e._$tooltip.addClass("tooltipster-show").removeClass("tooltipster-initial"), e.__options.animationDuration[0] > 0 && e._$tooltip.delay(e.__options.animationDuration[0]), e._$tooltip.queue(i))
                        }, 0)) : e._$tooltip.css("display", "none").fadeIn(e.__options.animationDuration[0], i), e.__trackerStart(), a(h.window).on("resize." + e.__namespace + "-triggerClose", function (b) {
                            var c = a(document.activeElement);
                            (c.is("input") || c.is("textarea")) && a.contains(e._$tooltip[0], c[0]) || e.reposition(b)
                        }).on("scroll." + e.__namespace + "-triggerClose", function (a) {
                            e.__scrollHandler(a)
                        }), e.__$originParents = e._$origin.parents(), e.__$originParents.each(function (b, c) {
                            a(c).on("scroll." + e.__namespace + "-triggerClose", function (a) {
                                e.__scrollHandler(a)
                            })
                        }), e.__options.triggerClose.mouseleave || e.__options.triggerClose.touchleave && h.hasTouchCapability) {
                            e._on("dismissable", function (a) {
                                a.dismissable ? a.delay ? (m = setTimeout(function () {
                                    e._close(a.event)
                                }, a.delay), e.__timeouts.close.push(m)) : e._close(a) : clearTimeout(m)
                            });
                            var j = e._$origin, k = "", l = "", m = null;
                            e.__options.interactive && (j = j.add(e._$tooltip)), e.__options.triggerClose.mouseleave && (k += "mouseenter." + e.__namespace + "-triggerClose ", l += "mouseleave." + e.__namespace + "-triggerClose "), e.__options.triggerClose.touchleave && h.hasTouchCapability && (k += "touchstart." + e.__namespace + "-triggerClose", l += "touchend." + e.__namespace + "-triggerClose touchcancel." + e.__namespace + "-triggerClose"), j.on(l, function (a) {
                                if (e._touchIsTouchEvent(a) || !e._touchIsEmulatedEvent(a)) {
                                    var b = "mouseleave" == a.type ? e.__options.delay : e.__options.delayTouch;
                                    e._trigger({delay: b[1], dismissable: !0, event: a, type: "dismissable"})
                                }
                            }).on(k, function (a) {
                                !e._touchIsTouchEvent(a) && e._touchIsEmulatedEvent(a) || e._trigger({
                                    dismissable: !1,
                                    event: a,
                                    type: "dismissable"
                                })
                            })
                        }
                        e.__options.triggerClose.originClick && e._$origin.on("click." + e.__namespace + "-triggerClose", function (a) {
                            e._touchIsTouchEvent(a) || e._touchIsEmulatedEvent(a) || e._close(a)
                        }), (e.__options.triggerClose.click || e.__options.triggerClose.tap && h.hasTouchCapability) && setTimeout(function () {
                            if ("closed" != e.__state) {
                                var b = "", c = a(h.window.document.body);
                                e.__options.triggerClose.click && (b += "click." + e.__namespace + "-triggerClose "), e.__options.triggerClose.tap && h.hasTouchCapability && (b += "touchend." + e.__namespace + "-triggerClose"), c.on(b, function (b) {
                                    e._touchIsMeaningfulEvent(b) && (e._touchRecordEvent(b), e.__options.interactive && a.contains(e._$tooltip[0], b.target) || e._close(b))
                                }), e.__options.triggerClose.tap && h.hasTouchCapability && c.on("touchstart." + e.__namespace + "-triggerClose", function (a) {
                                    e._touchRecordEvent(a)
                                })
                            }
                        }, 0), e._trigger("ready"), e.__options.functionReady && e.__options.functionReady.call(e, e, {
                            origin: e._$origin[0],
                            tooltip: e._$tooltip[0]
                        })
                    }
                    if (e.__options.timer > 0) {
                        var m = setTimeout(function () {
                            e._close()
                        }, e.__options.timer + g);
                        e.__timeouts.close.push(m)
                    }
                }
            }
            return e
        }, _openShortly: function (a) {
            var b = this, c = !0;
            if ("stable" != b.__state && "appearing" != b.__state && !b.__timeouts.open && (b._trigger({
                type: "start",
                event: a,
                stop: function () {
                    c = !1
                }
            }), c)) {
                var d = 0 == a.type.indexOf("touch") ? b.__options.delayTouch : b.__options.delay;
                d[0] ? b.__timeouts.open = setTimeout(function () {
                    b.__timeouts.open = null, b.__pointerIsOverOrigin && b._touchIsMeaningfulEvent(a) ? (b._trigger("startend"), b._open(a)) : b._trigger("startcancel")
                }, d[0]) : (b._trigger("startend"), b._open(a))
            }
            return b
        }, _optionsExtract: function (b, c) {
            var d = this, e = a.extend(!0, {}, c), f = d.__options[b];
            return f || (f = {}, a.each(c, function (a, b) {
                var c = d.__options[a];
                void 0 !== c && (f[a] = c)
            })), a.each(e, function (b, c) {
                void 0 !== f[b] && ("object" != typeof c || c instanceof Array || null == c || "object" != typeof f[b] || f[b] instanceof Array || null == f[b] ? e[b] = f[b] : a.extend(e[b], f[b]))
            }), e
        }, _plug: function (b) {
            var c = a.tooltipster._plugin(b);
            if (!c) throw new Error('The "' + b + '" plugin is not defined');
            return c.instance && a.tooltipster.__bridge(c.instance, this, c.name), this
        }, _touchIsEmulatedEvent: function (a) {
            for (var b = !1, c = (new Date).getTime(), d = this.__touchEvents.length - 1; d >= 0; d--) {
                var e = this.__touchEvents[d];
                if (!(c - e.time < 500)) break;
                e.target === a.target && (b = !0)
            }
            return b
        }, _touchIsMeaningfulEvent: function (a) {
            return this._touchIsTouchEvent(a) && !this._touchSwiped(a.target) || !this._touchIsTouchEvent(a) && !this._touchIsEmulatedEvent(a)
        }, _touchIsTouchEvent: function (a) {
            return 0 == a.type.indexOf("touch")
        }, _touchRecordEvent: function (a) {
            return this._touchIsTouchEvent(a) && (a.time = (new Date).getTime(), this.__touchEvents.push(a)), this
        }, _touchSwiped: function (a) {
            for (var b = !1, c = this.__touchEvents.length - 1; c >= 0; c--) {
                var d = this.__touchEvents[c];
                if ("touchmove" == d.type) {
                    b = !0;
                    break
                }
                if ("touchstart" == d.type && a === d.target) break
            }
            return b
        }, _trigger: function () {
            var b = Array.prototype.slice.apply(arguments);
            return "string" == typeof b[0] && (b[0] = {type: b[0]}), b[0].instance = this, b[0].origin = this._$origin ? this._$origin[0] : null, b[0].tooltip = this._$tooltip ? this._$tooltip[0] : null, this.__$emitterPrivate.trigger.apply(this.__$emitterPrivate, b), a.tooltipster._trigger.apply(a.tooltipster, b), this.__$emitterPublic.trigger.apply(this.__$emitterPublic, b), this
        }, _unplug: function (b) {
            var c = this;
            if (c[b]) {
                var d = a.tooltipster._plugin(b);
                d.instance && a.each(d.instance, function (a, d) {
                    c[a] && c[a].bridged === c[b] && delete c[a]
                }), c[b].__destroy && c[b].__destroy(), delete c[b]
            }
            return c
        }, close: function (a) {
            return this.__destroyed ? this.__destroyError() : this._close(null, a), this
        }, content: function (a) {
            var b = this;
            if (void 0 === a) return b.__Content;
            if (b.__destroyed) b.__destroyError(); else if (b.__contentSet(a), null !== b.__Content) {
                if ("closed" !== b.__state && (b.__contentInsert(), b.reposition(), b.__options.updateAnimation)) if (h.hasTransitions) {
                    var c = b.__options.updateAnimation;
                    b._$tooltip.addClass("tooltipster-update-" + c), setTimeout(function () {
                        "closed" != b.__state && b._$tooltip.removeClass("tooltipster-update-" + c)
                    }, 1e3)
                } else b._$tooltip.fadeTo(200, .5, function () {
                    "closed" != b.__state && b._$tooltip.fadeTo(200, 1)
                })
            } else b._close();
            return b
        }, destroy: function () {
            var b = this;
            if (b.__destroyed) b.__destroyError(); else {
                "closed" != b.__state ? b.option("animationDuration", 0)._close(null, null, !0) : b.__timeoutsClear(), b._trigger("destroy"), b.__destroyed = !0, b._$origin.removeData(b.__namespace).off("." + b.__namespace + "-triggerOpen"), a(h.window.document.body).off("." + b.__namespace + "-triggerOpen");
                var c = b._$origin.data("tooltipster-ns");
                if (c) if (1 === c.length) {
                    var d = null;
                    "previous" == b.__options.restoration ? d = b._$origin.data("tooltipster-initialTitle") : "current" == b.__options.restoration && (d = "string" == typeof b.__Content ? b.__Content : a("<div></div>").append(b.__Content).html()), d && b._$origin.attr("title", d), b._$origin.removeClass("tooltipstered"), b._$origin.removeData("tooltipster-ns").removeData("tooltipster-initialTitle")
                } else c = a.grep(c, function (a, c) {
                    return a !== b.__namespace
                }), b._$origin.data("tooltipster-ns", c);
                b._trigger("destroyed"), b._off(), b.off(), b.__Content = null, b.__$emitterPrivate = null, b.__$emitterPublic = null, b.__options.parent = null, b._$origin = null, b._$tooltip = null, a.tooltipster.__instancesLatestArr = a.grep(a.tooltipster.__instancesLatestArr, function (a, c) {
                    return b !== a
                }), clearInterval(b.__garbageCollector)
            }
            return b
        }, disable: function () {
            return this.__destroyed ? (this.__destroyError(), this) : (this._close(), this.__enabled = !1, this)
        }, elementOrigin: function () {
            return this.__destroyed ? void this.__destroyError() : this._$origin[0]
        }, elementTooltip: function () {
            return this._$tooltip ? this._$tooltip[0] : null
        }, enable: function () {
            return this.__enabled = !0, this
        }, hide: function (a) {
            return this.close(a)
        }, instance: function () {
            return this
        }, off: function () {
            return this.__destroyed || this.__$emitterPublic.off.apply(this.__$emitterPublic, Array.prototype.slice.apply(arguments)), this
        }, on: function () {
            return this.__destroyed ? this.__destroyError() : this.__$emitterPublic.on.apply(this.__$emitterPublic, Array.prototype.slice.apply(arguments)), this
        }, one: function () {
            return this.__destroyed ? this.__destroyError() : this.__$emitterPublic.one.apply(this.__$emitterPublic, Array.prototype.slice.apply(arguments)), this
        }, open: function (a) {
            return this.__destroyed ? this.__destroyError() : this._open(null, a), this
        }, option: function (b, c) {
            return void 0 === c ? this.__options[b] : (this.__destroyed ? this.__destroyError() : (this.__options[b] = c, this.__optionsFormat(), a.inArray(b, ["trigger", "triggerClose", "triggerOpen"]) >= 0 && this.__prepareOrigin(), "selfDestruction" === b && this.__prepareGC()), this)
        }, reposition: function (a, b) {
            var c = this;
            return c.__destroyed ? c.__destroyError() : "closed" != c.__state && d(c._$origin) && (b || d(c._$tooltip)) && (b || c._$tooltip.detach(), c.__Geometry = c.__geometry(), c._trigger({
                type: "reposition",
                event: a,
                helper: {geo: c.__Geometry}
            })), c
        }, show: function (a) {
            return this.open(a)
        }, status: function () {
            return {
                destroyed: this.__destroyed,
                enabled: this.__enabled,
                open: "closed" !== this.__state,
                state: this.__state
            }
        }, triggerHandler: function () {
            return this.__destroyed ? this.__destroyError() : this.__$emitterPublic.triggerHandler.apply(this.__$emitterPublic, Array.prototype.slice.apply(arguments)), this
        }
    }, a.fn.tooltipster = function () {
        var b = Array.prototype.slice.apply(arguments),
            c = "You are using a single HTML element as content for several tooltips. You probably want to set the contentCloning option to TRUE.";
        if (0 === this.length) return this;
        if ("string" == typeof b[0]) {
            var d = "#*$~&";
            return this.each(function () {
                var e = a(this).data("tooltipster-ns"), f = e ? a(this).data(e[0]) : null;
                if (!f) throw new Error("You called Tooltipster's \"" + b[0] + '" method on an uninitialized element');
                if ("function" != typeof f[b[0]]) throw new Error('Unknown method "' + b[0] + '"');
                this.length > 1 && "content" == b[0] && (b[1] instanceof a || "object" == typeof b[1] && null != b[1] && b[1].tagName) && !f.__options.contentCloning && f.__options.debug && console.log(c);
                var g = f[b[0]](b[1], b[2]);
                return g !== f || "instance" === b[0] ? (d = g, !1) : void 0
            }), "#*$~&" !== d ? d : this
        }
        a.tooltipster.__instancesLatestArr = [];
        var e = b[0] && void 0 !== b[0].multiple, g = e && b[0].multiple || !e && f.multiple,
            h = b[0] && void 0 !== b[0].content, i = h && b[0].content || !h && f.content,
            j = b[0] && void 0 !== b[0].contentCloning, k = j && b[0].contentCloning || !j && f.contentCloning,
            l = b[0] && void 0 !== b[0].debug, m = l && b[0].debug || !l && f.debug;
        return this.length > 1 && (i instanceof a || "object" == typeof i && null != i && i.tagName) && !k && m && console.log(c), this.each(function () {
            var c = !1, d = a(this), e = d.data("tooltipster-ns"), f = null;
            e ? g ? c = !0 : m && (console.log("Tooltipster: one or more tooltips are already attached to the element below. Ignoring."), console.log(this)) : c = !0, c && (f = new a.Tooltipster(this, b[0]), e || (e = []), e.push(f.__namespace), d.data("tooltipster-ns", e), d.data(f.__namespace, f), f.__options.functionInit && f.__options.functionInit.call(f, f, {origin: this}), f._trigger("init")), a.tooltipster.__instancesLatestArr.push(f)
        }), this
    }, b.prototype = {
        __init: function (b) {
            this.__$tooltip = b, this.__$tooltip.css({
                left: 0,
                overflow: "hidden",
                position: "absolute",
                top: 0
            }).find(".tooltipster-content").css("overflow", "auto"), this.$container = a('<div class="tooltipster-ruler"></div>').append(this.__$tooltip).appendTo(h.window.document.body)
        }, __forceRedraw: function () {
            var a = this.__$tooltip.parent();
            this.__$tooltip.detach(), this.__$tooltip.appendTo(a)
        }, constrain: function (a, b) {
            return this.constraints = {width: a, height: b}, this.__$tooltip.css({
                display: "block",
                height: "",
                overflow: "auto",
                width: a
            }), this
        }, destroy: function () {
            this.__$tooltip.detach().find(".tooltipster-content").css({
                display: "",
                overflow: ""
            }), this.$container.remove()
        }, free: function () {
            return this.constraints = null, this.__$tooltip.css({
                display: "",
                height: "",
                overflow: "visible",
                width: ""
            }), this
        }, measure: function () {
            this.__forceRedraw();
            var a = this.__$tooltip[0].getBoundingClientRect(),
                b = {size: {height: a.height || a.bottom - a.top, width: a.width || a.right - a.left}};
            if (this.constraints) {
                var c = this.__$tooltip.find(".tooltipster-content"), d = this.__$tooltip.outerHeight(),
                    e = c[0].getBoundingClientRect(), f = {
                        height: d <= this.constraints.height,
                        width: a.width <= this.constraints.width && e.width >= c[0].scrollWidth - 1
                    };
                b.fits = f.height && f.width
            }
            return h.IE && h.IE <= 11 && b.size.width !== h.window.document.documentElement.clientWidth && (b.size.width = Math.ceil(b.size.width) + 1), b
        }
    };
    var j = navigator.userAgent.toLowerCase();
    -1 != j.indexOf("msie") ? h.IE = parseInt(j.split("msie")[1]) : -1 !== j.toLowerCase().indexOf("trident") && -1 !== j.indexOf(" rv:11") ? h.IE = 11 : -1 != j.toLowerCase().indexOf("edge/") && (h.IE = parseInt(j.toLowerCase().split("edge/")[1]));
    var k = "tooltipster.sideTip";
    return a.tooltipster._plugin({
        name: k, instance: {
            __defaults: function () {
                return {
                    arrow: !0,
                    distance: 6,
                    functionPosition: null,
                    maxWidth: null,
                    minIntersection: 16,
                    minWidth: 0,
                    position: null,
                    side: "top",
                    viewportAware: !0
                }
            }, __init: function (a) {
                var b = this;
                b.__instance = a, b.__namespace = "tooltipster-sideTip-" + Math.round(1e6 * Math.random()), b.__previousState = "closed", b.__options, b.__optionsFormat(), b.__instance._on("state." + b.__namespace, function (a) {
                    "closed" == a.state ? b.__close() : "appearing" == a.state && "closed" == b.__previousState && b.__create(), b.__previousState = a.state
                }), b.__instance._on("options." + b.__namespace, function () {
                    b.__optionsFormat()
                }), b.__instance._on("reposition." + b.__namespace, function (a) {
                    b.__reposition(a.event, a.helper)
                })
            }, __close: function () {
                this.__instance.content() instanceof a && this.__instance.content().detach(), this.__instance._$tooltip.remove(), this.__instance._$tooltip = null
            }, __create: function () {
                var b = a('<div class="tooltipster-base tooltipster-sidetip"><div class="tooltipster-box"><div class="tooltipster-content"></div></div><div class="tooltipster-arrow"><div class="tooltipster-arrow-uncropped"><div class="tooltipster-arrow-border"></div><div class="tooltipster-arrow-background"></div></div></div></div>');
                this.__options.arrow || b.find(".tooltipster-box").css("margin", 0).end().find(".tooltipster-arrow").hide(), this.__options.minWidth && b.css("min-width", this.__options.minWidth + "px"), this.__options.maxWidth && b.css("max-width", this.__options.maxWidth + "px"),
                    this.__instance._$tooltip = b, this.__instance._trigger("created")
            }, __destroy: function () {
                this.__instance._off("." + self.__namespace)
            }, __optionsFormat: function () {
                var b = this;
                if (b.__options = b.__instance._optionsExtract(k, b.__defaults()), b.__options.position && (b.__options.side = b.__options.position), "object" != typeof b.__options.distance && (b.__options.distance = [b.__options.distance]), b.__options.distance.length < 4 && (void 0 === b.__options.distance[1] && (b.__options.distance[1] = b.__options.distance[0]), void 0 === b.__options.distance[2] && (b.__options.distance[2] = b.__options.distance[0]), void 0 === b.__options.distance[3] && (b.__options.distance[3] = b.__options.distance[1]), b.__options.distance = {
                    top: b.__options.distance[0],
                    right: b.__options.distance[1],
                    bottom: b.__options.distance[2],
                    left: b.__options.distance[3]
                }), "string" == typeof b.__options.side) {
                    var c = {top: "bottom", right: "left", bottom: "top", left: "right"};
                    b.__options.side = [b.__options.side, c[b.__options.side]], "left" == b.__options.side[0] || "right" == b.__options.side[0] ? b.__options.side.push("top", "bottom") : b.__options.side.push("right", "left")
                }
                6 === a.tooltipster._env.IE && b.__options.arrow !== !0 && (b.__options.arrow = !1)
            }, __reposition: function (b, c) {
                var d, e = this, f = e.__targetFind(c), g = [];
                e.__instance._$tooltip.detach();
                var h = e.__instance._$tooltip.clone(), i = a.tooltipster._getRuler(h), j = !1,
                    k = e.__instance.option("animation");
                switch (k && h.removeClass("tooltipster-" + k), a.each(["window", "document"], function (d, k) {
                    var l = null;
                    if (e.__instance._trigger({
                        container: k, helper: c, satisfied: j, takeTest: function (a) {
                            l = a
                        }, results: g, type: "positionTest"
                    }), 1 == l || 0 != l && 0 == j && ("window" != k || e.__options.viewportAware)) for (var d = 0; d < e.__options.side.length; d++) {
                        var m = {horizontal: 0, vertical: 0}, n = e.__options.side[d];
                        "top" == n || "bottom" == n ? m.vertical = e.__options.distance[n] : m.horizontal = e.__options.distance[n], e.__sideChange(h, n), a.each(["natural", "constrained"], function (a, d) {
                            if (l = null, e.__instance._trigger({
                                container: k,
                                event: b,
                                helper: c,
                                mode: d,
                                results: g,
                                satisfied: j,
                                side: n,
                                takeTest: function (a) {
                                    l = a
                                },
                                type: "positionTest"
                            }), 1 == l || 0 != l && 0 == j) {
                                var h = {
                                        container: k,
                                        distance: m,
                                        fits: null,
                                        mode: d,
                                        outerSize: null,
                                        side: n,
                                        size: null,
                                        target: f[n],
                                        whole: null
                                    },
                                    o = "natural" == d ? i.free() : i.constrain(c.geo.available[k][n].width - m.horizontal, c.geo.available[k][n].height - m.vertical),
                                    p = o.measure();
                                if (h.size = p.size, h.outerSize = {
                                    height: p.size.height + m.vertical,
                                    width: p.size.width + m.horizontal
                                }, "natural" == d ? c.geo.available[k][n].width >= h.outerSize.width && c.geo.available[k][n].height >= h.outerSize.height ? h.fits = !0 : h.fits = !1 : h.fits = p.fits, "window" == k && (h.fits ? "top" == n || "bottom" == n ? h.whole = c.geo.origin.windowOffset.right >= e.__options.minIntersection && c.geo.window.size.width - c.geo.origin.windowOffset.left >= e.__options.minIntersection : h.whole = c.geo.origin.windowOffset.bottom >= e.__options.minIntersection && c.geo.window.size.height - c.geo.origin.windowOffset.top >= e.__options.minIntersection : h.whole = !1), g.push(h), h.whole) j = !0; else if ("natural" == h.mode && (h.fits || h.size.width <= c.geo.available[k][n].width)) return !1
                            }
                        })
                    }
                }), e.__instance._trigger({
                    edit: function (a) {
                        g = a
                    }, event: b, helper: c, results: g, type: "positionTested"
                }), g.sort(function (a, b) {
                    if (a.whole && !b.whole) return -1;
                    if (!a.whole && b.whole) return 1;
                    if (a.whole && b.whole) {
                        var c = e.__options.side.indexOf(a.side), d = e.__options.side.indexOf(b.side);
                        return d > c ? -1 : c > d ? 1 : "natural" == a.mode ? -1 : 1
                    }
                    if (a.fits && !b.fits) return -1;
                    if (!a.fits && b.fits) return 1;
                    if (a.fits && b.fits) {
                        var c = e.__options.side.indexOf(a.side), d = e.__options.side.indexOf(b.side);
                        return d > c ? -1 : c > d ? 1 : "natural" == a.mode ? -1 : 1
                    }
                    return "document" == a.container && "bottom" == a.side && "natural" == a.mode ? -1 : 1
                }), d = g[0], d.coord = {}, d.side) {
                    case"left":
                    case"right":
                        d.coord.top = Math.floor(d.target - d.size.height / 2);
                        break;
                    case"bottom":
                    case"top":
                        d.coord.left = Math.floor(d.target - d.size.width / 2)
                }
                switch (d.side) {
                    case"left":
                        d.coord.left = c.geo.origin.windowOffset.left - d.outerSize.width;
                        break;
                    case"right":
                        d.coord.left = c.geo.origin.windowOffset.right + d.distance.horizontal;
                        break;
                    case"top":
                        d.coord.top = c.geo.origin.windowOffset.top - d.outerSize.height;
                        break;
                    case"bottom":
                        d.coord.top = c.geo.origin.windowOffset.bottom + d.distance.vertical
                }
                "window" == d.container ? "top" == d.side || "bottom" == d.side ? d.coord.left < 0 ? c.geo.origin.windowOffset.right - this.__options.minIntersection >= 0 ? d.coord.left = 0 : d.coord.left = c.geo.origin.windowOffset.right - this.__options.minIntersection - 1 : d.coord.left > c.geo.window.size.width - d.size.width && (c.geo.origin.windowOffset.left + this.__options.minIntersection <= c.geo.window.size.width ? d.coord.left = c.geo.window.size.width - d.size.width : d.coord.left = c.geo.origin.windowOffset.left + this.__options.minIntersection + 1 - d.size.width) : d.coord.top < 0 ? c.geo.origin.windowOffset.bottom - this.__options.minIntersection >= 0 ? d.coord.top = 0 : d.coord.top = c.geo.origin.windowOffset.bottom - this.__options.minIntersection - 1 : d.coord.top > c.geo.window.size.height - d.size.height && (c.geo.origin.windowOffset.top + this.__options.minIntersection <= c.geo.window.size.height ? d.coord.top = c.geo.window.size.height - d.size.height : d.coord.top = c.geo.origin.windowOffset.top + this.__options.minIntersection + 1 - d.size.height) : (d.coord.left > c.geo.window.size.width - d.size.width && (d.coord.left = c.geo.window.size.width - d.size.width), d.coord.left < 0 && (d.coord.left = 0)), e.__sideChange(h, d.side), c.tooltipClone = h[0], c.tooltipParent = e.__instance.option("parent").parent[0], c.mode = d.mode, c.whole = d.whole, c.origin = e.__instance._$origin[0], c.tooltip = e.__instance._$tooltip[0], delete d.container, delete d.fits, delete d.mode, delete d.outerSize, delete d.whole, d.distance = d.distance.horizontal || d.distance.vertical;
                var l = a.extend(!0, {}, d);
                if (e.__instance._trigger({
                    edit: function (a) {
                        d = a
                    }, event: b, helper: c, position: l, type: "position"
                }), e.__options.functionPosition) {
                    var m = e.__options.functionPosition.call(e, e.__instance, c, l);
                    m && (d = m)
                }
                i.destroy();
                var n, o;
                "top" == d.side || "bottom" == d.side ? (n = {
                    prop: "left",
                    val: d.target - d.coord.left
                }, o = d.size.width - this.__options.minIntersection) : (n = {
                    prop: "top",
                    val: d.target - d.coord.top
                }, o = d.size.height - this.__options.minIntersection), n.val < this.__options.minIntersection ? n.val = this.__options.minIntersection : n.val > o && (n.val = o);
                var p;
                p = c.geo.origin.fixedLineage ? c.geo.origin.windowOffset : {
                    left: c.geo.origin.windowOffset.left + c.geo.window.scroll.left,
                    top: c.geo.origin.windowOffset.top + c.geo.window.scroll.top
                }, d.coord = {
                    left: p.left + (d.coord.left - c.geo.origin.windowOffset.left),
                    top: p.top + (d.coord.top - c.geo.origin.windowOffset.top)
                }, e.__sideChange(e.__instance._$tooltip, d.side), c.geo.origin.fixedLineage ? e.__instance._$tooltip.css("position", "fixed") : e.__instance._$tooltip.css("position", ""), e.__instance._$tooltip.css({
                    left: d.coord.left,
                    top: d.coord.top,
                    height: d.size.height,
                    width: d.size.width
                }).find(".tooltipster-arrow").css({
                    left: "",
                    top: ""
                }).css(n.prop, n.val), e.__instance._$tooltip.appendTo(e.__instance.option("parent")), e.__instance._trigger({
                    type: "repositioned",
                    event: b,
                    position: d
                })
            }, __sideChange: function (a, b) {
                a.removeClass("tooltipster-bottom").removeClass("tooltipster-left").removeClass("tooltipster-right").removeClass("tooltipster-top").addClass("tooltipster-" + b)
            }, __targetFind: function (a) {
                var b = {}, c = this.__instance._$origin[0].getClientRects();
                if (c.length > 1) {
                    var d = this.__instance._$origin.css("opacity");
                    1 == d && (this.__instance._$origin.css("opacity", .99), c = this.__instance._$origin[0].getClientRects(), this.__instance._$origin.css("opacity", 1))
                }
                if (c.length < 2) b.top = Math.floor(a.geo.origin.windowOffset.left + a.geo.origin.size.width / 2), b.bottom = b.top, b.left = Math.floor(a.geo.origin.windowOffset.top + a.geo.origin.size.height / 2), b.right = b.left; else {
                    var e = c[0];
                    b.top = Math.floor(e.left + (e.right - e.left) / 2), e = c.length > 2 ? c[Math.ceil(c.length / 2) - 1] : c[0], b.right = Math.floor(e.top + (e.bottom - e.top) / 2), e = c[c.length - 1], b.bottom = Math.floor(e.left + (e.right - e.left) / 2), e = c.length > 2 ? c[Math.ceil((c.length + 1) / 2) - 1] : c[c.length - 1], b.left = Math.floor(e.top + (e.bottom - e.top) / 2)
                }
                return b
            }
        }
    }), a
});
/* tooltipster-follower v0.1.5 */
!function (a, b) {
    "function" == typeof define && define.amd ? define(["tooltipster"], function (a) {
        return b(a)
    }) : "object" == typeof exports ? module.exports = b(require("tooltipster")) : b(jQuery)
}(this, function (a) {
    var b = "laa.follower";
    return a.tooltipster._plugin({
        name: b, instance: {
            __defaults: function () {
                return {anchor: "top-left", maxWidth: null, minWidth: 0, offset: [15, -15]}
            }, __init: function (a) {
                var b = this;
                return b.__displayed, b.__helper, b.__initialROS = a.option("repositionOnScroll"), b.__instance = a, b.__latestMouseEvent, b.__namespace = "tooltipster-follower-" + Math.round(1e6 * Math.random()), b.__openingTouchEnded, b.__pointerPosition, b.__previousState = "closed", b.__size, b.__options, b.__initialROS || b.__instance.option("repositionOnScroll", !0), b.__optionsFormat(), b.__instance._on("destroy." + b.__namespace, function () {
                    b.__destroy()
                }), b.__instance._on("options." + b.__namespace, function () {
                    b.__optionsFormat()
                }), b.__instance._on("reposition." + b.__namespace, function (a) {
                    b.__reposition(a.event, a.helper)
                }), b.__instance._on("start." + b.__namespace, function (a) {
                    b.__instance._$origin.on("mousemove." + b.__namespace, function (a) {
                        b.__latestMouseEvent = a
                    })
                }), b.__instance._one("startend." + b.__namespace + " startcancel." + b.__namespace, function (a) {
                    b.__instance._$origin.off("mousemove." + b.__namespace), "startcancel" == a.type && (b.__latestMouseEvent = null)
                }), b.__instance._on("state." + b.__namespace, function (a) {
                    "closed" == a.state ? b.__close() : "appearing" == a.state && "closed" == b.__previousState && b.__create(), b.__previousState = a.state
                }), b
            }, __close: function () {
                return "object" == typeof this.__instance.content() && null !== this.__instance.content() && this.__instance.content().detach(), this.__instance._$tooltip.remove(), this.__instance._$tooltip = null, a(a.tooltipster._env.window.document).off("." + this.__namespace), this.__latestMouseEvent = null, this
            }, __create: function () {
                var b = this,
                    c = a('<div class="tooltipster-base tooltipster-follower"><div class="tooltipster-box"><div class="tooltipster-content"></div></div></div>'),
                    d = a(a.tooltipster._env.window.document);
                b.__options.minWidth && c.css("min-width", b.__options.minWidth + "px"), b.__options.maxWidth && c.css("max-width", b.__options.maxWidth + "px"), b.__instance._$tooltip = c, b.__displayed = !1, b.__openingTouchEnded = !1, d.on("mousemove." + b.__namespace, function (a) {
                    b.__openingTouchEnded && b.__displayed || b.__follow(a)
                });
                var e = b.__instance.option("triggerClose");
                return e.tap && d.on("touchend." + b.__namespace + " touchcancel." + b.__namespace, function (a) {
                    b.__openingTouchEnded = !0
                }), b.__instance._trigger("created"), b
            }, __destroy: function () {
                return this.__instance._off("." + this.__namespace), this.__initialROS || this.__instance.option("repositionOnScroll", !1), this
            }, __follow: function (b) {
                if (b ? this.__latestMouseEvent = b : this.__latestMouseEvent && (b = this.__latestMouseEvent), b) {
                    this.__displayed = !0;
                    var c = {}, d = this.__options.anchor, e = a.merge([], this.__options.offset);
                    switch (this.__helper.geo.window.scroll = {
                        left: a.tooltipster._env.window.scrollX || a.tooltipster._env.window.document.documentElement.scrollLeft,
                        top: a.tooltipster._env.window.scrollY || a.tooltipster._env.window.document.documentElement.scrollTop
                    }, d) {
                        case"top-left":
                        case"left-center":
                        case"bottom-left":
                            c.left = b.pageX + e[0];
                            break;
                        case"top-center":
                        case"bottom-center":
                            c.left = b.pageX + e[0] - this.__size.width / 2;
                            break;
                        case"top-right":
                        case"right-center":
                        case"bottom-right":
                            c.left = b.pageX + e[0] - this.__size.width;
                            break;
                        default:
                            console.log("Wrong anchor value")
                    }
                    switch (d) {
                        case"top-left":
                        case"top-center":
                        case"top-right":
                            c.top = b.pageY - e[1];
                            break;
                        case"left-center":
                        case"right-center":
                            c.top = b.pageY - e[1] - this.__size.height / 2;
                            break;
                        case"bottom-left":
                        case"bottom-center":
                        case"bottom-right":
                            c.top = b.pageY - e[1] - this.__size.height
                    }
                    if ("left-center" == d || "right-center" == d) {
                        if ("right-center" == d) c.left < this.__helper.geo.window.scroll.left && (b.pageX - e[0] + this.__size.width <= this.__helper.geo.window.scroll.left + this.__helper.geo.window.size.width ? (d = "left-center", e[0] = -e[0], c.left = b.pageX + e[0]) : (d = "top-right", e[1] = e[0], c = {
                            left: 0,
                            top: b.pageY - e[1]
                        })); else if (c.left + this.__size.width > this.__helper.geo.window.scroll.left + this.__helper.geo.window.size.width) {
                            var f = b.pageX - e[0] - this.__size.width;
                            f >= 0 ? (d = "right-center", e[0] = -e[0], c.left = f) : (d = "top-left", e[1] = -e[0], c = {
                                left: b.pageX + e[0],
                                top: b.pageY - e[1]
                            })
                        }
                        c.top + this.__size.height > this.__helper.geo.window.scroll.top + this.__helper.geo.window.size.height && (c.top = this.__helper.geo.window.scroll.top + this.__helper.geo.window.size.height - this.__size.height), c.top < this.__helper.geo.window.scroll.top && (c.top = this.__helper.geo.window.scroll.top), c.top + this.__size.height > this.__helper.geo.document.size.height && (c.top = this.__helper.geo.document.size.height - this.__size.height), c.top < 0 && (c.top = 0)
                    }
                    if ("left-center" != d && "right-center" != d) {
                        c.left + this.__size.width > this.__helper.geo.window.scroll.left + this.__helper.geo.window.size.width && (c.left = this.__helper.geo.window.scroll.left + this.__helper.geo.window.size.width - this.__size.width), c.left < 0 && (c.left = 0);
                        var g = b.pageY - this.__helper.geo.window.scroll.top;
                        if (0 == d.indexOf("bottom")) c.top < this.__helper.geo.window.scroll.top && (c.top < 0 || g < this.__helper.geo.window.size.height - g && b.pageY + e[1] + this.__size.height <= this.__helper.geo.document.size.height) && (c.top = b.pageY + e[1]); else {
                            var h = c.top + this.__size.height;
                            if (h > this.__helper.geo.window.scroll.top + this.__helper.geo.window.size.height && (g > this.__helper.geo.window.size.height - g || g - e[1] + this.__size.height <= this.__helper.geo.document.size.height)) {
                                var i = b.pageY + e[1] - this.__size.height;
                                i >= 0 && (c.top = i)
                            }
                        }
                    }
                    this.__helper.geo.origin.fixedLineage && (c.left -= this.__helper.geo.window.scroll.left, c.top -= this.__helper.geo.window.scroll.top);
                    var j = {coord: c};
                    this.__instance._trigger({
                        edit: function (a) {
                            j = a
                        }, event: b, helper: this.__helper, position: a.extend(!0, {}, j), type: "follow"
                    }), this.__instance._$tooltip.css({left: j.coord.left, top: j.coord.top}).show()
                } else this.__instance._$tooltip.hide();
                return this
            }, __optionsFormat: function () {
                return this.__options = this.__instance._optionsExtract(b, this.__defaults()), this
            }, __reposition: function (b, c) {
                var d = this, e = d.__instance._$tooltip.clone(), f = a.tooltipster._getRuler(e),
                    g = d.__instance.option("animation");
                g && e.removeClass("tooltipster-" + g);
                var h = f.free().measure(), i = {size: h.size};
                c.geo.origin.fixedLineage ? d.__instance._$tooltip.css("position", "fixed") : d.__instance._$tooltip.css("position", ""), d.__instance._trigger({
                    edit: function (a) {
                        i = a
                    }, event: b, helper: c, position: a.extend(!0, {}, i), tooltipClone: e[0], type: "position"
                }), f.destroy(), d.__helper = c, d.__size = i.size, d.__instance._$tooltip.css({
                    height: i.size.height,
                    width: i.size.width
                });
                var j = a.tooltipster._env.IE && "click" === b.type ? b : null;
                return d.__follow(j), d.__instance._$tooltip.appendTo(d.__instance.option("parent")), d.__instance._trigger({
                    type: "repositioned",
                    event: b,
                    position: {coord: {left: 0, top: 0}, size: i.size}
                }), this
            }
        }
    }), a
});