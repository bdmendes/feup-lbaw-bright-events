DROP TRIGGER IF EXISTS is_handled_by_admin ON report;
DROP TRIGGER IF EXISTS block_admin_comment ON comment;
DROP TRIGGER IF EXISTS block_admin_poll_vote ON user_poll_option;
DROP TRIGGER IF EXISTS block_admin_attendance ON attendance;
DROP TRIGGER IF EXISTS block_admin_request ON attendance_request;
DROP TRIGGER IF EXISTS block_admin_organizer ON event;
DROP TRIGGER IF EXISTS request_event_type ON attendance_request;
DROP TRIGGER IF EXISTS request_diff_users ON attendance_request;
DROP TRIGGER IF EXISTS voter_is_attendee ON user_poll_option;

DROP VIEW IF EXISTS event_poll;

DROP FUNCTION IF EXISTS is_handled_by_admin;
DROP FUNCTION IF EXISTS block_admin_comment;
DROP FUNCTION IF EXISTS block_admin_poll_vote;
DROP FUNCTION IF EXISTS block_admin_attendance;
DROP FUNCTION IF EXISTS block_admin_request;
DROP FUNCTION IF EXISTS block_admin_organizer;
DROP FUNCTION IF EXISTS request_event_type;
DROP FUNCTION IF EXISTS request_diff_users;
DROP FUNCTION IF EXISTS voter_is_attendee;

DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS user_poll_option;
DROP TABLE IF EXISTS poll_option;
DROP TABLE IF EXISTS poll;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS event_tag;
DROP TABLE IF EXISTS attendance;
DROP TABLE IF EXISTS attendance_request;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS location;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS file;

DROP TYPE IF EXISTS country;
DROP TYPE IF EXISTS gender;
DROP TYPE IF EXISTS event_state;
DROP TYPE IF EXISTS notification_type;
DROP TYPE IF EXISTS report_motive;

