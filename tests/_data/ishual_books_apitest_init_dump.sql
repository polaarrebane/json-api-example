create table migrations
(
    id            serial
        primary key,
    migration     varchar(191) not null,
    time_executed timestamp(0),
    created_at    timestamp(0)
);

alter table migrations
    owner to ishual_books;

create unique index migrations_index_migration_created_at_65e6fa57025b9
    on migrations (migration, created_at);

INSERT INTO public.migrations (id, migration, time_executed, created_at) VALUES (1, '0_ishual_books_create_books_create_tags_create_book_authors_create_genres_create_book_genres_create_book_tags_create_authors', '2024-03-05 10:57:02', '2024-03-01 18:40:55');



create table tags
(
    id    serial
        primary key,
    value varchar(255) not null
);

alter table tags
    owner to ishual_books;

create unique index tags_index_value_65e221379458a
    on tags (value);

INSERT INTO public.tags (id, value) VALUES (2, 'gottba');
INSERT INTO public.tags (id, value) VALUES (1, 'martolkienque');



create table genres
(
    id           serial
        primary key,
    abbreviation varchar(255) not null,
    description  varchar(255) not null
);

alter table genres
    owner to ishual_books;

create unique index genres_index_abbreviation_65e22137945bb
    on genres (abbreviation);

