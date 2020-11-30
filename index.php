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
            <a href="index.php" class="link-color1"><img class="nav-icon" src="images/ideabox_icon.png" alt="idea-box-icon">IdeaBox</a>
        </h1>

            <nav class="nav-menu">
                <ul class="menu">
                    <li class="menu-item"><a href="login.php" class="link-color1 link-color-change">login</a></li>
                    <li class="menu-item"><a href="signup.php" class="link-color1 link-color-change">sign up</a></li>
                </ul>
            </nav>
    </header>
    <main class="main">
        <section class="hero">

            <h1 class="hero-title">IdeaBox</h1>
            <p class="hero-catch">アイデアから、アイデアを。</p>
            <p class="hero-comment">IdeaBoxは、あなたのひらめきをサポートする</p>
            <p class="hero-comment">アイデア発想ツールです</p>

        </section>

        <section class="container">

        <h1 class="top-catch">アイデアを組み合わせて、新しいアイデアを閃こう</h1>
        <p class="top-catch-sub">IdeaBoxはあなたのひらめきをサポートします。</p>
        <button onclick="location.href='signup.php'" class="btn"><a href="signup.php" class="link-color1">無料で新規登録</a></button>
        <p class="top-comment"><a href="login.php" class="link-color2 link-color-change">すでにアカウントをお持ちですか？<span>ログイン</span></a></p>
        <p class="top-comment"><a href="login.php" class="link-color2 link-color-change">登録をスキップして利用する</a></p>


        </section>

        <section class="site-explain">
            <div class="explain-comment-wrap">
            <h1 class="explain-title">Idea Seed法のためのツール</h1>
            <h2 class="explain-title-sub">アイデアの種から、閃く。</h2>
            <p class="explain-comment">あなたのアイデアの種を登録し、<br>
                ランダムで表示させます。<br>
                それらの共通点を探してみましょう。</p>

            <p class="explain-comment-sub">この方法は、<span class="notes">数多のアイデアに関する知見</span>から<br>
                導き出されたものです。</p>
            </div>

            <div class="explain-figure-wrap">
                <img src="images/explain_figure.png" alt="explain_figure" class="explain-figure">
            </div>
        </section>

    </main>

    <footer class="footer">
        <p>©️2020 IdeaBox. All rights reserved</p>
        <ul class="footer-menu">
            <li class="footer-item"><a href="" class="link-color2">利用規約</a></li>
            <li class="footer-item"><a href="" class="link-color2">プライバシー</a></li>
        </ul>

    </footer>



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
	// },500); //0.5秒後にロゴをフェードイン
	setTimeout(function(){
		$('.start').fadeOut(500);
	},500); //2.5秒後にロゴ含め真っ白背景をフェードアウト
});
</script>
</html>