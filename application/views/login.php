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
    <script src="/WishIT/js/underscore.js" type="text/javascript"></script>
    <script src="/WishIT/js/backbone.js" type="text/javascript"></script>

</head>

<body>

<div class="login-box">
    <div class="page-name">
        <img src="/WishIT/images/logo.png" class="logo">
        <div class="name">WishIT</div>
    </div>

    <div class="form">
        <input type="text" name="username" placeholder="Username" id="username" required>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <i class="far fa-eye" id="togglePassword" onclick="passwordVisibility()"></i>

        <input type="button" value="Login" class="btn" onclick="login()">
    </div>
</div>

<div class="sign-up-div">
    Don't have an account? <a href="<?php echo base_url()."Register/" ?>" class="sign-up">Sign Up</a>
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

    var Authentication = Backbone.Model.extend({
        url: "<?php echo base_url().'api/Authentication/authenticate' ?>",
        idAttribute: 'id',
        defaults: {"id": null, "username": "", "password":""}
    });

    var authentication = new Authentication();

    function login() {
        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;

        if (username === "" || password === "") {
            alert('Please fill both fields.');
        } else {
            authentication.set('username', username);
            authentication.set('password', password);
            authentication.save(null, {async: false,
                success: function () {
                    window.location = "<?php echo base_url()."WishList/myWishList" ?>";
                },
                error: function (data, statusText, xhr) {
                    if (statusText.status === 401) {
                        alert('You have entered an invalid username or password');
                    } else {
                        alert('Error occurred while registering the user. Please try again');
                    }
                }
            });
        }
    }

</script>

</body>
</html>