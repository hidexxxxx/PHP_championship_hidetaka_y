//▼プロフィール画像のstorageへのアップロード。
//firebaseのverが9.xxなら以下の書き方、8.xxなら以前の書き方。
//firebaseのドキュメント要参照


import {
    initializeApp
} from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";

import {
    getStorage,
    ref,
    uploadBytes
} from "https://www.gstatic.com/firebasejs/9.22.0/firebase-storage.js";

const firebaseConfig = {
    apiKey: "",
    authDomain: "jschampionship-f5265.firebaseapp.com",
    projectId: "jschampionship-f5265",
    storageBucket: "jschampionship-f5265.appspot.com",
    messagingSenderId: "171502542751",
    appId: "1:171502542751:web:0e4129428f53af19ce67aa"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

const storage = getStorage(app);

//jQueryのonclickを使って関数を発火させる
$("#save").on("click", function () {
    const storageRef = ref(storage, "user-photo");
    const file = document.getElementById('imageInput').files[0];

    //uploadBytes関数を使ってstorageにfileをアップロードする
    uploadBytes(storageRef, file).then((snapshot) => {

        // アップロードが完了したときの処理
        console.log('Upload complete');
        alert('Upload complete!!');
    });
});