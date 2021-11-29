BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

-- Accept invite
UPDATE attendance_request
SET is_accepted = true;
WHERE id = $id;

-- Create notification
INSERT INTO notification (notification_type, attendance_request, addresse)
 VALUES ('Accepted invite', $id, $addresse);

END TRANSACTION;