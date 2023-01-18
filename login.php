<?php
if(isset($_POST['username']) && isset($_POST['password'])){
    //connect to database
    $db = mysqli_connect('eu-cdbr-west-03.cleardb.net', 'b59667cc031b8b', '79dfa041', 'heroku_f1e9af68bb8ac45');

    //get the entered username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    //query the database to see if the entered credentials match any records
    $query = "SELECT * FROM credentials WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);

    //if the credentials match, start a session and redirect to the main page
    if(mysqli_num_rows($result) == 1){
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header("Location: main.php");
    }else{
        echo "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nitro Film - Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap');
        *{
            font-family: 'Roboto Mono', monospace;
            box-sizing: border-box;
        }
        body{
            height: 100vh;
            margin: 0;
            background-color: rgb(24, 24, 24);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        form{
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input{
            height: 30px;
            background-color: rgb(30, 30, 30);
            border: none;
            color: rgb(100, 100, 100);
            border-radius: 5px;
            padding-left: 7px;
        }
        input:focus{
            outline: none;
            color: rgb(150,150,150);
        }
        header{
            background-color: rgb(30, 30, 30);
            width: 100%;
            height: 40px;
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 0;
        }
        .nadpis{
            padding: 9px;
            color: rgb(100, 100, 100);
            user-select: none;
        }
        input{
            font-size: 16px;
        }
        .login-btn{
        	transition: .2s;
        }
        .login-btn:hover{
        	transition: .2s;
            cursor: pointer;
            box-shadow: 0 0 7px rgb(100,100,100);
        }
    </style>
</head>
<body>
    <header>
        <div class="nadpis">Film Nitro</div>
    </header>
    <form method="post" action="login.php">
        <input type="text" name="username" placeholder="uživatelské jméno:" required>
        <input type="password" name="password" placeholder="heslo:" required>
        <input class="login-btn" type="submit" value="Login">
    </form>
</body>
</html>


