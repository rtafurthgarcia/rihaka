<div class="container pt-3">
    <div class="row align-items-start">
        <?=$this->fetch('./Base/Sidebar.php', ["activeMenu" => $activeMenu, "contributionsOnly" => $contributionsOnly])?>
        <div class="signup-form col-12 col-xl-10 col-lg-9 col-md-8 px-4 pe-md-0 py-4 py-md-0">
            <? if((isset($successful))): ?>
                <? if($successful): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        User information updated successfully!
                    </div>
                <? else: ?>
                    <? if((array_key_exists("upload", $errors))): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <?=$errors["upload"]?>
                        </div>
                    <? endif; ?>
                <? endif; ?>
            <? endif; ?>
            <? if ($_SESSION['id'] === $user->getPrimaryKey()): ?>
                <? if (isset($_COOKIE['showHelpAccount']) && $_COOKIE['showHelpAccount']): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-stars"></i>
                        Don't forget to put a nice profile picture and write down a few words in your bio before getting really started :3
                        <button type="button" id="showHelpAccount" onclick="onHideHelp(this)" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <? endif; ?>
                <div class="d-flex flex-row justify-content-between col-12 col-lg-9"> 
                    <h2>Account informations</h2>
                    <? if ($_SESSION['id'] === $user->getPrimaryKey()): ?>
                        <a href="/recording/new" class="btn btn-success h-100 my-auto mx-2" role="button"><i class="bi bi-cloud-upload mx-1"></i>Publish recording</a>
                    <? endif; ?>
                </div>
                <form id="account-form" onsubmit="onFormSubmitted(this, event)" method="post" enctype="multipart/form-data" class="needs-validation container col-12 col-lg-9 text-start p-3 m-0" novalidate>
                    <input type="hidden" name="max_file_size" value="2097152">
                    <div class="row justify-content-center">
                        <div class="form-floating mb-3 col-12 col-md-9 p-0 pe-md-3 p-md">
                            <textarea maxlength="300" class="form-control" OnKeyDown='return onKeyDownBiography();' placeholder="Write something about ya. Keep in mind everything's gonna be sanitized except links to external websites." id="biography" name="biography" style="height: 100%"><?=isset($user) ? trim($user->getBiography()) : ''?></textarea>
                            <label for="biography">Biography</label>
                        </div>
                        <div class="mb-3 p-0 col-9 col-md-3">
                            <label for="photo" class="form-label p-0 m-0">
                                <img id="img-photo" src="/<?=($user->getPhoto()) ? $user->getPhoto() : "images/default_pp.svg"?>" class="m-0 p-0 img-thumbnail">
                            </label>
                            <input class="d-none" type="file" id="photo" name="photo" onchange="onPictureChanged()">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating mb-3 col-12 col-lg p-0 p-md me-0 me-md-3">
                            <input type="email" class="form-control <?=(isset($errors["email"])) ? "is-invalid" : "" ?>" name="email" id="floating-email" minlength="3" maxlength="254" placeholder="johndoe@hftm.ch" value="<?=isset($user) ? $user->getEmail() : ''?>" autocomplete="email" required>
                            <label for="floating-email">Email address</label>
                            <div class="invalid-feedback">
                                <?=(isset($errors["email"])) ? $errors["email"] : "E-Mail doesnt match a proper E-Mail pattern." ?>
                            </div>
                        </div>
                        <div class="input-group mb-3 col-12 col-lg p-0 p-md">
                            <span class="input-group-text">@</span>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="username" id="floating-user" placeholder="Username" minlength="3" maxlength="30" value="<?=isset($user) ? $user->getUserName() : ''?>" autocomplete="username" readonly>
                                <label for="floating-user">Username</label>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-12 px-0">
                            <a href="/user/<?=$_SESSION['username']?>" class="btn btn-secondary float-end" role="button">Cancel</a>
                            <button id="submit-button" type="submit" class="btn btn-warning mb-3">Save</button>
                        </div>
                    </div>
                </form>
            <? else: ?>
                <h2 class="mb-0"><?=$user->getUserName()?>'s profile</h2>
                <small class="text-muted">Been here since <?=$user->getCreationDate()->format('F Y')?></small>
                <div class="container col-12 col-lg-9 text-start p-3 m-0">
                    <div class="row justify-content-center">
                        <div class="mb-3 col-12 col-md-9 p-0 pe-md-3 p-md">
                            <? if ($user->getBiography()): ?>
                                <p class="lead"><?=$user->getBiography()?></p>
                            <? else: ?>
                                <small class="text-muted">It seems this one user isn't as talkative as the others.</small>
                            <? endif; ?>
                        </div>
                        <div class="mb-3 p-0 col-9 col-md-3">
                            <img id="img-photo" src="/<?=($user->getPhoto()) ? $user->getPhoto() : "images/default_pp.svg"?>" class="m-0 p-0 img-thumbnail">
                        </div>
                    </div>
                </div>
            <? endif; ?>
        </div>
    </div>
</div>