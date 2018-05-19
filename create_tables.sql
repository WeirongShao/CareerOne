CREATE TABLE `Student` (
	`sid` INT NOT NULL,
    `semail` VARCHAR(45) NOT NULL UNIQUE,
	`sname` VARCHAR(45) NOT NULL,
	`spassword` VARCHAR(45) NOT NULL,
	`university` VARCHAR(127),
	`degree` VARCHAR(45),
	`major` VARCHAR(45),
	`GPA` FLOAT(3,2),
	`interests` TEXT,
	`qualifications` TEXT,
	`resume` TEXT,
	`restricted` BIT NOT NULL DEFAULT 0,
	PRIMARY KEY (`sid`)
) ENGINE=InnoDB;

CREATE TABLE `Friend` (
	`sid` INT NOT NULL,
	`sid2` INT NOT NULL,
	PRIMARY KEY (`sid`, `sid2`),
	FOREIGN KEY (`sid`) REFERENCES `Student` (`sid`),
    FOREIGN KEY (`sid2`) REFERENCES `Student` (`sid`)
) ENGINE=InnoDB;

CREATE TABLE `Friend_Request` (
	`requesttime` DATETIME NOT NULL,
	`sid` INT NOT NULL,
	`sid_requester` INT NOT NULL,
	`requesttext` VARCHAR(127),
	`status` ENUM('Unread', 'Read', 'Replied') NOT NULL DEFAULT 'Unread',
	PRIMARY KEY (`requesttime`, `sid`, `sid_requester`),
    KEY `requesttime_key` (`requesttime`),
    KEY `sid_key` (`sid`),
	KEY `sid_requester_key` (`sid_requester`),
	FOREIGN KEY (`sid`) REFERENCES `Student` (`sid`),
	FOREIGN KEY (`sid_requester`) REFERENCES `Student` (`sid`)
) ENGINE=InnoDB;

CREATE TABLE `Friend_Req_Reply` (
	`requesttime` DATETIME NOT NULL,
	`sid` INT NOT NULL,
	`sid_replier` INT NOT NULL,
	`replytime` DATETIME NOT NULL,
	`result` ENUM('Accepted', 'Rejected') NOT NULL,
	`replytext` VARCHAR(127),
	`status` ENUM('Unread', 'Read') NOT NULL DEFAULT 'Unread',
	PRIMARY KEY (`requesttime`, `sid`, `sid_replier`),
    FOREIGN KEY (`requesttime`, `sid_replier`, `sid`) REFERENCES `Friend_Request` (`requesttime`, `sid`, `sid_requester`)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE=InnoDB;



CREATE TABLE `Company` (
	`cid` INT NOT NULL,
    `cemail` VARCHAR(45) NOT NULL UNIQUE,
	`cname` VARCHAR(127) NOT NULL,
	`cpassword` VARCHAR(45) NOT NULL,
	`headquarter` VARCHAR(45),
	`industry` VARCHAR(45),
	PRIMARY KEY (`cid`)
) ENGINE=InnoDB;

CREATE TABLE `Following` (
	`sid` INT NOT NULL,
	`cid` INT NOT NULL,
	PRIMARY KEY (`sid`, `cid`),
	FOREIGN KEY (`cid`) REFERENCES `Company` (`cid`),
	FOREIGN KEY (`sid`) REFERENCES `Student` (`sid`)
) ENGINE=InnoDB;



CREATE TABLE `Job` (
	`jid` INT NOT NULL,
	`cid` INT NOT NULL,
	`title` VARCHAR(127) NOT NULL,
	`location` VARCHAR(45),
	`salary` VARCHAR(45),
	`required_degree` TEXT,
	`required_major` TEXT,
	`posttime` DATETIME NOT NULL,
	`description` TEXT,
	`available` BIT NOT NULL DEFAULT 1,
	PRIMARY KEY (`jid`),
	FOREIGN KEY (`cid`) REFERENCES `Company` (`cid`)
) ENGINE=InnoDB;

CREATE TABLE `Job_Application` (
	`applytime` DATETIME NOT NULL,
	`sid` INT NOT NULL,
	`jid` INT NOT NULL,
	`applytext` TEXT,
	`status` ENUM('Unread', 'Read', 'Replied') NOT NULL DEFAULT 'Unread',
	PRIMARY KEY (`applytime`, `sid`, `jid`),
	FOREIGN KEY (`sid`) REFERENCES `Student` (`sid`),
	FOREIGN KEY (`jid`) REFERENCES `Job` (`jid`)
) ENGINE=InnoDB;

CREATE TABLE `Job_App_Reply` (
	`applytime` DATETIME NOT NULL,
	`jid` INT NOT NULL,
	`sid` INT NOT NULL,
	`replytime` DATETIME NOT NULL,
	`result` ENUM('Accepted', 'Rejected') NOT NULL,
	`replytext` TEXT,
	`status` ENUM('Unread', 'Read') NOT NULL DEFAULT 'Unread',
	PRIMARY KEY (`applytime`, `sid`, `jid`),
	FOREIGN KEY (`applytime`, `sid`, `jid`) REFERENCES `Job_Application` (`applytime`, `sid`, `jid`)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE=InnoDB;



CREATE TABLE `Message` (
	`sid` INT NOT NULL,
	`sid_from` INT NOT NULL,
	`mtime` DATETIME NOT NULL,
	`mtext` TEXT NOT NULL,
	`status` ENUM('Unread', 'Read') NOT NULL DEFAULT 'Unread',
	PRIMARY KEY (`sid`, `sid_from`, `mtime`),
	FOREIGN KEY (`sid`) REFERENCES `Student` (`sid`),
	FOREIGN KEY (`sid_from`) REFERENCES `Student` (`sid`)
) ENGINE=InnoDB;



CREATE TABLE `Noti_Job` (
	`sid` INT NOT NULL,
	`jid` INT NOT NULL,
	`notitime` DATETIME NOT NULL,
	`status` ENUM('Unread', 'Read') NOT NULL DEFAULT 'Unread',
	PRIMARY KEY (`sid`, `jid`, `notitime`),
	FOREIGN KEY (`sid`) REFERENCES `Student` (`sid`),
	FOREIGN KEY (`jid`) REFERENCES `Job` (`jid`)
) ENGINE=InnoDB;

CREATE TABLE `Noti_Job_Fwd` (
	`sid` INT NOT NULL,
	`sid_from` INT NOT NULL,
	`jid` INT NOT NULL,
	`notitime` DATETIME NOT NULL,
	`status` ENUM('Unread', 'Read') NOT NULL DEFAULT 'Unread',
	PRIMARY KEY (`sid`, `sid_from`, `jid`, `notitime`),
	FOREIGN KEY (`sid`) REFERENCES `Student` (`sid`),
	FOREIGN KEY (`sid_from`) REFERENCES `Student` (`sid`),
    FOREIGN KEY (`jid`) REFERENCES `Job` (`jid`)
) ENGINE=InnoDB;
