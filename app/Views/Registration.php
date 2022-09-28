<div class="container pt-3">
    <nav class="mb-3 row">
        <div class="nav nav-tabs col-6" id="nav-tab" role="tablist">
            <? if((isset($successful) && ! $successful) || ! isset($successful)): ?>
                <button class="nav-link active" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="true">
            <? else: ?>
                <button class="nav-link" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="false" disabled>
            <? endif; ?>
                <span class="badge text-bg-secondary mx-2">1</span>Fill-in
            </button>
            <? if((isset($successful) && $successful)): ?>
                <button class="nav-link active" id="nav-confirm-tab" data-bs-toggle="tab" data-bs-target="#nav-confirm" type="button" role="tab" aria-controls="nav-confirm" aria-selected="true">
            <? else: ?>
                <button class="nav-link" id="nav-confirm-tab" data-bs-toggle="tab" data-bs-target="#nav-confirm" type="button" role="tab" aria-controls="nav-confirm" aria-selected="false" disabled>
            <? endif; ?>
                <span class="badge text-bg-secondary mx-2">2</span>Confirm
            </button>
        </div>
    </nav>
    <div class="row align-items-start">
        <div class="signup-form col-12 col-md-6">
            <? if((isset($successful) && ! $successful) || ! isset($successful)): ?>
                <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab" tabindex="0">
            <? else: ?>
                <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab" tabindex="-1" hidden>
            <? endif; ?>
                <h2>Sign-up</h2>
                <p>By having a RIHAKA account, you can vote, comment and post all your sweet sweet honeypot sessions logs. Sign up in just seconds.</p>
                <form id="registration-form" method="post">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="floating-email" placeholder="johndoe@hftm.ch" required>
                        <label for="floating-email">Email address</label>
                        <div class="form-text">
                            We won't share your e-mail address with anybody. 
                        </div>
                        <? if(isset($errors["email"])): ?>
                            <div class="invalid-feedback">
                                <?=$errors["email"] ?>
                            </div>
                        <? endif; ?>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">@</span>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="username" id="floating-user" placeholder="Username" minlength="3" maxlength="30" required>
                            <label for="floating-user">Username</label>
                            <? if(isset($errors["username"])): ?>
                                <div class="invalid-feedback">
                                    <?=$errors["username"] ?>
                                </div>
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="floating-password" minlength="10" placeholder="Password" required>
                        <label for="floating-password">Password</label>
                        <div class="form-text">
                            Your password must be at least 10 characters long to fit our minimal requirements.
                        </div>
                        <? if(isset($errors["password"])): ?>
                            <div class="invalid-feedback">
                                <?=$errors["password"] ?>
                            </div>
                        <? endif; ?>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password-confirmation" id="floating-password-2" minlength="10" placeholder="Password" required>
                        <label for="floating-password-2">Password confirmation</label>
                    </div>
                    <button id="submit-button" type="submit" class="btn btn-secondary mb-3">Submit</button>
                </form>
            </div>
            <? if((isset($successful) && $successful)): ?>
                <div class="tab-pane fade show active" id="nav-confirm" role="tabpanel" aria-labelledby="nav-confirm-tab" tabindex="0">
            <? else: ?>
                <div class="tab-pane fade" id="nav-confirm" role="tabpanel" aria-labelledby="nav-confirm-tab" tabindex="-1" hidden>
            <? endif; ?>
            <h3>
                Activation link sent!
                <small class="text-muted">Just one last step ahead!</small>
            </h3>
            <p class="lead">
                We've send an activation e-mail to your inbox. Please make sure to click on the link before trying to log-in or going any further.
            </p>
            </div>
        </div>
        <div class="signup-title col-12 col-md-6">
            <p class="display-1 font-monospace d-none d-md-block" id="r-brand">
                RIHAKA<br>
                II<br>
                H&nbsp;H<br>
                A&nbsp;&nbsp;A<br>
                K&nbsp;&nbsp;&nbsp;K<br>
                A&nbsp;&nbsp;&nbsp;&nbsp;A<br>
            </p>
            <!--<div class="row"><p class="col-7 fs-1 font-monospace">RIHAKA</p></div>
            <div class="row"><p class="col-1 fs-1 font-monospace">I</p></div>
            <div class="row"><p class="col-1 fs-1 font-monospace">H</p></div>
            <div class="row"><p class="col-1 fs-1 font-monospace">A</p></div>
            <div class="row"><p class="col-1 fs-1 font-monospace">K</p></div>
            <div class="row"><p class="col-1 fs-1 font-monospace">A</p></div>-->
        </div>
    </div>
</div>