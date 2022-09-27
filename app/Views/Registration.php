<div class="container pt-3">
    <nav class="mb-3 row">
        <div class="nav nav-tabs col-6" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="true">
                <span class="badge text-bg-secondary mx-2">1</span>Fill-in
            </button>
            <button class="nav-link" id="nav-confirm-tab" data-bs-toggle="tab" data-bs-target="#nav-confirm" type="button" role="tab" aria-controls="nav-confirm" aria-selected="false" disabled>
                <span class="badge text-bg-secondary mx-2">2</span>Confirm
            </button>
            <button class="nav-link" id="nav-validate-tab" data-bs-toggle="tab" data-bs-target="#nav-validate" type="button" role="tab" aria-controls="nav-validate" aria-selected="false" disabled>
                <span class="badge text-bg-secondary mx-2">3</span>Activate
            </button>
        </div>
    </nav>
    <div class="row align-items-start">
        <div class="signup-form col-12 col-md-6">
            <h2>Sign-up</h2>
            <p>By having a RIHAKA account, you can vote, comment and post all your sweet sweet honeypot sessions logs. Sign up in just seconds.</p>
            <form id="registration-form" method="post" enctype="multipart/form-data">
                <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab" tabindex="0">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floating-email" placeholder="johndoe@hftm.ch" required>
                        <label for="floating-email">Email address</label>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">@</span>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floating-user" placeholder="Username" minlength="3" maxlength="30" required>
                            <label for="floating-user">Username</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floating-password" minlength="10" placeholder="Password" required>
                        <label for="floating-password">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floating-password-2" minlength="10" placeholder="Password" required>
                        <label for="floating-password-2">Password confirmation</label>
                    </div>
                    <button id="previous-button" type="button" class="btn btn-secondary mb-3" onclick="previousTab()" hidden>Previous</button>
                    <button id="next-button" type="button" class="btn btn-secondary mb-3" onclick="goNextTab()">Next</button>
                    <button id="submit-button" type="submit" class="btn btn-secondary mb-3" hidden>Submit</button>
                </div>
                <div class="tab-pane fade" id="nav-confirm" role="tabpanel" aria-labelledby="nav-confirm-tab" tabindex="-1">...</div>
                <div class="tab-pane fade" id="nav-validate" role="tabpanel" aria-labelledby="nav-validate-tab" tabindex="-1">...</div>
            </form>
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