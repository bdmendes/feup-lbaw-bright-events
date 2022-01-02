-------------------------------------------------
--------------- Clear database ------------------
-------------------------------------------------

DROP SCHEMA IF EXISTS lbaw2134 CASCADE;

CREATE SCHEMA IF NOT EXISTS lbaw2134;

CREATE TYPE lbaw2134.country AS ENUM ('Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua & Deps', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bhutan', 'Bolivia', 'Bosnia Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Central African Rep', 'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo', 'Congo {Democratic Rep}', 'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland Republic', 'Israel', 'Italy', 'Ivory Coast', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea North', 'Korea South', 'Kosovo', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique', 'Myanmar, {Burma}', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Qatar', 'Romania', 'Russian Federation', 'Rwanda', 'St Kitts & Nevis', 'St Lucia', 'Saint Vincent & the Grenadines', 'Samoa', 'San Marino', 'Sao Tome & Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Sudan', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tonga', 'Trinidad & Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe');
CREATE TYPE lbaw2134.gender AS ENUM ('Male', 'Female', 'Other');
CREATE TYPE lbaw2134.event_state AS ENUM ('cancelled', 'finished', 'on-going', 'due');
CREATE TYPE lbaw2134.notification_type AS ENUM ('Disabled event', 'Cancelled event', 'Join request', 'Accepted request', 'Declined request', 'Invite', 'Accepted invite', 'Declined invite', 'New comment', 'New poll', 'Closed Poll');
CREATE TYPE lbaw2134.report_motive AS ENUM ('Sexual harassment', 'Violence or bodily harm', 'Nudity or explicit content', 'Hate speech', 'Other');

-------------------------------------------------
-------------------- Tables ---------------------
-------------------------------------------------

CREATE TABLE lbaw2134.files (
    id SERIAL PRIMARY KEY,
    path TEXT UNIQUE NOT NULL,
    name TEXT NOT NULL
);

CREATE TABLE lbaw2134.locations (
    id SERIAL PRIMARY KEY,
    address TEXT NOT NULL,
    city TEXT NOT NULL,
    coords TEXT NOT NULL,
    name TEXT,
    country lbaw2134.Country NOT NULL
);

CREATE TABLE lbaw2134.users (
    id SERIAL PRIMARY KEY,
    email TEXT UNIQUE NOT NULL,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    name TEXT NOT NULL,
    is_admin BOOLEAN NOT NULL,
    bio TEXT,
	remember_token  TEXT,
    birth_date DATE CHECK (birth_date < CURRENT_DATE),
    is_blocked BOOLEAN NOT NULL DEFAULT FALSE,
    gender lbaw2134.gender NOT NULL,
    profile_picture_id INTEGER REFERENCES lbaw2134.files ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE lbaw2134.events (
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description VARCHAR(1000),
    date TIMESTAMP NOT NULL,
    is_private BOOLEAN NOT NULL,
    is_disabled BOOLEAN NOT NULL DEFAULT FALSE,
    event_state lbaw2134.event_state NOT NULL,
    cover_image_id INTEGER REFERENCES lbaw2134.files ON DELETE SET NULL ON UPDATE CASCADE,
    organizer_id INTEGER REFERENCES lbaw2134.users ON DELETE SET NULL ON UPDATE CASCADE,
    location_id INTEGER REFERENCES lbaw2134.locations ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE lbaw2134.tags (
    id SERIAL PRIMARY KEY,
    name TEXT UNIQUE NOT NULL
);

CREATE TABLE lbaw2134.event_tags (
    event_id INTEGER REFERENCES lbaw2134.events ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    tag_id INTEGER REFERENCES lbaw2134.tags ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    PRIMARY KEY (event_id, tag_id)
);

CREATE TABLE lbaw2134.attendances (
    id SERIAL PRIMARY KEY,
    event_id INTEGER REFERENCES lbaw2134.events ON DELETE CASCADE ON UPDATE CASCADE,
    attendee_id INTEGER REFERENCES lbaw2134.users ON DELETE SET NULL ON UPDATE CASCADE,
    UNIQUE (event_id, attendee_id)
);

CREATE TABLE lbaw2134.attendance_requests (
    id SERIAL PRIMARY KEY,
    event_id INTEGER REFERENCES lbaw2134.events ON DELETE CASCADE ON UPDATE CASCADE,
    attendee_id INTEGER REFERENCES lbaw2134.users ON DELETE SET NULL ON UPDATE CASCADE,
    is_accepted BOOLEAN DEFAULT FALSE NOT NULL,
    is_invite BOOLEAN NOT NULL
);

CREATE TABLE lbaw2134.polls (
    id SERIAL PRIMARY KEY,
    event_id INTEGER REFERENCES lbaw2134.events ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    creator_id INTEGER REFERENCES lbaw2134.users ON DELETE SET NULL ON UPDATE CASCADE,
    title TEXT NOT NULL,
    description VARCHAR(1000) NOT NULL,
    date TIMESTAMP DEFAULT NOW(),
    is_open BOOLEAN DEFAULT TRUE
);

CREATE TABLE lbaw2134.poll_options (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    poll_id INTEGER REFERENCES lbaw2134.polls ON DELETE CASCADE ON UPDATE CASCADE NOT NULL
);

CREATE TABLE lbaw2134.user_poll_options (
    voter_id INTEGER REFERENCES lbaw2134.users ON DELETE SET NULL ON UPDATE CASCADE,
    poll_option_id INTEGER REFERENCES lbaw2134.poll_options ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE lbaw2134.comments (
    id SERIAL PRIMARY KEY,
    event_id INTEGER REFERENCES lbaw2134.events ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    commenter_id INTEGER REFERENCES lbaw2134.users ON DELETE SET NULL ON UPDATE CASCADE,
    parent_id INTEGER REFERENCES lbaw2134.comments ON DELETE CASCADE ON UPDATE CASCADE,
    body TEXT,
    date TIMESTAMP DEFAULT NOW() NOT NULL
);

CREATE TABLE lbaw2134.notifications (
    id SERIAL PRIMARY KEY,
    date TIMESTAMP DEFAULT NOW() NOT NULL,
    notification_type lbaw2134.notification_type NOT NULL,
    is_seen BOOLEAN DEFAULT FALSE NOT NULL,
    event_id INTEGER REFERENCES lbaw2134.events ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    attendance_request_id INTEGER REFERENCES lbaw2134.attendance_requests ON DELETE CASCADE ON UPDATE CASCADE,
    poll_id INTEGER REFERENCES lbaw2134.polls ON DELETE CASCADE ON UPDATE CASCADE,
    comment_id INTEGER REFERENCES lbaw2134.comments ON DELETE CASCADE ON UPDATE CASCADE,
    addressee_id INTEGER REFERENCES lbaw2134.users ON DELETE CASCADE ON UPDATE CASCADE NOT NULL,
    CONSTRAINT single_reference CHECK (array_length(array_remove(ARRAY[attendance_request_id::integer, poll_id::integer, comment_id::integer], NULL), 1) = 1)
);

CREATE TABLE lbaw2134.reports (
    id SERIAL PRIMARY KEY,
    date TIMESTAMP DEFAULT NOW() NOT NULL,
    description VARCHAR(1000),
    report_motive lbaw2134.report_motive NOT NULL,
    handled_by_id INTEGER REFERENCES lbaw2134.users ON DELETE SET NULL ON UPDATE CASCADE,
    reported_event_id INTEGER REFERENCES lbaw2134.events ON DELETE CASCADE ON UPDATE CASCADE,
    reported_user_id INTEGER REFERENCES lbaw2134.users ON DELETE CASCADE ON UPDATE CASCADE,
    reported_comment_id INTEGER REFERENCES lbaw2134.comments ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT single_reference CHECK ((reported_event_id IS NOT NULL AND reported_user_id IS NULL AND reported_comment_id IS NULL) OR (reported_event_id IS NULL AND reported_user_id IS NOT NULL AND reported_comment_id IS NULL) OR (reported_event_id IS NULL AND reported_user_id IS NULL AND reported_comment_id IS NOT NULL))
);

-------------------------------------------------
-------------------- Views ----------------------
-------------------------------------------------

CREATE VIEW lbaw2134.event_poll AS
(SELECT lbaw2134.polls.id AS poll_id, event_id
FROM lbaw2134.polls JOIN lbaw2134.events ON (lbaw2134.polls.event_id = lbaw2134.events.id));

------------------------------------------------------
-------------------- Functions -----------------------
------------------------------------------------------

CREATE FUNCTION lbaw2134.is_handled_by_admin() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.handled_by_id IS NOT NULL THEN
        IF NOT EXISTS (SELECT * FROM lbaw2134.users WHERE id = NEW.handled_by_id AND is_admin = TRUE) THEN
            RAISE EXCEPTION 'A lbaw2134.reports can only be handled by a user.';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.block_admin_comment() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.commenter_id IS NOT NULL THEN
        IF EXISTS (SELECT * FROM lbaw2134.users WHERE id = NEW.commenter_id AND is_admin = TRUE) THEN
            RAISE EXCEPTION 'Admins cannot write lbaw2134.comments';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.block_admin_poll_vote() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.voter_id IS NOT NULL THEN
        IF EXISTS (SELECT * FROM lbaw2134.users WHERE id = NEW.voter_id AND is_admin = TRUE) THEN
            RAISE EXCEPTION 'Admins cannot vote in polls';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.block_admin_attendance() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.attendee_id IS NOT NULL THEN
        IF EXISTS (SELECT * FROM lbaw2134.users WHERE id = NEW.attendee_id AND is_admin = TRUE) THEN
            RAISE EXCEPTION 'Admins cannot attend events';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.block_admin_request() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.attendee_id IS NOT NULL THEN
        IF EXISTS (SELECT * FROM lbaw2134.users WHERE id = NEW.attendee_id AND is_admin = TRUE) THEN
            RAISE EXCEPTION 'Admins cannot be the recipient of requests';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.block_admin_organizer() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.organizer_id IS NOT NULL THEN
        IF EXISTS (SELECT * FROM lbaw2134.users WHERE id = NEW.organizer_id AND is_admin = TRUE) THEN
            RAISE EXCEPTION 'Admins cannot be organizers';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.request_event_type() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.event_id IS NOT NULL THEN
        IF EXISTS (SELECT e.* FROM lbaw2134.events e WHERE id = NEW.event_id AND e.event_state <> 'due' AND e.event_state <> 'on-going') THEN
            RAISE EXCEPTION 'Requests can only be sent for due or on-going events';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.request_diff_users() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.attendee_id IS NOT NULL THEN
        IF EXISTS (SELECT * FROM lbaw2134.events WHERE organizer_id = NEW.attendee_id AND id = NEW.event_id) THEN
            RAISE EXCEPTION 'Requests for a certain event can not be sent to the organizer of that same events';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.request_attended_users() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.attendee_id IS NOT NULL THEN
        IF EXISTS (SELECT * FROM lbaw2134.attendances WHERE attendee_id = NEW.attendee_id AND event_id = NEW.event_id AND NEW.is_accepted = False) THEN
            RAISE EXCEPTION 'Cannot request if already attending event';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.voter_is_attendee() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.voter_id IS NOT NULL THEN
        IF NOT EXISTS (SELECT *
        FROM lbaw2134.event_poll JOIN lbaw2134.attendances a ON (event_poll.event_id = a.event_id)
                        JOIN lbaw2134.poll_options po ON (po.poll_id = event_poll.poll_id)
        WHERE po.id = NEW.poll_option_id AND attendee_id = NEW.voter_id) THEN
            RAISE EXCEPTION 'A polls voter must attend the events related to the polls';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;


-- 'Disabled event', 'cancelled event', 'Join request', 'Accepted request', 'Declined request', 'Invite', 'Accepted invite', 'Declined invite', 'New lbaw2134.comments', 'New lbaw2134.polls', 'Poll closed'

CREATE FUNCTION lbaw2134.disable_event_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.is_disabled = TRUE AND OLD.is_disabled = FALSE THEN
        INSERT INTO lbaw2134.notifications
        (notification_type, event_id, poll_id, comment_id, attendance_request_id, addressee_id)
        SELECT * FROM (
            (VALUES (CAST('Disabled event' AS lbaw2134.notification_type), NEW.id, CAST(NULL AS Integer), CAST(NULL AS Integer))) AS foo
            CROSS JOIN
            (
                SELECT id as attendance_request_id, attendee
                FROM lbaw2134.attendances
                WHERE event_id = NEW.id
            ) AS bar
        );
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.cancelled_event_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.event_state = 'cancelled' AND OLD.event_state <> 'cancelled' THEN
        INSERT INTO lbaw2134.notifications
        (notification_type, event_id, poll_id, comment_id, attendance_request_id, addressee_id)
        SELECT * FROM (
            (VALUES (CAST('Cancelled event' AS lbaw2134.notification_type), NEW.id, CAST(NULL AS Integer), CAST(NULL AS Integer))) AS foo
            CROSS JOIN
            (
                SELECT id as attendance_request_id, attendee
                FROM lbaw2134.attendances
                WHERE event_id = NEW.id
            ) AS bar
        );
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.join_request_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.is_invite = FALSE THEN
        INSERT INTO lbaw2134.notifications
        (notification_type, event_id, attendance_request_id, poll_id, comment_id, addressee_id)
        VALUES (CAST('Join request' AS lbaw2134.notification_type), NEW.event_id, NEW.id, CAST(NULL AS Integer), CAST(NULL AS Integer), NEW.attendee_id);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.accepted_request_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.is_invite = FALSE AND NEW.is_accepted = TRUE AND OLD.is_accepted = FALSE THEN
        INSERT INTO lbaw2134.notifications
        (notification_type, event_id, attendance_request_id, poll_id, comment_id, addressee_id)
        VALUES (CAST('Accepted request' AS lbaw2134.notification_type), NEW.event_id, NEW.id, CAST(NULL AS Integer), CAST(NULL AS Integer), NEW.attendee_id);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.invite_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.is_invite = TRUE THEN
        INSERT INTO lbaw2134.notifications
        (notification_type, event_id, attendance_request_id, poll_id, comment_id, addressee_id)
        VALUES (CAST('Invite' AS lbaw2134.notification_type), NEW.event_id, NEW.id, CAST(NULL AS Integer), CAST(NULL AS Integer), NEW.attendee_id);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.accepted_invite_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.is_invite = TRUE AND NEW.is_accepted = TRUE AND OLD.is_accepted = FALSE THEN
        INSERT INTO lbaw2134.notifications
        (notification_type, event_id, attendance_request_id, poll_id, comment_id, addressee_id)
        VALUES (CAST('Accepted Invite' AS lbaw2134.notification_type), NEW.event_id, NEW.id, CAST(NULL AS Integer), CAST(NULL AS Integer), NEW.attendee_id);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

--CREATE FUNCTION lbaw2134.new_comment_notification() RETURNS TRIGGER AS
--$BODY$
--BEGIN
--    RETURN NEW;
--END
--$BODY$
--LANGUAGE plpgsql;

CREATE FUNCTION lbaw2134.new_poll_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.is_open = TRUE THEN
        INSERT INTO lbaw2134.notifications
        (notification_type, event_id, attendance_request_id, poll_id, comment_id, addressee_id)
        SELECT * FROM (
            (VALUES (CAST('New poll' AS lbaw2134.notification_type), NEW.event_id, CAST(NULL AS Integer), NEW.id, CAST(NULL AS Integer))) AS foo
            CROSS JOIN
            (
                SELECT attendee_id
                FROM lbaw2134.attendances
                WHERE event_id = NEW.event_id
            ) AS bar
        );
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

-- currently adds a lbaw2134.notifications for all voters of the lbaw2134.polls
-- supports multiple votes in the same lbaw2134.polls
CREATE FUNCTION lbaw2134.closed_poll_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.is_open = FALSE AND OLD.is_open = TRUE THEN
        INSERT INTO lbaw2134.notifications
        (notification_type, event_id, attendance_request_id, poll_id, comment_id, addressee_id)
        SELECT * FROM (
            (VALUES ('Closed poll', NEW.event_id, NULL, NEW.id, NULL)) AS foo
            CROSS JOIN
            (
                SELECT DISTINCT voter_id
                FROM lbaw2134.user_poll_options
                JOIN (
                    SELECT *
                    FROM lbaw2134.poll_options
                    WHERE poll_id = NEW.id
                ) AS poll_options
                ON lbaw2134.user_poll_options.poll_option_id=poll_options.id
            ) AS bar
        );
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

----------------------------------------------------
-------------------- Triggers ----------------------
----------------------------------------------------

CREATE TRIGGER is_handled_by_admin
    BEFORE INSERT OR UPDATE ON lbaw2134.reports
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.is_handled_by_admin();

CREATE TRIGGER block_admin_comment
    BEFORE INSERT OR UPDATE ON lbaw2134.comments
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.block_admin_comment();

CREATE TRIGGER block_admin_poll_vote
    BEFORE INSERT OR UPDATE ON lbaw2134.user_poll_options
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.block_admin_poll_vote();

CREATE TRIGGER block_admin_attendance
    BEFORE INSERT OR UPDATE ON lbaw2134.attendances
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.block_admin_attendance();

CREATE TRIGGER block_admin_request
    BEFORE INSERT OR UPDATE ON lbaw2134.attendance_requests
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.block_admin_request();

CREATE TRIGGER block_admin_organizer
    BEFORE INSERT OR UPDATE ON lbaw2134.events
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.block_admin_organizer();

CREATE TRIGGER request_event_type
    BEFORE INSERT OR UPDATE ON lbaw2134.attendance_requests
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.request_event_type();

CREATE TRIGGER request_diff_users
    BEFORE INSERT OR UPDATE ON lbaw2134.attendance_requests
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.request_diff_users();

CREATE TRIGGER request_attended_users
    BEFORE INSERT OR UPDATE ON lbaw2134.attendance_requests
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.request_attended_users();

CREATE TRIGGER voter_is_attendee
    BEFORE INSERT OR UPDATE ON lbaw2134.user_poll_options
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.voter_is_attendee();

CREATE TRIGGER disable_event_notification
    AFTER UPDATE ON lbaw2134.events
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.disable_event_notification();

CREATE TRIGGER cancelled_event_notification
    AFTER UPDATE ON lbaw2134.events
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.cancelled_event_notification();

CREATE TRIGGER join_request_notification
    AFTER INSERT ON lbaw2134.attendance_requests
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.join_request_notification();

CREATE TRIGGER accepted_request_notification
    AFTER UPDATE ON lbaw2134.attendance_requests
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.accepted_request_notification();

CREATE TRIGGER invite_notification
    AFTER INSERT ON lbaw2134.attendance_requests
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.invite_notification();

CREATE TRIGGER accepted_invite_notification
    AFTER UPDATE ON lbaw2134.attendance_requests
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.accepted_invite_notification();

CREATE TRIGGER new_poll_notification
    AFTER INSERT ON lbaw2134.polls
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.new_poll_notification();

CREATE TRIGGER closed_poll_notification
    AFTER UPDATE ON lbaw2134.polls
    FOR EACH ROW
    EXECUTE PROCEDURE lbaw2134.closed_poll_notification();

----------------------------------------------------
------------ Full-text search indexes --------------
----------------------------------------------------

-- Add column to lbaw2134.users to store computed ts_vectors.
ALTER TABLE lbaw2134.events ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION lbaw2134.event_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.title), 'A') ||
		 setweight(to_tsvector('english', NEW.description), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.title <> OLD.title OR OLD.description <> OLD.description) THEN
            NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.title), 'A') ||
            setweight(to_tsvector('english', NEW.description), 'B')
            );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on lbaw2134.users.
