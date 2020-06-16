(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[28],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/_questions/2.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/_questions/2.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    old: Object,
    countries: {
      type: Array,
      required: true
    },
    errors: ErrorBag,
    loading: Boolean
  },
  data: function data() {
    var old = this.old;
    old['address'] = old['address'] || {};
    return {
      form: {
        phone_prefix: old['phone_prefix'] || '',
        phone: old['phone'] || '',
        address: {
          country: old['address']['country'] || '',
          city: old['address']['city'] || '',
          line: old['address']['line'] || '',
          zip_code: old['address']['zip_code'] || '',
          state: old['address']['state'] || ''
        }
      }
    };
  },
  methods: {
    handleSubmit: function handleSubmit() {
      this.$emit('submit', this.form);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/_questions/2.vue?vue&type=template&id=40c328cc&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/_questions/2.vue?vue&type=template&id=40c328cc& ***!
  \**********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "form",
    {
      staticClass: "questions",
      on: {
        submit: function($event) {
          $event.preventDefault()
          return _vm.handleSubmit($event)
        }
      }
    },
    [
      _c("h1", { staticClass: "margin-bottom--three" }, [
        _vm._v("Infomación de contacto")
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-xs-12 col-sm-6" }, [
          _c("h5", { staticClass: "margin-bottom--zero" }, [
            _vm._v("Teléfono")
          ]),
          _vm._v(" "),
          _vm.errors.has("phone_prefix") || _vm.errors.has("phone")
            ? _c("span", { staticClass: "error", attrs: { role: "alert" } }, [
                _vm._v(
                  _vm._s(
                    _vm.errors.first("phone_prefix") ||
                      _vm.errors.first("phone")
                  )
                )
              ])
            : _vm._e(),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "d-flex" },
            [
              _c("Input", {
                staticClass: "margin-right--one",
                staticStyle: { width: "55px" },
                attrs: { placeholder: "+00", required: "" },
                model: {
                  value: _vm.form.phone_prefix,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "phone_prefix", $$v)
                  },
                  expression: "form.phone_prefix"
                }
              }),
              _vm._v(" "),
              _c("Input", {
                attrs: { type: "tel" },
                model: {
                  value: _vm.form.phone,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "phone", $$v)
                  },
                  expression: "form.phone"
                }
              })
            ],
            1
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "h5",
          { staticClass: "margin-top--two margin-bottom--zero col-xs-12" },
          [_vm._v("\n            Dirección\n        ")]
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-xs-12 col-sm-6" },
          [
            _c("Select", {
              attrs: {
                label: "país",
                options: _vm.countries,
                error: _vm.errors.first("address.country")
              },
              model: {
                value: _vm.form.address.country,
                callback: function($$v) {
                  _vm.$set(_vm.form.address, "country", $$v)
                },
                expression: "form.address.country"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-xs-12 col-sm-6" },
          [
            _c("Input", {
              attrs: {
                label: "cuidad",
                error: _vm.errors.first("address.city")
              },
              model: {
                value: _vm.form.address.city,
                callback: function($$v) {
                  _vm.$set(_vm.form.address, "city", $$v)
                },
                expression: "form.address.city"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("Input", {
        attrs: {
          label: "dirección",
          error: _vm.errors.first("address.line"),
          textarea: ""
        },
        model: {
          value: _vm.form.address.line,
          callback: function($$v) {
            _vm.$set(_vm.form.address, "line", $$v)
          },
          expression: "form.address.line"
        }
      }),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-xs-12 col-sm-6" },
          [
            _c("Input", {
              attrs: {
                label: "código postal",
                error: _vm.errors.first("address.zip_code"),
                type: "number"
              },
              model: {
                value: _vm.form.address.zip_code,
                callback: function($$v) {
                  _vm.$set(_vm.form.address, "zip_code", $$v)
                },
                expression: "form.address.zip_code"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-xs-12 col-sm-6" },
          [
            _c("Input", {
              attrs: {
                error: _vm.errors.first("address.state"),
                label: "estado/provincia"
              },
              model: {
                value: _vm.form.address.state,
                callback: function($$v) {
                  _vm.$set(_vm.form.address, "state", $$v)
                },
                expression: "form.address.state"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "margin-top--two" },
        [
          _c(
            "Button",
            { attrs: { href: _vm.route("questions", 1), flat: "" } },
            [_vm._v("Atras")]
          ),
          _vm._v(" "),
          _c("Button", { attrs: { type: "submit", loading: _vm.loading } }, [
            _vm._v("Siguiente")
          ])
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/_questions/2.vue":
/*!*********************************************!*\
  !*** ./resources/js/pages/_questions/2.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _2_vue_vue_type_template_id_40c328cc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./2.vue?vue&type=template&id=40c328cc& */ "./resources/js/pages/_questions/2.vue?vue&type=template&id=40c328cc&");
/* harmony import */ var _2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./2.vue?vue&type=script&lang=js& */ "./resources/js/pages/_questions/2.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _2_vue_vue_type_template_id_40c328cc___WEBPACK_IMPORTED_MODULE_0__["render"],
  _2_vue_vue_type_template_id_40c328cc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/_questions/2.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/_questions/2.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/pages/_questions/2.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./2.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/_questions/2.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/_questions/2.vue?vue&type=template&id=40c328cc&":
/*!****************************************************************************!*\
  !*** ./resources/js/pages/_questions/2.vue?vue&type=template&id=40c328cc& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_2_vue_vue_type_template_id_40c328cc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./2.vue?vue&type=template&id=40c328cc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/_questions/2.vue?vue&type=template&id=40c328cc&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_2_vue_vue_type_template_id_40c328cc___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_2_vue_vue_type_template_id_40c328cc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
//# sourceMappingURL=28.js.map