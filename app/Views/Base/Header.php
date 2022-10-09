<header class="p-3 p-md-0 text-bg-dark">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <div class="container">
            <a href="/" id="rihaka-brand" class="navbar-brand fs-2 font-monospace">RIHAKA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse row align-items-start mt-3 mt-md-0" id="navmenu">
                <ul class="navbar-nav col-4 col-md-6">
                    <li class="nav-item"><a href="/" class="nav-link px-2 text-white fs-1-md <?=($activePage === 1) ? "active-page": "" ?>">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-white fs-1-md <?=($activePage === 2) ? "active-page": "" ?>">Categories</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-white fs-1-md <?=($activePage === 3) ? "active-page": "" ?>">Explore</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-white fs-1-md <?=($activePage === 4) ? "active-page": "" ?>">Setup</a></li>
                </ul>
                <div class="ms-auto text-end col-8 col-md-6 gap-2 row justify-content-end">
                    <? if (!$hideLogin): ?>
                        <? if ($_SESSION['authenticated']): ?>
                            <a href="/logout" class="btn btn-outline-light col-12 col-md-4 col-lg-3" role="button">Logout</a>
                        <?else: ?>
                            <a href="/login" class="btn btn-outline-light col-12 col-md-4 col-lg-3" role="button">Login</a>
                        <?endif; ?>
                    <?endif; ?>
                    <? if (!$hideSignup): ?>
                        <? if ($_SESSION['authenticated']): ?>
                            <a href="/user/<?=$_SESSION['username']?>" class="btn btn-warning col-12 col-md-4 col-lg-3" role="button">Account</a>
                        <?else: ?>
                            <a href="/register" class="btn btn-warning col-12 col-md-4 col-lg-3" role="button">Sign up</a>
                        <?endif; ?>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>