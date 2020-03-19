-- registration number: 1906423
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
    genre VARCHAR(3) NOT NULL,
    rating INT,
    description VARCHAR(1024),
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
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Sid Meier's Civilization V: Brave New World", "civilization5BraveNewWorld.jpg", "str", 85); -- 8 Jul 2013
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Crusader Kings II", "crusaderKings2.jpg", "str", 82); -- 14 feb 2012
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Warcraft III: Reforged", "warcraft3Reforged.jpg", "str", 60); -- 28 jan 2020

INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Else Heart.Break()", "elseHeartBreak().jpg", "rpg", 79); -- Sep 24 2015
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Shadowrun: Dragonfall - Director's Cut", "shadowrunDragonfall.jpg", "rpg", 87); -- 18 sep 2014
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Stardew Valley", "stardewValley.jpeg", "rpg", 89); -- 26 feb 2016 (it has the RPG tag on steam, it counts...)
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Disco Elysium", "discoElysium.jpg", "rpg", 91); -- 15 oct 2019

INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "RimWorld", "rimworld.jpg", "sim", 87); -- 17 oct 2018
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Tom Clancy's Rainbow Six® Siege", "rainbowSixSiege.jpg", "fps", 0); -- 1 dec 2015, metacritic score wasn't on steam page
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Euro Truck Simulator 2", "euroTruckSimulator.jpg", "sim", 79); -- 18 oct 2012
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Farming Simulator 19", "farmingSimulator2019.jpg", "sim", 73); -- 19 Nov, 2018
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Train Simulator 2020", "trainSimulator2020.jpg", "sim", 0); -- 12 jul 2009 *shrugs at release date on steam...*

INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Project Zomboid", "projectZomboid.jpg", "rpg", 87); -- 8 nov 2013
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Shadowrun Returns", "shadowrunReturns.jpg", "rpg", 76); -- 25 july 2013
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Shadowrun: Hong Kong - Extended Edition", "shadowrunHongKong.jpg", "rpg", 81); -- 20 aug 2015

INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Cave Story+", "caveStory+.jpg", "???", 81); -- 22 nov 2011
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Sorcery! Parts 1 & 2", "sorceryPart1And2.jpg", "???", 69); -- 2 feb 2016
INSERT INTO `games` (id, title, image, genre, rating) VALUES (NULL, "Dwarf Fortress", "dwarfFortress.jpg", "???", 0); -- 'time is subjective' isn't a valid release date...

