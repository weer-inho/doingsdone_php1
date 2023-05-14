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

        <a class="button button--transparent button--plus content__side-button"
           href="/addproject.php" target="project_add">Добавить проект</a>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Список задач</h2>

        <form class="search-form" action="" method="get" autocomplete="off">
            <input class="search-form__input" type="text" name="search" value="<?= $search ?? ''; ?>" placeholder="Поиск по задачам">

            <input class="search-form__submit" type="submit" name="" value="Искать">
        </form>

        <div class="tasks-controls">
            <nav class="tasks-switch">
                <a href="/?filter=all" class="tasks-switch__item <? if ($filter === 'all'): ?> tasks-switch__item--active <? endif; ?>">Все задачи</a>
                <a href="/?filter=today" class="tasks-switch__item <? if ($filter === 'today'): ?> tasks-switch__item--active <? endif; ?>">Повестка дня</a>
                <a href="/?filter=tomorrow" class="tasks-switch__item <? if ($filter === 'tomorrow'): ?> tasks-switch__item--active <? endif; ?>">Завтра</a>
                <a href="/?filter=expired" class="tasks-switch__item <? if ($filter === 'expired'): ?> tasks-switch__item--active <? endif; ?>">Просроченные</a>
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
                if (!$show_complete_tasks && $task["status"] === '1') {
                    continue; // условие на фильтрацию задач по выполненным и нет
                }
                if (isset($project_id) && $task["project_id"] != $project_id) {
                    continue; // условие на фильтрацию задач по проектам
                }
            ?>
                <tr class="tasks__item task
                    <?= $task["status"] ? 'task--completed' : '' ?>
                    <?= check_exp_date($task["end_date"]) > 0 ? '' : 'task--important' ?>
                ">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input
                                class="checkbox__input visually-hidden task__checkbox"
                                type="checkbox"
                                value="<?= $task["id"] ?>"
                                <?= $task["status"] === '1' ? 'checked' : '' ?>
                            >
                            <span class="checkbox__text"><?= $task["title"] ?></span>
                        </label>
                    </td>
                    <td class="task__file">
                        <a class="download-link" href="<?= isset($task["file_url"]) ? $task["file_url"] : ''; ?>"></a>
                    </td>

                    <td class="task__date"><?= $task["end_date"] ?></td>
                </tr>
            <? endforeach; ?>
        </table>
    </main>
</div>