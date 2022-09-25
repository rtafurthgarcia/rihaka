<header class="p-3 p-md-0 text-bg-dark">
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <div class="container">
      <a href="#" class="navbar-brand fs-2 font-monospace">RIHAKA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse row align-items-start mt-3 mt-md-0" id="navmenu">
        <ul class="navbar-nav col-6">
          <li class="nav-item"><a class="nav-link active px-2 fs-1-md" href="#" aria-current="page">Home <span class="visually-hidden">(current)</span></a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-white fs-1-md">Categories</a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-white fs-1-md">Explore</a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-white fs-1-md">Setup</a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-white fs-1-md">Community</a></li>
        </ul>
        <? if(! $hide_login_panel): ?>
          <div class="ms-auto text-end col-6 gap-2 row justify-content-end">
            <a href="/login" class="btn btn-outline-light col-12 col-md-3" role="button">Login</a>
            <a href="/register" class="btn btn-warning col-12 col-md-3" role="button">Sign up</a>
          </div>
        <? endif; ?>
      </div>
    </div>
  </nav>
</header>