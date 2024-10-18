USE honeypot_logs;

ALTER TABLE login_attempts
    ADD COLUMN src_ip VARCHAR(45) NOT NULL;
