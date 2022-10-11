<div class="card shadow-sm col-12 col-lg-4 ms-3 me-5 mb-3 px-0">
    <div class="player-light rounded-top-2" onclick="location.href='<?='/recording/' . $recording->getSecondaryId()?>'">
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
            <div class="btn-group">
                <? foreach($recording->getCategories() as $category): ?>
                    <a href="#" class="btn btn-sm btn-outline-secondary" role="button"><?=$category->getName()?></a>
                <? endforeach; ?>
            </div>
            <small class="text-muted"><?=\App\Core\ConverterHelper::secondsToTime($recording->getLength())?></small>
        </div>
    </div>
</div>