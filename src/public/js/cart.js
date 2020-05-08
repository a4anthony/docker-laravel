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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/cart.js":
/*!******************************!*\
  !*** ./resources/js/cart.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  //for (var i = 0; i < id.length; i++) {
  $.each(id, function (index, value) {
    //console.log(value);
    $("#result").append(index + ": " + value + '<br>'); //$(".cart-plus-minus" + value).append('<div class="dec qtybutton qtybutton' + value + '">-</div><div class="inc qtybutton qtybutton' + value + '">+</div>');

    $(".qtybutton_cart" + value).on("click", function () {
      //var $input = $('#quantity' + value);
      var $button = $(this);
      var oldValue = $('#quantity' + value).val();

      if ($button.text() == "+") {
        if (oldValue < 10) {
          var newVal = parseFloat(oldValue) + 1;
          $('#quantity' + value).val(newVal); //$('#update_quantity' + value).submit();

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: '/cart/update/' + value + '/' + newVal,
            method: 'PUT',
            success: function success(response) {
              $('#total_price' + value).html('<span> &#8358;</span>' + response.total);
              $('#item_total' + value).html('<span> &#8358;</span>' + response.total);
              $('#item_initial' + value).html('<span> &#8358;</span>' + response.initialTotal);
              $('#item_total_bg' + value).html('<span> &#8358;</span>' + response.total);
              $('#item_initial_bg' + value).html('<span> &#8358;</span>' + response.initialTotal);
              $('#cart_total').html('<span class="pull-left"> Total </span><span>&#8358;' + response.cartTotal + '</span>');
              $('#cart_total_sub').html('<span class="pull-left"> Subtotal </span><span>&#8358;' + response.cartTotal + '</span>');
            }
          });
        } else {
          var newVal = 10;
        }
      } else {
        // Don't allow decrementing below zero
        if (oldValue > 1) {
          var newVal = parseFloat(oldValue) - 1;
          $('#quantity' + value).val(newVal);
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: '/cart/update/' + value + '/' + newVal,
            method: 'PUT',
            //data: $('#add_item_to_cart').serialize(),
            success: function success(response) {
              $('#total_price' + value).html('<span> &#8358;</span>' + response.total);
              $('#item_total' + value).html('<span> &#8358;</span>' + response.total);
              $('#item_initial' + value).html('<span> &#8358;</span>' + response.initialTotal);
              $('#item_total_bg' + value).html('<span> &#8358;</span>' + response.total);
              $('#item_initial_bg' + value).html('<span> &#8358;</span>' + response.initialTotal);
              $('#cart_total').html('<span class="pull-left"> Total </span><span>&#8358;' + response.cartTotal + '</span>');
              $('#cart_total_sub').html('<span class="pull-left"> Subtotal </span><span>&#8358;' + response.cartTotal + '</span>');
            }
          });
        } else {
          newVal = 1;
        }
      }

      $button.parent().find("input").val(newVal);
    });
  }); //};
});

/***/ }),

/***/ 1:
/*!************************************!*\
  !*** multi ./resources/js/cart.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/anthony/www/melamart/resources/js/cart.js */"./resources/js/cart.js");


/***/ })

/******/ });