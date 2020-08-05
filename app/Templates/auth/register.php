<section class="register container">
    <div class="register__message">
        <img src="<?= ASSETS_IMG . 'logo.svg'; ?>" alt="logo" />
        <div>
            <h1>Welcome to "BLOG"</h1>
            <p>Please register your account to have access to awesome content!😎</p>
        </div>
    </div>
    <form class="register__form form" action="/auth/register" method="POST">
        <input class="form__input" type="text" name="username" placeholder="username" aria-label="username" required>
        <input class="form__input" type="email" name="email" placeholder="email" aria-label="email" required>
    <!--    ADD CHECKING FOR PASSWORD 2! , repeat/confirm password whatever-->
    <!--    <input class="form-control dropdown-item mb-2" type="password" name="password" placeholder="password" aria-label="password">-->
        <input class="form__input" type="password" name="password" placeholder="password" aria-label="password" required>
        <p class="error"></p>
        <button class="button" type="submit">Register</button>
    </form>
</section>