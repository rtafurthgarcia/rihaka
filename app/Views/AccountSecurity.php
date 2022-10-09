<div class="container pt-3">
    <div class="row align-items-start">
        <?=$this->fetch('./Base/Sidebar.php', ["activeMenu" => $activeMenu, "contributionsOnly" => $contributionsOnly])?>
        <div class="signup-form col-12 col-md-8 col-lg-5 px-4 py-4 py-md-0">
            <? if((isset($successful) && $successful)): ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    Password changed successfully!
                </div>
            <? else: ?>
                <? if(isset($errors["currentPassword"]) || isset($errors["newPassword"])): ?>
                    <h2 class="fs-3 fw-semibold btn btn-lg btn-toggle d-inline-flex align-items-center rounded border-0 ps-0" data-bs-toggle="collapse" data-bs-target="#password-change-collapse" aria-expanded="true">Change your password</h2>
                    <section id="password-change-collapse" class="collapse show">
                <? else: ?>
                    <h2 class="fs-3 fw-semibold btn btn-lg btn-toggle d-inline-flex align-items-center rounded border-0 ps-0 collapsed" data-bs-toggle="collapse" data-bs-target="#password-change-collapse" aria-expanded="false">Change your password</h2>
                    <section id="password-change-collapse" class="collapse collapsed">
                <? endif; ?>
                    <p>Please enter your old password, followed by your new password and a confirmation. </p>
                    <form id="password-form" onsubmit="onFormSubmitted(this, event)" method="post" class="needs-validation" autocomplete="on" novalidate>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control <?=(isset($errors["currentPassword"])) ? "is-invalid" : "" ?>" name="current-password" id="current-password" minlength="10" placeholder="Password" autocomplete="current-password" required>
                            <label for="current-password">Current password</label>
                            <div class="invalid-feedback">
                                <?=(isset($errors["currentPassword"])) ? $errors["currentPassword"] : "Password doesn't meet requirements or match the one being currently used." ?>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control <?=(isset($errors["newPassword"])) ? "is-invalid" : "" ?>" name="password" id="password" minlength="10" placeholder="Password" autocomplete="new-password" onchange="onPasswordChange()" required>
                            <label for="password">New password</label>
                            <div class="invalid-feedback">
                                <?=(isset($errors["newPassword"])) ? $errors["newPassword"] : "New passwords either do not meet length requirements or do not match." ?>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control <?=(isset($errors["newPassword"])) ? "is-invalid" : "" ?>" name="password-confirmation" id="password-confirmation" minlength="10" placeholder="Password" autocomplete="new-password" onchange="onPasswordChange()" required>
                            <label for="password-confirmation">New password a second time</label>
                            <div class="invalid-feedback">
                                <?=(isset($errors["newPassword"])) ? $errors["newPassword"] : "New passwords either do not meet length requirements or do not match." ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button id="submit-button" type="submit" class="btn btn-secondary mb-3">Change it</button>
                            </div>
                        </div>
                    </form>
                </section>
            <? endif; ?>
            <? if(isset($errors["deletionCurrentPassword"])): ?>
                <h2 class="text-nowrap fs-3 fw-semibold btn btn-lg btn-toggle d-inline-flex align-items-center rounded border-0 ps-0" data-bs-toggle="collapse" data-bs-target="#account-deletion-collapse" aria-expanded="true">Request your account deletion</h2>
                <section id="account-deletion-collapse" class="collapse show">
            <? else: ?>
                <h2 class="text-nowrap fs-3 fw-semibold btn btn-lg btn-toggle d-inline-flex align-items-center rounded border-0 ps-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-deletion-collapse" aria-expanded="false">Request your account deletion</h2>
                <section id="account-deletion-collapse" class="collapse collapsed">
            <? endif; ?>
                <p>Please enter your current password and confirm before we can delete anything.</p>
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    Please understand deletion is <u>not</u> reversible !
                </div>
                <form id="account-deletion-form" onsubmit="onFormSubmitted(this, event)" action="/user/<?=$_SESSION['username']?>/delete" method="post" class="needs-validation" autocomplete="off" novalidate>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?=(isset($errors["deletionCurrentPassword"])) ? "is-invalid" : "" ?>" name="current-password" id="current-password" minlength="10" placeholder="Password" required>
                        <label for="current-password">Current password</label>
                        <div class="invalid-feedback">
                            <?=(isset($errors["deletionCurrentPassword"])) ? $errors["deletionCurrentPassword"] : "No proper password, no deletion." ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button id="submit-button" type="submit" class="btn btn-danger mb-3">Delete my account</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>