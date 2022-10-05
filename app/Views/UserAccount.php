<div class="container pt-3">
    <div class="row align-items-start">
        <?=$this->fetch('./Base/Sidebar.php', [])?>
        <div class="signup-form col-12 col-xl-10 col-lg-9 col-md-8 px-4 py-4 py-md-0">
            <? if((isset($successful) && $successful)): ?>
                <div class="alert alert-success" role="alert">
                    User information updated successfully!
                </div>
            <? endif; ?>
            <h2>Account informations</h2>
            <form id="account-form" onsubmit="onFormSubmitted(event)" method="post" class="needs-validation container col-12 col-lg-9 text-start p-3 m-0" novalidate>
                <div class="row justify-content-center">
                    <div class="form-floating mb-3 col-12 col-md-9 p-0 pe-md-3 p-md">
                        <textarea class="form-control" placeholder="Write something about ya. Keep in mind everything's gonna be sanitized except links to external websites." id="biography" style="height: 100%"></textarea>
                        <label for="biography">Biography</label>
                    </div>
                    <div class="mb-3 p-0 col-9 col-md-3">
                        <label for="pp-file" class="form-label p-0 m-0">
                            <img src="/images/pp.jpg" class="m-0 p-0 img-thumbnail">
                        </label>
                        <input class="d-none" type="file" id="pp-file">
                    </div>
                </div>
                <div class="row">
                    <div class="form-floating mb-3 col-md p-0 p-md me-0 me-md-3">
                        <input type="email" class="form-control <?=(isset($errors["email"])) ? "is-invalid" : "" ?>" name="email" id="floating-email" minlength="3" maxlength="254" placeholder="johndoe@hftm.ch" value="<?=isset($user) ? $user->getemail() : ''?>" autocomplete="email" required>
                        <label for="floating-email">Email address</label>
                        <div class="invalid-feedback">
                            <?=(isset($errors["email"])) ? $errors["email"] : "E-Mail doesnt match a proper E-Mail pattern." ?>
                        </div>
                    </div>
                    <div class="input-group mb-3 col-md p-0 p-md">
                        <span class="input-group-text">@</span>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="username" id="floating-user" placeholder="Username" minlength="3" maxlength="30" value="<?=isset($user) ? $user->getuserName() : ''?>" autocomplete="username" readonly>
                            <label for="floating-user">Username</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-12 px-0">
                        <button id="submit-button" type="submit" class="btn btn-secondary mb-3">Save</button>
                        <a href="/user/<?=$_SESSION['username']?>" class="btn btn-warning float-end" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>