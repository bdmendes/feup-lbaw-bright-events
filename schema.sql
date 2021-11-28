CREATE TYPE country AS ENUM ('Albania', 'Portugal');
CREATE TYPE gender AS ENUM ('Male', 'Female', 'Other');
CREATE TYPE event_state AS ENUM ('Cancelled', 'Finished', 'On-going', 'Due');
CREATE TYPE notification_type AS ENUM ('Disabled event', 'Cancelled event', 'Join request', 'Accepted request', 'Declined request', 'Invite', 'Accepted invite', 'Declined Invite', 'New comment', 'New poll', 'Poll closed');
CREATE TYPE report_motive AS ENUM ('Sexual harassment', 'Violence or bodily harm', 'Nudity or explicit content', 'Hate speech', 'Other');

CREATE TABLE file (
    id SERIAL PRIMARY KEY,
    path TEXT UNIQUE NOT NULL,
    name TEXT NOT NULL
);

CREATE TABLE location (
    id SERIAL PRIMARY KEY,
    address TEXT NOT NULL,
    city TEXT NOT NULL,
    coords TEXT NOT NULL,
    name TEXT,
    TYPE Country NOT NULL
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email TEXT UNIQUE NOT NULL,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    name TEXT NOT NULL,
    is_admin BOOLEAN NOT NULL,
    birth_date DATETIME < CURRENT_DATE,
    is_blocked BOOLEAN NOT NULL DEFAULT FALSE,
    TYPE gender NOT NULL,
    profile_picture INTEGER REFERENCES file ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE event (
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT,
    date DATETIME NOT NULL,
    is_private BOOLEAN NOT NULL,
    is_disabled BOOLEAN NOT NULL DEFAULT FALSE,
    TYPE event_state NOT NULL,
    cover_image INTEGER REFERENCES file ON DELETE SET NULL ON UPDATE CASCADE,
    organizer INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE,
    location INTEGER REFERENCES location ON DELETE SET NULL ON UPDATE CASCADE 
);

CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    name TEXT UNIQUE NOT NULL
);

CREATE TABLE event_tag (
    event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    tag INTEGER REFERENCES tag ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    PRIMARY KEY (event, tag)
);

CREATE TABLE attendance (
    event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE,
    attendee INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE,
    PRIMARY KEY (event, attendee)
);

CREATE TABLE attendance_request (
    id SERIAL PRIMERY KEY,
    event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE, 
    users INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE,
    is_accepted BOOLEAN DEFAULT FALSE NOT NULL,
    is_invite BOOLEAN NOT NULL
);

CREATE TABLE poll (
    id SERIAL PRIMARY KEY,
    event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    creator INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    date DATETIME DEFAULT NOW(),
    is_open BOOLEAN DEFAULT TRUE
);

CREATE TABLE poll_option (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    poll INTEGER REFERENCES poll ON DELETE CASCADE ON UPDATE CASCADE NOT NULL
);

CREATE TABLE user_poll_option (
    users INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE,
    poll_option INTEGER REFERENCES poll_option ON DELETE CASCADE ON UPDATE 
);

CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    users INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE,
    body TEXT, 
    date DATETIME DEFAULT NOW() NOT NULL
);

CREATE TABLE notification (
    id SERIAL PRIMARY KEY,
    date DATETIME DEFAULT NOW() NOT NULL,
    TYPE notification_type NOT NULL,
    is_seen BOOLEAN DEFAULT FALSE NOT NULL,
    event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    attendance_request INTEGER REFERENCES attendance_request ON DELETE CASCADE ON UPDATE CASCADE,
    poll INTEGER REFERENCES poll ON DELETE CASCADE ON UPDATE CASCADE,
    comment INTEGER REFERENCES comment ON DELETE CASCADE ON UPDATE CASCADE,
    users INTEGER REFERENCES users ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    CONSTRAINT single_reference CHECK ((attendance_request IS NOT NULL AND event IS NULL AND comment IS NULL) OR (attendance_request IS NULL AND event IS NOT NULL AND comment IS NULL) OR (attendance_request IS NULL AND event IS NULL AND comment IS NOT NULL))
);

CREATE TABLE report (
    id SERIAL PRIMARY KEY,
    date DATETIME DEFAULT NOW(),
    description TEXT,
    TYPE report_motive NOT NULL,
    handled_by INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE, 
    reported_event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE, 
    reported_user INTEGER REFERENCES users ON DELETE CASCADE ON UPDATE CASCADE,
    reported_comment INTEGER REFERENCES comment ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT single_reference CHECK ((reported_event IS NOT NULL AND reported_user IS NULL AND reported_comment IS NULL) OR (reported_event IS NULL AND reported_user IS NOT NULL AND reported_comment IS NULL) OR (reported_event IS NULL AND reported_user IS NULL AND reported_comment IS NOT NULL))
)