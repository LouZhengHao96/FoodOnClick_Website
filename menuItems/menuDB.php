<?php
require_once("../dbConnection.php");
?>

<?php
$query = "SELECT * FROM `menu_item`";
$select = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($select);
$dataArray = array();
$menu_item_ID = "";
$item_category = "";
$item_name = "";
$item_description = "";
$item_picture = "";
$item_price = "";
$item_stock = "";
if ($num_rows > 0) {
    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
    $menu_item_ID = $rows["menu_item_ID"];
    $item_category = $rows["item_category"];
    $item_name = $rows["item_name"];
    $item_description = $rows["item_description"];
    $item_picture = $rows["item_picture"];
    $item_price = $rows["item_price"];
    $item_stock = $rows["item_stock"];

    $dataArray[]=array($menu_item_ID, $item_category, $item_name, $item_description, $item_picture, $item_price, $item_stock);
    }
}
?>