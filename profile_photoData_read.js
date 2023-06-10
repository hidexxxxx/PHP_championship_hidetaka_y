// ▼以下プロフィール画像を引き出し

import {
    initializeApp
} from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";

import {
    getStorage,
    ref,
    getDownloadURL
} from "https://www.gstatic.com/firebasejs/9.22.0/firebase-storage.js";

const firebaseConfig = {
    apiKey: "",
    authDomain: "jschampionship-f5265.firebaseapp.com",
    projectId: "jschampionship-f5265",
    storageBucket: "jschampionship-f5265.appspot.com",
    messagingSenderId: "171502542751",
    appId: "1:171502542751:web:0e4129428f53af19ce67aa"
};

const app = initializeApp(firebaseConfig);

const storage = getStorage(app);

const storageRef = ref(storage, "user-photo");
{/* // console.log(storageRef); */ }

const imageElement = document.getElementById("profile-photo");
{/* // console.log(imageElement); */ }

getDownloadURL(storageRef)
    .then((url) => {
        imageElement.src = url;
    })
    .catch((error) => {
        console.log(error);
    });

