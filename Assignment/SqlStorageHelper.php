<?php 

require_once 'vendor/autoload.php';

class ProductInfoADO
{
    private $productID;
    private $userID;
    private $productName;
    private $productPrice;

    public function __get($property) {
        if (property_exists($this, $property)) 
        {
            return $this->$property;
        }
    }

    public function __construct($productID, $userID, $productName, $productPrice)
    {
        $this->productID = $productID;
        $this->userID = $userID;
        $this->productName = $productName;
        $this->productPrice = $productPrice;
    }
}

class SqlStorageHelper
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "meesho";

    public function getProductInfo($productID)
    {
        try
        {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT ProductID, UserID, ProductName, Price 
                    FROM Products
                    WHERE ProductID = ?";
            $query = $conn->prepare($sql);
            $query->execute([$productID]);
            $query->setFetchMode(PDO::FETCH_ASSOC);

            $row = $query->fetch();
            $result = new ProductInfoADO($row['ProductID'], $row['UserID'], $row['ProductName'], $row['Price']);

            return $result;
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
        return null;
    }

    public function uploadProductInfo($productInfo)
    {
        try
        {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO Products (ProductID, UserID, ProductName, Price) 
                    VALUES ('$productInfo->productID', '$productInfo->userID', '$productInfo->productName', '$productInfo->productPrice')";
            $conn->exec($sql);
            echo "New record created successfully";
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
    }
}

?>