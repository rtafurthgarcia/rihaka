<div class="card shadow-sm mx-0 px-0 mb-3">
    <div class="player rounded-top-2">
        <source src="<?='/' . $recording->getVideoLink()?>">
        <time id="display-time" class="d-none" value="<?=\App\Core\ConverterHelper::secondsToTime($recording->getTimeToDisplay())?>">
    </div>
    <div class="card-body">
        <? if($lightVersion): ?>
            <p class="card-text <?=($lightVersion)? "d-none" : ""?>"><?=$recording->getDescription()?></p>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted"><?=\App\Core\ConverterHelper::secondsToTime($recording->getLength())?></small>
            </div>
        <? else :?>
            <div class="d-block mb-1">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="/user/<?=$recording->getUserName()?>"><?=$recording->getUserName()?></a>
                    <small class="text-muted">Posted on <?=$recording->getCreationDate()->format('j M Y')?></small>
                </div>
            </div>
            <div class="d-block mb-1">
                <p class="card-text"><?=$recording->getDescription()?></p>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <? foreach($recording->getCategories() as $category): ?>
                        <a href="#" class="btn btn-sm btn-outline-secondary" role="button"><?=$category->getName()?></a>
                    <? endforeach; ?>
                </div>
                <small class="text-muted"><?=\App\Core\ConverterHelper::secondsToTime($recording->getLength())?></small>
            </div>
        <? endif; ?>
        
    </div>
    
</div>