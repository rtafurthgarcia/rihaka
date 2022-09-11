CREATE TABLE benutzer
(
  id               INT          NOT NULL GENERATED ALWAYS AS IDENTITY UNIQUE,
  benutzername     VARCHAR(30)  NOT NULL UNIQUE,
  name             VARCHAR(50)  NOT NULL,
  vorname          VARCHAR(50)  NOT NULL,
  passwort         VARCHAR(64)  NOT NULL,
  isModerator      BOOLEAN      NOT NULL DEFAULT FALSE,
  email            VARCHAR(50)  NOT NULL UNIQUE,
  aktivierungslink VARCHAR(64)  NOT NULL UNIQUE,
  isActivated      BOOLEAN      DEFAULT FALSE,
  erstellungsdatum TIMESTAMP    NOT NULL,
  letzteverbindungsdatum        TIMESTAMP,
  ipAddresse       INET,
  PRIMARY KEY (id)
);

CREATE TABLE bewertung
(
  benutzerId INT NOT NULL,
  videoId    INT NOT NULL,
  punktzahl  BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (benutzerId, videoId)
);

CREATE TABLE kategorie
(
  id           INT          NOT NULL GENERATED ALWAYS AS IDENTITY UNIQUE,
  name         VARCHAR(50)  NOT NULL UNIQUE,
  beschreibung VARCHAR(300) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE kommentar
(
  benutzerId       INT            NOT NULL,
  videoId          INT            NOT NULL,
  erstellungsdatum TIMESTAMP      NOT NULL,
  inhalt           VARCHAR(300)   NOT NULL,
  PRIMARY KEY (benutzerId, videoId, erstellungsdatum)
);

CREATE TABLE video
(
  id               INT            NOT NULL GENERATED ALWAYS AS IDENTITY UNIQUE,
  sekundaerId      INT            NOT NULL UNIQUE,
  video            VARCHAR(300)   NOT NULL UNIQUE,
  titel            VARCHAR(50)    NOT NULL,
  beschreibung     VARCHAR(300),
  benutzerId       INT            NOT NULL,
  istPrivat        BOOLEAN        NOT NULL DEFAULT FALSE,
  istKommentierbar BOOLEAN        NOT NULL DEFAULT TRUE,
  erstellungsdatum TIMESTAMP      NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE videokategorie
(
  videoId     INT NOT NULL,
  kategorieId INT NOT NULL,
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
CREATE INDEX kategorieId_videokategorie_idx ON videokategorie (kategorieId);

CREATE INDEX benutzerId_kommentar_idx ON kommentar (benutzerId);
CREATE INDEX videoId_kommentar_idx ON kommentar (videoId);
CREATE INDEX erstellungsdatum_kommentar_idx ON kommentar (erstellungsdatum);