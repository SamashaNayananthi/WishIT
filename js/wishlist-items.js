var base_url = $('#base').val();

var WishItem = Backbone.Model.extend({
    url: base_url + "api/WishItem/wishItems",
    idAttribute: 'id',
    defaults: {"id": null, "title": "", "listId": null, "priorityId": null, "itemUrl": "",
        "price": null, "quantity": null, "priorityLvl": null, "priority": ""}
});

var wish = new WishItem();

var WishItems = Backbone.Collection.extend({
    model: WishItem,
    comparator: 'priorityLvl',
    url: base_url + "api/WishItem/wishItems"
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
                '<div class="item-url"><a href="' + item.get('itemUrl') + '" target="_blank">' +
                item.get('itemUrl') + '</a></div>' +
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

var itemPopup = document.getElementById("itemPopup");

function clearItemPopUp() {
    document.getElementById("title").value = '';
    document.getElementById("itemUrl").value = '';
    document.getElementById("price").value = '';
    document.getElementById("quantity").value = '';
    document.getElementById("id").value = '';
    document.getElementById("priority").value = 1;
}

function closeItemPopup() {
    clearItemPopUp();
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
                    clearItemPopUp();
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

    item.destroy({ url: base_url + "api/WishItem/wishItems/id/" + item.get('id'),
        success: function () {
            wishItemsView.render();
            deletePopup.style.display = "none";
        },
        error: function () {
            alert('Error occurred while deleting the item.');
        }
    });
}