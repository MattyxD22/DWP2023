DROP DATABASE IF EXISTS DWP;

CREATE DATABASE DWP;
USE DWP;

CREATE TABLE CategoryTable(
    CategoryID INT(11) AUTO_INCREMENT PRIMARY KEY,
    Title TEXT
) ENGINE = INNODB;

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
    IsAdmin TINYINT(1) DEFAULT 0
) ENGINE = INNODB;



CREATE TABLE PostTable(
    PostID INT(11) AUTO_INCREMENT PRIMARY KEY,
    ParentID INT(11),
    Description TEXT,
    CreatedDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT(11),
    Title VARCHAR(50),   
    CategoryID INT(11),
    FOREIGN KEY(ParentID) REFERENCES PostTable(PostID),
    FOREIGN KEY(CreatedBy) REFERENCES UserTable(UserID)
) ENGINE = INNODB;

CREATE TABLE CategoryPostTable(
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    PostID INT(11),
    CategoryID INT(11),
    FOREIGN KEY(PostID) REFERENCES PostTable(PostID),
    FOREIGN KEY(CategoryID) REFERENCES CategoryTable(CategoryID)
 ) ENGINE = INNODB;

CREATE TABLE MediaTable(
    MediaID INT(11) AUTO_INCREMENT PRIMARY KEY,
    MediaType INT(11),
    ImgData LONGBLOB NOT NULL,
    UploadDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    PostID INT(11),
    FOREIGN KEY(PostID) REFERENCES PostTable(PostID)
    ) ENGINE = INNODB;

CREATE TABLE FollowingTable (
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    UserID INT(11),
    FollowingID INT(11),
    FOREIGN KEY(UserID) REFERENCES usertable(UserID),
    FOREIGN KEY(FollowingID) REFERENCES usertable(UserID)
) ENGINE = INNODB;


CREATE TABLE LikesTable(
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    UserID INT(11),
    PostID INT(11),
    Type INT(11),
    FOREIGN KEY(UserID) REFERENCES usertable(UserID),
    FOREIGN KEY(PostID) REFERENCES postTable(PostID)
) ENGINE = INNODB;


CREATE TABLE RepostTable(
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    UserID INT(11),
    PostID INT(11),
    FOREIGN KEY(UserID) REFERENCES usertable(UserID),
    FOREIGN KEY(PostID) REFERENCES postTable(PostID)
) ENGINE = INNODB;

ALTER TABLE usertable ADD FOREIGN KEY (MediaID) REFERENCES mediatable(MediaID);
ALTER TABLE PostTable ADD FOREIGN KEY (CategoryID) REFERENCES CategoryPostTable(ID);

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
SELECT posttable.PostID, posttable.Description, posttable.CreatedBy, posttable.Title, usertable.Username, usertable.UserID FROM posttable LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy WHERE posttable.ParentID IS NULL;
END //
DELIMITER ;

DELIMITER ;

DELIMITER //
CREATE PROCEDURE getPost(IN postID INT(11))
BEGIN 

SELECT posttable.PostID, posttable.Title, posttable.Description, posttable.CreatedDate, usertable.Username
FROM posttable 
LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy 
WHERE posttable.PostID = postID;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE createComment(IN postID INT(11), IN userComment VARCHAR(500), IN userID INT(11))
BEGIN 

INSERT INTO posttable(posttable.ParentID, posttable.Description, posttable.CreatedDate, posttable.CreatedBy) VALUES (postID, userComment, NOW(), userID);

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE updateLikePost(IN postID INT(11), IN UserID INT(11), IN Type INT(11))
BEGIN 

SET @Exists = NULL;

SELECT likestable.PostID INTO @Exists FROM likestable WHERE likestable.PostID = PostID AND likestable.UserID = UserID; 

IF @Exists IS NULL THEN
    INSERT INTO likestable(likestable.PostID, likestable.UserID, likestable.Type) VALUES (PostID, UserID, Type);
