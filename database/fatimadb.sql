-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Apr 19, 2023 at 04:25 AM
-- Server version: 10.4.27-MariaDB-log
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
DROP DATABASE IF EXISTS fatimadb;
CREATE DATABASE fatimadb;
USE fatimadb;

CREATE TABLE `resident` (
        `resident_id` int(11) NOT NULL AUTO_INCREMENT,
        `first_name` varchar(255) NOT NULL,
        `mid_name` varchar(50) DEFAULT NULL,
        `last_name` varchar(50) NOT NULL,
        `suffix` varchar(10) DEFAULT NULL,
        `sex` varchar(20) NOT NULL,
        `date_of_birth` date NOT NULL,
        `place_of_birth` varchar(255) NOT NULL,
        `civil_status` varchar(50) NOT NULL,
        `nationality` varchar(20) NOT NULL,
        `occupation` varchar(50) DEFAULT NULL,
        `religion` varchar(50) DEFAULT NULL,
        `blood_type` varchar(10) DEFAULT NULL,
        `fourps_status` varchar(5) DEFAULT NULL,
        `disability_status` varchar(30) DEFAULT NULL,
        `type_disability` varchar(50) DEFAULT NULL,
        `senior_status` varchar(20) DEFAULT NULL,
        `educational_attainment` varchar(30) NOT NULL,
        `phone_number` varchar(11) NOT NULL,
        `tel_number` varchar(12) DEFAULT NULL,
        `email` varchar(100) DEFAULT NULL,
        `purok` varchar(20) NOT NULL,
        `street` varchar(50) NOT NULL,
        `lot_number` varchar(20) NOT NULL,
        `voter_status` varchar(20) DEFAULT NULL,
        `voter_id` varchar(50) DEFAULT NULL,
        `precinct_number` varchar(20) DEFAULT NULL,
        `national_id` varchar(55) DEFAULT NULL,
        `vaccine_status` varchar(10) DEFAULT NULL,
        `vaccine_1` varchar(15) DEFAULT NULL,
        `vaccine_date_1` date DEFAULT NULL,
        `vaccine_2` varchar(15) DEFAULT NULL,
        `vaccine_date_2` date NULL DEFAULT NULL,
        `booster_status` varchar(10) DEFAULT NULL,
        `booster_1` varchar(15) DEFAULT NULL,
        `booster_date_1` date DEFAULT NULL,
        `booster_2` varchar(15) DEFAULT NULL,
        `booster_date_2` date DEFAULT NULL,
        `emergency_person` varchar(255) NOT NULL,
        `relationship` varchar(20) NOT NULL,
        `emergency_address` varchar(255) NOT NULL,
        `emergency_contact` varchar(11) NOT NULL,
        `img_url` varchar(255) NOT NULL,
        `alien_status` varchar(50) NOT NULL,
        `deceased_status` varchar(50) DEFAULT NULL,
        `date_of_death` date DEFAULT NULL,
        `created_by` varchar(50) NOT NULL,
        `date_created` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_by` varchar(50) DEFAULT NULL,
        `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
        `restored_by` varchar(50) DEFAULT NULL,
        `date_restored` datetime DEFAULT NULL,
        UNIQUE INDEX idx_unique_resident (`first_name`, `mid_name`, `last_name`, `suffix`),
        PRIMARY KEY(`resident_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `resident_archive` (
        `resident_archive_id` int(11) NOT NULL AUTO_INCREMENT,
        `resident_id` int(11) NOT NULL,
        `first_name` varchar(255) NOT NULL,
        `mid_name` varchar(50) NOT NULL,
        `last_name` varchar(50) NOT NULL,
        `suffix` varchar(10) NOT NULL,
        `sex` varchar(20) NOT NULL,
        `date_of_birth` date NOT NULL,
        `place_of_birth` varchar(255) NOT NULL,
        `civil_status` varchar(20) NOT NULL,
        `nationality` varchar(20) NOT NULL,
        `occupation` varchar(50) NOT NULL,
        `religion` varchar(50) NOT NULL,
        `blood_type` varchar(10) NOT NULL,
        `fourps_status` varchar(5) NOT NULL,
        `disability_status` varchar(30) NOT NULL,
        `type_disability` varchar(50) NOT NULL,
        `senior_status` varchar(20) NOT NULL,
        `educational_attainment` varchar(30) NOT NULL,
        `phone_number` varchar(11) NOT NULL,
        `tel_number` varchar(12) NOT NULL,
        `email` varchar(100) NOT NULL,
        `purok` varchar(20) NOT NULL,
        `street` varchar(50) NOT NULL,
        `lot_number` varchar(20) NOT NULL,
        `voter_status` varchar(20) NOT NULL,
        `voter_id` varchar(20) DEFAULT NULL,
        `precinct_number` varchar(20) DEFAULT NULL,
        `national_id` varchar(55) DEFAULT NULL,
        `vaccine_status` varchar(10) DEFAULT NULL,
        `vaccine_1` varchar(15) DEFAULT NULL,
        `vaccine_date_1` datetime DEFAULT NULL,
        `vaccine_2` varchar(15) DEFAULT NULL,
        `vaccine_date_2` datetime DEFAULT NULL,
        `booster_status` varchar(10) DEFAULT NULL,
        `booster_1` varchar(15) DEFAULT NULL,
        `booster_date_1` datetime DEFAULT NULL,
        `booster_2` varchar(15) DEFAULT NULL,
        `booster_date_2` datetime DEFAULT NULL,
        `emergency_person` varchar(255) NOT NULL,
        `relationship` varchar(20) NOT NULL,
        `emergency_address` varchar(255) NOT NULL,
        `emergency_contact` varchar(11) NOT NULL,
        `img_url` varchar(255) NOT NULL,
        `alien_status` varchar(50) NOT NULL,
        `deceased_status` varchar(50) DEFAULT NULL,
        `date_of_death` date DEFAULT NULL,
        `created_by` varchar(50) NOT NULL,
        `date_created` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_by` varchar(50) DEFAULT NULL,
        `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
        `remarks` varchar(255) DEFAULT NULL,
        `archived_by` varchar(100) DEFAULT NULL,
        `date_archived` datetime DEFAULT NULL,
        PRIMARY KEY(`resident_archive_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;


CREATE TABLE `official` (
        `official_id` int(11) NOT NULL AUTO_INCREMENT,
        `resident_id` int(11) NOT NULL,
        `off_position` varchar(20) NOT NULL,
        `term` varchar(50) NOT NULL,
        `first_term_start` date NOT NULL,
        `first_term_end` date DEFAULT NULL,
        `second_term_start` date DEFAULT NULL,
        `second_term_end` date DEFAULT NULL,
        `third_term_start` date DEFAULT NULL,
        `third_term_end` date DEFAULT NULL,
        `created_by` varchar(50) NOT NULL,
        `date_created` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_by` varchar(50) DEFAULT NULL,
        `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
        `restored_by` varchar(50) DEFAULT NULL,
        `date_restored` datetime DEFAULT NULL,
        PRIMARY KEY(`official_id`),
        FOREIGN KEY(`resident_id`) REFERENCES resident(`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `official_archive` (
        `official_archive_id` int(11) NOT NULL AUTO_INCREMENT,
        `official_id` int(11) NOT NULL,
        `resident_id` int(11) NOT NULL,
        `off_position` varchar(20) NOT NULL,
        `term` varchar(50) NOT NULL,
        `first_term_start` date NOT NULL,
        `first_term_end` date DEFAULT NULL,
        `second_term_start` date DEFAULT NULL,
        `second_term_end` date DEFAULT NULL,
        `third_term_start` date DEFAULT NULL,
        `third_term_end` date DEFAULT NULL,
        `created_by` varchar(50) NOT NULL,
        `date_created` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_by` varchar(50) DEFAULT NULL,
        `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
        `remarks` varchar(50) DEFAULT NULL,
        `archived_by` varchar(255) DEFAULT NULL,
        `date_archived` datetime DEFAULT NULL ON UPDATE current_timestamp(),
        PRIMARY KEY(`official_archive_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;


CREATE TABLE `certificate_type` (
  `certificate_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `certificate_type` varchar(100) NOT NULL,
  PRIMARY KEY(`certificate_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `fee_setting` (
  `fee_setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `certificate_type_id` int(11) NOT NULL,
  `certificate_purpose` varchar(255) DEFAULT NULL,
  `certificate_category` varchar(50) DEFAULT NULL,
  `fee` decimal(11, 2) NOT NULL,
  `remarks` text NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` varchar(50) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY(`fee_setting_id`),
  FOREIGN KEY (`certificate_type_id`) REFERENCES `certificate_type`(`certificate_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `barangay_clearance` (
        `brgy_clearance_id` int(11) NOT NULL AUTO_INCREMENT,
        `resident_id` int(11) NOT NULL,
        `official_id` int(11) NOT NULL,
        `fee_setting_id` int(11) NOT NULL,
        `purpose` varchar(50) NOT NULL,
        `category` varchar(20) NOT NULL,
        `receipt_number` varchar(8) NOT NULL,
        `cedula_number` varchar(8) NOT NULL,
        `cedula_issued_at` varchar(50) NOT NULL,
        `cedula_date` date NOT NULL,
        `issued_by` varchar(50) NOT NULL,
        `date_issued` datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY(`brgy_clearance_id`),
        FOREIGN KEY(`resident_id`) REFERENCES `resident`(`resident_id`),
        FOREIGN KEY(`official_id`) REFERENCES `official`(`official_id`),
        FOREIGN KEY(`fee_setting_id`) REFERENCES `fee_setting`(`fee_setting_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;


CREATE TABLE `good_moral_certificate` (
        `good_moral_id` int(11) NOT NULL AUTO_INCREMENT,
        `resident_id` int(11) NOT NULL,
        `official_id` int(11) NOT NULL,
        `fee_setting_id` int(11) NOT NULL,
        `purpose` varchar(50) NOT NULL,
        `issued_by` varchar(50) NOT NULL,
        `date_issued` datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY(`good_moral_id`),
        FOREIGN KEY(`resident_id`) REFERENCES resident(`resident_id`),
        FOREIGN KEY(`official_id`) REFERENCES official(`official_id`),
		FOREIGN KEY(`fee_setting_id`) REFERENCES fee_setting(`fee_setting_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `jobseeker_certificate` (
	`jobseeker_id` int(11) NOT NULL AUTO_INCREMENT,
    `resident_id` int(11) NOT NULL,
    `official_id` int(11) NOT NULL,
    `date_of_residency` date NOT NULL,
    `issued_by` varchar(50) NOT NULL,
	`date_issued` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY(`jobseeker_id`),
    FOREIGN KEY(`resident_id`) REFERENCES resident(`resident_id`),
    FOREIGN KEY(`official_id`) REFERENCES official(`official_id`)
);

CREATE TABLE `residency_certificate` (
	`residency_id` int(11) NOT NULL AUTO_INCREMENT,
    `resident_id` int(11) NOT NULL,
    `official_id` int(11) NOT NULL,
    `fee_setting_id` int(11) NOT NULL,
    `purpose` varchar(50) NOT NULL,
    `date_of_residency` date NOT NULL,
    `issued_by` varchar(50) NOT NULL,
	`date_issued` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY(`residency_id`),
    FOREIGN KEY(`resident_id`) REFERENCES resident(`resident_id`),
    FOREIGN KEY(`official_id`) REFERENCES official(`official_id`),
    FOREIGN KEY(`fee_setting_id`) REFERENCES fee_setting(`fee_setting_id`)
);

CREATE TABLE `osca_certificate` (
	`osca_id` int(11) NOT NULL AUTO_INCREMENT,
    `resident_id` int(11) NOT NULL,
    `official_id` int(11) NOT NULL,
    `fee_setting_id` int(11) NOT NULL,
    `purpose` varchar(50) NOT NULL,
    `date_of_residency` date NOT NULL,
    `issued_by` varchar(50) NOT NULL,
	`date_issued` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY(`osca_id`),
    FOREIGN KEY(`resident_id`) REFERENCES resident(`resident_id`),
    FOREIGN KEY(`official_id`) REFERENCES official(`official_id`),
    FOREIGN KEY(`fee_setting_id`) REFERENCES fee_setting(`fee_setting_id`)
);

CREATE TABLE `low_income_certificate` (
	`low_income_id` int(11) NOT NULL AUTO_INCREMENT,
    `resident_id` int(11) NOT NULL,
    `official_id` int(11) NOT NULL,
    `fee_setting_id` int(11) NOT NULL,
    `purpose` varchar(50) NOT NULL,
    `date_of_residency` date NOT NULL,
    `issued_by` varchar(50) NOT NULL,
	`date_issued` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY(`low_income_id`),
    FOREIGN KEY(`resident_id`) REFERENCES resident(`resident_id`),
    FOREIGN KEY(`official_id`) REFERENCES official(`official_id`),
    FOREIGN KEY(`fee_setting_id`) REFERENCES fee_setting(`fee_setting_id`)
);

CREATE TABLE `non_resident` (
		`non_resident_id` int(11) NOT NULL AUTO_INCREMENT,
        `first_name` varchar(255) NOT NULL,
        `mid_name` varchar(50) NOT NULL,
        `last_name` varchar(50) NOT NULL,
        `suffix` varchar(10) NOT NULL, 
        `purok` varchar(255) NOT NULL,
        `barangay` varchar(255) NOT NULL,
        `city` varchar(255) NOT NULL,
        `province` varchar(255) NOT NULL,
        `img_url` varchar(100) NOT NULL,
        `created_by` varchar(50) NOT NULL,
        `date_created` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_by` varchar(50) DEFAULT NULL,
        `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
        PRIMARY KEY(`non_resident_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;


CREATE TABLE `complainant` (
		`complainant_id` int(11) NOT NULL AUTO_INCREMENT,
		`resident_id` int(11) NULL,
        `non_resident_id` int(11) NULL,
        PRIMARY KEY(`complainant_id`),
        FOREIGN KEY(`resident_id`) REFERENCES `resident`(`resident_id`),
        FOREIGN KEY(`non_resident_id`) REFERENCES `non_resident`(`non_resident_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `respondent` (
		`respondent_id` int(11) NOT NULL AUTO_INCREMENT,
		`resident_id` int(11) NOT NULL,
        PRIMARY KEY(`respondent_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `mediator` (
	  `mediator_id` int(11) NOT NULL AUTO_INCREMENT,
	  `resident_id` int(11) NOT NULL,
	  `official_id` int(11) NOT NULL,
	  PRIMARY KEY (`mediator_id`),
      FOREIGN KEY(`resident_id`) REFERENCES resident(`resident_id`),
	  FOREIGN KEY(`official_id`) REFERENCES official(`official_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `complaint` (
		`case_no` int(11) NOT NULL AUTO_INCREMENT,
        `complainant_id` int(11) NOT NULL,
		`respondent_id` int(11) NOT NULL,
        `mediator_id` int(11) NOT NULL,
        `or_no` varchar(8) NOT NULL,
        `reason` varchar(255) NOT NULL,
        `complaint_description` text NOT NULL,
        `date_of_hearing` date NOT NULL,
        `time_of_hearing` time NOT NULL,
        `action_taken` varchar(255) NOT NULL,
        `complaint_status` varchar(50) NOT NULL,
        `is_complainant_resident` boolean NOT NULL, 
		`created_by` varchar(50) NOT NULL,
        `date_created` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_by` varchar(50) DEFAULT NULL,
        `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
        `restored_by` varchar(50) DEFAULT NULL,
        `date_restored` datetime DEFAULT NULL,
        PRIMARY KEY(`case_no`),
        FOREIGN KEY(`complainant_id`) REFERENCES `complainant`(`complainant_id`),
        FOREIGN KEY(`respondent_id`) REFERENCES `respondent`(`respondent_id`),
        FOREIGN KEY(`mediator_id`) REFERENCES `mediator`(`mediator_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `complaint_archive` (
		`complaint_archive_id` int(11) NOT NULL AUTO_INCREMENT,
		`case_no` int(11) NOT NULL,
        `complainant_id` int(11) NOT NULL,
		`respondent_id` int(11) NOT NULL,
        `mediator_id` int(11) NOT NULL,
        `or_no` varchar(8) NOT NULL,
        `reason` varchar(255) NOT NULL,
        `complaint_description` varchar(255) NOT NULL,
        `date_of_hearing` datetime NOT NULL,
        `time_of_hearing` time NOT NULL,
        `action_taken` varchar(255) NOT NULL,
        `complaint_status` varchar(50) NOT NULL,
		`created_by` varchar(50) NOT NULL,
        `date_created` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_by` varchar(50) DEFAULT NULL,
        `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
        `remarks` varchar(255) DEFAULT NULL,
        `archived_by` varchar(100) DEFAULT NULL,
        `date_archived` datetime DEFAULT NULL,
        PRIMARY KEY(`complaint_archive_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `announcement` (
  `announcement_id` int(11) NOT NULL AUTO_INCREMENT,
  `official_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `recipients` varchar(255) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` varchar(50) NOT NULL,
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY(`announcement_id`),
  FOREIGN KEY(`official_id`) REFERENCES `official`(`official_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
        `user_id` int(11) NOT NULL AUTO_INCREMENT,
        `resident_id` int(11) NULL,
        `official_id` int(11) NULL,
        `username` varchar(50) NOT NULL,
        `password` varchar(50) NOT NULL,
        `role` varchar(40) NOT NULL,
        PRIMARY KEY(`user_id`),
        FOREIGN KEY(`resident_id`) REFERENCES resident(`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(`official_id`) REFERENCES official(`official_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;


SET FOREIGN_KEY_CHECKS = 0;
INSERT INTO `users` (`user_id`, `resident_id`, `official_id`, `username`, `password`, `role`) VALUES
(1, NULL, NULL, 'administrator', 'b6f8ebf6b21eb164447365d0582e3ce6', 'Administrator');
-- ------------------------------------------------------------------------------------------------------------------------------------------------

-- VIEWS

-- View to retrieve all information of residents.
CREATE VIEW resident_view AS
SELECT *
FROM resident;

CREATE VIEW user_view AS
SELECT u.user_id, r.resident_id, o.official_id, r.last_name, r.first_name, r.mid_name, r.suffix, r.img_url, u.username, u.password, u.role, o.off_position
FROM users u 
LEFT JOIN resident r ON u.resident_id = r.resident_id
LEFT JOIN official o ON u.official_id = o.official_id;

-- View to retrieve information of resident, officials and their positions
CREATE VIEW official_view AS
SELECT o.official_id, r.resident_id, r.last_name, r.first_name, r.mid_name, r.suffix, r.img_url, o.off_position, o.term,
o.first_term_start, o.first_term_end, o.second_term_start, o.second_term_end, o.third_term_start, o.third_term_end,
r.phone_number, r.email, r.emergency_person, r.relationship, r.emergency_address, r.emergency_contact,
o.created_by, o.date_created, o.updated_by, o.date_updated, o.restored_by, o.date_restored
FROM official o
LEFT JOIN resident r ON o.resident_id = r.resident_id;

CREATE VIEW brgy_clearance_view AS
SELECT c.brgy_clearance_id, COALESCE(r1.resident_id, ra1.resident_id) AS resident_id, COALESCE(o.official_id, oa.official_id) AS official_id, fs.fee_setting_id,
COALESCE(CONCAT(r1.first_name, ' ', r1.mid_name, ' ', r1.last_name, ' ',  r1.suffix), CONCAT(ra1.first_name, ' ', ra1.mid_name, ' ', ra1.last_name, ' ', ra1.suffix)) AS resident_name,
COALESCE(r1.sex, r2.sex) AS sex,
COALESCE(r1.civil_status, ra1.civil_status) AS civil_status,
COALESCE(r1.nationality, ra1.nationality) AS nationality,
COALESCE(CONCAT(r2.last_name, ', ', r2.first_name, ' ', r2.mid_name, ' ', r2.suffix),  CONCAT(r3.last_name, ', ', r3.first_name, ' ', r3.mid_name, ' ', r3.suffix), CONCAT(ra2.last_name, ', ', ra2.first_name, ' ', ra2.mid_name, ' ', ra2.suffix)) AS official_name,
COALESCE(CONCAT(r1.purok, ', ', r1.street, ', ', r1.lot_number), CONCAT(ra1.purok, ', ', ra1.street, ', ', ra1.lot_number)) AS address, COALESCE(r1.fourps_status, ra1.fourps_status) AS fourps_status,
c.purpose, c.category, c.receipt_number, c.cedula_number, c.cedula_issued_at, c.cedula_date, c.issued_by, c.date_issued, ct.certificate_type, fs.certificate_purpose, fs.certificate_category, fs.fee, 
COALESCE(r1.img_url, ra1.img_url) AS resident_image
FROM barangay_clearance c 
LEFT JOIN official o ON o.official_id = c.official_id
LEFT JOIN official_archive oa ON oa.official_id = c.official_id
LEFT JOIN resident r1 ON r1.resident_id = c.resident_id
LEFT JOIN resident_archive ra1 ON ra1.resident_id = c.resident_id
LEFT JOIN resident r2 ON r2.resident_id = o.resident_id
LEFT JOIN resident r3 ON r3.resident_id = oa.resident_id
LEFT JOIN resident_archive ra2 ON ra2.resident_id = oa.resident_id
LEFT JOIN fee_setting fs ON fs.fee_setting_id = c.fee_setting_id
LEFT JOIN certificate_type ct ON ct.certificate_type_id = fs.certificate_type_id;

CREATE VIEW good_moral_certificate_view AS
SELECT c.good_moral_id, COALESCE(r1.resident_id, ra1.resident_id) AS resident_id, COALESCE(o.official_id, oa.official_id) AS official_id, 
COALESCE(CONCAT(r1.first_name, ' ', r1.mid_name, ' ', r1.suffix, r1.last_name), CONCAT(ra1.first_name, ' ', ra1.mid_name, ' ', ra1.suffix, ra1.last_name)) AS resident_name,
COALESCE(CONCAT(r2.first_name, ' ', r2.mid_name, ' ', r2.suffix, r2.last_name), CONCAT(r3.first_name, ' ', r3.mid_name, ' ', r3.suffix, r3.last_name), CONCAT(ra2.first_name, ' ', ra2.mid_name, ' ', ra2.suffix, ra2.last_name)) AS official_name,
COALESCE(CONCAT(r1.purok, ', ', r1.street, ', ', r1.lot_number), CONCAT(ra1.purok, ', ', ra1.street, ', ', ra1.lot_number)) AS address,
COALESCE(r1.civil_status, ra1.civil_status) AS civil_status,
COALESCE(r1.nationality, ra1.nationality) AS nationality,
c.purpose, fs.fee, c.issued_by, c.date_issued, COALESCE(r1.img_url, ra1.img_url) AS resident_image
FROM good_moral_certificate c 
LEFT JOIN official o ON o.official_id = c.official_id
LEFT JOIN official_archive oa ON oa.official_id = c.official_id
LEFT JOIN resident r1 ON r1.resident_id = c.resident_id
LEFT JOIN resident_archive ra1 ON ra1.resident_id = c.resident_id
LEFT JOIN resident r2 ON r2.resident_id = o.resident_id 
LEFT JOIN resident r3 ON r3.resident_id = oa.resident_id
LEFT JOIN resident_archive ra2 ON ra2.resident_id = oa.resident_id
LEFT JOIN fee_setting fs ON fs.fee_setting_id = c.fee_setting_id;

CREATE VIEW jobseeker_certificate_view AS
SELECT c.jobseeker_id, COALESCE(r1.resident_id, ra1.resident_id) AS resident_id, COALESCE(o.official_id, oa.official_id) AS official_id, 
COALESCE(CONCAT(r1.first_name, ' ', r1.mid_name, ' ', r1.suffix, r1.last_name), CONCAT(ra1.first_name, ' ', ra1.mid_name, ' ', ra1.suffix, ra1.last_name)) AS resident_name,
COALESCE(CONCAT(r2.first_name, ' ', r2.mid_name, ' ', r2.suffix, r2.last_name), CONCAT(r3.first_name, ' ', r3.mid_name, ' ', r3.suffix, r3.last_name), CONCAT(ra2.first_name, ' ', ra2.mid_name, ' ', ra2.suffix, ra2.last_name)) AS official_name,
COALESCE(CONCAT(r1.purok, ', ', r1.street, ', ', r1.lot_number), CONCAT(ra1.purok, ', ', ra1.street, ', ', ra1.lot_number)) AS address,
COALESCE(r1.date_of_birth, ra1.date_of_birth) AS date_of_birth,
COALESCE(r1.civil_status, ra1.civil_status) AS civil_status,
COALESCE(r1.nationality, ra1.nationality) AS nationality,
c.date_of_residency, c.issued_by, c.date_issued, COALESCE(r1.img_url, ra1.img_url) AS resident_image
FROM jobseeker_certificate c 
LEFT JOIN official o ON o.official_id = c.official_id
LEFT JOIN official_archive oa ON oa.official_id = c.official_id
LEFT JOIN resident r1 ON r1.resident_id = c.resident_id
LEFT JOIN resident_archive ra1 ON ra1.resident_id = c.resident_id
LEFT JOIN resident r2 ON r2.resident_id = o.resident_id 
LEFT JOIN resident r3 ON r3.resident_id = oa.resident_id
LEFT JOIN resident_archive ra2 ON ra2.resident_id = oa.resident_id;

CREATE VIEW osca_certificate_view AS
SELECT c.osca_id, COALESCE(r1.resident_id, ra1.resident_id) AS resident_id, COALESCE(o.official_id, oa.official_id) AS official_id, 
COALESCE(CONCAT(r1.first_name, ' ', r1.mid_name, ' ', r1.suffix, r1.last_name), CONCAT(ra1.first_name, ' ', ra1.mid_name, ' ', ra1.suffix, ra1.last_name)) AS resident_name,
COALESCE(CONCAT(r2.first_name, ' ', r2.mid_name, ' ', r2.suffix, r2.last_name), CONCAT(r3.first_name, ' ', r3.mid_name, ' ', r3.suffix, r3.last_name), CONCAT(ra2.first_name, ' ', ra2.mid_name, ' ', ra2.suffix, ra2.last_name)) AS official_name,
COALESCE(CONCAT(r1.purok, ', ', r1.street, ', ', r1.lot_number), CONCAT(ra1.purok, ', ', ra1.street, ', ', ra1.lot_number)) AS address,
COALESCE(r1.date_of_birth, ra1.date_of_birth) AS date_of_birth,
COALESCE(r1.place_of_birth, ra1.place_of_birth) AS place_of_birth,
COALESCE(r1.civil_status, ra1.civil_status) AS civil_status,
COALESCE(r1.nationality, ra1.nationality) AS nationality,
c.purpose, c.date_of_residency, fs.fee, c.issued_by, c.date_issued, COALESCE(r1.img_url, ra1.img_url) AS resident_image
FROM osca_certificate c 
LEFT JOIN official o ON o.official_id = c.official_id
LEFT JOIN official_archive oa ON oa.official_id = c.official_id
LEFT JOIN resident r1 ON r1.resident_id = c.resident_id
LEFT JOIN resident_archive ra1 ON ra1.resident_id = c.resident_id
LEFT JOIN resident r2 ON r2.resident_id = o.resident_id 
LEFT JOIN resident r3 ON r3.resident_id = oa.resident_id
LEFT JOIN resident_archive ra2 ON ra2.resident_id = oa.resident_id
LEFT JOIN fee_setting fs ON fs.fee_setting_id = c.fee_setting_id;

CREATE VIEW residency_certificate_view AS
SELECT c.residency_id, COALESCE(r1.resident_id, ra1.resident_id) AS resident_id, COALESCE(o.official_id, oa.official_id) AS official_id, 
COALESCE(CONCAT(r1.first_name, ' ', r1.mid_name, ' ', r1.suffix, r1.last_name), CONCAT(ra1.first_name, ' ', ra1.mid_name, ' ', ra1.suffix, ra1.last_name)) AS resident_name,
COALESCE(CONCAT(r2.first_name, ' ', r2.mid_name, ' ', r2.suffix, r2.last_name), CONCAT(r3.first_name, ' ', r3.mid_name, ' ', r3.suffix, r3.last_name), CONCAT(ra2.first_name, ' ', ra2.mid_name, ' ', ra2.suffix, ra2.last_name)) AS official_name,
COALESCE(CONCAT(r1.purok, ', ', r1.street, ', ', r1.lot_number), CONCAT(ra1.purok, ', ', ra1.street, ', ', ra1.lot_number)) AS address,
COALESCE(r1.civil_status, ra1.civil_status) AS civil_status,
COALESCE(r1.nationality, ra1.nationality) AS nationality,
c.purpose, c.date_of_residency, fs.fee, c.issued_by, c.date_issued, COALESCE(r1.img_url, ra1.img_url) AS resident_image
FROM residency_certificate c 
LEFT JOIN official o ON o.official_id = c.official_id
LEFT JOIN official_archive oa ON oa.official_id = c.official_id
LEFT JOIN resident r1 ON r1.resident_id = c.resident_id
LEFT JOIN resident_archive ra1 ON ra1.resident_id = c.resident_id
LEFT JOIN resident r2 ON r2.resident_id = o.resident_id 
LEFT JOIN resident r3 ON r3.resident_id = oa.resident_id
LEFT JOIN resident_archive ra2 ON ra2.resident_id = oa.resident_id
LEFT JOIN fee_setting fs ON fs.fee_setting_id = c.fee_setting_id;

CREATE VIEW low_income_certificate_view AS
SELECT c.low_income_id, COALESCE(r1.resident_id, ra1.resident_id) AS resident_id, COALESCE(o.official_id, oa.official_id) AS official_id, 
COALESCE(CONCAT(r1.first_name, ' ', r1.mid_name, ' ', r1.suffix, r1.last_name), CONCAT(ra1.first_name, ' ', ra1.mid_name, ' ', ra1.suffix, ra1.last_name)) AS resident_name,
COALESCE(CONCAT(r2.first_name, ' ', r2.mid_name, ' ', r2.suffix, r2.last_name), CONCAT(r3.first_name, ' ', r3.mid_name, ' ', r3.suffix, r3.last_name), CONCAT(ra2.first_name, ' ', ra2.mid_name, ' ', ra2.suffix, ra2.last_name)) AS official_name,
COALESCE(CONCAT(r1.purok, ', ', r1.street, ', ', r1.lot_number), CONCAT(ra1.purok, ', ', ra1.street, ', ', ra1.lot_number)) AS address,
COALESCE(r1.civil_status, ra1.civil_status) AS civil_status,
COALESCE(r1.nationality, ra1.nationality) AS nationality,
c.purpose, c.date_of_residency, fs.fee, c.issued_by, c.date_issued, COALESCE(r1.img_url, ra1.img_url) AS resident_image
FROM low_income_certificate c 
LEFT JOIN official o ON o.official_id = c.official_id
LEFT JOIN official_archive oa ON oa.official_id = c.official_id
LEFT JOIN resident r1 ON r1.resident_id = c.resident_id
LEFT JOIN resident_archive ra1 ON ra1.resident_id = c.resident_id
LEFT JOIN resident r2 ON r2.resident_id = o.resident_id 
LEFT JOIN resident r3 ON r3.resident_id = oa.resident_id
LEFT JOIN resident_archive ra2 ON ra2.resident_id = oa.resident_id
LEFT JOIN fee_setting fs ON fs.fee_setting_id = c.fee_setting_id;


-- View the details of resident complaints along with the names of complainants, respondents, and mediator
CREATE VIEW resident_complaint_view AS
SELECT comp.case_no, com.complainant_id, com.resident_id AS complainant_resident_id, res.respondent_id, res.resident_id AS respondent_resident_id, med.mediator_id, med.official_id, 
CONCAT(c.last_name, ', ', c.first_name, ' ', c.mid_name, ' ', c.suffix) AS complainant_name, CONCAT(c.purok, ', ', c.street, ', ', c.lot_number) AS complainant_address, c.img_url AS complainant_image,
CONCAT(r.last_name, ', ', r.first_name, ' ', r.mid_name, ' ', r.suffix) AS respondent_name, CONCAT(r.purok, ', ', r.street, ', ', r.lot_number) AS respondent_address, o.off_position, r.img_url AS respondent_image,
CONCAT(m.last_name, ', ', m.first_name, ' ', m.mid_name, ' ', m.suffix) AS mediator_name, m.img_url AS mediator_image,
comp.or_no, comp.reason, comp.complaint_description, comp.date_of_hearing, comp.time_of_hearing, comp.action_taken, comp.complaint_status,
comp.created_by, comp.date_created, comp.updated_by, comp.date_updated
FROM complaint comp
LEFT JOIN complainant com ON comp.complainant_id = com.complainant_id
LEFT JOIN respondent res ON comp.respondent_id = res.respondent_id
LEFT JOIN mediator med ON comp.mediator_id = med.mediator_id
LEFT JOIN official o ON med.official_id = o.official_id
LEFT JOIN resident c ON c.resident_id = com.resident_id
LEFT JOIN resident r ON r.resident_id = res.resident_id
LEFT JOIN resident m ON m.resident_id = o.resident_id
WHERE is_complainant_resident = 1
ORDER BY comp.case_no ASC;

-- View the details of non resident complaints along with the names of complainants, respondents, and mediator
CREATE VIEW non_resident_complaint_view AS
SELECT comp.case_no, com.complainant_id, com.non_resident_id AS complainant_non_resident_id, res.respondent_id, res.resident_id AS respondent_resident_id, med.mediator_id, med.official_id, 
CONCAT(nr.last_name, ', ', nr.first_name, ' ', nr.mid_name, ' ', nr.suffix) AS complainant_name, CONCAT(nr.purok, ', ', nr.barangay, ', ', nr.city, ', ', nr.province) AS complainant_address, nr.img_url AS complainant_image,
CONCAT(r.last_name, ', ', r.first_name, ' ', r.mid_name, ' ', r.suffix) AS respondent_name, CONCAT(r.purok, ', ', r.street, ', ', r.lot_number) AS respondent_address, o.off_position, r.img_url AS respondent_image,
CONCAT(m.last_name, ', ', m.first_name, ' ', m.mid_name, ' ', m.suffix) AS mediator_name, m.img_url AS mediator_image,
comp.or_no, comp.reason, comp.complaint_description, comp.date_of_hearing, comp.time_of_hearing, comp.action_taken, comp.complaint_status,
comp.created_by, comp.date_created, comp.updated_by, comp.date_updated
FROM complaint comp
LEFT JOIN complainant com ON comp.complainant_id = com.complainant_id
LEFT JOIN respondent res ON comp.respondent_id = res.respondent_id
LEFT JOIN mediator med ON comp.mediator_id = med.mediator_id
LEFT JOIN official o ON med.official_id = o.official_id
LEFT JOIN non_resident nr ON nr.non_resident_id = com.non_resident_id
LEFT JOIN resident r ON r.resident_id = res.resident_id
LEFT JOIN resident m ON m.resident_id = o.resident_id
WHERE is_complainant_resident = 0
ORDER BY comp.case_no ASC;


CREATE VIEW fee_view AS 
SELECT fs.fee_setting_id, ct.certificate_type_id, ct.certificate_type, fs.certificate_purpose, fs.certificate_category, fs.fee, fs.remarks, 
fs.created_by, fs.date_created, fs.updated_by, fs.date_updated 
FROM fee_setting fs
LEFT JOIN certificate_type ct ON ct.certificate_type_id = fs.certificate_type_id;
-- ---------------------------------------------------------------------------------------------------------------------------------------------

-- FUNCTIONS

-- Get the resident id
DELIMITER //
CREATE FUNCTION resident_name(residentID INT)
RETURNS VARCHAR(255)
READS SQL DATA
BEGIN
    DECLARE residentInfo VARCHAR(255);
    SELECT CONCAT(first_name, ' ', mid_name, ' ', last_name, ' ', suffix) AS Full_Name    
    INTO residentInfo
    FROM resident_view
    WHERE resident_id = residentID;
    RETURN residentInfo;
END //
DELIMITER ;

-- Count the resident complaint record
DELIMITER //
CREATE FUNCTION resident_complaint_status(complaint_no INT)
RETURNS varchar(255)
READS SQL DATA
BEGIN
    DECLARE complaintStatus varchar(255);
    SELECT complaint_status INTO complaintStatus
    FROM resident_complaint_view
    WHERE case_no = complaint_no;
    RETURN complaintStatus;
END //
DELIMITER ;

-- Function to get the age of a resident
DELIMITER //
CREATE FUNCTION resident_age(residentId INT) 
RETURNS INT
READS SQL DATA
BEGIN
    DECLARE age INT;
    SELECT TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) INTO age
    FROM resident_view
    WHERE resident_id = residentId;
    RETURN age;
END//
DELIMITER ;

-- Function to get the total number of barangay clearances issued for a resident
DELIMITER //
CREATE FUNCTION resident_clearance_count(residentId INT) 
RETURNS INT
READS SQL DATA
BEGIN
    DECLARE clearance_count INT;
    SELECT Full_Name, COUNT(brgy_clearance_id) AS 'Brgy_Clearance_id' INTO clearance_count
    FROM barangay_clearance_view
    WHERE resident_id = residentId
    GROUP BY Full_Name;
    RETURN clearance_count;
END//
DELIMITER ;
-- ----------------------------------------------------------------------------------------------------------------------
-- Stored Procedure
DELIMITER //

CREATE PROCEDURE insert_resident(
    IN p_first_name VARCHAR(255), IN p_mid_name VARCHAR(50), IN p_last_name VARCHAR(50), IN p_suffix VARCHAR(10), IN p_sex VARCHAR(20), IN p_date_of_birth DATE, IN p_place_of_birth VARCHAR(255),
    IN p_civil_status VARCHAR(20), IN p_nationality VARCHAR(20), IN p_occupation VARCHAR(50), IN p_religion VARCHAR(50), IN p_blood_type VARCHAR(10), IN p_fourps_status VARCHAR(5), IN p_disability_status VARCHAR(30),
    IN p_type_disability VARCHAR(50), IN p_senior_status VARCHAR(20), IN p_educational_attainment VARCHAR(30), IN p_phone_number VARCHAR(11), IN p_tel_number VARCHAR(12), IN p_email VARCHAR(100), IN p_purok VARCHAR(20),
    IN p_street VARCHAR(50), IN p_lot_number VARCHAR(20), IN p_voter_status VARCHAR(20), IN p_voter_id VARCHAR(20), IN p_precinct_number VARCHAR(20), IN p_national_id VARCHAR(55), IN p_vaccine_status VARCHAR(10),
    IN p_vaccine_1 VARCHAR(15), IN p_vaccine_date_1 DATE, IN p_vaccine_2 VARCHAR(15), IN p_vaccine_date_2 DATE, IN p_booster_status VARCHAR(10), IN p_booster_1 VARCHAR(15), IN p_booster_date_1 DATE,
    IN p_booster_2 VARCHAR(15), IN p_booster_date_2 DATE, IN p_emergency_person VARCHAR(255), IN p_relationship VARCHAR(20), IN p_emergency_address VARCHAR(255), IN p_emergency_contact VARCHAR(12), IN p_img_url VARCHAR(255), IN p_alien_status VARCHAR(50), IN p_deceased_status VARCHAR(50), IN p_date_of_death DATE, IN p_created_by VARCHAR(50)
)
BEGIN
    INSERT INTO resident (
        first_name, mid_name, last_name, suffix, sex, date_of_birth, place_of_birth, civil_status, nationality, occupation, religion, blood_type, fourps_status, disability_status,
        type_disability, senior_status, educational_attainment, phone_number, tel_number, email, purok, street, lot_number, voter_status, voter_id, precinct_number,
        national_id, vaccine_status, vaccine_1, vaccine_date_1, vaccine_2, vaccine_date_2, booster_status, booster_1, booster_date_1, booster_2, booster_date_2, emergency_person, relationship,
        emergency_address,emergency_contact, img_url, alien_status, deceased_status, date_of_death, created_by
    ) VALUES (
        p_first_name, p_mid_name, p_last_name, p_suffix, p_sex, p_date_of_birth, p_place_of_birth, p_civil_status, p_nationality, p_occupation, p_religion, p_blood_type,
        p_fourps_status, p_disability_status, p_type_disability, p_senior_status, p_educational_attainment, p_phone_number, p_tel_number, p_email, p_purok,
        p_street, p_lot_number, p_voter_status, p_voter_id, p_precinct_number, p_national_id, p_vaccine_status, p_vaccine_1, p_vaccine_date_1, p_vaccine_2, p_vaccine_date_2, p_booster_status,
        p_booster_1, p_booster_date_1, p_booster_2, p_booster_date_2, p_emergency_person, p_relationship, p_emergency_address, p_emergency_contact, p_img_url, p_alien_status, p_deceased_status,
        p_date_of_death, p_created_by
    );
END //

CREATE PROCEDURE insert_official(
    IN p_resident_id INT, IN p_off_position VARCHAR(20), IN p_term VARCHAR(50), IN p_first_term_start DATE, IN p_first_term_end DATE, IN p_second_term_start DATE, IN p_second_term_end DATE, IN p_third_term_start DATE,
    IN p_third_term_end DATE, IN p_created_by VARCHAR(50)
)
BEGIN
    INSERT INTO official (
        resident_id, off_position, term, first_term_start, first_term_end, second_term_start, second_term_end, third_term_start, third_term_end, created_by
    ) VALUES (
        p_resident_id, p_off_position, p_term, p_first_term_start, p_first_term_end, p_second_term_start, p_second_term_end, p_third_term_start, p_third_term_end, p_created_by
    );
END //

CREATE PROCEDURE insert_complainant(
    IN p_resident_id INT
)
BEGIN
    INSERT INTO complainant (resident_id)
    VALUES (p_resident_id);
END //

CREATE PROCEDURE insert_respondent(
    IN p_resident_id INT
)
BEGIN
    INSERT INTO respondent (resident_id)
    VALUES (p_resident_id);
END //

CREATE PROCEDURE insert_mediator(
    IN p_resident_id INT,
    IN p_official_id INT
)
BEGIN
    INSERT INTO mediator (resident_id, official_id)
    VALUES (p_resident_id, p_official_id);
END //

CREATE PROCEDURE insert_complaint(
    IN p_complainant_id INT, IN p_respondent_id INT, IN p_mediator_id INT, IN p_or_no INT, IN p_reason VARCHAR(255), IN p_complaint_description VARCHAR(255),
    IN p_date_of_hearing TIMESTAMP, IN p_action_taken VARCHAR(255), IN p_complaint_status VARCHAR(50), IN p_created_by VARCHAR(50)
)
BEGIN
    INSERT INTO complaint (
        complainant_id, respondent_id, mediator_id, or_no, reason, complaint_description, date_of_hearing, action_taken, complaint_status, created_by
    ) VALUES (
        p_complainant_id, p_respondent_id, p_mediator_id, p_or_no, p_reason, p_complaint_description, p_date_of_hearing, p_action_taken, p_complaint_status, p_created_by
    );
END //

CREATE PROCEDURE insert_user(
    IN p_resident_id INT, IN p_official_id INT, IN p_username VARCHAR(50), IN p_password VARCHAR(50), IN p_role VARCHAR(40)
)
BEGIN
    INSERT INTO users (resident_id, official_id, username, password, role)
    VALUES (p_resident_id, p_official_id, p_username, p_password, p_role);
END //

DELIMITER ;


-- --------------------------------------------------------------------------------------------------------------------------
-- ADMINISTRATOR - HAVE ALL OF THE PRIVILEGES

CREATE ROLE 'superadmin'; 
GRANT ALL PRIVILEGES ON *.* TO 'superadmin' WITH GRANT OPTION;


CREATE USER 'brgy_administrator' IDENTIFIED BY 'Brgy_superAdmin1';
GRANT USAGE ON fatimadb.* TO 'brgy_administrator';
GRANT superadmin TO 'brgy_administrator';

-- ROLES
CREATE ROLE 'captain'; 
GRANT SELECT ON fatimadb.resident TO 'captain';
GRANT SELECT ON fatimadb.complaint TO 'captain';
GRANT SELECT ON fatimadb.complainant TO 'captain';
GRANT SELECT ON fatimadb.respondent TO 'captain';
GRANT SELECT ON fatimadb.mediator TO 'captain';
GRANT SHOW VIEW, SELECT ON fatimadb.resident_view TO 'captain';

CREATE ROLE 'secretary'; 
GRANT INSERT, SELECT, UPDATE ON fatimadb.users TO 'secretary';
GRANT INSERT, SELECT, UPDATE ON fatimadb.resident TO 'secretary';
GRANT INSERT, SELECT, UPDATE ON fatimadb.resident_archive TO 'secretary';
GRANT INSERT, SELECT, UPDATE ON fatimadb.complaint TO 'secretary';
GRANT INSERT, SELECT, UPDATE ON fatimadb.complainant TO 'secretary';
GRANT INSERT, SELECT, UPDATE ON fatimadb.respondent TO 'secretary';
GRANT INSERT, SELECT, UPDATE ON fatimadb.mediator TO 'secretary';
GRANT INSERT, SELECT, UPDATE ON fatimadb.complaint_archive TO 'secretary';
GRANT INSERT, SELECT, UPDATE ON fatimadb.official TO 'secretary';
GRANT INSERT, SELECT, UPDATE ON fatimadb.official_archive TO 'secretary';
GRANT SHOW VIEW, SELECT ON fatimadb.* TO 'secretary';
GRANT EXECUTE ON fatimadb.* TO 'secretary';

CREATE ROLE 'resident_admin'; 
GRANT INSERT, SELECT, UPDATE ON fatimadb.users TO 'resident_admin';
GRANT INSERT, SELECT, UPDATE, DELETE ON fatimadb.resident TO 'resident_admin';
GRANT INSERT, SELECT, UPDATE ON fatimadb.resident_archive TO 'resident_admin';
GRANT INSERT, SELECT, UPDATE ON fatimadb.official TO 'resident_admin';
GRANT INSERT, SELECT, UPDATE ON fatimadb.official_archive TO 'resident_admin';
GRANT SHOW VIEW, SELECT ON fatimadb.official_info_view TO 'resident_admin';
GRANT SHOW VIEW, SELECT ON fatimadb.resident_view TO 'resident_admin';
GRANT SHOW VIEW, SELECT ON fatimadb.brgy_clearance_view TO 'resident_admin';
GRANT EXECUTE ON FUNCTION fatimadb.resident_age TO 'resident_admin';
GRANT EXECUTE ON FUNCTION fatimadb.resident_name TO 'resident_admin';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_user TO 'resident_admin';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_resident TO 'resident_admin';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_official TO 'resident_admin';

CREATE ROLE 'resident_encoder'; 
GRANT INSERT, SELECT ON fatimadb.resident TO 'resident_encoder';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_resident TO 'resident_encoder';

CREATE ROLE 'complaint_admin';
GRANT INSERT, SELECT, UPDATE ON fatimadb.users TO 'complaint_admin';
GRANT SELECT ON fatimadb.resident TO 'complaint_admin';
GRANT INSERT, SELECT, UPDATE, DELETE ON fatimadb.complaint TO 'complaint_admin';
GRANT INSERT, SELECT, UPDATE ON fatimadb.complaint_archive TO 'complaint_admin';
GRANT INSERT, SELECT, UPDATE, DELETE ON fatimadb.complainant TO 'complaint_admin';
GRANT INSERT, SELECT, UPDATE, DELETE ON fatimadb.respondent TO 'complaint_admin';
GRANT INSERT, SELECT, UPDATE, DELETE ON fatimadb.mediator TO 'complaint_admin';
GRANT INSERT, SELECT, UPDATE ON fatimadb.official TO 'complaint_admin';
GRANT INSERT, SELECT, UPDATE ON fatimadb.official_archive TO 'complaint_admin';
GRANT SHOW VIEW, SELECT ON fatimadb.* TO 'complaint_admin';
GRANT EXECUTE ON FUNCTION fatimadb.resident_complaint_status TO 'complaint_admin';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_user TO 'complaint_admin';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_complaint TO 'complaint_admin';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_complainant TO 'complaint_admin';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_mediator TO 'complaint_admin';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_respondent TO 'complaint_admin';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_official TO 'complaint_admin';

CREATE ROLE 'complaint_encoder';
GRANT SELECT ON fatimadb.resident TO 'complaint_encoder';
GRANT INSERT, SELECT ON fatimadb.complaint TO 'complaint_encoder';
GRANT INSERT, SELECT ON fatimadb.complainant TO 'complaint_encoder';
GRANT INSERT, SELECT ON fatimadb.respondent TO 'complaint_encoder';
GRANT INSERT, SELECT ON fatimadb.mediator TO 'complaint_encoder';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_complaint TO 'complaint_encoder';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_complainant TO 'complaint_encoder';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_respondent TO 'complaint_encoder';
GRANT EXECUTE ON PROCEDURE fatimadb.insert_mediator TO 'complaint_encoder';

-- USER
-- Create users with their corresponding privileges

-- BARANGAY CAPTAIN
CREATE USER 'brgy_captain' IDENTIFIED BY 'Brgy_captain2';
GRANT captain TO 'brgy_captain';

-- BARANGAY SECRETARY
CREATE USER 'brgy_secretary' IDENTIFIED BY 'Brgy_secretary3';
GRANT secretary TO 'brgy_secretary';

-- BARANGAY CLERK - RESIDENT PROFILE ADMIN
CREATE USER 'clerk_resident_admin' IDENTIFIED BY 'Clerk_residentAdmin4';
GRANT resident_admin TO 'clerk_resident_admin';

-- BARANGAY CLERK - RESIDENT PROFILE ENCODER
CREATE USER 'clerk_resident_encoder' IDENTIFIED BY 'Clerk_residentEncoder5';
GRANT resident_encoder TO 'clerk_resident_encoder';

-- BARANGAY CLERK - COMPLAINT COMPLAINT ADMIN
CREATE USER 'clerk_complaint_admin' IDENTIFIED BY 'Clerk_complaintAdmin6';
GRANT complaint_admin TO 'clerk_complaint_admin';

-- BARANGAY CLERK - RESIDENT COMPLAINT ENCODER
CREATE USER 'clerk_complaint_encoder' IDENTIFIED BY 'Clerk_complaintEncoder7';
GRANT complaint_encoder TO 'clerk_complaint_encoder';

FLUSH PRIVILEGES;