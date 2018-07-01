(function($, window) {
  var SUPPORTS_FILE_READER = typeof window.FileReader != "undefined",
    _getTypes = function($input) {
      var allowedTypes = $.split(($input.valAttr("allowing") || "").toLowerCase());
      if ($.inArray("jpg", allowedTypes) > -1 && $.inArray("jpeg", allowedTypes) == -1) allowedTypes.push("jpeg");
      else if ($.inArray("jpeg", allowedTypes) > -1 && $.inArray("jpg", allowedTypes) == -1) allowedTypes.push("jpg");
      return allowedTypes
    },
    _log = function(msg) {
      if (window.console && window.console.log) {
        window.console.log(msg)
      }
    };
  $.formUtils.addValidator({
    name: "mime",
    validatorFunction: function(str, $input) {
      var files = $input.get(0).files || [];
      if (SUPPORTS_FILE_READER) {
        var valid = true,
          mime = "",
          allowedTypes = _getTypes($input);
        $.each(files, function(i, file) {
          valid = false;
          mime = file.type || "";
          $.each(allowedTypes, function(j, type) {
            valid = mime.indexOf(type) > -1;
            if (valid) {
              return false
            }
          });
          return valid
        });
        if (!valid) {
          _log("Trying to upload a file with mime type " + mime + " which is not allowed")
        }
        return valid
      } else {
        _log("FileReader not supported by browser, will check file extension");
        return $.formUtils.validators.validate_extension.validatorFunction(str, $input)
      }
    },
    errorMessage: "The file you are trying to upload is of wrong type",
    errorMessageKey: "wrongFileType"
  });
  $.formUtils.addValidator({
    name: "extension",
    validatorFunction: function(value, $input) {
      var valid = true,
        types = _getTypes($input);
      $.each($input.get(0).files || [], function(i, file) {
        var val = file.value,
          ext = val.substr(val.lastIndexOf(".") + 1);
        if ($.inArray(ext.toLowerCase(), types) == -1) {
          valid = false;
          return false
        }
      });
      return valid
    },
    errorMessage: "The file you are trying to upload is of wrong type",
    errorMessageKey: "wrongFileType"
  });
  $.formUtils.addValidator({
    name: "size",
    validatorFunction: function(val, $input) {
      var maxSize = $input.valAttr("max-size");
      if (!maxSize) {
        _log('Input "' + $input.attr("name") + '" is missing data-validation-max-size attribute');
        return true
      } else if (!SUPPORTS_FILE_READER) {
        return true
      }
      var maxBytes = $.formUtils.convertSizeNameToBytes(maxSize),
        valid = true;
      $.each($input.get(0).files || [], function(i, file) {
        valid = file.size <= maxBytes;
        return valid
      });
      return valid
    },
    errorMessage: "The file you are trying to upload is too large",
    errorMessageKey: "wrongFileSize"
  });
  $.formUtils.convertSizeNameToBytes = function(sizeName) {
    sizeName = sizeName.toUpperCase();
    if (sizeName.substr(sizeName.length - 1, 1) == "M") {
      return parseInt(sizeName.substr(0, sizeName.length - 1), 10) * 1024 * 1024
    } else if (sizeName.substr(sizeName.length - 2, 2) == "MB") {
      return parseInt(sizeName.substr(0, sizeName.length - 2), 10) * 1024 * 1024
    } else if (sizeName.substr(sizeName.length - 2, 2) == "KB") {
      return parseInt(sizeName.substr(0, sizeName.length - 2), 10) * 1024
    } else if (sizeName.substr(sizeName.length - 1, 1) == "B") {
      return parseInt(sizeName.substr(0, sizeName.length - 1), 10)
    } else {
      return parseInt(sizeName, 10)
    }
  };
  $(window).one("validatorsLoaded formValidationSetup", function(evt, $form) {
    var $inputs;
    if ($form) {
      $inputs = $form.find('input[type="file"]')
    } else {
      $inputs = $('input[type="file"]')
    }
    $inputs.filter("*[data-validation]").bind("change", function() {
      $(this).removeClass("error").parent().find(".form-error").remove()
    })
  })
})(jQuery, window);