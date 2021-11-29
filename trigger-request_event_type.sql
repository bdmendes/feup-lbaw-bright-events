DROP TRIGGER IF EXISTS request_event_type ON attendance_request;
DROP FUNCTION IF EXISTS request_event_type;

CREATE FUNCTION request_event_type() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.event IS NOT NULL THEN
        IF NOT EXISTS (SELECT * FROM event WHERE id = NEW.event AND (event_state = 'Due' OR event_state = 'On-going')) THEN 
            RAISE EXCEPTION 'Requests can only be sent for due or on-going events';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER request_event_type
    BEFORE INSERT OR UPDATE ON attendance_request
    FOR EACH ROW
    EXECUTE PROCEDURE request_event_type();