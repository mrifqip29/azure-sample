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

    
 </head>
 <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
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
                    <h1>Daftar disini!</h1>
                    <span class="border-top my-3"></span>
                    <p>Isikan nama, email, dan pekerjaan anda kemudian click <strong>Submit</strong> untuk mendaftar.</p>
            </div>
            <div class="mt-4 mb-2">
            <form method="post" action="index.php" enctype="multipart/form-data" >
                Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="name" id="name" style="margin-left: 15px"/></br></br>
                Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email" id="email" style="margin-left: 15px"/></br></br>
                Pekerjaan &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="job" id="job" style="margin-left: 15px"/></br></br>
                <input type="submit" name="submit" value="Submit" style="margin-right: 15px"/>
                <input type="submit" name="load_data" value="Load Data" />
            </form>
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
                            echo "<h2>Total pendaftar : ".count($registrants)." orang</h2>";
                            echo "<h3>Sudah terdaftar:</h3>";
                            echo "<table>";
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