CREATE TYPE country AS ENUM ('Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua & Deps', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bhutan', 'Bolivia', 'Bosnia Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Central African Rep', 'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo', 'Congo {Democratic Rep}', 'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland Republic', 'Israel', 'Italy', 'Ivory Coast', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea North', 'Korea South', 'Kosovo', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique', 'Myanmar, {Burma}', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Qatar', 'Romania', 'Russian Federation', 'Rwanda', 'St Kitts & Nevis', 'St Lucia', 'Saint Vincent & the Grenadines', 'Samoa', 'San Marino', 'Sao Tome & Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Sudan', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tonga', 'Trinidad & Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe');
CREATE TYPE gender AS ENUM ('Male', 'Female', 'Other');
CREATE TYPE event_state AS ENUM ('Cancelled', 'Finished', 'On-going', 'Due');
CREATE TYPE notification_type AS ENUM ('Disabled event', 'Cancelled event', 'Join request', 'Accepted request', 'Declined request', 'Invite', 'Accepted invite', 'Declined invite', 'New comment', 'New poll', 'Poll closed');
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
    bio TEXT,
    birth_date DATE CHECK (birth_date < CURRENT_DATE),
    is_blocked BOOLEAN NOT NULL DEFAULT FALSE,
    gender gender NOT NULL,
    profile_picture INTEGER REFERENCES file ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE event (
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description VARCHAR(1000),
    date TIMESTAMP NOT NULL,
    is_private BOOLEAN NOT NULL,
    is_disabled BOOLEAN NOT NULL DEFAULT FALSE,
    event_state event_state NOT NULL,
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
    id SERIAL PRIMARY KEY,
    event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE, 
    addressee INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE,
    is_accepted BOOLEAN DEFAULT FALSE NOT NULL,
    is_invite BOOLEAN NOT NULL
);

CREATE TABLE poll (
    id SERIAL PRIMARY KEY,
    event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    creator INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE,
    title TEXT NOT NULL,
    description VARCHAR(1000) NOT NULL,
    date TIMESTAMP DEFAULT NOW(),
    is_open BOOLEAN DEFAULT TRUE
);

CREATE TABLE poll_option (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    poll INTEGER REFERENCES poll ON DELETE CASCADE ON UPDATE CASCADE NOT NULL
);

CREATE TABLE user_poll_option (
    voter INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE,
    poll_option INTEGER REFERENCES poll_option ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    commenter INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE,
    parent INTEGER REFERENCES comment ON DELETE CASCADE ON UPDATE CASCADE,
    body TEXT, 
    date TIMESTAMP DEFAULT NOW() NOT NULL
);

CREATE TABLE notification (
    id SERIAL PRIMARY KEY,
    date TIMESTAMP DEFAULT NOW() NOT NULL,
    notification_type notification_type NOT NULL,
    is_seen BOOLEAN DEFAULT FALSE NOT NULL,
    event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    attendance_request INTEGER REFERENCES attendance_request ON DELETE CASCADE ON UPDATE CASCADE,
    poll INTEGER REFERENCES poll ON DELETE CASCADE ON UPDATE CASCADE,
    comment INTEGER REFERENCES comment ON DELETE CASCADE ON UPDATE CASCADE,
    addressee INTEGER REFERENCES users ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    CONSTRAINT single_reference CHECK ((attendance_request IS NOT NULL AND event IS NULL AND comment IS NULL) OR (attendance_request IS NULL AND event IS NOT NULL AND comment IS NULL) OR (attendance_request IS NULL AND event IS NULL AND comment IS NOT NULL))
);

CREATE TABLE report (
    id SERIAL PRIMARY KEY,
    date TIMESTAMP DEFAULT NOW(),
    description VARCHAR(1000),
    report_motive report_motive NOT NULL,
    handled_by INTEGER REFERENCES users ON DELETE SET NULL ON UPDATE CASCADE, 
    reported_event INTEGER REFERENCES event ON DELETE CASCADE ON UPDATE CASCADE, 
    reported_user INTEGER REFERENCES users ON DELETE CASCADE ON UPDATE CASCADE,
    reported_comment INTEGER REFERENCES comment ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT single_reference CHECK ((reported_event IS NOT NULL AND reported_user IS NULL AND reported_comment IS NULL) OR (reported_event IS NULL AND reported_user IS NOT NULL AND reported_comment IS NULL) OR (reported_event IS NULL AND reported_user IS NULL AND reported_comment IS NOT NULL))
);

-------------------------------------------------
-------------------- Views --------------------
-------------------------------------------------

CREATE VIEW event_poll AS
(SELECT poll.id AS poll_id, event 
FROM poll JOIN event ON (poll.event = event.id));

------------------------------------------------------
-------------------- Functions --------------------
------------------------------------------------------

CREATE FUNCTION is_handled_by_admin() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.handled_by IS NOT NULL THEN
        IF NOT EXISTS (SELECT * FROM users WHERE id = NEW.handled_by AND is_admin = TRUE) THEN
            RAISE EXCEPTION 'A report can only be handled by a user.';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION block_admin_comment() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.commenter IS NOT NULL THEN
        IF EXISTS (SELECT * FROM users WHERE id = NEW.commenter AND is_admin = TRUE) THEN 
            RAISE EXCEPTION 'Admins cannot write comments';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION block_admin_poll_vote() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.voter IS NOT NULL THEN
        IF EXISTS (SELECT * FROM users WHERE id = NEW.voter AND is_admin = TRUE) THEN 
            RAISE EXCEPTION 'Admins cannot vote in polls';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION block_admin_attendance() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.attendee IS NOT NULL THEN
        IF EXISTS (SELECT * FROM users WHERE id = NEW.attendee AND is_admin = TRUE) THEN 
            RAISE EXCEPTION 'Admins cannot attend events';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION block_admin_request() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.addressee IS NOT NULL THEN
        IF EXISTS (SELECT * FROM users WHERE id = NEW.addressee AND is_admin = TRUE) THEN 
            RAISE EXCEPTION 'Admins cannot be the recipient of requests';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION block_admin_organizer() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.organizer IS NOT NULL THEN
        IF EXISTS (SELECT * FROM users WHERE id = NEW.organizer AND is_admin = TRUE) THEN 
            RAISE EXCEPTION 'Admins cannot be organizers';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION request_event_type() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.event IS NOT NULL THEN
        IF EXISTS (SELECT e.* FROM event e WHERE id = NEW.event AND e.event_state <> 'Due' AND e.event_state <> 'On-going') THEN 
            RAISE EXCEPTION 'Requests can only be sent for due or on-going events';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION request_diff_users() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.addressee IS NOT NULL THEN
        IF EXISTS (SELECT * FROM event WHERE organizer = NEW.addressee AND id = NEW.event) THEN
            RAISE EXCEPTION 'Requests for a certain event can not be sent to the organizer of that same event'; 
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION voter_is_attendee() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.voter IS NOT NULL THEN
        IF NOT EXISTS (SELECT * 
        FROM event_poll JOIN attendance a ON (event_poll.event = a.event)
                        JOIN poll_option po ON (po.poll = event_poll.poll_id) 
        WHERE po.id = NEW.poll_option AND attendee = NEW.voter) THEN
            RAISE EXCEPTION 'A poll voter must attend the event related to the poll';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

----------------------------------------------------
-------------------- Triggers --------------------
----------------------------------------------------

CREATE TRIGGER is_handled_by_admin
    BEFORE INSERT OR UPDATE ON report
    FOR EACH ROW
    EXECUTE PROCEDURE is_handled_by_admin();

CREATE TRIGGER block_admin_comment
    BEFORE INSERT OR UPDATE ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE block_admin_comment();

CREATE TRIGGER block_admin_poll_vote
    BEFORE INSERT OR UPDATE ON user_poll_option
    FOR EACH ROW
    EXECUTE PROCEDURE block_admin_poll_vote();

CREATE TRIGGER block_admin_attendance
    BEFORE INSERT OR UPDATE ON attendance
    FOR EACH ROW
    EXECUTE PROCEDURE block_admin_attendance();

CREATE TRIGGER block_admin_request
    BEFORE INSERT OR UPDATE ON attendance_request
    FOR EACH ROW
    EXECUTE PROCEDURE block_admin_request();

CREATE TRIGGER block_admin_organizer
    BEFORE INSERT OR UPDATE ON event
    FOR EACH ROW
    EXECUTE PROCEDURE block_admin_organizer();

CREATE TRIGGER request_event_type
    BEFORE INSERT OR UPDATE ON attendance_request
    FOR EACH ROW
    EXECUTE PROCEDURE request_event_type();

CREATE TRIGGER request_diff_users
    BEFORE INSERT OR UPDATE ON attendance_request
    FOR EACH ROW
    EXECUTE PROCEDURE request_diff_users();

CREATE TRIGGER voter_is_attendee
    BEFORE INSERT OR UPDATE ON user_poll_option
    FOR EACH ROW
    EXECUTE PROCEDURE voter_is_attendee();
