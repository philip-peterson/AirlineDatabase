CREATE TABLE Arrival (
   AirportCode CHAR(4)
   , ScheduleTime TIMESTAMP
   , LegNumberRef INTEGER
   , TripNumberRef INTEGER
   , PRIMARY KEY (LegNumberRef, TripNumberRef)
);


SELECT ScheduleTime, LegNumberRef, TripNumberRef FROM Departure WHERE DATE(ScheduleTime) BETWEEN ? AND ? AND AirportCode = ?; -- TODO avoid cycles
