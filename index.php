<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Project</title>
    <link rel="icon" href="php.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300&family=Cairo:wght@500;600&family=IBM+Plex+Sans+Arabic&display=swap" rel="stylesheet">
    <style>
        body {
            background: url(https://i.imgur.com/IgDe1Zf.png) no-repeat center center fixed;
            background-size: cover;
            font-family: 'Alexandria', 'Cairo', 'IBM Plex Sans Arabic', sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 0px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        #progress-bar-container {
            width: 100%;
            border: 1px solid #ccc;
            margin: 20px 0;
        }
        #progress-bar {
            width: 0;
            height: 30px;
            background-color: #4caf50;
            transition: width 0.5s ease;
        }
        .tab-icon {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#formTab">
                    <img src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png" alt="WordPress" class="tab-icon">
                    WordPress
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tableTab">
                    <img src="https://www.svgrepo.com/show/303251/mysql-logo.svg" alt="Table" class="tab-icon">
                    Table
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#laravelTab">
                    <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel" class="tab-icon">
                    Laravel
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#chromeTab">
                    <img src="https://www.google.com/chrome/static/images/chrome-logo.svg" alt="Google Chrome" class="tab-icon">
                    Google Chrome
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#flutterTab">
                    <img src="https://storage.googleapis.com/cms-storage-bucket/4fd0db61df0567c0f352.png" alt="Flutter" class="tab-icon">
                    Flutter
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Form Tab (WordPress) -->
            <div class="tab-pane container active" id="formTab">
                <form id="myForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site-name" class="form-label"> Site</label>
                                <input type="text" class="form-control" id="site-name" name="site_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="database" class="form-label"> Database</label>
                                <input type="text" class="form-control" id="database" name="database">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="explain_" class="form-label">explain</label>
                                <textarea class="form-control" id="explain_" name="explain_"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-block" id="submitBtn">  Register a new WordPress website</button>
                        </div>
                    </div>
                </form>
                
                <!-- Loading spinner -->
                <div id="loadingSpinner" class="d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-primary mt-2">جارٍ التحميل...</div>
                </div>
                
                <!-- Display response -->
                <div id="div"></div>
            </div>

            <!-- Table Tab -->
            <div class="tab-pane container fade" id="tableTab">
                <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "wp";

                try {
                    // Create connection
                    $conn = new PDO("mysql:host=$servername", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Create database if not exists
                    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
                    $conn->exec($sql);
                    
                    // Connect to the database
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Create table if not exists
                    $sql = "CREATE TABLE IF NOT EXISTS site_name (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        site_name VARCHAR(30) NOT NULL,
                        database_ VARCHAR(30) NOT NULL,
                        explain_ TEXT,
                        kind VARCHAR(30) NOT NULL
                    )";
                    $conn->exec($sql);

                    // Fetch and display data
                    $stmt = $conn->prepare("SELECT id, site_name, database_, explain_, kind FROM site_name");
                    $stmt->execute();

                    // Display data in HTML table
                    echo "<table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Site Name</th>
                                    <th>Database</th>
                                    <th>Explain</th>
                                    <th>Delete</th>
                                    <th>APP</th>
                                    <th>LINK</th>
                                </tr>
                            </thead>
                            <tbody>";

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if($row['kind']=="wordpress"){
$img="https://help.brevo.com/hc/article_attachments/12685441277458";
$siz="55%";
                            $url = "http://localhost/plugins/" . $row['site_name'] . "/wp-login.php";
$app= "http://localhost/plugins/" . $row['site_name'] . "/a.php";

}else if($row['kind']=="Laravel"){
$img="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png";
$siz="30%";
$app= "http://localhost/plugins/" . $row['site_name'] . "/a.php";

                            $url = "http://localhost/plugins/".$row['site_name']."/public/";

}else if($row['kind']=="Google"){
$img="pngwing.com.png";
$siz="30%";
$app= "http://localhost/plugins/" . $row['site_name'] . "/a.php";

                            $url = "http://localhost/plugins/".$row['site_name']."/public/";

}
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['site_name']}</td>
                                <td>{$row['database_']}</td>
                                <td style='font-size: 8px;'>{$row['explain_']}</td>
                                <td>
                                    <form method='POST' action='delete_record.php'> 
                                        <input type='hidden' name='record_id' value='{$row['id']}'>
                                        <input type='hidden' name='site_name' value='{$row['site_name']}'>
                                        <input type='hidden' name='database_' value='{$row['database_']}'>
                                        <button type='submit' class='btn btn-danger'>Delete</button>
                                    </form>
                                </td>
                                <td>
                                    <a href='{$app}'>
                                        <img src='https://cdn.thenewstack.io/media/2021/10/4f0ac3e0-visual_studio_code.png' style='width: 55%;'>
                                    </a>
                                </td>
                                <td>
                                    <a href='$url' target='_blank'>
                                        <img src={$img} style='width: {$siz};'>
                                    </a>
                                </td>
                            </tr>";
                    }

                    echo "</tbody></table>";
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }

                $conn = null;
                ?>
            </div>

            <!-- Laravel Tab Content -->
            <div class="tab-pane container fade" id="laravelTab">
                <h3>Laravel Content</h3>
   <form id="Laravel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site-name" class="form-label"> Site</label>
                                <input type="text" class="form-control" id="site-name" name="site_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="database" class="form-label"> Database</label>
                                <input type="text" class="form-control" id="database" name="database">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="explain_" class="form-label">explain</label>
                                <textarea class="form-control" id="explain_" name="explain_"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-block" id="submitBtn1" >Register a new Larvel website</button>
                        </div>
                    </div>
                </form>    

         <div id="loadingSpinner1" class="d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-primary mt-2">جارٍ التحميل...</div>
                </div>
                
                <!-- Display response -->
                <div id="div11"></div>
            </div>

            <!-- Google Chrome Tab Content -->
            <div class="tab-pane container fade" id="chromeTab">
                <h3>Google Chrome Content</h3>
   <form id="Google">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="site-name" class="form-label">Application </label>
                                <input type="text" class="form-control" id="site-name" name="site_name">
                            </div>
                        </div>
                   
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="explain_" class="form-label">explain</label>
                                <textarea class="form-control" id="explain_" name="explain_"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-block" id="submitBtn33"> New Extensions project </button>
                        </div>
                    </div>
                </form>    
  <div id="loadingSpinner33" class="d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-primary mt-2">جارٍ التحميل...</div>
                </div>
                
                <!-- Display response -->
                <div id="div33"></div>    
      </div>

            <!-- Flutter Tab Content -->
            <div class="tab-pane container fade" id="flutterTab">
                <h3>Flutter Content</h3>
   <form id="Flutter">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="site-name" class="form-label">Application </label>
                                <input type="text" class="form-control" id="site-name" name="site_name">
                            </div>
                        </div>
                   
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="explain_" class="form-label">explain</label>
                                <textarea class="form-control" id="explain_" name="explain_"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-block" id="submitBtn2"> New mobile project </button>
                        </div>
                    </div>
                </form>    

         <div id="loadingSpinner" class="d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-primary mt-2">جارٍ التحميل...</div>
                </div>
                
                <!-- Display response -->
                <div id="div2"></div>       

   </div>
        </div>

