create table authors
(
    uuid varchar(36) not null
        primary key,
    name text(255)   not null
);

create table books
(
    uuid        varchar(36) not null
        primary key,
    title       text(255)   not null,
    description text(255)   not null,
    cover       text(255)   not null
);

create table book_authors
(
    id          integer     not null
        primary key,
    book_uuid   varchar(36) not null
        references books
            on update cascade on delete cascade,
    author_uuid varchar(36) not null
        references authors
            on update cascade on delete cascade
);

create index book_authors_index_author_uuid_65debafb45057
    on book_authors (author_uuid);

create index book_authors_index_book_uuid_65debafb45051
    on book_authors (book_uuid);

create unique index book_authors_index_book_uuid_author_uuid_65debafb4504b
    on book_authors (book_uuid, author_uuid);

create table genres
(
    id           integer   not null
        primary key,
    abbreviation text(255) not null,
    description  text(255) not null
);

create table book_genres
(
    id        integer     not null
        primary key,
    book_uuid varchar(36) not null
        references books
            on update cascade on delete cascade,
    genre_id  integer     not null
        references genres
            on update cascade on delete cascade
);

create index book_genres_index_book_uuid_65debafb45023
    on book_genres (book_uuid);

create unique index book_genres_index_book_uuid_genre_id_65debafb4501c
    on book_genres (book_uuid, genre_id);

create index book_genres_index_genre_id_65debafb4502a
    on book_genres (genre_id);

create unique index genres_index_abbreviation_65debafb450bc
    on genres (abbreviation);

create table migrations
(
    id            integer   not null
        primary key,
    migration     text(191) not null,
    time_executed datetime,
    created_at    datetime
);

create unique index migrations_index_migration_created_at_65dde0e400c6d
    on migrations (migration, created_at);

create table tags
(
    id    integer   not null
        primary key,
    value text(255) not null
);

create table book_tags
(
    id        integer     not null
        primary key,
    book_uuid varchar(36) not null
        references books
            on update cascade on delete cascade,
    tag_id    integer     not null
        references tags
            on update cascade on delete cascade
);

create index book_tags_index_book_uuid_65debafb44fec
    on book_tags (book_uuid);

create unique index book_tags_index_book_uuid_tag_id_65debafb44f31
    on book_tags (book_uuid, tag_id);

create index book_tags_index_tag_id_65debafb44ff8
    on book_tags (tag_id);

create unique index tags_index_value_65debafb450ae
    on tags (value);

