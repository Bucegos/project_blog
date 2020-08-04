<?php

use App\Helper\Elements;
use App\Model\Role;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?></title>
    <link type="text/css" rel="stylesheet" href="<?= HOST; ?>../assets/css/main.css" />
    <link rel="icon" type="image/x-icon" href="<?= HOST; ?>../assets/images/logo.svg">
</head>
<body>
<nav class="navigation">
    <a class="logo" href="/">
        <img class="logo__img" src="<?= HOST . 'assets/images/logo.svg'; ?>" alt="Logo" />
        <p>Blog</p>
    </a>
<!--    ADD SEARCH!! -->
<!--    <form class="d-flex mb-0">-->
<!--        <input class="form-control mr-2" type="search" placeholder="Search" aria-label="Search">-->
<!--        <button class="btn btn-success" type="submit">Search</button>-->
<!--    </form>-->
    <ul class="navigation__menu">
        <li class="navigation__item">
            <button class="button button--gradient" onclick="location.href='/posts/write'" type="button">
                Write a post
            </button>
        </li>
        <li class="navigation__item">
            <div class="dropdown">
                <?php if (isset($data['user'])) : ?>
                <div class="navigation__user">
                    <button class="dropdown__toggler profile-image" role="button">
                        <img src="<?= HOST . "assets/uploads/{$data['user']['image']}"; ?>" alt="profile" />
                    </button>
                    <ul class="navigation__user__content dropdown__content">
                        <li class="dropdown__item"><a href="/account/reading-list">Reading list[0]</a></li>
                        <li class="dropdown__item"><a href="/account/dashboard">Dashboard</a></li>
                        <li class="dropdown__item"><a href="/account/drafts">Drafs[0]</a></li>
                        <li class="dropdown__item"><a href="/account/settings">Account Settings</a></li>
                        <?php if ($data['user']['role'] === Role::ADMIN) : ?>
                        <li class="dropdown__item navigation__user__admin"><a href="/admin">Admin</a></li>
                        <?php endif; ?>
                        <li class="navigation__user__logout">
                            <button class="button button--secondary" onclick="location.href='/auth/logout'" type="button">
                                Logout
                            </button>
                        </li>
                    </ul>
                </div>
                <?php else : ?>
                <div class="navigation__login">
                    <button class="button dropdown__toggler" role="button">
                        Login
                    </button>
                    <div class="navigation__login__content dropdown__content">
                        <?php Elements::element('login'); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </li>
    </ul>
</nav>
<main id="main-content">