INSERT INTO public.genres (id, abbreviation, description) VALUES (1, 'sf_history', 'Alternative history');
INSERT INTO public.genres (id, abbreviation, description) VALUES (2, 'sf_action', 'Action');
INSERT INTO public.genres (id, abbreviation, description) VALUES (3, 'sf_epic', 'Epic');
INSERT INTO public.genres (id, abbreviation, description) VALUES (4, 'sf_heroic', 'Heroic');
INSERT INTO public.genres (id, abbreviation, description) VALUES (5, 'sf_detective', 'Detective');
INSERT INTO public.genres (id, abbreviation, description) VALUES (6, 'sf_cyberpunk', 'Cyberpunk');
INSERT INTO public.genres (id, abbreviation, description) VALUES (7, 'sf_space', 'Space');
INSERT INTO public.genres (id, abbreviation, description) VALUES (8, 'sf_social', 'Social-philosophical');
INSERT INTO public.genres (id, abbreviation, description) VALUES (9, 'sf_horror', 'Horror & mystic');
INSERT INTO public.genres (id, abbreviation, description) VALUES (10, 'sf_humor', 'Humor');
INSERT INTO public.genres (id, abbreviation, description) VALUES (11, 'sf_fantasy', 'Fantasy');
INSERT INTO public.genres (id, abbreviation, description) VALUES (12, 'sf', 'Science Fiction');
INSERT INTO public.genres (id, abbreviation, description) VALUES (13, 'det_classic', 'Classical detectives');
INSERT INTO public.genres (id, abbreviation, description) VALUES (14, 'det_police', 'Police Stories');
INSERT INTO public.genres (id, abbreviation, description) VALUES (15, 'det_action', 'Action');
INSERT INTO public.genres (id, abbreviation, description) VALUES (16, 'det_irony', 'Ironical detectives');
INSERT INTO public.genres (id, abbreviation, description) VALUES (17, 'det_history', 'Historical detectives');
INSERT INTO public.genres (id, abbreviation, description) VALUES (18, 'det_espionage', 'Espionage detectives');
INSERT INTO public.genres (id, abbreviation, description) VALUES (19, 'det_crime', 'Crime detectives');
INSERT INTO public.genres (id, abbreviation, description) VALUES (20, 'det_political', 'Political detectives');
INSERT INTO public.genres (id, abbreviation, description) VALUES (21, 'det_maniac', 'Maniacs');
INSERT INTO public.genres (id, abbreviation, description) VALUES (22, 'det_hard', 'Hard-boiled');
INSERT INTO public.genres (id, abbreviation, description) VALUES (23, 'thriller', 'Thrillers');
INSERT INTO public.genres (id, abbreviation, description) VALUES (24, 'detective', 'Detectives');
INSERT INTO public.genres (id, abbreviation, description) VALUES (25, 'prose_classic', 'Classics prose');
INSERT INTO public.genres (id, abbreviation, description) VALUES (26, 'prose_history', 'Historical prose');
INSERT INTO public.genres (id, abbreviation, description) VALUES (27, 'prose_contemporary', 'Contemporary prose');
INSERT INTO public.genres (id, abbreviation, description) VALUES (28, 'prose_counter', 'Counterculture');
INSERT INTO public.genres (id, abbreviation, description) VALUES (29, 'prose_rus_classic', 'Russial classics prose');
INSERT INTO public.genres (id, abbreviation, description) VALUES (30, 'prose_su_classics', 'Soviet classics prose');
INSERT INTO public.genres (id, abbreviation, description) VALUES (31, 'love_contemporary', 'Contemporary Romance');
INSERT INTO public.genres (id, abbreviation, description) VALUES (32, 'love_history', 'Historical Romance');
INSERT INTO public.genres (id, abbreviation, description) VALUES (33, 'love_detective', 'Detective Romance');
INSERT INTO public.genres (id, abbreviation, description) VALUES (34, 'love_short', 'Short Romance');
INSERT INTO public.genres (id, abbreviation, description) VALUES (35, 'love_erotica', 'Erotica');
INSERT INTO public.genres (id, abbreviation, description) VALUES (36, 'adv_western', 'Western');
INSERT INTO public.genres (id, abbreviation, description) VALUES (37, 'adv_history', 'History');
INSERT INTO public.genres (id, abbreviation, description) VALUES (38, 'adv_indian', 'Indians');
INSERT INTO public.genres (id, abbreviation, description) VALUES (39, 'adv_maritime', 'Maritime Fiction');
INSERT INTO public.genres (id, abbreviation, description) VALUES (40, 'adv_geo', 'Travel & geography');
INSERT INTO public.genres (id, abbreviation, description) VALUES (41, 'adv_animal', 'Nature & animals');
INSERT INTO public.genres (id, abbreviation, description) VALUES (42, 'adventure', 'Other');
INSERT INTO public.genres (id, abbreviation, description) VALUES (43, 'child_tale', 'Fairy Tales');
INSERT INTO public.genres (id, abbreviation, description) VALUES (44, 'child_verse', 'Verses');
INSERT INTO public.genres (id, abbreviation, description) VALUES (45, 'child_prose', 'Prose');
INSERT INTO public.genres (id, abbreviation, description) VALUES (46, 'child_sf', 'Science Fiction');
INSERT INTO public.genres (id, abbreviation, description) VALUES (47, 'child_det', 'Detectives & Thrillers');
INSERT INTO public.genres (id, abbreviation, description) VALUES (48, 'child_adv', 'Adventures');
INSERT INTO public.genres (id, abbreviation, description) VALUES (49, 'child_education', 'Educational');
INSERT INTO public.genres (id, abbreviation, description) VALUES (50, 'children', 'Other');
INSERT INTO public.genres (id, abbreviation, description) VALUES (51, 'poetry', 'Poetry');
INSERT INTO public.genres (id, abbreviation, description) VALUES (52, 'dramaturgy', 'Dramaturgy');
INSERT INTO public.genres (id, abbreviation, description) VALUES (53, 'antique_ant', 'Antique');
INSERT INTO public.genres (id, abbreviation, description) VALUES (54, 'antique_european', 'European');
INSERT INTO public.genres (id, abbreviation, description) VALUES (55, 'antique_russian', 'Old russian');
INSERT INTO public.genres (id, abbreviation, description) VALUES (56, 'antique_east', 'Old east');
INSERT INTO public.genres (id, abbreviation, description) VALUES (57, 'antique_myths', 'Myths. Legends. Epos');
INSERT INTO public.genres (id, abbreviation, description) VALUES (58, 'antique', 'Other');
INSERT INTO public.genres (id, abbreviation, description) VALUES (59, 'sci_history', 'History');
INSERT INTO public.genres (id, abbreviation, description) VALUES (60, 'sci_psychology', 'Psychology');
INSERT INTO public.genres (id, abbreviation, description) VALUES (61, 'sci_culture', 'Cultural science');
INSERT INTO public.genres (id, abbreviation, description) VALUES (62, 'sci_religion', 'Religious studies');
INSERT INTO public.genres (id, abbreviation, description) VALUES (63, 'sci_philosophy', 'Philosophy');
INSERT INTO public.genres (id, abbreviation, description) VALUES (64, 'sci_politics', 'Politics');
INSERT INTO public.genres (id, abbreviation, description) VALUES (65, 'sci_business', 'Business literature');
INSERT INTO public.genres (id, abbreviation, description) VALUES (66, 'sci_juris', 'Jurisprudence');
INSERT INTO public.genres (id, abbreviation, description) VALUES (67, 'sci_linguistic', 'Linguistics');
INSERT INTO public.genres (id, abbreviation, description) VALUES (68, 'sci_medicine', 'Medicine');
INSERT INTO public.genres (id, abbreviation, description) VALUES (69, 'sci_phys', 'Physics');
INSERT INTO public.genres (id, abbreviation, description) VALUES (70, 'sci_math', 'Mathematics');
INSERT INTO public.genres (id, abbreviation, description) VALUES (71, 'sci_chem', 'Chemistry');
INSERT INTO public.genres (id, abbreviation, description) VALUES (72, 'sci_biology', 'Biology');
INSERT INTO public.genres (id, abbreviation, description) VALUES (73, 'sci_tech', 'Technical');
INSERT INTO public.genres (id, abbreviation, description) VALUES (74, 'science', 'Other');
INSERT INTO public.genres (id, abbreviation, description) VALUES (75, 'comp_www', 'Internet');
INSERT INTO public.genres (id, abbreviation, description) VALUES (76, 'comp_programming', 'Programming');
INSERT INTO public.genres (id, abbreviation, description) VALUES (77, 'comp_hard', 'Hardware');
INSERT INTO public.genres (id, abbreviation, description) VALUES (78, 'comp_soft', 'Software');
INSERT INTO public.genres (id, abbreviation, description) VALUES (79, 'comp_db', 'Databases');
INSERT INTO public.genres (id, abbreviation, description) VALUES (80, 'comp_osnet', 'OS & Networking');
INSERT INTO public.genres (id, abbreviation, description) VALUES (81, 'computers', 'Other');
INSERT INTO public.genres (id, abbreviation, description) VALUES (82, 'ref_encyc', 'Encyclopedias');
INSERT INTO public.genres (id, abbreviation, description) VALUES (83, 'ref_dict', 'Dictionaries');
INSERT INTO public.genres (id, abbreviation, description) VALUES (84, 'ref_ref', 'Reference');
INSERT INTO public.genres (id, abbreviation, description) VALUES (85, 'ref_guide', 'Guidebooks');
INSERT INTO public.genres (id, abbreviation, description) VALUES (86, 'reference', 'Other');
INSERT INTO public.genres (id, abbreviation, description) VALUES (87, 'nonf_biography', 'Biography & Memoirs');
INSERT INTO public.genres (id, abbreviation, description) VALUES (88, 'nonf_publicism', 'Publicism');
INSERT INTO public.genres (id, abbreviation, description) VALUES (89, 'nonf_criticism', 'Criticism');
INSERT INTO public.genres (id, abbreviation, description) VALUES (90, 'design', 'Art & design');
INSERT INTO public.genres (id, abbreviation, description) VALUES (91, 'nonfiction', 'Other');
INSERT INTO public.genres (id, abbreviation, description) VALUES (92, 'religion_rel', 'Religion');
INSERT INTO public.genres (id, abbreviation, description) VALUES (93, 'religion_esoterics', 'Esoterics');
INSERT INTO public.genres (id, abbreviation, description) VALUES (94, 'religion_self', 'Self-improvement');
INSERT INTO public.genres (id, abbreviation, description) VALUES (95, 'Other', 'Other');
INSERT INTO public.genres (id, abbreviation, description) VALUES (96, 'humor_anecdote', 'Anecdote (funny stories)');
INSERT INTO public.genres (id, abbreviation, description) VALUES (97, 'humor_prose', 'Prose');
INSERT INTO public.genres (id, abbreviation, description) VALUES (98, 'humor_verse', 'Verses');
INSERT INTO public.genres (id, abbreviation, description) VALUES (99, 'humor', 'Other');
INSERT INTO public.genres (id, abbreviation, description) VALUES (100, 'home_cooking', 'Cooking');
INSERT INTO public.genres (id, abbreviation, description) VALUES (101, 'home_pets', 'Pets');
INSERT INTO public.genres (id, abbreviation, description) VALUES (102, 'home_crafts', 'Hobbies & Crafts');
INSERT INTO public.genres (id, abbreviation, description) VALUES (103, 'home_entertain', 'Entertaining');
INSERT INTO public.genres (id, abbreviation, description) VALUES (104, 'home_health', 'Health');
INSERT INTO public.genres (id, abbreviation, description) VALUES (105, 'home_garden', 'Garden');
INSERT INTO public.genres (id, abbreviation, description) VALUES (106, 'home_diy', 'Do it yourself');
INSERT INTO public.genres (id, abbreviation, description) VALUES (107, 'home_sport', 'Sports');
INSERT INTO public.genres (id, abbreviation, description) VALUES (108, 'home_sex', 'Erotica & sex');
INSERT INTO public.genres (id, abbreviation, description) VALUES (109, 'home', 'Other');


