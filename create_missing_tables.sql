-- ============================================================
-- MISSING TABLES - Generated from ERP PHP source code analysis
-- Database: db_roriri
-- ============================================================

-- ============================================================
-- INTERNSHIP MODULE (RoririSoftware)
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`internship_tbl` (
  `intern_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `incharge_id` INT DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `mode` VARCHAR(50) DEFAULT NULL,
  `gender` VARCHAR(20) DEFAULT NULL,
  `joining_date` DATE DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `inte_cou_id` INT DEFAULT NULL,
  `duration` VARCHAR(100) DEFAULT NULL,
  `payment` DECIMAL(10,2) DEFAULT NULL,
  `username` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `total_workingdays` VARCHAR(50) DEFAULT '0/0',
  `certificate_status` VARCHAR(50) DEFAULT 'Inactive',
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`intern_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `dob` DATE DEFAULT NULL,
  `gender` VARCHAR(20) DEFAULT NULL,
  `join_date` DATE DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `course_id` INT DEFAULT NULL,
  `duration` VARCHAR(100) DEFAULT NULL,
  `fees` DECIMAL(10,2) DEFAULT NULL,
  `username` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`inter_course_tbl` (
  `inte_cou_id` INT AUTO_INCREMENT PRIMARY KEY,
  `intern_course_name` VARCHAR(255) NOT NULL,
  `course_logo` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`intern_payment` (
  `inter_paym_id` INT AUTO_INCREMENT PRIMARY KEY,
  `intern_id` INT DEFAULT NULL,
  `inter_amount` DECIMAL(10,2) DEFAULT NULL,
  `tranx_id` VARCHAR(255) DEFAULT NULL,
  `received_date` DATE DEFAULT NULL,
  `pay_mode` VARCHAR(100) DEFAULT NULL,
  `pay_balance` DECIMAL(10,2) DEFAULT NULL,
  `received_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_intern_id` (`intern_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`intern_attendance` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `date` DATE DEFAULT NULL,
  `present_ids` TEXT DEFAULT NULL,
  `absent_ids` TEXT DEFAULT NULL,
  `updated_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`intern_support_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `intern_id` INT DEFAULT NULL,
  `msg` TEXT DEFAULT NULL,
  `date_time` DATETIME DEFAULT NULL,
  `reply_id` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`intern_idcard_tbl` (
  `idcard_id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_number` VARCHAR(255) NOT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`idcard_track_tbl` (
  `track_id` INT AUTO_INCREMENT PRIMARY KEY,
  `idcard_id` INT DEFAULT NULL,
  `intern_id` INT DEFAULT NULL,
  `issued_date` DATE DEFAULT NULL,
  `returned_date` DATE DEFAULT NULL,
  `issued_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_idcard_id` (`idcard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`intern_appli_track` (
  `appli_id` INT AUTO_INCREMENT PRIMARY KEY,
  `intern_id` INT DEFAULT NULL,
  `appli_name` VARCHAR(255) DEFAULT NULL,
  `appli_description` TEXT DEFAULT NULL,
  `refer_documents` TEXT DEFAULT NULL,
  `assigned_by` INT DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `trainer_status` VARCHAR(50) DEFAULT NULL,
  `task_mark` VARCHAR(50) DEFAULT NULL,
  `verified_by` INT DEFAULT NULL,
  `verified_time` DATETIME DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  INDEX `idx_intern_id` (`intern_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`intern_ppt_tbl` (
  `ppt_id` INT AUTO_INCREMENT PRIMARY KEY,
  `cou_id` INT DEFAULT NULL,
  `title` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `file_name` VARCHAR(255) DEFAULT NULL,
  `created_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`intern_task_update` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `date` DATE DEFAULT NULL,
  `task` TEXT DEFAULT NULL,
  `created_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`intern_enquiry` (
  `intern_enquiry_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `college_name` VARCHAR(255) DEFAULT NULL,
  `POY` VARCHAR(50) DEFAULT NULL,
  `department` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `follow_up` DATE DEFAULT NULL,
  `comment` TEXT DEFAULT NULL,
  `follow_status` VARCHAR(50) DEFAULT NULL,
  `enq_date` DATE DEFAULT NULL,
  `mode` VARCHAR(50) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- EXPENSE MODULE
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`expense_category` (
  `cat_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`expense_subcategory` (
  `subcat_id` INT AUTO_INCREMENT PRIMARY KEY,
  `cat_id` INT DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_cat_id` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`expense_details` (
  `expense_id` INT AUTO_INCREMENT PRIMARY KEY,
  `sub_id` INT DEFAULT NULL,
  `cash_handler` VARCHAR(255) DEFAULT NULL,
  `date` DATE DEFAULT NULL,
  `amount` DECIMAL(12,2) DEFAULT NULL,
  `bill` VARCHAR(500) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `mode` VARCHAR(100) DEFAULT NULL,
  `transaction_id` VARCHAR(255) DEFAULT NULL,
  `created_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_sub_id` (`sub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`expense_future` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `amount` DECIMAL(12,2) DEFAULT NULL,
  `priority` VARCHAR(50) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- ACADEMY MODULE (NexGen_IT_Academy)
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`academy_course_details` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_name` VARCHAR(255) NOT NULL,
  `subject_id` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Available',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`subject_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `sub_id` INT DEFAULT NULL,
  `subject_name` VARCHAR(255) DEFAULT NULL,
  `sub_name` VARCHAR(255) DEFAULT NULL,
  `duration` VARCHAR(100) DEFAULT NULL,
  `course_id` INT DEFAULT NULL,
  `entity_id` INT DEFAULT NULL,
  `sub_status` VARCHAR(20) DEFAULT 'Active',
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`topic_tbl` (
  `topic_id` INT AUTO_INCREMENT PRIMARY KEY,
  `topic_sub_id` INT DEFAULT NULL,
  `sub_id` INT DEFAULT NULL,
  `topic_name` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `topic_duration` VARCHAR(100) DEFAULT NULL,
  `topic_status` VARCHAR(20) DEFAULT 'Active',
  `section` VARCHAR(50) DEFAULT NULL,
  `topic_meterial` TEXT DEFAULT NULL,
  `topic_description` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_sub_id` (`topic_sub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`coursedetails_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT DEFAULT NULL,
  `course_duration` VARCHAR(100) DEFAULT NULL,
  `course_fees` DECIMAL(10,2) DEFAULT NULL,
  `course_subject` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`syllabus_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `section` VARCHAR(50) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`syllabus_track` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `syl_student_id` INT DEFAULT NULL,
  `syl_track_details` LONGTEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_student_id` (`syl_student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`evaluation_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `section` VARCHAR(50) DEFAULT NULL,
  `course_id` INT DEFAULT NULL,
  `student_id` INT DEFAULT NULL,
  `sub_id` INT DEFAULT NULL,
  `topic_id` INT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`app_evaluation_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `section` VARCHAR(50) DEFAULT NULL,
  `course_id` INT DEFAULT NULL,
  `student_id` INT DEFAULT NULL,
  `application_id` INT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`application_tbl` (
  `application_id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT DEFAULT NULL,
  `application_name` VARCHAR(255) DEFAULT NULL,
  `application_duration` VARCHAR(100) DEFAULT NULL,
  `application_discription` TEXT DEFAULT NULL,
  `section` VARCHAR(50) DEFAULT 'syllabus',
  `updated_by` INT DEFAULT NULL,
  `application_status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`application_track` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT DEFAULT NULL,
  `application_details` LONGTEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`trainee_additional_details` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `basic_id` INT DEFAULT NULL,
  `course_id` INT DEFAULT NULL,
  `duration` INT DEFAULT NULL,
  `slot_timing` VARCHAR(100) DEFAULT NULL,
  `batch` VARCHAR(100) DEFAULT NULL,
  `course_fee` DECIMAL(10,2) DEFAULT NULL,
  `incharge_name` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_basic_id` (`basic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`trainee_mini_project` (
  `project_id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT DEFAULT NULL,
  `project_name` VARCHAR(255) DEFAULT NULL,
  `duration` VARCHAR(100) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `updated_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`trainee_work_update_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `date` DATE DEFAULT NULL,
  `name` INT DEFAULT NULL,
  `work` TEXT DEFAULT NULL,
  `hours` DECIMAL(5,2) DEFAULT NULL,
  `url` VARCHAR(500) DEFAULT NULL,
  `image` TEXT DEFAULT NULL,
  `created_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- COLLEGE MODULE (NexGen_IT_College)
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`course_tbl` (
  `course_id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_name` VARCHAR(255) NOT NULL,
  `duration` VARCHAR(100) DEFAULT NULL,
  `course_fee` DECIMAL(10,2) DEFAULT NULL,
  `course_status` VARCHAR(20) DEFAULT 'Active',
  `entity_id` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`student_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `course` INT DEFAULT NULL,
  `role_id` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`jeno_ledger` (
  `led_id` INT AUTO_INCREMENT PRIMARY KEY,
  `led_type` VARCHAR(255) DEFAULT NULL,
  `led_updated_by` INT DEFAULT NULL,
  `led_status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- HR / EMPLOYEE MODULE
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`position_tbl` (
  `position_id` INT AUTO_INCREMENT PRIMARY KEY,
  `position_name` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`employee_tbl` (
  `emp_id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` VARCHAR(100) DEFAULT NULL,
  `entity_id` INT DEFAULT NULL,
  `emp_first_name` VARCHAR(255) DEFAULT NULL,
  `emp_last_name` VARCHAR(255) DEFAULT NULL,
  `emp_address` TEXT DEFAULT NULL,
  `emp_personal_email` VARCHAR(255) DEFAULT NULL,
  `emp_company_email` VARCHAR(255) DEFAULT NULL,
  `emp_mobile` VARCHAR(20) DEFAULT NULL,
  `emp_role` INT DEFAULT NULL,
  `emp_joining_date` DATE DEFAULT NULL,
  `emp_pay_role` VARCHAR(100) DEFAULT NULL,
  `emp_img` VARCHAR(255) DEFAULT NULL,
  `emp_user_id` INT DEFAULT NULL,
  `emp_status` VARCHAR(20) DEFAULT 'Active',
  `user_name` VARCHAR(255) DEFAULT NULL,
  `pass` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`emp_additional_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `emp_id` INT DEFAULT NULL,
  `payroll` VARCHAR(100) DEFAULT NULL,
  `experience` VARCHAR(100) DEFAULT NULL,
  `account_no` VARCHAR(50) DEFAULT NULL,
  `ifsc` VARCHAR(50) DEFAULT NULL,
  `branch` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_emp_id` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`salary_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `basic_id` INT DEFAULT NULL,
  `salary` DECIMAL(12,2) DEFAULT NULL,
  `days` INT DEFAULT NULL,
  `month` DATE DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_basic_id` (`basic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`employee_task` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `subcategory_id` INT DEFAULT NULL,
  `task` VARCHAR(500) DEFAULT NULL,
  `hours` DECIMAL(5,2) DEFAULT NULL,
  `created_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_subcategory_id` (`subcategory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`coordinator` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `details` TEXT DEFAULT NULL,
  `log` LONGTEXT DEFAULT NULL,
  `roles_res` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`coordinator_report` (
  `rep_id` INT AUTO_INCREMENT PRIMARY KEY,
  `coordinator_id` INT DEFAULT NULL,
  `dept_id` INT DEFAULT NULL,
  `assigned_date` DATE DEFAULT NULL,
  `report` TEXT DEFAULT NULL,
  `assign_by` INT DEFAULT NULL,
  `completed_date` DATE DEFAULT NULL,
  `work_ststus` VARCHAR(50) DEFAULT NULL,
  `date` DATE DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- DAILY REPORT / TASK MODULE
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`report_category_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category` VARCHAR(255) DEFAULT NULL,
  `create_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`report_subcategory_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT DEFAULT NULL,
  `subcategory` VARCHAR(255) DEFAULT NULL,
  `created_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`daily_report_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `date` DATE DEFAULT NULL,
  `working_date` DATE DEFAULT NULL,
  `name` INT DEFAULT NULL,
  `category_id` INT DEFAULT NULL,
  `subcategory_id` INT DEFAULT NULL,
  `task_id` INT DEFAULT NULL,
  `task` TEXT DEFAULT NULL,
  `hours` DECIMAL(5,2) DEFAULT NULL,
  `working_hours` DECIMAL(5,2) DEFAULT NULL,
  `url` VARCHAR(500) DEFAULT NULL,
  `image` TEXT DEFAULT NULL,
  `task_status` VARCHAR(50) DEFAULT NULL,
  `completed_date` DATE DEFAULT NULL,
  `created_by` INT DEFAULT NULL,
  `create_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(20) DEFAULT 'Active',
  INDEX `idx_name` (`name`),
  INDEX `idx_category` (`category_id`),
  INDEX `idx_task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- ENQUIRY / CONTACT MODULE
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`enquire_tbl` (
  `enquire_id` INT AUTO_INCREMENT PRIMARY KEY,
  `entity_id` INT DEFAULT NULL,
  `e_name` VARCHAR(255) DEFAULT NULL,
  `e_company_name` VARCHAR(255) DEFAULT NULL,
  `e_email` VARCHAR(255) DEFAULT NULL,
  `e_mobile` VARCHAR(20) DEFAULT NULL,
  `e_address` TEXT DEFAULT NULL,
  `enquire_details` TEXT DEFAULT NULL,
  `enquire_status` VARCHAR(20) DEFAULT 'Active',
  `e_date` DATE DEFAULT NULL,
  `enquiry_status` VARCHAR(50) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`enq_category` (
  `enq_category_id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`allenquiry_tbl` (
  `event_id` INT AUTO_INCREMENT PRIMARY KEY,
  `enq_category_id` INT DEFAULT NULL,
  `name` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `enquiry_date` DATE DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `location` TEXT DEFAULT NULL,
  `follow_up` DATE DEFAULT NULL,
  `comment` TEXT DEFAULT NULL,
  `follow_status` VARCHAR(50) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_category` (`enq_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`enquiry_detail_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `event_id` INT DEFAULT NULL,
  `college_name` VARCHAR(255) DEFAULT NULL,
  `degree` VARCHAR(255) DEFAULT NULL,
  `passed_out` VARCHAR(50) DEFAULT NULL,
  `academy_course` VARCHAR(255) DEFAULT NULL,
  `duration` VARCHAR(100) DEFAULT NULL,
  `mode` VARCHAR(50) DEFAULT NULL,
  `previous_company` VARCHAR(255) DEFAULT NULL,
  `role` VARCHAR(255) DEFAULT NULL,
  `ctc` VARCHAR(100) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`official_contact` (
  `contact_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `department` VARCHAR(255) DEFAULT NULL,
  `contact` VARCHAR(50) DEFAULT NULL,
  `url` VARCHAR(500) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`complaint_tbl` (
  `com_id` INT AUTO_INCREMENT PRIMARY KEY,
  `com_from` INT DEFAULT NULL,
  `com_to` TEXT DEFAULT NULL,
  `com_details` TEXT DEFAULT NULL,
  `com_reply` TEXT DEFAULT NULL,
  `reply_date` DATE DEFAULT NULL,
  `com_status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- MOU MODULE
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`mou_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `category` VARCHAR(255) DEFAULT NULL,
  `date` DATE DEFAULT NULL,
  `incharge` INT DEFAULT NULL,
  `moustatus` VARCHAR(50) DEFAULT NULL,
  `documents` TEXT DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- COMPANY ASSET MODULE
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`asset_category` (
  `assetcate_id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR(255) DEFAULT NULL,
  `category_status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`asset_subcategory` (
  `subcat_id` INT AUTO_INCREMENT PRIMARY KEY,
  `assetcate_id` INT DEFAULT NULL,
  `Subcategory` VARCHAR(255) DEFAULT NULL,
  `quantity` INT DEFAULT NULL,
  `staus` VARCHAR(20) DEFAULT 'Active',
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_assetcate_id` (`assetcate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`asset_vendor` (
  `vendor_id` INT AUTO_INCREMENT PRIMARY KEY,
  `vendor_name` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `shop_name` VARCHAR(255) DEFAULT NULL,
  `location` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`asset_product` (
  `assetpro_id` INT AUTO_INCREMENT PRIMARY KEY,
  `subcat_id` INT DEFAULT NULL,
  `product_no` VARCHAR(255) DEFAULT NULL,
  `product_name` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `vendor_id` INT DEFAULT NULL,
  `buy_date` DATE DEFAULT NULL,
  `asset_status` VARCHAR(50) DEFAULT 'Available',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_subcat_id` (`subcat_id`),
  INDEX `idx_vendor_id` (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`asset_asign_tbl` (
  `asign_id` INT AUTO_INCREMENT PRIMARY KEY,
  `asign_user_id` INT DEFAULT NULL,
  `asign_asset_id` INT DEFAULT NULL,
  `asign_room_id` INT DEFAULT NULL,
  `asign_start_date` DATE DEFAULT NULL,
  `asign_end_date` DATE DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_asset_id` (`asign_asset_id`),
  INDEX `idx_user_id` (`asign_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`asset_service` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `assetpro_id` INT DEFAULT NULL,
  `service_date` DATE DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `return_date` DATE DEFAULT NULL,
  `amount` DECIMAL(12,2) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_assetpro_id` (`assetpro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`room_tbl` (
  `room_id` INT AUTO_INCREMENT PRIMARY KEY,
  `room_name` VARCHAR(255) DEFAULT NULL,
  `room_status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- INDUSTRIAL VISIT MODULE
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`iv_client_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `location` TEXT DEFAULT NULL,
  `username` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`iv_details_tbl` (
  `iv_id` INT AUTO_INCREMENT PRIMARY KEY,
  `college_id` INT DEFAULT NULL,
  `iv_date` DATE DEFAULT NULL,
  `department` VARCHAR(255) DEFAULT NULL,
  `batch` VARCHAR(100) DEFAULT NULL,
  `stu_count` INT DEFAULT NULL,
  `staff_count` INT DEFAULT NULL,
  `incharge_name` VARCHAR(255) DEFAULT NULL,
  `incharge_phone` VARCHAR(20) DEFAULT NULL,
  `iv_status` VARCHAR(50) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(20) DEFAULT 'Active',
  INDEX `idx_college_id` (`college_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`iv_enquiry_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `college_name` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone_number` VARCHAR(20) DEFAULT NULL,
  `enquiry_date` DATE DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`iv_payment_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `visit_id` INT DEFAULT NULL,
  `food_id` INT DEFAULT NULL,
  `reason` VARCHAR(255) DEFAULT NULL,
  `amount` DECIMAL(12,2) DEFAULT NULL,
  `payment_method` VARCHAR(100) DEFAULT NULL,
  `traisanction_id` VARCHAR(255) DEFAULT NULL,
  `razorpay_payment_id` VARCHAR(255) DEFAULT NULL,
  `razorpay_order_id` VARCHAR(255) DEFAULT NULL,
  `paid_date` DATE DEFAULT NULL,
  `pay_status` VARCHAR(50) DEFAULT NULL,
  `created_by` INT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_visit_id` (`visit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`iv_students` (
  `iv_stu_id` INT AUTO_INCREMENT PRIMARY KEY,
  `iv_id` INT DEFAULT NULL,
  `name` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `certificate_status` VARCHAR(50) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_iv_id` (`iv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`iv_banner_tbl` (
  `banner_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `image_name` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`iv_gallery_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `visit_id` INT DEFAULT NULL,
  `name` VARCHAR(500) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_visit_id` (`visit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`food_packages_tbl` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category` VARCHAR(255) DEFAULT NULL,
  `image` VARCHAR(500) DEFAULT NULL,
  `name` VARCHAR(255) DEFAULT NULL,
  `price` DECIMAL(10,2) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`visits` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `iv_date` DATE DEFAULT NULL,
  `department` VARCHAR(255) DEFAULT NULL,
  `batch` VARCHAR(100) DEFAULT NULL,
  `stu_count` INT DEFAULT NULL,
  `staff_count` INT DEFAULT NULL,
  `incharge_name` VARCHAR(255) DEFAULT NULL,
  `incharge_phone` VARCHAR(20) DEFAULT NULL,
  `iv_status` VARCHAR(50) DEFAULT 'Not Approved',
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- SYSTEM / UTILITY TABLES
-- ============================================================

CREATE TABLE IF NOT EXISTS `db_roriri`.`birthday_log` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `log_date` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `db_roriri`.`login_history` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `basic_id` INT DEFAULT NULL,
  `system_info` LONGTEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_basic_id` (`basic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
