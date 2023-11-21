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
    MediaID INT(11)
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
    FOREIGN KEY(UserID) REFERENCES UserTable(UserID),
    FOREIGN KEY(FollowingID) REFERENCES UserTable(UserID)
) ENGINE = INNODB;


CREATE TABLE LikesTable(
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    UserID INT(11),
    PostID INT(11),
    Type INT(11),
    FOREIGN KEY(UserID) REFERENCES UserTable(UserID),
    FOREIGN KEY(PostID) REFERENCES PostTable(PostID)
) ENGINE = INNODB;


CREATE TABLE RepostTable(
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    UserID INT(11),
    PostID INT(11),
    FOREIGN KEY(UserID) REFERENCES UserTable(UserID),
    FOREIGN KEY(PostID) REFERENCES PostTable(PostID)
) ENGINE = INNODB;

ALTER TABLE UserTable ADD FOREIGN KEY (MediaID) REFERENCES MediaTable(MediaID);
ALTER TABLE PostTable ADD FOREIGN KEY (CategoryID) REFERENCES CategoryPostTable(ID);

insert into UserTable (Username, FName, LName, Email, Password) values ('jflipsen0', 'Jess', 'Flipsen', 'jflipsen0@latimes.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('fstanislaw1', 'Florette', 'Stanislaw', 'fstanislaw1@cam.ac.uk', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('bspurret2', 'Bridie', 'Spurret', 'bspurret2@cafepress.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('lwem3', 'Laurene', 'Wem', 'lwem3@cornell.edu', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('lwoffenden4', 'Logan', 'Woffenden', 'lwoffenden4@wikia.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('ofrounks5', 'Odey', 'Frounks', 'ofrounks5@hhs.gov', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('othames6', 'Osborn', 'Thames', 'othames6@webeden.co.uk', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('bnewey7', 'Brita', 'Newey', 'bnewey7@icq.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('ecarreck8', 'Estell', 'Carreck', 'ecarreck8@hubpages.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('awinthrop9', 'Aridatha', 'Winthrop', 'awinthrop9@bravesites.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('ggieroka', 'Gordon', 'Gierok', 'ggieroka@netlog.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('rknuttonb', 'Rolfe', 'Knutton', 'rknuttonb@foxnews.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('gromic', 'Gale', 'Romi', 'gromic@nbcnews.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('cwinslowd', 'Cly', 'Winslow', 'cwinslowd@woothemes.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('kmatushenkoe', 'Karalynn', 'Matushenko', 'kmatushenkoe@t.co', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('ghunef', 'Griz', 'Hune', 'ghunef@shutterfly.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('rbardeyg', 'Reagan', 'Bardey', 'rbardeyg@people.com.cn', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('nbollardh', 'Normie', 'Bollard', 'nbollardh@comcast.net', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('bmelhuishi', 'Buddie', 'Melhuish', 'bmelhuishi@intel.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('aparsonagej', 'Alanson', 'Parsonage', 'aparsonagej@typepad.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('bathyk', 'Brook', 'Athy', 'bathyk@vkontakte.ru', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('ialphegel', 'Ingelbert', 'Alphege', 'ialphegel@mayoclinic.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('tgotcherm', 'Tedda', 'Gotcher', 'tgotcherm@earthlink.net', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('mbendsonn', 'Marris', 'Bendson', 'mbendsonn@sphinn.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');
insert into UserTable (Username, FName, LName, Email, Password) values ('aitzkovwitcho', 'Archibaldo', 'Itzkovwitch', 'aitzkovwitcho@aol.com', '$2y$10$KEhR01gCVwRtDx9k0mUzxe4WbMpacd6skesgDDC95WfN69t9hfs7O');



INSERT INTO CategoryTable(CategoryTable.Title) VALUES ("Homemade");
INSERT INTO CategoryTable(CategoryTable.Title) VALUES ("Amateur");
INSERT INTO CategoryTable(CategoryTable.Title) VALUES ("Professionals");
insert into CategoryTable(CategoryTable.Title) VALUES("Category 1");
insert into CategoryTable(CategoryTable.Title) VALUES("Category 2");
insert into CategoryTable(CategoryTable.Title) VALUES("Category 3");
insert into CategoryTable(CategoryTable.Title) VALUES("Category 4");
insert into CategoryTable(CategoryTable.Title) VALUES("Category 5");

DELIMITER //
CREATE PROCEDURE addNewPost(IN Description VARCHAR(500), IN UserID INT(11), IN Title VARCHAR(50))
BEGIN
INSERT INTO PostTable(PostTable.Description, PostTable.CreatedBy, postTable.Title) VALUES(Description, UserID, Title);
SELECT LAST_INSERT_ID() AS 'PostID';
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE getFeed(IN UserID INT(11))
BEGIN
SELECT PostTable.PostID, PostTable.Description, PostTable.CreatedBy, PostTable.Title, UserTable.Username, UserTable.UserID, (SELECT COUNT(*) FROM posttable p2 WHERE p2.ParentID = posttable.PostID) AS 'Comments', (SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'Likes', (SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 0) AS 'Dislikes', (SELECT COUNT(*) FROM likestable WHERE likestable.UserID = UserID AND likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'UserLike', (SELECT COUNT(*) FROM likestable WHERE likestable.UserID = UserID AND likestable.PostID = posttable.PostID AND likestable.Type = 0) AS 'UserDislike', mediatable.ImgData FROM PostTable 
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy 
LEFT JOIN MediaTable ON MediaTable.PostID = PostTable.PostID
WHERE PostTable.ParentID IS NULL;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE getPost(IN postID INT(11))
BEGIN 

SELECT PostTable.PostID, PostTable.Title, PostTable.Description, PostTable.CreatedDate, UserTable.Username
FROM PostTable 
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy 
WHERE PostTable.PostID = postID;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE createComment(IN postID INT(11), IN userComment VARCHAR(500), IN userID INT(11))
BEGIN 

INSERT INTO PostTable(PostTable.ParentID, PostTable.Description, PostTable.CreatedDate, PostTable.CreatedBy) VALUES (postID, userComment, NOW(), userID);

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE updateLikePost(IN postID INT(11), IN UserID INT(11), IN Type INT(11))
BEGIN 

SET @Exists = NULL;

SELECT LikesTable.PostID INTO @Exists FROM LikesTable WHERE LikesTable.PostID = PostID AND LikesTable.UserID = UserID; 

IF @Exists IS NULL THEN
    INSERT INTO LikesTable(LikesTable.PostID, LikesTable.UserID, LikesTable.Type) VALUES (PostID, UserID, Type);
ELSE 
    UPDATE LikesTable SET LikesTable.Type = Type WHERE LikesTable.postID = PostID AND LikesTable.UserID = UserID;
END IF;


END //

DELIMITER ;


DELIMITER //
CREATE PROCEDURE deleteFromLikesTable(IN postID INT(11), IN UserID INT(11))
BEGIN 

DELETE FROM LikesTable WHERE LikesTable.PostID = PostID AND LikesTable.UserID = UserID;


END //

DELIMITER ;


DELIMITER //
CREATE PROCEDURE getComments(IN postID INT(11))
BEGIN 

SELECT DISTINCT
    PostTable.PostID,
    PostTable.ParentID,
    PostTable.Description,
    PostTable.CreatedDate,
    PostTable.CreatedBy,
    UserTable.Username,
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.Type = 1 AND LikesTable.PostID = PostTable.ParentID) AS 'Likes',
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.Type = 2 AND LikesTable.PostID = PostTable.ParentID) AS 'Dislikes'
FROM
    PostTable
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy
WHERE
    PostTable.ParentID = PostID

UNION

SELECT DISTINCT
    p2.PostID,
    p2.ParentID,
    p2.Description,
    p2.CreatedDate,
    p2.CreatedBy,
    u2.Username,
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.Type = 1 AND LikesTable.PostID = p2.ParentID) AS 'Likes',
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.Type = 2 AND LikesTable.PostID = p2.ParentID) AS 'Dislikes'
FROM
    PostTable
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy
LEFT JOIN PostTable p2 ON p2.ParentID = PostTable.PostID
LEFT JOIN UserTable u2 ON u2.UserID = p2.CreatedBy
WHERE
    PostTable.ParentID = PostID;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE getCategories()
BEGIN 

SELECT * FROM CategoryTable; 


END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE addFileToPost(IN Type INT(11), IN PostID INT(11), IN FileData LONGBLOB)
BEGIN 

INSERT INTO MediaTable(MediaTable.MediaType, MediaTable.UploadDate, MediaTable.PostID, MediaTable.ImgData) VALUES (Type, NOW(), PostID, FileData);


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

SELECT PostTable.PostID, PostTable.CreatedDate, PostTable.CreatedBy, PostTable.Title, UserTable.Username, (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'Likes', (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 2) AS 'Dislikes', (SELECT COUNT(PostTable.Description) FROM PostTable WHERE PostTable.ParentID IS NOT NULL AND PostTable.PostID = CategoryPostTable.PostID) AS 'Comments', MediaTable.ImgData FROM CategoryTable
LEFT JOIN CategoryPostTable ON CategoryPostTable.CategoryID = CategoryTable.CategoryID
LEFT JOIN PostTable ON PostTable.PostID = CategoryPostTable.PostID
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy
LEFT JOIN MediaTable ON MediaTable.PostID = PostTable.PostID
WHERE CategoryTable.CategoryID = CategoryID;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE createComment(IN postID INT(11), IN userComment VARCHAR(500), IN userID INT(11))
BEGIN 

INSERT INTO posttable(posttable.ParentID, posttable.Description, posttable.CreatedDate, posttable.CreatedBy) VALUES (postID, userComment, NOW(), userID);

END //

DELIMITER //
CREATE PROCEDURE getPostImgs(IN PostID INT(11))
BEGIN 

SELECT MediaTable.ImgData, MediaTable.MediaID FROM MediaTable WHERE MediaTable.PostID = PostID;

END //

DELIMITER ;


DELIMITER //
CREATE PROCEDURE updateLikePost(IN PostID INT(11), IN UserID INT(11), IN Type INT(11))
BEGIN 

SET @Exists = 0;

SELECT COUNt(*) INTO @Exists FROM LikesTable WHERE LikesTable.PostID = PostID AND LikesTable.UserID = UserID; 

IF @Exists = 0 THEN
    INSERT INTO LikesTable(LikesTable.PostID, LikesTable.UserID, LikesTable.Type) VALUES (PostID, UserID, Type);
ELSE 
    UPDATE LikesTable SET LikesTable.Type = Type WHERE LikesTable.postID = PostID AND LikesTable.UserID = UserID;
END IF;

SELECT @Exists AS 'exists';


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
    posttable.ParentID = PostID -- Assuming that the main posts have NULL ParentID

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

END


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
WHERE categorytable.CategoryID = CategoryID

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

DELIMITER //
CREATE PROCEDURE fetchLikesByID(IN UserID INT(11))
BEGIN 

SELECT PostTable.PostID, PostTable.Description, PostTable.CreatedBy, PostTable.Title, UserTable.Username, (SELECT COUNT(*) FROM posttable p2 WHERE p2.ParentID = posttable.PostID) AS 'Comments', (SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'Likes', (SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 0) AS 'Dislikes', (SELECT COUNT(*) FROM likestable WHERE likestable.UserID = UserID AND likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'UserLike', (SELECT COUNT(*) FROM likestable WHERE likestable.UserID = UserID AND likestable.PostID = posttable.PostID AND likestable.Type = 0) AS 'UserDislike', mediatable.ImgData FROM LikesTable
LEFT JOIN PostTable ON PostTable.PostID = LikesTable.PostID
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy
LEFT JOIN mediatable ON mediatable.PostID = posttable.PostID
WHERE LikesTable.UserID = UserID AND LikesTable.Type = 1 AND PostTable.ParentID IS NULL;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE fetchDislikesByID(IN UserID INT(11))
BEGIN 

SELECT PostTable.PostID, PostTable.Description, PostTable.CreatedBy, PostTable.Title, UserTable.Username, (SELECT COUNT(*) FROM posttable p2 WHERE p2.ParentID = posttable.PostID) AS 'Comments', (SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'Likes', (SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 0) AS 'Dislikes', (SELECT COUNT(*) FROM likestable WHERE likestable.UserID = UserID AND likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'UserLike', (SELECT COUNT(*) FROM likestable WHERE likestable.UserID = UserID AND likestable.PostID = posttable.PostID AND likestable.Type = 0) AS 'UserDislike', mediatable.ImgData FROM LikesTable
LEFT JOIN PostTable ON PostTable.PostID = LikesTable.PostID
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy 
LEFT JOIN mediatable ON mediatable.PostID = posttable.PostID
WHERE LikesTable.UserID = UserID AND LikesTable.Type = 0 AND PostTable.ParentID IS NULL;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE fetchUserCommentsByID(IN UserID INT(11))
BEGIN 

SELECT DISTINCT posttable.PostID, posttable.ParentID, posttable.Description, posttable.CreatedDate, usertable.Username FROM posttable 
LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy
LEFT JOIN posttable p2 ON p2.ParentID = posttable.PostID
WHERE posttable.ParentID IS NOT NULL AND posttable.CreatedBy = UserID

UNION

SELECT DISTINCT
    p2.PostID,
    p2.ParentID,
    p2.Description,
    p2.CreatedDate,
    u2.Username
FROM
    PostTable
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy
LEFT JOIN PostTable p2 ON p2.ParentID = PostTable.PostID
LEFT JOIN UserTable u2 ON u2.UserID = p2.CreatedBy

WHERE posttable.ParentID IS NOT NULL AND posttable.CreatedBy = UserID;
    
END //

DELIMITER ;

