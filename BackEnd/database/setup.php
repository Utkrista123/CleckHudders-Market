<?php

// Create user table
    $usersTable="
    CREATE TABLE IF NOT EXISTS `USER` (
	`user_id`	int(11) NOT NULL AUTO_INCREMENT,
	`full_name`	VARCHAR(8) NOT NULL,
	`email`	VARCHAR(8) NOT NULL,
	`password`	VARCHAR(8) NOT NULL,
	`age`	INTEGER,
	`phone_no`	INTEGER,
	`DOB`	timestamp NOT NULL DEFAULT NULL,
	`verify_code`	INTEGER,
	`role`	VARCHAR(10),
	`status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`user_id`),
)   ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    // $reviewsTable="
    // CREATE TABLE IF NOT EXISTS `REVIEWS`(
    // `review_id`	INTEGER NOT NULL,
	// `user_id`	INTEGER NOT NULL,
	// `product_id`	INTEGER NOT NULL,
	// `review	LONG` VARCHAR,
	// `review_rating`	INTEGER,
	// `review_date`	DATE,
    // PRIMARY KEY(`review_id`),
    // CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `USER` (`user_id`),
    // CONSTRAINT `products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`)
    // )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    // ";

    // $productTable="
    // CREATE TABLE IF NOT EXISTS `PRODUCT`(
    // `review_id`	INTEGER NOT NULL,
	// `user_id`	INTEGER NOT NULL,
	// `product_id`	INTEGER NOT NULL,
	// `review	LONG` VARCHAR,
	// `review_rating`	INTEGER,
	// `review_date`	DATE,
    // `user_id` INTEGER NOT NULL,
    // `product_id`	INTEGER NOT NULL,
	// `shop_id`	INTEGER NOT NULL,
    // CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `USER` (`user_id`),
    // CONSTRAINT `products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
    // CONSTRAINT `products_ibfk_3` FOREIGN KEY (`shop_id`) REFERENCES `products` (`shop_id`)
    // )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    // ";
?>
