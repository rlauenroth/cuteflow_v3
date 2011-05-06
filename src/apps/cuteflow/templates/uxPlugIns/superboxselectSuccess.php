Ext.namespace('Ext.ux.form');
/**
 * <p>SuperBoxSelect is an extension of the ComboBox component that displays selected items as labelled boxes within the form field. As seen on facebook, hotmail and other sites.</p>
 * <p>The SuperBoxSelect component was inspired by and based on the BoxSelect component found here: http://efattal.fr/en/extjs/extuxboxselect/</p>
 *
 * @author <a href="mailto:dan.humphrey@technomedia.co.uk">Dan Humphrey</a> created for ******CENSORED******
 * @class Ext.ux.form.SuperBoxSelect
 * @extends Ext.form.ComboBox
 * @constructor
 * @component
 * @version 1.0b1
 * @license Unlikely
 *
 */
Ext.ux.form.SuperBoxSelect = function(config) {
    Ext.ux.form.SuperBoxSelect.superclass.constructor.call(this, config);

    this.addEvents(
        /**
         * Fires before an item is added to the component via user interaction. Return false from the callback function to prevent the item from being added.
         * @event beforeadditem
         * @memberOf Ext.ux.form.SuperBoxSelect
         * @param {SuperBoxSelect} this
         * @param {Mixed} value The value of the item to be added
         */
        'beforeadditem',

        /**
         * Fires after a new item is added to the component.
         * @event additem
         * @memberOf Ext.ux.form.SuperBoxSelect
         * @param {SuperBoxSelect} this
         * @param {Mixed} value The value of the item which was added
         */
        'additem',

        /**
         * Fires when the allowAddNewData config is set to true, and a user attempts to add an item that is not in the data store.
         * @event newitem
         * @memberOf Ext.ux.form.SuperBoxSelect
         * @param {SuperBoxSelect} this
         * @param {Mixed} value The new item's value
         */
        'newitem',

        /**
         * Fires when an item's remove button is clicked. Return false from the callback function to prevent the item from being removed.
         * @event beforeremoveitem
         * @memberOf Ext.ux.form.SuperBoxSelect
         * @param {SuperBoxSelect} this
         * @param {Mixed} value The value of the item to be removed
         */
        'beforeremoveitem',

        /**
         * Fires after an item has been removed.
         * @event removeitem
         * @memberOf Ext.ux.form.SuperBoxSelect
         * @param {SuperBoxSelect} this
         * @param {Mixed} value The value of the item which was removed
         */
        'removeitem'
    );
};

/**
 * @private hide from doc gen
 */
