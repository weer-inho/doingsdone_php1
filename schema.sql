CREATE DATABASE doingsdone;
USE doingsdone;

CREATE TABLE users
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    email         VARCHAR(128) NOT NULL UNIQUE,
    password      CHAR(12),
    user_name     VARCHAR(128),
    register_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    title     VARCHAR(128),
    author_id INT,
    FOREIGN KEY (author_id) REFERENCES users (id)
);

CREATE TABLE tasks
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status        CHAR(1),
    title         VARCHAR(255),
    file_url      VARCHAR(255),
    end_date      DATE,
    author_id     INT,
    project_id    INT,
    FOREIGN KEY (author_id) REFERENCES users (id),
    FOREIGN KEY (project_id) REFERENCES projects (id)
);