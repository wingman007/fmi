ALTER TABLE users ADD `usr_password_salt` varchar(100) DEFAULT NULL COMMENT 'dynamicSalt',

INSERT INTO `users` VALUES (2,'stoyan','50f2405710d1ea8a0e6a0d6b4471586c','stoyan@hotmail.com',NULL,NULL,1,NULL,NULL,NULL,'eqwe3213');

string to encripting: aFGQ475SDsdfsaf2342passwordeqwe3213

ALTER TABLE users ADD `usr_registration_date`  DATETIME DEFAULT NULL COMMENT 'Registration moment';
ALTER TABLE users ADD `usr_registration_token`  varchar(100)  DEFAULT NULL COMMENT 'unique id sent by e-mail';

ALTER TABLE users ADD  `usr_email_cofirmed`  tinyint(1) NOT NULL COMMENT 'e-mail confirmed by user';

=========== Error and correction ===============================================
ALTER TABLE users ADD  `usr_email_cofirmed`  tinyint(1) NOT NULL COMMENT 'e-mail confirmed by user';

ALTER TABLE users CHANGE `usr_email_cofirmed` `usr_email_confirmed` tinyint(1) NOT NULL COMMENT 'e-mail confirmed by user';