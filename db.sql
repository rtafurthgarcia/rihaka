
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

COMMENT ON TABLE bewertung IS 'benutzer + video = muss nur ein einzige Bewertung geben pro Benutzer';

COMMENT ON COLUMN bewertung.videoId IS 'Andere Entitäten mit Video u verknüpfen';

COMMENT ON COLUMN bewertung.punktzahl IS 'geht von 1 bis 5';

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

COMMENT ON TABLE kommentar IS 'benutzer + video + datum = ein benutzer kann mehrere Kommentare hochladen';

COMMENT ON COLUMN kommentar.videoId IS 'Andere Entitäten mit Video u verknüpfen';

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

COMMENT ON COLUMN video.id IS 'Andere Entitäten mit Video u verknüpfen';

COMMENT ON COLUMN video.sekundaerId IS 'Benutzer mit video zu verknüpfen';

COMMENT ON COLUMN video.video IS 'Video wird ausserhalb der DB gespeichert';

CREATE TABLE videokategorie
(
  videoId     NUMBER(6) NOT NULL,
  kategorieId NUMBER(6) NOT NULL,
  PRIMARY KEY (videoId, kategorieId)
);

COMMENT ON COLUMN videokategorie.videoId IS 'Andere Entitäten mit Video u verknüpfen';

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
