-- JWR assignment database;

DROP TABLE IF EXISTS `bookmarks`;
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `games`;
DROP TABLE IF EXISTS `genres`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uname VARCHAR(40),
    pass VARCHAR(255),
    salt VARCHAR(255),
    is_admin BOOLEAN
);

CREATE TABLE `genres` (
    id varchar(3) NOT NULL PRIMARY KEY,
    title VARCHAR(50)
);

CREATE TABLE `games` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150),
    image VARCHAR(255),
    genre varchar(3) NOT NULL,
    rating INT,
    FOREIGN KEY (genre) REFERENCES genres(id) ON DELETE CASCADE
);

CREATE TABLE `bookmarks` (
    user_id INT,
    game_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);

CREATE TABLE `reviews` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id int,
    game_id int,
    rating INT,
    title VARCHAR(150),
    review TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);


INSERT INTO `genres` VALUES ("str", "Strategy");
INSERT INTO `genres` VALUES ("rpg", "Role-Playing Game");
INSERT INTO `genres` VALUES ("fps", "First Person Shooter");
INSERT INTO `genres` VALUES ("sim", "Simulation Game");
INSERT INTO `genres` VALUES ("???", "Other");

-- game list (yes, I'm including ones with strange letters on purpose)
INSERT INTO `games` VALUES (NULL, "Sid Meier's Civilization V: Brave New World", "", "str", 85); -- 8 Jul 2013
INSERT INTO `games` VALUES (NULL, "Crusader Kings II", "", "str", 82); -- 14 feb 2012
INSERT INTO `games` VALUES (NULL, "Warcraft III: Reforged ", "", "str", 60); -- 28 jan 2020

INSERT INTO `games` VALUES (NULL, "Else Heart.Break()", "", "rpg", 79); -- Sep 24 2015
INSERT INTO `games` VALUES (NULL, "Shadowrun: Dragonfall - Director's Cut", "", "rpg", 87); -- 18 sep 2014
INSERT INTO `games` VALUES (NULL, "Stardew Valley", "", "rpg", 89); -- 26 feb 2016 (it has the RPG tag on steam, it counts...)
INSERT INTO `games` VALUES (NULL, "Disco Elysium", "", "rpg", 91); -- 15 oct 2019

INSERT INTO `games` VALUES (NULL, "RimWorld", "", "sim", 87); -- 17 oct 2018
INSERT INTO `games` VALUES (NULL, "Tom Clancy's Rainbow Six® Siege", "", "fps", 0); -- 1 dec 2015, metacritic score wasn't on steam page
INSERT INTO `games` VALUES (NULL, "Euro Truck Simulator 2", "", "sim", 79); -- 18 oct 2012
INSERT INTO `games` VALUES (NULL, "Farming Simulator 19", "", "sim", 73); -- 19 Nov, 2018
INSERT INTO `games` VALUES (NULL, "Train Simulator 2020", "", "sim", 0); -- 12 jul 2009 *shrugs at release date on steam...*

INSERT INTO `games` VALUES (NULL, "Project Zomboid", "", "rpg", 87); -- 8 nov 2013
INSERT INTO `games` VALUES (NULL, "Shadowrun Returns", "", "rpg", 76); -- 25 july 2013
INSERT INTO `games` VALUES (NULL, "Shadowrun: Hong Kong - Extended Edition", "", "rpg", 81); -- 20 aug 2015

INSERT INTO `games` VALUES (NULL, "Cave Story+", "", "???", 81); -- 22 nov 2011
INSERT INTO `games` VALUES (NULL, "Sorcery! Parts 1 & 2", "", "???", 69); -- 2 feb 2016
INSERT INTO `games` VALUES (NULL, "Dwarf Fortress", "", "???", 0); -- 'time is subjective' isn't a valid release date...

-- users
-- salts should be random, using strings here, algorithm is sha1( $pass . $salt ); not secure, but it's an assignment.
INSERT INTO `users` VALUES (NULL, "jwalto", "244cad413fa94db1c686ff5bfc6777241ceaa3ea", "abc123", 1); -- password42
INSERT INTO `bookmarks` VALUES (1, 1);
INSERT INTO `bookmarks` VALUES (1, 2);

INSERT INTO `users` VALUES (NULL, "pwillic", "38bf8a5df0a227b697045c1b29a25a759e391f9b", "java123", 0); -- hanabi
INSERT INTO `bookmarks` VALUES (2, 3);
INSERT INTO `bookmarks` VALUES (2, 4);
INSERT INTO `bookmarks` VALUES (2, 5);

INSERT INTO `users` VALUES (NULL, "rpgs", "ba494cde63bd5d092e916b4083e27cda7c306d43", "html42", 0); -- rpgsftw
INSERT INTO `bookmarks` VALUES (3, 4);
INSERT INTO `bookmarks` VALUES (3, 5);
INSERT INTO `bookmarks` VALUES (3, 6);
INSERT INTO `bookmarks` VALUES (3, 7);
INSERT INTO `bookmarks` VALUES (3, 13);

INSERT INTO `users` VALUES (NULL, "sims", "c65e822545b8596c484112ac62a9194c6043c724", "eadlc", 0); -- simsftw
INSERT INTO `bookmarks` VALUES (4, 8);
INSERT INTO `bookmarks` VALUES (4, 10);
INSERT INTO `bookmarks` VALUES (4, 11);
INSERT INTO `bookmarks` VALUES (4, 12);


-- Changes::


update games
set image="https://steamcdn-a.akamaihd.net/steam/apps/8930/header.jpg?t=1579731804"
where id = 1;

update games
set image="https://www.hrkgame.com/media/games/.thumbnails/header_hv4Gcap.jpg/header_hv4Gcap-460x215.jpg"
where id = 2;

update games
set image="https://bnetcmsus-a.akamaihd.net/cms/template_resource/MFOHLV6RD1VK1541005871536.jpg"
where id = 3;

update games
set image="https://hb.imgix.net/43d2b953aca4d67b18929a09c4b97313758ee779.jpg?auto=compress,format&fit=crop&h=353&w=616&s=7c29152cd0e6a05fbdf549c1303aefec"
where id = 4;

update games
set image="https://vignette.wikia.nocookie.net/shadowrun/images/b/ba/Dragonfall_directorscut_poster.jpg/revision/latest?cb=20180316130658&path-prefix=en"
where id = 5;

update games
set image="https://hb.imgix.net/00797f64c64a677883a9a3ef8a46ab21d7d67020.jpeg?auto=compress,format&fit=crop&h=353&w=616&s=6dbb376bb30e6953659876cb4cb6b368"
where id = 6;

update games
set image="https://images.gog-statics.com/0d4244c2fd3525dca5278a1bfa6e6a50608d690ec473e4597f53b76c8211aed4_product_card_v2_mobile_slider_639.jpg"
where id = 7;

update games
set image="https://i0.wp.com/play3r.net/wp-content/uploads/2015/04/Rimworld_cover.jpg?fit=745%2C485&ssl=1"
where id = 8;

update games
set image="https://www.idgcdn.com.au/article/images/740x500/dimg/rainbow-six.jpg"
where id = 9;

update games
set image="https://steamcdn-a.akamaihd.net/steam/apps/227300/header.jpg?t=1580390416"
where id = 10;

update games
set image="https://gpstatic.com/acache/37/28/1/uk/t620x300.jpg"
where id = 11;

update games
set image="https://steamcdn-a.akamaihd.net/steam/apps/24010/header.jpg?t=1582815384"
where id = 12;

update games
set image="https://steamcdn-a.akamaihd.net/steam/apps/108600/header.jpg?t=1575377037"
where id = 13;

update games
set image="https://steamcdn-a.akamaihd.net/steam/apps/234650/header.jpg?t=1577749569"
where id = 14;

update games
set image="https://steamcdn-a.akamaihd.net/steam/apps/346940/header.jpg?t=1561555035"
where id = 15;

update games
set image="https://cdn02.nintendo-europe.com/media/images/10_share_images/games_15/nintendo_switch_download_software_1/H2x1_NSwitchDS_CaveStoryPlus_image1600w.jpg"
where id = 16;

update games
set image="https://steamcdn-a.akamaihd.net/steam/apps/411000/header.jpg?t=1572348098"
where id = 17;

update games
set image="https://steamcdn-a.akamaihd.net/steam/apps/975370/header.jpg?t=1580248926"
where id = 18;
