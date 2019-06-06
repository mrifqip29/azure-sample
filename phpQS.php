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

        <style>
            body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            }

            * {
            box-sizing: border-box;
            }

            .bg-image {
            /* The image used */
            background-image: url("https://www.dicoding.com/images/original/academy/azure_cloud_for_developer_logo_210219114249.jpg");
            
            /* Add the blur effect */
            filter: blur(5px);
            -webkit-filter: blur(5px);
            
            /* Full height */
            height: 100%; 
            
            /* Center and scale the image nicely */
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;

            
            }

            /* Position text in the middle of the page/image */
            .bg-text {
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
                color: white;
                border: 3px solid #f1f1f1;
                position: absolute;
                transform: translate(-50%, -50%);
                left: 50%;
                z-index: 2;
                width: 100%;
                padding: 20px;
                overflow-x: scroll;
            }
        </style> 

    </head>

    <body>
        <div class="bg-image"></div>    

            <main role="main" class="container bg-text">
                <div class="starter-template">
                    <h1>Analisis Foto</h1>
                    <span class="border-top my-3"></span>
                    <p>Pilih foto yang ingin di analisa, kemudian click <strong>Upload</strong> untuk mengunggah.</p>
                    <p>Lalu click <strong>Analisa Foto</strong> untuk menampilkan hasil analisa Azure Computer Vision.</p>
                    <form class="d-flex justify-content-left" action="phpQS.php" method="post" enctype="multipart/form-data">
                    <div>
                        <input type="file" name="fileToUpload" accept=".jpeg,.jpg,.png" required=""></br></br>
                        <input type="submit" name="submit" value="Upload" class="btn btn-primary"></br></br>
                    </div>
                </form>
                </div>
            <div class="m-4 mb-2">

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
        <div>
            <button class="btn btn-info" onclick="window.location.href = 'https://azurerifqi.azurewebsites.net/';">Back to Home</button>
        </div>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
  </body>


</html>
