CREATE TABLE VENUE (
VName varchar(30) NOT NULL,
VAddress varchar (50) NOT NULL,
PRIMARY KEY (VName))
engine=innodb;

CREATE TABLE GARAGEINFO (
GName varchar(30) NOT NULL,
GAddress varchar(50) NOT NULL,
SpotQuantity int NULL,
PRIMARY KEY (GName))
engine=innodb;

CREATE TABLE GARAGE (
GName varchar(30) NOT NULL,
EDate date NOT NULL,
SpotPrice decimal(4,2) NULL,
AvailableSpots int NULL,
PRIMARY KEY (GName, EDate))
engine=innodb;

CREATE TABLE NEAR (
VName varchar(30) NOT NULL,
GName varchar(30) NOT NULL,
Distance decimal(4,2) NOT NULL,
FOREIGN KEY (VName) REFERENCES VENUE(VName),
FOREIGN KEY (GName) REFERENCES GARAGE(GName))
engine=innodb;

CREATE TABLE TRANSACTION (
TransNo int NOT NULL,
GName varchar(30) NOT NULL,
EDate date NOT NULL,
TDate date NOT NULL,
Active boolean NULL,
Fee decimal(4,2) NULL,
PRIMARY KEY (TransNo),
FOREIGN KEY (GName, EDate) REFERENCES GARAGE(GName, EDate))
engine=innodb;

CREATE TABLE RESERVATION (
ReservationNo int NOT NULL,
TransNo int NOT NULL,
GName varchar(30) NOT NULL,
EDate date NOT NULL,
RDate date NOT NULL,
CellNo varchar(10) NOT NULL,
Price decimal(4,2) NOT NULL,
PRIMARY KEY (ReservationNo),
FOREIGN KEY (TransNo) REFERENCES TRANSACTION(TransNo),
FOREIGN KEY (GName, EDate) REFERENCES TRANSACTION(GName, EDate))
engine=innodb;