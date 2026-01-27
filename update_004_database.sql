CREATE TABLE intern_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO intern_status (name) VALUES
('ищет'),
('работает'),
('закончил');

ALTER TABLE users
ADD COLUMN status_id INT DEFAULT 1;


UPDATE users SET status_id = 1 WHERE status_id IS NULL;

ALTER TABLE users
ADD CONSTRAINT fk_users_status
FOREIGN KEY (status_id) REFERENCES intern_status(id);