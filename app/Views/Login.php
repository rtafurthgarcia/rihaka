<div class="container pt-3">
    <div class="row align-items-start">
        <div class="signup-form col-12 col-md-5 me-md-5">
            <h2>Log-in</h2>
            <p>By login-in your RIHAKA account, you can vote, comment and post all your sweet sweet honeypot sessions logs. </p>
            <form id="login-form" action="/login#" onsubmit="onFormSubmitted(this, event)" method="post" class="needs-validation" autocomplete="on" novalidate>
                <div class="input-group mb-3">
                    <span class="input-group-text">@</span>
                    <div class="form-floating">
                        <input type="text" class="form-control <?=(isset($errors["email"])) ? "is-invalid" : "" ?>" name="email" id="floating-email" placeholder="Username or E-Mail" minlength="3" maxlength="254" value="<?=isset($user) ? $user->getuserName() : ''?>" autocomplete="email" required>
                        <label for="floating-email">E-Mail or Username</label>
                    </div>
                    <div class="invalid-feedback">
                        <?=(isset($errors["email"])) ? $errors["email"] : "Your E-Mail address or your username cannot be empty." ?>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control <?=(isset($errors["password"])) ? "is-invalid" : "" ?>" name="password" id="floating-password" minlength="10" placeholder="Password" autocomplete="current-password" required>
                    <label for="floating-password">Password</label>
                    <div class="invalid-feedback">
                        <?=(isset($errors["password"])) ? $errors["password"] : "Passwords either do not meet length requirements or do not match." ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button id="submit-button" type="submit" class="btn btn-secondary mb-3">Log-in</button>
                    </div>
                    <div class="col">
                        <a href="/register" class="btn btn-warning float-end" role="button">No account?</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="signup-title col-12 col-md-6">
            <?=$this->fetch('./Base/Rihaka.php', [])?>
        </div>
    </div>
</div>