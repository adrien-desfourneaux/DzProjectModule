/* Replace this file with actual dump of your database */

CREATE TABLE project
(
    project_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    display_name VARCHAR(50) NOT NULL UNIQUE,
    begin_date INTEGER NOT NULL,
    end_date INTEGER NOT NULL
);
