(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[34],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/File.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/File.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    file: {
      type: [File, Object],
      required: true
    },
    readonly: Boolean
  },
  methods: {
    formatSize: function formatSize(bytes) {
      var unit = 'KB';
      var formatted = bytes / 1024;

      if (formatted >= 700) {
        formatted /= 1024;
        unit = 'MB';
      }

      return formatted.toFixed(1) + unit;
    }
  },
  computed: {
    type: function type() {
      var type = this.file.type;
      if (type.includes('image')) return 'image';
      if (type.includes('pdf')) return 'pdf';
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/sass-resources-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-3!./node_modules/sass-loader/dist/cjs.js??ref--7-4!./node_modules/sass-resources-loader/lib/loader.js??ref--7-5!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "/* --------------------------------- Colors --------------------------------- */\n/* ------------------------------- Typography ------------------------------- */\n/* -------------------------------- Elevation ------------------------------- */\n/* -------------------------------------------------------------------------- */\n/*                                 Components                                 */\n/* -------------------------------------------------------------------------- */\n/* --------------------------------- Button --------------------------------- */\n/* ---------------------------------- Input --------------------------------- */\n/* -------------------------------- Checkbox -------------------------------- */\n/* ---------------------------------- Radio --------------------------------- */\n/* --------------------------------- Select --------------------------------- */\n.file[data-v-77c84e67]:not(:last-child) {\n  border-bottom: 1px solid #c2c8cc;\n}\n.file__container[data-v-77c84e67] {\n  padding: 0.75rem;\n}\n.file__container[data-v-77c84e67],\n.file__controls[data-v-77c84e67] {\n  display: flex;\n  align-items: center;\n}\n.file__icon[data-v-77c84e67] {\n  font-size: 2rem !important;\n}\n.file--is-image .file__icon[data-v-77c84e67] {\n  color: #f6993f;\n}\n.file--is-pdf .file__icon[data-v-77c84e67] {\n  color: #dc3545;\n}\n.file__name[data-v-77c84e67] {\n  white-space: nowrap !important;\n  overflow: hidden !important;\n  text-overflow: ellipsis !important;\n  max-width: 100%;\n  padding: 0 0.75rem;\n  flex-grow: 1;\n}\n.file__size[data-v-77c84e67] {\n  color: #a6afb4;\n  padding: 0 1rem;\n  margin-right: 0.5rem;\n  border-right: 1px solid #c2c8cc;\n}\n.file__controls .icon[data-v-77c84e67] {\n  font-size: 1.3rem;\n  cursor: pointer;\n}\n.icon-x[data-v-77c84e67] {\n  color: #dc3545;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/extract-text-webpack-plugin/dist/loader.js?!./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/sass-resources-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/extract-text-webpack-plugin/dist/loader.js??ref--7-0!./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-3!./node_modules/sass-loader/dist/cjs.js??ref--7-4!./node_modules/sass-resources-loader/lib/loader.js??ref--7-5!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-3!../../../node_modules/sass-loader/dist/cjs.js??ref--7-4!../../../node_modules/sass-resources-loader/lib/loader.js??ref--7-5!../../../node_modules/vue-loader/lib??vue-loader-options!./File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/sass-resources-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/File.vue?vue&type=template&id=77c84e67&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/File.vue?vue&type=template&id=77c84e67&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "file", class: ["file--is-" + _vm.type] }, [
    _c("div", { staticClass: "file__container" }, [
      _c("div", [
        _c("i", {
          staticClass: "file__icon icon",
          class: "icon-file-" + _vm.type
        })
      ]),
      _vm._v(" "),
      _c("p", { staticClass: "file__name" }, [
        _vm._v("\n            " + _vm._s(_vm.file.name) + "\n        ")
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "file__controls" }, [
        _c("span", { staticClass: "file__size" }, [
          _vm._v(" " + _vm._s(_vm.formatSize(_vm.file.size)) + " ")
        ]),
        _vm._v(" "),
        !_vm.readonly
          ? _c("i", {
              staticClass: "icon icon-x",
              attrs: { title: "Remover" },
              on: {
                click: function($event) {
                  return _vm.$emit("remove")
                }
              }
            })
          : _c(
              "a",
              {
                attrs: {
                  href: _vm.file.path,
                  download: _vm.file.name,
                  target: "_blank",
                  rel: "noopener noreferrer",
                  title: "Descargar"
                }
              },
              [_c("i", { staticClass: "icon icon-download" })]
            )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/File.vue":
/*!******************************************!*\
  !*** ./resources/js/components/File.vue ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _File_vue_vue_type_template_id_77c84e67_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./File.vue?vue&type=template&id=77c84e67&scoped=true& */ "./resources/js/components/File.vue?vue&type=template&id=77c84e67&scoped=true&");
/* harmony import */ var _File_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./File.vue?vue&type=script&lang=js& */ "./resources/js/components/File.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _File_vue_vue_type_style_index_0_id_77c84e67_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true& */ "./resources/js/components/File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _File_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _File_vue_vue_type_template_id_77c84e67_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _File_vue_vue_type_template_id_77c84e67_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "77c84e67",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/File.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/File.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/components/File.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./File.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/File.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true& ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_extract_text_webpack_plugin_dist_loader_js_ref_7_0_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_3_node_modules_sass_loader_dist_cjs_js_ref_7_4_node_modules_sass_resources_loader_lib_loader_js_ref_7_5_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_style_index_0_id_77c84e67_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/extract-text-webpack-plugin/dist/loader.js??ref--7-0!../../../node_modules/style-loader!../../../node_modules/css-loader!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-3!../../../node_modules/sass-loader/dist/cjs.js??ref--7-4!../../../node_modules/sass-resources-loader/lib/loader.js??ref--7-5!../../../node_modules/vue-loader/lib??vue-loader-options!./File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true& */ "./node_modules/extract-text-webpack-plugin/dist/loader.js?!./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/sass-resources-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/File.vue?vue&type=style&index=0&id=77c84e67&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_extract_text_webpack_plugin_dist_loader_js_ref_7_0_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_3_node_modules_sass_loader_dist_cjs_js_ref_7_4_node_modules_sass_resources_loader_lib_loader_js_ref_7_5_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_style_index_0_id_77c84e67_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_extract_text_webpack_plugin_dist_loader_js_ref_7_0_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_3_node_modules_sass_loader_dist_cjs_js_ref_7_4_node_modules_sass_resources_loader_lib_loader_js_ref_7_5_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_style_index_0_id_77c84e67_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_extract_text_webpack_plugin_dist_loader_js_ref_7_0_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_3_node_modules_sass_loader_dist_cjs_js_ref_7_4_node_modules_sass_resources_loader_lib_loader_js_ref_7_5_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_style_index_0_id_77c84e67_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_extract_text_webpack_plugin_dist_loader_js_ref_7_0_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_3_node_modules_sass_loader_dist_cjs_js_ref_7_4_node_modules_sass_resources_loader_lib_loader_js_ref_7_5_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_style_index_0_id_77c84e67_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_extract_text_webpack_plugin_dist_loader_js_ref_7_0_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_3_node_modules_sass_loader_dist_cjs_js_ref_7_4_node_modules_sass_resources_loader_lib_loader_js_ref_7_5_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_style_index_0_id_77c84e67_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/File.vue?vue&type=template&id=77c84e67&scoped=true&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/File.vue?vue&type=template&id=77c84e67&scoped=true& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_template_id_77c84e67_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./File.vue?vue&type=template&id=77c84e67&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/File.vue?vue&type=template&id=77c84e67&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_template_id_77c84e67_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_File_vue_vue_type_template_id_77c84e67_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
//# sourceMappingURL=34.js.map