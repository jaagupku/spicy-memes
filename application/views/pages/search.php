<?php
$title = lang('title_search');
$selection = 'search';

include('header.php');
?>

<div class="container-fluid"><div class="break"></div></div>
<div class="container-fluid"><div class="break"></div></div>

<?php if (isset($error)): ?>
    <div class="container-fluid">
        <div class="col-xs-6 col-centered">
            <?= lang('search_invalid') ?>
        </div>
    </div>
<?php elseif (count($memes) == 0): ?>
    <div class="container-fluid">
        <div class="col-xs-6 col-centered">
            <?= lang('search_nomatches') ?>
        </div>
    </div>
<?php else: ?>
    <div class="container-fluid">
        <div class="col-xs-6 col-centered">
            <div class="sortingsection-userpage">
                <p><strong><?= lang('search_sortby') ?>: </strong></p>
                <a class="sort" href="<?= site_url(strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query(array_merge($_GET, array('sort' => 'top')))) ?>"><span class="label label-default"><?= lang('search_sortby_top') ?></span></a>
                <a class="sort" href="<?= site_url(strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query(array_merge($_GET, array('sort' => 'comments'))))?>"><span class="label label-default"><?= lang('search_sortby_comments') ?></span></a>
                <a class="sort" href="<?= site_url(strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query(array_merge($_GET, array('sort' => 'date')))) ?>"><span class="label label-default"><?= lang('search_sortby_date') ?></span></a>
            </div>
        </div>
    </div>

    <?php foreach ($memes as $meme): ?>
        <div class="container-fluid"><div class="break"></div></div>

        <div class="container-fluid">
            <div class="col-xs-6 col-centered">
                <div class="search-row ">

                    <div class="search-thumbnail">
                        <a href="<?= site_url('/meme/' . $meme['Id']) ?>">
                            <?php if ($meme['Data_Type'] == 'P'): ?>
                                <img class="search-image" alt="<?= $meme['Title'] ?>" src="<?= "https://res.cloudinary.com/spicy-memes/image/upload/t_meme/{$meme['Data']}" ?>"/>
                            <?php else: ?>
                                <img class="search-image" alt="<?= $meme['Title'] ?>" src="<?= "https://i.ytimg.com/vi/{$meme['Data']}/default.jpg" ?>"/>
                            <?php endif ?>
                        </a>
                    </div>

                    <div class="search-memeinfo">
                        <a class="search-title"
                           href="<?= site_url('/meme/' . $meme['Id']) ?>"><?= $meme['Title'] ?></a>
                        <div class="search-data">
                            <div><?= lang('search_addedby') ?>: <a href="<?= site_url('/profile/' . $meme['User_Name']) ?>"><?= $meme['User_Name'] ?></a></div>
                            <div><?= lang('search_spicelevel') ?>: <span class="badge"><?= $meme['Points'] ?></span></div>
                            <div><?= lang('search_comments') ?>: <a href="<?= site_url('/meme/' . $meme['Id'] . '#comments') ?>"<span class="badge"><?= $meme['comments'] ?></span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>

<?php
include('footer.php');
?>