CREATE TRIGGER event_search_update
 BEFORE INSERT OR UPDATE ON lbaw2134.events
 FOR EACH ROW
 EXECUTE PROCEDURE lbaw2134.event_search_update();

-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_idx ON lbaw2134.events USING GIN (tsvectors);


-- Add column to lbaw2134.users to store computed ts_vectors.
ALTER TABLE lbaw2134.users ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION lbaw2134.users_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
		 setweight(to_tsvector('english', NEW.bio), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.username <> OLD.username OR NEW.name <> OLD.name OR NEW.bio <> OLD.bio) THEN
			NEW.tsvectors = (
			 setweight(to_tsvector('english', NEW.name), 'A') ||
			 setweight(to_tsvector('english', NEW.bio), 'B')
			);
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on lbaw2134.users.
CREATE TRIGGER users_search_update
 BEFORE INSERT OR UPDATE ON lbaw2134.users
 FOR EACH ROW
 EXECUTE PROCEDURE lbaw2134.users_search_update();

-- Finally, create a GIN index for ts_vectors.
CREATE INDEX user_search_idx ON lbaw2134.users USING GIN (tsvectors);

----------------------------------------------------
---------------- Performance indexes ---------------
----------------------------------------------------
CREATE INDEX date_event_idx ON lbaw2134.events USING BTREE (date);
CREATE INDEX event_comment_idx on lbaw2134.comments USING HASH (event_id);
CREATE INDEX user_notification_idx  ON lbaw2134.notifications USING HASH (addressee_id);

