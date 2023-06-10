import {
    initializeApp
} from "https://www.gstatic.com/firebasejs/9.21.0/firebase-app.js";

// 🔽 追加
import {
    getFirestore,
    collection,
    addDoc,
    serverTimestamp,
    //onsnapshotを追加してデータベースのデータ変更が発生したタイミングで処理を実行させる
    onSnapshot,
    //orderbyでデータのソートとorderbyで
    query,
    orderBy,
} from "https://www.gstatic.com/firebasejs/9.21.0/firebase-firestore.js";

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "",
    authDomain: "jswork-7558c.firebaseapp.com",
    projectId: "jswork-7558c",
    storageBucket: "jswork-7558c.appspot.com",
    messagingSenderId: "215719114362",
    appId: "1:215719114362:web:fe555875017463a7856dc3"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// 🔽 追加
const db = getFirestore(app);

$("#send").on("click", function () {
    // 送信時に必要な処理
    const postData = {
        name: $("#name").val(),
        text: $("#text").val(),
        time: serverTimestamp(),
    };
    //データベースにchatという名前でコレクションを作成している
    addDoc(collection(db, "chat"), postData);
    // 以下追加後、入力欄を空にする
    $("#text").val("");
});

// 🔽 データ取得条件の指定（今回は時間の新しい順に並び替えて取得）
const q = query(collection(db, "chat"), orderBy("time", "asc"));

// データ取得処理
onSnapshot(q, (querySnapshot) => {
    console.log(querySnapshot.docs);
    //querySnapshot.docsを必要なデータのみ抽出した「オブジェクト形式の配列」に変換
    const documents = [];
    querySnapshot.docs.forEach(function (doc) {
        const document = {
            id: doc.id,
            data: doc.data(),
        };
        documents.push(document);
    });

    console.log(documents);
    //必要な情報のみを抽出した配列が作成できたためこの配列から画面表示用のタグを作成
    //時刻形式を変換
    const htmlElements = [];
    documents.forEach(function (document) {
        htmlElements.push(`
                    <li id="${document.id}" style="border-bottom: 1px solid black;">
                    <p>${document.data.name} at ${convertTimestampToDatetime(document.data.time.seconds)}</p>
                    <p>${document.data.text}</p>
                    </li>
                    `);
    });

    $("#output-chat").html(htmlElements);
});