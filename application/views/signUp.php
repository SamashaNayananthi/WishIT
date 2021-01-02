<html lang="en">
<head>
    <title>WishIT | Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="/WishIT/images/favicon.ico" />
    <link rel="stylesheet" href="/WishIT/css/bootstrap.min.css">
    <link href="/WishIT/css/signup.css" rel="stylesheet">

    <script src="/WishIT/js/jquery-3.5.1.min.js"></script>
    <script src="/WishIT/js/popper.min.js"></script>
    <script src="/WishIT/js/bootstrap.min.js"></script>
    <script src="/WishIT/js/underscore.js" type="text/javascript"></script>
    <script src="/WishIT/js/backbone.js" type="text/javascript"></script>

</head>

<body>

<div class="container">
    <div class="page-name">
        <img src="/WishIT/images/logo.png" class="logo">
        <div class="name">WishIT</div>
    </div>

    <div class="sign-up-box">
        <label for="fname" class="lbl">First Name*</label>
        <input type="text" placeholder="Enter First Name" name="fname" id="fname" required>

        <label for="lname" class="lbl">Last Name*</label>
        <input type="text" placeholder="Enter Last Name" name="lname" id="lname" required>

        <label for="username" class="lbl">Username*</label>
        <input type="text" placeholder="Enter Username" name="username" id="username" required>

        <label for="psw" class="lbl">Password*</label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

        <label for="pswRepeat" class="lbl">Repeat Password*</label>
        <input type="password" placeholder="Repeat Password" name="pswRepeat" id="pswRepeat" required>

        <input type="button" value="Sign Up" class="btn" onclick="checkForm()">
    </div>

</div>

<div class="login-div">
    Already have an account? <a href="<?php echo base_url()."Login/" ?>" class="login">Login</a>
</div>

<?php
include_once("footer.php");
?>

<script>

    var User = Backbone.Model.extend({
        url: "<?php echo base_url().'api/User/users' ?>",
        idAttribute: 'id',
        defaults: {"id": null, "fname": "", "lname": "", "username": "", "password":""}
    });

    var user = new User();

    function checkForm() {
        let namePattern = /^[A-Za-z]+$/;
        let fname = document.getElementById('fname').value;
        let lname = document.getElementById('lname').value;
        let username = document.getElementById('username').value;
        let psw = document.getElementById('psw').value;
        let pswRepeat = document.getElementById('pswRepeat').value;

        if (fname === "" || lname === "" || lname === "" || username === ""
            || psw === "" || pswRepeat === "") {
            alert('Please fill all the fields.');

        }else if (!fname.match(namePattern)) {
            alert('First name is invalid');

        } else if (fname.length > 25) {
            alert('First name is too lengthy');

        } else if (!lname.match(namePattern)) {
            alert('Last name is invalid');

        } else if (lname.length > 25) {
            alert('Last name is too lengthy');

        } else if (username.length > 15) {
            alert('Username is too lengthy. Please limit to 15 characters.');

        } else if(psw !== pswRepeat) {
            alert('The password and repeat password do not match.');

        } else {
            registerUser(fname, lname, username, psw);
        }

    }

    function registerUser(fname, lname, username, psw) {
        user.set('fname', fname);
        user.set('lname', lname);
        user.set('username', username);
        user.set('password', psw);
        user.save(null, {async: false,
            success: function (data, statusText, xhr) {
                alert("User registered successfully. Please login.");
                window.location = "<?php echo base_url()."Login/" ?>";
            },
            error: function (data, statusText, xhr) {
                if (statusText.status === 409) {
                    alert('Username already exists.');
                } else {
                    alert('Error occurred while registering the user. Please try again');
                }
            }
        });
    }

</script>

</body>
</html>
