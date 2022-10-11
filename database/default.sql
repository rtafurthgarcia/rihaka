INSERT INTO benutzer (
    benutzername,
    biografie,
    foto,
    passwort,
    istModerator,
    email,
    aktivierungslink,
    istAktiviert,
    erstellungsdatum,
    letzteverbindungsdatum,
    ipAddresse
)
VALUES (
    'RIHAKA',
    'We do a little trollin',
    '',
    '',
    true,
    'rihaka@hftm.ch',
    '',
    true,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP,
    '127.0.0.1'
  );

INSERT INTO video (
    sekundaerid,
    video,
    titel,
    beschreibung,
    dauer,
    benutzerid,
    istprivat,
    
    istkommentierbar,
    erstellungsdatum
)
VALUES (
    'gh59fjdj40fjd1mxbwit',
    'real.cast',
    'Dude gets confused for real.',
    'Tries to change users password',
    40.830768,
    1,
    false,
    false,
    CURRENT_TIMESTAMP
  );

INSERT INTO kategorie (
    name,
    beschreibung
)
VALUES (
    'elite',
    ''
);

INSERT INTO kategorie (
    name,
    beschreibung
)
VALUES (
    'scriptkiddie',
    ''
);

INSERT INTO kategorie (
    name,
    beschreibung
)
VALUES (
    'botnet',
    ''
);

INSERT INTO kategorie (
    name,
    beschreibung
)
VALUES (
    'cringe',
    ''
);