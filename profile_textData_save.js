
//プロフィールのテキストデータの保存
//▼以下firestore databaseへのテキストデータアップロード

import {
    initializeApp
}
    from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";

import {
    getFirestore,
    collection,
    addDoc,
    serverTimestamp,
    query,
    orderBy,
    onSnapshot,
} from "https://www.gstatic.com/firebasejs/9.22.0/firebase-firestore.js";

const firebaseConfig = {
    apiKey: "",
    authDomain: "jschampionship-f5265.firebaseapp.com",
    projectId: "jschampionship-f5265",
    storageBucket: "jschampionship-f5265.appspot.com",
    messagingSenderId: "171502542751",
    appId: "1:171502542751:web:0e4129428f53af19ce67aa"
};

// Firebase App を初期化して連携させる
const app = initializeApp(firebaseConfig);
//firestoreのオブジェクトを取得
const db = getFirestore(app);

$("#save").on("click", function () {
    // 送信時に必要な処理。

    const postData = {
        name: $("#input-name").val(),
        birth: $("#input-birth").val(),
        comment: $("#input-commit").val(),
        time: serverTimestamp(),
    };

    addDoc(collection(db, "user"), postData);
});

//データ取得処理

const q = query(collection(db, "user"), orderBy("time", "desc"));

onSnapshot(q, (querySnapshot) => {
    console.log(querySnapshot.docs);

    //複雑な形のため必要なデータのみ抽出した「オブジェクト形式の配列」に変換
    const documents = [];
    querySnapshot.forEach((doc) => {
        console.log(doc.data());
        const document = {
            id: doc.id,
            data: doc.data(),
        };
        documents.push(document);
    });


    const htmlElements = [];
    documents.forEach(function (document) {
        htmlElements.push(`
                            <li id="${documents[0].id}">
                                <p>${documents[0].data.name}</p>   
                            </li>
                        `);
    });

    $("#output").html(htmlElements[0]);
});



