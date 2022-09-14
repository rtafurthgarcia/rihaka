)INSERT INTO benutzer (
    benutzername,
    name,
    vorname,
    passwort,
    ismoderator,
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