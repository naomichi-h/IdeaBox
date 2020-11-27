$(function () {
  $("#ajax-valid").on("click", function (e) {
    e.preventDefault();

    $.ajax({
      //フォームのバリデーションに使うためPOST
      type: "POST",

      url: "ajaxValid.php",

      dataType: "json",

      data: {
        //登録フォームのemailを取得
        email: $(".js-email").val(),
        password: $(".js-password").val(),
        password_re: $(".js-password_re").val(),
      },
    }).done(function (data) {
      $(".js-msg-email").text(data.email);
      $(".js-msg-password").text(data.password);
      $(".js-msg-password_re").text(data.password_re);
    });
  });
});
