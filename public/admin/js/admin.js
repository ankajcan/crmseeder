/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 37);
/******/ })
/************************************************************************/
/******/ ({

/***/ 2:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Helper = function () {
    function Helper() {
        _classCallCheck(this, Helper);
    }

    _createClass(Helper, null, [{
        key: 'getFormResults',
        value: function getFormResults(form) {
            var formElements = form.elements;
            var formParams = {};
            var dots = 0;
            var elem = null;
            for (var i = 0; i < formElements.length; i += 1) {
                elem = formElements[i];
                switch (elem.type) {
                    case 'submit':
                        break;
                    case 'radio':
                        if (elem.checked) {
                            dots = elem.name.split(".");
                            if (dots.length > 1) {
                                // item.something
                                var brackets = dots[0].search(/\[[0-9]\]/);
                                if (brackets > -1) {
                                    // items[0].something
                                    var key = dots[0].substring(0, brackets); // items
                                    var index = dots[0][brackets + 1]; // 0
                                    if (!formParams.hasOwnProperty(key)) {
                                        formParams[key] = [];
                                    }
                                    if (!formParams[key].hasOwnProperty(index)) {
                                        formParams[key][index] = {};
                                    }
                                    formParams[key][index][dots[1]] = elem.value;
                                } else {
                                    if (!formParams.hasOwnProperty(dots[0])) {
                                        formParams[dots[0]] = {};
                                    }
                                    formParams[dots[0]][dots[1]] = elem.value;
                                }
                            } else if (elem.name.slice(-2) === '[]') {
                                // array[]
                                var _key = elem.name.substring(0, elem.name.length - 2);
                                if (!formParams.hasOwnProperty(_key)) {
                                    formParams[_key] = [];
                                }
                                formParams[_key].push(elem.value);
                            } else {
                                formParams[elem.name] = elem.value;
                            }
                        }
                        break;
                    case 'checkbox':
                        if (elem.checked) {
                            dots = elem.name.split(".");
                            if (dots.length > 1) {
                                var brackets = dots[0].search(/\[[0-9]\]/);
                                if (brackets > -1) {
                                    // items[0].something
                                    var key = dots[0].substring(0, brackets); // items
                                    var index = dots[0][brackets + 1]; // 0
                                    if (!formParams.hasOwnProperty(key)) {
                                        formParams[key] = [];
                                    }
                                    if (!formParams[key].hasOwnProperty(index)) {
                                        formParams[key][index] = {};
                                    }
                                    formParams[key][index][dots[1]] = elem.value;
                                } else {
                                    if (!formParams.hasOwnProperty(dots[0])) {
                                        formParams[dots[0]] = {};
                                    }
                                    formParams[dots[0]][dots[1]] = elem.value;
                                }
                            } else if (elem.name.slice(-2) === '[]') {
                                var _key2 = elem.name.substring(0, elem.name.length - 2);
                                if (!formParams.hasOwnProperty(_key2)) {
                                    formParams[_key2] = [];
                                }
                                formParams[_key2].push(elem.value);
                            } else {
                                formParams[elem.name] = elem.value;
                            }
                        }
                        break;
                    case 'text':
                        if (elem.value != "") {
                            dots = elem.name.split(".");
                            if (dots.length > 1) {
                                var brackets = dots[0].search(/\[[0-9]\]/);
                                if (brackets > -1) {
                                    // items[0].something
                                    var key = dots[0].substring(0, brackets); // items
                                    var index = dots[0][brackets + 1]; // 0
                                    if (!formParams.hasOwnProperty(key)) {
                                        formParams[key] = [];
                                    }
                                    if (!formParams[key].hasOwnProperty(index)) {
                                        formParams[key][index] = {};
                                    }
                                    formParams[key][index][dots[1]] = elem.value;
                                } else {
                                    if (!formParams.hasOwnProperty(dots[0])) {
                                        formParams[dots[0]] = {};
                                    }
                                    formParams[dots[0]][dots[1]] = elem.value;
                                }
                            } else if (elem.name.slice(-2) === '[]') {
                                var _key3 = elem.name.substring(0, elem.name.length - 2);
                                if (!formParams.hasOwnProperty(_key3)) {
                                    formParams[_key3] = [];
                                }
                                formParams[_key3].push(elem.value);
                            } else {
                                formParams[elem.name] = elem.value;
                            }
                        }
                        break;
                    case 'number':
                        if (elem.value != "") {
                            dots = elem.name.split(".");
                            if (dots.length > 1) {
                                var brackets = dots[0].search(/\[[0-9]\]/);
                                if (brackets > -1) {
                                    // items[0].something
                                    var key = dots[0].substring(0, brackets); // items
                                    var index = dots[0][brackets + 1]; // 0
                                    if (!formParams.hasOwnProperty(key)) {
                                        formParams[key] = [];
                                    }
                                    if (!formParams[key].hasOwnProperty(index)) {
                                        formParams[key][index] = {};
                                    }
                                    formParams[key][index][dots[1]] = elem.value;
                                } else {
                                    if (!formParams.hasOwnProperty(dots[0])) {
                                        formParams[dots[0]] = {};
                                    }
                                    formParams[dots[0]][dots[1]] = elem.value;
                                }
                            } else if (elem.name.slice(-2) === '[]') {
                                var _key4 = elem.name.substring(0, elem.name.length - 2);
                                if (!formParams.hasOwnProperty(_key4)) {
                                    formParams[_key4] = [];
                                }
                                formParams[_key4].push(elem.value);
                            } else {
                                formParams[elem.name] = elem.value;
                            }
                        }
                        break;
                    default:
                        dots = elem.name.split(".");
                        if (dots.length > 1) {
                            var brackets = dots[0].search(/\[[0-9]\]/);
                            if (brackets > -1) {
                                // items[0].something
                                var key = dots[0].substring(0, brackets); // items
                                var index = dots[0][brackets + 1]; // 0
                                if (!formParams.hasOwnProperty(key)) {
                                    formParams[key] = [];
                                }
                                if (!formParams[key].hasOwnProperty(index)) {
                                    formParams[key][index] = {};
                                }
                                formParams[key][index][dots[1]] = elem.value;
                            } else {
                                if (!formParams.hasOwnProperty(dots[0])) {
                                    formParams[dots[0]] = {};
                                }
                                formParams[dots[0]][dots[1]] = elem.value;
                            }
                        } else if (elem.name.slice(-2) === '[]') {
                            var _key5 = elem.name.substring(0, elem.name.length - 2);
                            if (!formParams.hasOwnProperty(_key5)) {
                                formParams[_key5] = [];
                            }
                            formParams[_key5].push(elem.value);
                        } else {
                            formParams[elem.name] = elem.value;
                        }
                }
            }

            return formParams;
        }
    }, {
        key: 'encodeQueryData',
        value: function encodeQueryData(data) {
            var ret = [];
            for (var d in data) {
                if (data[d] != "") {
                    ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
                }
            }
            return ret.join('&');
        }
    }, {
        key: 'startLoading',
        value: function startLoading() {
            $("#loader").removeClass("hidden");
        }
    }, {
        key: 'endLoading',
        value: function endLoading() {
            $("#loader").addClass("hidden");
        }
    }]);

    return Helper;
}();

/* harmony default export */ __webpack_exports__["a"] = (Helper);

/***/ }),