-----------------------------------------------------
--------------------Populate database----------------
-----------------------------------------------------
INSERT INTO lbaw2134.LOCATIONS values
	( 100, '484 Weeping Birch Street', 'Soito', '40.4690667 -8.1110545', 'Northview', 'Portugal' ),
	( 101, '42514 Old Gate Junction', 'Craoteil', '48.7803815 2.4549884', 'Dawn', 'France' ),
	( 102, '98032 Ronald Regan Point', 'Anchorage', '61.148769 -149.8010811', 'Hollow Ridge', 'United States' ),
	( 103, '93608 Grayhawk Drive', 'Pocohuanca', '-14.216667 -73.083333', 'Canary', 'Peru' ),
	( 104, '594 Fairfield Pass', 'Lluchubamba', '-7.5231833 -77.9710098', 'Esker', 'Peru' ),
	( 105, '994 Laurel Drive', 'Washington', '38.9003669 -77.0351137', 'Di Loreto', 'United States' ),
	( 106, '7 Hermina Plaza', 'San Diego', '32.903454 -117.2195678', 'Kings', 'United States' ),
	( 107, '729 Badeau Terrace', 'Paris La Daofense', '48.892701 2.233089', 'Dottie', 'France' ),
	( 108, '15814 Browning Junction', 'Paris 05', '43.4945737 5.8978018', 'Bowman', 'France' ),
	( 109, '67 Tennessee Junction', 'Puerto Maldonado', '-12.5909084 -69.1963141', 'Meadow Vale', 'Peru' ),
	( 110, '93 Porter Court', 'Paris 02', '43.4945737 5.8978018', 'Comanche', 'France' ),
	( 111, '5997 Burning Wood Way', 'Mantes-la-Jolie', '48.9990813 1.6899473', 'Manufacturers', 'France' ),
	( 112, '5 Redwing Center', 'Aco', '-9.3601019 -77.553344', 'Old Shore', 'Peru' );
