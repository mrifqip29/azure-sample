<html>
 <head>
    <Title>Analisis Sample Foto</Title>
    <!-- <style type="text/css">
        body { background-color: #fff; border-top: solid 10px #000;
            color: #333; font-size: .85em; margin: 20; padding: 20;
            font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
        }
        h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
        h1 { font-size: 2em; }
        h2 { font-size: 1.75em; }
        h3 { font-size: 1.2em; }
        table { margin-top: 0.75em; }
        th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
        td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
    </style> -->
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
                font-weight: bold;
                border: 3px solid #f1f1f1;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 2;
                width: 80%;
                padding: 20px;
            }
        }
    </style>    
    
 </head>
 <body>
    <div class="bg-image"></div>

        <main role="main" class="container bg-text">
            <div class="starter-template"> <br><br><br>
                    <h1>Daftar disini!</h1>
                    <span class="border-top my-3"></span>
                    <p>Isikan nama, email, dan pekerjaan anda kemudian click <strong>Submit</strong> untuk mendaftar.</p>
            </div>
            <div class="mt-4 mb-2">
                <form method="post" action="index.php" enctype="multipart/form-data" >
                    Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="name" id="name" style="margin-left: 15px"/></br></br>
                    Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email" id="email" style="margin-left: 15px"/></br></br>
                    Pekerjaan &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="job" id="job" style="margin-left: 15px"/></br></br>
                    <input type="submit" name="submit" value="Submit" style="margin-right: 15px" class="btn btn-primary"/>
                    <input type="submit" name="load_data" value="Load Data" class="btn btn-primary"/>
                </form>
                <div>
                    <button class="btn btn-info" onclick="window.location.href = 'https://azurerifqi.azurewebsites.net/phpQS.php';">Analisis Foto</button>
                </div>
            </div>
            <br>
            <br>
            <?php
                $host = "rifqiazure.database.windows.net";
                $user = "rifqionky";
                $pass = "Blackblues4m";
                $db = "rifqidb";

                try {
                    $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
                    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                } catch(Exception $e) {
                    echo "Failed: " . $e;
                }

                if (isset($_POST['submit'])) {
                    try {
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $job = $_POST['job'];
                        $date = date("d-m-Y");
                        // Insert data
                        $sql_insert = "INSERT INTO Registration (name, email, job, date) 
                                    VALUES (?,?,?,?)";
                        $stmt = $conn->prepare($sql_insert);
                        $stmt->bindValue(1, $name);
                        $stmt->bindValue(2, $email);
                        $stmt->bindValue(3, $job);
                        $stmt->bindValue(4, $date);
                        $stmt->execute();
                    } catch(Exception $e) {
                        echo "Failed: " . $e;
                    }

                    echo "<h3>Your're registered!</h3>";
                } else if (isset($_POST['load_data'])) {
                    try {
                        $sql_select = "SELECT * FROM Registration";
                        $stmt = $conn->query($sql_select);
                        $registrants = $stmt->fetchAll(); 
                        if(count($registrants) > 0) {
                            echo "<h4>Total pendaftar : ".count($registrants)." orang</h4>";
                            echo "<h5>Sudah terdaftar:</h5>";
                            echo "<table class='table table-hover'>";
                            echo "<thead>";
                            echo "<tr><th>Nama</th>";
                            echo "<th>Email</th>";
                            echo "<th>Pekerjaan</th>";
                            echo "<th>Tanggal Mendaftar</th></tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach($registrants as $registrant) {
                                echo "<tr><td>".$registrant['name']."</td>";
                                echo "<td>".$registrant['email']."</td>";
                                echo "<td>".$registrant['job']."</td>";
                                echo "<td>".$registrant['date']."</td></tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<h3>Belum ada yang mendaftar.</h3>";
                        }
                    } catch(Exception $e) {
                        echo "Failed: " . $e;
                    }
                }
            ?>
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
  </body>
 </body>
 </html>