-- game descriptions
update games set description = "The Flagship Turn-Based Strategy Game Returns <br> Become Ruler of the World by establishing and leading a civilization from the dawn of man into the space age: Wage war, conduct diplomacy, discover new technologies, go head-to-head with some of history’s greatest leaders and build the most powerful empire the world has ever known."
where title = "Sid Meier's Civilization V: Brave New World";
update games set description = "Europe is in turmoil. <br> The lands are fragmented into petty fiefs, the emperor struggles with the Pope, and the Holy Father declares that all those who go to liberate the Holy Land will be freed of their sins. Now is the time for greatness. Stand ready, increase your prestige, and listen to the world whisper your name in awe. Do you have what it takes to become a Crusader King?"
where title = "Crusader Kings II";
update games set description = "Warcraft® III: Reforged™ is a complete reimagining of a real-time strategy classic. Experience the epic origin stories of Warcraft, now more stunning and evocative than ever before."
where title = "Warcraft III: Reforged";
update games set description = "Sebastian has just landed his first job in the distant city of Dorisburg. He moves there to start his adult life and figure out who he really wants to be. Among a strange collection of people, hackers and activists he finds some true friends – perhaps even love. But can they stop the terrible deeds of the people ruling the city? And who will get their heart broken in the end?<br>Else Heart.Break() is a reimagination of the adventure game – a fantastic story set in a fully dynamic and interactive world. Instead of rigid puzzles you will learn (with the help from other characters in the game) how the reality of the game can be changed through programming and how any problem can be solved in whatever way you find suitable.<br>From the creators of Blueberry Garden, Clairvoyance and Kometen, a new and unforgettable adventure!"
where title = "Else Heart.Break()";
update games set description = "Shadowrun: Dragonfall - Director’s Cut is a standalone release of Harebrained Schemes' critically-acclaimed Dragonfall campaign, which first premiered as a major expansion for Shadowrun Returns. The Director's Cut adds a host of new content and enhancements to the original game: 5 all-new missions, alternate endings, new music, a redesigned interface, team customization options, a revamped combat system, and more - making it the definitive version of this one-of-a-kind cyberpunk RPG experience."
where title = "Shadowrun: Dragonfall - Director's Cut";
update games set description = "You've inherited your grandfather's old farm plot in Stardew Valley. Armed with hand-me-down tools and a few coins, you set out to begin your new life. Can you learn to live off the land and turn these overgrown fields into a thriving home? It won't be easy. Ever since Joja Corporation came to town, the old ways of life have all but disappeared. The community center, once the town's most vibrant hub of activity, now lies in shambles. But the valley seems full of opportunity. With a little dedication, you might just be the one to restore Stardew Valley to greatness!"
where title = "Stardew Valley";
update games set description = "Disco Elysium is a multi award-winning role playing game. You’re a detective with a unique skill system at your disposal and a whole city block to carve your path across. Interrogate unforgettable characters, crack murders or take bribes. Become a hero or an absolute disaster of a human being."
where title = "Disco Elysium";
update games set description = "A sci-fi colony sim driven by an intelligent AI storyteller. Generates stories by simulating psychology, ecology, gunplay, melee combat, climate, biomes, diplomacy, interpersonal relationships, art, medicine, trade, and more."
where title = "RimWorld";
update games set description = "Tom Clancy's Rainbow Six Siege is the latest installment of the acclaimed first-person shooter franchise developed by the renowned Ubisoft Montreal studio."
where title = "Tom Clancy's Rainbow Six® Siege";
update games set description = "Travel across Europe as king of the road, a trucker who delivers important cargo across impressive distances! With dozens of cities to explore, your endurance, skill and speed will all be pushed to their limits."
where title = "Euro Truck Simulator 2";
update games set description = "The best-selling franchise takes a giant leap forward with a complete overhaul of the graphics engine, offering the most striking and immersive visuals and effects, along with the deepest and most complete farming experience ever."
where title = "Farming Simulator 19";
update games set description = "The ultimate railway hobby! Train Simulator 2020 puts you in control of authentic, licensed locomotives and brings real world routes to life."
where title = "Train Simulator 2020";
update games set description = "Project Zomboid is the ultimate in zombie survival. Alone or in MP: you loot, build, craft, fight, farm and fish in a struggle to survive. A hardcore RPG skillset, a vast map, a massively customisable sandbox and a cute tutorial raccoon await the unwary. So how will you die?"
where title = "Project Zomboid";
update games set description = "The unique cyberpunk-meets-fantasy world of Shadowrun has gained a huge cult following since its creation nearly 25 years ago. Now, creator Jordan Weisman returns to the world of Shadowrun, modernizing this classic game setting as a single player, turn-based tactical RPG."
where title = "Shadowrun Returns";
update games set description = "Shadowrun: Hong Kong - Extended Edition is the capstone title in Harebrained Schemes' Shadowrun series - and now includes the all-new, 6+ hr Shadows of Hong Kong Bonus Campaign. Experience the most impressive Shadowrun RPG yet, hailed as one of the best cRPG / strategy games of 2015!"
where title = "Shadowrun: Hong Kong - Extended Edition";
update games set description = "Run, jump, shoot, fly and explore your way through a massive action-adventure reminiscent of classic 8- and 16-bit games."
where title = "Cave Story+";
update games set description = "An epic adventure in a land of monsters, traps and magic. Journey across the deadly Shamutanti Hills and through Kharé, Cityport of Thieves. Armed with your sword and over fifty spells with weird and wonderful effects, embark on a narrative adventure of a thousand choices where every one is remembered."
where title = "Sorcery! Parts 1 & 2";
update games set description = "The deepest, most intricate simulation of a world that's ever been created. The legendary Dwarf Fortress is now on Steam. Build a fortress and try to help your dwarves survive, OR adventure as a single hero against a deeply generated world."
where title = "Dwarf Fortress";

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
