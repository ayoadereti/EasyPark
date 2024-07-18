LOAD DATA INFILE 'C:/<Users/ayobamiadereti/Downloads/USER.csv' 
INTO TABLE USER 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS (`Utd_id`, `Fname`, `Lname`, `Email`, `Phone_num`);

LOAD DATA LOCAL INFILE 'C:/<Users/ayobamiadereti/Downloads/PERMIT.csv' 
INTO TABLE PERMIT 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS (`Permit_num`, `Utd_id`, `Permit_color`);

LOAD DATA LOCAL INFILE 'C:/<Users/ayobamiadereti/Downloads/PLATE_NUM.csv' 
INTO TABLE PLATE_NUM 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS (`Permit_num`, `Plate_num`);

LOAD DATA LOCAL INFILE 'C:/<Users/ayobamiadereti/Downloads/PARKING_LOT.csv' 
INTO TABLE PARKING_LOT 
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS (`Lot_name`, `Lot_size`);

LOAD DATA LOCAL INFILE 'C:/<Users/ayobamiadereti/Downloads/PARKING_LOT.csv' 
INTO TABLE PARKING_SPOT
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS (`Lot_name`, `Spot_num`, `Spot_color`);

LOAD DATA LOCAL INFILE 'C:/<Users/ayobamiadereti/Downloads/PARKING_LOT.csv' 
INTO TABLE PERMISSION
FIELDS TERMINATED BY ',' 
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS (`Permit_color`,`Spot_color`);