INSERT INTO lbaw2134.USERS VALUES
	 (110, 'admin@admin.com', 'admin', '$2y$10$2ZQsdg13mHYK6QeLEVjPPOp5sJmAjlOrUU7tRlIpa8tMKB6EW5Ef2', 'LBAW2134', True, '','null', date '1978-09-28', False, 'Male', null ) ,
     (100, 'danial1978@gmail.com', 'danial1978', '$2y$10$WNIrrB/6C7yPQpvScdXSs.y/mLdxJ8PajD0YxWnugGEfAJsqtCh2e', 'Breanda Marple', False, '','null', date '1978-09-28', False, 'Female', null ) ,
	 (101, 'PedroLLiao@rhyta.com', 'pedrolliao', '$2y$10$7clHki3BzBs..oeY/Ym6vuGOfUe7xeahf.JjVBumBxrTp4iNCKjpK', 'Pedro Liao', False, '','null', date '1954-07-28', False, 'Male', null ) ,
	 (102, 'MatthewERaleigh@dayrep.com', 'rayleigh', '$2y$10$vgqw.lujkVX0Txekfw0SbegdAb2OdfoUWA8haJVDgb6mG4NpvAAZ2', 'Matthew Raleigh', False, '','null', date '1998-02-21', False, 'Male', null ) ,
	 (103, 'JuanitaWPayton@dayrep.com', 'juanitaJuan', '$2y$10$PIxT1sCJn.q6qNc.aJe7nuJ014oLBTKjpFPdKE6Ka.yHy0gCmsXJy', 'Juanita Payton', False, '','null', date '1982-01-18', False, 'Female', null ) ,
	 (104, 'LouisJAvelar@jourrapide.com', 'louislit', '$2y$10$svD6JX.6Aoh12j7z1Hlct.oMIwtZKM1K9mvAgTs53XBm17wgvMS9O', 'Louis Avelar', False, '','null', date '1982-04-01', False, 'Male', null ) ,
	 (105, 'MaryMHolland@dayrep.com', 'maryland', '$2y$10$zFCrQueN5tCr4s9ZrDCFHuj7nD8ERM1pImghymJpf7LdcG9db6wQa', 'Mary Holland', False, '','null', date '1991-5-21', False, 'Female', null ) ,
	 (106, 'WilliamSKing@teleworm.us', 'willking', '$2y$10$x3tHiP27A6F0Jm6f03ZvrOv4Ua1e9vuqbWOi5pW.TbDbc1vSxMoyO', 'William King', False, '','null', date '1998-06-27', False, 'Male', null ) ,
	 (107, 'MichaelVJones@jourrapide.com', 'michaelbjones', '$2y$10$YZYNFof5Jwim1OcS.Z8xI.98vbDubcawtkgmkQySddPuSuNLisCGe', 'Michael Jones', False, '','null', date '1997-12-12', False, 'Male', null ) ,
	 (108, 'MeredithMFry@jourrapide.com', 'meredithfried', '$2y$10$OqRoswFxgz2xK5wUv78L2eFB2go2.fAmkUIoYsWObuUJiRNShgnZK', 'Meredith Fry', False, '','null', date '2001-11-20', False, 'Female', null ) ,
	 (109, 'PeterLWhite@armyspy.com', 'peterpeter', '$2y$10$QUc83MLokA/gh6H7.s6AH.pW2aLjaF/6CeM.mlCiuvjaXKI2iF4Na', 'Peter White', False, '','null', date '2000-01-09', False, 'Male', null ) ;
