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
    Password TEXT,
    SignedUpDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    Banned INT(11),
    MediaID INT(11),
    IsAdmin INT(1) DEFAULT 0,
    LastUpdated DATETIME DEFAULT CURRENT_TIMESTAMP

) ENGINE = INNODB;



CREATE TABLE PostTable(
    PostID INT(11) AUTO_INCREMENT PRIMARY KEY,
    ParentID INT(11),
    Description LONGTEXT,
    CreatedDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT(11),
    Title VARCHAR(50),   
    CategoryID INT(11),
    Hidden INT(11) DEFAULT 0,
    Deleted INT(11) DEFAULT 0,
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

CREATE TABLE BlockedTable (
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    UserID INT(11),
    BlockedID INT(11),
    FOREIGN KEY(UserID) REFERENCES UserTable(UserID),
    FOREIGN KEY(BlockedID) REFERENCES UserTable(UserID)
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

CREATE TABLE RulesTable(
    RuleID INT(11) AUTO_INCREMENT PRIMARY KEY,
    Rule TEXT
) ENGINE = INNODB;

CREATE TABLE AboutTable(
    Description TEXT
) ENGINE = INNODB;

CREATE TABLE ContactInfoTable(
    Email VARCHAR(100) PRIMARY KEY,
    FName TEXT,
    LName TEXT,
    PhoneNumber TEXT,
    City Text,
    StreetName Text,
    HouseNumber Text
) ENGINE = INNODB;

CREATE VIEW PostView AS
SELECT *
FROM PostTable
WHERE ParentID IS NULL; 

CREATE VIEW CombinedInfoView AS
SELECT 
    AboutTable.Description,
    ContactInfoTable.Email,
    ContactInfoTable.FName,
    ContactInfoTable.LName,
    ContactInfoTable.PhoneNumber,
    ContactInfoTable.City,
    ContactInfoTable.StreetName,
    ContactInfoTable.HouseNumber
FROM 
    AboutTable
CROSS JOIN 
    ContactInfoTable;

DELIMITER //

CREATE TRIGGER AfterBlockUnfollowTrigger
AFTER INSERT ON BlockedTable
FOR EACH ROW
BEGIN
    DELETE FROM FollowingTable
    WHERE UserID = NEW.UserID AND FollowingID = NEW.BlockedID;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER UpdateUserLastUpdatedTrigger
BEFORE UPDATE ON UserTable
FOR EACH ROW
BEGIN
    SET NEW.LastUpdated = CURRENT_TIMESTAMP;
END //

DELIMITER ;




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
INSERT INTO CategoryTable(CategoryTable.Title) VALUES ("French");
INSERT INTO CategoryTable(CategoryTable.Title) VALUES ("Japanese");
INSERT INTO CategoryTable(CategoryTable.Title) VALUES ("Parody");
INSERT INTO CategoryTable(CategoryTable.Title) VALUES ("Humor");
INSERT INTO CategoryTable(CategoryTable.Title) VALUES ("Cartoon");
INSERT INTO CategoryTable(CategoryTable.Title) VALUES ("Deep Fakes");


insert into RulesTable (Rule) values ("All Posts should be related to bread, it doens't matter what the context is, as long as it is about bread");
insert into RulesTable (Rule) values ("Please keep a civil tone with each other, after all it is just bread");
insert into RulesTable (Rule) values ("Admins can always ban you, within reason");
insert into RulesTable (Rule) values ("Admins can always delete posts, if it doesn't follow the guidelines");

INSERT INTO AboutTable(Description) VALUES ("W");

INSERT INTO ContactInfoTable (Email, FName, LName, PhoneNumber, City, StreetName, HouseNumber) VALUES("admin@breadtube.dk", "Name", "Nameson", "+45 12 34 56 78", "Esbjerg", "Spangsbjerg Kirkevej", "103");


INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Artisan Bread Making', 'TGVhcm4gdG8gbWFrZSBhcnRpc2FuIGJyZWFkIHdpdGggdGhpcyBzaW1wbGUgZ3VpZGU=', 19);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Sourdough Starter Tips', 'VGlwcyBmb3IgbWFpbnRhaW5pbmcgYSBoZWFsdGh5IHNvdXJkb3VnaCBzdGFydGVy', 21);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Gluten-Free Bread Recipes', 'RGVsaWNpb3VzIGFuZCBlYXN5IGdsdXRlbi1mcmVlIGJyZWFkIHJlY2lwZXMgZm9yIGV2ZXJ5b25l', 3);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('French Baguette Secrets', 'U2VjcmV0cyBiZWhpbmQgbWFraW5nIHRoZSBwZXJmZWN0IEZyZW5jaCBiYWd1ZXR0ZQ==', 10);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Rye Bread Benefits', 'RGlzY292ZXIgdGhlIGhlYWx0aCBiZW5lZml0cyBvZiByeWUgYnJlYWQ=', 21);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Baking Bread at Home', 'U3RlcC1ieS1zdGVwIGd1aWRlIHRvIGJha2luZyBicmVhZCBhdCBob21l', 17);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Whole Wheat Bread Benefits', 'SGVhbHRoIGJlbmVmaXRzIG9mIHdob2xlIHdoZWF0IGJyZWFk', 11);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Brioche Baking Secrets', 'U2VjcmV0cyB0byBtYWtpbmcgc29mdCBhbmQgcmljaCBicmlvY2hl', 18);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Multigrain Bread Guide', 'QSBjb21wcmVoZW5zaXZlIGd1aWRlIHRvIGJha2luZyBtdWx0aWdyYWluIGJyZWFk', 18);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Pita Bread Recipe', 'U2ltcGxlIGFuZCB0YXN0eSBob21lbWFkZSBwaXRhIGJyZWFkIHJlY2lwZQ==', 22);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Ciabatta Bread Techniques', 'VGVjaG5pcXVlcyBmb3IgcGVyZmVjdCBjaWFiYXR0YSBicmVhZA==', 23);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Banana Bread Delight', 'RGVsaWNpb3VzIGFuZCBtb2lzdCBiYW5hbmEgYnJlYWQgcmVjaXBl', 7);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Focaccia Bread Tips', 'VGlwcyBmb3IgYmFraW5nIEl0YWxpYW4gZm9jYWNjaWEgYnJlYWQ=', 10);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Challah Bread Tradition', 'VHJhZGl0aW9uYWwgSmV3aXNoIGNoYWxsYWggYnJlYWQgcmVjaXBl', 11);
INSERT INTO PostTable (Title, Description, CreatedBy) VALUES ('Irish Soda Bread', 'SG93IHRvIG1ha2UgdHJhZGl0aW9uYWwgSXJpc2ggc29kYSBicmVhZA==', 9);

