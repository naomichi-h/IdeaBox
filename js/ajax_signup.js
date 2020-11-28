$(function () {
  $("#ajax-valid").on("click", function (e) {
    e.preventDefault();

    $.ajax({
      //フォームのバリデーションに使うためPOST
      type: "POST",

      url: "ajax_signup.php",

      dataType: "json",

      data: {
        //登録フォームの入力データを送信
        email: $(".js-email").val(),
        password: $(".js-password").val(),
        password_re: $(".js-password-re").val(),
      },
    }).done(function (data) {
      //バリデーションに通れば画面を遷移する
      if (data.email || data.password || data.password_re) {
        $(".js-msg-email").text(data.email);
        $(".js-msg-password").text(data.password);
        $(".js-msg-password-re").text(data.password_re);
      } else {
        window.location.href = "mypage.php";
      }
    });
  });
});
