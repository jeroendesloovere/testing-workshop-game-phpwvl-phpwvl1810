INSERT INTO `account` VALUES 
    (1,'Michelangelo','van Dam','michelangelo@in2it.be','YoOX7hibF4h5.','fb5497047be5b468610abfd8f5003dbb97bae180',1,1,'2013-01-31 19:03:18','2013-01-21 12:15:36');

INSERT INTO `project` VALUES
    (1, 1, 'Test project', NOW(), NOW());

INSERT INTO `task` VALUES
  (1, 1, 1, 'Test task', 'Testing the task manager', NOW(), NOW(), NOW(), 1);