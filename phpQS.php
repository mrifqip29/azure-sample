<?php
require_once 'vendor/autoload.php';
require_once "./random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=azuresa;AccountKey=mRvpJLe6q7r43UhniX69WEGBMw/bjcPCsgFyqORCKhEE+bDjo5WybbQ4CjfP+3H05vWXl00ogHBEQikKpYGYGg==;";
$containerName = "azureblobrifqi";
// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);

if (isset($_POST['submit'])) {
	$fileToUpload = strtolower($_FILES["fileToUpload"]["name"]);
	$content = fopen($_FILES["fileToUpload"]["tmp_name"], "r");
	// echo fread($content, filesize($fileToUpload));
	$blobClient->createBlockBlob($containerName, $fileToUpload, $content);
	header("Location: phpQS.php");
}
$listBlobsOptions = new ListBlobsOptions();
$listBlobsOptions->setPrefix("");
$result = $blobClient->listBlobs($containerName, $listBlobsOptions);
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Analisis Sample Foto</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- <link href="starter-template.css" rel="stylesheet"> -->

    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            </button>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="https://azurerifqi.azurewebsites.net/">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="https://azurerifqi.azurewebsites.net/phpQS.php">Analisis Foto<span class="sr-only">(current)</span></a>
                </li>
            </div>
            </nav>
            <main role="main" class="container">
                <div class="starter-template"> <br><br><br>
                    <h1>Analisis Foto</h1>
                    <span class="border-top my-3"></span>
                    <p>Pilih foto yang ingin di analisa, kemudian click <strong>Upload</strong> untuk mengunggah.</p>
                    <p>Lalu click <strong>Analisa Foto</strong> untuk menampilkan hasil analisa Azure Computer Vision.</p>
                </div>
            <div class="mt-4 mb-2">
                <form class="d-flex justify-content-lefr" action="phpQS.php" method="post" enctype="multipart/form-data">
                    <div> 
                        <input type="file" name="fileToUpload" accept=".jpeg,.jpg,.png" required="">
                        
                    </div>
                    
                    <div> 
                        <br><br><br>
                        <input type="submit" name="submit" value="Upload" class="btn btn-primary">
                    </div>
                </form>
            </div>
            <br>
            <br>
            <h4>Total foto : <?php echo sizeof($result->getBlobs())?></h4>
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <th>Nama File</th>
                        <th>URL File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    do {
                        foreach ($result->getBlobs() as $blob)
                        {
                            ?>
                            <tr>
                                <td><?php echo $blob->getName() ?></td>
                                <td><?php echo $blob->getUrl() ?></td>
                                <td>
                                    <form action="azurecv.php" method="post">
                                        <input type="hidden" name="url" value="<?php echo $blob->getUrl()?>">
                                        <input type="submit" name="submit" value="Analisa Foto" class="btn btn-primary">
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        $listBlobsOptions->setContinuationToken($result->getContinuationToken());
                    } while($result->getContinuationToken());
                    ?>
                </tbody>
            </table>
            <!-- <form method="post" action="phpQS.php?Cleanup&containerName=<?php echo $containerName; ?>">
                <button type="submit">Press to clean up all resources created by this sample</button>
            </form>         -->
        </div>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
  </body>


</html>