Ext.ux.form.SuperBoxSelect = Ext.extend(Ext.ux.form.SuperBoxSelect, Ext.form.ComboBox, {
    /**
     * @cfg {Boolean} allowAddNewData When set to true, allows items to be added (via the setValueEx and addItem methods) that do not already exist in the data store. Defaults to false.
     */
    allowAddNewData: false,

    /**
     * @cfg {Boolean} backspaceDeletesLastItem When set to false, the BACKSPACE key will focus the last selected item. When set to true, the last item will be immediately deleted. Defaults to true.
     */
    backspaceDeletesLastItem: true,

    /**
     * @cfg {String} classField The underlying data field that will be used to supply an additional class to each item.
     */
    classField: null,

    /**
     * @cfg {String} clearBtnCls An additional class to add to the in-field clear button.
     */
    clearBtnCls: '',

    /**
     * @cfg {String/XTemplate} displayFieldTpl A template for rendering the displayField in each selected item. Defaults to null.
     */
    displayFieldTpl: null,

    /**
     * @cfg {String} extraItemCls An additional css class to apply to each item.
     */
    extraItemCls: '',

    /**
     * @cfg {String/Object/Function} extraItemStyle Additional css style(s) to apply to each item. Should be a valid argument to Ext.Element.applyStyles.
     */
    extraItemStyle: '',

    /**
     * @cfg {String} expandBtnCls An additional class to add to the in-field expand button.
     */
    expandBtnCls: '',

    /**
     * @cfg {Boolean} fixFocusOnTabSelect When set to true, the component will not lose focus when a list item is selected with the TAB key. Defaults to true.
     */
    fixFocusOnTabSelect: true,

    /**
     * @cfg {Boolean} navigateItemsWithTab When set to true the tab key will navigate between selected items. Defaults to true.
     */
    navigateItemsWithTab: true,

    /**
     * @cfg {Boolean} pinList When set to true the select list will be pinned to allow for multiple selections. Defaults to true.
     */
    pinList: true,

    /**
     * @cfg {Boolean} preventDuplicates When set to true unique item values will be enforced. Defaults to true.
     */
    preventDuplicates: true,

    /**
     * @cfg {Boolean} removeValuesFromStore When set to true, selected records will be removed from the store. Defaults to true.
     */
    removeValuesFromStore: true,

    /**
     * @cfg {String} renderFieldBtns When set to true, will render in-field buttons for clearing the component, and displaying the list for selection. Defaults to true.
     */
    renderFieldBtns: true,

    /**
     * @cfg {Boolean} stackItems When set to true, the items will be stacked 1 per line. Defaults to false which displays the items inline.
     */
    stackItems: false,

    /**
     * @cfg {String} styleField The underlying data field that will be used to supply additional css styles to each item.
     */
    styleField : null,

    /**
     * @cfg {String} valueDelimiter The delimiter to use when joining and splitting value arrays and strings.
     */
    valueDelimiter: ',',

    initComponent: function() {
        Ext.apply(this, {
            items           : new Ext.util.MixedCollection(false),
            usedRecords     : new Ext.util.MixedCollection(false),
            hideTrigger     : true,
            grow            : false,
            resizable       : false,
            multiSelectMode : false
        });

        Ext.ux.form.SuperBoxSelect.superclass.initComponent.call(this);
    },

    onRender:function(ct, position) {
        Ext.ux.form.SuperBoxSelect.superclass.onRender.call(this, ct, position);

        var extraClass = (this.stackItems === true) ? 'x-superboxselect-stacked' : '';
        if (this.renderFieldBtns) {
            extraClass += ' x-superboxselect-display-btns';
        }

        this.el.removeClass('x-form-text').addClass('x-superboxselect-input-field');

        this.wrapEl = this.el.wrap({
            tag : 'ul'
        });

        this.outerWrapEl = this.wrapEl.wrap({
            tag : 'div',
            cls: 'x-form-text x-superboxselect ' + extraClass
        });

        this.inputEl = this.el.wrap({
            tag : 'li',
            cls : 'x-superboxselect-input'
        });

        if (this.renderFieldBtns) {
            this.setupFieldButtons();
            this.manageClearBtn();
        }
        this.setupFormInterception();
    },

    setupFieldButtons : function() {
        this.buttonWrap = this.outerWrapEl.createChild({
            cls: 'x-superboxselect-btns'
        });
        
        this.buttonClear = this.buttonWrap.createChild({
            tag:'div',
            cls: 'x-superboxselect-btn-clear ' + this.clearBtnCls
        });

        this.buttonExpand = this.buttonWrap.createChild({
            tag:'div',
            cls: 'x-superboxselect-btn-expand ' + this.expandBtnCls
        });

        this.initButtonEvents();
    },

    initButtonEvents : function() {
        this.buttonClear.addClassOnOver('x-superboxselect-btn-over').on('click', function(e) {
            e.stopEvent();
            if (this.disabled) {
                return;
            }
            this.clearValue();
            this.el.focus();
        }, this);

        this.buttonExpand.addClassOnOver('x-superboxselect-btn-over').on('click', function(e) {
            e.stopEvent();
            if (this.disabled) {
                return;
            }
            if (this.isExpanded()) {
                this.multiSelectMode = false;
            } else if (this.pinList) {
                this.multiSelectMode = true;
            }
            this.onTriggerClick();
        }, this);
    },

    removeButtonEvents : function() {
        this.buttonClear.removeAllListeners();
        this.buttonExpand.removeAllListeners();
    },

    clearCurrentFocus : function() {
        if (this.currentFocus) {
            this.currentFocus.onLnkBlur();
            this.currentFocus = null;
        }
    },

    initEvents : function() {
        var el = this.el;

        el.on({
            click   : this.onClick,
            focus   : this.clearCurrentFocus,
            blur    : this.onBlur,

            keydown : this.onKeyDownHandler,
            keyup   : this.onKeyUpBuffered,

            scope   : this
        });

        this.on({
            collapse: this.onCollapse,
            expand: this.clearCurrentFocus,
            scope: this
        });

        this.wrapEl.on('click', this.onWrapClick, this);
        this.outerWrapEl.on('click', this.onWrapClick, this);

        // TODO: what the heck?!?! setting this.inputEl.focus = el.focus / this.el.focus doesn't work?!?!
        this.inputEl.focus = function() {
            el.focus();
        };

        Ext.ux.form.SuperBoxSelect.superclass.initEvents.call(this);

        Ext.apply(this.keyNav, {
            tab: function(e) {
                if (this.fixFocusOnTabSelect && this.isExpanded()) {
                    e.stopEvent();
                    el.blur();
                    this.onViewClick(false);
                    this.focus(false, 10);
                    return true;
                }

                this.onViewClick(false);
                if (el.dom.value !== '') {
                    this.setRawValue('');
                }

                return true;
            },

            down: function(e) {
                if (!this.isExpanded() && !this.currentFocus) {
                    this.onTriggerClick();
                } else {
                    this.inKeyMode = true;
                    this.selectNext();
                }
            },

            enter: function(e) {
                this.onViewClick();
                this.delayedCheck = true;
                this.unsetDelayCheck.defer(10, this);
                return true;
            }
        });
    },

    onClick: function() {
        this.clearCurrentFocus();
        this.collapse();
        this.autoSize();
    },

    beforeBlur: Ext.form.ComboBox.superclass.beforeBlur,

    onFocus: function() {
        this.outerWrapEl.addClass(this.focusClass);

        Ext.ux.form.SuperBoxSelect.superclass.onFocus.call(this);
    },

    onBlur: function() {
        this.outerWrapEl.removeClass(this.focusClass);

        this.clearCurrentFocus();

        if (this.el.dom.value !== '') {
            this.applyEmptyText();
            this.autoSize();
        }

        Ext.ux.form.SuperBoxSelect.superclass.onBlur.call(this);
    },

    onCollapse: function() {
        this.multiSelectMode = false;
    },

    onWrapClick: function(e) {
        e.stopEvent();
        this.collapse();
        this.el.focus();
        this.clearCurrentFocus();
    },

    markInvalid : function(msg) {
        var elp, t;

        if (!this.rendered || this.preventMark) { // not rendered
            return;
        }
        this.outerWrapEl.addClass(this.invalidClass);
        msg = msg || this.invalidText;

        switch (this.msgTarget) {
            case 'qtip':
                Ext.apply(this.el.dom, {
                    qtip    : msg,
                    qclass  : 'x-form-invalid-tip'
                });
                Ext.apply(this.wrapEl.dom, {
                    qtip    : msg,
                    qclass  : 'x-form-invalid-tip'
                });
                if (Ext.QuickTips) { // fix for floating editors interacting with DND
                    Ext.QuickTips.enable();
                }
                break;
            case 'title':
                this.el.dom.title = msg;
                this.wrapEl.dom.title = msg;
                this.outerWrapEl.dom.title = msg;
                break;
            case 'under':
                if (!this.errorEl) {
                    elp = this.getErrorCt();
                    if (!elp) { // field has no container el
                        this.el.dom.title = msg;
                        break;
                    }
                    this.errorEl = elp.createChild({cls:'x-form-invalid-msg'});
                    this.errorEl.setWidth(elp.getWidth(true) - 20);
                }
                this.errorEl.update(msg);
                Ext.form.Field.msgFx[this.msgFx].show(this.errorEl, this);
                break;
            case 'side':
                if (!this.errorIcon) {
                    elp = this.getErrorCt();
                    if (!elp) { // field has no container el
                        this.el.dom.title = msg;
                        break;
                    }
                    this.errorIcon = elp.createChild({cls:'x-form-invalid-icon'});
                }
                this.alignErrorIcon();
                Ext.apply(this.errorIcon.dom, {
                    qtip    : msg,
                    qclass  : 'x-form-invalid-tip'
                });
                this.errorIcon.show();
                this.on('resize', this.alignErrorIcon, this);
                break;
            default:
                t = Ext.getDom(this.msgTarget);
                t.innerHTML = msg;
                t.style.display = this.msgDisplay;
                break;
        }
        this.fireEvent('invalid', this, msg);
    },

    clearInvalid : function() {
        var t;

        if (!this.rendered || this.preventMark) { // not rendered
            return;
        }
        this.outerWrapEl.removeClass(this.invalidClass);
        switch (this.msgTarget) {
            case 'qtip':
                this.el.dom.qtip = '';
                this.wrapEl.dom.qtip = '';
                break;
            case 'title':
                this.el.dom.title = '';
                this.wrapEl.dom.title = '';
                this.outerWrapEl.dom.title = '';
                break;
            case 'under':
                if (this.errorEl) {
                    Ext.form.Field.msgFx[this.msgFx].hide(this.errorEl, this);
                }
                break;
            case 'side':
                if (this.errorIcon) {
                    this.errorIcon.dom.qtip = '';
                    this.errorIcon.hide();
                    this.un('resize', this.alignErrorIcon, this);
                }
                break;
            default:
                t = Ext.getDom(this.msgTarget);
                t.innerHTML = '';
                t.style.display = 'none';
                break;
        }
        this.fireEvent('valid', this);
    },

    // private
    alignErrorIcon : function() {
        if (this.wrap) {
            this.errorIcon.alignTo(this.wrap, 'tl-tr', [Ext.isIE ? 5 : 2, 3]);
        }
    },

    expand : function() {
        if (this.isExpanded() || !this.hasFocus) {
            return;
        }
        this.list.alignTo(this.outerWrapEl, this.listAlign).show();
        this.innerList.setOverflow('auto'); // necessary for FF 2.0/Mac
        Ext.getDoc().on({
            mousewheel: this.collapseIf,
            mousedown: this.collapseIf,
            scope: this
        });
        this.fireEvent('expand', this);
    },

    restrictHeight : function() {
        var inner = this.innerList.dom,
            st = inner.scrollTop,
            pad = this.list.getFrameWidth('tb') + (this.resizable ? this.handleHeight : 0) + this.assetHeight,
            h = Math.max(inner.clientHeight, inner.offsetHeight, inner.scrollHeight),
            ha = this.getPosition()[1] - Ext.getBody().getScroll().top,
            hb = Ext.lib.Dom.getViewHeight() - ha - this.getSize().height,
            space = Math.max(ha, hb, this.minHeight || 0) - this.list.shadowOffset - pad - 5;

        inner.style.height = '';
        h = Math.min(h, space, this.maxHeight);

        this.innerList.setHeight(h);
        this.list.beginUpdate();
        this.list.setHeight(h + pad);
        this.list.alignTo(this.outerWrapEl, this.listAlign);
        this.list.endUpdate();

        if (this.multiSelectMode) {
            inner.scrollTop = st;
        }
    },

    validateValue: function(val) {
        if (this.items.getCount() == 0) {
            if (this.allowBlank) {
                this.clearInvalid();
                return true;
            } else {
                this.markInvalid(this.blankText);
                return false;
            }
        } else {
            this.clearInvalid();
            return true;
        }
    },

    setupFormInterception : function() {
        //intercept form.getValues to ensure that the input element is not included as an empty field
        var form;
        this.findParentBy(function(p) {
            if (p.getForm) {
                form = p.getForm();
            }
        });
        if (form) {
            var formGet = form.getValues;
            form.getValues = function(asString) {
                var oldVal, vals;

                if (this.items.getCount() > 0) {
                    this.el.dom.disabled = true;
                }
                oldVal = this.el.dom.value;
                this.setRawValue('');
                vals = formGet.call(form, asString);
                this.el.dom.disabled = false;
                this.setRawValue(oldVal);
                return vals;
            }.createDelegate(this);
        }
    },

    onResize : function(w, h, rw, rh) {
        var reduce = Ext.isIE6 ? 4 : Ext.isIE7 ? 1 : Ext.isIE8 ? 1 : 0;
        
        this._width = w;
        this.outerWrapEl.setWidth(w - reduce);
        if (this.renderFieldBtns) {
            reduce += (this.buttonWrap.getWidth() + 20);
            this.wrapEl.setWidth(w - reduce);
        }
        Ext.ux.form.SuperBoxSelect.superclass.onResize.call(this, w, h, rw, rh);
        this.autoSize();
    },

    onEnable: function() {
        Ext.ux.form.SuperBoxSelect.superclass.onEnable.call(this);
        this.items.each(function(item) {
            item.enable();
        });
        this.initButtonEvents();
    },

    onDisable: function() {
        Ext.ux.form.SuperBoxSelect.superclass.onDisable.call(this);
        this.items.each(function(item) {
            item.disable();
        });
        this.removeButtonEvents();
    },

    clearValue : function() {
        Ext.ux.form.SuperBoxSelect.superclass.clearValue.call(this);
        this.removeAllItems();
    },

    onKeyUp : function(e) {
        if (this.editable !== false && !e.isSpecialKey() && (!e.hasModifier() || e.shiftKey)) {
            this.lastKey = e.getKey();
            this.dqTask.delay(this.queryDelay);
        }
    },

    onKeyDownHandler : function(e, t) {
        if ((e.getKey() === e.DELETE || e.getKey() === e.SPACE) && this.currentFocus) {
            e.stopEvent();
            var toDestroy = this.currentFocus,
                idx = this.items.indexOfKey(this.currentFocus.key),
                nextFocus;

            this.on('expand', function() {
                this.collapse();
            }, this, {single: true});

            this.clearCurrentFocus();

            if (idx < (this.items.getCount() - 1)) {
                nextFocus = this.items.itemAt(idx + 1);
            }

            toDestroy.preDestroy(true);

            if (nextFocus) {
                (function() {
                    nextFocus.onLnkFocus();
                    this.currentFocus = nextFocus;
                }).defer(200, this);
            }

            return true;
        }

        var val = this.el.dom.value, it;
        //ctrl+enter for new items
        if (e.getKey() === e.ENTER) {
            if (val !== "") {
                e.stopEvent();
                if (e.ctrlKey) {
                    this.collapse();
                    this.setRawValue('');
                    this.fireEvent('newitem', this, val);
                }
                else {
                    if (!this.isExpanded()) {
                        this.setRawValue('');
                        this.fireEvent('newitem', this, val);
                    }
                    else {
                        this.onViewClick();
                        this.delayedCheck = true;
                        this.unsetDelayCheck.defer(10, this);
                    }
                }
            } else {
                if (!this.isExpanded()) {
                    return;
                }
                this.onViewClick();
                this.delayedCheck = true;
                this.unsetDelayCheck.defer(10, this);
            }
            return true;
        }

        if (val !== '') {
            return;
        }

        //select first item
        if (e.getKey() === e.HOME) {
            e.stopEvent();
            if (this.items.getCount() > 0) {
                this.collapse();
                it = this.items.get(0);
                it.el.focus();

            }
            return true;
        }
        //backspace remove
        if (e.getKey() === e.BACKSPACE) {
            e.stopEvent();
            if (this.currentFocus) {
                toDestroy = this.currentFocus;
                idx = this.items.indexOfKey(toDestroy.key);
                nextFocus = null;

                this.on('expand', function() {
                    this.collapse();
                }, this, {single: true});

                this.clearCurrentFocus();
                if (idx < (this.items.getCount() - 1)) {
                    nextFocus = this.items.itemAt(idx + 1);
                }

                toDestroy.preDestroy(true);

                if (nextFocus) {
                    (function() {
                        nextFocus.onLnkFocus();
                        this.currentFocus = nextFocus;
                    }).defer(200, this);
                }

                return;
            } else {
                it = this.items.get(this.items.getCount() - 1);
                if (it) {
                    if (this.backspaceDeletesLastItem) {
                        this.on('expand', function() {
                            this.collapse();
                        }, this, {single: true});

                        it.preDestroy(true);
                    } else {
                        if (this.navigateItemsWithTab) {
                            it.onElClick();
                        } else {
                            this.on('expand', function() {
                                this.collapse();
                                this.currentFocus = it;
                                this.currentFocus.onLnkFocus.defer(20, this.currentFocus);
                            }, this, {single: true});
                        }
                    }
                }
                return true;
            }
        }

        if (!e.isNavKeyPress()) {
            this.multiSelectMode = false;
            this.clearCurrentFocus();
            return;
        }
        //arrow nav
        if (e.getKey() === e.LEFT || (e.getKey() === e.UP && !this.isExpanded())) {
            e.stopEvent();
            this.collapse();
            //get last item
            it = this.items.get(this.items.getCount() - 1);
            if (this.navigateItemsWithTab) {
                //focus last el
                if (it) {
                    it.focus();
                }
            } else {
                //focus prev item
                if (this.currentFocus) {
                    idx = this.items.indexOfKey(this.currentFocus.key);
                    this.clearCurrentFocus();

                    if (idx !== 0) {
                        this.currentFocus = this.items.itemAt(idx - 1);
                        this.currentFocus.onLnkFocus();
                    }
                } else {
                    this.currentFocus = it;
                    if (it) {
                        it.onLnkFocus();
                    }
                }
            }
            return true;
        }
        if (e.getKey() === e.DOWN) {
            if (this.currentFocus) {
                this.collapse();
                e.stopEvent();
                idx = this.items.indexOfKey(this.currentFocus.key);
                if (idx == (this.items.getCount() - 1)) {
                    this.clearCurrentFocus.defer(10, this);
                } else {
                    this.clearCurrentFocus();
                    this.currentFocus = this.items.itemAt(idx + 1);
                    if (this.currentFocus) {
                        this.currentFocus.onLnkFocus();
                    }
                }
                return true;
            }
        }
        if (e.getKey() === e.RIGHT) {
            this.collapse();
            it = this.items.itemAt(0);
            if (this.navigateItemsWithTab) {
                //focus first el
                if (it) {
                    it.focus();
                }
            } else {
                if (this.currentFocus) {
                    idx = this.items.indexOfKey(this.currentFocus.key);
                    this.clearCurrentFocus();
                    if (idx < (this.items.getCount() - 1)) {
                        this.currentFocus = this.items.itemAt(idx + 1);
                        if (this.currentFocus) {
                            this.currentFocus.onLnkFocus();
                        }
                    }
                } else {
                    this.currentFocus = it;
                    if (it) {
                        it.onLnkFocus();
                    }
                }
            }
        }
    },

    reset :  function() {
        Ext.ux.form.SuperBoxSelect.superclass.reset.call(this);
        this.autoSize();
        this.setRawValue('');
        this.el.focus();
    },

    applyEmptyText : function() {
        if (this.items.getCount() > 0) {
            this.el.removeClass(this.emptyClass);
            this.setRawValue('');
            return;
        }
        if (this.rendered && this.emptyText && this.getRawValue().length < 1) {
            this.setRawValue(this.emptyText);
            this.el.addClass(this.emptyClass);
        }
    },

    /**
     * Removes all items from the SuperBoxSelect component
     * @methodOf Ext.ux.form.SuperBoxSelect
     * @name removeAllItems
     */
    removeAllItems: function() {
        this.items.each(function(item) {
            item.preDestroy(true);
        }, this);

        this.manageClearBtn();
    },

    resetStore: function() {
        if (!this.removeValuesFromStore) {
            return;
        }
        this.usedRecords.each(function(rec) {
            this.store.add(rec);
        }, this);
        this.sortStore();
    },

    sortStore: function() {
        var ss = this.store.getSortState();
        if (ss && ss.field) {
            this.store.sort(ss.field, ss.direction);
        }
    },

    getCaption: function(dataObject) {
        if (typeof this.displayFieldTpl === 'string') {
            this.displayFieldTpl = new Ext.XTemplate(this.displayFieldTpl);
        }
        var recordData = dataObject instanceof Ext.data.Record ? dataObject.data : dataObject,
            caption;

        if (this.displayFieldTpl) {
            caption = this.displayFieldTpl.apply(recordData);
        } else if (this.displayField) {
            caption = recordData[this.displayField];
        }

        return caption;
    },

    addRecord : function(record) {
        var display = record.data[this.displayField],
            caption = this.getCaption(record),
            val = record.data[this.valueField],
            cls = this.classField ? record.data[this.classField] : '',
            style = this.styleField ? record.data[this.styleField] : '';

        if (this.removeValuesFromStore) {
            this.usedRecords.add(val, record);
            this.store.remove(record);
        }

        this.fireEvent('additem', this, val);

        this.addItemBox(val, display, caption, cls, style);
    },

    createRecord : function(recordData) {
        if (!this.recordConstructor) {
            var recordFields = [{
                name: this.valueField
            }, {
                name: this.displayField
            }];

            if (this.classField) {
                recordFields.push({name: this.classField});
            }
            if (this.styleField) {
                recordFields.push({name: this.styleField});
            }
            this.recordConstructor = Ext.data.Record.create(recordFields);
        }
        return new this.recordConstructor(recordData);
    },

    /**
     * Adds an item to the SuperBoxSelect component if the {@link #Ext.ux.form.SuperBoxSelect-allowAddNewData} config is set to true.
     * @methodOf Ext.ux.form.SuperBoxSelect
     * @name addItem
     * @param {Object} newItemObject An object literal containing the property names and values for an item. The property names must match those specified in {@link #Ext.ux.form.SuperBoxSelect-displayField}, {@link #Ext.ux.form.SuperBoxSelect-valueField} and {@link #Ext.ux.form.SuperBoxSelect-classField}
     */
    addItem : function(newItemObject) {
        var val = newItemObject[this.valueField];

        if (this.disabled) {
            return false;
        }
        if (this.preventDuplicates && this.hasValue(val)) {
            return;
        }

        //use existing record if found
        var record;
        if (record = this.findRecord(this.valueField, val)) {
            this.addRecord(record);
            return;
        } else if (!this.allowAddNewData) { // else it's a new item
            return;
        }
        
        var rec = this.createRecord(newItemObject);
        this.store.add(rec);
        this.addRecord(rec);

        return true;
    },

    addItemBox : function(itemVal, itemDisplay, itemCaption, itemClass, itemStyle) {
        var parseStyle = function(s) {
            var ret = '';
            if (typeof s == 'function') {
                ret = s.call();
            } else if (typeof s == 'object') {
                for (p in s) {
                    ret += p + ':' + s[p] + ';';
                }
            } else if (typeof s == 'string') {
                ret = s + ';';
            }
            return ret;
        };

        var itemKey = Ext.id(null, 'sbx-item'),
            box = new Ext.ux.form.SuperBoxSelectItem({
                owner: this,
                renderTo: this.wrapEl,
                cls: this.extraItemCls + ' ' + itemClass,
                style: parseStyle(this.extraItemStyle) + ' ' + itemStyle,
                caption: itemCaption,
                display: itemDisplay,
                value:  itemVal,
                key: itemKey,
                listeners: {
                    remove: function(item) {
                        if (this.fireEvent('beforeremoveitem', this, item.value) === false) {
                            return;
                        }
                        this.items.removeKey(item.key);
                        if (this.removeValuesFromStore) {
                            if (this.usedRecords.containsKey(item.value)) {
                                this.store.add(this.usedRecords.get(item.value));
                                this.usedRecords.removeKey(item.value);
                                this.sortStore();
                                if (this.view) {
                                    this.view.render();
                                }
                            }
                        }
                        this.fireEvent('removeitem', this, item.value);
                    },
                    destroy: function() {
                        this.collapse();
                        this.autoSize();
                        this.validateValue();
                        this.manageClearBtn();
                    },
                    scope: this
                }
        });

        box.render();
        box.hidden = this.el.insertSibling({
            tag:'input',
            type:'hidden',
            value: itemVal,
            name: (this.hiddenName || this.name)
        }, 'before');

        this.items.add(itemKey, box);
        this.applyEmptyText();
        this.autoSize();
        this.validateValue();
        this.manageClearBtn();
    },

    manageClearBtn : function() {
        if (!this.renderFieldBtns) {
            return;
        }
        var cls = 'x-superboxselect-btn-hide';
        if (this.items.getCount() == 0) {
            this.buttonClear.addClass(cls);
        } else {
            this.buttonClear.removeClass(cls);
        }
    },

    findInStore : function(val) {
        var index = this.store.find(this.valueField, val.trim());
        if (index > -1) {
            return this.store.getAt(index);
        }
        return false;
    },

    /**
     * Returns a String value containing a concatenated list of item values. The list is concatenated with the {@link #Ext.ux.form.SuperBoxSelect-valueDelimiter}.
     * @methodOf Ext.ux.form.SuperBoxSelect
     * @name getValue
     * @return {String} a String value containing a concatenated list of item values.
     */
    getValue : function() {
        var ret = [];
        this.items.each(function(item) {
            ret.push(item.value);
        });
        return ret.join(this.valueDelimiter);
    },

    /**
     * Returns an Array of item objects containing the {@link #Ext.ux.form.SuperBoxSelect-displayField}, {@link #Ext.ux.form.SuperBoxSelect-valueField} and {@link #Ext.ux.form.SuperBoxSelect-classField} properties.
     * @methodOf Ext.ux.form.SuperBoxSelect
     * @name getValueEx
     * @return {Array} an array of item objects.
     */
    getValueEx : function() {
        var ret = [];
        this.items.each(function(item) {
            var newItem = {};
            newItem[this.valueField] = item.value;
            newItem[this.displayField] = item.display;
            newItem[this.classField] = item.cls;
            ret.push(newItem);
        });
        return ret;
    },

    /**
     * Sets the value of the SuperBoxSelect component.
     * @methodOf Ext.ux.form.SuperBoxSelect
     * @name setValue
     * @param {String} value a String value containing a concatenated list of item values. The list should be concatenated with the {@link #Ext.ux.form.SuperBoxSelect-valueDelimiter
     */
    setValue: function(value) {
        var values = value.split(this.valueDelimiter);

        this.removeAllItems();
        this.store.clearFilter();
        this.resetStore();

        Ext.each(values, function(val) {
            var record;
            if (record = this.findRecord(this.valueField, val)) {
                this.addRecord(record);
            }
        }, this);

    },

    /**
     * Sets the value of the SuperBoxSelect component, adding new items that don't exist in the data store if the {@link #Ext.ux.form.SuperBoxSelect-allowAddNewData} config is set to true.
     * @methodOf Ext.ux.form.SuperBoxSelect
     * @name setValue
     * @param {Array} data An Array of item objects containing the {@link #Ext.ux.form.SuperBoxSelect-displayField}, {@link #Ext.ux.form.SuperBoxSelect-valueField} and {@link #Ext.ux.form.SuperBoxSelect-classField} properties.
     */
    setValueEx : function(data) {
        this.removeAllItems();
        this.store.clearFilter();
        this.resetStore();

        if (!Ext.isArray(data)) {
            data = [data];
        }
        Ext.each(data, function(item) {
            this.addItem(item);
        }, this);
    },

    /**
     * Returns true if the SuperBoxSelect component has a selected item with a value matching the 'val' parameter.
     * @methodOf Ext.ux.form.SuperBoxSelect
     * @name hasValue
     * @param {Mixed} val The value to test.
     * @return {Boolean} true if the component has the selected value, false otherwise.
     */
    hasValue: function(val) {
        var has = false;
        this.items.each(function(item) {
            if (item.value == val) {
                has = true;
                return false;
            }
        }, this);
        return has;
    },

    onSelect : function(record, index) {
        var val = record.data[this.valueField];

        if (this.preventDuplicates && this.hasValue(val)) {
            return;
        }

        this.setRawValue('');
        this.lastSelectionText = '';

        if (this.fireEvent('beforeadditem', this, val) !== false) {
            this.addRecord(record);
        }
        if (this.store.getCount() == 0 || !this.multiSelectMode) {
            this.collapse();
        } else {
            this.restrictHeight();
        }
    },

    onDestroy : function() {
        this.items.each(function(item) {
            item.preDestroy(true);
        }, this);

        if (this.renderFieldBtns) {
            Ext.destroy(
                this.buttonClear,
                this.buttonExpand,
                this.buttonWrap
            );
        }

        Ext.destroy(
            this.inputEl,
            this.wrapEl,
            this.outerWrapEl
        );

        Ext.ux.form.SuperBoxSelect.superclass.onDestroy.call(this);
    },

    autoSize : function() {
        if (!this.rendered) {
            return;
        }
        if (!this.metrics) {
            this.metrics = Ext.util.TextMetrics.createInstance(this.el);
        }
        var el = this.el,
            v = el.dom.value,
            d = document.createElement('div');

        if (v === "" && this.emptyText && this.items.getCount() < 1) {
            v = this.emptyText;
        }
        d.appendChild(document.createTextNode(v));
        v = d.innerHTML + " ";
        d = null;
        var w = Math.max(this.metrics.getWidth(v) + 24, 24);
        if (typeof this._width != 'undefined') {
            w = Math.min(this._width, w);
        }
        this.el.setWidth(w);

        if (Ext.isIE) {
            this.el.dom.style.top = '0';
        }
    }
});
Ext.reg('superboxselect', Ext.ux.form.SuperBoxSelect);

