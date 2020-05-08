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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/checkout.js":
/*!**********************************!*\
  !*** ./resources/js/checkout.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  //retrieve selected option if user edits address if stored in session
  var selected = sessionStorage.getItem('selected');

  if (selected) {
    $("#address_select").val(selected); //include csrf token

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }); //retrieves selected adddress details from database

    $.ajax({
      url: '/checkout/address/' + selected,
      method: 'GET',
      success: function success(response) {
        var address_id = response[0]['address_id'];
        var address_address = response[0]['address_address'];
        var landmark = response[0]['landmark'];
        $('.display_address').removeClass('d-none');
        $("#address").empty();
        $("#landmark").empty();
        $("#edit_btn").empty();
        $("#state_country").empty();
        $("#address").append("<p>" + address_address + "</p>");

        if (landmark != null) {
          $("#landmark").append("<p>Near " + landmark + "</p>");
        }

        $("#state_country").append("<p>Akwa Ibom State, Nigeria.</p>");
        $("#edit_btn").append("<a id='edit_address_" + address_id + "'href='/account/address-book/edit/" + address_id + "?prev_url=checkout' class='btn btn-primary btn-block edit_btn'>Edreereit</a>");
      }
    });
    sessionStorage.clear(); //clears session storage
  } //retrieves address details from database if option is selected


  $.each(addressArray, function (index, value) {
    $('#address_select').on('change', function () {
      if (this.value == value) {
        sessionStorage.setItem('selected', this.value);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: '/checkout/address/' + value,
          method: 'GET',
          success: function success(response) {
            var address_id = response[0]['address_id'];
            var address_address = response[0]['address_address'];
            var landmark = response[0]['landmark'];
            $('.display_address').removeClass('d-none');
            $("#address").empty();
            $("#landmark").empty();
            $("#edit_btn").empty();
            $("#state_country").empty();
            $("#address").append("<p>" + address_address + "</p>");
            $("#landmark").append("<p>Near " + landmark + "</p>");
            $("#state_country").append("<p>Akwa Ibom State, Nigeria.</p>");
            $("#edit_btn").append("<a id='edit_address_" + address_id + "'href='/account/address-book/edit/" + address_id + "?prev_url=checkout' class='btn btn-primary btn-block edit_btn'>Edit</a>");
          }
        });
      } else {
        $('.display_address').addClass('d-none');
      }
    });
  }); //proceeds to checkout

  $('#pay').on('click', function () {
    $('#delivery_address_id').val($('#address_select').val());
    setTimeout(function () {
      if ($('#delivery_address_id').val() == "") {
        $('#payment_error').empty();
        $('#payment_error').append('* Please select a delivery address');
      } else {
        $('#paystack_form').submit();
      }
    }, 1000);
  }); //email verified check

  $('#pay_null').on('click', function () {
    $('#delivery_address_id').val($('#address_select').val());
    setTimeout(function () {
      if ($('#delivery_address_id').val() == "") {
        $('#payment_error').empty();
        $('#payment_error_null').append('* Please verify your email address.');
      } else {
        $('#paystack_form').submit();
      }
    }, 1000);
  });
});

/***/ }),

/***/ 2:
/*!****************************************!*\
  !*** multi ./resources/js/checkout.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/anthony/www/melamart/resources/js/checkout.js */"./resources/js/checkout.js");


/***/ })

/******/ });