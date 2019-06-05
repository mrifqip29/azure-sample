<?php
if (isset($_POST['submit'])) {
	if (isset($_POST['url'])) {
		$url = $_POST['url'];
	} else {
		header("Location: phpQS.php");
	}
} else {
	header("Location: phpQS.php");
}
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="https://azurerifqi.azurewebsites.net/">Azure Rifqi</a>
                </li>
                <!-- <li class="nav-item active">
                    <a class="nav-link" href="https://azurerifqi.azurewebsites.net/phpQS.php">Analisis Foto<span class="sr-only">(current)</span></a>
                </li> -->
            </div>
	</nav>
	<main role="main" class="container">
        <br>
    	<div class="starter-template"> <br><br>
        	<h1>Hasil Analisis Foto</h1>
			<span class="border-top my-3"></span>
        </div>
            
        <script type="text/javascript">
                $(document).ready(function () {
            
                var subscriptionKey = "ae1d4fab8ae2491ab0803f3bac58ebc7";
        
                var uriBase =
                    "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
        
                // Request parameters.
                var params = {
                    "visualFeatures": "Categories,Description,Color",
                    "details": "",
                    "language": "en",
                };
        
                // Display the image.

                var sourceImageUrl = "<?php echo $url ?>";
                document.querySelector("#sourceImage").src = sourceImageUrl;
        
                // Make the REST API call.
                $.ajax({
                    url: uriBase + "?" + $.param(params),
        
                    // Request headers.
                    beforeSend: function(xhrObj){
                        xhrObj.setRequestHeader("Content-Type","application/json");
                        xhrObj.setRequestHeader(
                            "Ocp-Apim-Subscription-Key", subscriptionKey);
                    },
        
                    type: "POST",
        
                    // Request body.
                    data: '{"url": ' + '"' + sourceImageUrl + '"}',
                })
        
                .done(function(data) {
                    // Show formatted JSON on webpage.
                    // $("#responseTextArea").val(JSON.stringify(data, null, 2));
                    $("#description").text(data.description.captions[0].text);
                })
        
                .fail(function(jqXHR, textStatus, errorThrown) {
                    // Display error message.
                    var errorString = (errorThrown === "") ? "Error. " :
                        errorThrown + " (" + jqXHR.status + "): ";
                    errorString += (jqXHR.responseText === "") ? "" :
                        jQuery.parseJSON(jqXHR.responseText).message;
                    alert(errorString);
                });
            });
        </script>
        
        <!-- <h1>Analyze image:</h1>
        Enter the URL to an image, then click the <strong>Analyze image</strong> button.
        <br><br>
        Image to analyze:
        <input type="text" name="inputImage" id="inputImage"
            value="http://upload.wikimedia.org/wikipedia/commons/3/3c/Shaki_waterfall.jpg" />
        <button onclick="processImage()">Analyze image</button>
        <br><br> -->
        <br>
        <div id="wrapper" style="width:1020px; display:table;">
            <!-- <div id="jsonOutput" style="width:600px; display:table-cell;">
                Response:
                <br><br>
                <textarea id="responseTextArea" class="UIInput"
                        style="width:580px; height:400px; "readonly=" "></textarea>
            </div> -->
            <div id="imageDiv" style="width:420px; display:table-cell;">
                Source image:
                <br><br>
                <img id="sourceImage" width="400" />
                <br><br>
                <h3 id="description"></h3>
            </div>
        </div>
        <div>
            <button class="btn btn-info" onclick="window.location.href = 'https://azurerifqi.azurewebsites.net/';">Back to Home</button>
        </div>

<!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
  </body>
</html>