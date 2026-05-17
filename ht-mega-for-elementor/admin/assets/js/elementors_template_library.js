;(function ( $, winelementor ) {
    window.htmega = window.htmega || {};
    
    var moduleExp = { 
        Views: {},
        Models: {},
        Collections: {},
        Behaviors: {},
        Layout: null,
        Manager: null
    };

    var htFilterText = 'page';

    /**
     * `get_htmega_template_data` updates WP options in that AJAX request after Elementor already built
     * `Widgets_Manager`; the next isolated `get_widgets_config` HTTP request re-bootstraps PHP so newly-enabled
     * widgets exist in `elementor.widgetsCache` (Elementor uses widget base + cache for unknown types).
     */
    function htmegaRefreshElementorWidgetsConfigThen(callback) {
        var excludeWidgets = {},
            runCb = function () {
                if (typeof callback === "function") {
                    callback();
                }
            };
        if (typeof elementor === "undefined" || typeof elementorCommon === "undefined" || !elementorCommon.ajax) {
            runCb();
            return;
        }
        jQuery.each(elementor.widgetsCache || {}, function (widgetName, widgetConfig) {
            if (widgetConfig && widgetConfig.controls) {
                excludeWidgets[widgetName] = true;
            }
        });
        elementorCommon.ajax.addRequest("get_widgets_config", {
            unique_id: "htmega_lib_widgets_" + String(Date.now()),
            data: {
                exclude: excludeWidgets
            },
            success: function (data) {
                elementor.addWidgetsCache(data || {});
                if (elementor.config && elementor.config.locale !== elementor.config.user.locale && typeof elementor.translateControlsDefaults === "function") {
                    elementor.translateControlsDefaults(elementor.config.locale);
                }
                if (elementor.loaded) {
                    if (elementor.kitManager && typeof elementor.kitManager.renderGlobalsDefaultCSS === "function") {
                        elementor.kitManager.renderGlobalsDefaultCSS();
                    }
                    if (typeof $e !== "undefined" && $e.internal) {
                        $e.internal("panel/state-ready");
                    }
                } else if (typeof elementor.once === "function") {
                    elementor.once("panel:init", function () {
                        if (typeof $e !== "undefined" && $e.internal) {
                            $e.internal("panel/state-ready");
                        }
                    });
                }
                runCb();
            },
            error: function () {
                runCb();
            }
        });
    }

    /** True when this widget still needs frontend JS (Slick/Swiper/Beer slider) typical after Elementor library import. */
    function htmegaPreviewWidgetNeedsCarouselRebind($widget, jq) {
        function hasUninitedSlick(sel) {
            return (
                $widget.find(sel).filter(function () {
                    return !jq(this).hasClass("slick-initialized");
                }).length > 0
            );
        }
        if (hasUninitedSlick(".htmega-carousel-activation")) {
            return true;
        }
        if (hasUninitedSlick(".htmega-testimonial-activation")) {
            return true;
        }
        if (hasUninitedSlick(".htmega-testimonial-for") || hasUninitedSlick(".htmega-testimonal-nav")) {
            return true;
        }
        if (hasUninitedSlick(".htmega-thumbgallery-for") || hasUninitedSlick(".htmega-thumbgallery-nav")) {
            return true;
        }
        if (hasUninitedSlick(".htmega-pro-carousel-activation")) {
            return true;
        }
        if (hasUninitedSlick(".htmega-pro-slider-for") || hasUninitedSlick(".htmega-pro-slider-nav")) {
            return true;
        }
        var $sw = $widget.find(".htmega-team-carousel-slider-active").first();
        if ($sw.length && !$sw.hasClass("swiper-initialized")) {
            return true;
        }
        if (
            $widget.find(".htmega-imagecomparison .beer-slider").filter(function () {
                return !jq(this).find(".beer-range").length;
            }).length > 0
        ) {
            return true;
        }
        return false;
    }

    /**
     * True when this widget should re-run HT Mega frontend handlers after library import (sliders + progress/countdown/chart/…).
     * Skips broad “all widgets” rebinding to reduce duplicate listeners on tab/accordion/etc.
     */
    function htmegaPreviewWidgetNeedsLibraryRebind($widget, jq) {
        if (htmegaPreviewWidgetNeedsCarouselRebind($widget, jq)) {
            return true;
        }
        var el = $widget[0];
        var wt = (el && el.getAttribute("data-widget_type")) || "";
        // Widgets that rely on scripts/CSS loaded per-widget on first paint (same root cause as carousels).
        if (
            /htmega-(progressbar|countdown|counter|newtsicker|videoplayer|imagemasonryd|chart|google-map|magnific-popup|notify|audio-player|postslider|thumbgallery|carousel|postcarousel|instagram|twitterfeed|panelslider|scrollnavigation|postgridtab|imagecomparison|imagemagnifier|animatedheading|lottie|flip-carousel)-addons/i.test(
                wt
            )
        ) {
            return true;
        }
        if (/^bl-/.test(wt)) {
            return true;
        }
        if ($widget.find(".radial-progress").length) {
            return true;
        }
        if ($widget.find("[data-countdown]").length) {
            return true;
        }
        if ($widget.find(".htmega-masonry-activation").length) {
            return true;
        }
        if ($widget.find(".htmega-newstricker").length) {
            return true;
        }
        if ($widget.find(".htmega-animated-heading").length) {
            return true;
        }
        if ($widget.find(".htmega-lottie-image").length || $widget.find("lottie-player").length) {
            return true;
        }
        if ($widget.find(".htmega-flipster").length) {
            return true;
        }
        if ($widget.find(".htmega-doughunt-chartjs").length) {
            return true;
        }
        if ($widget.find(".magnifier-thumb-wrapper img.zoom").length) {
            return true;
        }
        return false;
    }

    /**
     * Re-fire Elementor `element_ready` in the preview iframe so HT Mega handlers run after library import.
     * Targets sliders and other “activation” widgets that miss per-widget enqueued scripts until preview reload.
     */
    function htmegaRerunHtmegaCarouselsInPreview() {
        try {
            var frame = window.elementor && elementor.$preview && elementor.$preview[0];
            if (!frame || !frame.contentWindow || !frame.contentWindow.document) {
                return;
            }
            var win = frame.contentWindow;
            var ef = win.elementorFrontend;
            if (!ef || !ef.elementsHandler || typeof ef.elementsHandler.runReadyTrigger !== "function") {
                return;
            }
            var jq = win.jQuery;
            if (!jq) {
                return;
            }
            jq(win.document)
                .find('[data-element_type="widget"]')
                .each(function () {
                    var wt = this.getAttribute("data-widget_type") || "";
                    if (wt.indexOf("htmega-") !== 0 && wt.indexOf("bl-") !== 0) {
                        return;
                    }
                    var $w = jq(this);
                    if (!htmegaPreviewWidgetNeedsLibraryRebind($w, jq)) {
                        return;
                    }
                    ef.elementsHandler.runReadyTrigger(this);
                });
            window.setTimeout(function () {
                if (!jq.fn || typeof jq.fn.slick !== "function") {
                    return;
                }
                jq(win.document)
                    .find(".slick-initialized")
                    .each(function () {
                        var $el = jq(this);
                        if (
                            !$el.closest('.elementor-element[data-widget_type^="htmega-"]').length &&
                            !$el.closest('.elementor-element[data-widget_type^="bl-"]').length
                        ) {
                            return;
                        }
                        try {
                            $el.slick("setPosition");
                        } catch (ePos) {}
                    });
            }, 150);
        } catch (e) {}
    }

    function htmegaAfterLibraryImportRebindPreviewCarousels(importResult) {
        var done = function () {
            window.setTimeout(htmegaRerunHtmegaCarouselsInPreview, 80);
        };
        if (importResult === false) {
            return;
        }
        if (importResult && typeof importResult.done === "function" && typeof importResult.fail === "function") {
            importResult.done(done).fail(function () {});
            return;
        }
        if (importResult && typeof importResult.then === "function") {
            importResult.then(done).catch(function () {});
            return;
        }
        window.setTimeout(done, 120);
    }

    moduleExp.Models.Template = Backbone.Model.extend( 
        { 
            defaults: { 
                template_id: 0, 
                title: '', 
                type: '', 
                thumbnail: '',
                url: '', 
                tags: [], 
                isPro: false 
            } 
        } 
    );

    moduleExp.Collections.Template = Backbone.Collection.extend(
        { 
            model: moduleExp.Models.Template 
        }
    );

    moduleExp.Views.Logo = Marionette.ItemView.extend(
        {
            template: "#tmpl-htmega-template-library-logo",
            className: "htmega_templateLibrary_logo",
            templateHelpers: function () {
                return { title: this.getOption("title") };
            },
        }
    );

    // moduleExp.Views.Actions = Marionette.ItemView.extend(
    //     {
    //         template: "#tmpl-htmega-template-library-header-actions",
    //         id: "elementor-template-library-header-actions",
    //         ui: { sync: "#htmega-template-library-header-sync i" },
    //         events: { "click @ui.sync": "onSyncClick" },
    //         onSyncClick: function () {
    //             var e = this;
    //             e.ui.sync.addClass("eicon-animation-spin"),
    //             htmega.library.getLibraryData({
    //                 onUpdate: function () {
    //                     e.ui.sync.removeClass("eicon-animation-spin"), htmega.library.updateBlocksView();
    //                 },
    //                 forceUpdate: true,
    //                 forceSync: true,
    //             });
    //         },
    //     }
    // );
    moduleExp.Views.Actions = Marionette.ItemView.extend(
        {
            template: "#tmpl-htmega-template-library-header-actions",
            id: "elementor-template-library-header-actions",
            ui: { sync: "#htmega-template-library-header-sync i" },
            //events: { "click @ui.sync": "onSyncClick" },
            events: function () {
                return { click: "onClick" };
            },
            onClick: function () {
                var e = this;
                e.ui.sync.addClass("eicon-animation-spin"),
                htmega.library.getLibraryData({
                    onUpdate: function () {
                        e.ui.sync.removeClass("eicon-animation-spin"), htmega.library.updateBlocksView();
                    },
                    forceUpdate: true,
                    forceSync: true,
                });
            },
        }
    );

    moduleExp.Views.Menu = Marionette.ItemView.extend(
        {
            template: "#tmpl-htmega-template-library-header-menu",
            id: "elementor-template-library-header-menu",
            className: "htmega_templateLibrary_header_menu",
            ui: { 
                items: "> .elementor-component-tab" 
            },
            events: { 
                "click @ui.items": "onTabItemClick" 
            },
            onTabItemClick: function (target) {
                var currenttab = $( target.currentTarget ),
                    value = currenttab.data("tab");
                    htmega.library.setFilter("type", value),
                currenttab.addClass("elementor-active").siblings().removeClass("elementor-active");
                htFilterText = value;
                htmega.library.updateCategoryFilter(htFilterText);
            },
            templateHelpers: function () {
                htmega.library.setFilter("type", htFilterText);
                return htmega.library.getTabs();
            },
        }
    );

    moduleExp.Views.ResponsiveMenu = Marionette.ItemView.extend(
        {
            template: "#tmpl-htmega-template-library-header-menu-responsive",
            id: "elementor-template-library-header-menu-responsive",
            className: "htmega-template-library-header-menu-responsive",
            ui: { items: "> .elementor-component-tab" },
            events: { "click @ui.items": "onTabItemClick" },
            onTabItemClick: function (e) {
                var e = $(e.currentTarget),
                    t = e.data("tab");
                htmega.library.channels.tabs.trigger("change:device", t, e);
            }
        }
    );

    moduleExp.Views.BackButton = Marionette.ItemView.extend(
        {
            template: "#tmpl-htmega-template-library-header-back",
            id: "elementor-template-library-header-preview-back",
            className: "htmega_templateLibrary_back",
            events: function () {
                return { click: "onClick" };
            },
            onClick: function (target) {
                htmega.library.showBlocksView();
                $('[data-tab="'+htFilterText+'"]').addClass("elementor-active").siblings().removeClass("elementor-active");
            },
        }
    );

    moduleExp.Behaviors.InsertTemplate = Marionette.Behavior.extend(
        {
            ui: { 
                insertButton: ".htmega-template-library-template-insert" 
            },
            events: { 
                "click @ui.insertButton": "onInsertButtonClick" 
            },
            onInsertButtonClick: function () {
                htmega.library.insertTemplate( { model: this.view.model } );
            },
        } 
    );

    moduleExp.Views.EmptyTemplateCollection = Marionette.ItemView.extend(
        {
            id: "elementor-template-library-templates-empty",
            template: "#tmpl-elementor-htmega-library-templates-empty",
            ui: { 
                title: ".elementor-template-library-blank-title", 
                message: ".elementor-template-library-blank-message" 
            },
            modesStrings: {
                empty: {
                    title: "No Templates Found", 
                    message: "Try different category or sync for new templates."
                },
                noResults: { 
                    title: "No Results Found", 
                    message: "Please make sure your search is spelled correctly or try a different words." 
                },
            },
            getCurrentMode: function () {
                return htmega.library.getFilter("text") ? "noResults" : "empty";
            },
            onRender: function () {
                var e = this.modesStrings[this.getCurrentMode()];
                this.ui.title.html(e.title), this.ui.message.html(e.message);
            },
        }
    );

    moduleExp.Views.TemplateCollection = Marionette.CompositeView.extend(
        {
            template: "#tmpl-htmega-template-library-templates",
            id: "htmega_template_library_templates",
            childViewContainer: "#htmega-template-library-list",
            emptyView: function () {
                return new moduleExp.Views.EmptyTemplateCollection();
            },
            ui:{ 
                textFilter: "#htmega-template-library-filter-text", 
                categoryFilter: "#elementor-template-library-filter-category"
            },
            events:{ 
                "input @ui.textFilter": "onTextFilterInput",
                "change @ui.categoryFilter": "onCategoryFilterChange",
            },
            getChildView: function (e) {
                return moduleExp.Views.Template;
            },
            initialize: function () {
                this.listenTo(htmega.library.channels.templates, "filter:change", this._renderChildren);
                this.listenTo(this.collection, "reset", this.onCollectionReset);
                setTimeout(() => {
                    this.ui.categoryFilter.select2({
                        width: '100%',
                        placeholder: 'Filter by Category',
                        dropdownCssClass: 'elementor-template-library-filter-category',
                        allowClear: true,
                        minimumInputLength: 0,
                        minimumResultsForSearch: 0
                    });
                }, 100);
            },
            filter: function (e) {
                var t = htmega.library.getFilterTerms(),
                    i = true;
                return (
                    _.each(t, function (t, a) {
                        var n = htmega.library.getFilter(a);
                        if ((n || a === 'category') && t.callback) {
                            var r = t.callback.call(e, n);
                            return r || (i = false), r;
                        }
                    }),
                    i
                );
            },
            
            onTextFilterInput: function () {
                var e = this;
                _.defer(function () {
                    htmega.library.setFilter("text", e.ui.textFilter.val());
                });
            },

            onCategoryFilterChange: function() {
                var category = this.ui.categoryFilter.val();
                htmega.library.setFilter('category', category);
            },
            
        }
    );

    moduleExp.Views.Template = Marionette.ItemView.extend(
        {
            template: "#htmega-template-library-template",
            className: "htmega_template_library_template",
            ui: { 
                previewButton: ".htmega-template-library-preview-button, .htmega-template-library-preview" 
            },
            events: { 
                "click @ui.previewButton": "onPreviewButtonClick"
            },
            behaviors: { 
                insertTemplate: { behaviorClass: moduleExp.Behaviors.InsertTemplate } 
            },
            onPreviewButtonClick: function () {
                htmega.library.showPreviewView(this.model);
            },
        }
    );

    moduleExp.Views.Loading = Marionette.ItemView.extend(
        { 
            template: "#tmpl-htmega-template-library-loading", 
            id: "htmega_templateLibrary_loading" 
        }
    );

    moduleExp.Views.InsertWrapper = Marionette.ItemView.extend(
        {
            template: "#tmpl-htmega-template-library-header-insert",
            id: "elementor-template-library-header-preview",
            behaviors: { 
                insertTemplate: { behaviorClass: moduleExp.Behaviors.InsertTemplate }
            },
        }
    );

    moduleExp.Views.Preview = Marionette.ItemView.extend(
        {
            template: "#tmpl-htmega-template-library-preview",
            className: "htmega_templateLibrary_preview",
            ui: function () {
                return { iframe: "> iframe" };
            },
            onRender: function () {
                this.ui.iframe.attr("src", this.getOption("url")).hide();
                var e = this,
                    t = new moduleExp.Views.Loading().render();
                this.$el.append(t.el),
                this.ui.iframe.on("load", function () {
                    e.$el.find("#htmega_templateLibrary_loading").remove(), e.ui.iframe.show();
                });
            },
        }
    );

    moduleExp.Modal = elementorModules.common.views.modal.Layout.extend({
        
        getModalOptions: function () {
            return { 
                id: "htmega-template-library-modal"
            };
        },

        getLogo: function ( title ) {
            this.getHeaderView().logoArea.show(new moduleExp.Views.Logo(title));
        },

        showDefaultHeader: function () {
            this.getLogo({ title: "HT MEGA LIBRARY" });
            var headerview = this.getHeaderView();
            headerview.menuArea.show( new moduleExp.Views.Menu() ),
            headerview.tools.show( new moduleExp.Views.Actions() );
        },

        getTemplateActionButton: function (e) {
            var buttonClass = e.isPro && !false ? "get-pro-button" : "insert-button";
            return ( viewId = "#tmpl-htmega-template-library-" + buttonClass ), 
            (template = Marionette.TemplateCache.get(viewId)), 
            Marionette.Renderer.render(template);
        },

        showPreviewView: function (e) {
            var headerview = this.getHeaderView();
            headerview.logoArea.show(new moduleExp.Views.BackButton()),
            headerview.menuArea.show(new moduleExp.Views.ResponsiveMenu()),
            headerview.tools.show(new moduleExp.Views.InsertWrapper({ model: e })), 
            this.modalContent.show(new moduleExp.Views.Preview({ url: e.get("url") }));
        },

        showBlocksView: function (e) {
            this.modalContent.show(new moduleExp.Views.TemplateCollection({ collection: e }));
        },
    });

    moduleExp.Manager = function () {
        var l,
            s,
            d,
            c,
            m = this,
            s = { desktop: "100%", tab: "768px", mobile: "360px" };
        function a() {
            var t = $(this).closest(".elementor-top-section"),
                i = t.data("model-cid"),
                a = window.elementor.sections;
            a.currentView.collection.length &&
                _.each(a.currentView.collection.models, function (e, t) {
                    i === e.cid && (m.atIndex = t);
                }),
                t.prev(".elementor-add-section").find(FIND_SELECTOR).before(HtLibraryPopUpBtn);
        }

        function n(e) {
            var t = e.find(FIND_SELECTOR);
            t.length && t.before(HtLibraryPopUpBtn), e.on("click.onAddElement", ".elementor-editor-section-settings .elementor-editor-element-add", a);
        }

        function r(t, i) {
            $(".htemega_templateLibrary_preview").css("width", "100%");
        }

        function p(e, t) {
            t.addClass("elementor-active").siblings().removeClass("elementor-active");
            t = s[e] || s.desktop;
            $(".htmega_templateLibrary_preview").css("width", t);
        }

        function o() {
            var e = window.elementor.$previewContents,
                t = setInterval(function () {
                    n(e), e.find(".elementor-add-new-section").length > 0 && clearInterval(t);
                }, 100);

                e.on("click.onAddTemplateButton", ".elementor-add-htmega-template-button", m.showModal.bind(m));
                this.channels.tabs.on("change:device", p);
        }

        this.updateBlocksView = function () {
            htmega.library.setFilter("tags", "", !0), htmega.library.setFilter("text", "", !0), htmega.library.getModal(),htmega.library.showBlocksView();
        };

        FIND_SELECTOR = ".elementor-add-new-section .elementor-add-section-drag-title";

        HtLibraryPopUpBtn = '<div class="elementor-add-section-area-button elementor-add-htmega-template-button"><img src="'+HTMEGAETMP.icon+'" /></div>';

        this.atIndex = -1;

        this.channels = { 
            tabs: Backbone.Radio.channel("tabs"), 
            templates: Backbone.Radio.channel("templates") 
        };

        this.init = function () {
            winelementor.on("preview:loaded", o.bind(this));
        };

        this.showModal = function (){
            m.getModal().showModal(),m.showBlocksView();
        };

        this.getModal = function () {
            return l || (l = new moduleExp.Modal()), l;
        };

        this.getTabs = function () {
            return { 
                tabs: { 
                    section: { 
                        title: "Blocks", 
                        active: false 
                    },
                    page: { 
                        title: "Pages", 
                        active: true 
                    }
                }
            };
        };

        this.setFilter = function (e, t, i) {
            m.channels.templates.reply("filter:" + e, t), 
            i || m.channels.templates.trigger("filter:change");
        };

        this.getFilter = function (e) {
            return m.channels.templates.request("filter:" + e);
        };

        this.getFilterTerms = function () {
            return {
                text: {
                    callback: function (e) {
                        return (
                            (e = e.toLowerCase()),
                            this.get("title").toLowerCase().indexOf(e) >= 0 ||
                                _.any(this.get("tags"), function (t) {
                                    return t.indexOf(e) >= 0;
                                })
                        );
                    },
                },
                type: {
                    callback: function (e) {
                        return (
                            (e = e.toLowerCase()),
                            this.get("type").toLowerCase().indexOf(e) >= 0
                        );
                    },
                },
                category: {
                    callback: function (category) {
                        if (!category) {
                            if (htFilterText === 'page') {
                                var title = (this.get('title') || '').toLowerCase();
                                var tags = this.get('tags') || [];
                                return title.indexOf('home') !== -1 ||
                                    _.any(tags, function (tag) {
                                        return String(tag).toLowerCase().indexOf('home') !== -1;
                                    });
                            }
                            return true;
                        }
                        var shareId = this.get("shareId");
                        return shareId === category;
                    }
                }

            };
        };

        this.showBlocksView = function () {
            m.getModal().showDefaultHeader();
            $('[data-tab="'+htFilterText+'"]').addClass("elementor-active").siblings().removeClass("elementor-active");
            m.setFilter("text", "", true),
            m.loadTemplates(function () {
                m.getModal().showBlocksView(d);
            });
        };

        this.showPreviewView = function (e) {
            m.getModal().showPreviewView(e);
        };

        this.loadTemplates = function (e) {
            m.getLibraryData({
                onBeforeUpdate: m.getModal().showLoadingView.bind(m.getModal()),
                onUpdate: function () {
                    m.getModal().hideLoadingView(), e && e();
                },
            });
        };

        this.getLibraryData = function (e) {
            if (d && !e.forceUpdate) return void (e.onUpdate && e.onUpdate());
            e.onBeforeUpdate && e.onBeforeUpdate();
            var t = {
                data: {},
                success: function (t) {
                    d = new moduleExp.Collections.Template(t.templates);

                    if (htFilterText === 'page') {
                        d.comparator = function(model) {
                            var dateVal = model.get('date') || model.get('human_date') || '';
                            var time = new Date(dateVal).getTime() || parseInt(model.get('id')) || 0;
                            return -time;
                        };
                        d.sort();
                    }

                    t.tags && (s = t.tags);
                    e.onUpdate && e.onUpdate();
                },
            };
            e.forceSync && (t.data.sync = true), 
            elementorCommon.ajax.addRequest("get_htmega_library_data", t);
        };

        this.getTemplateContent = function (id, ajaxOptions) {
            var options = { 
                unique_id: id, 
                data: { 
                    edit_mode: true,
                    display: true,
                    template_id: id 
                } 
            };
            ajaxOptions && jQuery.extend( true, options, ajaxOptions), 
            elementorCommon.ajax.addRequest("get_htmega_template_data", options);
        };

        this.insertTemplate = function (e) {
            var t = e.model,
                i = this;             
            i.getModal().showLoadingView(),
            i.getTemplateContent(t.get("id"), {
                success: function (e) {
                    i.getModal().hideLoadingView(), 
                    i.getModal().hideModal();
                    var payload = jQuery.extend(true, {}, e || {}),
                        placement = {};
                    delete payload.htmega_reload_editor,
                    -1 !== i.atIndex && (placement.at = i.atIndex),
                    window.setTimeout(function () {
                        var runImport = function () {
                            var importDeferred = $e.run("document/elements/import", {
                                model: t,
                                data: payload,
                                options: placement
                            });
                            htmegaAfterLibraryImportRebindPreviewCarousels(importDeferred);
                        };
                        if (e && e.htmega_reload_editor) {
                            htmegaRefreshElementorWidgetsConfigThen(runImport);
                        } else {
                            runImport();
                        }
                    }, 10),
                    i.atIndex = -1;
                },
                error: function (e) {
                    i.showErrorDialog(e);
                },
                complete: function (e) {
                    i.getModal().hideLoadingView();
                },
            });
        };

        this.showErrorDialog = function (e) {
            if ("object" == typeof e) {
                var t = "";
                _.each(e, function (e) {
                    t += "<div>" + e.message + ".</div>";
                }),
                (e = t);
            } else e ? (e += ".") : (e = "<i>&#60;The error message is empty&#62;</i>");
            m.getErrorDialog()
                .setMessage('The following error(s) occurred while processing the request:<div id="elementor-template-library-error-info">' + e + "</div>")
                .show();
        };

        this.getErrorDialog = function () {
            return c || (
                c = elementorCommon.dialogsManager.createWidget(
                    "alert", 
                    { 
                        id: "elementor-template-library-error-dialog", 
                        headerMessage: "An error occurred" 
                    }
                )
            ), 
            c;
        };

        this.updateCategoryFilter = function(type) {
            var categories = m.getCategories(type);
            var categorySelect = $('#elementor-template-library-filter-category');
            categorySelect.empty();

            // Add a default option
            categorySelect.append('<option value="">Select Category</option>');

            _.each(categories, function(category) {
                categorySelect.append('<option value="' + category + '">' + category + '</option>');
            });

            categorySelect.trigger('change');
        };

        this.getCategories = function(templateType = 'page') {
            if (!d) return [];
            try {
                    // Filter models by the template type first
                    var filteredModels = _.filter(d.models, function(model) {
                        return model.get('type') === templateType;
                    });

                    var categories = _.uniq(_.compact(_.map(filteredModels, function(model) {
                        return model.get('shareId'); 
                    })));
                    
                return categories;
            } catch (err) {
                console.log('Error getting categories:', err);
                return [];
            }
        };

    };

    window.htmega.library = new moduleExp.Manager();
    window.htmega.library.init();

})(jQuery, window.elementor);