create table authors
(
    uuid uuid         not null
        primary key,
    name varchar(255) not null
);

alter table authors
    owner to ishual_books;

INSERT INTO public.authors (uuid, name) VALUES ('f4aa4f2f-154d-476a-bc30-0db70f7cb336', 'John Ronald Reuel Tolkien');
INSERT INTO public.authors (uuid, name) VALUES ('9b5dd509-763b-481c-be84-5c8ff2c551c4', 'George Raymond Richard Martin');


create table books
(
    uuid        uuid         not null
        primary key,
    title       varchar(255) not null,
    description text         not null,
    cover       varchar(255) not null
);

alter table books
    owner to ishual_books;

INSERT INTO public.books (uuid, title, description, cover) VALUES ('5535c8aa-bc84-4009-a647-e9445e0d52bd', 'Game of Thrones, or There and Back Again', e'In this ingenious fusion of epic fantasy and adventure, renowned author J.R.R. Martolkien weaves a tale that traverses realms, blending the intricate politics of Westeros with the whimsical adventures of the Shire. "Game of Thrones, or There and Back Again" transports readers to a world where dragons soar overhead and hobbits tread cautiously through the lush greenery of their homeland.

From the scheming halls of King\'s Landing to the quaint villages of the Shire, the journey is fraught with danger, hilarity, and the occasional misplaced wizard. Along the way, our heroes encounter a colorful cast of characters, including a talking direwolf with a penchant for sarcasm and a band of bumbling knights whose loyalty is matched only by their ineptitude.', 'http://ishual-books/images/there_and_back_again.jpg');


