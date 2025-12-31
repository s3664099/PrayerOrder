<?php
/*
File: PrayerOrder prayer item template
Author: David Sarkies 
#Initial: 31 December 2025
#Update: 31 December 2025
#Version: 1.0
*/
?>
<pre class="prayer">
    <h4 class="user-header">
        <img
            id="avatar"
            alt="user_image"
            width="15"
            src="<?= htmlspecialchars($view['avatar'], ENT_QUOTES, 'UTF-8') ?>"
        >
        <?= htmlspecialchars($view['user_name'], ENT_QUOTES, 'UTF-8') ?>
    </h4>
    <div class="user-header">
        <?= htmlspecialchars($view['post_date'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <div class="user-header">
        <?= htmlspecialchars($view['prayer'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <br>
</pre>

<div class="prayer-like">
    <button
        class="praybtn<?= $view['user_reaction'] == 1 ? ' selected' : '' ?>"
        id="pray<?= htmlspecialchars($view['prayer_key'], ENT_QUOTES, 'UTF-8') ?>"
        onclick="react(this)"
    >
        <img src="/Images/icon/pray.png" width="20">
    </button>
    <span id="pry<?= htmlspecialchars($view['prayer_key'], ENT_QUOTES, 'UTF-8') ?>">
        <?= $view['prayer_count'] > 0 ? (int)$view['prayer_count'] : '' ?>
    </span>
    <button
        class="praybtn<?= $view['user_reaction'] == 2 ? ' selected' : '' ?>"
        id="praise<?= htmlspecialchars($view['prayer_key'], ENT_QUOTES, 'UTF-8') ?>"
        onclick="react(this)"
    >
        <img src="/Images/icon/praise.png" width="20">
    </button>
    <span id="prs<?= htmlspecialchars($view['prayer_key'], ENT_QUOTES, 'UTF-8') ?>">
        <?= $view['praise_count'] > 0 ? (int)$view['praise_count'] : '' ?>
    </span>
</div>

<?php
/* 31 December 2025 - Created File
*/
?>