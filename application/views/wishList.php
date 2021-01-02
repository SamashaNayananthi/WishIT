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
            <img src="/WishIT/images/logo.png"><div class="name">WishIT</div>
        </div>
    </li>

    <li class="right">
        <a href="javascript:void(0)" class="dropbtn">
            <div class="user-name"><?php echo "$user->fname" ?><i class="fa fa-sort-down icon"></i></div>
        </a>
        <div class="dropdown-content">
            <a href="<?php echo base_url()."api/Authentication/logout" ?>" id="logout">Logout</a>
        </div>
    </li>
</ul>

<div class="no-list" id="noListView">
    <div class="no-list-msg">Create your Wish List</div>
    <button class='add-icon' onclick="openList('add')">
        <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Create Wish List"></i>
    </button>
</div>

<div class="list-details" id="listView">
    <div class="list-left" id="listMain"></div>

    <div class="list-right">
        <button class="edit-icon" onclick="openList('edit')">
            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit List"></i>
        </button>
        <button class="share-icon" onclick="shareableLink()">
            <i class="fa fa-share" data-toggle="tooltip" data-placement="bottom" title="Get Shareable Link"></i>
        </button>
        <button class='add-icon' onclick="openItemPopup('add', null)">
            <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Add an Item"></i>
        </button>
    </div>
</div>

<div class="popup" id="listPopup">
    <div class="popup-content">
        <span class="close" onclick="closeListPopup()">&times;</span>
        <div class="popup-heading" id="listPopupHeading"></div>

        <label for="name" class="lbl">List Name*</label>
        <input type="text" placeholder="List Name" name="name" id="name">

        <label for="desc" class="lbl">List Description*</label>
        <textarea name="desc" id="desc" placeholder="List Description"></textarea>

        <label for="occasion" class="lbl">Occasion*</label>
        <select name="occasion" id="occasion">
            <?php foreach ($occasionList as $occasion) {
                echo "<option value='$occasion->id'>$occasion->name</option>";
            } ?>
        </select>

        <input type="button" value="Create Wish List" class="popupBtn" id="addListBtn" onclick="onSubmitList('add')">
        <input type="button" value="Edit Wish List" class="popupBtn" id="editListBtn" onclick="onSubmitList('edit')">
    </div>
</div>

<div class="no-list" id="noItemView">
    <div class="no-list-msg">Your wish list is empty. Add your first item by clicking the "Plus" icon.</div>
</div>

<div class="items" id="wishItems"></div>

<div class="popup" id="itemPopup">
    <div class="popup-content">
        <span class="close" onclick="closeItemPopup()">&times;</span>
        <div class="popup-heading" id="popupHeading"></div>

        <input type="hidden" id="id" name="id" value="">

        <label for="title" class="lbl">Title*</label>
        <input type="text" placeholder="Title" name="title" id="title">

        <label for="itemUrl" class="lbl">Item URL*</label>
        <input type="text" placeholder="Item URL" name="itemUrl" id="itemUrl">

        <label for="priority" class="lbl">Priority*</label>
        <select name="priority" id="priority">
            <?php foreach ($priorityList as $priority) {
                echo "<option value='$priority->id'>$priority->name</option>";
            } ?>
        </select>

        <label for="price" class="lbl">Price*</label>
        <input type="number" placeholder="Price" name="price" id="price" min="1" step="any"
               oninput="validity.valid||(value='');">

        <label for="quantity" class="lbl">Quantity*</label>
        <input type="number" placeholder="Quantity" name="quantity" id="quantity" min="1"
               oninput="validity.valid||(value='');">

        <input type="button" value="Add an Item" class="popupBtn" id="addItemBtn" onclick="onSubmitItem('add')">
        <input type="button" value="Edit an Item" class="popupBtn" id="editItemBtn" onclick="onSubmitItem('edit')">
    </div>
</div>

<div class="popup" id="deletePopup">
    <div class="popup-content">
        <span class="close" onclick="closeDeletePopup()">&times;</span>
        <div class="popup-heading">Delete an Item</div>

        <input type="hidden" id="deleteId" name="deleteId" value="">

        <label for="name" class="del-msg" id="deleteMsg"></label>

        <input type="button" value="Yes, delete this item" class="popupBtn" onclick="onClickDeleteItem()">
    </div>
</div>

