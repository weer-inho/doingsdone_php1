<div class="content">
    <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
            <ul class="main-navigation__list">
                <? foreach ($categories as $category): ?>
                    <li class="main-navigation__list-item">
                        <a class="main-navigation__list-item-link" href="#"><?= $category ?></a>
                        <span class="main-navigation__list-item-count"><?= count_tasks($tasks, $category); ?></span>
                    </li>
                <? endforeach; ?>
            </ul>
        </nav>

        <a class="button button--transparent button--plus content__side-button"
           href="pages/form-project.html" target="project_add">Добавить проект</a>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Список задач</h2>

        <form class="search-form" action="index.php" method="post" autocomplete="off">
            <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

            <input class="search-form__submit" type="submit" name="" value="Искать">
        </form>

        <div class="tasks-controls">
            <nav class="tasks-switch">
                <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                <a href="/" class="tasks-switch__item">Повестка дня</a>
                <a href="/" class="tasks-switch__item">Завтра</a>
                <a href="/" class="tasks-switch__item">Просроченные</a>
            </nav>

            <label class="checkbox">
                <input
                    class="checkbox__input visually-hidden show_completed"
                    type="checkbox"
                    <?= $show_complete_tasks ? 'checked' : '' ?>
                >
                <span class="checkbox__text">Показывать выполненные</span>
            </label>
        </div>

        <table class="tasks">
            <? foreach ($tasks as $task):
                if ($show_complete_tasks && $task["is_done"]) {
                    continue;
                }
                ?>
                <tr class="tasks__item task <?= $task["is_done"] ? 'task--completed' : '' ?>">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                            <span class="checkbox__text"><?= $task["title"] ?></span>
                        </label>
                    </td>

                    <td class="task__file">
                        <a class="download-link" href="#"></a>
                    </td>

                    <td class="task__date"><?= $task["date_of_completion"] ?></td>
                </tr>
            <? endforeach; ?>
        </table>
    </main>
</div>