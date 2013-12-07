DELETE FROM Trip;
DELETE FROM Airport;

INSERT INTO Airplane
   (ID, Type, NumberOfSeats)
VALUES
    (1,  'Boeing 787-8',         335),
    (2,  'Boeing 747-400',       565),
    (3,  'Bombardier CRJ700',    70 ),
    (4,  'Airbus A320',          166)
;


INSERT INTO Airport (Code, Name, City, State)
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
(1, 1, );

INSERT INTO Departure
(AirportCode, ScheduleTime, LegNumberRef, TripNumberRef);

