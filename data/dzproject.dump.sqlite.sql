INSERT INTO project (
    project_id,
    display_name,
    begin_date,
    end_date
) VALUES (
    1,
    'Projet non débuté',
    strftime('%s', 'now', 'start of day', '-1 hour', '+6 months'),
    strftime('%s', 'now', 'start of day', '-1 hour', '+1 year')
);

INSERT INTO project (
    project_id,
    display_name,
    begin_date,
    end_date
) VALUES (
    2,
    "Projet qui débute aujourd'hui",
    strftime('%s', 'now', 'start of day', '-1 hour'),
    strftime('%s', 'now', 'start of day', '-1 hour', '+2 years')
);

INSERT INTO project (
    project_id,
    display_name,
    begin_date,
    end_date
) VALUES (
    3,
    'Projet actif 1',
    strftime('%s', 'now', 'start of day', '-1 hour', '-1 day'),
    strftime('%s', 'now', 'start of day', '-1 hour', '+3 years')
);

INSERT INTO project (
    project_id,
    display_name,
    begin_date,
    end_date
) VALUES (
    4,
    'Projet actif 2',
    strftime('%s', 'now', 'start of day', '-1 hour', '-1 day'),
    strftime('%s', 'now', 'start of day', '-1 hour', '+3 years')
);

INSERT INTO project (
    project_id,
    display_name,
    begin_date,
    end_date
) VALUES (
    5,
    "Projet qui se termine aujourd'hui",
    strftime('%s', 'now', 'start of day', '-1 hour', '-1 day'),
    strftime('%s', 'now', 'start of day', '-1 hour')
);

INSERT INTO project (
    project_id,
    display_name,
    begin_date,
    end_date
) VALUES (
    6,
    'Projet terminé',
    strftime('%s', 'now', 'start of day', '-1 hour', '-2 days'),
    strftime('%s', 'now', 'start of day', '-1 hour', '-1 day')
);

INSERT INTO project (
    project_id,
    display_name,
    begin_date,
    end_date
) VALUES (
    7,
    'Project actif 1 de Jean Michel',
    strftime('%s', 'now', 'start of day', '-1 hour', '-1 day'),
    strftime('%s', 'now', 'start of day', '-1 hour', '+3 years')
);
