<div class="container pt-3">
    <nav class="mb-3 row">
        <div class="nav nav-tabs col-12 col-md-6" id="nav-tab" role="tablist">
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
        <div class="signup-form col-12 col-md-5 me-md-5">
            <? if((isset($successful) && ! $successful) || ! isset($successful)): ?>
                <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab" tabindex="0">
            <? else: ?>
                <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab" tabindex="-1" hidden>
            <? endif; ?>
                <h2>Sign-up</h2>
                <p>By having a RIHAKA account, you can vote, comment and post all your sweet sweet honeypot sessions logs. Sign up in just seconds.</p>
                <form id="registration-form" action="/register#" onsubmit="onFormSubmitted(this, event)" method="post" class="needs-validation" autocomplete="on" novalidate>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control <?=(isset($errors["email"])) ? "is-invalid" : "" ?>" name="email" id="floating-email" minlength="3" maxlength="254" placeholder="johndoe@hftm.ch" value="<?=isset($user) ? $user->getemail() : ''?>" autocomplete="email" required>
                        <label for="floating-email">Email address</label>
                        <div class="invalid-feedback">
                            <?=(isset($errors["email"])) ? $errors["email"] : "E-Mail doesnt match a proper E-Mail pattern." ?>
                        </div>
                        <div class="form-text">
                            We won't share your e-mail address with anybody. 
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">@</span>
                        <div class="form-floating">
                            <input type="text" class="form-control <?=(isset($errors["username"])) ? "is-invalid" : "" ?>" name="username" id="floating-user" placeholder="Username" minlength="3" maxlength="30" value="<?=isset($user) ? $user->getuserName() : ''?>" autocomplete="username" required>
                            <label for="floating-user">Username</label>
                        </div>
                        <div class="invalid-feedback">
                            <?=(isset($errors["username"])) ? $errors["username"] : "Your username's length has to be between 3 and 30 characters." ?>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?=(isset($errors["password"])) ? "is-invalid" : "" ?>" name="password" id="floating-password" minlength="10" placeholder="Password" onChange="onPasswordChange()" autocomplete="new-password" required>
                        <label for="floating-password">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?=(isset($errors["password"])) ? "is-invalid" : "" ?>" name="password-confirmation" id="floating-password-2" minlength="10" placeholder="Password"  onChange="onPasswordChange()" autocomplete="new-password" required>
                        <label for="floating-password-2">Password confirmation</label>
                        <div class="invalid-feedback">
                            <?=(isset($errors["password"])) ? $errors["password"] : "Passwords either do not meet length requirements or do not match." ?>
                        </div>
                        <div class="form-text">
                            Your password must be at least 10 characters long to fit our minimal requirements.
                        </div>
                    </div>
                    <button id="submit-button" type="submit" class="btn btn-secondary mb-3">Next</button>
                </form>
            </div>
            <? if((isset($successful) && $successful)): ?>
                <div class="tab-pane fade show active" id="nav-confirm" role="tabpanel" aria-labelledby="nav-confirm-tab" tabindex="0">
            <? else: ?>
                <div class="tab-pane fade" id="nav-confirm" role="tabpanel" aria-labelledby="nav-confirm-tab" tabindex="-1" hidden>
            <? endif; ?>
            <h3>
                Activation link sent!
                <small class="text-muted">Just one last step ahead</small>
            </h3>
            <p class="lead">
                We just sent an activation e-mail to <a href="mailto:<?=isset($user) ? $user->getemail(): ''?>"><?=isset($user) ? $user->getemail(): ''?></a>. Please make sure to click on the link before trying to log-in or going any further.
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
        </div>
    </div>
</div>