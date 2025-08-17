<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
/**
* @var array $arParams
* @var array $arResult
* @var CMain $APPLICATION
* @var CBitrixComponent $component
* @var CBitrixComponentTemplate $this
*/
?>


<div class="samples-user-card">
    <?php if (isset($arResult['PERSONAL_PHOTO_SRC'])): ?>
    <div class="samples-user-card__avatar">
        <img
            class="js-samples-user-card-avatar-show-in-new-page"
            src="<?= $arResult['PERSONAL_PHOTO_SRC'] ?>"
            alt="<?= $arResult['NAME'] ?>"
        >
    </div>    
    <?php endif; ?>
    
    <div class="samples-user-card__info">
        <h2 class="samples-user-card__name">
            <?= $arResult['NAME'] ?>
        </h2>
        <?php if ($arParams['SHOW_EMAIL'] === 'Y'): ?>
            <p class="samples-user-card__email">
                <span><?= Loc::getMessage('USER_CARD_EMAIL_LABEL') ?></span>
                <span><?= $arResult['EMAIL'] ?></span>
            </p>
        <?php endif; ?>
    </div>
</div>