insert into LikesTable (UserID, PostID, Type) values (12, 6, 0);
insert into LikesTable (UserID, PostID, Type) values (25, 12, 1);
insert into LikesTable (UserID, PostID, Type) values (22, 14, 1);
insert into LikesTable (UserID, PostID, Type) values (2, 3, 1);
insert into LikesTable (UserID, PostID, Type) values (10, 4, 0);
insert into LikesTable (UserID, PostID, Type) values (8, 13, 1);
insert into LikesTable (UserID, PostID, Type) values (24, 1, 1);
insert into LikesTable (UserID, PostID, Type) values (18, 11, 0);
insert into LikesTable (UserID, PostID, Type) values (5, 6, 0);
insert into LikesTable (UserID, PostID, Type) values (13, 12, 0);
insert into LikesTable (UserID, PostID, Type) values (14, 8, 1);
insert into LikesTable (UserID, PostID, Type) values (23, 14, 0);
insert into LikesTable (UserID, PostID, Type) values (21, 14, 1);
insert into LikesTable (UserID, PostID, Type) values (2, 1, 1);
insert into LikesTable (UserID, PostID, Type) values (11, 9, 1);
insert into LikesTable (UserID, PostID, Type) values (16, 9, 0);
insert into LikesTable (UserID, PostID, Type) values (10, 9, 0);
insert into LikesTable (UserID, PostID, Type) values (16, 6, 0);
insert into LikesTable (UserID, PostID, Type) values (12, 14, 0);
insert into LikesTable (UserID, PostID, Type) values (24, 6, 0);
insert into LikesTable (UserID, PostID, Type) values (23, 10, 0);
insert into LikesTable (UserID, PostID, Type) values (15, 2, 1);
insert into LikesTable (UserID, PostID, Type) values (25, 8, 1);
insert into LikesTable (UserID, PostID, Type) values (18, 6, 0);
insert into LikesTable (UserID, PostID, Type) values (19, 9, 1);
insert into LikesTable (UserID, PostID, Type) values (16, 12, 1);
insert into LikesTable (UserID, PostID, Type) values (7, 10, 0);
insert into LikesTable (UserID, PostID, Type) values (25, 13, 0);
insert into LikesTable (UserID, PostID, Type) values (16, 13, 1);
insert into LikesTable (UserID, PostID, Type) values (14, 7, 0);
insert into LikesTable (UserID, PostID, Type) values (5, 2, 0);
insert into LikesTable (UserID, PostID, Type) values (6, 3, 1);
insert into LikesTable (UserID, PostID, Type) values (15, 7, 0);
insert into LikesTable (UserID, PostID, Type) values (20, 13, 1);
insert into LikesTable (UserID, PostID, Type) values (25, 15, 1);
insert into LikesTable (UserID, PostID, Type) values (20, 3, 1);
insert into LikesTable (UserID, PostID, Type) values (5, 9, 0);
insert into LikesTable (UserID, PostID, Type) values (16, 12, 0);
insert into LikesTable (UserID, PostID, Type) values (9, 11, 0);
insert into LikesTable (UserID, PostID, Type) values (13, 3, 0);
insert into LikesTable (UserID, PostID, Type) values (5, 15, 0);
insert into LikesTable (UserID, PostID, Type) values (21, 11, 0);
insert into LikesTable (UserID, PostID, Type) values (15, 8, 1);
insert into LikesTable (UserID, PostID, Type) values (16, 4, 0);
insert into LikesTable (UserID, PostID, Type) values (24, 10, 1);
insert into LikesTable (UserID, PostID, Type) values (12, 9, 0);
insert into LikesTable (UserID, PostID, Type) values (1, 9, 1);
insert into LikesTable (UserID, PostID, Type) values (17, 6, 0);
insert into LikesTable (UserID, PostID, Type) values (8, 4, 0);
insert into LikesTable (UserID, PostID, Type) values (12, 4, 1);
insert into LikesTable (UserID, PostID, Type) values (21, 3, 0);
insert into LikesTable (UserID, PostID, Type) values (2, 10, 1);
insert into LikesTable (UserID, PostID, Type) values (23, 9, 1);
insert into LikesTable (UserID, PostID, Type) values (23, 13, 0);
insert into LikesTable (UserID, PostID, Type) values (21, 1, 0);
insert into LikesTable (UserID, PostID, Type) values (17, 4, 0);
insert into LikesTable (UserID, PostID, Type) values (20, 9, 1);
insert into LikesTable (UserID, PostID, Type) values (20, 2, 0);
insert into LikesTable (UserID, PostID, Type) values (20, 7, 1);
insert into LikesTable (UserID, PostID, Type) values (13, 13, 0);
insert into LikesTable (UserID, PostID, Type) values (13, 1, 1);
insert into LikesTable (UserID, PostID, Type) values (4, 7, 1);
insert into LikesTable (UserID, PostID, Type) values (23, 9, 1);
insert into LikesTable (UserID, PostID, Type) values (11, 4, 0);
insert into LikesTable (UserID, PostID, Type) values (20, 13, 0);
insert into LikesTable (UserID, PostID, Type) values (16, 9, 0);
insert into LikesTable (UserID, PostID, Type) values (7, 6, 0);
insert into LikesTable (UserID, PostID, Type) values (10, 3, 1);
insert into LikesTable (UserID, PostID, Type) values (16, 6, 0);
insert into LikesTable (UserID, PostID, Type) values (24, 4, 0);
insert into LikesTable (UserID, PostID, Type) values (17, 6, 1);
insert into LikesTable (UserID, PostID, Type) values (5, 4, 1);
insert into LikesTable (UserID, PostID, Type) values (4, 5, 1);
insert into LikesTable (UserID, PostID, Type) values (19, 5, 0);
insert into LikesTable (UserID, PostID, Type) values (9, 12, 1);
insert into LikesTable (UserID, PostID, Type) values (23, 6, 1);
insert into LikesTable (UserID, PostID, Type) values (3, 5, 1);
insert into LikesTable (UserID, PostID, Type) values (20, 1, 1);
insert into LikesTable (UserID, PostID, Type) values (8, 4, 0);
insert into LikesTable (UserID, PostID, Type) values (13, 14, 1);
insert into LikesTable (UserID, PostID, Type) values (10, 12, 1);
insert into LikesTable (UserID, PostID, Type) values (9, 7, 1);
insert into LikesTable (UserID, PostID, Type) values (15, 15, 0);
insert into LikesTable (UserID, PostID, Type) values (14, 10, 0);
insert into LikesTable (UserID, PostID, Type) values (17, 10, 1);
insert into LikesTable (UserID, PostID, Type) values (10, 12, 0);
insert into LikesTable (UserID, PostID, Type) values (21, 8, 0);
insert into LikesTable (UserID, PostID, Type) values (3, 14, 0);
insert into LikesTable (UserID, PostID, Type) values (24, 14, 0);
insert into LikesTable (UserID, PostID, Type) values (3, 14, 1);
insert into LikesTable (UserID, PostID, Type) values (6, 12, 0);
insert into LikesTable (UserID, PostID, Type) values (14, 9, 0);
insert into LikesTable (UserID, PostID, Type) values (1, 6, 0);
insert into LikesTable (UserID, PostID, Type) values (6, 11, 1);
insert into LikesTable (UserID, PostID, Type) values (16, 9, 1);
insert into LikesTable (UserID, PostID, Type) values (5, 15, 0);
insert into LikesTable (UserID, PostID, Type) values (1, 6, 1);
insert into LikesTable (UserID, PostID, Type) values (12, 4, 1);
insert into LikesTable (UserID, PostID, Type) values (5, 2, 0);
insert into LikesTable (UserID, PostID, Type) values (14, 2, 1);