create table book_authors
(
    id          serial
        primary key,
    book_uuid   uuid not null
        constraint book_authors_foreign_book_uuid_65e22137944a7
            references books
            on update cascade on delete cascade,
    author_uuid uuid not null
        constraint book_authors_foreign_author_uuid_65e22137944c0
            references authors
            on update cascade on delete cascade
);

alter table book_authors
    owner to ishual_books;

create unique index book_authors_index_book_uuid_author_uuid_65e2213794497
    on book_authors (book_uuid, author_uuid);

create index book_authors_index_book_uuid_65e22137944af
    on book_authors (book_uuid);

create index book_authors_index_author_uuid_65e22137944c9
    on book_authors (author_uuid);

INSERT INTO public.book_authors (id, book_uuid, author_uuid) VALUES (1, '5535c8aa-bc84-4009-a647-e9445e0d52bd', 'f4aa4f2f-154d-476a-bc30-0db70f7cb336');
INSERT INTO public.book_authors (id, book_uuid, author_uuid) VALUES (2, '5535c8aa-bc84-4009-a647-e9445e0d52bd', '9b5dd509-763b-481c-be84-5c8ff2c551c4');


create table book_genres
(
    id        serial
        primary key,
    book_uuid uuid    not null
        constraint book_genres_foreign_book_uuid_65e2213794402
            references books
            on update cascade on delete cascade,
    genre_id  integer not null
        constraint book_genres_foreign_genre_id_65e221379441d
            references genres
            on update cascade on delete cascade
);

