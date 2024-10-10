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