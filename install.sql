/* - Create Tables - */
CREATE TABLE Projects(
    ID INT(8) NOT NULL AUTO_INCREMENT,
    Title VARCHAR(128) NOT NULL,
    Description TEXT NOT NULL,
    URL VARCHAR(2083) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE Occupations(
    ID INT(8) NOT NULL AUTO_INCREMENT,
    Company VARCHAR(128) NOT NULL,
    Title VARCHAR(128) NOT NULL,
    StartDate DATE NOT NULL,
    EndDate DATE,
    PRIMARY KEY (ID)
);

CREATE TABLE EducationTypes(
    ID INT(8) NOT NULL AUTO_INCREMENT,
    Type VARCHAR(64) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE Educations(
    ID INT(8) NOT NULL AUTO_INCREMENT,
    Name VARCHAR(128) NOT NULL,
    School VARCHAR(256) NOT NULL,
    StartDate DATE NOT NULL,
    EndDate DATE,
    TypeID INT(8) NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (TypeID) REFERENCES EducationTypes(ID)
);

/* - Inserts - */
INSERT INTO EducationTypes (Type) VALUES ("Course"), ("Program");