<div id="progress-bar-container">
  <div id="progress-bar"></div>
</div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-form@4.3.0/dist/jquery.form.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Function to run the progress bar
  function runProgressBar(totalTime) {
    const progressBar = document.getElementById('progress-bar');
    const progressBarContainer = document.getElementById('progress-bar-container');
    const progressBarLength = progressBarContainer.clientWidth;
    const stepTime = totalTime / progressBarLength;

    function updateProgressBar(progress) {
      progressBar.style.width = `${progress}px`;
    }

    function runProgressStep(step) {
      updateProgressBar(step);
      if (step < progressBarLength) {
        setTimeout(() => runProgressStep(step + 1), stepTime * 1000);
      } else {
        console.log("Done!");
      }
    }

    runProgressStep(0);
  }


</script>


    <script>
        $(document).ready(function () {
            $("#submitBtn").click(function () {
                var formData = $("#myForm").serialize();
  const totalTimeInSeconds = 150;

  // Display the progress bar
  runProgressBar(totalTimeInSeconds);
                // Show the loading spinner
                $("#loadingSpinner").removeClass("d-none");

                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: formData,
                    dataType: 'html',
                    success: function (response) {
                        // Hide the loading spinner on success
                        $("#loadingSpinner").addClass("d-none");

                        // Display the response in the 'div' element
                        $('#div').html(response);
                        console.log(response);
                    },
                    error: function (error) {
                        // Hide the loading spinner on error
                        $("#loadingSpinner").addClass("d-none");

                        console.log(error);
                    }
                });
            });



       $("#submitBtn1").click(function () {
                var formData = $("#Laravel").serialize();
                // Show the loading spinner
  const totalTimeInSeconds = 50;

  // Display the progress bar
  runProgressBar(totalTimeInSeconds);
                $("#loadingSpinner1").removeClass("d-none");
                $.ajax({
                    type: "POST",
                    url: "Laravel.php",
                    data: formData,
                    dataType: 'html',
                    success: function (response) {
                        // Hide the loading spinner on success
                        $("#loadingSpinner1").addClass("d-none");
                        // Display the response in the 'div' element
                        $('#div11').html(response);
                        console.log(response);
                    },
                    error: function (error) {
                        // Hide the loading spinner on error
                        $("#loadingSpinner").addClass("d-none");

                        console.log(error);
                    }
                });
            });


       $("#submitBtn2").click(function () {
                var formData = $("#Flutter").serialize();
                // Show the loading spinner
                $("#loadingSpinner").removeClass("d-none");
                $.ajax({
                    type: "POST",
                    url: "Flutter.php",
                    data: formData,
                    dataType: 'html',
                    success: function (response) {
                        // Hide the loading spinner on success
                        $("#loadingSpinner").addClass("d-none");
                        // Display the response in the 'div' element
                        $('#div2').html(response);
                        console.log(response);
                    },
                    error: function (error) {
                        // Hide the loading spinner on error
                        $("#loadingSpinner").addClass("d-none");

                        console.log(error);
                    }
                });
            });
  



   $("#submitBtn33").click(function () {
  const totalTimeInSeconds = 30;

  // Display the progress bar
  runProgressBar(totalTimeInSeconds);
                var formData = $("#Google").serialize();
                // Show the loading spinner
                $("#loadingSpinner33").removeClass("d-none");
                $.ajax({
                    type: "POST",
                    url: "Google.php",
                    data: formData,
                    dataType: 'html',
                    success: function (response) {
                        // Hide the loading spinner on success
                        $("#loadingSpinner33").addClass("d-none");
                        // Display the response in the 'div' element
                        $('#div33').html(response);
                        console.log(response);
                    },
                    error: function (error) {
                        // Hide the loading spinner on error
                        $("#loadingSpinner33").addClass("d-none");

                        console.log(error);
                    }
                });
            });


  
        });
    </script>



</body>
</html>