INSERT INTO lbaw2134.EVENTS VALUES
	 (100, 'Vegan for beginners' ,'More and more people are interested in vegan/plant-based eating. Some are just curious, some want to get their feet wet, and some are ready to come to the V-side!', TO_TIMESTAMP('2021/12/29 00:00', 'YYYY/MM/DD/ HH24:MI'), False, False, 'due', null, 105, 100) ,
	 (101, 'Begin your taichi journey' ,'This series does seasonal training to help you develop a wide range of skills which will enhance both your health and your practice. We practices basic Tai Chi skills as posting, walking, breathing, stretching, energy work, bone tapping and hand movements.', TO_TIMESTAMP('2021/12/03 00:00', 'YYYY/MM/DD/ HH24:MI'), False, False, 'due', null, 109, 101) ,
	 (102, 'Knee pain corrective exercise workshop' ,'If you or a loved one is experiencing hip or knee pain, you wont want to miss this special event. This is an interactive workshop where you will perform the exercises while sitting at your computer.', TO_TIMESTAMP('2021/12/09 00:00', 'YYYY/MM/DD/ HH24:MI'), False, False, 'due', null, 106, 102) ,
	 (103, 'Baking from lbaw2134.Scratch 101' ,'Formerly known as Puff Pastry 101, weve shifted to include fun baking projects of all kinds! Bring a friend and join us on Instagram Live!', TO_TIMESTAMP('2021/12/18 00:00', 'YYYY/MM/DD/ HH24:MI'), False, False, 'due', null, 109, 103) ,
	 (104, 'Tech career fair' ,'We will be hosting a Tech Career Fair with our hiring partners from lbaw2134.fast growing startups and Fortune 500 companies in technology in the US/Canada.  There will be a focus on helping companies achieve their diversity and inclusivity initiative with more diverse candidates to their talent pool.', TO_TIMESTAMP('2021/12/10 00:00', 'YYYY/MM/DD/ HH24:MI'), False, False, 'due', null, 102, 104) ,
	 (105, 'Gentle yoga for terrible times' ,'Human beings are not meant to be in constant fight, flight, or freeze mode. Chronic stress takes a devastating toll on our mental and physical well-being. If you are exhausted, stressed out, burnt out, or just looking to relax and nourish your mind, body, and spirit, please join me for 75 minutes of gentle yoga', TO_TIMESTAMP('2021/12/17 00:00', 'YYYY/MM/DD/ HH24:MI'), False, False, 'due', null, 109, 105) ,
	 (106, 'The antidote: Womens circle' ,'The Antidote: Womens Circle is a virtual event that uses meditation and reflection to help women gracefully navigate todays world.', TO_TIMESTAMP('2021/12/16 00:00', 'YYYY/MM/DD/ HH24:MI'), False, False, 'due', null, 102, 106) ,
	 (107, 'Health and Happiness Workshop' ,'The pandemic environment, personal problems and work pressure take a toll on our body and mind. The Art of Living brings you this free holistic and integrated workshop called the Health and Happiness which provide unique tools and techniques which help combat stress accumulated in our daily, modern life.', TO_TIMESTAMP('2021/12/10 00:00', 'YYYY/MM/DD/ HH24:MI'), False, False, 'due', null, 109, 107) ,
	 (108, 'Doge Disco Party' ,'Our ultimate dream is to create a Doge-Powered Party Metaverse. A new Party Layer that will sit atop reality, allowing anyone, anywhere to instantly step into a parallel dimension alive with sound, light and positive vibes.', TO_TIMESTAMP('2021/12/01 00:00', 'YYYY/MM/DD/ HH24:MI'), True, False, 'due', null, 109, 108) ,
	 (109, 'Lets Talk... Conversations on Race, Equity, & Belonging' ,'There is still SO MUCH to talk about when it comes to systemic racism and often times there is not a safe space with which to have these conversations, ask questions, self reflect, learn from lbaw2134.others and identify the next action step.', TO_TIMESTAMP('2021/12/18 00:00', 'YYYY/MM/DD/ HH24:MI'), True, False, 'due', null, 108, 109) ,
	 (110, 'Black Singles Virtual Speed Dating' ,'Join the Filter Off free virtual speed dating event! This event is for all ages.', TO_TIMESTAMP('2021/12/17 00:00', 'YYYY/MM/DD/ HH24:MI'), True, False, 'due', null, 104, 110) ,
	 (111, 'SocietyX :The Magic Portal: Healing Through the Tarot' ,'Have you ever wanted to learn more about the tarot but didnt know where to start? This year the Magic Portal will be teaching the art of the tarot! Each class for the next 78 weeks will be dedicated to teaching each card of this well known divination practice.', TO_TIMESTAMP('2021/11/29 00:00', 'YYYY/MM/DD/ HH24:MI'), True, False, 'due', null, 107, 111) ;