INSERT INTO genres (id, abbreviation, description) VALUES (1, 'sf_history', 'Alternative history');
INSERT INTO genres (id, abbreviation, description) VALUES (2, 'sf_action', 'Action');
INSERT INTO genres (id, abbreviation, description) VALUES (3, 'sf_epic', 'Epic');
INSERT INTO genres (id, abbreviation, description) VALUES (4, 'sf_heroic', 'Heroic');
INSERT INTO genres (id, abbreviation, description) VALUES (5, 'sf_detective', 'Detective');
INSERT INTO genres (id, abbreviation, description) VALUES (6, 'sf_cyberpunk', 'Cyberpunk');
INSERT INTO genres (id, abbreviation, description) VALUES (7, 'sf_space', 'Space');
INSERT INTO genres (id, abbreviation, description) VALUES (8, 'sf_social', 'Social-philosophical');
INSERT INTO genres (id, abbreviation, description) VALUES (9, 'sf_horror', 'Horror & mystic');
INSERT INTO genres (id, abbreviation, description) VALUES (10, 'sf_humor', 'Humor');
INSERT INTO genres (id, abbreviation, description) VALUES (11, 'sf_fantasy', 'Fantasy');
INSERT INTO genres (id, abbreviation, description) VALUES (12, 'sf', 'Science Fiction');
INSERT INTO genres (id, abbreviation, description) VALUES (13, 'det_classic', 'Classical detectives');
INSERT INTO genres (id, abbreviation, description) VALUES (14, 'det_police', 'Police Stories');
INSERT INTO genres (id, abbreviation, description) VALUES (15, 'det_action', 'Action');
INSERT INTO genres (id, abbreviation, description) VALUES (16, 'det_irony', 'Ironical detectives');
INSERT INTO genres (id, abbreviation, description) VALUES (17, 'det_history', 'Historical detectives');
INSERT INTO genres (id, abbreviation, description) VALUES (18, 'det_espionage', 'Espionage detectives');
INSERT INTO genres (id, abbreviation, description) VALUES (19, 'det_crime', 'Crime detectives');
INSERT INTO genres (id, abbreviation, description) VALUES (20, 'det_political', 'Political detectives');
INSERT INTO genres (id, abbreviation, description) VALUES (21, 'det_maniac', 'Maniacs');
INSERT INTO genres (id, abbreviation, description) VALUES (22, 'det_hard', 'Hard-boiled');
INSERT INTO genres (id, abbreviation, description) VALUES (23, 'thriller', 'Thrillers');
INSERT INTO genres (id, abbreviation, description) VALUES (24, 'detective', 'Detectives');
INSERT INTO genres (id, abbreviation, description) VALUES (25, 'prose_classic', 'Classics prose');
INSERT INTO genres (id, abbreviation, description) VALUES (26, 'prose_history', 'Historical prose');
INSERT INTO genres (id, abbreviation, description) VALUES (27, 'prose_contemporary', 'Contemporary prose');
INSERT INTO genres (id, abbreviation, description) VALUES (28, 'prose_counter', 'Counterculture');
INSERT INTO genres (id, abbreviation, description) VALUES (29, 'prose_rus_classic', 'Russial classics prose');
INSERT INTO genres (id, abbreviation, description) VALUES (30, 'prose_su_classics', 'Soviet classics prose');
INSERT INTO genres (id, abbreviation, description) VALUES (31, 'love_contemporary', 'Contemporary Romance');
INSERT INTO genres (id, abbreviation, description) VALUES (32, 'love_history', 'Historical Romance');
INSERT INTO genres (id, abbreviation, description) VALUES (33, 'love_detective', 'Detective Romance');
INSERT INTO genres (id, abbreviation, description) VALUES (34, 'love_short', 'Short Romance');
INSERT INTO genres (id, abbreviation, description) VALUES (35, 'love_erotica', 'Erotica');
INSERT INTO genres (id, abbreviation, description) VALUES (36, 'adv_western', 'Western');
INSERT INTO genres (id, abbreviation, description) VALUES (37, 'adv_history', 'History');
INSERT INTO genres (id, abbreviation, description) VALUES (38, 'adv_indian', 'Indians');
INSERT INTO genres (id, abbreviation, description) VALUES (39, 'adv_maritime', 'Maritime Fiction');
INSERT INTO genres (id, abbreviation, description) VALUES (40, 'adv_geo', 'Travel & geography');
INSERT INTO genres (id, abbreviation, description) VALUES (41, 'adv_animal', 'Nature & animals');
INSERT INTO genres (id, abbreviation, description) VALUES (42, 'adventure', 'Other');
INSERT INTO genres (id, abbreviation, description) VALUES (43, 'child_tale', 'Fairy Tales');
INSERT INTO genres (id, abbreviation, description) VALUES (44, 'child_verse', 'Verses');
INSERT INTO genres (id, abbreviation, description) VALUES (45, 'child_prose', 'Prose');
INSERT INTO genres (id, abbreviation, description) VALUES (46, 'child_sf', 'Science Fiction');
INSERT INTO genres (id, abbreviation, description) VALUES (47, 'child_det', 'Detectives & Thrillers');
INSERT INTO genres (id, abbreviation, description) VALUES (48, 'child_adv', 'Adventures');
INSERT INTO genres (id, abbreviation, description) VALUES (49, 'child_education', 'Educational');
INSERT INTO genres (id, abbreviation, description) VALUES (50, 'children', 'Other');
INSERT INTO genres (id, abbreviation, description) VALUES (51, 'poetry', 'Poetry');
INSERT INTO genres (id, abbreviation, description) VALUES (52, 'dramaturgy', 'Dramaturgy');
INSERT INTO genres (id, abbreviation, description) VALUES (53, 'antique_ant', 'Antique');
INSERT INTO genres (id, abbreviation, description) VALUES (54, 'antique_european', 'European');
INSERT INTO genres (id, abbreviation, description) VALUES (55, 'antique_russian', 'Old russian');
INSERT INTO genres (id, abbreviation, description) VALUES (56, 'antique_east', 'Old east');
INSERT INTO genres (id, abbreviation, description) VALUES (57, 'antique_myths', 'Myths. Legends. Epos');
INSERT INTO genres (id, abbreviation, description) VALUES (58, 'antique', 'Other');
INSERT INTO genres (id, abbreviation, description) VALUES (59, 'sci_history', 'History');
INSERT INTO genres (id, abbreviation, description) VALUES (60, 'sci_psychology', 'Psychology');
INSERT INTO genres (id, abbreviation, description) VALUES (61, 'sci_culture', 'Cultural science');
INSERT INTO genres (id, abbreviation, description) VALUES (62, 'sci_religion', 'Religious studies');
INSERT INTO genres (id, abbreviation, description) VALUES (63, 'sci_philosophy', 'Philosophy');
INSERT INTO genres (id, abbreviation, description) VALUES (64, 'sci_politics', 'Politics');
INSERT INTO genres (id, abbreviation, description) VALUES (65, 'sci_business', 'Business literature');
INSERT INTO genres (id, abbreviation, description) VALUES (66, 'sci_juris', 'Jurisprudence');
INSERT INTO genres (id, abbreviation, description) VALUES (67, 'sci_linguistic', 'Linguistics');
INSERT INTO genres (id, abbreviation, description) VALUES (68, 'sci_medicine', 'Medicine');
INSERT INTO genres (id, abbreviation, description) VALUES (69, 'sci_phys', 'Physics');
INSERT INTO genres (id, abbreviation, description) VALUES (70, 'sci_math', 'Mathematics');
INSERT INTO genres (id, abbreviation, description) VALUES (71, 'sci_chem', 'Chemistry');
INSERT INTO genres (id, abbreviation, description) VALUES (72, 'sci_biology', 'Biology');
INSERT INTO genres (id, abbreviation, description) VALUES (73, 'sci_tech', 'Technical');
INSERT INTO genres (id, abbreviation, description) VALUES (74, 'science', 'Other');
INSERT INTO genres (id, abbreviation, description) VALUES (75, 'comp_www', 'Internet');
INSERT INTO genres (id, abbreviation, description) VALUES (76, 'comp_programming', 'Programming');
INSERT INTO genres (id, abbreviation, description) VALUES (77, 'comp_hard', 'Hardware');
INSERT INTO genres (id, abbreviation, description) VALUES (78, 'comp_soft', 'Software');
INSERT INTO genres (id, abbreviation, description) VALUES (79, 'comp_db', 'Databases');
INSERT INTO genres (id, abbreviation, description) VALUES (80, 'comp_osnet', 'OS & Networking');
INSERT INTO genres (id, abbreviation, description) VALUES (81, 'computers', 'Other');
INSERT INTO genres (id, abbreviation, description) VALUES (82, 'ref_encyc', 'Encyclopedias');
INSERT INTO genres (id, abbreviation, description) VALUES (83, 'ref_dict', 'Dictionaries');
INSERT INTO genres (id, abbreviation, description) VALUES (84, 'ref_ref', 'Reference');
INSERT INTO genres (id, abbreviation, description) VALUES (85, 'ref_guide', 'Guidebooks');
INSERT INTO genres (id, abbreviation, description) VALUES (86, 'reference', 'Other');
INSERT INTO genres (id, abbreviation, description) VALUES (87, 'nonf_biography', 'Biography & Memoirs');
INSERT INTO genres (id, abbreviation, description) VALUES (88, 'nonf_publicism', 'Publicism');
INSERT INTO genres (id, abbreviation, description) VALUES (89, 'nonf_criticism', 'Criticism');
INSERT INTO genres (id, abbreviation, description) VALUES (90, 'design', 'Art & design');
INSERT INTO genres (id, abbreviation, description) VALUES (91, 'nonfiction', 'Other');
INSERT INTO genres (id, abbreviation, description) VALUES (92, 'religion_rel', 'Religion');
INSERT INTO genres (id, abbreviation, description) VALUES (93, 'religion_esoterics', 'Esoterics');
INSERT INTO genres (id, abbreviation, description) VALUES (94, 'religion_self', 'Self-improvement');
INSERT INTO genres (id, abbreviation, description) VALUES (95, 'Other', 'Other');
INSERT INTO genres (id, abbreviation, description) VALUES (96, 'humor_anecdote', 'Anecdote (funny stories)');
INSERT INTO genres (id, abbreviation, description) VALUES (97, 'humor_prose', 'Prose');
INSERT INTO genres (id, abbreviation, description) VALUES (98, 'humor_verse', 'Verses');
INSERT INTO genres (id, abbreviation, description) VALUES (99, 'humor', 'Other');
INSERT INTO genres (id, abbreviation, description) VALUES (100, 'home_cooking', 'Cooking');
INSERT INTO genres (id, abbreviation, description) VALUES (101, 'home_pets', 'Pets');
INSERT INTO genres (id, abbreviation, description) VALUES (102, 'home_crafts', 'Hobbies & Crafts');
INSERT INTO genres (id, abbreviation, description) VALUES (103, 'home_entertain', 'Entertaining');
INSERT INTO genres (id, abbreviation, description) VALUES (104, 'home_health', 'Health');
INSERT INTO genres (id, abbreviation, description) VALUES (105, 'home_garden', 'Garden');
INSERT INTO genres (id, abbreviation, description) VALUES (106, 'home_diy', 'Do it yourself');
INSERT INTO genres (id, abbreviation, description) VALUES (107, 'home_sport', 'Sports');
INSERT INTO genres (id, abbreviation, description) VALUES (108, 'home_sex', 'Erotica & sex');
INSERT INTO genres (id, abbreviation, description) VALUES (109, 'home', 'Other');