alter table book_genres
    owner to ishual_books;

create unique index book_genres_index_book_uuid_genre_id_65e22137943f1
    on book_genres (book_uuid, genre_id);

create index book_genres_index_book_uuid_65e221379440b
    on book_genres (book_uuid);

create index book_genres_index_genre_id_65e2213794426
    on book_genres (genre_id);

INSERT INTO public.book_genres (id, book_uuid, genre_id) VALUES (1, '5535c8aa-bc84-4009-a647-e9445e0d52bd', 11);


create table book_tags
(
    id        serial
        primary key,
    book_uuid uuid    not null
        constraint book_tags_foreign_book_uuid_65e2213794265
            references books
            on update cascade on delete cascade,
    tag_id    integer not null
        constraint book_tags_foreign_tag_id_65e2213794365
            references tags
            on update cascade on delete cascade
);

alter table book_tags
    owner to ishual_books;

create unique index book_tags_index_book_uuid_tag_id_65e2213794251
    on book_tags (book_uuid, tag_id);

create index book_tags_index_book_uuid_65e221379434a
    on book_tags (book_uuid);

create index book_tags_index_tag_id_65e2213794370
    on book_tags (tag_id);

INSERT INTO public.book_tags (id, book_uuid, tag_id) VALUES (1, '5535c8aa-bc84-4009-a647-e9445e0d52bd', 1);
INSERT INTO public.book_tags (id, book_uuid, tag_id) VALUES (2, '5535c8aa-bc84-4009-a647-e9445e0d52bd', 2);

SELECT SETVAL((SELECT PG_GET_SERIAL_SEQUENCE('"book_authors"', 'id')), (SELECT (MAX("id") + 1) FROM "book_authors"), FALSE);
SELECT SETVAL((SELECT PG_GET_SERIAL_SEQUENCE('"book_genres"', 'id')), (SELECT (MAX("id") + 1) FROM "book_genres"), FALSE);
SELECT SETVAL((SELECT PG_GET_SERIAL_SEQUENCE('"book_tags"', 'id')), (SELECT (MAX("id") + 1) FROM "book_tags"), FALSE);
SELECT SETVAL((SELECT PG_GET_SERIAL_SEQUENCE('"genres"', 'id')), (SELECT (MAX("id") + 1) FROM "genres"), FALSE);
SELECT SETVAL((SELECT PG_GET_SERIAL_SEQUENCE('"tags"', 'id')), (SELECT (MAX("id") + 1) FROM "tags"), FALSE);
SELECT SETVAL((SELECT PG_GET_SERIAL_SEQUENCE('"migrations"', 'id')), (SELECT (MAX("id") + 1) FROM "migrations"), FALSE);
