<?php 

require_once 'vendor/autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use MicrosoftAzure\Storage\Common\ServiceException;

class BlobStorageHelper
{
    private $connectionString = "UseDevelopmentStorage=true";
    private $blobContainerName = "devstoreaccount1/images";

    public function uploadProductImage($productID, $filepath)
    {
        $content = fopen($filepath, "r");

        try    
        {
            $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($this->connectionString);
            $blobRestProxy->createBlockBlob($this->blobContainerName, $productID, $content);
            echo "Image uploaded successfully <br/>";
        }
        catch (ServiceException $e)
        {
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code.": ".$error_message."<br />";
        }
    }

    public function downloadProductImage($productID, $filePath)
    {
        try
        {
            $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($this->connectionString);
            $blob = $blobRestProxy->getBlob($this->blobContainerName, $productID);
            $fileContents = $blob->getContentStream();
            file_put_contents($filePath, $fileContents);
        }
        catch(ServiceException $e)
        {
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code.": ".$error_message."<br />";
        }
    }
}

?>