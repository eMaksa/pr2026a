CREATE TABLE users_audit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    old_email VARCHAR(255), new_email VARCHAR(255),
    changed_at DATETIME NOT NULL,
    changed_by VARCHAR(45), -- IP (IPv4 / IPv6)
    INDEX (user_id) 
    );


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
            COALESCE(@changed_by, 'unknown')
        );
    END IF;
END$$

DELIMITER ;