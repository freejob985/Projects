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