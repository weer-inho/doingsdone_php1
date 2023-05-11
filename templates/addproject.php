<div class="content">
    <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
            <ul class="main-navigation__list">
                <? foreach ($projects as $project): ?>
                    <li class="main-navigation__list-item">
                        <a
                            class="main-navigation__list-item-link <? if ($project['id'] === $project_id): ?> main-navigation__list-item--active<? endif; ?>"
                            href="?project_id=<?= $project['id'] ?>">
                            <?= $project['title'] ?>
                        </a>
                        <span class="main-navigation__list-item-count"><?= count_tasks($tasks, $project['id']); ?></span>
                    </li>
                <? endforeach; ?>
            </ul>
        </nav>

        <a class="button button--transparent button--plus content__side-button" href="/">Добавить проект</a>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Добавление проекта</h2>

        <form class="form"  action="" method="post" autocomplete="off">
            <? $classname = isset($error) ? 'form__input--error' : ''; ?>
            <div class="form__row">
                <label class="form__label" for="project_name">Название <sup>*</sup></label>

                <input
                    class="form__input <?= $classname; ?>"
                    type="text"
                    name="name"
                    id="project_name"
                    value="<?= $project_name ?? ''; ?>"
                    placeholder="<?= $error ?? 'Введите название проекта'; ?>"
                >
            </div>

            <div class="form__row form__row--controls">
                <input class="button" type="submit" value="Добавить">
            </div>
        </form>
    </main>
</div>