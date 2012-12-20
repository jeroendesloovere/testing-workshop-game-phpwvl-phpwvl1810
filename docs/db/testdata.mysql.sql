-- Create a first account for testing purposes --
INSERT INTO `account` (name, email, password, created, modified, active, token) values
  ('Michelangelo van Dam', 'michelangelo@in2it.be', 'ad94a8edf93d1f7c491c4843ddf7dcfc6fa0b0a7', '2012-12-15 16:16:44', '2012-12-15 16:16:44', '1', 'fa26be19de6bff93f70bc2308434e4a440bbad02');

-- Provide two projects for ths account --
INSERT INTO `project` (accountId, title, description, created, modified) VALUES
  ('1', 'Test Project', 'This is a testproject', '2012-12-16 16:45:57', '2012-12-16 16:45:57'),
  ('2', 'Test Project of John Doe', 'This is a testproject from John Doe', '2012-12-16 16:45:58', '2012-12-16 16:45:58');

-- Ensure you have 2 tasks per project --
INSERT INTO `task` (projectId, title, description, created, modified, complete) VALUES
  ('1', 'Test Task 1', 'This a test task', '2012-12-16 16:45:58', '2012-12-16 16:45:58', '0'),
  ('1', 'Test Task 2', 'This is a test task', '2012-12-16 16:45:58', '2012-12-16 16:45:58', '0'),
  ('2', 'Test Task 1 of John Doe', 'This is a test task of John Doe', '2012-12-16 16:45:58', '2012-12-16 16:45:58', '0'),
  ('2', 'Test Task 2 of John Doe', 'This is a test task of John Doe', '2012-12-16 16:45:58', '2012-12-16 16:45:58', '0');