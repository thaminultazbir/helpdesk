<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>success</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Quicksand", sans-serif;
        }

        body{
            background: url('./img/bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .container{
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .container .logo img{
            width: 70px;
            height: 70px;
        }

        .container .head{
            margin-top: 30px;
            max-width: 300px;
        }
        .container .head h3{
            color: #ffffff;
            font-size: 30px;
            text-align: center;
            font-weight: 500;
        }

        .container .sub_head p{
            margin-top: 50px;
            color: #ffffff;
            width: 300px;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="./img/green.png" alt="">
        </div>
        <div class="head">
            <h3>Your report <br>
 has been submitted</h3>
        </div>
        <div class="sub_head">
            <p> This matter is under review. <br> You will be contacted shortly.</p>
        </div>
    </div>
</body>
</html>