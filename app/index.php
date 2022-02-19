<?php
// データベースに接続
$url = parse_url(getenv('DATABASE_URL'));
$dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
$pdo = new PDO($dsn, $url['user'], $url['pass']);


function random_keyword()
{
    $length = 8;
    return base_convert(mt_rand(pow(36, $length - 1), pow(36, $length) - 1), 10, 36);
}

$key = random_keyword();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>ふたりで書く官能小説</title>

    <script>
        $(function() {
            $('#create').on('click', function() {
                $("#modal").fadeIn();
            });
            $('#esc').on('click', function() {
                $("#modal").fadeOut();
            });
        });
    </script>
</head>

<body class="main0">
    <div class="frame0 ellipse"></div>
    <div class="frame1 ellipse"></div>

    <div class="my_title">＃ふたりで書く官能小説</div>
    <div class="my_bookbinding_ellipse ellipse"></div>
    <button class="my_bookbinding">製本する</button>
    <div class="my_create_ellipse ellipse"></div>
    <button class="my_create" id="create">作成する</button>

    <!-- <div>作品一覧</div> -->
    <div class="flex">
        <?php
        $stmt = $pdo->prepare('SELECT * FROM script');
        $stmt->execute();
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="flex_item">
                <a href="./story.php?key=<?= $result['key'] ?>">
                    <img class="story_img" src="./img/IMG_2104.jpg" alt="">
                    <div class="story_title"><?= $result['word'] ?></div>
                </a>
            </div>

        <?php } ?>
    </div>



    <div id="modal" class="my_create_modal">
        <div class="title">合言葉で小説をはじめる。</div>
        <div class="esc" id="esc">×</div>
        <form action="create.php" method="post">
            <input id="copyTarget" class="form0" type="text" value="<?= $key ?>" readonly name="key">
            <input type="hidden" value="1" name="editor">
            <div class="btn0_ellipse ellipse"></div>
            <input type="submit" value="つくる" class="btn0">
        </form>
        <!-- <button onclick="copyToClipboard()">Copy</button> -->
        <form action="top.php" method="post">
            <input class="form1" type="text" value="" name="key">
            <input type="hidden" value="-1" name="editor">
            <div class="btn1_ellipse ellipse"></div>
            <input type="submit" value="あわせる" class="btn1 ellipse">
        </form>
    </div>




    <script>
        function copyToClipboard() {
            // コピー対象をJavaScript上で変数として定義する
            var copyTarget = document.getElementById("copyTarget");

            // コピー対象のテキストを選択する
            copyTarget.select();

            // 選択しているテキストをクリップボードにコピーする
            document.execCommand("Copy");

            // コピーをお知らせする
            alert("copied! : " + copyTarget.value);
        }
    </script>
</body>

</html>