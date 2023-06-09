<div class="content">
    <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
            <ul class="main-navigation__list">
                <?php foreach ($projects as $project): ?>
                    <li class="main-navigation__list-item">
                        <a
                                class="main-navigation__list-item-link <?php if ($project['id'] === $project_id): ?> main-navigation__list-item--active<?php endif; ?>"
                                href=" /?project_id=<?= $project['id'] ?>">
                            <?= htmlspecialchars($project['title']) ?>
                        </a>
                        <span class="main-navigation__list-item-count"><?= count_tasks($tasks, $project['id']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <a class="button button--transparent button--plus content__side-button"
           href="/addproject.php" target="project_add">Добавить проект</a>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form"  action="" method="post" enctype="multipart/form-data">
            <div class="form__row">
                <?php $classname = isset($errors['title']) ? "form__input--error" : ""; ?>
                <label class="form__label" for="name">Название <sup>*</sup></label>
                <input
                    class="form__input <?= $classname; ?>"
                    type="text"
                    name="title"
                    id="name"
                    value="<?= isset($task['title']) ? htmlspecialchars($task['title']) : ''; ?>"
                    placeholder="Введите название"
                >
                <p class="form__message"><?= $errors['title'] ?? ''; ?></p>
            </div>

            <div class="form__row">
                <?php $classname = isset($errors['project_id']) ? "form__input--error" : ""; ?>
                <label class="form__label" for="project">Проект <sup>*</sup></label>
                <select
                    class="form__input form__input--select <?= $classname; ?>"
                    name="project_id"
                    id="project"
                >
                    <?php foreach ($projects as $project): ?>
                        <option value="<?= $project['id'] ?>" checked="<?= isset($task['project_id']) && $project['id'] === $task['project_id']; ?>">
                            <?= htmlspecialchars($project['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="form__message"><?= $errors['project_id'] ?? ''; ?></p>
            </div>

            <div class="form__row">
                <?php $classname = isset($errors['end_date']) ? "form__input--error" : ""; ?>
                <label class="form__label" for="date">Дата выполнения</label>
                <input
                    class="form__input form__input--date <?= $classname; ?>"
                    type="text"
                    name="end_date"
                    id="date"
                    value="<?= isset($task['end_date']) ? htmlspecialchars($task['end_date']) : ''; ?>"
                    placeholder="Введите дату в формате ГГГГ-ММ-ДД"
                >
                <p class="form__message"><?= $errors['end_date'] ?? ''; ?></p>
            </div>

            <div class="form__row">
                <label class="form__label" for="file">Файл</label>

                <div class="form__input-file">
                    <input class="visually-hidden" type="file" name="file" id="file" value="">

                    <label class="button button--transparent" for="file">
                        <span>Выберите файл</span>
                    </label>
                </div>
            </div>

            <div class="form__row form__row--controls">
                <input class="button" type="submit" name="" value="Добавить">
            </div>
        </form>
    </main>
</div>