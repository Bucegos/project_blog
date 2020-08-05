<form class="form" action="/auth/login" method="POST">
    <input class="form__input" type="text" name="username" placeholder="username" aria-label="username" autofocus required>
    <input class="form__input" type="password" name="password" placeholder="password" aria-label="password" required>
    <p class="error"></p>
    <div class="login__buttons">
        <button class="button" type="submit">Login</button>
        <button class="button button--secondary" onclick="location.href='/auth/register'" type="button">
            Sign up
        </button>
    </div>
</form>
