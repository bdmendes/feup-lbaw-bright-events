BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

-- Create join request
INSERT INTO attendance_request (event, attendee, is_invite)
 VALUES ($event, $attendee, false);

-- Create notification
INSERT INTO notification (notification_type, attendance_request, attendee)
 VALUES ('Join request', currval('attendance_request_id_seq'), $addressee);

END TRANSACTION;