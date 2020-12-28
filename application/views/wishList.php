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
    <button class='add-icon' id="addList">
        <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Create Wish List"></i>
    </button>
</div>

<div class="list-details" id="listView">
    <div class="list-left" id="listMain"></div>

    <div class="list-right">
        <button class="edit-icon" id="editList">
            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit List"></i>
        </button>
        <button class="share-icon" onclick="">
            <i class="fa fa-share" data-toggle="tooltip" data-placement="bottom" title="Get Shareable Link"></i>
        </button>
        <button class='add-icon' id="addItemBtn">
            <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Add an Item"></i>
        </button>
    </div>
</div>

<div class="popup" id="listPopup">
    <div class="popup-content">
        <span class="close" id="listClose">&times;</span>
        <div class="popup-heading">Create Wish List</div>

        <label for="name" class="lbl">List Name*</label>
        <input type="text" placeholder="List Name" name="name" id="name">

        <label for="desc" class="lbl">List Description*</label>
        <textarea name="desc" id="desc" placeholder="List Description"></textarea>

        <input type="button" value="Create Wish List" class="popupBtn" onclick="onCreateList()">
    </div>
</div>

<div class="popup" id="editListPopup">
    <div class="popup-content">
        <span class="close" id="editListClose">&times;</span>
        <div class="popup-heading">Edit Wish List</div>

        <label for="name" class="lbl">List Name*</label>
        <input type="text" placeholder="List Name" name="name" id="editName">

        <label for="desc" class="lbl">List Description*</label>
        <textarea name="desc" id="editDesc" placeholder="List Description"></textarea>

        <input type="button" value="Edit Wish List" class="popupBtn" onclick="onEditList()">
    </div>
</div>

<div class="no-list" id="noItemView">
    <div class="no-list-msg">Your wish list is empty. Add your first item by clicking the "Plus" icon.</div>
</div>

<div class="items" id="wishItems"></div>

<div class="popup" id="addItem">
    <div class="popup-content">
        <span class="close" id="addItemClose">&times;</span>
        <div class="popup-heading">Add an Item</div>

        <label for="title" class="lbl">Title*</label>
        <input type="text" placeholder="Title" name="title" id="title">

        <label for="itemUrl" class="lbl">Item URL*</label>
        <input type="text" placeholder="Item URL" name="itemUrl" id="itemUrl">

        <label for="occasion" class="lbl">Occasion*</label>
        <select name="occasion" id="occasion">
            <?php
            foreach ($occasionList as $occasion) {
                echo "<option value='$occasion->id'>$occasion->name</option>";
            }
            ?>
        </select>

        <label for="priority" class="lbl">Priority*</label>
        <select name="priority" id="priority">
            <?php
            foreach ($priorityList as $priority) {
                echo "<option value='$priority->id'>$priority->name</option>";
            }
            ?>
        </select>

        <label for="price" class="lbl">Price*</label>
        <input type="number" placeholder="Price" name="price" id="price" min="1" step="any" oninput="validity.valid||(value='');">

        <label for="quantity" class="lbl">Quantity*</label>
        <input type="number" placeholder="Quantity" name="quantity" id="quantity" min="1" oninput="validity.valid||(value='');">

        <input type="button" value="Add an Item" class="popupBtn" onclick="onAddItem()">
    </div>
</div>

<?php
include_once("footer.php");
?>

