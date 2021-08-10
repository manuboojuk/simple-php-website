-- drop table appuser cascade;

create table appuser (
	userid varchar(50) primary key,
	password varchar(100),
	gender varchar(10),
	age numeric,
	uoftstudent boolean,
	pizzapref boolean,
	guessgamewins numeric,
	rockpaperscissorswins numeric,
	frogswins numeric
);

/*
'auser' is a non-hashed user for games00-09 ideally this line shouldnt be here. 
DO NOT use 'auser' and 'apassword' to use the games website, rather make an 
account to play on games.
*/
insert into appuser values('auser', 'apassword', 'Male', 20, true, true, 0, 0, 0);



