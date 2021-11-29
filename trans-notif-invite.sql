BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

-- Create invite
INSERT INTO attendance_request (event, attendee, is_invite)
 VALUES ($event, $attendee, true);

-- Create notification
INSERT INTO notification (notification_type, attendance_request, attendee)
 VALUES ('Invite', currval('attendance_request_id_seq'), attendee);

END TRANSACTION;