
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= HOME_URL ?>">CRM</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link-active" href="<?= HOME_URL ?>">Home</a>
                </li>
            </ul>
        </div>

        <div class="navbar-nav d-flex">
            <form action="/logout" method="post">
                <span class="h-5 text-success">You is logged in as <b><?= $authUser->email ?></b></span>
                <button type="success" class="btn btn-outline-success mx-4">Logout</button>
            </form>
        </div>
    </div>
</nav>
