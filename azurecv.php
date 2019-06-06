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

            overflow-x: scroll;
            }

            /* Position text in the middle of the page/image */
            .bg-text {
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
                color: white;
                border: 3px solid #f1f1f1;
                position: absolute;
                left: 10%;
                z-index: 2;
                width: 80%;
                padding: 20px;
                overflow-y: scroll;
                overflow-x: auto;
                height: 90%;
                top: 5%;
            }
            }
        </style> 
        
</head>
<body>
    <div class="bg-image"></div>        

	<main role="main" class="container bg-text">
    	<div class="starter-template">
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
        <br>
        <div>
            <button class="btn btn-info" onclick="window.location.href = 'https://azurerifqi.azurewebsites.net/';">Back to Home</button>
        </div>

<!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
  </body>
</html>