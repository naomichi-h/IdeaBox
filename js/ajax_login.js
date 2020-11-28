$(function () {
  $("#ajax-valid").on("click", function (e) {
    e.preventDefault();

    $.ajax({
      //フォームのバリデーションに使うためPOST
      type: "POST",

      url: "ajax_login.php",

      dataType: "json",

      data: {
        //登録フォームの入力データを送信
        email: $(".js-email").val(),
        password: $(".js-password").val(),
        login_save: $(".js-login-save:checked").val(),
      },
    }).done(function (data) {
      //バリデーションに通れば画面を遷移する
      if (data.email || data.password) {
        $(".js-msg-email").text(data.email);
        $(".js-msg-password").text(data.password);
      } else {
        window.location.href = "mypage.php";
      }
    });
  });
});
