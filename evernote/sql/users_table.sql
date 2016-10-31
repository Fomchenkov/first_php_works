CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  user_login VARCHAR(20) NOT NULL,
  user_password VARCHAR(40) NOT NULL,
  PRIMARY KEY (user_id)
) CHARACTER SET utf8