ELSE 
    UPDATE likestable SET likestable.Type = Type WHERE likestable.postID = PostID AND likestable.UserID = UserID;
END IF;


END //

DELIMITER ;


DELIMITER //
CREATE PROCEDURE deleteFromLikesTable(IN postID INT(11), IN UserID INT(11))
BEGIN 

DELETE FROM likestable WHERE likestable.PostID = PostID AND likestable.UserID = UserID;


END //

DELIMITER ;


DELIMITER //
CREATE PROCEDURE getComments(IN postID INT(11))
BEGIN 

SELECT DISTINCT
    posttable.PostID,
    posttable.ParentID,
    posttable.Description,
    posttable.CreatedDate,
    posttable.CreatedBy,
    usertable.Username,
    (SELECT COUNT(*) FROM likestable WHERE likestable.Type = 1 AND likestable.PostID = posttable.ParentID) AS 'Likes',
    (SELECT COUNT(*) FROM likestable WHERE likestable.Type = 2 AND likestable.PostID = posttable.ParentID) AS 'Dislikes'
FROM
    posttable
LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy
WHERE
    posttable.ParentID = PostID

UNION

SELECT DISTINCT
    p2.PostID,
    p2.ParentID,
    p2.Description,
    p2.CreatedDate,
    p2.CreatedBy,
    u2.Username,
    (SELECT COUNT(*) FROM likestable WHERE likestable.Type = 1 AND likestable.PostID = p2.ParentID) AS 'Likes',
    (SELECT COUNT(*) FROM likestable WHERE likestable.Type = 2 AND likestable.PostID = p2.ParentID) AS 'Dislikes'
FROM
    posttable
LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy
LEFT JOIN posttable p2 ON p2.ParentID = posttable.PostID
LEFT JOIN usertable u2 ON u2.UserID = p2.CreatedBy
WHERE
    posttable.ParentID = PostID;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE getCategories()
BEGIN 

SELECT * FROM categorytable; 


END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE addFileToPost(IN Type INT(11), IN PostID INT(11), IN FileData LONGBLOB)
BEGIN 

INSERT INTO mediatable(mediatable.MediaType, mediatable.UploadDate, mediatable.PostID, mediatable.ImgData) VALUES (Type, NOW(), PostID, FileData);


END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE addPostToCategory(IN CategoryID INT(11), IN PostID INT(11))
BEGIN 

INSERT INTO CategoryPostTable(CategoryPostTable.PostID, CategoryPostTable.CategoryID) VALUES (PostID, CategoryID);


END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE getPostsInCategory(IN CategoryID INT(11))
BEGIN 

SELECT posttable.PostID, posttable.CreatedDate, posttable.CreatedBy, posttable.Title, usertable.Username, (SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'Likes', (SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 2) AS 'Dislikes', (SELECT COUNT(posttable.Description) FROM posttable WHERE posttable.ParentID IS NOT NULL AND posttable.PostID = categoryposttable.PostID) AS 'Comments', mediatable.ImgData FROM categorytable
LEFT JOIN categoryposttable ON categoryposttable.CategoryID = categorytable.CategoryID
LEFT JOIN posttable ON posttable.PostID = categoryposttable.PostID
LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy
LEFT JOIN mediatable ON mediatable.PostID = posttable.PostID
WHERE categorytable.CategoryID = CategoryID;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE getPostImgs(IN PostID INT(11))
BEGIN 

SELECT mediatable.ImgData, mediatable.MediaID FROM mediatable WHERE mediatable.PostID = PostID;

END //

DELIMITER ;


DELIMITER //
CREATE PROCEDURE getUncatorizedPosts()
BEGIN 

SELECT posttable.PostID, posttable.CreatedDate, posttable.CreatedBy, posttable.Title, usertable.Username, mediatable.ImgData, (SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'Likes', (SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 2) AS 'Dislikes' FROM PostTable
LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy
LEFT JOIN mediatable ON mediatable.PostID = posttable.PostID
WHERE posttable.CategoryID IS NULL;

END //

DELIMITER ;

