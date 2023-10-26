DROP DATABASE IF EXISTS DWP;

CREATE DATABASE DWP;
USE DWP;

CREATE TABLE UserTable(
    UserID INT(11) AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50),
    FName VARCHAR(50),
    LName VARCHAR(50),
    Email VARCHAR(50),
    Password VARCHAR(100),
    SignedUpDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    Banned INT(11)
);


CREATE TABLE CategoryTable(
CategoryID INT(11) AUTO_INCREMENT PRIMARY KEY,
    Title TEXT
);

CREATE TABLE PostTable(

    PostID INT(11) AUTO_INCREMENT PRIMARY KEY,
    ParentID INT(11),
    Description TEXT,
    CreatedDate DATE,
    CreatedBy INT(11),
    Titel VARCHAR(50),   
    CategoryID INT(11),
    FOREIGN KEY(CategoryID) REFERENCES CategoryTable(CategoryID),
    FOREIGN KEY(ParentID) REFERENCES PostTable(PostID)
);



CREATE TABLE MediaTable(
    MediaID INT(11) AUTO_INCREMENT PRIMARY KEY,
    MediaType INT(11),
    UploadDate DATE);

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