DELIMITER //
CREATE PROCEDURE addNewPost(IN Description VARCHAR(500), IN UserID INT(11), IN Title VARCHAR(50))
BEGIN
INSERT INTO PostTable(PostTable.Description, PostTable.CreatedBy, PostTable.Title) VALUES(Description, UserID, Title);
SELECT LAST_INSERT_ID() AS 'PostID';
END //
DELIMITER ;

DELIMITER //

CREATE PROCEDURE getFeed(IN UserID INT(11))
BEGIN
    SELECT 
        PostView.PostID, 
        PostView.Description, 
        PostView.CreatedBy, 
        PostView.Title, 
        UserTable.Username, 
        UserTable.UserID, 
        (SELECT COUNT(*) FROM PostView p2 WHERE p2.ParentID = PostView.PostID) AS 'Comments', 
        (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostView.PostID AND LikesTable.Type = 1) AS 'Likes', 
        (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostView.PostID AND LikesTable.Type = 0) AS 'Dislikes', 
        (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostView.PostID AND LikesTable.Type = 1) AS 'UserLike', 
        (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostView.PostID AND LikesTable.Type = 0) AS 'UserDislike', 
        (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.PostID = PostView.PostID) AS 'Reposts',
        (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.UserID = UserID AND RepostTable.PostID = PostView.PostID) AS 'UserReposted',
        MediaTable.ImgData, 
        PostView.CreatedDate ,
        UserMedia.ImgData AS UserImgData
    FROM 
        PostView
    LEFT JOIN 
        UserTable ON UserTable.UserID = PostView.CreatedBy 
    LEFT JOIN 
        MediaTable ON MediaTable.PostID = PostView.PostID
    LEFT JOIN 
        MediaTable AS UserMedia ON UserTable.MediaID = UserMedia.MediaID
    WHERE 
        PostView.Hidden = 0 AND PostView.Deleted = 0 AND
        NOT EXISTS (
            SELECT 1 FROM BlockedTable
            WHERE BlockedTable.UserID = UserID AND BlockedTable.BlockedID = PostView.CreatedBy
        )
    ORDER BY 
        PostView.CreatedDate DESC;
