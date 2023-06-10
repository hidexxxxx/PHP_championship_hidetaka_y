//登録ボタンを押したと同時にブラウザをリロードするコード
document.getElementById('closeModal').addEventListener('click', function () {

    console.log("ok");
    parent.location.reload();

});