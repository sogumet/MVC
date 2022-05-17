DROP TABLE IF EXISTS user;
CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, akronym VARCHAR(255) DEFAULT NULL);
CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email);