END //

DELIMITER ;


DELIMITER //
CREATE PROCEDURE getPost(IN PostID INT(11), IN UserID INT(11))
BEGIN 

SELECT 
    PostTable.PostID, 
    PostTable.Title, 
    PostTable.Description, 
    PostTable.CreatedDate, 
    UserTable.Username, 
    PostTable.CreatedBy, 
    PostTable.Hidden, 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'Likes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'Dislikes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'UserLike', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'UserDislike',
    (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.PostID = PostTable.PostID) AS 'Reposts',
    (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.UserID = UserID AND RepostTable.PostID = PostTable.PostID) AS 'UserReposted'
FROM PostTable 
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy 
WHERE PostTable.PostID = PostID;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE createComment(IN postID INT(11), IN userComment VARCHAR(500), IN userID INT(11))
BEGIN 

INSERT INTO PostTable(PostTable.ParentID, PostTable.Description, PostTable.CreatedDate, PostTable.CreatedBy) VALUES (postID, userComment, NOW(), userID);

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

CREATE PROCEDURE addFileToPost(IN Type INT, IN PostID INT, IN FileData LONGBLOB)
BEGIN 
    INSERT INTO MediaTable(MediaType, UploadDate, PostID, ImgData) 
    VALUES (Type, NOW(), PostID, FileData);

    SELECT LAST_INSERT_ID() AS NewMediaID;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE addPostToCategory(IN CategoryID INT(11), IN PostID INT(11))
