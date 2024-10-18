
ALTER TABLE login_attempts
ADD CONSTRAINT unique_login_attempt UNIQUE (timestamp, username, src_ip, success);