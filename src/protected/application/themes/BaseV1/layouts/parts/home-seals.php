<?php

if(!$app->isEnabled('seals')){
    return;
}

$class_seal = 'MapasCulturais\Entities\Seal';
$num_seals             = $this->getNumEntities($class_seal);
$num_verified_seals    = $this->getNumEntities($class_seal, true);
$seal_areas = array_values($app->getRegisteredTaxonomy($class_seal, 'area')->restrictedTerms);
sort($seal_areas);

$seal_types = $app->getRegisteredEntityTypes($class_seal);

$seal_img_attributes = 'class="random-feature no-image"';

$seal = $this->getOneVerifiedEntity($class_seal);
if($seal && $img_url = $this->getEntityFeaturedImageUrl($seal)){
    $seal_img_attributes = 'class="random-feature" style="background-image: url(' . $img_url . ');"';
}

$url_search_seals = $this->searchSealsUrl;

?>

<article id="home-seals" class="js-page-menu-item home-entity clearfix">
    <div class="box">
        <h1><span class="icon icon-seal"></span> Selos</h1>
        <div class="clearfix">
            <div class="statistics">
                <div class="statistic"><?php echo $num_seals ?></div>
                <div class="statistic-label">selos cadastrados</div>
            </div>
            <div class="statistics">
                <div class="statistic"><?php echo $num_verified_seals ?></div>
                <div class="statistic-label">selos da <?php $this->dict('home: abbreviation'); ?></div>
            </div>
        </div>
        <p><?php $this->dict('home: seals') ?></p>
        <h4>Encontre selos por</h4>
        <ul class="abas clearfix">
            <li class="active"><a href="#seal-terms">Área de atuação</a></li>
            <li><a href="#seal-types">Tipo</a></li>
        </ul>
        <div id="seal-terms" class="tag-box">
            <div>
                <?php foreach ($seal_areas as $i => $t): ?>
                    <a class="tag" href="<?php echo $app->createUrl('site', 'search') ?>##(seal:(areas:!(<?php echo $i ?>)),global:(enabled:(seal:!t),filterEntity:seal))"><?php echo $t ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="agent-types" class="tag-box">
            <div>
                <?php foreach ($seal_types as $t): ?>
                    <a class="tag" href="<?php echo $app->createUrl('site', 'search') ?>##(seal:(type:<?php echo $t->id ?>),global:(enabled:(seal:!t),filterEntity:seal))"><?php echo $t->name ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="box">
        <?php if($seal): ?>
        <a href="<?php echo $seal->singleUrl ?>">
            <div <?php echo $seal_img_attributes;?>>
                <div class="feature-content">
                    <h3>destaque</h3>
                    <h2><?php echo $seal->name ?></h2>
                    <p><?php echo $seal->shortDescription ?></p>
                </div>
            </div>
        </a>
        <?php endif; ?>
        <a class="btn btn-accent btn-large add" href="<?php echo $app->createUrl('seal', 'create') ?>">Adicionar selo</a>
        <a class="btn btn-accent btn-large" href="<?php echo $url_search_seals ?>">Ver tudo</a>
    </div>
</article>