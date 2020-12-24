<html lang="en">
<head>
    <title>WishIT | My List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="/WishIT/images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/WishIT/css/bootstrap.min.css">
    <link href="/WishIT/css/wishList.css" rel="stylesheet">

    <script src="/WishIT/js/jquery-3.5.1.min.js"></script>
    <script src="/WishIT/js/popper.min.js"></script>
    <script src="/WishIT/js/bootstrap.min.js"></script>
    <script src="/WishIT/js/underscore.js" type="text/javascript"></script>
    <script src="/WishIT/js/backbone.js" type="text/javascript"></script>
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
            <div class="user-name"><?php echo "$user->fname" ?><i class="fa fa-sort-down icon"></i>
            </div>
        </a>
        <div class="dropdown-content">
            <a href="<?php echo base_url()."api/Authentication/logout" ?>" id="logout">Logout</a>
        </div>
    </li>
</ul>

<div class="no-list" id="noListView">
    <div class="no-list-msg">Create your Wish List</div>

    <button class='add-icon' onclick="">
        <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Create Wish List"></i>
    </button>
</div>

<div class="list-details" id="listView">
    <div class="list-left">
        <div class="list-name" data-toggle="tooltip" data-placement="bottom" title="My List Test">My List Test</div>
        <div class="vl"></div>
        <div class="list-note" data-toggle="tooltip" data-placement="bottom" title="This is my first list">
            This is my first list</div>
        <button class='edit-icon' onclick="">
            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit List"></i>
        </button>
        <button class='share-icon' onclick="">
            <i class="fa fa-share" data-toggle="tooltip" data-placement="bottom" title="Share Link"></i>
        </button>
    </div>

    <div class="list-right">
        <button class='add-icon' onclick="">
            <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Add an Item"></i>
        </button>
    </div>
</div>

<div class="items" id="wishItems">
    <div class="item-card">
        <div class="card-top">
            <div class="item-name" data-toggle="tooltip" data-placement="bottom" title="Item 1">Item 1</div>
            <div class="item-url"><a href="http://localhost/WishIT/index.php/HomePage/wishList">http://localhost/WishIT/index.php/HomePage/wishList</a></div>

            <button class='item-icon' onclick="">
                <i class="fa fa-trash" data-toggle="tooltip" data-placement="bottom" title="Delete Item"></i>
            </button>

            <button class='item-icon' onclick="">
                <i class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit Item"></i>
            </button>
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
    var listGlobal = null;

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('#logout').click(function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            success: function(response) {
                window.location = "<?php echo base_url()."HomePage/" ?>";
            }
        });
        return false;
    });

    var List = Backbone.Model.extend({
        url: '/WishIT/index.php/api/ListDetails/list/userId/<?php echo "$user->id" ?>',
        idAttribute: 'userId',
        defaults: {"id":null,
            "name":"",
            "description":"",
            "userId":null
        }
    });

    var list = new List();
    list.fetch({async:false});

    if (list.get('id') == null) {
        document.getElementById("listView").style.visibility = "hidden";
        document.getElementById("noListView").style.visibility = "visible";
        document.getElementById("wishItems").style.visibility = "hidden";
    } else {
        document.getElementById("listView").style.visibility = "visible";
        document.getElementById("noListView").style.visibility = "hidden";
        document.getElementById("wishItems").style.visibility = "visible";
    }

    // var ListView = Backbone.View.extend({
    //     el: '#listView',
    //     initialize: function () {
    //         this.listenTo(this.model, 'sync change', this.render);
    //         this.model.fetch();
    //     },
    //     render: function () {
    //
    //         return this;
    //     }
    // });

</script>

</body>
</html>