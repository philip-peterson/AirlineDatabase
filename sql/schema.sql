DROP DATABASE IF EXISTS Airline;
CREATE DATABASE Airline;
USE Airline;

-- ************************************************************************************
-- *  Schema
-- ************************************************************************************

CREATE TABLE Airport (
  Code CHAR(3) PRIMARY KEY
  , Name VARCHAR(70)
  , City CHAR(40)
  , State CHAR(2)
);

CREATE TABLE Airplane (
  Id INTEGER PRIMARY KEY
  , Type VARCHAR(30)
  , NumberOfSeats INTEGER
);

CREATE TABLE Arrival (
   AirportCode CHAR(4)
   , ScheduleTime TIMESTAMP
   , LegNumberRef INTEGER
   , TripNumberRef INTEGER
   , PRIMARY KEY (LegNumberRef, TripNumberRef)
);

CREATE TABLE Departure LIKE Arrival;

CREATE TABLE Trip (
   TripNumber INTEGER PRIMARY KEY
   , Airline VARCHAR(60)
   , Price DECIMAL(6,2)
   , NumLegs INTEGER
   , Departure CHAR(3)
   , Destination CHAR(3)
);

CREATE TABLE Reservation (
   ReservationNum INTEGER PRIMARY KEY
   , Email VARCHAR(40)
   , Name VARCHAR(100)
   , Addr VARCHAR(150)
   , PhoneNum VARCHAR(20)
   , ReserveDate DATE
);

CREATE TABLE FlightLeg (
   TripNumber INTEGER
   , LegNumber INTEGER
   , NumSeatsAvailable INTEGER
   , TheDate DATE
   , AirplaneId INTEGER
   , PRIMARY KEY (TripNumber, LegNumber)
);

CREATE TABLE Payment (
   TransactionNumber INTEGER PRIMARY KEY
   , PaymentDate DATE
   , Account DECIMAL(20,0)
   , NameOnAccount VARCHAR(100)
   , ReservRef INTEGER
   , TripRef INTEGER
);

-- ************************************************************************************
-- *  Constraints
-- ************************************************************************************

ALTER TABLE Arrival
   ADD CONSTRAINT fk_AirportCode_Arrival
      FOREIGN KEY (AirportCode)
         REFERENCES Airport (Code)
         -- ON DELETE RESTRICT (Oracle's default -- doesn't allow explicit)
         -- ON UPDATE NO ACTION (default)
         ;
ALTER TABLE Departure
   ADD CONSTRAINT fk_AirportCode_Departure
      FOREIGN KEY (AirportCode)
         REFERENCES Airport (Code)
         -- ON DELETE RESTRICT (Oracle's default -- doesn't allow explicit)
         -- ON UPDATE NO ACTION (default)
         ;

ALTER TABLE Trip
   ADD CONSTRAINT fk_Departure
      FOREIGN KEY (Departure)
         REFERENCES Airport (Code)
         -- ON DELETE RESTRICT (Oracle's default -- doesn't allow explicit)
         -- ON UPDATE NO ACTION (default)
         ;

ALTER TABLE Trip
   ADD CONSTRAINT fk_Destination
      FOREIGN KEY (Destination)
         REFERENCES Airport (Code)
         -- ON DELETE RESTRICT (Oracle's default -- doesn't allow explicit)
         -- ON UPDATE NO ACTION (default)
         ;

ALTER TABLE FlightLeg
   ADD CONSTRAINT fk_TripNum
      FOREIGN KEY (TripNumber)
         REFERENCES Trip (TripNumber)
         ON DELETE CASCADE
         -- ON UPDATE NO ACTION (default)
         ;

ALTER TABLE FlightLeg
   ADD CONSTRAINT fk_LegNum
      FOREIGN KEY (AirplaneId)
         REFERENCES Airplane (Id)
         -- ON DELETE RESTRICT (Oracle's default -- doesn't allow explicit)
         -- ON UPDATE NO ACTION (default)
         ;

ALTER TABLE Airplane
   ADD CONSTRAINT NonNegativeSeats
      CHECK (
         NumberOfSeats >= 0
      );

ALTER TABLE FlightLeg
   ADD CONSTRAINT PositiveLegNum
      CHECK (
         LegNumber >= 1
      );

ALTER TABLE Airport
   ADD CONSTRAINT Valid_State
   CHECK (
      State IN (
         'AL' , 'AK' , 'AZ' , 'AR' , 'CA' , 'CO' , 'CT' , 'DE' , 'DC' , 'FL' , 'GA' , 'HI' , 'ID' , 'IL' , 'IN' , 'IA' , 'KS' , 'KY' , 'LA' , 'ME' , 'MD' , 'MA' , 'MI' , 'MN' , 'MS' , 'MO' , 'MT' , 'NE' , 'NV' , 'NH' , 'NJ' , 'NM' , 'NY' , 'NC' , 'ND' , 'OH' , 'OK' , 'OR' , 'PA' , 'RI' , 'SC' , 'SD' , 'TN' , 'TX' , 'UT' , 'VT' , 'VA' , 'WA' , 'WV' , 'WI' , 'WY'
      )
   );
