BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

-- Decline join request
UPDATE attendance_request
SET is_accepted = false;
WHERE id = $id;

-- Create notification
INSERT INTO notification (notification_type, attendance_request, attendee)
 VALUES ('Declined request', $id, $addressee);

END TRANSACTION;