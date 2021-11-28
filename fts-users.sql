-- Drop existing
DROP INDEX IF EXISTS search_idx;
ALTER TABLE users DROP COLUMN IF EXISTS tsvectors;
DROP TRIGGER IF EXISTS users_search_update ON users;
DROP FUNCTION IF EXISTS users_search_update;

-- Add column to work to store computed ts_vectors.
ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION users_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(NEW.username, 'A') ||
         setweight(to_tsvector('english', NEW.name), 'B') ||
		 setweight(to_tsvector('english', NEW.bio), 'C')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.username <> OLD.username OR NEW.name <> OLD.name OR NEW.bio <> OLD.bio) THEN
			NEW.tsvectors = (
			 setweight(NEW.username, 'A') ||
			 setweight(to_tsvector('english', NEW.name), 'B') ||
			 setweight(to_tsvector('english', NEW.bio), 'C')
			);
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on work.
CREATE TRIGGER users_search_update
 BEFORE INSERT OR UPDATE ON users
 FOR EACH ROW
 EXECUTE PROCEDURE users_search_update();


-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_idx ON users USING GIN (tsvectors);