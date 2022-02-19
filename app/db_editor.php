<?php

// データベースに接続
$url = parse_url(getenv('DATABASE_URL'));
$dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
$pdo = new PDO($dsn, $url['user'], $url['pass']);

$targetID = 0;

// PDOでDBからデータを取得
$stmt = $pdo->prepare('SELECT * FROM dict');
$stmt->execute();
?>
<table>
    <tr>
        <th>用語</th>
        <th>意味</th>
        <th>用法</th>
        <th>作者</th>
    </tr>
    <?php while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<th>' . $result['word'] . '</th>';
        echo '<th>' . $result['meaning'] . '</th>';
        echo '<th>' . $result['ex_sentence'] . '</th>';
        echo '<th>' . $result['author'] . '</th>';
        echo '</tr>';
        // var_dump($result);
    }
    ?>
</table>