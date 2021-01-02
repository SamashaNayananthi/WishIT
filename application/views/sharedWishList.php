<html lang="en">
<head>
    <title>WishIT | Shared List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="/WishIT/images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/WishIT/css/bootstrap.min.css">
    <link href="/WishIT/css/sharedWishList.css" rel="stylesheet">

    <script src="/WishIT/js/jquery-3.5.1.min.js"></script>
    <script src="/WishIT/js/popper.min.js"></script>
    <script src="/WishIT/js/bootstrap.min.js"></script>
    <script src="/WishIT/js/underscore.js" type="text/javascript"></script>
    <script src="/WishIT/js/backbone.js" type="text/javascript"></script>
</head>

<body>

<div class="nav-bar">
    <div class="page-name">
        <img src="/WishIT/images/logo.png"><div class="name">WishIT</div>
    </div>

    <div class="username" id="username"></div>
</div>

<div class="list-details">
    <div class="list-left" id="listDetails"></div>
</div>

<?php
if (empty($items)) {
    echo "<div class='no-list'>";
    echo "<div class='no-list-msg'>Currently $user->fName's Wish List is empty</div>";
    echo "</div>";
}
?>

<?php
if (!empty($items)) {
    echo "<div class='items'>";
    foreach ($items as $item) {

        echo "<div class='item-card'>";
        echo "<div class='card-top'>";
        echo "<div class='item-name' data-toggle='tooltip' data-placement='bottom' title='$item->title'>$item->title</div>";
        echo "<div class='item-url'><a href='$item->itemUrl'>$item->itemUrl</a></div>";
        echo "</div>";

        echo "<div class='card-bottom'>";
        echo "<span class='item-detail'><span class='item-lbl'>Priority : </span>";
        echo "<span class='item-lbl-detail'>$item->priority</span>";

        if ($item->priorityLvl == 1) {
            echo "<span class='fa fa-star checked' style='color: #bf0a0a'></span>";
            echo "<span class='fa fa-star checked' style='color: #bf0a0a'></span>";
            echo "<span class='fa fa-star checked' style='color: #bf0a0a'></span>";
        } elseif ($item->priorityLvl == 2) {
            echo "<span class='fa fa-star checked' style='color: orange'></span>";
            echo "<span class='fa fa-star checked' style='color: orange'></span>";
            echo "<span class='fa fa-star checked'></span>";
        } else {
            echo "<span class='fa fa-star checked' style='color: yellow'></span>";
            echo "<span class='fa fa-star checked'></span>";
            echo "<span class='fa fa-star checked'></span>";
        }

        echo "</span>";

        echo "<span class='item-detail'><span class=item-lbl'>Price : </span>";
        echo "<span class='item-lbl-detail'>$item->price</span>";
        echo "</span>";

        echo "<span class='item-detail'><span class='item-lbl'>Quantity : </span>";
        echo "<span class='item-lbl-detail'>$item->quantity</span>";
        echo "</span>";

        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
}
?>

<?php
include_once("footer.php");
?>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    var User = Backbone.Model.extend({
        url: "<?php echo base_url().'api/User/users' ?>",
        idAttribute: 'id',
        defaults: {"id": null, "fname": "", "lname": "", "username": ""}
    });

    var user = new User();
    var username = window.location.href.split("/").pop();

    var UserView = Backbone.View.extend({
        el: '#username',
        initialize : function () {
            this.model.fetch({data: $.param({"username": username}), async:false});
            this.render();
        },
        render : function () {
            var html = '<span>' + this.model.get('fname') + ' ' + this.model.get('lname') + '\'s Wish List</span>';
            this.$el.html(html);
        }
    });

    var userView = new UserView({model:user});


    var List = Backbone.Model.extend({
        url: "<?php echo base_url().'api/ListDetails/list' ?>",
        idAttribute: 'id',
        defaults: {"id": null, "name": "", "description": "", "occasionId": null,
            "occasion":"", "userId": null}
    });

    var list = new List();

    var ListView = Backbone.View.extend({
        el: '#listDetails',
        initialize: function () {
            this.listenTo(this.model, 'sync', this.render);
            this.model.fetch({data: $.param({"userId": user.get('id')}), async:false});
        },
        render: function () {
            var html = '<div class="list-name" data-toggle="tooltip" data-placement="bottom" ' +
                'title= "' + this.model.get('name') + '">' + this.model.get('name') + '</div>' +
                '<div class="vl">|</div>' +
                '<div class="occasion">' + this.model.get('occasion') + '</div>' +
                '<div class="vl">|</div>' +
                '<div class="list-note" data-toggle="tooltip" data-placement="bottom" title="' +
                this.model.get('desc') + '">' + this.model.get('description') +
                '</div>';

            this.$el.html(html);
            return this;
        }
    });

    var listView = new ListView({model:list});
</script>

</body>
</html>