INSERT INTO lbaw2134.TAGS VALUES
	 (100, 'fun') ,
	 (101, 'science') ,
	 (102, 'culture') ,
	 (103, 'music') ,
	 (104, 'film') ,
	 (105, 'influencer') ,
	 (106, 'bloat') ,
	 (107, 'talk') ,
	 (108, 'masterclass') ,
	 (109, 'cars') ,
	 (110, 'food') ,
	 (111, 'sports') ;
INSERT INTO lbaw2134.EVENT_TAGS VALUES
	( 100, 100 ) ,
	( 101, 101 ) ,
	( 102, 102 ) ,
	( 103, 103 ) ,
	( 104, 104 ) ,
	( 105, 105 ) ,
	( 106, 106 ) ,
	( 107, 107 ) ,
	( 108, 108 ) ,
	( 109, 109 ) ;
INSERT INTO lbaw2134.ATTENDANCES (event_id, attendee_id) VALUES
	( 100, 101 ) ,
	( 100, 102 ) ,
	( 100, 103 ) ,
	( 100, 104 ) ,
	( 100, 106 ) ,
	( 100, 107 ) ,
	( 101, 100 ) ,
	( 101, 101 ) ,
	( 101, 104 ) ,
	( 101, 105 ) ,
	( 101, 106 ) ,
	( 101, 107 ) ,
	( 101, 108 ) ,
	( 102, 100 ) ,
	( 102, 102 ) ,
	( 102, 103 ) ,
	( 102, 107 ) ,
	( 102, 108 ) ,
	( 102, 109 ) ,
	( 103, 100 ) ,
	( 103, 101 ) ,
	( 103, 102 ) ,
	( 103, 104 ) ,
	( 103, 105 ) ,
	( 103, 106 ) ,
	( 103, 108 ) ,
	( 104, 103 ) ,
	( 104, 104 ) ,
	( 104, 105 ) ,
	( 104, 106 ) ,
	( 104, 107 ) ,
	( 104, 108 ) ,
	( 104, 109 ) ,
	( 105, 100 ) ,
	( 105, 101 ) ,
	( 105, 102 ) ,
	( 105, 103 ) ,
	( 105, 104 ) ,
	( 105, 105 ) ,
	( 105, 106 ) ,
	( 105, 107 ) ,
	( 105, 108 ) ,
	( 106, 100 ) ,
	( 106, 103 ) ,
	( 106, 104 ) ,
	( 106, 106 ) ,
	( 106, 108 ) ,
	( 106, 109 ) ,
	( 107, 100 ) ,
	( 107, 101 ) ,
	( 107, 102 ) ,
	( 107, 103 ) ,
	( 107, 104 ) ,
	( 107, 105 ) ,
	( 107, 107 ) ,
	( 107, 108 ) ,
	( 108, 101 ) ,
	( 108, 103 ) ,
	( 108, 105 ) ,
	( 108, 106 ) ,
	( 108, 107 ) ,
	( 108, 108 ) ,
	( 109, 100 ) ,
	( 109, 101 ) ,
	( 109, 102 ) ,
	( 109, 104 ) ,
	( 109, 105 ) ,
	( 109, 106 ) ,
	( 109, 109 ) ,
	( 110, 100 ) ,
	( 110, 101 ) ,
	( 110, 102 ) ,
	( 110, 105 ) ,
	( 110, 107 ) ,
	( 110, 108 ) ,
	( 110, 109 ) ,
	( 111, 100 ) ,
	( 111, 101 ) ,
	( 111, 102 ) ,
	( 111, 103 ) ,
	( 111, 104 ) ,
	( 111, 105 ) ,
	( 111, 106 ) ,
	( 111, 108 ) ;
