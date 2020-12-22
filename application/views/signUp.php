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

</head>

<body>

<div class="container">
    <div class="page-name">
        <img src="/WishIT/images/logo.png" class="logo">
        <div class="name">WishIT</div>
    </div>

    <div class="sign-up-box">
        <form action="<?php echo base_url()."api/User/users" ?>" method="post" id="form" onSubmit="return checkForm()">
            <label for="fname" class="lbl">First Name</label>
            <input type="text" placeholder="Enter First Name" name="fname" id="fname" required>

            <label for="lname" class="lbl">Last Name</label>
            <input type="text" placeholder="Enter Last Name" name="lname" id="lname" required>

            <label for="username" class="lbl">Username</label>
            <input type="text" placeholder="Enter Username" name="username" id="username" required>

            <label for="psw" class="lbl">Password</label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

            <label for="pswRepeat" class="lbl">Repeat Password</label>
            <input type="password" placeholder="Repeat Password" name="pswRepeat" id="pswRepeat" required>

            <input type="submit" value="Sign Up" class="btn">
        </form>
    </div>

</div>

<div class="login-div">
    Already have an account? <a href="<?php echo base_url()."HomePage/login" ?>" class="login">Login</a>
</div>

<?php
include_once("footer.php");
?>

<script>

    function checkForm() {
        let namePattern = /^[A-Za-z]+$/;
        let fname = document.getElementById('fname').value;
        let lname = document.getElementById('lname').value;
        let psw = document.getElementById('psw').value;
        let pswRepeat = document.getElementById('pswRepeat').value;

        if (fname != '' && !fname.match(namePattern)) {
            alert('First name is invalid');
            return false;

        } else if (lname != '' && !lname.match(namePattern)) {
            alert('Last name is invalid');
            return false;

        } else if(psw != pswRepeat) {
            alert('The password and repeat password do not match.');
            return false;

        } else {
            return true;
        }

    }

    $('#form').submit(function(){
        $.ajax({
            url: $('#form').attr('action'),
            type: 'POST',
            data : $('#form').serialize(),
            success: function(){
                window.location = "<?php echo base_url()."HomePage/login" ?>";
            },
            statusCode: {
                409: function() {
                    alert('Username already exists');
                }
            }
        });
        return false;
    });

</script>

</body>
</html>
