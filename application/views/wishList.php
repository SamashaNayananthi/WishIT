<html lang="en">
<head>
    <title>WishIT | My List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="/WishIT/images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="/WishIT/css/wishList.css" rel="stylesheet">

    <script src="/WishIT/js/jquery-3.5.1.min.js"></script>
    <script src="/WishIT/js/popper.min.js"></script>
    <script src="/WishIT/js/bootstrap.min.js"></script>
</head>

<body>

<ul class="topnav">
    <li>
        <div class="page-name">
            <img src="/WishIT/images/logo.png">
            <div class="name">WishIT</div>
        </div>
    </li>

    <li class="right">
        <a href="javascript:void(0)" class="dropbtn">
            <div class="user-name">Samashaaaa<i class="fa fa-sort-down icon"></i>
            </div>
        </a>
        <div class="dropdown-content">
            <a href="">Logout</a>
        </div>
    </li>
</ul>
<div class="list-details">
    <div class="list-left">
        <div class="list-name" data-toggle="tooltip" data-placement="bottom" title="My List Test">My List Test</div>
        <div class="vl"></div>
        <div class="list-note" data-toggle="tooltip" data-placement="bottom" title="This is my first list">
            This is my first list</div>
        <button class='edit-icon' onclick="">
            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit List"></i>
        </button>
    </div>

    <div class="list-right">
        <button class='add-icon' onclick="">
            <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Add an Item"></i>
        </button>
    </div>
</div>

<div class="items">
    <div class="item-card">
        <div class="card-top">
            <span class="item-name">Item 1 : </span>
            <span class="item-url">http://localhost/WishIT/index.php/HomePage/wishList</span>
        </div>

        <div class="card-bottom">
            <span class="item-detail">
                <span class="item-lbl">Occasion : </span>
                <span class="item-lbl-detail">Birthday</span>
            </span>

            <span class="item-detail">
                <span class="item-lbl">Price : </span>
                <span class="item-lbl-detail">1000 (Rs.)</span>
            </span>

            <span class="item-detail">
                <span class="item-lbl">Quantity : </span>
                <span class="item-lbl-detail">1</span>
            </span>

            <span class="item-detail">
                <span class="item-lbl">Priority : </span>
                <span class="item-lbl-detail">I want it</span>
            </span>
        </div>

    </div>
</div>

<?php
include_once("footer.php");
?>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

</body>
</html>