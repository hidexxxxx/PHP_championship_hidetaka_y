<!-- DB接続関数の作成 -->

<?php

function connect_to_db() {
    $dbn='mysql:dbname=07_php02_work_items;charset=utf8mb4;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';
    // try: 例外が発生する可能性のあるコードブロックを定義
    try {
        return new PDO($dbn, $user, $pwd);
        // catch: tryブロック内でスローされた例外をキャッチしexitする
        // PDOExceptionは、PHPに組み込まれている例外クラスの一つ,エラーが発生した場合にスローされる
    }   catch (PDOException $e) {
        // $e->getMessage()は$eという変数が持つ例外オブジェクトのgetMessage メソッドを呼び出してエラーメッセージを作成
        exit('dbError:'.$e->getMessage());
    }
}

?>