BEGIN 

INSERT INTO CategoryPostTable(CategoryPostTable.PostID, CategoryPostTable.CategoryID) VALUES (PostID, CategoryID);


END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE getPostsInCategory(IN CategoryID INT(11), IN UserID INT(11))
BEGIN 

SELECT 
    PostTable.PostID, 
    PostTable.CreatedDate, 
    PostTable.CreatedBy, 
    PostTable.Title, 
    UserTable.Username, 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'Likes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 2) AS 'Dislikes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.UserID = UserID AND LikesTable.Type = 1) AS 'UserLike', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.UserID = UserID AND LikesTable.Type = 2) AS 'UserDislike', 
    (SELECT COUNT(PostTable.Description) FROM PostTable WHERE PostTable.ParentID IS NOT NULL AND PostTable.PostID = CategoryPostTable.PostID) AS 'Comments', 
    MediaTable.ImgData 
    FROM CategoryTable
LEFT JOIN CategoryPostTable ON CategoryPostTable.CategoryID = CategoryTable.CategoryID
LEFT JOIN PostTable ON PostTable.PostID = CategoryPostTable.PostID
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy
LEFT JOIN MediaTable ON MediaTable.PostID = PostTable.PostID
WHERE CategoryTable.CategoryID = CategoryID;

END //

