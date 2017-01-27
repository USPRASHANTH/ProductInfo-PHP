<?php 

require_once("BlobStorageHelper.php");
require_once("SqlStorageHelper.php");

$productID = intval($_GET['productID']);

// Using Product ID, fetch product info from DB and product image from blob storage
$downloadPath = "downloads/" . "$productID" . ".png";
$blobStorageHelper = new BlobStorageHelper();
$productImage = $blobStorageHelper->downloadProductImage($productID, $downloadPath);

$sqlStorageHelper = new SqlStorageHelper();
$productInfo = $sqlStorageHelper->getProductInfo($productID);

echo "productInfo: <br/>";
echo "ID = $productInfo->productID <br/>";
echo "Name = $productInfo->productName <br/>";
echo "Price = $productInfo->productPrice <br/>";

// Read the image downloaded from Blob from $downloadPath and send it to the client
/*
$content = fopen($downloadPath, "r");
var_dump($content);
echo "<br/>";
//*/

/*
header('Content-Type: image/png');
$image = imagecreatefrompng($downloadPath);
imagepng($image);
imagedestroy($im);
//*/

/*
header('Content-Type: image/jpeg');
readfile($downloadPath);
//*/

?>