<html lang="en">
<head>
    <title>WishIT | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="/WishIT/images/favicon.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="/WishIT/css/login.css" rel="stylesheet">

    <script src="/WishIT/js/jquery-3.5.1.min.js"></script>
    <script src="/WishIT/js/popper.min.js"></script>
    <script src="/WishIT/js/bootstrap.min.js"></script>

</head>

<body>

<div class="login-box">
    <div class="page-name">
        <img src="/WishIT/images/logo.png" class="logo">
        <div class="name">WishIT</div>
    </div>

    <form action="" method="post" class="form">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <input type="submit" value="Login" class="btn">
    </form>

</div>

<div class="sign-up-div">
    Don't have an account? <a href="<?php echo base_url()."HomePage/signUP" ?>" class="sign-up">Sign Up</a>
</div>

<?php
include_once("footer.php");
?>

<script>

</script>

</body>
</html>