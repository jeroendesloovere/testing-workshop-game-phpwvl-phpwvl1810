SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE `account`;
INSERT INTO `account` 
    (`firstName`,`lastName`,`email`,`password`,`active`,`created`,`modified`)
    VALUES 
        ('Michelangelo','van Dam', 'michelangelo@in2it.be','YoOX7hibF4h5.',1,NOW(),NOW()),
        ('John','Doe','john.doe@example.com','YokNejSO8KsNU',0,NOW(),NOW());
SET FOREIGN_KEY_CHECKS = 1;