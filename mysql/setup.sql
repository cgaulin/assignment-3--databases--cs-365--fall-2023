DROP DATABASE IF EXISTS student_passwords;

CREATE DATABASE student_passwords;

DROP USER IF EXISTS 'passwords_user'@'localhost';

CREATE USER 'passwords_user'@'localhost' IDENTIFIED BY 'password123';
GRANT ALL ON student_passwords.* TO 'passwords_user'@'localhost';

USE student_passwords;


CREATE TABLE websites (
    website_name VARCHAR(128) NOT NULL,
    website_URL VARCHAR(128) NOT NULL,
    PRIMARY KEY (website_URL)
);

CREATE TABLE account (
    website_URL VARCHAR(128) NOT NULL,
    first_name VARCHAR(64) NOT NULL,
    last_name VARCHAR(64) NOT NULL,
    username VARCHAR(64) NOT NULL,
    email VARCHAR(128) NOT NULL,
    p_word VARCHAR(128) NOT NULL,
    comment TEXT,
    PRIMARY KEY (website_URL, username, p_word)
);

INSERT INTO websites VALUES
('Youtube', 'https://www.youtube.com/'),
('Google', 'https://www.google.com/'),
('Facebook', 'https://www.facebook.com/'),
('Yahoo', 'https://www.yahoo.com/'),
('Amazon', 'https://www.amazon.com/'),
('Reddit', 'https://www.reddit.com/'),
('Ebay', 'https://www.ebay.com/'),
('Twitter', 'https://twitter.com/'),
('LinkedIn', 'https://www.linkedin.com/'),
('Pinterest', 'https://www.pinterest.com/');

INSERT INTO account VALUES
('https://www.youtube.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'youtubePass', 'This is my youtube password'),
('https://www.google.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'googlePass', 'This is my google password'),
('https://www.facebook.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'facebookPass', 'This is my facebook password'),
('https://www.yahoo.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'yahooPass', 'This is my yahoo password'),
('https://www.amazon.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'amazonPass', 'This is my amazon password'),
('https://www.reddit.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'redditPass', 'This is my reddit password'),
('https://www.ebay.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'ebayPass', 'This is my ebay password'),
('https://twitter.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'twitterPass', 'This is my twitter password'),
('https://www.linkedin.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'linkedinPass', 'This is my linkedin password'),
('https://www.pinterest.com/', 'Cameron', 'Gaulin', 'cgaulin', 'cgaulin@gmail.com', 'pinterestPass', 'This is my pinterest password');