<div class="popup" id="shareablePopup">
    <div class="popup-content">
        <span class="close" onclick="closeShareablePopup()">&times;</span>
        <div class="popup-heading">Your Shareable Link</div>

        <input type="text" value="" id="shareableLink">

        <input type="button" value="Copy to Clipboard" class="popupBtn" onclick="onClickCopyToClipboard()">
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
            },
            error: function () {
                alert('Unable to logout. Try again.');
            }
        });
        return false;
    });

    var Occasion = Backbone.Model.extend({
        url: "<?php echo base_url().'api/Occasion/occasion' ?>",
        idAttribute: 'id',
        defaults: {"id": null, "name": ""}
    });

    var Occasions = Backbone.Collection.extend({
        model: Occasion,
        url: "<?php echo base_url().'api/Occasion/occasion' ?>"
    });

    var occasionList = new Occasions();

    var OccasionView = Backbone.View.extend({
        el: '#occasion',
        initialize : function () {
            this.model.fetch({async:false});
            this.listenTo(this.model, 'sync', this.render());
        },
        render : function () {
            var html = '';
            this.model.each(function (occasion) {
                html += '<option value="' + occasion.get('id') + '">' + occasion.get('name') + '</option>';
            });
            this.$el.html(html);
        }
    });

    var occasionView = new OccasionView({model:occasionList});


    var List = Backbone.Model.extend({
        url: "<?php echo base_url().'api/ListDetails/list' ?>",
        idAttribute: 'id',
        defaults: {"id": null, "name": "", "description": "", "occasionId": null,
            "occasion":"", "userId": null}
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

            var html = '<div class="list-heading">' +
                '<div class="list-name" data-toggle="tooltip" data-placement="bottom" title="' +
                this.model.get('name') + '">' + this.model.get('name') + '</div>' +
                '<div class="vl">|</div>' +
                '<div class="occasion">' + this.model.get('occasion') + '</div></div>' +
                '<div class="list-note" data-toggle="tooltip" data-placement="bottom" title="' +
                this.model.get('description') + '">' + this.model.get('description') + '</div>';

            this.$el.html(html);
            return this;
        },
        wait: true
    });

    var listView = new ListView({model:list});

    var WishItem = Backbone.Model.extend({
        url: "<?php echo base_url().'api/WishItem/wishItems' ?>",
        idAttribute: 'id',
        defaults: {"id": null, "title": "", "listId": null, "priorityId": null, "itemUrl": "",
            "price": null, "quantity": null, "priorityLvl": null, "priority": ""}
    });

    var wish = new WishItem();

    var WishItems = Backbone.Collection.extend({
        model: WishItem,
        comparator: 'priorityLvl',
        url: "<?php echo base_url().'api/WishItem/wishItems' ?>"
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
                    '<button class="item-icon" onclick="openDeleteItemPopup(' + item.get('id') + ')">' +
                    '<i class="fa fa-trash" data-toggle="tooltip" data-placement="bottom" title="Delete Item"></i>' +
                    '</button>' +
                    '<button class="item-icon" onclick="openItemPopup(\'edit\', ' + item.get('id') + ')">' +
                    '<i class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit Item"></i>' +
                    '</button>' +
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

    var listPopup = document.getElementById("listPopup");

    function closeListPopup() {
        listPopup.style.display = "none";
    }

    function openList(action) {
        if (action === 'add') {
            document.getElementById("listPopupHeading").innerHTML = 'Create Wish List';
            document.getElementById("addListBtn").style.display = 'block';
            document.getElementById("editListBtn").style.display = 'none';
            listPopup.style.display = "block";
        } else {
            document.getElementById("listPopupHeading").innerHTML = 'Edit Wish List';
            document.getElementById("addListBtn").style.display = 'none';
            document.getElementById("editListBtn").style.display = 'block';
            document.getElementById("name").value = list.get('name');
            document.getElementById("desc").value = list.get('description');
            document.getElementById("occasion").value = list.get('occasionId');
            listPopup.style.display = "block";
        }
    }

    function onSubmitList(action) {
        var name = document.getElementById("name").value;
        var desc = document.getElementById("desc").value;
        var occasion = document.getElementById("occasion").value;

        if (name !== '' && desc !== '') {
            if (action === 'add') {
                list.set('id',null);
            }
            list.set('name', name);
            list.set('description', desc);
            list.set('occasionId', occasion);
            list.set('userId', <?php echo "$user->id" ?>);
            list.save(null, { async: false,
                success: function () {
                    listPopup.style.display = "none";
                },
                error: function () {
                    if (action === 'add') {
                        alert('Error occurred while creating the list.');
                    } else {
                        alert('Error occurred while editing the list.');
                    }
                }
            });

        } else  {
            alert('Please fill all the required fields.');
        }
    }

    var itemPopup = document.getElementById("itemPopup");

    function closeItemPopup() {
        itemPopup.style.display = "none";
    }

    function openItemPopup(action, id) {
        if (action === 'add') {
            document.getElementById("popupHeading").innerHTML = 'Add an Item';
            document.getElementById("addItemBtn").style.display = 'block';
            document.getElementById("editItemBtn").style.display = 'none';
            itemPopup.style.display = "block";
        } else {
            document.getElementById("popupHeading").innerHTML = 'Edit an Item';
            document.getElementById("addItemBtn").style.display = 'none';
            document.getElementById("editItemBtn").style.display = 'block';
            document.getElementById("id").value = id;
            itemPopup.style.display = "block";

            var selectedItem = wishItems.get(id);
            document.getElementById("title").value = selectedItem.get('title');
            document.getElementById("itemUrl").value = selectedItem.get('itemUrl');
            document.getElementById("priority").value = selectedItem.get('priorityId');
            document.getElementById("price").value = selectedItem.get('price');
            document.getElementById("quantity").value = selectedItem.get('quantity');
        }
    }

    function onSubmitItem(action) {
        var title = document.getElementById("title").value;
        var itemUrl = document.getElementById("itemUrl").value;
        var priority = document.getElementById("priority").value;
        var price = document.getElementById("price").value;
        var quantity = document.getElementById("quantity").value;

        var urlRegex = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;

        if (title !== '' && itemUrl !== '' && price !== '' && quantity !== '') {
            if (urlRegex.test(itemUrl)) {
                var item;
                if (action === 'add') {
                    item = new WishItem();
                } else {
                    item = wishItems.get(document.getElementById("id").value);
                }

                item.set('title', title);
                item.set('listId', list.get('id'));
                item.set('priorityId', priority);
                item.set('itemUrl', itemUrl);
                item.set('price', price);
                item.set('quantity', quantity);

                item.save(null, {async:false,
                     success: function () {
                         if (action === 'add') {
                             wishItems.add(item);
                         }
                         wishItems.sort();
                         wishItemsView.render();
                         itemPopup.style.display = "none";
                         document.getElementById("title").value = '';
                         document.getElementById("itemUrl").value = '';
                         document.getElementById("price").value = '';
                         document.getElementById("quantity").value = '';
                         document.getElementById("id").value = '';
                         document.getElementById("priority").value = 1;
                    },
                    error: function () {
                        if (action === "add") {
                            alert('Error occurred while adding the new item.');
                        } else {
                            alert('Error occurred while editing the item.');
                        }
                    }
                });

            } else {
                alert('Please provide a valid URL.');
            }

        } else  {
            alert('Please fill all the required fields.');
        }
    }

    var deletePopup = document.getElementById("deletePopup");

    function closeDeletePopup() {
        deletePopup.style.display = "none";
    }

    function openDeleteItemPopup(id) {
        var item = wishItems.get(id);
        document.getElementById("deleteMsg").innerHTML = "Are you sure ? <br> The wish list item '" +
            item.get('title') + "' will be removed from your wish list.";
        document.getElementById("deleteId").value = id;
        deletePopup.style.display = "block";
    }

    function onClickDeleteItem() {
        var item = wishItems.get(document.getElementById("deleteId").value);

        item.destroy({ url: "<?php echo base_url().'api/WishItem/wishItems/id/' ?>" + item.get('id'),
            success: function () {
                wishItemsView.render();
                deletePopup.style.display = "none";
            },
            error: function () {
                alert('Error occurred while deleting the item.');
            }
        });
    }

    var shareablePopup = document.getElementById("shareablePopup");

    function closeShareablePopup() {
        shareablePopup.style.display = "none";
    }

    function shareableLink() {
        $.ajax({
            url:"<?php echo base_url()."api/ListDetails/shareableLink" ?>",
            method: "GET",
            success: function(response) {
                document.getElementById("shareableLink").value = response;
                shareablePopup.style.display = "block";
            },
            error: function () {
                alert('Error occurred while getting shareable link.');
            }
        });
    }

    function onClickCopyToClipboard() {
        var copiedText = document.getElementById("shareableLink");
        copiedText.select();
        copiedText.setSelectionRange(0, 99999)
        document.execCommand("copy");
    }

    window.onclick = function(event) {
        if (event.target === listPopup) {
            listPopup.style.display = "none";
        } else if (event.target === itemPopup) {
            itemPopup.style.display = "none";
        } else if (event.target === deletePopup) {
            deletePopup.style.display = "none";
        } else if (event.target === shareablePopup) {
            shareablePopup.style.display = "none";
        }
    }

</script>

</body>
</html>