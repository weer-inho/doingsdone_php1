<div class="content">
    <section class="content__side">
        <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

        <a class="button button--transparent content__side-button" href="/auth.php">Войти</a>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Регистрация аккаунта</h2>

        <form class="form" action="" method="post" autocomplete="off">
            <? $classname = isset($errors['email']) ? 'form__input--error' : ''; ?>
            <div class="form__row">
                <label class="form__label" for="email">E-mail <sup>*</sup></label>
                <input class="form__input <?= $classname; ?>" type="text" name="email" id="email"
                       value="<?= $user['email'] ?? ''; ?>"
                       placeholder="Введите e-mail">
                <? if (isset($errors['email'])): ?>
                    <p class="form__message"><?= $errors['email'] ?? ''; ?></p>
                <? endif; ?>
            </div>

            <? $classname = isset($errors['password']) ? 'form__input--error' : ''; ?>
            <div class="form__row">
                <label class="form__label" for="password">Пароль <sup>*</sup></label>
                <input class="form__input <?= $classname; ?>" type="password" name="password" id="password"
                       value="<?= $user['password'] ?? ''; ?>"
                       placeholder="Введите пароль">
            </div>

            <? $classname = isset($errors['user_name']) ? 'form__input--error' : ''; ?>
            <div class="form__row">
                <label class="form__label" for="name">Имя <sup>*</sup></label>
                <input class="form__input <?= $classname; ?>" type="text" name="user_name" id="name"
                       value="<?= $user['user_name'] ?? ''; ?>" placeholder="Введите имя">
            </div>

            <div class="form__row form__row--controls">
                <? if (isset($errors)): ?>
                    <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
                <? endif; ?>
                <input class="button" type="submit" value="Зарегистрироваться">
            </div>
        </form>
    </main>
</div>