INSERT INTO lbaw2134.ATTENDANCE_REQUESTS VALUES
	( 100, 108, 100, False, False ) ;
INSERT INTO lbaw2134.POLLS VALUES
	( 100, 103, 109, 'Do you want to change the schedule?',  '' , TO_TIMESTAMP('2021/12/18 00:00', 'YYYY/MM/DD/ HH24:MI'), True ) ,
	( 101, 111, 107, 'What should we eat',  '' , TO_TIMESTAMP('2021/11/29 00:00', 'YYYY/MM/DD/ HH24:MI'), False ) ;
INSERT INTO lbaw2134.POLL_OPTIONS VALUES
	( 100, 'yes', 100 ) ,
	( 101, 'no', 100 ) ,
	( 102, 'Tacos', 101 ) ,
	( 103, 'Hotdogs', 101 ) ,
	( 104, 'Pizza', 101 ) ,
	( 105, 'Salad', 101 ) ;
INSERT INTO lbaw2134.USER_POLL_OPTIONS  VALUES
	(100, 101 ) ,
	(101, 100 ) ,
	(102, 101 ) ,
	(104, 101 ) ,
	(105, 100 ) ,
	(106, 101 ) ,
	(108, 100 ) ,
	(101, 102 ) ,
	(102, 103 ) ,
	(103, 103 ) ,
	(104, 105 ) ,
	(106, 103 ) ,
	(108, 105 ) ;
