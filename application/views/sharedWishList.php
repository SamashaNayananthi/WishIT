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
</head>

<body>

<div class="nav-bar">
    <div class="page-name">
        <img src="/WishIT/images/logo.png"><div class="name">WishIT</div>
    </div>

    <div class="username">
        <span><?php echo $user->fName." ".$user->lName."'s Wish List"?></span>
    </div>
</div>

<div class="list-details">
    <div class="list-left">
        <div class="list-name" data-toggle="tooltip" data-placement="bottom" title="<?php echo $list->name ?>">
            <?php echo $list->name ?>
        </div>
        <div class="vl">|</div>
        <div class="occasion"><?php echo $list->occasion ?></div>
        <div class="vl">|</div>
        <div class="list-note" data-toggle="tooltip" data-placement="bottom" title="<?php echo $list->desc ?>">
            <?php echo $list->desc ?>
        </div>
    </div>
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
</script>

</body>
</html>