DELIMITER ;

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
CREATE PROCEDURE getUncatorizedPosts(IN UserID INT(11))
BEGIN 

SELECT 
    PostTable.PostID, 
    PostTable.CreatedDate, 
    PostTable.CreatedBy, 
    PostTable.Title, 
    UserTable.Username, 
    MediaTable.ImgData, 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'Likes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 2) AS 'Dislikes',
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.UserID = UserID AND LikesTable.Type = 1) AS 'UserLike', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.UserID = UserID AND LikesTable.Type = 2) AS 'UserDislike'
    FROM PostTable
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy
LEFT JOIN MediaTable ON MediaTable.PostID = PostTable.PostID
WHERE PostTable.CategoryID IS NULL;

END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE fetchLikesByID(IN UserID INT(11))
BEGIN 

SELECT 
    PostTable.PostID, 
    PostTable.Description, 
    PostTable.CreatedBy, 
    PostTable.Title, 
    UserTable.Username, 
    (SELECT COUNT(*) FROM PostTable p2 WHERE p2.ParentID = PostTable.PostID) AS 'Comments', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'Likes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'Dislikes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'UserLike', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'UserDislike', 
    (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.PostID = PostTable.PostID) AS 'Reposts',
    (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.UserID = UserID AND RepostTable.PostID = PostTable.PostID) AS 'UserReposted',
    MediaTable.ImgData 
FROM 
    LikesTable
LEFT JOIN 
    PostTable ON PostTable.PostID = LikesTable.PostID
LEFT JOIN 
    UserTable ON UserTable.UserID = PostTable.CreatedBy
LEFT JOIN 
    MediaTable ON MediaTable.PostID = PostTable.PostID
WHERE 
    LikesTable.UserID = UserID AND LikesTable.Type = 1 AND PostTable.ParentID IS NULL;

END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE fetchDislikesByID(IN UserID INT(11))
BEGIN 

SELECT 
    PostTable.PostID, 
    PostTable.Description, 
    PostTable.CreatedBy, 
    PostTable.Title, 
    UserTable.Username, 
    (SELECT COUNT(*) FROM PostTable p2 WHERE p2.ParentID = PostTable.PostID) AS 'Comments', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'Likes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'Dislikes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'UserLike', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'UserDislike', 
    (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.PostID = PostTable.PostID) AS 'Reposts',
    (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.UserID = UserID AND RepostTable.PostID = PostTable.PostID) AS 'UserReposted',
    MediaTable.ImgData 
FROM 
    LikesTable
LEFT JOIN 
    PostTable ON PostTable.PostID = LikesTable.PostID
LEFT JOIN 
    UserTable ON UserTable.UserID = PostTable.CreatedBy 
LEFT JOIN 
    MediaTable ON MediaTable.PostID = PostTable.PostID
WHERE 
    LikesTable.UserID = UserID AND LikesTable.Type = 0 AND PostTable.ParentID IS NULL;

END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE fetchUserPosts(IN UserID INT(11))
BEGIN 

SELECT 
    PostTable.PostID, 
    PostTable.Description, 
    PostTable.CreatedDate, 
    PostTable.CreatedBy, 
    PostTable.Title, 
    PostTable.CategoryID, 
    MediaTable.ImgData,
    (SELECT COUNT(*) FROM PostTable p2 WHERE p2.ParentID = PostTable.PostID) AS 'Comments', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'Likes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'Dislikes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'UserLike', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'UserDislike', 
    (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.PostID = PostTable.PostID) AS 'Reposts',
    (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.UserID = UserID AND RepostTable.PostID = PostTable.PostID) AS 'UserReposted'
FROM 
    PostTable 
LEFT JOIN 
    MediaTable ON MediaTable.PostID = PostTable.PostID
WHERE 
    PostTable.ParentID IS NULL AND PostTable.Deleted = 0 AND PostTable.CreatedBy = UserID
ORDER BY 
    PostTable.PostID DESC;

