
CREATE TABLE benutzer
(
  id               NUMBER(6)    NOT NULL GENERATED ALWAYS AS IDENTITY UNIQUE,
  benutzername     VARCHAR2(30) NOT NULL UNIQUE,
  name             VARCHAR2(50) NOT NULL,
  vorname          VARCHAR2(50) NOT NULL,
  passwort         VARCHAR2(64) NOT NULL,
  isModerator      NUMBER(1)    NOT NULL DEFAULT 0,
  email            VARCHAR2(50) NOT NULL UNIQUE,
  aktivierungslink VARCHAR2(64) NOT NULL UNIQUE,
  isActivated      NUMBER(1)    DEFAULT 0,
  erstellungsdatum DATETIME     NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE bewertung
(
  benutzerId NUMBER(6) NOT NULL,
  videoId    NUMBER(6) NOT NULL,
  punktzahl  NUMBER(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (benutzerId, videoId)
);

CREATE TABLE kategorie
(
  id           NUMBER(6)     NOT NULL GENERATED ALWAYS AS IDENTITY UNIQUE,
  name         VARCHAR2(50)  NOT NULL UNIQUE,
  beschreibung VARCHAR2(300) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE kommentar
(
  benutzerId       NUMBER(6)     NOT NULL,
  videoId          NUMBER(6)     NOT NULL,
  erstellungsdatum DATETIME      NOT NULL,
  inhalt           VARCHAR2(300) NOT NULL,
  PRIMARY KEY (benutzerId, videoId, erstellungsdatum)
);

CREATE TABLE video
(
  id               NUMBER(6)     NOT NULL GENERATED ALWAYS AS IDENTITY UNIQUE,
  sekundaerId      NUMBER(6)     NOT NULL UNIQUE,
  video            VARCHAR2(300) NOT NULL UNIQUE,
  titel            VARCHAR2(50)  NOT NULL,
  beschreibung     VARCHAR2(300),
  benutzerId       NUMBER(6)     NOT NULL,
  istPrivat        NUMBER(1)     NOT NULL DEFAULT 0,
  istKommentierbar NUMMBER(1)    NOT NULL DEFAULT 1,
  erstellungsdatum DATETIME      NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE videokategorie
(
  videoId     NUMBER(6) NOT NULL,
  kategorieId NUMBER(6) NOT NULL,
  PRIMARY KEY (videoId, kategorieId)
);

ALTER TABLE video
  ADD CONSTRAINT FK_benutzer_TO_video
    FOREIGN KEY (benutzerId)
    REFERENCES benutzer (id)
    ON DELETE CASCADE;

ALTER TABLE bewertung
  ADD CONSTRAINT FK_benutzer_TO_bewertung
    FOREIGN KEY (benutzerId)
    REFERENCES benutzer (id)
    ON DELETE CASCADE;

ALTER TABLE bewertung
  ADD CONSTRAINT FK_video_TO_bewertung
    FOREIGN KEY (videoId)
    REFERENCES video (id)
    ON DELETE CASCADE;

ALTER TABLE kommentar
  ADD CONSTRAINT FK_benutzer_TO_kommentar
    FOREIGN KEY (benutzerId)
    REFERENCES benutzer (id)
    ON DELETE CASCADE;

ALTER TABLE kommentar
  ADD CONSTRAINT FK_video_TO_kommentar
    FOREIGN KEY (videoId)
    REFERENCES video (id)
    ON DELETE CASCADE;

ALTER TABLE videokategorie
  ADD CONSTRAINT FK_video_TO_videokategorie
    FOREIGN KEY (videoId)
    REFERENCES video (id)
    ON DELETE CASCADE;

ALTER TABLE videokategorie
  ADD CONSTRAINT FK_kategorie_TO_videokategorie
    FOREIGN KEY (kategorieId)
    REFERENCES kategorie (id)
    ON DELETE CASCADE;

CREATE UNIQUE INDEX benutzername_benutzer_idx ON benutzer (benutzername);
CREATE UNIQUE INDEX email_benutzer_idx ON benutzer (email);
CREATE UNIQUE INDEX aktivierungslink_benutzer_idx ON benutzer (aktivierungslink);

CREATE INDEX benutzerId_bewertung_idx ON bewertung (benutzerId); 
CREATE INDEX videoId_bewertung_idx ON bewertung (videoId);

CREATE UNIQUE INDEX sekundaerId_video_idx ON video (sekundaerId);
CREATE UNIQUE INDEX beschreibung_video_idx ON video (beschreibung);
CREATE UNIQUE INDEX titel_video_idx ON video (titel);

CREATE INDEX benutzerId_video_idx ON video (benutzerId);
CREATE INDEX erstellungsdatum_video_idx ON video (erstellungsdatum);

CREATE UNIQUE INDEX name_kategorie_idx ON kategorie (name);

CREATE INDEX videoId_videokategorie_idx ON videokategorie (videoId);
CREATE INDEX kategorieId_videokategorie_idx ON videokategorie (kategorie);

CREATE INDEX benutzerId_kommentar_idx ON kommentar (benutzerId);
CREATE INDEX videoId_kommentar_idx ON kommentar (videoId);
CREATE INDEX erstellungsdatum_kommentar_idx ON kommentar (erstellungsdatum);

-- Can only be 0 or 1, since it represents a boolean value
ALTER TABLE video
  ADD CONSTRAINT CHK_istPrivat CHECK (istPrivat IN (0, 1));

-- Can only be 0 or 1, since it represents a boolean value
ALTER TABLE video
  ADD CONSTRAINT CHK_istKommentierbar CHECK (istKommentierbar IN (0, 1));