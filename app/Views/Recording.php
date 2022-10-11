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
            <h2><?=(isset($recording)) ? "Edit an exisiting recording" : "Publish a new recording"?> </h2>
            <form id="recording-form" onsubmit="onFormSubmitted(this, event)" method="post" enctype="multipart/form-data" class="needs-validation container col-12 col-lg-9 text-start p-3 m-0" novalidate>
                <input type="hidden" name="max_file_size" value="20971520">
                <div class="row">
                    <div class="form-floating mb-3 col-12 col-lg p-0 p-md me-0 me-md-3">
                        <input type="text" class="form-control <?=(isset($errors["title"])) ? "is-invalid" : "" ?>" name="title" id="floating-title" minlength="10" maxlength="50" value="<?=(isset($recording)) ? $recording->getTitle(): ""?>" required>
                        <label for="floating-title">Title</label>
                        <div class="invalid-feedback">
                            <?=(isset($errors["title"])) ? $errors["title"] : "Oops.. Make sure the title is between 10 and 50 caracters long." ?>
                        </div>
                    </div>
                    
                    <div class="form-floating mb-3 col-12 col-lg p-0 p-md">
                        <div class="keyword-box h-100">
                            <ul class="m-0 p-0 h-100">
                                <input type="text" class="form-control form-control-lg p-0 ps-3" spellcheck="false" placeholder="Categories" value="<?=(isset($recording)) ? $recording->getCategoriesAsString(): '' ?>">
                                <input type="text" class="d-none" id="categories" name="categories" spellcheck="false">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-floating mb-3 col-12 p-0 p-md">
                        <textarea maxlength="300" class="form-control" OnKeyDown='return onKeyDownBiography();' id="description" name="description" style="height: 100%"><?=(isset($recording)) ? $recording->getDescription() : ""?></textarea>
                        <label for="description">Description</label>
                    </div>
                </div>
                <div class="row">
                    <? if (isset($recording) && $recording->getVideoLink()) :?>
                        <?=$this->fetch('./Base/PlayerCard.php', [
                            "recording" => $recording,
                            "hideEdit" => (isset($_SESSION['id'])) && ($recording->getUserId() === $_SESSION['id'])
                        ])?>
                    <? else: ?>
                        <div class="mb-3 col-12 col-lg p-0 p-md me-0">
                            <label for="recording-file" class="form-label">UML Record (will be automatically converted)</label>
                            <input class="form-control" type="file" name="recording-file" id="recording-file" required>
                        </div>
                    <? endif; ?>
                </div> 
                <div class="row mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="isPrivate" id="checkbox-is-private" <?=((isset($recording)) && $recording->getIsPrivate()) ? "checked" : ""?>>
                        <label class="form-check-label" for="checkbox-is-private">
                            This recording is gonna be private aka only accessible by me.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="commentsAuthorized" id="checkbox-comments-authorized" <?=((isset($recording)) && $recording->getCommentsAuthorized()) ? "checked" : ""?>>
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