/*AWARD ISA HIERARCHY*/

CREATE TABLE Award (
	award_id varchar(5) unique,
	year int,
	PRIMARY KEY(award_id));

CREATE TABLE Artist_Award(
	award_id varchar(5) unique,
	artist_title varchar(50),
	winner_artist varchar(50),
	PRIMARY KEY(award_id),
	FOREIGN KEY(award_id) REFERENCES Award(award_id)
);

CREATE TABLE Art_Award(
	award_id varchar(5) unique,
	PRIMARY KEY(award_id),
	FOREIGN KEY(award_id) REFERENCES Award(award_id)
);

/*ART AWARD ISA HIERARCHY*/

CREATE TABLE Visual_Award(
  	award_id varchar(5) unique,
  	winner_visual varchar(50),
  	visual_title varchar(50),
  	PRIMARY KEY (award_id),
  	FOREIGN KEY(award_id) REFERENCES Art_Award(award_id)
);

CREATE TABLE Song_Award(
  	award_id varchar(5) unique,
  	winner_song varchar(50),
  	song_prize varchar(50),
  	PRIMARY KEY (award_id),
  	FOREIGN KEY(award_id) REFERENCES Art_Award(award_id)
);

CREATE TABLE Album_Award(
  	award_id varchar(5) unique,
  	winner_album varchar(50),
  	album_prize varchar(50),
  	PRIMARY KEY (award_id),
  	FOREIGN KEY(award_id) REFERENCES Art_Award(award_id)
);


/* MUSIC ISA HIERARCHY*/

CREATE TABLE Music(
   music_id INTEGER,
   version varchar(50),
   genre varchar(50),
   language varchar(50),
   PRIMARY KEY(music_id)
);

CREATE TABLE Song(
   song_id int unique,
   song_title varchar(20),
   is_winner_song bool,
   PRIMARY KEY (song_id),
   FOREIGN KEY(song_id) REFERENCES Music(music_id)
);

CREATE TABLE Album(
   album_id int unique,
   album_title varchar(20),
   is_winner_album bool,
   PRIMARY KEY (album_id),
   FOREIGN KEY(album_id) REFERENCES Music(music_id)
);

/*ARTIST ISA HIERARCHY*/

CREATE TABLE Artist(
   artist_id INTEGER,
   is_winner_artist bool,
   PRIMARY KEY(artist_id)
);

CREATE TABLE Band(
   band_id int unique,
   members_number int,
   band_name varchar(20),
   PRIMARY KEY (band_id),
   FOREIGN KEY(band_id) REFERENCES Artist(artist_id)
);

CREATE TABLE Singer(
   singer_id int unique,
   name varchar(20),
   surname varchar(20),
   PRIMARY KEY (singer_id),
   FOREIGN KEY(singer_id) REFERENCES Artist(artist_id)
);

/*RELATIONSHIPS*/

CREATE TABLE RECEIVES(
	artist_id int unique,
	award_id varchar(5) unique,
	PRIMARY KEY(award_id, artist_id),
	FOREIGN KEY(award_id) REFERENCES Artist_Award(award_id),
	FOREIGN KEY(artist_id) REFERENCES Artist(artist_id)
);

CREATE TABLE WON_BY(
	song_id int unique,
  	award_id varchar(5) unique,
  	PRIMARY KEY (song_id, award_id),
  	FOREIGN KEY (song_id) REFERENCES Song(song_id),
  	FOREIGN KEY (award_id) REFERENCES Song_Award(award_id)
);

CREATE TABLE BELONGS_TO(
	album_id int unique,
  	award_id varchar(5) unique,
  	PRIMARY KEY (album_id, award_id),
  	FOREIGN KEY (album_id) REFERENCES Album(album_id),
  	FOREIGN KEY (award_id) REFERENCES Album_Award(award_id)
);

CREATE TABLE GETS(
  	artist_id int unique,
   	award_id varchar(5) unique,
   	PRIMARY KEY (artist_id, award_id),
  	FOREIGN KEY (artist_id) REFERENCES Artist(artist_id),
  	FOREIGN KEY (award_id) REFERENCES Visual_Award(award_id)
);

CREATE TABLE CREATES(
   	artist_id int unique,
   	music_id int unique,
   	PRIMARY KEY (artist_id, music_id),
   	FOREIGN KEY (artist_id) REFERENCES Artist(artist_id),
   	FOREIGN KEY (music_id) REFERENCES Music(music_id)
);


