<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/styles/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="side">
            <div class="h-100">
                <div class="sidebar_logo d-flex align-items-end">

                    <a href="#" class="nav-link text-white-50">Dashboard</a>

                </div>

                <ul class="sidebar_nav">
                    <li class="sidebar_item active" style="width: 100%;">
                        <a href="?route=dashboard" class="sidebar_link"> <img src="assets/styles/img/1. overview.svg" alt="icon">Overview</a>
                    </li>
                    <li class="sidebar_item">
                        <a href="?route=candidat" class="sidebar_link"> <img src="assets/styles/img/agents.svg" alt="icon">Candidat</a>
                    </li>
                    <li class="sidebar_item">
                        <a href="?route=offre" class="sidebar_link"> <img src="assets/styles/img/task.svg" alt="icon">Offre</a>
                    </li>
                    <li class="sidebar_item">
                        <a href="?route=contact" class="sidebar_link"><img src="assets/styles/img/agent.svg" alt="icon">Contact</a>
                    </li>
                    <li class="sidebar_item">
                        <a href="#" class="sidebar_link"><img src="assets/styles/img/articles.svg" alt="icon">Articles</a>
                    </li>

                </ul>
                <div class="line"></div>
                <a href="#" class="sidebar_link"><img src="assets/styles/img/settings.svg" alt="">Settings</a>


            </div>
        </aside>
        <div class="main">
            <nav class="navbar justify-content-space-between pe-4 ps-2">
                <button class="btn open">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar  gap-4">
                    <div class="">
                        <input type="search" class="search " placeholder="Search">
                        <img class="search_icon" src="assets/styles/img/search.svg" alt="iconicon">
                    </div>
                    <!-- <img src="img/search.svg" alt="icon"> -->
                    <img class="notification" src="assets/styles/img/new.svg" alt="icon">
                    <div class="card new w-auto">
                        <div class="list-group list-group-light">
                            <div class="list-group-item px-3 d-flex justify-content-between align-items-center ">
                                <p class="mt-auto">Notification</p><a href="#"><img src="assets/styles/img/settingsno.svg" alt="icon"></a>
                            </div>
                            <div class="list-group-item px-3 d-flex"><img src="assets/styles/img/notif.svg" alt="iconimage">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text mb-3">Some quick example text to build on the card title and make up
                                        the bulk of the card's content.</p>
                                    <small class="card-text">1 day ago</small>
                                </div>
                            </div>
                            <div class="list-group-item px-3 d-flex"><img src="assets/styles/img/notif.svg" alt="iconimage">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text mb-3">Some quick example text to build on the card title and make up
                                        the bulk of the card's content.</p>
                                    <small class="card-text">1 day ago</small>
                                </div>
                            </div>
                            <div class="list-group-item px-3 text-center"><a href="#">View all notifications</a></div>
                        </div>
                    </div>
                    <div class="inline"></div>
                    <div class="name"> Admin</div>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-icon pe-md-0 position-relative" data-bs-toggle="dropdown">
                                <img src="assets/styles/img/photo_admin.svg" alt="icon">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end position-absolute">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Account Setting</a>
                                <a class="dropdown-item" href="/PeoplePerTask/project/pages/index.html">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            </section>

            <form action="?route=AddOffre" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="Titre">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Descrption</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="Descrption">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Company</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="Company">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Location</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="Location">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">image</label>
                    <input type="file" class="form-control" id="exampleInputEmail1" name="jobImg" accept=".jpg , .jpeg , .png">
                </div>
                <button type="submit" class="btn btn-primary" name="submitOffre">Submit</button>
            </form>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="assets/js/dashboard.js"></script>
</body>

</html>