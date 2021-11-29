BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

-- Accept join request
UPDATE attendance_request
SET is_accepted = true;
WHEN id = $id;

-- Create notification
INSERT INTO notification (notification_type, attendance_request, attendee)
 VALUES ('Accepted request', id, attendee);

END TRANSACTION;