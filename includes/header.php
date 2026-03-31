<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Management System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/view_products.css">

    <style>
        :root {
            --bs-primary: #d9c600;
            --bs-primary-rgb: 217, 198, 0;
            --sidebar-width: 260px;
        }

        /* Essential Body Reset */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f6f4ed;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            /* Fix for mobile height 'blank space' */
            min-height: 100vh;
            min-height: -webkit-fill-available; 
        }

        html {
            height: -webkit-fill-available;
        }

        /* High-priority override for Bootstrap Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #d9c600 0%, #b89e00 100%) !important;
            border-color: transparent !important;
            color: #1a1a1a !important;
        }

        /* Prevent content shifting on mobile */
        * {
            box-sizing: border-box;
        }
    </style>
</head>
<body>
