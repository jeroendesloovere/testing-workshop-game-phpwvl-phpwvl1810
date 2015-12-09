INSERT INTO `account` (`firstName`, `lastName`, `email`, `password`, `token`, `active`, `reset`, `created`, `modified`) VALUES
    ('Test','User','promo@in2it.be','YoOX7hibF4h5.','fb5497047be5b468610abfd8f5003dbb97bae180',1,1,'2013-01-31 19:03:18','2013-01-21 12:15:36');

INSERT INTO `project` (accountId, projectName, created, modified) VALUES
    (1, 'PHPUnit Training', NOW(), NOW()),
    (1, 'PHP7 Training', NOW(), NOW()),
    (1, 'Zend Framework Training', NOW(), NOW()),
    (1, 'Apigility Training', NOW(), NOW());

INSERT INTO `task` (projectId, accountId, title, description, dueDate, created, modified, done) VALUES
  (1, 1, 'Introduction', 'Introduction to unit testing', NOW(), NOW(), NOW(), 1),
  (1, 1, 'Testing Legacy Code', 'Legacy code testing challenges', NOW(), NOW(), NOW(), 1),
  (1, 1, 'External Services Testing', 'Testing 3rd party systems', NOW(), NOW(), NOW(), 1),
  (1, 1, 'Test-First or Test Driven Development', 'Write the tests first', NOW(), NOW(), NOW(), 1),
  (1, 1, 'Acceptance Testing', 'Automated UI testing with Selenium and PHPUnit', NOW(), NOW(), NOW(), 0),
  (1, 1, 'Continuous Integration', 'Continuously testing code changes', NOW(), NOW(), NOW(), 0),
  (1, 1, 'Recap', 'Overview of what we have covered', NOW(), NOW(), NOW(), 0);