<?php
    include('views/layouts/header.view.php');
?>

<main>
    <h1><?= $bannerTitle ?></h1>
    <div class="card">
        <img src="/static/images/teams/<?= $bannerImage ?>" alt="All blacks logo" class="logo" />
        <div class="name">
            <em class="js-number">#<?= $number ?></em>
            <h2 class="js-first-name"><?= $first_name ?> <strong class="js-last-name"><?= $last_name ?></strong></h2>
        </div>
        <div class="profile">
            <img src="/static/images/players/<?= $image ?>" alt="<?= $first_name ?> <?= $last_name ?>" class="headshot js-image" />
            <div class="features js-featured">
                <?php foreach ($featured as $statistic) { ?>
                    <div class="feature">
                        <h3><?= $statistic['label'] ?></h3>
                        <?= $statistic['value'] ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="bio js-bio">

            <?php foreach ($bio as $bioData) { ?>
                <div class="data">
                    <strong><?= $bioData['label'] ?></strong>
                     <?= $bioData['value'] ?>
                </div>
            <?php } ?>

        </div>
        <div class="tab">
            <ul>
                <?php if($tabs['prev']) { ?>
                  <li><button class="js-tab js-tab-prev" cache=".js-cache-prev" id="<?= $tabs['prev'] ?>"><strong>Loading...</strong></li></button></li>
                <?php } ?>
                    <li><button class="active js-tab js-tab-current" cache=".js-cache" id="<?= $id ?>"><strong><?= $full_name ?></strong></li></button></li>
                 <?php if($tabs['next']) { ?>
                  <li><button class="js-tab js-tab-next" cache=".js-cache-next" id="<?= $tabs['next'] ?>"><strong>Loading...</strong></li></button></li>
                <?php } ?>
                
            </ul>
        </div>
    </div>
    <input type="hidden" class="js-type"  name="<?= $type ?>">
    <input type="hidden" class="js-cache" name="cache" value='<?= $cache ?>'>
    <input type="hidden" class="js-cache-prev" name="cache" value="">
    <input type="hidden" class="js-cache-next" name="cache" value="">
</main>

<?php
    include('views/layouts/footer.view.php');
?>
