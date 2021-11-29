BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

-- Accept request
UPDATE attendance_request
SET is_accepted = true
WHERE id = $request_id;

-- Add attendee to event participant lists
INSERT INTO attendance VALUES ($request_id, $attendee_id);

END TRANSACTION;