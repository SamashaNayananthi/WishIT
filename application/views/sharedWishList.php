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

<div id="wishItems"></div>

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
            this.model.fetch({data: $.param({"userId": user.get('id')}), async:false});
            this.render();
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

    var WishItem = Backbone.Model.extend({
        url: "<?php echo base_url().'api/WishItem/wishItems' ?>",
        idAttribute: 'id',
        defaults: {"id": null, "title": "", "listId": null, "priorityId": null, "itemUrl": "",
            "price": null, "quantity": null, "priorityLvl": null, "priority": ""}
    });

    var WishItems = Backbone.Collection.extend({
        model: WishItem,
        comparator: 'priorityLvl',
        url: "<?php echo base_url().'api/WishItem/wishItems' ?>"
    });

    var wishItems = new WishItems();

    var WishItemsView = Backbone.View.extend({
        el: '#wishItems',
        initialize : function () {
            this.model.fetch({data: $.param({"listId": list.get('id')}), async:false});
            this.render();
        },
        render : function () {
            var html = '';
            if (this.model.length === 0) {
                html += '<div class="no-list">' +
                    '<div class="no-list-msg">Currently ' + user.get('fname') + '\'s Wish List is empty</div>' +
                    '</div>';
            } else {
                html += '<div class="items">';
                this.model.each(function (item) {
                    html += '<div class="item-card">' +
                    '<div class="card-top">' +
                    '<div class="item-name" data-toggle="tooltip" data-placement="bottom" title="' +
                        item.get('title') + '">' + item.get('title') + '</div>' +
                    '<div class="item-url"><a href="' + item.get('itemUrl') + '">' + item.get('itemUrl') +
                        '</a></div>' +
                    '</div>' +
                    '<div class="card-bottom">' +
                    '<span class="item-detail"><span class="item-lbl">Priority : </span>' +
                    '<span class="item-lbl-detail">' + item.get('priority') + '</span>';
                    if (item.get('priorityLvl') == 1) {
                        html += '<span class="fa fa-star checked" style="color: #bf0a0a"></span>' +
                            '<span class="fa fa-star checked" style="color: #bf0a0a"></span>' +
                            '<span class="fa fa-star checked" style="color: #bf0a0a"></span>';
                    } else if (item.get('priorityLvl') == 2) {
                        html += '<span class="fa fa-star checked" style="color: orange"></span>' +
                            '<span class="fa fa-star checked" style="color: orange"></span>' +
                            '<span class="fa fa-star checked"></span>';
                    } else {
                        html += '<span class="fa fa-star checked" style="color: yellow"></span>' +
                            '<span class="fa fa-star checked"></span>' +
                            '<span class="fa fa-star checked"></span>';
                    }
                    html += '</span>' +
                    '<span class="item-detail"><span class="item-lbl">Price : </span>' +
                    '<span class="item-lbl-detail">' + item.get('price') + '</span>' +
                    '</span>' +
                    '<span class="item-detail"><span class="item-lbl">Quantity : </span>' +
                    '<span class="item-lbl-detail">' + item.get('quantity') + '</span>' +
                    '</span>' +
                    '</div>' +
                    '</div>';
                    });
                    html += '</div>';
            }
            $('#wishItems').html(html);
        }
    });

    var wishItemsView = new WishItemsView({model:wishItems});
</script>

</body>
</html>