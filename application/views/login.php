<html lang="en">
<head>
    <title>WishIT | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="/WishIT/images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="/WishIT/css/bootstrap.min.css">
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

    <form action="<?php echo base_url()."api/Authentication/authenticate" ?>" method="post" class="form" id="form">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" id="psw" placeholder="Password" required>
        <i class="far fa-eye" id="togglePassword" onclick="passwordVisibility()"></i>

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

    function passwordVisibility() {
        const psw = document.getElementById("psw");
        if (psw.type === "password") {
            psw.type = "text";
        } else {
            psw.type = "password";
        }
    }

    $('#form').submit(function(){
        $.ajax({
            url: $('#form').attr('action'),
            type: 'POST',
            data : $('#form').serialize(),
            success: function(){
                window.location = "<?php echo base_url()."HomePage/wishList" ?>";
            },
            statusCode: {
                401: function() {
                    alert('You have entered an invalid username or password');
                }
            }
        });
        return false;
    });

</script>

</body>
</html>