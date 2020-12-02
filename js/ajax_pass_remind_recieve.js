$(function () {
  $("#ajax-valid").on("click", function (e) {
    e.preventDefault();

    $.ajax({
      //フォームのバリデーションに使うためPOST
      type: "POST",

      url: "ajax_pass_remind_recieve.php",

      dataType: "json",

      data: {
        //登録フォームの入力データを送信
        token: $(".js-token").val(),
      },
    }).done(function (data) {
      //バリデーションに通れば画面を遷移する
      if (data.token) {
        $(".js-msg-token").text(data.token);
      } else {
        window.location.href = "login.php";
      }
    });
  });
});
