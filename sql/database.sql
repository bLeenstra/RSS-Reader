-- create database incase it doesn't exist
CREATE database rss;
USE rss;

-- create tables
CREATE TABLE tbl_user (
	userID INT AUTO_INCREMENT,
	username VARCHAR(30),
	password CHAR(128),
	salt CHAR(128),
	PRIMARY KEY (userID)
) ENGINE=InnoDB;

CREATE TABLE tbl_feed (
	feedID INT AUTO_INCREMENT,
	feedName VARCHAR(255),
	feedSite VARCHAR(255),
	PRIMARY KEY (feedID)
) ENGINE=InnoDB;

CREATE TABLE tbl_sub (
	subID INT AUTO_INCREMENT,
	userID INT,
	feedID INT,
	PRIMARY KEY (subID),
	CONSTRAINT tbl_user_fk FOREIGN KEY (userID)
		REFERENCES tbl_user (userID)
		ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT tbl_feed_fk FOREIGN KEY (feedID)
		REFERENCES tbl_feed (feedID)
		ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE tbl_article (
	articleID INT AUTO_INCREMENT,
	subID INT,
	articleName VARCHAR(255),
	viewed BOOLEAN,
	stared BOOLEAN,
	PRIMARY KEY (articleID),
	CONSTRAINT tbl_sub_fk FOREIGN KEY (subID)
		REFERENCES tbl_sub (subID)
		ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

--insert test user
INSERT INTO tbl_user VALUES(
	1,
	'utest',
	'00807432eae173f652f2064bdca1b61b290b52d40e429a7d295d76a71084aa96c0233b82f1feac45529e0726559645acaed6f3ae58a286b9f075916ebf66cacc',
	'f9aab579fc1b41ed0c44fe4ecdbfcdb4cb99b9023abb241a6db833288f4eea3c02f76e0d35204a8695077dcf81932aa59006423976224be0390395bae152d4ef'
);