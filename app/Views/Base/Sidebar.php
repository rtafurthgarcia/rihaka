<nav id="sidebar" class="flex-shrink-0 bg-white col-12 col-xl-2 col-lg-3 col-md-4 fs-5 border-end border-bottom border-2">
    <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <? if(isset($activeMenu) && $activeMenu > 0 && $activeMenu <= 3 ): ?>
                <button class="fw-bold btn btn-lg btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#contributions-collapse" aria-expanded="true">Contributions</button>
                <div class="collapse show" id="contributions-collapse">
            <? else: ?>
                <button class="fw-bold btn btn-lg btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#contributions-collapse" aria-expanded="false">Contributions</button>
                <div class="collapse collapsed" id="contributions-collapse">
            <? endif; ?>
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li class="d-flex flex-row">
                        <a href="#" class="link-dark d-inline-flex text-decoration-none rounded <?=($activeMenu === 1) ? "active-menu": "" ?>">Recordings</a>
                        <? if($_SESSION['authenticated']): ?>
                            <a href="/session/new" class="btn btn-success h-100 my-auto mx-2" role="button"><i class="bi bi-cloud-upload"></i></a>
                        <? endif; ?>
                    </li>
                    <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded <?=($activeMenu === 2) ? "active-menu": "" ?>">Comments</a></li>
                    <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded <?=($activeMenu === 3) ? "active-menu": "" ?>">Likes</a></li>
                </ul>
            </div>
        </li>
        <? if (isset($contributionsOnly) && ! $contributionsOnly): ?>
            <li class="mb-1">
                <? if(isset($activeMenu) && $activeMenu > 3 && $activeMenu <= 6 ): ?>
                    <button class="fw-bold btn btn-lg btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="true">
                        Account
                    </button>
                    <div class="collapse show" id="account-collapse">
                <? else: ?>
                    <button class="fw-bold btn btn-lg btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                        Account
                    </button>
                    <div class="collapse collapsed" id="account-collapse">
                <? endif; ?>
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="/user/<?=$_SESSION['username']?>" class="link-dark d-inline-flex text-decoration-none rounded <?=($activeMenu === 4) ? "active-menu": "" ?>">Profile</a></li>
                        <li><a href="/user/<?=$_SESSION['username']?>/security" class="link-dark d-inline-flex text-decoration-none rounded <?=($activeMenu === 5) ? "active-menu": "" ?>">Security</a></li>
                        <li><a href="/logout" class="link-dark d-inline-flex text-decoration-none rounded <?=($activeMenu === 6) ? "active-menu": "" ?>">Logout</a></li>
                    </ul>
                </div>
            </li>
        <? endif; ?>
    </ul>
</nav>