<script>
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
        url: '/WishIT/index.php/api/ListDetails/list',
        idAttribute: 'id',
        defaults: {"id": null, "name": "", "description": "", "userId": null}
    });

    var list = new List();

    var ListView = Backbone.View.extend({
        el: '#listMain',
        initialize: function () {
            this.listenTo(this.model, 'sync', this.render);
            this.model.fetch();
            divVisibilityChange();
        },
        render: function () {
            divVisibilityChange();

            var html = '<div class="list-name" data-toggle="tooltip" data-placement="bottom" title="' +
                this.model.get('name') + '">' + this.model.get('name') + '</div>' +
                '<div class="vl"></div>' +
                '<div class="list-note" data-toggle="tooltip" data-placement="bottom" title="' +
                this.model.get('description') + '">' + this.model.get('description') + '</div>';

            this.$el.html(html);
            return this;
        },
        wait: true
    });

    var listView = new ListView({model:list});

    var WishItem = Backbone.Model.extend({
        url: '/WishIT/index.php/api/WishItem/wishItems',
        idAttribute: 'id',
        defaults: {"id": null, "title": "", "listId": null, "occasionId": null, "priorityId": null, "itemUrl": "",
            "price": null, "quantity": null, "priorityLvl": null, "occasion": "", "priority": ""}
    });

    var wish = new WishItem();

    var WishItems = Backbone.Collection.extend({
        model: WishItem,
        comparator: 'priorityLvl',
        url: "/WishIT/index.php/api/WishItem/wishItems"
    });

    var wishItems = new WishItems();

    var WishItemsView = Backbone.View.extend({
        el: '#wishItems',
        initialize : function () {
            this.model.fetch({async:false});
            this.listenTo(this.model, 'sync', this.render());
            divVisibilityChange();
        },
        render : function () {
            divVisibilityChange();

            var html = '';
            this.model.each(function (item) {
                html += '<div class="item-card">' +
                    '<div class="card-top">' +
                    '<div class="item-name" data-toggle="tooltip" data-placement="bottom" title="' +
                    item.get('title') + '">' + item.get('title') + '</div>' +
                    '<div class="item-url"><a href="' + item.get('itemUrl') + '">' + item.get('itemUrl') + '</a></div>' +
                    '<button class="item-icon">' +
                    '<i class="fa fa-trash" data-toggle="tooltip" data-placement="bottom" title="Delete Item"></i>' +
                    '</button>' +
                    '<button class="item-icon">' +
                    '<i class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit Item"></i>' +
                    '</button>' +
                    '</div>' +
                    '<div class="card-bottom">' +
                    '<span class="item-detail"><span class="item-lbl">Occasion : </span>' +
                    '<span class="item-lbl-detail">' + item.get('occasion') + '</span>' +
                    '</span>' +
                    '<span class="item-detail"><span class="item-lbl">Priority : </span>' +
                    '<span class="item-lbl-detail">' + item.get('priority') + '</span>' +
                    '</span>' +
                    '<span class="item-detail"><span class="item-lbl">Price : </span>' +
                    '<span class="item-lbl-detail">' + item.get('price') + '</span>' +
                    '</span>' +
                    '<span class="item-detail"><span class="item-lbl">Quantity : </span>' +
                    '<span class="item-lbl-detail">' + item.get('quantity') + '</span>' +
                    '</span>' +
                    '</div>' +
                    '</div>';
            });

            $('#wishItems').html(html);
        },
        wait: true
    });

    var wishItemsView = new WishItemsView({model:wishItems});

    function divVisibilityChange() {
        if (list.get('id') == null) {
            document.getElementById("listView").style.display = "none";
            document.getElementById("noListView").style.display = "flex";
            document.getElementById("wishItems").style.display = "none";
            document.getElementById("noItemView").style.display = "none";
        } else {
            document.getElementById("listView").style.display = "flex";
            document.getElementById("noListView").style.display = "none";

            if (wishItems.length === 0) {
                document.getElementById("wishItems").style.display = "none";
                document.getElementById("noItemView").style.display = "flex";
            } else {
                document.getElementById("wishItems").style.display = "block";
                document.getElementById("noItemView").style.display = "none";
            }
        }
    }

    var lisClose = document.getElementById("listClose");
    var listPopup = document.getElementById("listPopup");
    var addList = document.getElementById("addList");

    lisClose.onclick = function() {
        listPopup.style.display = "none";
    }

    addList.onclick = function() {
        listPopup.style.display = "block";
    }

    function onCreateList() {
        var name = document.getElementById("name").value;
        var desc = document.getElementById("desc").value;

        if (name !== '' && desc !== '') {
            list.set('id',null);
            list.set('name', name);
            list.set('description', desc);
            list.set('userId', <?php echo "$user->id" ?>);
            list.save(null, {
                async: false,
                success: function () {
                    listPopup.style.display = "none";
                },
                error: function () {
                    alert('Error occurred while creating the list.');
                }
            });

        } else  {
            alert('Please fill all the required fields.');
        }
    }

    var editListClose = document.getElementById("editListClose");
    var editListPopup = document.getElementById("editListPopup");
    var editList = document.getElementById("editList");

    editListClose.onclick = function() {
        editListPopup.style.display = "none";
    }

    editList.onclick = function() {
        document.getElementById("editName").value = list.get('name');
        document.getElementById("editDesc").value = list.get('description');
        editListPopup.style.display = "block";
    }

    function onEditList() {
        var name = document.getElementById("editName").value;
        var desc = document.getElementById("editDesc").value;

        if (name !== '' && desc !== '') {
            list.set('name', name);
            list.set('description', desc);
            list.save({async:false});
            editListPopup.style.display = "none";

        } else  {
            alert('Please fill all the required fields.');
        }
    }

    var addItemClose = document.getElementById("addItemClose");
    var addItem = document.getElementById("addItem");
    var addItemBtn = document.getElementById("addItemBtn");

    addItemClose.onclick = function() {
        addItem.style.display = "none";
    }

    addItemBtn.onclick = function() {
        addItem.style.display = "block";
    }

    function onAddItem() {
        var title = document.getElementById("title").value;
        var itemUrl = document.getElementById("itemUrl").value;
        var occasion = document.getElementById("occasion").value;
        var priority = document.getElementById("priority").value;
        var price = document.getElementById("price").value;
        var quantity = document.getElementById("quantity").value;

        var urlRegex = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;

        if (title !== '' && itemUrl !== '' && price !== '' && quantity !== '') {
            if (urlRegex.test(itemUrl)) {
                var newItem = new WishItem();
                newItem.set('title', title);
                newItem.set('listId', list.get('id'));
                newItem.set('occasionId', occasion);
                newItem.set('priorityId', priority);
                newItem.set('itemUrl', itemUrl);
                newItem.set('price', price);
                newItem.set('quantity', quantity);

                newItem.save(null, {async:false,
                     success: function () {
                        wishItems.add(newItem);
                        wishItemsView.render();
                        addItem.style.display = "none";
                         document.getElementById("title").value = '';
                         document.getElementById("itemUrl").value = '';
                         document.getElementById("price").value = '';
                         document.getElementById("quantity").value = '';
                    },
                    error: function () {
                    alert('Error occurred while adding the new item.');
                    }
                });

            } else {
                alert('Please provide a valid URL.');
            }

        } else  {
            alert('Please fill all the required fields.');
        }
    }

    window.onclick = function(event) {
        if (event.target === listPopup) {
            listPopup.style.display = "none";
        } else if (event.target === editListPopup) {
            editListPopup.style.display = "none";
        } else if (event.target === addItem) {
            addItem.style.display = "none";
        }
    }

</script>

</body>
</html>