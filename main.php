<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

$username = $_SESSION['username'];
//echo "Welcome, $username";

$mysqli = new mysqli('eu-cdbr-west-03.cleardb.net', 'b59667cc031b8b', '79dfa041', 'heroku_f1e9af68bb8ac45');

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$query = "SELECT pfp FROM credentials WHERE username='$username'";
$result = $mysqli->query($query);

/* check for errors in the query */
if (!$result) {
    printf("Error: %s\n", $mysqli->error);
    exit();
}

$row = $result->fetch_assoc();
$pfp = $row['pfp'];

/* check if a password was found */
if (!$pfp) {
    exit();
}
else{
    $_SESSION['pfp'] = $pfp;
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Nitro Film</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

        ::-webkit-scrollbar {
            display: none;
        }

        .material-symbols-outlined {
        font-variation-settings:
            'FILL' 1,
            'wght' 600,
            'GRAD' 0,
            'opsz' 48
        }
        .material-symbols-outlined{
            color: rgb(100, 100, 100);
        }
        *{
            font-family: 'Open Sans', sans-serif;
            box-sizing: border-box;
        }
        body{
            margin: 0;
            background: linear-gradient(156deg, rgba(255,165,92,1) 0%, rgba(232,62,208,1) 100%);
            height: 100vh;
        }
        header{
            position: absolute;
            width: 100%;
            height: 40px;
            display: flex;
            justify-content: space-between;
        }
        .nadpis{
            position: absolute;
            font-style: italic;
            top: 5vh;
            font-family: 'Open Sans', sans-serif;
            left: 6vw;
            font-size: 60px;
            color: rgba(255,255,255,0.85);
            user-select: none;
            font-weight: 800;
        }
        .menu{
            height: 100%;
            display: flex;
            transition: .2s;
            position: absolute;
            right: 2vw;
            top: 7.5vh;
            animation: menuuu ease-out 1s;
        }
        @keyframes menuuu{
            0%{
                right: -2vw;
                opacity: 0;
            }
            100%{
                right: 2vw;
                opacity: 1;
            }
        }
        .menu:hover{
            cursor: pointer;
            transition: .2s;
        }
        .menu:hover .ico{
            box-shadow: 0 0 7px rgb(255,255,255);
            transition: .2s;
        }
        .username{
            color: rgb(255,255,255);
            font-family: 'Merriweather Sans', sans-serif;
            margin: 12px 5px;
            user-select: none;
        }
        .ico{
            border-radius: 50%;
            user-select: none;
            cursor: pointer;
            transition: .2s;
            height: 30px;
            width: 30px;
            margin: 5px;
        }

        main{
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .main{
            height: 35px;
            width: 300px;
            transition: .3s;
            border-radius: 18px;
            scale: 1.1;
            position: absolute;
            animation: none;
            z-index: 10000;
            animation: animace ease-out 1s;
        }
        @keyframes animace{
            0%{
                margin-top: 100vh;
                opacity: 0;
            }
            100%{
                margin-top: 0vh;
                opacity: 1;
            }
        }
        .main:hover{
            box-shadow: 0 0 10px rgba(255,255,255,1);
            transition: .šs;
        }
        .main input{
            width: 100%;
            height: 100%;
            border-radius: 18px;
            font-size: 14px;
            background-color: #fff;
            color: rgb(70,70,70);
            padding-left: 17px;
            padding-bottom:1px;
            border: none;
        }
        .main input:focus{
            outline: none;
            caret-color: rgb(100, 100, 100);
            color: rgb(100, 100, 100);
        }
        .main span{
            position: absolute;
            margin-left: 263px;
            padding: 7px;
            font-size: 20px;
            user-select: none;
            cursor: pointer;
        }
        main video{
            border-radius: 20px;
            opacity: 0;
            margin-top: 7%;
            z-index: 1000;
            height: 60vh;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
        }
        .loading{
            position: absolute;
            background-color: rgb(24,24,24);
            z-index: 1000;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .loading div{
            color: rgb(100, 100, 100);
            font-size: 20px;
            user-select: none;
        }
        @keyframes search-input{
            0%{
                scale: 1.1;
            }
            100%{
                margin-top: -40%;
                scale: 1;
            }
        }
        @keyframes search-video{
            0%{
                opacity: 0;
                scale: 0;
            }
            100%{
                opacity: 1;
                scale: 1;
            }
        }
        @keyframes search-text{
            0%{
                font-size: 0px;
                opacity: 0;
            }
            100%{
                font-size: 19px;
                opacity: 1;
            }
        }
        #text{
            font-size: 16px;
            margin-top: 20px;
            animation: none;
            animation-duration: 3s;
        }
        .loading{
            display: none;
        }
        .loading-text{
            position: absolute;
            color: rgba(255,255,255,0.8);
            letter-spacing: 0.5px;
            font-weight: 700;
            font-style: italic;
            font-size: 30px;
            animation: none;
            opacity: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="nadpis">Nitro Film</div>

        <div class="menu" id="acc">
            <div class="username"><?PHP echo $username; ?></div>
            <img id="pfp" src="<?php echo $_SESSION["pfp"]; ?>" class="ico premium">
        </div>
    </header>
    <main>
        <div class="main" id="main">
            <span id="search" class="material-symbols-outlined">search</span>
            <input id="input" type="text">
        </div>
        <video id="video" controls autoplay>
            <source src="" type="video/mp4">
            <source src="" type="video/ogg">
            Your browser does not support the video tag.
        </video>
        <div class="loading-text" id="loading-text">načítání...</div>
    </main>
</body>
<script>
    setInterval(() => {
        let loading = document.getElementById("loading-text");

        if(loading.innerHTML == "načítání..."){
            loading.innerHTML = "načítání";
        }
        else if(loading.innerHTML == "načítání"){
            loading.innerHTML = "načítání.";
        }
        else if(loading.innerHTML == "načítání."){
            loading.innerHTML = "načítání..";
        }
        else if(loading.innerHTML == "načítání.."){
            loading.innerHTML = "načítání...";
        }
    }, 500);
</script>
<script>
    function Odkaz(film, callback){
        fetch('http://localhost:8080/?arg='+ film)
        .then(response => response.text())
        .then(data => callback(data))
    }

    document.getElementById("search").addEventListener("click", function(){
        //document.getElementById("loading-screen").style.display = "flex";
        document.title = "Načítání...";
        document.getElementById("main").style.animation = "search-input 1s ease 1 forwards";
        document.getElementById("loading-text").style.animation = "search-text 1s ease 1 forwards";
        Odkaz(document.getElementById('input').value, function(data){
            document.title = "Nitro Film";
            document.getElementById("video").style.animation = "search-video 1s ease 1 forwards";
            document.getElementById("loading-text").style.opacity = "0";
            if(data != "nenalezeno"){
                document.getElementById("video").src = data;
            }
            else{
                alert("film nebyl nalezen");
            }
        });
    });
</script>
<script>
    var span = document.getElementById("acc");

    span.addEventListener("click", function() {
        window.location.href = "account.php";
    });
</script>