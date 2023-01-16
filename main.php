<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

$username = $_SESSION['username'];
//echo "Welcome, $username";
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Film Nitro</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap');
        
        .material-symbols-outlined {
        font-variation-settings:
            'FILL' 1,
            'wght' 400,
            'GRAD' 0,
            'opsz' 48
        }
        .material-symbols-outlined{
            color: rgb(100, 100, 100);
        }
        *{
            font-family: 'Roboto Mono', monospace;
            box-sizing: border-box;
        }
        body{
            margin: 0;
            background-color: rgb(24, 24, 24);
        }
        header{
            background-color: rgb(30, 30, 30);
            width: 100%;
            height: 40px;
            display: flex;
            justify-content: space-between;
        }
        .nadpis{
            padding: 9px;
            color: rgb(100, 100, 100);
            user-select: none;
        }
        .menu{
            height: 100%;
            display: flex;
        }
        .username{
            color: rgb(100,100,100);
            margin: 8px 3px;
            user-select: none;
        }
        .ico{
            padding: 5px;
            font-size: 30px;
            user-select: none;
            cursor: pointer;
            transition: .1s;
        }
        .ico:hover{
            text-shadow: 0 0 3px rgb(100,100,100);
            transition: .1s;
        }

        main{
            display: grid;
            place-items: center;
        }
        .main{
            margin: 50px;
            height: 35px;
            width: 300px;
            transition: .1s;
        }
        .main:hover{
            background-color: rgb(35,35,35);
            box-shadow: 0 0 5px rgba(80,80,80,0.5);
            transition: .1s;
        }
        .main input{
            width: 100%;
            height: 100%;
            font-size: 14px;
            background-color: rgb(30, 30, 30);
            color: rgb(70,70,70);
            padding-left: 10px;
            border: none;
            border-radius: 5px;
        }
        .main input:focus{
            outline: none;
            caret-color: rgb(100, 100, 100);
            color: rgb(100, 100, 100);
        }
        .main span{
            position: absolute;
            margin-left: 266px;
            padding: 7px;
            font-size: 20px;
            user-select: none;
            cursor: pointer;
            transition: .1s;
        }
        .main span:hover{
            text-shadow: 0 0 3px rgb(100,100,100);
            transition: .1s;
        }
        main video{
            border-radius: 5px;
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
        @keyframes textreveal{
            0%{
                opacity: 0;
            }
            100%{
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
    </style>
</head>
<body>
    <div class="loading" id="loading-screen">
        <div id="loading">načítání...</div>
        <div id="text">načítaní trvá zpravidla maximálně 15 sekund</div>
    </div>
    <header>
        <div class="nadpis">Film Nitro</div>

        <div class="menu">
            <div class="username"><?PHP echo $username; ?></div>
            <span id="acc" class="material-symbols-outlined ico">account_circle</span>
        </div>
    </header>
    <main>
        <div class="main">
            <span id="search" class="material-symbols-outlined">search</span>
            <input id="input" type="text">
        </div>
        <video id="video" width="1280" height="720" controls autoplay>
            <source src="" type="video/mp4">
            <source src="" type="video/ogg">
            Your browser does not support the video tag.
          </video>
    </main>
</body>
<script>
    let text = document.getElementById('loading');

    setInterval(() => {
        if(text.innerHTML == "načítání"){
            text.innerHTML = "načítání.";
        }
        else if(text.innerHTML == "načítání."){
            text.innerHTML = "načítání..";
        }
        else if(text.innerHTML == "načítání.."){
            text.innerHTML = "načítání...";
        }
        else if(text.innerHTML == "načítání..."){
            text.innerHTML = "načítání";
        }
    }, 500);

</script>
<script>
    function Odkaz(film, callback){
        fetch('https://61c8-78-80-124-106.eu.ngrok.io/?arg='+ film)
        .then(response => response.text())
        .then(data => callback(data))
    }

    document.getElementById("search").addEventListener("click", function(){
        document.getElementById("loading-screen").style.display = "flex";
        document.getElementById("text").style.animation = "textreveal";
        Odkaz(document.getElementById('input').value, function(data){
            document.getElementById("loading-screen").style.display = "none";
            document.getElementById("text").style.animation = "none";
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