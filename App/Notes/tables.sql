-- ----------------------------------
-- SQL for sample database
-- ----------------------------------

--
-- Table posts
--

CREATE TABLE posts (

    id int(11) NOT NUll AUTO_INCREMENT,
    title varchar(128) NOT NULL,
    content text NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY created_at (created_at)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Sample Data
--

INSERT INTO posts(title, content) VALUES 
('First post', 'This is a really interesting post'),
('Second post', 'This is a really amazing post'),
('Third post', 'This is a really informative post');

GRANT ALL PRIVILEGES ON `mvc`.* TO 'Alexander'@'localhost'WITH GRANT OPTION;

-------------------------------------------
-- USERS TABLE
-------------------------------------------

CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(50) NOT NULL,
 `email` varchar(255) NOT NULL,
 `password_hash` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1



-------------------------------------------
-- login_tokens
-------------------------------------------

CREATE TABLE `login_tokens` (
 `token_hash` varchar(64) NOT NULL,
 `user_id` int(11) NOT NULL,
 `expires_at` datetime NOT NULL,
 PRIMARY KEY (`token_hash`),
 KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

-------------------------------------------
-- Add Foreign key constrain to login tokens
-------------------------------------------

ALTER TABLE `login_tokens` 
ADD CONSTRAINT `fk_tokens_user_id` 
FOREIGN KEY (`user_id`) 
REFERENCES `mvc`.`users`(`id`) 
ON DELETE CASCADE 
ON UPDATE CASCADE;


-------------------------------------------
-- Create login_tokens in 1 query
-------------------------------------------


CREATE TABLE `login_tokens` (
 `token_hash` varchar(64) NOT NULL,
 `user_id` int(11) NOT NULL,
 `expires_at` datetime NOT NULL,
 PRIMARY KEY (`token_hash`),
 KEY `user_id` (`user_id`),
 CONSTRAINT `fk_tokens_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1