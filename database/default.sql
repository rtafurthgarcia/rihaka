INSERT INTO benutzer (
    benutzername,
    name,
    vorname,
    passwort,
    istModerator,
    email,
    aktivierungslink,
    isactivated,
    erstellungsdatum,
    letzteverbindungsdatum
)
VALUES (
    'RIHAKA',
    '',
    '',
    '',
    true,
    'rihaka@hftm.ch',
    '',
    true,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
  );

INSERT INTO video (
    sekundaerid,
    video,
    titel,
    beschreibung,
    benutzerid,
    istprivat,
    istkommentierbar,
    erstellungsdatum
)
VALUES (
    generateSecondaryVideoId(),
    'real.cast',
    'Dude gets confused for real.',
    'Tries to change users password',
    1,
    false,
    false,
    CURRENT_TIMESTAMP
  );