/*
 * @private
 */
Ext.ux.form.SuperBoxSelectItem = function(config) {
    Ext.apply(this, config);
    Ext.ux.form.SuperBoxSelectItem.superclass.constructor.call(this);
};

/*
 * @private
 */
Ext.ux.form.SuperBoxSelectItem = Ext.extend(Ext.ux.form.SuperBoxSelectItem, Ext.Component, {
    initComponent : function() {
        Ext.ux.form.SuperBoxSelectItem.superclass.initComponent.call(this);
    },

    onElClick : function(e) {
        this.owner.clearCurrentFocus();
        this.owner.collapse();
        if (this.owner.navigateItemsWithTab) {
            this.focus();
        } else {
            this.owner.el.focus();
            (function() {
                this.onLnkFocus();
                this.owner.currentFocus = this;
            }).defer(10, this);
        }
    },

    onLnkClick : function(e) {
        if (e) {
            e.stopEvent();
        }

        this.preDestroy();

        if (!this.owner.navigateItemsWithTab) {
            this.owner.el.focus();
        }
    },

    onLnkFocus : function() {
        this.owner.outerWrapEl.addClass(this.owner.focusClass);

        this.el.addClass("x-superboxselect-item-focus");
    },

    onLnkBlur : function(e) {
        this.owner.outerWrapEl.removeClass(this.owner.focusClass);

        this.el.removeClass("x-superboxselect-item-focus");
    },

    enableElListeners : function() {
        this.el.on('click', this.onElClick, this, {stopEvent:true});
        this.el.addClassOnOver('x-superboxselect-item x-superboxselect-item-hover');
    },

    enableLnkListeners : function() {
        this.lnk.on({
            click   : this.onLnkClick,
            focus   : this.onLnkFocus,
            blur    : this.onLnkBlur,
            scope   : this
        });
    },

    enableAllListeners : function() {
        this.enableElListeners();
        this.enableLnkListeners();
    },

    disableAllListeners : function() {
        this.el.removeAllListeners();
        this.lnk.removeAllListeners();
    },

    onRender : function(ct, position) {
        Ext.ux.form.SuperBoxSelectItem.superclass.onRender.call(this, ct, position);

        if (this.el) {
            this.el.remove();
        }

        this.el = ct.createChild({ tag: 'li' }, ct.last());
        this.el.addClass('x-superboxselect-item');

        var btnEl = this.owner.navigateItemsWithTab ? (Ext.isSafari ? 'button' : 'a') : 'span';

        Ext.apply(this.el, {
            focus: function() {
                this.down(btnEl + '.x-superboxselect-item-close').focus();
            },

            preDestroy: this.preDestroy
        });

        this.enableElListeners();

        this.el.update(this.caption);

        var cfg = {
            tag: btnEl,
            cls: 'x-superboxselect-item-close',
            tabIndex : this.owner.navigateItemsWithTab ? '0' : '-1'
        };
        if (btnEl === 'a') {
            cfg.href = '#';
        }
        this.lnk = this.el.createChild(cfg);


        if (this.disabled) {
            this.disableAllListeners();
        } else {
            this.enableLnkListeners();
        }

        this.on({
            disable : this.disableAllListeners,
            enable  : this.enableAllListeners,
            scope   : this
        });

        this.setupKeyMap();
    },

    setupKeyMap : function() {
        this.keyMap = new Ext.KeyMap(this.lnk, [{
            key: [
                Ext.EventObject.BACKSPACE,
                Ext.EventObject.DELETE,
                Ext.EventObject.SPACE
            ],
            fn: function() {
                if (this.fireEvent('remove', this) !== false) {
                    this.preDestroy();
                    this.on('expand', this.collapse, this, {single: true});
                }
            }.createDelegate(this)
        }, {
            key: [
                Ext.EventObject.RIGHT,
                Ext.EventObject.DOWN
            ],
            fn: this.moveFocus.createDelegate(this, ['right'])
        }, {
            key: [
                Ext.EventObject.LEFT,
                Ext.EventObject.UP
            ],
            fn: this.moveFocus.createDelegate(this, ['left'])
        }, {
            key: Ext.EventObject.HOME,
            fn: function() {
                this.owner.items.get(0).el.focus();
            }.createDelegate(this)
        }, {
            key: Ext.EventObject.END,
            fn: function() {
                this.owner.el.focus();
            }.createDelegate(this)
        }]);

        this.keyMap.stopEvent = true;
    },

    /*
     * @private
     */
    moveFocus : function(dir) {
        var el = this.el[dir == 'left' ? 'prev' : 'next']() || this.owner.el;

        el.focus();
    },

    /*
     * @private
     */
    preDestroy : function(suppressEffect) {
        if (this.fireEvent('remove', this) === false) {
            return;
        }
        
        var actionDestroy = function() {
            if (this.owner.navigateItemsWithTab) {
                this.moveFocus('right');
            }
            this.hidden.remove();
            this.hidden = null;
            this.destroy();
        };

        if (suppressEffect) {
            actionDestroy.call(this);
        } else {
            this.el.hide({
                duration: .2,
                callback: actionDestroy,
                scope: this
            });
        }
        return this;
    },

    onDestroy : function() {
        Ext.destroy(
            this.lnk,
            this.el
        );

        Ext.ux.form.SuperBoxSelectItem.superclass.onDestroy.call(this);
    }
});