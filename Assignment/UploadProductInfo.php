<?php 

require_once("SqlStorageHelper.php");

$sqlStorageHelper = new SqlStorageHelper();

$json = file_get_contents('php://input'); 
echo "$json<br/>";
$obj = json_decode($json);
echo "$obj->productID<br/>";
echo "$obj->productName<br/>";
echo "$obj->productPrice<br/>";

$productID = $obj->productID;
$productName = $obj->productName;
$productPrice = $obj->productPrice;

$productInfo = new ProductInfoADO($productID, 3042, $productName, $productPrice);
$sqlStorageHelper->uploadProductInfo($productInfo);

?>