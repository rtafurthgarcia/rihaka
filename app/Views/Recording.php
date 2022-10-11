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
            <div class="d-flex flex-row justify-content-between col-12 col-lg-9"> 
                <? if (isset($recording)): ?>  
                    <h2>Edit an exisiting recording</h2>
                    <? if (isset($user) && $_SESSION['id'] === $user->getPrimaryKey()): ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirmation-modal">
                            <i class="bi bi-trash me-2"></i>Delete recording
                        </button>
                        <div class="modal fade" id="delete-confirmation-modal" tabindex="-1" aria-labelledby="delete-confirmation-label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="delete-confirmation-label">Confirmation</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this one recording? This operation cannot be reversed. 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nope</button>
                                    <a href="/recording/<?=$recording->getSecondaryId()?>/delete" class="btn btn-danger h-100 my-auto mx-1" role="button">
                                        <i class="bi bi-trash me-2"></i>Yes, delete this recording
                                    </a>
                                </div>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>                
                <? else: ?>
                    <h2>Publish a new recording</h2>
                <? endif; ?>
            </div>
            <form id="recording-form" action="/recording/<?=(isset($recording)) ? $recording->getSecondaryId() : "new" ?>" onsubmit="onFormSubmitted(this, event)" method="post" enctype="multipart/form-data" class="needs-validation container col-12 col-lg-9 text-start p-3 m-0" novalidate>
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
                        <textarea maxlength="300" class="form-control" id="description" name="description" style="height: 100%"><?=(isset($recording)) ? $recording->getDescription() : ""?></textarea>
                        <label for="description">Description</label>
                    </div>
                </div>
                <div class="row">
                    <? if (isset($recording) && $recording->getVideoLink()) :?>
                        <?=$this->fetch('./Base/PlayerCard.php', [
                            "recording" => $recording,
                            "hideEdit" => (isset($_SESSION['id'])) && ($recording->getUserId() === $_SESSION['id']),
                            "hideDescAndTitle" => true
                        ])?>
                        <input class="d-none" type="hidden" name="display-time" id="display-time" value="<?=\App\Core\ConverterHelper::secondsToTime($recording->getTimeToDisplay())?>">
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
                        <a href="/user/<?=$_SESSION['username']?>" class="btn btn-secondary float-end" role="button">Cancel</a>
                        <button id="submit-button" type="submit" class="btn btn-success mb-3">Publish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>