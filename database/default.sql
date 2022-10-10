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
    letzteverbindungsdatum
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
    'gh59fjdj40fjd1mxbwit',
    'real.cast',
    'Dude gets confused for real.',
    'Tries to change users password',
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