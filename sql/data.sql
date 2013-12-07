DELETE FROM Trip;
DELETE FROM Airport;
DELETE FROM Departure;
DELETE FROM Arrival;
DELETE FROM FlightLeg;
DELETE FROM Airplane;

INSERT INTO Airplane
   (ID, Type, NumberOfSeats)
VALUES
    (1,  'Boeing 787-8',         335),
    (2,  'Boeing 747-400',       565),
    (3,  'Bombardier CRJ700',    70 ),
    (4,  'Airbus A320',          166)
;


INSERT INTO Airport
   (Code, Name, City, State)
VALUES
   ('JFK', 'John F. Kennedy International Airport', 'New York', 'NY'),
   ('MCO', 'Orlando International Airport', 'Orlando', 'FL'),
   ('ATL', 'Hartsfield-Jackson Atlanta International Airport', 'Atlanta', 'FL'),
   ('CLT', 'Charlotte Douglas International Airport', 'Charlotte', 'NC');

INSERT INTO Trip 
   (TripNumber, Airline, Price, NumLegs, Departure, Destination)
VALUES
   (1, 'Errfoil', 300, 3, 'JFK', 'MCO'),
   (2, 'Errfoil', 350, 3, 'MCO', 'JFK'),

   (3, 'Errfoil', 200, 2, 'JFK', 'MCO'),
   (4, 'Errfoil', 200, 2, 'MCO', 'JFK');

INSERT INTO FlightLeg
(TripNumber, LegNumber, NumSeatsAvailable, TheDate, AirplaneId)
VALUES
(1, 1, 565, '2013-12-07', 2),
(1, 2, 565, '2013-12-07', 2),
(1, 3, 565, '2013-12-07', 2),

(2, 1, 565, '2013-12-08', 2),
(2, 2, 565, '2013-12-08', 2),
(2, 3, 565, '2013-12-08', 2),

(3, 1, 335, '2013-12-07', 1),
(3, 2, 335, '2013-12-07', 1),

(4, 1, 335, '2013-12-07', 1),
(4, 2, 335, '2013-12-07', 1)
;

INSERT INTO Departure
   (AirportCode, ScheduleTime, LegNumberRef, TripNumberRef)
VALUES

   -- JFK to MCO (3 legs)
   ('JFK', '15:00:00', 1, 1),
   ('CLT', '16:15:00', 2, 1),
   ('ATL', '16:45:00', 3, 1),

   -- MCO to JFK (3 legs)
   ('MCO', '12:00:00', 1, 2),
   ('ATL', '13:00:00', 2, 2),
   ('CLT', '13:30:00', 3, 2),

   -- JFK to MCO (2 legs)
   ('JFK', '07:00:00', 1, 3),
   ('CLT', '08:15:00', 2, 3),

   -- MCO to JFK (2 legs)
   ('MCO', '22:00:00', 1, 4),
   ('ATL', '23:00:00', 2, 4)

;
