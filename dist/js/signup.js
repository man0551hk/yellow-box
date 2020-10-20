function CheckSignup(key, errMsg, existedEmail) {
  var error = 0;
  var response = grecaptcha.getResponse();
  if (response.length == 0) {
    error +=1;
  } else {
    var txtPassword = document.getElementById("password");
    var txtConfirmPassword = document.getElementById("confirmPassword");
    txtConfirmPassword.setCustomValidity("");
  
    if (txtPassword.value != txtConfirmPassword.value) {
      txtConfirmPassword.setCustomValidity(errMsg);
      error += 1;
    }
    var isExisted = CheckEmailExist(key);
    if (isExisted > 0) {
      document.getElementById("email").setCustomValidity(existedEmail);
    }
    error +=isExisted
  }

  if (error > 0) {
    return false;
  }

  return true;
}

function CheckEmailExist(key) {
  var isExisted = 0;
  $.ajax({
    type: "POST",
    url: domain + "api/user/checkEmail/",
    async: false,
    dataType: "json",
    headers: {
      "internal-client-key": key
    },
    data: {
      email: document.getElementById("email").value
    },
    success: function (response) {
      console.log(response);
      isExisted = response.isExisted;
    },
    error: function (jqXHR, exception) {
      console.log(exception);
      console.log(jqXHR.responseText);
    }
  });
  
  return isExisted;
}

function imNotARobot() {
  $("#submitType").removeClass("disable");
}

function CheckLogin () {
  var error = 0;
  var response = grecaptcha.getResponse();
  if (response.length == 0) {
    error +=1;
  }
  if (error > 0) {
    return false;
  } 
  return true;
}