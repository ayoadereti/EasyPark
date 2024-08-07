CREATE TABLE USER (
    Utd_id      varchar(10)             NOT NULL,
    Pass	    varchar(30)				NOT NULL,
    Fname       varchar(30), 
    Lname       varchar(30),
    Email       varchar(22),
    Phone_num   varchar(10),     
    CONSTRAINT USERUSERSERPK
        PRIMARY KEY (Utd_id),
    CONSTRAINT CHK_ID
        CHECK (Utd_id REGEXP '[24][0][0-9]{8}'), -- UTD ID should be 10 digits starting with 20 or 40 
    CONSTRAINT CHK_PASS
        CHECK (LENGTH(Pass) >= 6),
    CONSTRAINT CHK_EMAIL
        CHECK (Email LIKE '%@utdallas.edu'), -- Email should be in the format NETID@utdallas.edu
    CONSTRAINT CHK_PHONENUM
        CHECK (Phone_num REGEXP '[0-9]{10}') -- Phone number should only contain (10) numbers 
);

CREATE TABLE PERMIT (
    Permit_num      varchar(10)         NOT NULL,
    Utd_id          varchar(10), 
    Permit_color    varchar(15),
    CONSTRAINT PERMITPK
        PRIMARY KEY (Permit_num),
    CONSTRAINT PERMITUSERFK
        FOREIGN KEY (Utd_id) REFERENCES USER (Utd_id)
            ON UPDATE CASCADE       ON DELETE CASCADE,
    CONSTRAINT CHK_PERMITNUM
        CHECK (Permit_num REGEXP '^[A-Za-z0-9]{10}$'), -- Permit number should be 10 alphanumeric characters
    CONSTRAINT CHK_PERMITCOLOR
        CHECK (Permit_color IN ('Orange', 'Evening Orange', 'Gold', 'Green', 'Purple', 'Accessible'))
);


CREATE TABLE PLATE_NUM (
    Permit_num      varchar(10)     NOT NULL,
    Plate_num       varchar(8)      NOT NULL,
    CONSTRAINT PLATENUMPK
        PRIMARY KEY (Permit_num, Plate_num),
    CONSTRAINT PERMITNUMFK
        FOREIGN KEY (Permit_num) REFERENCES PERMIT (Permit_num)
            ON UPDATE CASCADE       ON DELETE CASCADE,
    CONSTRAINT CHK_PLATENUM
        CHECK (Plate_num REGEXP '^[A-Za-z0-9]+$') -- Plate number should contain only (up to 8) alphanumeric characters
);

CREATE TABLE PARKING_LOT (
    Lot_name        varchar(30)     NOT NULL,
    Lot_size        int,             
    CONSTRAINT PARKINGLOTPK
        PRIMARY KEY (Lot_name)
);

CREATE TABLE PARKING_SPOT (
    Lot_name        varchar(10)     NOT NULL,
    Spot_num        int             NOT NULL,
    Spot_color      varchar(10),
    CONSTRAINT PARKINGSPOTPK
        PRIMARY KEY (Lot_name, Spot_num),
    CONSTRAINT SPOTLOTFK
        FOREIGN KEY (Lot_name) REFERENCES PARKING_LOT(Lot_name)
            ON UPDATE CASCADE       ON DELETE CASCADE,
    CONSTRAINT CHK_SPOTCOLOR
        CHECK (Spot_color IN ('Orange', 'Gold', 'Green', 'Purple', 'Accessible'))
);

CREATE TABLE PERMISSION (
    Permit_color        varchar(15)     NOT NULL,
    Spot_color          varchar(10)     NOT NULL,
    CONSTRAINT PERMISSIONPK
        PRIMARY KEY (Permit_color, Spot_color),
    CONSTRAINT CHK_PCOLOR
        CHECK (Permit_color IN ('Orange', 'Evening Orange', 'Gold', 'Green', 'Purple', 'Accessible')),
    CONSTRAINT CHK_SPCOLOR
        CHECK (Spot_color IN ('Orange', 'Gold', 'Green', 'Purple', 'Accessible'))
);

CREATE TABLE ACCESSES (
    Permit_num          varchar(10)     NOT NULL,
    Permit_color        varchar(15)     NOT NULL,
    Spot_color          varchar(10)     NOT NULL,
    CONSTRAINT ACCESSESPK
        PRIMARY KEY (Permit_num, Spot_color),
    CONSTRAINT PERMITFK
        FOREIGN KEY (Permit_num) REFERENCES PERMIT (Permit_num)
            ON UPDATE CASCADE       ON DELETE CASCADE, 
    CONSTRAINT PERMISSIONFK
        FOREIGN KEY (Permit_color, Spot_color) REFERENCES PERMISSION (Permit_color, Spot_color)
            ON UPDATE CASCADE       ON DELETE CASCADE
);

CREATE TABLE RESERVES (
    R_id        bigint        NOT NULL        AUTO_INCREMENT,
    Rstart      datetime,
    Rend        datetime, 
    Utd_id      varchar(10)   NOT NULL, 
    Lot_name    varchar(30),
    Spot_num    int,
    CONSTRAINT RESERVESPK
        PRIMARY KEY (R_id),
    CONSTRAINT RESERVESUSERFK
        FOREIGN KEY (Utd_id) REFERENCES USER (Utd_id)
            ON UPDATE CASCADE       ON DELETE CASCADE,
    CONSTRAINT RESERVESPOTFK
        FOREIGN KEY (Lot_name, Spot_num) REFERENCES PARKING_SPOT (Lot_name, Spot_num)
            ON UPDATE CASCADE       ON DELETE CASCADE,
    CONSTRAINT CHECK_TIMES
        CHECK (Rstart < Rend)
);

ALTER TABLE RESERVES AUTO_INCREMENT = 1000000000;

DELIMITER //
CREATE TRIGGER permit_access 
  AFTER INSERT 
  ON PERMIT
  FOR EACH ROW
  BEGIN
	INSERT INTO ACCESSES (Permit_num, Permit_color, Spot_color)
    SELECT UserP.Permit_num, P.Permit_color, P.Spot_color
    FROM Permit UserP, Permission P 
    WHERE P.Permit_color = UserP.Permit_color
    AND NOT EXISTS ( SELECT *
					FROM ACCESSES
					WHERE Permit_num = UserP.Permit_num
                    AND Permit_color = P.Permit_color
                    AND Spot_color = P.Spot_color );
  END
  //



