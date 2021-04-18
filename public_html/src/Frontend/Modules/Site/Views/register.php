<?php

use OSM\Core\Collections\ChampionshipCollection;
use OSM\Core\Collections\CountryCollection;
use OSM\Frontend\Helpers\ActiveHtml;
use OSM\Frontend\Helpers\Html;
use OSM\Frontend\Modules\Site\ViewModels\RegistrationViewModel;
use OSM\Frontend\Templates\LayoutTypes;

$this->layout(LayoutTypes::TYPE_DEFAULT_OUTSIDE);

/** @var CountryCollection $countries */
/** @var ChampionshipCollection $championships */
/** @var RegistrationViewModel $model */

?>
<h1><?= _d('frontend', 'Registration') ?></h1>
<p><?= _d('frontend', "Fill this application for your very own football club") ?></p>

<form method="post" action="/register">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <?= Html::label(_d('frontend', 'Username'), ['class' => 'form-label']) ?>
                <?= Html::inputText('username', $model->username, ['class' => 'form-control']) ?>
                <?= ActiveHtml::fieldError($model, 'username') ?>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?= Html::tag('label', _d('frontend', 'Team name'), ['class' => 'form-label']) ?>
                <?= Html::inputText('team_name', $model->teamName, ['class' => 'form-control']) ?>
                <?= ActiveHtml::fieldError($model, 'teamName') ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?= Html::tag('label', _d('frontend', 'Password'), ['class' => 'form-label']) ?>
                <?= Html::inputPassword('password', $model->password, ['class' => 'form-control']) ?>
                <?= ActiveHtml::fieldError($model, 'password') ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?= Html::tag('label', _d('frontend', 'Password again'), ['class' => 'form-label']) ?>
                <?= Html::inputPassword('password_again', $model->passwordAgain, ['class' => 'form-control']) ?>
                <?= ActiveHtml::fieldError($model, 'passwordAgain') ?>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?= Html::tag('label', _d('frontend', 'Country'), ['class' => 'form-label']) ?>
                <?= Html::select(
                    'country_id',
                    $countries->mapFieldById('name'),
                    $model->countryId,
                    [
                        'placeholder' => _d('frontend', 'Select country'),
                        'class' => 'form-control',
                    ]
                ) ?>
                <?= ActiveHtml::fieldError($model, 'countryId') ?>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?= Html::tag('label', _d('frontend', 'Championship'), ['class' => 'form-label']) ?>
                <?= Html::select(
                    'championship_id',
                    $championships->mapFieldById('name'),
                    $model->championshipId,
                    [
                        'placeholder' => _d('frontend', 'Select championship'),
                        'class' => 'form-control',
                    ]
                ) ?>
                <?= ActiveHtml::fieldError($model, 'championshipId') ?>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <?= Html::submitButton(_d('frontend', 'Register')) ?>
            </div>
        </div>
    </div>
</form>

