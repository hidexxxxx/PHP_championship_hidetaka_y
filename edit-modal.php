<?php
    include 'item-edit.php';
?>

    <!-- モーダルエリアここから,input.phpファイルの機能と同等 -->
    <section id='modalEditArea' class='modalEditArea'>
        
          <form action='item-create.php' method='POST' enctype='multipart/form-data'>
              <fieldset class='fieldset-modal'>
               <div>
                  <input type='text' name='item' class='item' placeholder='*商品名を修正してください' value='<?= $record['item'] ?>'>
                </div>
                <br>
                <div>
                  <textarea rows=5 name='explanation' class='explanation' placeholder='＊商品の説明を記入してください'><?= $record['explanation']?></textarea>
                </div>
                <br>
                <div>
                  <input type='input' name='price' class='price' placeholder='＊金額を記入して下さい(例：10000円の場合「10000」と記入)' value='<?= $record['price']?>'>
                </div>
                <br>
                <div>
                  <input type='hidden' name='id' value='<?= $record['id'] ?>'>
                </div>
                <br>
                <div class='submit-button-box'>
                    <button type='submit' class='resister-button'>▶︎登録</button>
                </div>
              </fieldset>
            </form>
      
        <div id='closeEditModal' class='closeEditModal'>
          ×
        </div>
      </div>
    </section>
    <!-- モーダルエリアここまで -->

    <!-- ↓body閉じタグ直前でjQueryを読み込む -->
    <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    
    <!-- input用のモーダルコード -->
    <script src='item-edit-modal.js'></script>