BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

-- Decline invite
UPDATE attendance_request
SET is_accepted = false;
WHERE id = $id;

-- Create notification
INSERT INTO notification (notification_type, attendance_request, addressee)
 VALUES ('Declined invite', $id, $addressee);

END TRANSACTION;