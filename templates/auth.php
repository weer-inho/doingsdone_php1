<div class="content">

    <section class="content__side">
        <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

        <a class="button button--transparent content__side-button" href="/auth.php">Войти</a>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Вход на сайт</h2>

        <form class="form" action="" method="post" autocomplete="off">
            <? $classname = isset($errors['email']) ? 'form__input--error' : ''; ?>
            <div class="form__row">
                <label class="form__label" for="email">E-mail <sup>*</sup></label>
                <input
                    class="form__input <?= $classname; ?>"
                    type="text"
                    name="email"
                    id="email"
                    value="<?= $user['email'] ?? ''; ?>"
                    placeholder="Введите e-mail"
                >
                <p class="form__message"><?= $errors['email'] ?? ''; ?></p>
            </div>

            <div class="form__row">
                <? $classname = isset($errors['password']) ? 'form__input--error' : ''; ?>
                <label class="form__label" for="password">Пароль <sup>*</sup></label>
                <input
                    class="form__input <?= $classname; ?>"
                    type="password"
                    name="password"
                    id="password"
                    value="<?= $user['password'] ?? ''; ?>"
                    placeholder="Введите пароль"
                >
            </div>

            <div class="form__row form__row--controls">
                <input class="button" type="submit" name="" value="Войти">
            </div>
        </form>

    </main>

</div>
