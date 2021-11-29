DROP TRIGGER IF EXISTS voter_is_attendee ON report;

CREATE VIEW event_poll AS
SELECT id AS poll_id, event 
FROM poll JOIN event ON (poll.event = event.id)

CREATE FUNCTION voter_is_attendee() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.voter IS NOT NULL
        IF NOT EXISTS (SELECT * 
        FROM event_poll JOIN attendance ON (event_poll.event = attendance.event) 
        WHERE poll_id = NEW.id AND attendee = NEW.voter) THEN
            RAISE EXCEPTION 'A poll voter must attend the event related to the poll';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER voter_is_attendee
    BEFORE INSERT OR UPDATE ON user_poll_option
    FOR EACH ROW
    EXECUTE PROCEDURE voter_is_attendee();