ALTER TABLE users
DROP FOREIGN KEY IF EXISTS users_ibfk_1,
DROP FOREIGN KEY IF EXISTS users_ibfk_2;


CREATE TABLE IF NOT EXISTS genders (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL UNIQUE,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO genders (name)
SELECT 'Мужской'
WHERE NOT EXISTS (SELECT 1 FROM genders WHERE name='Мужской');

INSERT INTO genders (name)
SELECT 'Женский'
WHERE NOT EXISTS (SELECT 1 FROM genders WHERE name='Женский');


CREATE TABLE IF NOT EXISTS faculties (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(150) NOT NULL UNIQUE,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO faculties (name)
SELECT 'Информатика'
WHERE NOT EXISTS (SELECT 1 FROM faculties WHERE name='Информатика');

INSERT INTO faculties (name)
SELECT 'Экономика'
WHERE NOT EXISTS (SELECT 1 FROM faculties WHERE name='Экономика');



UPDATE users
SET gender_id = (SELECT id FROM genders WHERE name='Мужской')
WHERE gender_id IS NULL;


UPDATE users
SET faculty_id = (SELECT id FROM faculties WHERE name='Информатика')
WHERE faculty_id IS NULL;


ALTER TABLE users
MODIFY COLUMN gender_id INT(11) NOT NULL,
MODIFY COLUMN faculty_id INT(11) NOT NULL;


ALTER TABLE users
ADD CONSTRAINT users_ibfk_1
FOREIGN KEY (gender_id) REFERENCES genders(id)
ON DELETE RESTRICT;

ALTER TABLE users
ADD CONSTRAINT users_ibfk_2
FOREIGN KEY (faculty_id) REFERENCES faculties(id)
ON DELETE RESTRICT;
