DROP DATABASE IF EXISTS DWP;

CREATE DATABASE DWP;
USE DWP;

CREATE TABLE UserTable(
    UserID INT(11) AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) UNIQUE,
    FName VARCHAR(50),
    LName VARCHAR(50),
    Email VARCHAR(50) UNIQUE,
    Password VARCHAR(100),
    SignedUpDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    Banned INT(11),
    MediaID INT(11),
    FOREIGN KEY(MediaID) REFERENCES UserTable(MediaID)
);


CREATE TABLE CategoryTable(
    CategoryID INT(11) AUTO_INCREMENT PRIMARY KEY,
    Title TEXT
);

CREATE TABLE PostTable(

    PostID INT(11) AUTO_INCREMENT PRIMARY KEY,
    ParentID INT(11),
    Description TEXT,
    CreatedDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT(11),
    Title VARCHAR(50),   
    CategoryID INT(11),
    FOREIGN KEY(CategoryID) REFERENCES CategoryTable(CategoryID),
    FOREIGN KEY(ParentID) REFERENCES PostTable(PostID)
);



CREATE TABLE MediaTable(
    MediaID INT(11) AUTO_INCREMENT PRIMARY KEY,
    MediaType INT(11),
    UploadDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    PostID INT(11),
    FOREIGN KEY(PostID) REFERENCES PostTable(PostID),
    );

CREATE TABLE FollowingTable (
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    UserID INT(11),
    FollowingID INT(11),
    FOREIGN KEY(UserID) REFERENCES usertable(UserID),
    FOREIGN KEY(FollowingID) REFERENCES usertable(UserID)
);


CREATE TABLE LikesTable(
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    UserID INT(11),
    PostID INT(11),
    Type INT(11),
    FOREIGN KEY(UserID) REFERENCES usertable(UserID),
    FOREIGN KEY(PostID) REFERENCES postTable(PostID)
);


CREATE TABLE RepostTable(
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    UserID INT(11),
    PostID INT(11),
    FOREIGN KEY(UserID) REFERENCES usertable(UserID),
    FOREIGN KEY(PostID) REFERENCES postTable(PostID)
);

--Mockaroo generated users for testing
insert into usertable (username, FName, LName, email) values ('jflipsen0', 'Jess', 'Flipsen', 'jflipsen0@latimes.com');
insert into usertable (username, FName, LName, email) values ('fstanislaw1', 'Florette', 'Stanislaw', 'fstanislaw1@cam.ac.uk');
insert into usertable (username, FName, LName, email) values ('bspurret2', 'Bridie', 'Spurret', 'bspurret2@cafepress.com');
insert into usertable (username, FName, LName, email) values ('lwem3', 'Laurene', 'Wem', 'lwem3@cornell.edu');
insert into usertable (username, FName, LName, email) values ('lwoffenden4', 'Logan', 'Woffenden', 'lwoffenden4@wikia.com');
insert into usertable (username, FName, LName, email) values ('ofrounks5', 'Odey', 'Frounks', 'ofrounks5@hhs.gov');
insert into usertable (username, FName, LName, email) values ('othames6', 'Osborn', 'Thames', 'othames6@webeden.co.uk');
insert into usertable (username, FName, LName, email) values ('bnewey7', 'Brita', 'Newey', 'bnewey7@icq.com');
insert into usertable (username, FName, LName, email) values ('ecarreck8', 'Estell', 'Carreck', 'ecarreck8@hubpages.com');
insert into usertable (username, FName, LName, email) values ('awinthrop9', 'Aridatha', 'Winthrop', 'awinthrop9@bravesites.com');
insert into usertable (username, FName, LName, email) values ('ggieroka', 'Gordon', 'Gierok', 'ggieroka@netlog.com');
insert into usertable (username, FName, LName, email) values ('rknuttonb', 'Rolfe', 'Knutton', 'rknuttonb@foxnews.com');
insert into usertable (username, FName, LName, email) values ('gromic', 'Gale', 'Romi', 'gromic@nbcnews.com');
insert into usertable (username, FName, LName, email) values ('cwinslowd', 'Cly', 'Winslow', 'cwinslowd@woothemes.com');
insert into usertable (username, FName, LName, email) values ('kmatushenkoe', 'Karalynn', 'Matushenko', 'kmatushenkoe@t.co');
insert into usertable (username, FName, LName, email) values ('ghunef', 'Griz', 'Hune', 'ghunef@shutterfly.com');
insert into usertable (username, FName, LName, email) values ('rbardeyg', 'Reagan', 'Bardey', 'rbardeyg@people.com.cn');
insert into usertable (username, FName, LName, email) values ('nbollardh', 'Normie', 'Bollard', 'nbollardh@comcast.net');
insert into usertable (username, FName, LName, email) values ('bmelhuishi', 'Buddie', 'Melhuish', 'bmelhuishi@intel.com');
insert into usertable (username, FName, LName, email) values ('aparsonagej', 'Alanson', 'Parsonage', 'aparsonagej@typepad.com');
insert into usertable (username, FName, LName, email) values ('bathyk', 'Brook', 'Athy', 'bathyk@vkontakte.ru');
insert into usertable (username, FName, LName, email) values ('ialphegel', 'Ingelbert', 'Alphege', 'ialphegel@mayoclinic.com');
insert into usertable (username, FName, LName, email) values ('tgotcherm', 'Tedda', 'Gotcher', 'tgotcherm@earthlink.net');
insert into usertable (username, FName, LName, email) values ('mbendsonn', 'Marris', 'Bendson', 'mbendsonn@sphinn.com');
insert into usertable (username, FName, LName, email) values ('aitzkovwitcho', 'Archibaldo', 'Itzkovwitch', 'aitzkovwitcho@aol.com');



INSERT INTO categorytable(categorytable.Title) VALUES ("Homemade");
INSERT INTO categorytable(categorytable.Title) VALUES ("Amateur");
INSERT INTO categorytable(categorytable.Title) VALUES ("Professionals");
insert into categorytable(categorytable.Title) VALUES("Category 1");
insert into categorytable(categorytable.Title) VALUES("Category 2");
insert into categorytable(categorytable.Title) VALUES("Category 3");
insert into categorytable(categorytable.Title) VALUES("Category 4");
insert into categorytable(categorytable.Title) VALUES("Category 5");

DELIMITER //
CREATE PROCEDURE addNewPost(IN Description VARCHAR(500), IN UserID INT(11), IN Title VARCHAR(50))
BEGIN
INSERT INTO posttable(posttable.Description, posttable.CreatedBy, postTable.Title) VALUES(Description, UserID, Title);
SELECT LAST_INSERT_ID() AS 'PostID';
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE getFeed()
BEGIN
SELECT posttable.PostID, posttable.Description, posttable.CreatedBy, posttable.Title, usertable.Username FROM posttable LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy WHERE posttable.ParentID IS NULL;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE getPost(IN postID INT(11))
BEGIN 

SELECT posttable.Description, posttable.Title, posttable.CreatedDate, usertable.Username
FROM posttable 
LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy 
WHERE posttable.PostID = postID;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE getPost(IN postID INT(11))
BEGIN 

SELECT posttable.PostID, posttable.Description, posttable.CreatedDate, usertable.Username
FROM posttable 
LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy 
WHERE posttable.ParentID = postID;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE createComment(IN postID INT(11), IN userComment VARCHAR(500), IN userID INT(11))
BEGIN 

INSERT INTO posttable(posttable.ParentID, posttable.Description, posttable.CreatedDate, posttable.CreatedBy) VALUES (postID, userComment, NOW(), userID);

END //

DELIMITER ;