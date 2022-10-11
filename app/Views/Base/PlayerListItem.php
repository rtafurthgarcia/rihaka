<div class="card shadow-sm col me-3 px-0 mb-3">
    <div class="player-light rounded-top-2">
        <source src="<?='/' . $recording->getVideoLink()?>">
        <time class="d-none"><?=\App\Core\ConverterHelper::secondsToTime($recording->getTimeToDisplay())?></time>
    </div>
    <div class="card-body">
        <p class="card-text <?=($hideDescAndTitle)? "d-none" : ""?>"><?=$recording->getDescription()?></p>
        <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
                <a href="/recording/<?=$recording->getSecondaryId()?>/full" class="btn btn-sm btn-outline-secondary" role="button">View</a>
                <? if (! $hideEdit): ?>
                    <a href="/recording/<?=$recording->getSecondaryId()?>" class="btn btn-sm btn-outline-secondary" role="button">Edit</a>
                <? endif; ?>
            </div>
            <small class="text-muted"><?=\App\Core\ConverterHelper::secondsToTime($recording->getLength())?></small>
        </div>
    </div>
</div>