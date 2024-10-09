<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🚀</text></svg>" type="image/svg+xml">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300&family=Cairo:wght@500;600&family=IBM+Plex+Sans+Arabic&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Alexandria', 'Cairo', 'IBM Plex Sans Arabic', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content-wrapper {
            flex: 1 0 auto;
        }
        .gradient-header {
            background: linear-gradient(to right, #4a00e0, #8e2de2);
            color: white;
            padding: 20px 0;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 40px 0;
            flex-shrink: 0;
        }
        .footer h5 {
            margin-bottom: 20px;
            font-weight: bold;
        }
        .footer ul li {
            margin-bottom: 10px;
        }
        .footer-icon {
            font-size: 20px;
            margin-right: 10px;
            color: #ecf0f1;
            transition: color 0.3s ease;
        }
        .footer a:hover .footer-icon {
            color: #3498db;
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
        .main-content {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .nav-tabs {
            border-bottom: 2px solid #3498db;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #34495e;
            font-weight: bold;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        .nav-tabs .nav-link:hover {
            color: #3498db;
        }
        .nav-tabs .nav-link.active {
            color: #3498db;
            background-color: transparent;
            border-bottom: 3px solid #3498db;
        }
        .tab-content {
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <!-- Gradient Header -->
        <header class="gradient-header">
            <div class="container">
                <h1 class="text-4xl font-bold">Project Management</h1>
            </div>
        </header>

        <div class="container mt-5 main-content">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tableTab">
                        <i class="fas fa-table tab-icon"></i>
                        Table
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#formTab">
                        <img src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png" alt="WordPress" class="tab-icon">
                        WordPress
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
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#reactTab">
                        <img src="https://reactjs.org/favicon.ico" alt="React" class="tab-icon">
                        React.js
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#pythonTab">
                        <img src="https://www.python.org/static/favicon.ico" alt="Python" class="tab-icon">
                        Python
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#phpTab">
                        <img src="https://www.php.net/favicon.ico" alt="PHP" class="tab-icon">
                        PHP
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Table Tab -->
                <div class="tab-pane container active" id="tableTab">
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
                            kind VARCHAR(30) NOT NULL,
                            path VARCHAR(255) NOT NULL,
                            url VARCHAR(255) NOT NULL
                        )";
                        $conn->exec($sql);

                        // Fetch and display data
                        $stmt = $conn->prepare("SELECT id, site_name, database_, explain_, kind, path, url FROM site_name");
                        $stmt->execute();

                        // Display data in HTML table
                        echo "<table class='table table-bordered table-striped'>
                                <thead class='thead-dark'>
                                    <tr>
                                        <th>ID</th>
                                        <th>Site Name</th>
                                        <th>Database</th>
                                        <th>Explain</th>
                                        <th>Kind</th>
                                        <th>Path</th>
                                        <th>URL</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>";

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['site_name']}</td>
                                    <td>{$row['database_']}</td>
                                    <td>{$row['explain_']}</td>
                                    <td>{$row['kind']}</td>
                                    <td>{$row['path']}</td>
                                    <td><a href='{$row['url']}' target='_blank'>{$row['url']}</a></td>
                                    <td>
                                        <form method='POST' action='delete_record.php'> 
                                            <input type='hidden' name='record_id' value='{$row['id']}'>
                                            <input type='hidden' name='site_name' value='{$row['site_name']}'>
                                            <input type='hidden' name='database_' value='{$row['database_']}'>
                                            <input type='hidden' name='path' value='{$row['path']}'>
                                            <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                        </form>
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

                <!-- Form Tab (WordPress) -->
                <div class="tab-pane container fade" id="formTab">
                    <form id="myForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site-name" class="form-label">Site</label>
                                    <input type="text" class="form-control" id="site-name" name="site_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="database" class="form-label">Database</label>
                                    <input type="text" class="form-control" id="database" name="database">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="explain_" class="form-label">Explain</label>
                                    <textarea class="form-control" id="explain_" name="explain_"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary btn-block" id="submitBtn">Register a new WordPress website</button>
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

                <!-- Laravel Tab Content -->
                <div class="tab-pane container fade" id="laravelTab">
                    <h3>Laravel Content</h3>
                    <form id="Laravel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site-name" class="form-label">Site</label>
                                    <input type="text" class="form-control" id="site-name" name="site_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="database" class="form-label">Database</label>
                                    <input type="text" class="form-control" id="database" name="database">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="explain_" class="form-label">Explain</label>
                                    <textarea class="form-control" id="explain_" name="explain_"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary btn-block" id="submitBtn1">Register a new Laravel website</button>
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
                                    <label for="site-name" class="form-label">Application</label>
                                    <input type="text" class="form-control" id="site-name" name="site_name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="explain_" class="form-label">Explain</label>
                                    <textarea class="form-control" id="explain_" name="explain_"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary btn-block" id="submitBtn33">New Extensions project</button>
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
                                <label for="site-name" class="form-label">Application</label>
                                <input type="text" class="form-control" id="site-name" name="site_name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="explain_" class="form-label">Explain</label>
                                <textarea class="form-control" id="explain_" name="explain_"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-block" id="submitBtn2">New mobile project</button>
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

            <!-- React.js Tab Content -->
            <div class="tab-pane container fade" id="reactTab">
                <h3>React.js Content</h3>
                <form id="React">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="site-name" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="site-name" name="site_name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="explain_" class="form-label">Explain</label>
                                <textarea class="form-control" id="explain_" name="explain_"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-block" id="submitBtnReact">New React.js project</button>
                        </div>
                    </div>
                </form>    

                <div id="loadingSpinnerReact" class="d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-primary mt-2">جارٍ التحميل...</div>
                </div>
                
                <!-- Display response -->
                <div id="divReact"></div>       
            </div>

            <!-- Python Tab Content -->
            <div class="tab-pane container fade" id="pythonTab">
                <h3>Python Content</h3>
                <form id="Python">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="site-name" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="site-name" name="site_name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="explain_" class="form-label">Explain</label>
                                <textarea class="form-control" id="explain_" name="explain_"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-block" id="submitBtnPython">New Python project</button>
                        </div>
                    </div>
                </form>    

                <div id="loadingSpinnerPython" class="d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-primary mt-2">جارٍ التحميل...</div>
                </div>
                
                <!-- Display response -->
                <div id="divPython"></div>       
            </div>

            <!-- PHP Tab Content -->
            <div class="tab-pane container fade" id="phpTab">
                <h3>PHP Content</h3>
                <form id="PHP">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="site-name" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="site-name" name="site_name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="explain_" class="form-label">Explain</label>
                                <textarea class="form-control" id="explain_" name="explain_"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-block" id="submitBtnPHP">New PHP project</button>
                        </div>
                    </div>
                </form>    

                <div id="loadingSpinnerPHP" class="d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-primary mt-2">جارٍ التحميل...</div>
                </div>
                
                <!-- Display response -->
                <div id="divPHP"></div>       
            </div>
        </div>

        <div id="progress-bar-container">
            <div id="progress-bar"></div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>روابط سريعة</h5>
                <ul class="list-unstyled">
                    <li><a href="http://localhost/home/"><i class="fas fa-home footer-icon"></i> الرئيسية</a></li>
                    <li><a href="http://localhost/blackboard/"><i class="fas fa-chalkboard footer-icon"></i> السبورة</a></li>
                    <li><a href="http://localhost/task-ai/"><i class="fas fa-tasks footer-icon"></i> المهام</a></li>
                    <li><a href="http://localhost/info-code/bt.php"><i class="fas fa-code footer-icon"></i> بنك الأكواد</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>الأدوات</h5>
                <ul class="list-unstyled">
                    <li><a href="http://localhost/administration/public/"><i class="fas fa-folder footer-icon"></i> الملفات</a></li>
                    <li><a href="http://localhost/Columns/"><i class="fas fa-columns footer-icon"></i> الأعمدة</a></li>
                    <li><a href="http://localhost/ask/"><i class="fas fa-question-circle footer-icon"></i> الأسئلة</a></li>
                    <li><a href="http://localhost/phpmyadminx/"><i class="fas fa-database footer-icon"></i> إدارة قواعد البيانات</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>موارد أخرى</h5>
                <ul class="list-unstyled">
                    <li><a href="http://localhost/pr.php"><i class="fas fa-bug footer-icon"></i> اصطياد الأخطاء</a></li>
                    <li><a href="http://localhost/Timmy/"><i class="fas fa-clock footer-icon"></i> تيمي</a></li>
                    <li><a href="http://localhost/copy/"><i class="fas fa-clipboard footer-icon"></i> حافظة الملاحظات</a></li>
                    <li><a href="http://localhost/Taskme/"><i class="fas fa-calendar-check footer-icon"></i> المهام اليومية</a></li>
                    <li><a href="http://subdomain.localhost/tasks"><i class="fas fa-tasks footer-icon"></i> مهام CRM</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

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