/***/ 3:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Errors = function () {
    /**
     * Create a new Errors instance.
     */
    function Errors() {
        _classCallCheck(this, Errors);

        this.errors = {};
    }

    /**
     * Determine if an errors exists for the given field.
     *
     * @param {string} field
     */


    _createClass(Errors, [{
        key: 'has',
        value: function has(field) {
            return this.errors.hasOwnProperty(field);
        }

        /**
         * Determine if we have any errors.
         */

    }, {
        key: 'any',
        value: function any() {
            return Object.keys(this.errors).length > 0;
        }

        /**
         * Retrieve the error message for a field.
         *
         * @param {string} field
         */

    }, {
        key: 'get',
        value: function get(field) {
            if (this.errors[field]) {
                return this.errors[field];
            }
        }

        /**
         * Record the new errors.
         *
         * @param {object} errors
         */

    }, {
        key: 'record',
        value: function record(errors) {
            this.errors = errors;
        }

        /**
         * Clear one or all error fields.
         *
         */

    }, {
        key: 'clear',
        value: function clear() {
            for (var key in this.errors) {
                $('*[data-error="' + key + '"]').removeClass("has-error");
                $('*[data-error="' + key + '"] .error-content').html("");
            }

            this.errors = {};
        }
    }, {
        key: 'show',
        value: function show() {
            for (var key in this.errors) {
                $('*[data-error="' + key + '"]').addClass("has-error");
                $('*[data-error="' + key + '"] .error-content').html(this.errors[key]);
            }
        }
    }]);

    return Errors;
}();

/* harmony default export */ __webpack_exports__["a"] = (Errors);

/***/ }),

/***/ 37:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(38);


/***/ }),

/***/ 38:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helper_js__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__classes_Errors__ = __webpack_require__(3);
window.base_api = '';



var errors = new __WEBPACK_IMPORTED_MODULE_1__classes_Errors__["a" /* default */]();

function startLoading() {
    $("#loader").removeClass("hidden");
}

function endLoading() {
    $("#loader").addClass("hidden");
}

/**
 * Update/create user
 */
$("#update-user").submit(function (event) {
    errors.clear();
    var data = Object(__WEBPACK_IMPORTED_MODULE_0__helper_js__["a" /* default */])(this);
    startLoading();

    if (data['id'] != undefined) {
        // UPDATE USER
        axios.put(base_api + '/users/' + data['id'], data).then(function (response) {
            location.reload();
        }).catch(function (error) {
            errors.record(error.response.data.details);
            errors.show();
        });
    } else {
        // NEW USER
        axios.post(base_api + '/users', data).then(function (response) {
            window.location.href = '/admin/users';
        }).catch(function (error) {
            errors.record(error.response.data.details);
            errors.show();
        });
    }

    endLoading();
    event.preventDefault();
});

/**
 * Delete user
 */
$("#btn-delete-user").on('click', function (evt) {

    var user_id = $(this).attr("data-user-id");

    axios.delete(base_api + '/users/' + user_id, {}).then(function (response) {
        window.location.href = '/admin/users';
    }).catch(function (error) {
        console.log(error);
    });
});

/**
 * Open user avatar upload dialog
 */
$("#btn-avatar-upload").on('click', function (evt) {
    $("#input-avatar-upload").click();
});

/**
 * Upload user avatar
 */
$("#input-avatar-upload").on('change', function (evt) {
    var files = evt.target.files;
    var formData = new FormData();
    formData.append('file', files[0]);
    var config = {
        headers: {
            'content-type': 'multipart/form-data'
        }
    };
    startLoading();
    axios.post(base_api + '/users/avatar-upload', formData, config).then(function (response) {
        console.log(response.data);
        $("#img-user-avatar").attr("src", "/" + response.data);
        $("#input-user-avatar").val(response.data);
        endLoading();
    }).catch(function (error) {
        console.log(error);
        endLoading();
    });
});

/***/ })

/******/ });