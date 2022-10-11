BEGIN TRANSACTION;

CREATE TABLE IF NOT EXISTS benutzer
(
  id               INT          NOT NULL GENERATED ALWAYS AS IDENTITY UNIQUE,
  benutzername     VARCHAR(30)  NOT NULL UNIQUE,
  passwort         VARCHAR(64)  NOT NULL,
  biografie        VARCHAR(300) NOT NULL DEFAULT '',
  foto             VARCHAR(300) NOT NULL DEFAULT '',    
  istModerator     BOOLEAN      NOT NULL DEFAULT FALSE,
  email            VARCHAR(254) NOT NULL UNIQUE,
  aktivierungslink VARCHAR(64)  NOT NULL UNIQUE,
  istAktiviert     BOOLEAN      NOT NULL DEFAULT FALSE,
  erstellungsdatum TIMESTAMP    NOT NULL,
  letzteverbindungsdatum        TIMESTAMP NOT NULL,
  ipAddresse       INET NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS bewertung
(
  benutzerId INT NOT NULL,
  videoId    INT NOT NULL,
  punktzahl  BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (benutzerId, videoId)
);

CREATE TABLE IF NOT EXISTS kategorie
(
  id           INT          NOT NULL GENERATED ALWAYS AS IDENTITY UNIQUE,
  name         VARCHAR(50)  NOT NULL UNIQUE,
  beschreibung VARCHAR(300) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS kommentar
(
  benutzerId       INT            NOT NULL,
  videoId          INT            NOT NULL,
  erstellungsdatum TIMESTAMP      NOT NULL,
  inhalt           VARCHAR(300)   NOT NULL,
  PRIMARY KEY (benutzerId, videoId, erstellungsdatum)
);

CREATE TABLE IF NOT EXISTS video
(
  id               INT            NOT NULL GENERATED ALWAYS AS IDENTITY UNIQUE,
  sekundaerId      VARCHAR(50)    NOT NULL UNIQUE,
  video            VARCHAR(300)   NOT NULL UNIQUE,
  titel            VARCHAR(50)    NOT NULL,
  dauer            FLOAT          NOT NULL DEFAULT 15.0,
  zuzeigendezeit   FLOAT          NOT NULL DEFAULT 0,
  beschreibung     VARCHAR(300)   NOT NULL DEFAULT '',
  benutzerId       INT            NOT NULL,
  istPrivat        BOOLEAN        NOT NULL DEFAULT FALSE,
  istKommentierbar BOOLEAN        NOT NULL DEFAULT TRUE,
  berechneteBewertung FLOAT       NOT NULL DEFAULT 0,
  erstellungsdatum TIMESTAMP      NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS videokategorie
(
  videoId     INT NOT NULL,
  kategorieId INT NOT NULL,
  PRIMARY KEY (videoId, kategorieId)
);

ALTER TABLE video DROP CONSTRAINT IF EXISTS FK_benutzer_TO_video;
ALTER TABLE video
  ADD CONSTRAINT FK_benutzer_TO_video
    FOREIGN KEY (benutzerId)
    REFERENCES benutzer (id)
    ON DELETE CASCADE;

ALTER TABLE bewertung DROP CONSTRAINT IF EXISTS FK_benutzer_TO_bewertung;
ALTER TABLE bewertung
  ADD CONSTRAINT FK_benutzer_TO_bewertung
    FOREIGN KEY (benutzerId)
    REFERENCES benutzer (id)
    ON DELETE CASCADE;

ALTER TABLE bewertung DROP CONSTRAINT IF EXISTS FK_video_TO_bewertung;
ALTER TABLE bewertung
  ADD CONSTRAINT FK_video_TO_bewertung
    FOREIGN KEY (videoId)
    REFERENCES video (id)
    ON DELETE CASCADE;

ALTER TABLE kommentar DROP CONSTRAINT IF EXISTS FK_benutzer_TO_kommentar;
ALTER TABLE kommentar
  ADD CONSTRAINT FK_benutzer_TO_kommentar
    FOREIGN KEY (benutzerId)
    REFERENCES benutzer (id)
    ON DELETE CASCADE;

ALTER TABLE kommentar DROP CONSTRAINT IF EXISTS FK_video_TO_kommentar;
ALTER TABLE kommentar
  ADD CONSTRAINT FK_video_TO_kommentar
    FOREIGN KEY (videoId)
    REFERENCES video (id)
    ON DELETE CASCADE;

ALTER TABLE videokategorie DROP CONSTRAINT IF EXISTS FK_video_TO_videokategorie;
ALTER TABLE videokategorie
  ADD CONSTRAINT FK_video_TO_videokategorie
    FOREIGN KEY (videoId)
    REFERENCES video (id)
    ON DELETE CASCADE;

ALTER TABLE videokategorie DROP CONSTRAINT IF EXISTS FK_kategorie_TO_videokategorie;
ALTER TABLE videokategorie
  ADD CONSTRAINT FK_kategorie_TO_videokategorie
    FOREIGN KEY (kategorieId)
    REFERENCES kategorie (id)
    ON DELETE CASCADE;

CREATE UNIQUE INDEX IF NOT EXISTS benutzername_benutzer_idx ON benutzer (benutzername);
CREATE UNIQUE INDEX IF NOT EXISTS email_benutzer_idx ON benutzer (email);
CREATE UNIQUE INDEX IF NOT EXISTS aktivierungslink_benutzer_idx ON benutzer (aktivierungslink);

CREATE INDEX IF NOT EXISTS benutzerId_bewertung_idx ON bewertung (benutzerId); 
CREATE INDEX IF NOT EXISTS videoId_bewertung_idx ON bewertung (videoId);

CREATE UNIQUE INDEX IF NOT EXISTS sekundaerId_video_idx ON video (sekundaerId);
CREATE INDEX IF NOT EXISTS beschreibung_video_idx ON video (beschreibung);
CREATE INDEX IF NOT EXISTS titel_video_idx ON video (titel);

CREATE INDEX IF NOT EXISTS benutzerId_video_idx ON video (benutzerId);
CREATE INDEX IF NOT EXISTS erstellungsdatum_video_idx ON video (erstellungsdatum);

CREATE UNIQUE INDEX IF NOT EXISTS name_kategorie_idx ON kategorie (name);

CREATE INDEX IF NOT EXISTS videoId_videokategorie_idx ON videokategorie (videoId);
CREATE INDEX IF NOT EXISTS kategorieId_videokategorie_idx ON videokategorie (kategorieId);

CREATE INDEX IF NOT EXISTS benutzerId_kommentar_idx ON kommentar (benutzerId);
CREATE INDEX IF NOT EXISTS videoId_kommentar_idx ON kommentar (videoId);
CREATE INDEX IF NOT EXISTS erstellungsdatum_kommentar_idx ON kommentar (erstellungsdatum);

COMMIT TRANSACTION;