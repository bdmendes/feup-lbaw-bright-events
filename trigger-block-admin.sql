DROP TRIGGER IF EXISTS block_admin_comment ON comment;
DROP FUNCTION IF EXISTS block_admin_comment;

DROP TRIGGER IF EXISTS block_admin_poll_vote ON user_poll_option;
DROP FUNCTION IF EXISTS block_admin_poll_vote;

DROP TRIGGER IF EXISTS block_admin_attendance ON attendance;
DROP FUNCTION IF EXISTS block_admin_attendance;

DROP TRIGGER IF EXISTS block_admin_request ON attendance_request;
DROP FUNCTION IF EXISTS block_admin_request;

DROP TRIGGER IF EXISTS block_admin_organizer ON event;
DROP FUNCTION IF EXISTS block_admin_organizer;

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

CREATE TRIGGER block_admin_comment
    BEFORE INSERT OR UPDATE ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE block_admin_comment();


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

CREATE TRIGGER block_admin_poll_vote
    BEFORE INSERT OR UPDATE ON user_poll_option
    FOR EACH ROW
    EXECUTE PROCEDURE block_admin_poll_vote();

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

CREATE TRIGGER block_admin_attendance
    BEFORE INSERT OR UPDATE ON attendance
    FOR EACH ROW
    EXECUTE PROCEDURE block_admin_attendance();

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

CREATE TRIGGER block_admin_request
    BEFORE INSERT OR UPDATE ON attendance_request
    FOR EACH ROW
    EXECUTE PROCEDURE block_admin_request();

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

CREATE TRIGGER block_admin_organizer
    BEFORE INSERT OR UPDATE ON event
    FOR EACH ROW
    EXECUTE PROCEDURE block_admin_organizer();