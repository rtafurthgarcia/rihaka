<div class="container pt-3">
    <div class="row align-items-start">
        <?=$this->fetch('./Base/Sidebar.php', ["activeMenu" => $activeMenu, "contributionsOnly" => $contributionsOnly])?>
        <div class="signup-form col-12 col-xl-10 col-lg-9 col-md-8 px-4 pe-md-0 py-4 py-md-0">
            <? if((isset($successful))): ?>
                <? if($successful): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        Recording successfully published !
                    </div>
                <? else: ?>
                    <? if((isset($errors["upload"]))): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <?=$errors["upload"]?>
                        </div>
                    <? endif; ?>
                <? endif; ?>
            <? endif; ?>
            <? if (isset($_COOKIE['showHelpUpload']) && $_COOKIE['showHelpUpload']): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-stars"></i>
                    From here you can publish all the ssh-honeypot recordings you collected. As long you find it cool, We are pretty sure others are also gonna think the same :3
                    <button type="button" id="showHelpUpload" onclick="onHideHelp(this)" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <? endif; ?>
            <h2>Publish a new recording</h2>
            <form id="recording-form" onsubmit="onFormSubmitted(this, event)" method="post" enctype="multipart/form-data" class="needs-validation container col-12 col-lg-9 text-start p-3 m-0" novalidate>
                <input type="hidden" name="max_file_size" value="20971520">
                <div class="row">
                    <div class="form-floating mb-3 col-12 p-0 p-md">
                        <textarea maxlength="300" class="form-control" OnKeyDown='return onKeyDownBiography();' id="description" name="description" style="height: 100%"><?=isset($category) ? $category->getBiography() : ''?></textarea>
                        <label for="description">Description</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-floating mb-3 col-12 col-lg p-0 p-md me-0 me-md-3">
                        <input type="title" class="form-control <?=(isset($errors["title"])) ? "is-invalid" : "" ?>" name="title" id="floating-title" minlength="10" maxlength="50" required>
                        <label for="floating-title">Title</label>
                        <div class="invalid-feedback">
                            <?=(isset($errors["title"])) ? $errors["title"] : "Oops.. Make sure the title is between 10 and 50 caracters long." ?>
                        </div>
                    </div>
                    <div class="form-floating mb-3 col-12 col-lg p-0 p-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="category" id="floating-category" minlength="3" maxlength="50">
                            <label for="floating-category">Categories</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-12 col-lg p-0 p-md me-0">
                        <label for="recording-file" class="form-label">UML Record (will be automatically converted)</label>
                        <input class="form-control" type="file" name="recording-file" id="recording-file">
                    </div>
                </div> 
                <div class="row mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="isPrivate" id="checkbox-is-private">
                        <label class="form-check-label" for="checkbox-is-private">
                            This recording is gonna be private aka only accessible by me.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="commentsAuthorized" id="checkbox-comments-authorized" checked>
                        <label class="form-check-label" for="checkbox-comments-authorized">
                            Everyone can comment that recording.
                        </label>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-12 px-0">
                        <a href="/recording/<?=$_SESSION['username']?>" class="btn btn-secondary float-end" role="button">Cancel</a>
                        <button id="submit-button" type="submit" class="btn btn-success mb-3">Publish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>