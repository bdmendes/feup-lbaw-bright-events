DROP TRIGGER IF EXISTS request_diff_users ON attendance_request;
DROP FUNCTION IF EXISTS request_diff_users;

CREATE FUNCTION request_diff_users() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.attendee NOT NULL THEN
        IF EXISTS (SELECT * FROM event WHERE organizer = NEW.attendee AND id = NEW.event) THEN
            RAISE EXCEPTION 'Requests for a certain event can not be sent to the organizer of that same event'; 
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER request_diff_users
    BEFORE INSERT OR UPDATE ON attendance_request
    FOR EACH ROW
    EXECUTE PROCEDURE request_diff_users();