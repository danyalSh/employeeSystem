/**
 * Created by ahsan on 20/10/16.
 */

function loginWithAPI(res) {
  console.log(res);
  var form = new FormData();
  form.append("name", res.name);
  form.append("email", res.email);

  var settings = {
    "async": true,
    "crossDomain": true,
    "url": "/loginSocialUser",
    "method": "POST",
    "headers": {
      "cache-control": "no-cache",
      "postman-token": "9893f706-b932-4341-a9c7-b760549e16ee"
    },
    "processData": false,
    "contentType": false,
    "mimeType": "multipart/form-data",
    "data": form
  }

  $.ajax(settings).done(function (response) {
    console.log(response);
    response = JSON.parse(response);
    console.log(response.code);
    if (response.code == 200) {
      window.location.reload();
    }
  });
}