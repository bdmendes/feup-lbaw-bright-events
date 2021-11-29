-- Drop existing
DROP INDEX IF EXISTS search_idx;
ALTER TABLE event DROP COLUMN IF EXISTS tsvectors;
DROP TRIGGER IF EXISTS event_search_update ON users;
DROP FUNCTION IF EXISTS event_search_update;

-- Add column to users to store computed ts_vectors.
ALTER TABLE event ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION event_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.title), 'A') ||
		 setweight(to_tsvector('english', NEW.description), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.username <> OLD.username OR NEW.name <> OLD.name OR NEW.bio <> OLD.bio) THEN
            NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.title), 'A') ||
            setweight(to_tsvector('english', NEW.description), 'B')
            );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on users.
CREATE TRIGGER event_search_update
 BEFORE INSERT OR UPDATE ON event
 FOR EACH ROW
 EXECUTE PROCEDURE event_search_update();

-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_idx ON event USING GIN (tsvectors);