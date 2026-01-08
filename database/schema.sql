-- ========================================
-- COMPLETE SCHOOL ERP DATABASE SCHEMA
-- ========================================
-- Version: 1.0
-- Database: school_erp
-- Author: School Management System
-- Date: January 04, 2026
-- Description: Comprehensive school management system database
-- ========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ========================================
-- CREATE DATABASE
-- ========================================

CREATE DATABASE IF NOT EXISTS `school_erp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `school_erp`;

-- ========================================
-- CORE USER MANAGEMENT
-- ========================================

-- Table: users
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','student','parent') NOT NULL DEFAULT 'student',
  `email` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_role` (`role`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: roles
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: permissions
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_permission` (`module`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: role_permissions
CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_role_permission` (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `fk_role_permissions_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_role_permissions_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: user_roles
CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_role` (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `fk_user_roles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_roles_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: user_preferences
CREATE TABLE `user_preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `sms_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `push_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `notification_categories` text DEFAULT NULL,
  `language` varchar(10) NOT NULL DEFAULT 'en',
  `theme` enum('Light','Dark','Auto') NOT NULL DEFAULT 'Light',
  `date_format` varchar(20) NOT NULL DEFAULT 'Y-m-d',
  `time_format` varchar(20) NOT NULL DEFAULT 'H:i',
  `timezone` varchar(50) NOT NULL DEFAULT 'Africa/Lagos',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `fk_user_preferences_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- ACADEMIC STRUCTURE
-- ========================================

-- Table: academic_sessions
CREATE TABLE `academic_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_name` (`session_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: terms
CREATE TABLE `terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `term_name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `fk_terms_session` FOREIGN KEY (`session_id`) REFERENCES `academic_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: classes
CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `section` varchar(10) NOT NULL,
  `class_teacher_id` int(11) DEFAULT NULL,
  `capacity` int(11) NOT NULL DEFAULT 40,
  `room_number` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_class_teacher_id` (`class_teacher_id`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: subjects
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `type` enum('Theory','Practical','Both') NOT NULL DEFAULT 'Theory',
  `description` text DEFAULT NULL,
  `credit_hours` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: class_subjects
CREATE TABLE `class_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_class_subject` (`class_id`,`subject_id`),
  KEY `subject_id` (`subject_id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `fk_class_subjects_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_class_subjects_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: grading_system
CREATE TABLE `grading_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade` varchar(5) NOT NULL,
  `min_marks` decimal(5,2) NOT NULL,
  `max_marks` decimal(5,2) NOT NULL,
  `grade_point` decimal(3,2) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `color_code` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- STAFF MANAGEMENT
-- ========================================

-- Table: staff
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `role_type` enum('Teacher','Admin','Support','Management','Security','Nurse','Librarian','Other') NOT NULL DEFAULT 'Teacher',
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_number` varchar(20) DEFAULT NULL,
  `current_address` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'Nigeria',
  `department` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `subject_specialty` varchar(100) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `university` varchar(255) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `employment_type` enum('Permanent','Contract','Part-Time','Temporary') NOT NULL DEFAULT 'Permanent',
  `basic_salary` decimal(15,2) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account_no` varchar(50) DEFAULT NULL,
  `bank_code` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `employee_id` (`employee_id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_role_type` (`role_type`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_staff_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add foreign key to classes table
ALTER TABLE `classes`
  ADD CONSTRAINT `fk_classes_teacher` FOREIGN KEY (`class_teacher_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL;

-- Add foreign key to class_subjects table
ALTER TABLE `class_subjects`
  ADD CONSTRAINT `fk_class_subjects_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL;

-- Table: staff_attendance
CREATE TABLE `staff_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` enum('Present','Absent','Half-Day','Late','On Leave') NOT NULL DEFAULT 'Present',
  `work_hours` decimal(5,2) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_staff_attendance` (`staff_id`,`date`),
  KEY `idx_date` (`date`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_staff_attendance_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: performance_reviews
CREATE TABLE `performance_reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `review_period` varchar(50) NOT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `teaching_quality` int(11) DEFAULT NULL CHECK (`teaching_quality` BETWEEN 1 AND 10),
  `punctuality` int(11) DEFAULT NULL CHECK (`punctuality` BETWEEN 1 AND 10),
  `communication` int(11) DEFAULT NULL CHECK (`communication` BETWEEN 1 AND 10),
  `collaboration` int(11) DEFAULT NULL CHECK (`collaboration` BETWEEN 1 AND 10),
  `initiative` int(11) DEFAULT NULL CHECK (`initiative` BETWEEN 1 AND 10),
  `overall_rating` decimal(3,1) DEFAULT NULL,
  `strengths` text DEFAULT NULL,
  `areas_improvement` text DEFAULT NULL,
  `goals` text DEFAULT NULL,
  `reviewer_id` int(11) DEFAULT NULL,
  `review_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  KEY `reviewer_id` (`reviewer_id`),
  CONSTRAINT `fk_performance_reviews_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_performance_reviews_reviewer` FOREIGN KEY (`reviewer_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: salary_structure
CREATE TABLE `salary_structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `basic_salary` decimal(15,2) NOT NULL,
  `house_allowance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `transport_allowance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `medical_allowance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `other_allowances` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_deduction` decimal(15,2) NOT NULL DEFAULT 0.00,
  `pension_deduction` decimal(15,2) NOT NULL DEFAULT 0.00,
  `other_deductions` decimal(15,2) NOT NULL DEFAULT 0.00,
  `net_salary` decimal(15,2) GENERATED ALWAYS AS ((`basic_salary` + `house_allowance` + `transport_allowance` + `medical_allowance` + `other_allowances`) - (`tax_deduction` + `pension_deduction` + `other_deductions`)) STORED,
  `effective_from` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_salary_structure_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: payroll
CREATE TABLE `payroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `salary_structure_id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `year` int(11) NOT NULL,
  `working_days` int(11) NOT NULL DEFAULT 0,
  `present_days` int(11) NOT NULL DEFAULT 0,
  `gross_salary` decimal(15,2) NOT NULL,
  `total_deductions` decimal(15,2) NOT NULL DEFAULT 0.00,
  `net_salary` decimal(15,2) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` enum('Cash','Bank Transfer','Cheque') NOT NULL DEFAULT 'Bank Transfer',
  `status` enum('Pending','Paid') NOT NULL DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_payroll` (`staff_id`,`month`,`year`),
  KEY `salary_structure_id` (`salary_structure_id`),
  KEY `idx_status` (`status`),
  KEY `generated_by` (`generated_by`),
  CONSTRAINT `fk_payroll_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_payroll_salary_structure` FOREIGN KEY (`salary_structure_id`) REFERENCES `salary_structure` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_payroll_generated_by` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- STUDENT & PARENT MANAGEMENT
-- ========================================

-- Table: parents
CREATE TABLE `parents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `father_phone` varchar(20) DEFAULT NULL,
  `father_occupation` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `mother_phone` varchar(20) DEFAULT NULL,
  `mother_occupation` varchar(100) DEFAULT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `guardian_relation` varchar(50) DEFAULT NULL,
  `guardian_phone` varchar(20) DEFAULT NULL,
  `primary_phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `idx_email` (`email`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_parents_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: students
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `admission_no` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `roll_no` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `nationality` varchar(100) NOT NULL DEFAULT 'Nigerian',
  `religion` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_number` varchar(20) DEFAULT NULL,
  `current_address` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'Nigeria',
  `allergies` text DEFAULT NULL,
  `medications` text DEFAULT NULL,
  `prev_school_name` varchar(255) DEFAULT NULL,
  `prev_school_tc_no` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `admission_no` (`admission_no`),
  UNIQUE KEY `email` (`email`),
  KEY `class_id` (`class_id`),
  KEY `parent_id` (`parent_id`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_students_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_students_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_students_parent` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: student_promotions
CREATE TABLE `student_promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `from_class_id` int(11) NOT NULL,
  `to_class_id` int(11) NOT NULL,
  `from_session` varchar(20) NOT NULL,
  `to_session` varchar(20) NOT NULL,
  `promotion_status` enum('Promoted','Detained','Pass Out') NOT NULL DEFAULT 'Promoted',
  `promotion_date` date NOT NULL,
  `remarks` text DEFAULT NULL,
  `promoted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `from_class_id` (`from_class_id`),
  KEY `to_class_id` (`to_class_id`),
  KEY `promoted_by` (`promoted_by`),
  CONSTRAINT `fk_promotions_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_promotions_from_class` FOREIGN KEY (`from_class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_promotions_to_class` FOREIGN KEY (`to_class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_promotions_promoted_by` FOREIGN KEY (`promoted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- ATTENDANCE MANAGEMENT
-- ========================================

-- Table: attendance
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent','Late','Excused') NOT NULL DEFAULT 'Present',
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_attendance` (`student_id`,`date`),
  KEY `idx_date` (`date`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_attendance_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TIMETABLE MANAGEMENT
-- ========================================

-- Table: timetable_periods
CREATE TABLE `timetable_periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `type` enum('class','break') NOT NULL DEFAULT 'class',
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: timetable
CREATE TABLE `timetable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `period_id` int(11) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `subject_id` (`subject_id`),
  KEY `staff_id` (`staff_id`),
  KEY `period_id` (`period_id`),
  CONSTRAINT `fk_timetable_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_timetable_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_timetable_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_timetable_period` FOREIGN KEY (`period_id`) REFERENCES `timetable_periods` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- EXAMINATION & ASSESSMENT
-- ========================================

-- Table: exams
CREATE TABLE `exams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `exam_type` enum('Mid-Term','Final','Quiz','Test','Assignment') NOT NULL DEFAULT 'Mid-Term',
  `class_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `term` varchar(20) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `idx_exam_type` (`exam_type`),
  KEY `idx_is_published` (`is_published`),
  CONSTRAINT `fk_exams_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: exam_timetable
CREATE TABLE `exam_timetable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room_number` varchar(50) DEFAULT NULL,
  `max_marks` decimal(5,2) NOT NULL DEFAULT 100.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`),
  KEY `subject_id` (`subject_id`),
  KEY `idx_exam_date` (`exam_date`),
  CONSTRAINT `fk_exam_timetable_exam` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_exam_timetable_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: marks
CREATE TABLE `marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `marks_obtained` decimal(5,2) NOT NULL,
  `total_marks` decimal(5,2) NOT NULL DEFAULT 100.00,
  `grade` varchar(5) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mark` (`exam_id`,`student_id`,`subject_id`),
  KEY `student_id` (`student_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `fk_marks_exam` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_marks_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_marks_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: report_cards
CREATE TABLE `report_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `academic_year` varchar(20) NOT NULL,
  `term` varchar(20) NOT NULL,
  `total_marks` decimal(10,2) DEFAULT NULL,
  `percentage` decimal(5,2) DEFAULT NULL,
  `grade` varchar(5) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `attendance_percentage` decimal(5,2) DEFAULT NULL,
  `teacher_remarks` text DEFAULT NULL,
  `principal_remarks` text DEFAULT NULL,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `generated_by` int(11) DEFAULT NULL,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_report` (`student_id`,`exam_id`),
  KEY `exam_id` (`exam_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_report_cards_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_report_cards_exam` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_report_cards_generated_by` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: assignments
CREATE TABLE `assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `assigned_date` date NOT NULL,
  `due_date` date NOT NULL,
  `max_marks` decimal(5,2) NOT NULL DEFAULT 100.00,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `subject_id` (`subject_id`),
  KEY `staff_id` (`staff_id`),
  KEY `idx_due_date` (`due_date`),
  CONSTRAINT `fk_assignments_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_assignments_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_assignments_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: assignment_submissions
CREATE TABLE `assignment_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `submission_file` varchar(255) DEFAULT NULL,
  `submission_text` text DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `marks_obtained` decimal(5,2) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `status` enum('Pending','Submitted','Graded','Late') NOT NULL DEFAULT 'Pending',
  `graded_by` int(11) DEFAULT NULL,
  `graded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_submission` (`assignment_id`,`student_id`),
  KEY `student_id` (`student_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_submissions_assignment` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_submissions_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_submissions_graded_by` FOREIGN KEY (`graded_by`) REFERENCES `staff` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: lesson_plans
CREATE TABLE `lesson_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `lesson_date` date NOT NULL,
  `topic` varchar(255) NOT NULL,
  `objectives` text DEFAULT NULL,
  `teaching_method` varchar(255) DEFAULT NULL,
  `resources` text DEFAULT NULL,
  `activities` text DEFAULT NULL,
  `assessment` text DEFAULT NULL,
  `homework` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('Draft','Approved','Completed') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  KEY `class_id` (`class_id`),
  KEY `subject_id` (`subject_id`),
  KEY `idx_lesson_date` (`lesson_date`),
  CONSTRAINT `fk_lesson_plans_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_lesson_plans_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_lesson_plans_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- FEE MANAGEMENT
-- ========================================

-- Table: fee_types
CREATE TABLE `fee_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `frequency` enum('One-Time','Monthly','Quarterly','Annually') NOT NULL DEFAULT 'One-Time',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: student_fees
CREATE TABLE `student_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `fee_type_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Unpaid','Partial','Paid','Waived') NOT NULL DEFAULT 'Unpaid',
  `due_date` date DEFAULT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `term` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `fee_type_id` (`fee_type_id`),
  KEY `idx_status` (`status`),
  KEY `idx_due_date` (`due_date`),
  CONSTRAINT `fk_student_fees_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_student_fees_fee_type` FOREIGN KEY (`fee_type_id`) REFERENCES `fee_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: payments
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_fee_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` enum('Cash','Bank Transfer','Online','Cheque','POS') NOT NULL DEFAULT 'Cash',
  `transaction_id` varchar(100) DEFAULT NULL,
  `proof_file` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Approved',
  `remarks` text DEFAULT NULL,
  `received_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_fee_id` (`student_fee_id`),
  KEY `idx_payment_date` (`payment_date`),
  KEY `idx_status` (`status`),
  KEY `received_by` (`received_by`),
  CONSTRAINT `fk_payments_student_fee` FOREIGN KEY (`student_fee_id`) REFERENCES `student_fees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_payments_received_by` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: expenses
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `expense_date` date NOT NULL,
  `payment_method` enum('Cash','Bank Transfer','Cheque','Online') NOT NULL DEFAULT 'Cash',
  `vendor_name` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `invoice_file` varchar(255) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `status` enum('Pending','Approved','Paid') NOT NULL DEFAULT 'Pending',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_expense_category` (`expense_category`),
  KEY `idx_expense_date` (`expense_date`),
  KEY `idx_status` (`status`),
  KEY `approved_by` (`approved_by`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `fk_expenses_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_expenses_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: budgets
CREATE TABLE `budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `academic_year` varchar(20) NOT NULL,
  `allocated_amount` decimal(15,2) NOT NULL,
  `spent_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remaining_amount` decimal(15,2) GENERATED ALWAYS AS (`allocated_amount` - `spent_amount`) STORED,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_budget` (`category`,`academic_year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- LIBRARY MANAGEMENT
-- ========================================

-- Table: books
CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `publication_year` year DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `available` int(11) NOT NULL DEFAULT 1,
  `shelf_no` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`),
  KEY `idx_category` (`category`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: book_issues
CREATE TABLE `book_issues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('Issued','Returned','Overdue','Lost') NOT NULL DEFAULT 'Issued',
  `fine_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remarks` text DEFAULT NULL,
  `issued_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `student_id` (`student_id`),
  KEY `staff_id` (`staff_id`),
  KEY `issued_by` (`issued_by`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_book_issues_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_book_issues_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_book_issues_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_book_issues_issued_by` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- TRANSPORT MANAGEMENT
-- ========================================

-- Table: transport_vehicles
CREATE TABLE `transport_vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_no` varchar(50) NOT NULL,
  `vehicle_type` enum('Bus','Van','Car') NOT NULL DEFAULT 'Bus',
  `driver_name` varchar(100) NOT NULL,
  `driver_phone` varchar(20) NOT NULL,
  `driver_license` varchar(50) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicle_no` (`vehicle_no`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: transport_routes
CREATE TABLE `transport_routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_name` varchar(100) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `fare` decimal(10,2) NOT NULL DEFAULT 0.00,
  `start_point` varchar(255) DEFAULT NULL,
  `end_point` varchar(255) DEFAULT NULL,
  `stops` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `vehicle_id` (`vehicle_id`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_transport_routes_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `transport_vehicles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: transport_allocations
CREATE TABLE `transport_allocations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `pickup_point` varchar(255) DEFAULT NULL,
  `allocated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_allocation` (`student_id`),
  KEY `route_id` (`route_id`),
  CONSTRAINT `fk_transport_allocations_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_transport_allocations_route` FOREIGN KEY (`route_id`) REFERENCES `transport_routes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- HOSTEL MANAGEMENT
-- ========================================

-- Table: hostel_rooms
CREATE TABLE `hostel_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostel_name` varchar(100) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `floor` int(11) DEFAULT NULL,
  `room_type` enum('Single','Double','Triple','Dormitory') NOT NULL DEFAULT 'Double',
  `capacity` int(11) NOT NULL,
  `occupied` int(11) NOT NULL DEFAULT 0,
  `gender` enum('Male','Female','Mixed') NOT NULL DEFAULT 'Male',
  `facilities` text DEFAULT NULL,
  `monthly_fee` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_room` (`hostel_name`,`room_number`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: hostel_allocations
CREATE TABLE `hostel_allocations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `bed_number` varchar(20) DEFAULT NULL,
  `allocation_date` date NOT NULL,
  `vacate_date` date DEFAULT NULL,
  `status` enum('Active','Vacated') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `room_id` (`room_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_hostel_allocations_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_hostel_allocations_room` FOREIGN KEY (`room_id`) REFERENCES `hostel_rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- STUDENT SERVICES
-- ========================================

-- Table: health_records
CREATE TABLE `health_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `record_date` date NOT NULL,
  `record_type` enum('Checkup','Illness','Injury','Vaccination','Allergy','Other') NOT NULL DEFAULT 'Checkup',
  `symptoms` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `treatment` text DEFAULT NULL,
  `medication_prescribed` text DEFAULT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `hospital_name` varchar(255) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `blood_pressure` varchar(20) DEFAULT NULL,
  `temperature` decimal(4,1) DEFAULT NULL,
  `next_checkup` date DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `idx_record_date` (`record_date`),
  KEY `idx_record_type` (`record_type`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `fk_health_records_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_health_records_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: vaccinations
CREATE TABLE `vaccinations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `vaccine_name` varchar(100) NOT NULL,
  `dose_number` int(11) NOT NULL DEFAULT 1,
  `vaccination_date` date NOT NULL,
  `next_dose_date` date DEFAULT NULL,
  `administered_by` varchar(100) DEFAULT NULL,
  `hospital_name` varchar(255) DEFAULT NULL,
  `batch_number` varchar(50) DEFAULT NULL,
  `certificate_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `idx_vaccination_date` (`vaccination_date`),
  CONSTRAINT `fk_vaccinations_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: disciplinary_records
CREATE TABLE `disciplinary_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `incident_date` date NOT NULL,
  `incident_type` enum('Misconduct','Fighting','Bullying','Absence','Late','Uniform','Other') NOT NULL DEFAULT 'Other',
  `description` text NOT NULL,
  `action_taken` enum('Warning','Detention','Suspension','Expulsion','Counseling','Parent Meeting') NOT NULL DEFAULT 'Warning',
  `duration_days` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reported_by` int(11) DEFAULT NULL,
  `handled_by` int(11) DEFAULT NULL,
  `parent_notified` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `idx_incident_date` (`incident_date`),
  KEY `idx_incident_type` (`incident_type`),
  KEY `reported_by` (`reported_by`),
  KEY `handled_by` (`handled_by`),
  CONSTRAINT `fk_disciplinary_records_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_disciplinary_records_reported_by` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_disciplinary_records_handled_by` FOREIGN KEY (`handled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: behavior_points
CREATE TABLE `behavior_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `reason` text NOT NULL,
  `type` enum('Positive','Negative') NOT NULL DEFAULT 'Positive',
  `category` enum('Academic','Behavior','Attendance','Participation','Other') NOT NULL DEFAULT 'Other',
  `awarded_by` int(11) DEFAULT NULL,
  `awarded_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `idx_type` (`type`),
  KEY `awarded_by` (`awarded_by`),
  CONSTRAINT `fk_behavior_points_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_behavior_points_awarded_by` FOREIGN KEY (`awarded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- ALUMNI MANAGEMENT
-- ========================================

-- Table: alumni
CREATE TABLE `alumni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `graduation_year` int(11) NOT NULL,
  `graduation_class` varchar(50) DEFAULT NULL,
  `current_occupation` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `willing_to_mentor` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `idx_graduation_year` (`graduation_year`),
  KEY `idx_email` (`email`),
  CONSTRAINT `fk_alumni_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: alumni_donations
CREATE TABLE `alumni_donations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumni_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `donation_date` date NOT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `payment_method` enum('Cash','Bank Transfer','Online','Cheque') NOT NULL DEFAULT 'Bank Transfer',
  `transaction_id` varchar(100) DEFAULT NULL,
  `receipt_file` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `alumni_id` (`alumni_id`),
  KEY `idx_donation_date` (`donation_date`),
  CONSTRAINT `fk_alumni_donations_alumni` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- COMMUNICATION & ENGAGEMENT
-- ========================================

-- Table: messages
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `parent_message_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`),
  KEY `idx_is_read` (`is_read`),
  KEY `parent_message_id` (`parent_message_id`),
  CONSTRAINT `fk_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_messages_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_messages_parent` FOREIGN KEY (`parent_message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: events
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_type` enum('Holiday','Exam','Meeting','Sports','Cultural','Other') NOT NULL DEFAULT 'Other',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `audience` enum('all','student','staff','parent') NOT NULL DEFAULT 'all',
  `color` varchar(20) DEFAULT '#3498db',
  `is_holiday` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_start_date` (`start_date`),
  KEY `idx_event_type` (`event_type`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `fk_events_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: notices
CREATE TABLE `notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `audience` enum('all','student','staff','parent') NOT NULL DEFAULT 'all',
  `priority` enum('Low','Normal','High','Urgent') NOT NULL DEFAULT 'Normal',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `idx_audience` (`audience`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_notices_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: announcements
CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `announcement_type` enum('General','Academic','Event','Emergency','Holiday') NOT NULL DEFAULT 'General',
  `target_audience` enum('All','Students','Staff','Parents','Class') NOT NULL DEFAULT 'All',
  `target_class_id` int(11) DEFAULT NULL,
  `priority` enum('Low','Normal','High','Urgent') NOT NULL DEFAULT 'Normal',
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `target_class_id` (`target_class_id`),
  KEY `created_by` (`created_by`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_announcements_class` FOREIGN KEY (`target_class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_announcements_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: complaints
CREATE TABLE `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `complaint_by` int(11) NOT NULL,
  `category` enum('Academic','Discipline','Facility','Transport','Fee','Other') NOT NULL DEFAULT 'Other',
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` enum('Low','Medium','High','Urgent') NOT NULL DEFAULT 'Medium',
  `status` enum('Open','In Progress','Resolved','Closed') NOT NULL DEFAULT 'Open',
  `assigned_to` int(11) DEFAULT NULL,
  `resolution` text DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `complaint_by` (`complaint_by`),
  KEY `assigned_to` (`assigned_to`),
  KEY `idx_status` (`status`),
  KEY `idx_priority` (`priority`),
  CONSTRAINT `fk_complaints_by` FOREIGN KEY (`complaint_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_complaints_assigned_to` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: parent_teacher_meetings
CREATE TABLE `parent_teacher_meetings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `meeting_date` datetime NOT NULL,
  `duration_minutes` int(11) NOT NULL DEFAULT 30,
  `location` varchar(255) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `discussion_points` text DEFAULT NULL,
  `action_items` text DEFAULT NULL,
  `status` enum('Scheduled','Completed','Cancelled','Rescheduled') NOT NULL DEFAULT 'Scheduled',
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `parent_id` (`parent_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `idx_meeting_date` (`meeting_date`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `fk_ptm_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ptm_parent` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ptm_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ptm_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- FORUM & COMMUNITY
-- ========================================

-- Table: forum_categories
CREATE TABLE `forum_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: forum_posts
CREATE TABLE `forum_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  KEY `idx_is_pinned` (`is_pinned`),
  CONSTRAINT `fk_forum_posts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_forum_posts_category` FOREIGN KEY (`category_id`) REFERENCES `forum_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: forum_comments
CREATE TABLE `forum_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_forum_comments_post` FOREIGN KEY (`post_id`) REFERENCES `forum_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_forum_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: forum_likes
CREATE TABLE `forum_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_like` (`post_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_forum_likes_post` FOREIGN KEY (`post_id`) REFERENCES `forum_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_forum_likes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- ADMINISTRATIVE
-- ========================================

-- Table: leave_applications
CREATE TABLE `leave_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `leave_type` enum('Sick','Casual','Medical','Emergency','Other') NOT NULL DEFAULT 'Casual',
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `days` int(11) NOT NULL,
  `reason` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `approval_remarks` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_from_date` (`from_date`),
  KEY `approved_by` (`approved_by`),
  CONSTRAINT `fk_leave_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_leave_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: inventory_items
CREATE TABLE `inventory_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `item_code` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unit` varchar(50) NOT NULL DEFAULT 'piece',
  `location` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `warranty_expiry` date DEFAULT NULL,
  `condition_status` enum('Good','Fair','Poor','Damaged') NOT NULL DEFAULT 'Good',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_code` (`item_code`),
  KEY `idx_category` (`category`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: inventory_movements
CREATE TABLE `inventory_movements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `movement_type` enum('In','Out','Damaged','Lost','Return') NOT NULL DEFAULT 'In',
  `quantity` int(11) NOT NULL,
  `from_location` varchar(255) DEFAULT NULL,
  `to_location` varchar(255) DEFAULT NULL,
  `issued_to` int(11) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `movement_date` date NOT NULL,
  `handled_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `issued_to` (`issued_to`),
  KEY `handled_by` (`handled_by`),
  CONSTRAINT `fk_inventory_movements_item` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_inventory_movements_issued_to` FOREIGN KEY (`issued_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_inventory_movements_handled_by` FOREIGN KEY (`handled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: certificates
CREATE TABLE `certificates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `certificate_type` varchar(100) NOT NULL,
  `unique_code` varchar(50) NOT NULL,
  `issue_date` date NOT NULL,
  `content` text DEFAULT NULL,
  `issued_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_code` (`unique_code`),
  KEY `student_id` (`student_id`),
  KEY `issued_by` (`issued_by`),
  CONSTRAINT `fk_certificates_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_certificates_issued_by` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- DOCUMENTS & MEDIA
-- ========================================

-- Table: documents
CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `document_type` enum('Policy','Curriculum','Report','Certificate','Letter','Form','Other') NOT NULL DEFAULT 'Other',
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_extension` varchar(10) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `access_level` enum('Public','Staff','Admin') NOT NULL DEFAULT 'Staff',
  `version` varchar(20) DEFAULT '1.0',
  `expiry_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_document_type` (`document_type`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_documents_uploaded_by` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: gallery_albums
CREATE TABLE `gallery_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `album_date` date DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `created_by` (`created_by`),
  KEY `idx_is_public` (`is_public`),
  CONSTRAINT `fk_gallery_albums_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_gallery_albums_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: gallery_photos
CREATE TABLE `gallery_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `fk_gallery_photos_album` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_gallery_photos_uploaded_by` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- SYSTEM & SECURITY
-- ========================================

-- Table: activity_logs
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(100) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `old_values` text DEFAULT NULL,
  `new_values` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idx_action` (`action`),
  KEY `idx_module` (`module`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `fk_activity_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: login_history
CREATE TABLE `login_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `device_type` varchar(50) DEFAULT NULL,
  `browser` varchar(50) DEFAULT NULL,
  `status` enum('Success','Failed') NOT NULL DEFAULT 'Success',
  `failure_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idx_login_time` (`login_time`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_login_history_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: notifications
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('Info','Success','Warning','Error') NOT NULL DEFAULT 'Info',
  `category` enum('Assignment','Exam','Fee','Attendance','Message','System','Other') NOT NULL DEFAULT 'Other',
  `link_url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idx_is_read` (`is_read`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: notification_queue
CREATE TABLE `notification_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient_type` enum('User','Email','SMS','Both') NOT NULL DEFAULT 'User',
  `recipient_id` int(11) DEFAULT NULL,
  `recipient_email` varchar(100) DEFAULT NULL,
  `recipient_phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `notification_type` varchar(50) DEFAULT NULL,
  `status` enum('Pending','Sent','Failed') NOT NULL DEFAULT 'Pending',
  `sent_at` timestamp NULL DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `retry_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `recipient_id` (`recipient_id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `fk_notification_queue_recipient` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: sms_logs
CREATE TABLE `sms_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient_phone` varchar(20) NOT NULL,
  `recipient_name` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `sms_type` enum('Attendance','Fee','Exam','General','Emergency') NOT NULL DEFAULT 'General',
  `status` enum('Pending','Sent','Failed','Delivered') NOT NULL DEFAULT 'Pending',
  `gateway_response` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `cost` decimal(10,4) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_recipient_phone` (`recipient_phone`),
  KEY `idx_status` (`status`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `fk_sms_logs_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: email_logs
CREATE TABLE `email_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient_email` varchar(100) NOT NULL,
  `recipient_name` varchar(100) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `email_type` enum('Welcome','Fee','Report','Notification','Newsletter','Other') NOT NULL DEFAULT 'Other',
  `status` enum('Pending','Sent','Failed','Bounced') NOT NULL DEFAULT 'Pending',
  `error_message` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `opened_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_recipient_email` (`recipient_email`),
  KEY `idx_status` (`status`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `fk_email_logs_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: backup_logs
CREATE TABLE `backup_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `backup_type` enum('Full','Partial','Incremental') NOT NULL DEFAULT 'Full',
  `backup_path` varchar(255) NOT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `status` enum('In Progress','Completed','Failed') NOT NULL DEFAULT 'In Progress',
  `error_message` text DEFAULT NULL,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `fk_backup_logs_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- SETTINGS & CONFIGURATION
-- ========================================

-- Table: school_settings
CREATE TABLE `school_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(255) NOT NULL DEFAULT 'My School ERP',
  `school_address` text DEFAULT NULL,
  `school_phone` varchar(50) DEFAULT NULL,
  `school_email` varchar(100) DEFAULT NULL,
  `school_website` varchar(255) DEFAULT NULL,
  `currency_symbol` varchar(10) NOT NULL DEFAULT '₦',
  `currency_code` varchar(5) NOT NULL DEFAULT 'NGN',
  `theme_color` varchar(20) DEFAULT '#3498db',
  `logo_path` varchar(255) DEFAULT NULL,
  `principal_name` varchar(255) DEFAULT NULL,
  `principal_signature` varchar(255) DEFAULT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `current_term` varchar(20) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: website_content
CREATE TABLE `website_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_key` varchar(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `action_text` varchar(100) DEFAULT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_description` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_key` (`section_key`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- INSERT DEFAULT DATA
-- ========================================

-- Insert default school settings
INSERT INTO `school_settings` (`school_name`, `currency_symbol`, `currency_code`, `theme_color`) 
VALUES ('My School ERP', '₦', 'NGN', '#3498db');

-- Insert default grading system
INSERT INTO `grading_system` (`grade`, `min_marks`, `max_marks`, `grade_point`, `description`, `color_code`) VALUES
('A+', 90.00, 100.00, 4.00, 'Excellent', '#28a745'),
('A', 80.00, 89.99, 3.70, 'Very Good', '#5cb85c'),
('B+', 75.00, 79.99, 3.30, 'Good', '#17a2b8'),
('B', 70.00, 74.99, 3.00, 'Above Average', '#6c757d'),
('C+', 65.00, 69.99, 2.70, 'Average', '#ffc107'),
('C', 60.00, 64.99, 2.30, 'Below Average', '#fd7e14'),
('D', 50.00, 59.99, 2.00, 'Pass', '#dc3545'),
('F', 0.00, 49.99, 0.00, 'Fail', '#c82333');

-- Insert default roles
INSERT INTO `roles` (`role_name`, `description`, `is_system`, `is_active`) VALUES
('Super Admin', 'Full system access', 1, 1),
('Principal', 'School principal with administrative rights', 1, 1),
('Vice Principal', 'Assistant principal', 1, 1),
('Teacher', 'Teaching staff', 1, 1),
('Student', 'Student user', 1, 1),
('Parent', 'Parent/Guardian', 1, 1),
('Accountant', 'Finance and accounting', 1, 1),
('Librarian', 'Library management', 1, 1),
('Receptionist', 'Front desk operations', 1, 1);

-- Insert default permissions (Sample permissions)
INSERT INTO `permissions` (`permission_name`, `module`, `action`, `description`) VALUES
('View Dashboard', 'dashboard', 'view', 'Access to main dashboard'),
('Manage Students', 'students', 'manage', 'Create, update, delete students'),
('View Students', 'students', 'view', 'View student information'),
('Manage Staff', 'staff', 'manage', 'Create, update, delete staff'),
('View Staff', 'staff', 'view', 'View staff information'),
('Manage Classes', 'classes', 'manage', 'Create, update, delete classes'),
('View Classes', 'classes', 'view', 'View class information'),
('Manage Subjects', 'subjects', 'manage', 'Create, update, delete subjects'),
('View Subjects', 'subjects', 'view', 'View subject information'),
('Manage Exams', 'exams', 'manage', 'Create, update exams'),
('View Exams', 'exams', 'view', 'View exam information'),
('Enter Marks', 'marks', 'enter', 'Enter student marks'),
('View Marks', 'marks', 'view', 'View marks'),
('Manage Fees', 'fees', 'manage', 'Manage fee structure'),
('Process Payments', 'fees', 'payment', 'Process fee payments'),
('View Fees', 'fees', 'view', 'View fee information'),
('Manage Attendance', 'attendance', 'manage', 'Mark attendance'),
('View Attendance', 'attendance', 'view', 'View attendance records'),
('Manage Timetable', 'timetable', 'manage', 'Create and edit timetable'),
('View Timetable', 'timetable', 'view', 'View timetable'),
('Manage Library', 'library', 'manage', 'Manage library books'),
('Issue Books', 'library', 'issue', 'Issue and return books'),
('View Library', 'library', 'view', 'View library information'),
('Manage Transport', 'transport', 'manage', 'Manage transport system'),
('View Transport', 'transport', 'view', 'View transport information'),
('Manage Hostel', 'hostel', 'manage', 'Manage hostel system'),
('View Hostel', 'hostel', 'view', 'View hostel information'),
('Send Notifications', 'communication', 'send', 'Send messages and notifications'),
('View Reports', 'reports', 'view', 'View system reports'),
('Manage Settings', 'settings', 'manage', 'Manage system settings'),
('View Logs', 'logs', 'view', 'View activity logs');

-- Insert default timetable periods
INSERT INTO `timetable_periods` (`name`, `start_time`, `end_time`, `type`, `display_order`) VALUES
('Period 1', '08:00:00', '08:45:00', 'class', 1),
('Period 2', '08:45:00', '09:30:00', 'class', 2),
('Period 3', '09:30:00', '10:15:00', 'class', 3),
('Break', '10:15:00', '10:30:00', 'break', 4),
('Period 4', '10:30:00', '11:15:00', 'class', 5),
('Period 5', '11:15:00', '12:00:00', 'class', 6),
('Lunch Break', '12:00:00', '13:00:00', 'break', 7),
('Period 6', '13:00:00', '13:45:00', 'class', 8),
('Period 7', '13:45:00', '14:30:00', 'class', 9);

-- Insert default fee types
INSERT INTO `fee_types` (`name`, `amount`, `description`, `frequency`, `is_active`) VALUES
('Tuition Fee', 50000.00, 'Term tuition fee', 'Quarterly', 1),
('Admission Fee', 25000.00, 'One-time admission fee', 'One-Time', 1),
('Exam Fee', 5000.00, 'Examination fee', 'Quarterly', 1),
('Library Fee', 2000.00, 'Library usage fee', 'Annually', 1),
('Sports Fee', 3000.00, 'Sports and activities fee', 'Annually', 1),
('Lab Fee', 5000.00, 'Laboratory fee', 'Quarterly', 1),
('Transport Fee', 15000.00, 'Transportation fee', 'Quarterly', 1),
('Hostel Fee', 30000.00, 'Hostel accommodation', 'Quarterly', 1),
('Uniform Fee', 8000.00, 'School uniform', 'Annually', 1),
('Development Fee', 10000.00, 'School development', 'Annually', 1);

-- Insert default forum categories
INSERT INTO `forum_categories` (`name`, `description`, `icon`, `display_order`, `is_active`) VALUES
('General Discussion', 'General topics and discussions', 'chat', 1, 1),
('Academic Help', 'Questions about subjects and assignments', 'book', 2, 1),
('Events & Activities', 'School events and activities', 'calendar', 3, 1),
('Sports', 'Sports discussions and updates', 'trophy', 4, 1),
('Technology', 'Technology and computer related topics', 'laptop', 5, 1),
('Announcements', 'Official school announcements', 'megaphone', 6, 1);

-- ========================================
-- CREATE VIEWS FOR REPORTING
-- ========================================

-- View: Student Full Details
CREATE OR REPLACE VIEW `view_student_details` AS
SELECT 
  s.id,
  s.admission_no,
  s.name,
  s.email,
  s.phone,
  s.roll_no,
  s.dob,
  s.gender,
  s.blood_group,
  c.name as class_name,
  c.section,
  p.name as parent_name,
  p.primary_phone as parent_phone,
  u.username,
  u.is_active,
  s.created_at
FROM students s
LEFT JOIN classes c ON s.class_id = c.id
LEFT JOIN parents p ON s.parent_id = p.id
LEFT JOIN users u ON s.user_id = u.id;

-- View: Staff Full Details
CREATE OR REPLACE VIEW `view_staff_details` AS
SELECT 
  st.id,
  st.employee_id,
  st.name,
  st.email,
  st.phone,
  st.role_type,
  st.designation,
  st.department,
  st.qualification,
  st.joining_date,
  st.employment_type,
  u.username,
  u.is_active,
  st.created_at
FROM staff st
LEFT JOIN users u ON st.user_id = u.id;

-- View: Fee Summary by Student
CREATE OR REPLACE VIEW `view_student_fee_summary` AS
SELECT 
  sf.student_id,
  s.name as student_name,
  s.admission_no,
  c.name as class_name,
  SUM(sf.amount) as total_fee,
  SUM(sf.paid) as total_paid,
  SUM(sf.amount - sf.paid - sf.discount) as balance,
  sf.academic_year,
  sf.term
FROM student_fees sf
JOIN students s ON sf.student_id = s.id
LEFT JOIN classes c ON s.class_id = c.id
GROUP BY sf.student_id, sf.academic_year, sf.term;

-- View: Attendance Summary
CREATE OR REPLACE VIEW `view_attendance_summary` AS
SELECT 
  a.student_id,
  s.name as student_name,
  s.admission_no,
  c.name as class_name,
  COUNT(*) as total_days,
  SUM(CASE WHEN a.status = 'Present' THEN 1 ELSE 0 END) as present_days,
  SUM(CASE WHEN a.status = 'Absent' THEN 1 ELSE 0 END) as absent_days,
  SUM(CASE WHEN a.status = 'Late' THEN 1 ELSE 0 END) as late_days,
  ROUND((SUM(CASE WHEN a.status = 'Present' THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_percentage,
  MONTH(a.date) as month,
  YEAR(a.date) as year
FROM attendance a
JOIN students s ON a.student_id = s.id
LEFT JOIN classes c ON s.class_id = c.id
GROUP BY a.student_id, MONTH(a.date), YEAR(a.date);

-- View: Exam Results Summary
CREATE OR REPLACE VIEW `view_exam_results` AS
SELECT 
  m.exam_id,
  e.name as exam_name,
  m.student_id,
  s.name as student_name,
  s.admission_no,
  c.name as class_name,
  sub.name as subject_name,
  m.marks_obtained,
  m.total_marks,
  m.grade,
  ROUND((m.marks_obtained / m.total_marks) * 100, 2) as percentage
FROM marks m
JOIN exams e ON m.exam_id = e.id
JOIN students s ON m.student_id = s.id
JOIN subjects sub ON m.subject_id = sub.id
LEFT JOIN classes c ON s.class_id = c.id;

-- View: Book Issue Status
CREATE OR REPLACE VIEW `view_book_issues_status` AS
SELECT 
  bi.id,
  b.title as book_title,
  b.author,
  b.isbn,
  COALESCE(s.name, st.name) as borrower_name,
  COALESCE(s.admission_no, st.employee_id) as borrower_id,
  bi.issue_date,
  bi.due_date,
  bi.return_date,
  bi.status,
  bi.fine_amount,
  CASE 
    WHEN bi.return_date IS NULL AND bi.due_date < CURDATE() THEN DATEDIFF(CURDATE(), bi.due_date)
    ELSE 0
  END as overdue_days
FROM book_issues bi
JOIN books b ON bi.book_id = b.id
LEFT JOIN students s ON bi.student_id = s.id
LEFT JOIN staff st ON bi.staff_id = st.id;

-- ========================================
-- CREATE STORED PROCEDURES
-- ========================================

DELIMITER $

-- Procedure: Calculate Student Fee Balance
CREATE PROCEDURE `sp_calculate_fee_balance`(IN p_student_id INT)
BEGIN
  SELECT 
    sf.id,
    ft.name as fee_type,
    sf.amount,
    sf.paid,
    sf.discount,
    (sf.amount - sf.paid - sf.discount) as balance,
    sf.status,
    sf.due_date
  FROM student_fees sf
  JOIN fee_types ft ON sf.fee_type_id = ft.id
  WHERE sf.student_id = p_student_id
  ORDER BY sf.due_date;
END$

-- Procedure: Get Student Report Card
CREATE PROCEDURE `sp_get_report_card`(IN p_student_id INT, IN p_exam_id INT)
BEGIN
  SELECT 
    s.name as student_name,
    s.admission_no,
    s.roll_no,
    c.name as class_name,
    c.section,
    e.name as exam_name,
    e.academic_year,
    e.term,
    sub.name as subject_name,
    m.marks_obtained,
    m.total_marks,
    m.grade,
    ROUND((m.marks_obtained / m.total_marks) * 100, 2) as percentage,
    m.remarks
  FROM marks m
  JOIN students s ON m.student_id = s.id
  JOIN exams e ON m.exam_id = e.id
  JOIN subjects sub ON m.subject_id = sub.id
  LEFT JOIN classes c ON s.class_id = c.id
  WHERE m.student_id = p_student_id AND m.exam_id = p_exam_id
  ORDER BY sub.name;
END$

-- Procedure: Mark Daily Attendance
CREATE PROCEDURE `sp_mark_attendance`(
  IN p_student_id INT,
  IN p_date DATE,
  IN p_status ENUM('Present','Absent','Late','Excused'),
  IN p_remarks VARCHAR(255)
)
BEGIN
  INSERT INTO attendance (student_id, date, status, remarks)
  VALUES (p_student_id, p_date, p_status, p_remarks)
  ON DUPLICATE KEY UPDATE 
    status = p_status,
    remarks = p_remarks;
END$

-- Procedure: Process Fee Payment
CREATE PROCEDURE `sp_process_payment`(
  IN p_student_fee_id INT,
  IN p_amount DECIMAL(10,2),
  IN p_payment_date DATE,
  IN p_payment_method ENUM('Cash','Bank Transfer','Online','Cheque','POS'),
  IN p_transaction_id VARCHAR(100),
  IN p_received_by INT,
  OUT p_payment_id INT,
  OUT p_message VARCHAR(255)
)
BEGIN
  DECLARE v_fee_amount DECIMAL(10,2);
  DECLARE v_paid_amount DECIMAL(10,2);
  DECLARE v_discount DECIMAL(10,2);
  DECLARE v_balance DECIMAL(10,2);
  
  -- Get current fee details
  SELECT amount, paid, discount 
  INTO v_fee_amount, v_paid_amount, v_discount
  FROM student_fees 
  WHERE id = p_student_fee_id;
  
  -- Calculate balance
  SET v_balance = v_fee_amount - v_paid_amount - v_discount;
  
  -- Check if payment amount is valid
  IF p_amount > v_balance THEN
    SET p_message = 'Payment amount exceeds balance';
    SET p_payment_id = NULL;
  ELSE
    -- Insert payment record
    INSERT INTO payments (
      student_fee_id, amount, payment_date, payment_method, 
      transaction_id, status, received_by
    ) VALUES (
      p_student_fee_id, p_amount, p_payment_date, p_payment_method,
      p_transaction_id, 'Approved', p_received_by
    );
    
    SET p_payment_id = LAST_INSERT_ID();
    
    -- Update student_fees
    UPDATE student_fees 
    SET 
      paid = paid + p_amount,
      status = CASE 
        WHEN (paid + p_amount) >= (amount - discount) THEN 'Paid'
        WHEN (paid + p_amount) > 0 THEN 'Partial'
        ELSE 'Unpaid'
      END
    WHERE id = p_student_fee_id;
    
    SET p_message = 'Payment processed successfully';
  END IF;
END$

-- Procedure: Generate Student Promotion
CREATE PROCEDURE `sp_promote_students`(
  IN p_from_class_id INT,
  IN p_to_class_id INT,
  IN p_from_session VARCHAR(20),
  IN p_to_session VARCHAR(20),
  IN p_promoted_by INT
)
BEGIN
  INSERT INTO student_promotions (
    student_id, from_class_id, to_class_id, 
    from_session, to_session, promotion_status,
    promotion_date, promoted_by
  )
  SELECT 
    id, class_id, p_to_class_id,
    p_from_session, p_to_session, 'Promoted',
    CURDATE(), p_promoted_by
  FROM students
  WHERE class_id = p_from_class_id AND is_active = 1;
  
  -- Update student class
  UPDATE students
  SET class_id = p_to_class_id
  WHERE class_id = p_from_class_id AND is_active = 1;
END$

DELIMITER ;

-- ========================================
-- CREATE TRIGGERS
-- ========================================

DELIMITER $

-- Trigger: Update book availability after issue
CREATE TRIGGER `trg_after_book_issue`
AFTER INSERT ON `book_issues`
FOR EACH ROW
BEGIN
  IF NEW.status = 'Issued' THEN
    UPDATE books 
    SET available = available - 1 
    WHERE id = NEW.book_id;
  END IF;
END$

-- Trigger: Update book availability after return
CREATE TRIGGER `trg_after_book_return`
AFTER UPDATE ON `book_issues`
FOR EACH ROW
BEGIN
  IF OLD.status = 'Issued' AND NEW.status = 'Returned' THEN
    UPDATE books 
    SET available = available + 1 
    WHERE id = NEW.book_id;
  END IF;
END$

-- Trigger: Update hostel room occupancy
CREATE TRIGGER `trg_after_hostel_allocation`
AFTER INSERT ON `hostel_allocations`
FOR EACH ROW
BEGIN
  IF NEW.status = 'Active' THEN
    UPDATE hostel_rooms 
    SET occupied = occupied + 1 
    WHERE id = NEW.room_id;
  END IF;
END$

-- Trigger: Update hostel room when vacated
CREATE TRIGGER `trg_after_hostel_vacation`
AFTER UPDATE ON `hostel_allocations`
FOR EACH ROW
BEGIN
  IF OLD.status = 'Active' AND NEW.status = 'Vacated' THEN
    UPDATE hostel_rooms 
    SET occupied = occupied - 1 
    WHERE id = NEW.room_id;
  END IF;
END$

-- Trigger: Log user activity
CREATE TRIGGER `trg_log_user_update`
AFTER UPDATE ON `users`
FOR EACH ROW
BEGIN
  INSERT INTO activity_logs (user_id, action, module, record_id, old_values, new_values)
  VALUES (
    NEW.id,
    'UPDATE',
    'users',
    NEW.id,
    CONCAT('is_active:', OLD.is_active, ',role:', OLD.role),
    CONCAT('is_active:', NEW.is_active, ',role:', NEW.role)
  );
END$

DELIMITER ;

-- ========================================
-- CREATE INDEXES FOR OPTIMIZATION
-- ========================================

-- Additional composite indexes for better query performance
CREATE INDEX `idx_student_class_active` ON `students` (`class_id`, `is_active`);
CREATE INDEX `idx_staff_role_active` ON `staff` (`role_type`, `is_active`);
CREATE INDEX `idx_attendance_date_status` ON `attendance` (`date`, `status`);
CREATE INDEX `idx_marks_exam_student` ON `marks` (`exam_id`, `student_id`);
CREATE INDEX `idx_payments_date_status` ON `payments` (`payment_date`, `status`);
CREATE INDEX `idx_messages_receiver_read` ON `messages` (`receiver_id`, `is_read`);
CREATE INDEX `idx_notifications_user_read` ON `notifications` (`user_id`, `is_read`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- ========================================
-- END OF SCHOOL ERP DATABASE SCHEMA
-- ========================================