END //

DELIMITER ;


DELIMITER //

CREATE PROCEDURE fetchUserReposts(IN UserID INT(11))
BEGIN 

SELECT 
    PostTable.PostID, 
    PostTable.Description, 
    PostTable.CreatedBy, 
    PostTable.Title, 
    UserTable.Username, 
    (SELECT COUNT(*) FROM PostTable p2 WHERE p2.ParentID = PostTable.PostID) AS 'Comments', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'Likes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'Dislikes', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'UserLike', 
    (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = UserID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'UserDislike', 
    (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.PostID = PostTable.PostID) AS 'Reposts',
    (SELECT COUNT(*) FROM RepostTable WHERE RepostTable.UserID = UserID AND RepostTable.PostID = PostTable.PostID) AS 'UserReposted',
    MediaTable.ImgData 
FROM 
    PostTable 
LEFT JOIN 
    UserTable ON UserTable.UserID = PostTable.CreatedBy 
LEFT JOIN 
    MediaTable ON MediaTable.PostID = PostTable.PostID
JOIN 
    RepostTable ON RepostTable.PostID = PostTable.PostID
WHERE 
    RepostTable.UserID = UserID;

END //

DELIMITER ;


DELIMITER //
CREATE PROCEDURE fetchUserCommentsByID(IN UserID INT(11))
BEGIN 

SELECT DISTINCT PostTable.PostID, PostTable.ParentID, PostTable.Description, PostTable.CreatedDate, UserTable.Username FROM PostTable 
LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy
LEFT JOIN PostTable p2 ON p2.ParentID = PostTable.PostID
WHERE PostTable.ParentID IS NOT NULL AND PostTable.CreatedBy = UserID

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

WHERE PostTable.ParentID IS NOT NULL AND PostTable.CreatedBy = UserID;
    
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE followUser(IN FollowID INT(11), IN UserID INT(11))
BEGIN

SELECT COUNT(*) INTO @Exists FROM FollowingTable WHERE FollowingTable.UserID = UserID AND FollowingTable.FollowingID = FollowID;

IF @Exists = 0 THEN

INSERT INTO FollowingTable(FollowingTable.UserID, FollowingTable.FollowingID) VALUES(UserID, FollowID);

ELSE

DELETE FROM FollowingTable WHERE FollowingTable.UserID = UserID AND FollowingTable.FollowingID = FollowID;

END IF;

END //

DELIMITER ; 

DELIMITER //
CREATE PROCEDURE getRules()
BEGIN
SELECT * FROM RulesTable;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE deleteRule(IN RuleID INT(11))
BEGIN
DELETE FROM RulesTable WHERE RulesTable.RuleID = RuleID;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE insertRule(IN Rule LONGTEXT)
BEGIN
INSERT INTO RulesTable(RulesTable.Rule) VALUES (Rule);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE updateRule(IN RuleID INT(11), IN Rule LONGTEXT)
BEGIN
UPDATE RulesTable SET RulesTable.Rule = Rule WHERE RulesTable.RuleID = RuleID;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GetReplyChain(p_postID INT, IN UserID INT(11))
BEGIN
    -- Recursive common table expression to get post hierarchy
    WITH RECURSIVE PostHierarchyCTE AS (
        SELECT
            p.PostID,
            p.ParentID,
            p.Description,
            p.CreatedDate,
            p.CreatedBy,
            UserTable.Username AS Username,
            (SELECT COUNT(*) FROM LikesTable l WHERE l.PostID = p.PostID AND l.Type = 1) AS Likes,
            (SELECT COUNT(*) FROM LikesTable l WHERE l.PostID = p.PostID AND l.Type = 0) AS Dislikes,
        	(SELECT COUNT(*) FROM LikesTable l WHERE l.UserID = userID AND l.PostID = p.PostID AND l.Type = 1) AS UserLike, 
            (SELECT COUNT(*) FROM LikesTable l WHERE l.UserID = userID AND l.PostID = p.PostID AND l.Type = 0) AS UserDislike,
            0 AS Level
        FROM
            PostTable p
        LEFT JOIN
            UserTable ON p.CreatedBy = UserTable.UserID
        WHERE
            p.PostID = p_postID
        UNION ALL
        SELECT
            PostTable.PostID,
            PostTable.ParentID,
            PostTable.Description,
            PostTable.CreatedDate,
            PostTable.CreatedBy,
            UserTable.Username AS Username,
            (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'Likes',
            (SELECT COUNT(*) FROM LikesTable WHERE LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'Dislikes',
        	(SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = userID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 1) AS 'UserLike', 
        	(SELECT COUNT(*) FROM LikesTable WHERE LikesTable.UserID = userID AND LikesTable.PostID = PostTable.PostID AND LikesTable.Type = 0) AS 'UserDislike',
            ph.Level + 1 AS Level
        FROM
            PostTable
        LEFT JOIN UserTable ON UserTable.UserID = PostTable.CreatedBy
        INNER JOIN
            PostHierarchyCTE ph ON PostTable.ParentID = ph.PostID
        LEFT JOIN
            UserTable u ON PostTable.CreatedBy = u.UserID
    )

    -- Selecting the final result from the CTE
    SELECT
        PostID,
        ParentID,
        Description,
        CreatedDate,
        CreatedBy,
        Username,
        Likes,
        Dislikes,
        UserLike,
        UserDislike,
        Level
    FROM
        PostHierarchyCTE
    ORDER BY
        Level, PostID;

END //
DELIMITER ;

DELIMITER //

CREATE PROCEDURE repostPost(IN p_PostID INT(11), IN p_UserID INT(11))
BEGIN
    IF EXISTS (SELECT * FROM RepostTable WHERE UserID = p_UserID AND PostID = p_PostID) THEN
        DELETE FROM RepostTable WHERE UserID = p_UserID AND PostID = p_PostID;
    ELSE
        INSERT INTO RepostTable (UserID, PostID) VALUES (p_UserID, p_PostID);
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE GetFollowingUsers(IN user_id INT)
BEGIN
    SELECT u.UserID, u.Username, u.FName, u.LName, u.Email
    FROM UserTable u
    INNER JOIN FollowingTable f ON u.UserID = f.FollowingID
    WHERE f.UserID = user_id;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE GetBlockedUsers(IN user_id INT)
BEGIN
    SELECT u.UserID, u.Username, u.FName, u.LName, u.Email
    FROM UserTable u
    INNER JOIN BlockedTable b ON u.UserID = b.BlockedID
    WHERE b.UserID = user_id;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE GetMediaImgDataByUserID(IN _UserID INT)
BEGIN
    SELECT MediaTable.ImgData
    FROM UserTable
    JOIN MediaTable ON UserTable.MediaID = MediaTable.MediaID
    WHERE UserTable.UserID = _UserID;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE BlockUnblockUser(IN userID INT, IN blockedUserID INT)
BEGIN
    DECLARE entryExists BOOLEAN DEFAULT FALSE;

    SELECT EXISTS(
        SELECT 1 FROM BlockedTable
        WHERE UserID = userID AND BlockedID = blockedUserID
    ) INTO entryExists;

    IF entryExists THEN
        DELETE FROM BlockedTable
        WHERE UserID = userID AND BlockedID = blockedUserID;
    ELSE
        INSERT INTO BlockedTable (UserID, BlockedID)
        VALUES (userID, blockedUserID);
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE GetIsUserBlocked(IN currentUserID INT, IN otherUserID INT, OUT isBlocked BOOLEAN)
BEGIN
    SELECT EXISTS(
        SELECT 1 FROM BlockedTable
        WHERE UserID = currentUserID AND BlockedID = otherUserID
    ) INTO isBlocked;
END //

DELIMITER ;
