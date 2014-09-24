
CREATE DATABASE IF NOT EXISTS yclean CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE USER 'yclean'@'localhost' IDENTIFIED BY 'yclean@123!';
GRANT ALL PRIVILEGES ON yclean.* TO 'yclean'@'localhost'   WITH GRANT OPTION;

CREATE USER 'yclean'@'%' IDENTIFIED BY 'yclean@123!';
GRANT ALL PRIVILEGES ON yclean.* TO 'yclean'@'%'   WITH GRANT OPTION;


GRANT ALL PRIVILEGES ON yclean.* TO 'yclean'@'localhost'   WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON yclean.* TO 'yclean'@'%'   WITH GRANT OPTION;