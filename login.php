<?php
$vysledek = "";

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
        $_SESSION['pfp'] = null;
        header("Location: main.php");
    }else{
        $vysledek = "nesprávné údaje!";
    }

    $servername = "eu-cdbr-west-03.cleardb.net";
    $username = "b59667cc031b8b";
    $password = "79dfa041";
    $dbname = "heroku_f1e9af68bb8ac45";

    if($vysledek != "nesprávné údaje!"){
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $usernamee = $_SESSION['username'];
    
        $sql = "SELECT * FROM users WHERE username='$usernamee'";
        $resultt = $conn->query($sql);
    
        if ($resultt->num_rows > 0) {
            // output data of each row
            while($row = $resultt->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["password"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nitro Film | Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
        *{
            font-family: 'Open Sans', sans-serif;
            box-sizing: border-box;
        }
        body{
            height: 100vh;
            margin: 0;
            background: linear-gradient(156deg, rgba(255,165,92,1) 0%, rgba(232,62,208,1) 100%);
            display: flex;
            align-items: center;
        }
        form{
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input{
            background-color: rgba(255, 255, 255, 0.0);
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.7);
            width: 200px;
            font-size: 0.9em;
            font-weight: 500;
            padding: ;
            color: #fff;
            padding-left: 7px;
        }
        input:hover{
            border-bottom: 2px solid rgba(255, 255, 255, 1);
        }
        input:valid{
            border-bottom: 2px solid rgba(255, 255, 255, 1);
        }
        input::placeholder {
            color: white;
            font-style: italic;
            opacity: 0.7;
        }
        input[type=text]{
            height: 35px;
            padding-top: 5px;
        }
        input[type=password]{
            height: 35px;
            padding-top: 5px;
        }
        input[type=submit]{
            height: 35px;
            font-size: 17px;
            font-style: italic;
            margin-top: -47px;
            font-weight: 800;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(156deg, rgba(255,165,92,1) 0%, rgba(232,62,208,1) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            border: none;
        }
        input:focus{
            outline: none;
        }
        header{
            width: 100%;
            height: 40px;
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 0;
        }
        .nadpis{
            position: absolute;
            top: 5vh;
            font-family: 'Open Sans', sans-serif;
            font-weight: 800;
            left: 6vw;
            font-size: 60px;
            color: rgba(255,255,255,0.85);
            user-select: none;
        }
        .chyba{
            margin-bottom: 20px;
            color: rgb(122, 40, 34);
        }
        form{
            position: absolute;
            left: 8.5vw;
            scale: 1.05;
        }
        .btn-bg{
            width: 200px;
            height: 40px;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <div class="nadpis"><i>Nitro Film</i></div>
    <div class="chyba"><?php echo $vysledek;?></div>
    <form method="post" action="login.php">
        <input type="text" name="username" placeholder="uživatelské jméno:" required>
        <input type="password" name="password" placeholder="heslo:" required>
        <div class="btn-bg"></div>
        <input class="login-btn" type="submit" value="Login">
    </form>
</body>
</html>


