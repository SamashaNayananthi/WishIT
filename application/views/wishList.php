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
        <a href="javascript:void(0)" class="dropbtn" id="loggedInUser"></a>
        <div class="dropdown-content">
            <a href="<?php echo base_url()."api/Authentication/logout" ?>" id="logout">Logout</a>
        </div>
    </li>
</ul>

<input type="hidden" id="base" value="<?php echo base_url(); ?>">

<div class="no-list" id="noListView">
    <div class="no-list-msg">Create your Wish List</div>
    <button class='add-icon' onclick="openList('add')">
        <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Create Wish List"></i>
    </button>
</div>

<div class="list-details" id="listView">
    <div class="list-left" id="listMain"></div>

    <div class="list-right">
        <button class="edit-icon" onclick="openDeleteList()">
            <i class="fa fa-trash" data-toggle="tooltip" data-placement="bottom" title="Delete List"></i>
        </button>
        <button class="edit-icon" onclick="openList('edit')">
            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit List"></i>
        </button>
        <button class="share-icon" onclick="shareableLink()">
            <i class="fa fa-share" data-toggle="tooltip" data-placement="bottom" title="Get Shareable Link"></i>
        </button>
        <button class='add-icon list-add' onclick="openItemPopup('add', null)">
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
        <select name="occasion" id="occasion"></select>

        <input type="button" value="Create Wish List" class="popupBtn" id="addListBtn" onclick="onSubmitList('add')">
        <input type="button" value="Edit Wish List" class="popupBtn" id="editListBtn" onclick="onSubmitList('edit')">
    </div>
</div>

<div class="popup" id="deleteListPopup">
    <div class="popup-content">
        <span class="close" onclick="closeDeleteListPopup()">&times;</span>
        <div class="popup-heading">Delete The List</div>

        <label for="name" class="del-msg" id="deleteListMsg"></label>

        <input type="button" value="Yes, delete this list" class="popupBtn" onclick="onClickDeleteList()">
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
        <select name="priority" id="priority"></select>

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

    window.onclick = function(event) {
        if (event.target === listPopup) {
            listPopup.style.display = "none";
        } else if (event.target === itemPopup) {
            itemPopup.style.display = "none";
        } else if (event.target === deletePopup) {
            deletePopup.style.display = "none";
        } else if (event.target === shareablePopup) {
            shareablePopup.style.display = "none";
        } else if (event.target === listDeletePopup) {
            listDeletePopup.style.display = "none";
        }
    }

</script>

<script src="/WishIT/js/wishlist-user.js" type="text/javascript"></script>
<script src="/WishIT/js/dropdown.js" type="text/javascript"></script>
<script src="/WishIT/js/wishlist-list.js" type="text/javascript"></script>
<script src="/WishIT/js/wishlist-items.js" type="text/javascript"></script>

</body>
</html>