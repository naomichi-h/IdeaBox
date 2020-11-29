<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IdeaBox | トップページ</title>
    <link rel="stylesheet" type="text/css" href="node_modules/ress/dist/ress.min.css" >
    <link rel="stylesheet" type="text/css" href="css/style.css" >
</head>
<body>
    <header class="header">
        <h1 class="nav-title">
            <img class="nav-icon" src="images/ideabox_icon.png" alt="idea-box-icon">
        IdeaBox</h1>

            <nav class="nav-menu">
                <ul class="menu">
                    <li class="menu-item"><a href="login.php" class="menu-link">login</a></li>
                    <li class="menu-item"><a href="signup.php" class="menu-link">sign up</a></li>
                </ul>
            </nav>
    </header>
    <main>
        <section class="hero">



            <h1 class="hero-title">IdeaBox</h1>
            <p class="hero-catch">アイデアから、アイデアを。</p>
            <p class="hero-comment">IdeaBoxは、あなたのひらめきをサポートする</p>
            <p>アイデア発想ツールです</p>

        </section>

        <h1 class="hero-catch">アイデアを組み合わせて、新しいアイデアを閃こう</h1>
        <p class="hero-catch-sub">IdeaBoxはあなたのひらめきをサポートします。</p>
        <button class="btn"><a href="signup.php">無料で新規登録</a></button>

        </section>

    </main>



    <!-- 開始時のアニメーション -->

    <div class="start">
    <p><img src="" alt=""></p>
</div>
</body>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>

<script>
    $(function() {
	// setTimeout(function(){
	// 	$('.start p').fadeIn(1600);
	// },500); //0.5秒後にロゴをフェードイン!
	setTimeout(function(){
		$('.start').fadeOut(500);
	},500); //2.5秒後にロゴ含め真っ白背景をフェードアウト！
});
</script>
</html>