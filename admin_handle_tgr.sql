DROP TRIGGER IF EXISTS is_handled_by_admin ON report;

CREATE FUNCTION is_handled_by_admin() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.handled_by IS NOT NULL THEN
        IF NOT EXISTS (SELECT * FROM users WHERE id = NEW.handled_by AND is_admin = TRUE) THEN
            RAISE EXCEPTION 'A report can only be handled by a user.';
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER is_handled_by_admin
    BEFORE INSERT OR UPDATE ON report
    FOR EACH ROW
    EXECUTE PROCEDURE is_handled_by_admin();