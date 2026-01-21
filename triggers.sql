DELIMITER $$

CREATE TRIGGER users_email_audit
AFTER UPDATE ON users
FOR EACH ROW
BEGIN
    IF NOT (OLD.email <=> NEW.email) THEN
        INSERT INTO users_audit (
            user_id,
            old_email,
            new_email,
            changed_at,
            changed_by
        ) VALUES (
            OLD.id,
            OLD.email,
            NEW.email,
            NOW(),
            @changed_by
        );
    END IF;
END$$

DELIMITER ;