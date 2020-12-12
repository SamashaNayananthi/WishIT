<html lang="en">
<head>
    <title>WishIT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="/WishIT/images/favicon.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="/WishIT/js/jquery-3.5.1.min.js"></script>
    <script src="/WishIT/js/popper.min.js"></script>
    <script src="/WishIT/js/bootstrap.min.js"></script>

    <style>
        body {
            height: 100%;
            margin: 0;
            /*background: radial-gradient(circle, #b537c4e0, #2c0241);*/
            background-image:url("/WishIT/images/bg.jpg");
            background-size:cover;
        }

        .main-container {
            width: 100vw;
            height: 100vh;
            background-color: #0a0009cc;
            font-family: serif;
        }

        .page-name {
            display: inline-flex;
            width: 100vw;
        }

        .logo {
            float: left;
            margin: auto 0 auto auto;
        }

        .name {
            color: white;
            float: right;
            margin: auto auto auto 0;
            font-size: 500%;
            font-weight: bold;
        }

        .desc {
            color: white;
            text-align: center;
            font-size: 250%;
        }

        .my-btn {
            width: 60vw;
            margin: 5vw 20vw 2vw 20vw;
        }
    </style>
</head>

<body>

<div class="main-container">
    <div class="page-name">
        <img src="/WishIT/images/logo.png" class="logo">
        <div class="name">WishIT</div>
    </div>

    <div class="desc">
        Make an online wish list with WishIT, <br>
        and then easily share it with friends and family.
    </div>

    <div class="my-btn">
        <button type="button" class="btn btn-outline-light btn-block btn-lg"
                onclick='Login()'>Login</button>
        <button type="button" class="btn btn-outline-light btn-block btn-lg"
                onclick='SignUp()'>Sign Up</button>
    </div>

</div>

<?php
include_once("footer.php");
?>

<script>
    function Login() {
        window.location = "<?php echo base_url()."HomePage/login" ?>";
    }

    function SignUp() {
        window.location = "<?php echo base_url()."HomePage/signUp" ?>";
    }
</script>

</body>
</html>
