<?php \Core\CookieManager::deleteAllCookie(); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Login</title>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-7 col-sm-9">
            <div class="mb-4 mt-3 text-center">
                <img src="img/logo.png" alt="logo" width="80">
            </div>

            <div class="card shadow p-1 mt-5 bg-white rounded">
                <div class="card-body p-2">
                    <div class="card-title mb-4 text-center text-success">Login or <a href="/registration" class="text-success">Register</a></div>

                    <form action="/login" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" id="password">
                        </div>

                        <input name="frm_login" type="hidden">

                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-success ms-auto" type="submit">LOGIN</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>
