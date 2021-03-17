<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Star Computer Calendar</title>

    <script src="https://kit.fontawesome.com/7c2a35dd94.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="/asset/css/admin.css" rel="stylesheet">
</head>

<body>
<div class="wrapper">
    <nav id="sidebar" class="active">
        <div class="sidebar-header">
            <img src="/asset/img/logo-admin.png" alt="bootraper logo" class="app-logo">
        </div>
        <ul class="list-unstyled components text-secondary sidebar-elements">
            <li>
                <a href="/index.php?page=admin&item=dashboard"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            <li>
                <a href="/index.php?page=admin&item=users"><i class="fas fa-users"></i> Utilisateurs</a>
            </li>
            <li>
                <a href="/index.php?page=admin&item=roles"><i class="fas fa-users-cog"></i> Roles</a>
            </li>
            <li>
                <a href="/index.php?page=admin&item=meetings"><i class="far fa-handshake"></i> Meetings</a>
            </li>
        </ul>
    </nav>

    <div id="body" class="active">
        <nav class="navbar navbar-expand-lg navbar-white bg-white">
            <button type="button" id="sidebarCollapse" class="btn btn-light"><i class="fas fa-bars"></i><span></span></button>
            <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <div class="nav-dropdown">
                            <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-user"></i> <span>John Doe</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                            <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                <ul class="nav-list">
                                    <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                    <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                    <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a href="" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="content">
            <div class="container">