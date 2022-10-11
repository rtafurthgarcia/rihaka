<div class="card shadow-sm col-12 col-lg-4 mx-3 mb-3 px-0">
    <div class="player-light rounded-top-2">
        <source src="<?='/' . $recording->getVideoLink()?>">
        <time class="d-none"><?=\App\Core\ConverterHelper::secondsToTime($recording->getTimeToDisplay())?></time>
    </div>
    <div class="card-body">
        <div class="d-block mb-1">
            <div class="d-flex justify-content-between align-items-center">
                <a href="/user/<?=$recording->getUserName()?>"><?=$recording->getUserName()?></a>
                <small class="text-muted">Posted on <?=$recording->getCreationDate()->format('j M Y')?></small>
            </div>
            <p class="card-text"><?=$recording->getTitle()?></p>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <? if ($_SESSION['id'] === $recording->getUserId()): ?>
                <div class="btn-group">
                    <a href="/recording/<?=$recording->getSecondaryId()?>" class="btn btn-sm btn-outline-secondary" role="button">Edit</a>
                </div>
            <? endif; ?>
            <div class="btn-group">
                <? foreach($recording->getCategories() as $category): ?>
                    <a href="#" class="btn btn-sm btn-outline-secondary" role="button"><?=$category->getName()?></a>
                <? endforeach; ?>
            </div>
            <small class="text-muted"><?=\App\Core\ConverterHelper::secondsToTime($recording->getLength())?></small>
        </div>
    </div>
</div>