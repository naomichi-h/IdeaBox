$(function () {
  $("#ajax-valid").on("click", function (e) {
    e.preventDefault();

    $.ajax({
      //フォームのバリデーションに使うためPOST
      type: "POST",

      url: "ajax_pass_remind_send.php",

      dataType: "json",

      data: {
        //登録フォームの入力データを送信
        email: $(".js-email").val(),
      },
    }).done(function (data) {
      //バリデーションに通れば画面を遷移する
      if (data.email) {
        $(".js-msg-email").text(data.email);
      } else {
        window.location.href = "pass_remind_recieve.php";
      }
    });
  });
});