INSERT INTO lbaw2134.COMMENTS  VALUES
	( 100, 100, 103, null, 'Very nice event', TO_TIMESTAMP('2022/02/19 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 101, 101, 105, null, 'NiCe event', TO_TIMESTAMP('2021/12/14 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 102, 101, 106, null, 'Very nice event', TO_TIMESTAMP('2021/12/15 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 103, 103, 102, null, 'Looking forward to it!', TO_TIMESTAMP('2021/12/25 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 104, 104, 105, null, 'This event is bloat', TO_TIMESTAMP('2022/01/03 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 105, 105, 104, null, 'NiCe event', TO_TIMESTAMP('2022/01/05 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 106, 105, 106, null, 'Very nice event', TO_TIMESTAMP('2022/02/06 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 107, 106, 103, null, 'Looking forward to it!', TO_TIMESTAMP('2022/01/28 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 108, 106, 109, null, 'Very nice event', TO_TIMESTAMP('2022/02/08 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 109, 107, 101, null, 'Very nice event', TO_TIMESTAMP('2021/12/21 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 110, 107, 105, null, 'can my girlfriend cum?', TO_TIMESTAMP('2022/02/06 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 111, 108, 103, null, 'NiCe event', TO_TIMESTAMP('2021/12/18 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 112, 108, 106, null, 'This event is bloat', TO_TIMESTAMP('2021/12/08 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 113, 109, 100, null, 'Very nice event', TO_TIMESTAMP('2022/01/06 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 114, 109, 102, null, 'NiCe event', TO_TIMESTAMP('2021/12/25 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 115, 109, 109, null, 'This event is bloat', TO_TIMESTAMP('2022/02/13 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 116, 110, 101, null, 'Bonjour', TO_TIMESTAMP('2022/02/09 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 117, 110, 109, null, 'Nice event', TO_TIMESTAMP('2022/01/08 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 118, 111, 102, null, 'Bonjour', TO_TIMESTAMP('2021/12/06 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 119, 111, 103, null, 'can my girlfriend cum?', TO_TIMESTAMP('2021/12/26 00:00', 'YYYY/MM/DD/ HH24:MI') ) ,
	( 120, 111, 105, null, 'can my girlfriend cum?', TO_TIMESTAMP('2021/12/07 00:00', 'YYYY/MM/DD/ HH24:MI') ) ;

INSERT INTO lbaw2134.REPORTS VALUES
	(100, TO_TIMESTAMP('2021/11/29 00:00', 'YYYY/MM/DD/ HH24:MI'), 'Is this a typo?', 'Nudity or explicit content', null, null, null, 120);
