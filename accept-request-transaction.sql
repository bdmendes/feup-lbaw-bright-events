BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

-- Accept request
UPDATE attendance_request
SET is_accepted = true
WHERE id = $req_id;

-- Add attendee to event participant lists
INSERT INTO attendance VALUES ($req_id, $att_id);

END TRANSACTION;