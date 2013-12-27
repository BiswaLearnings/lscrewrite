CREATE TABLE IF NOT EXISTS `lsc_account` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(50) NOT NULL,
  `account_shortname` varchar(50) NOT NULL,
  `account_description` varchar(100) NOT NULL,
  `global_account` int(10) NOT NULL,
  `region_id` bigint(20) NOT NULL,
  `account_verticalid` bigint(20) NOT NULL,
  `primary_scope` bigint(20) NOT NULL,
  `account_statusid` bigint(20) NOT NULL,
  `supported_india` int(10) NOT NULL,
  `account_executive_globalid` bigint(20) NOT NULL,
  `account_designation` bigint(20) NOT NULL,
  `account_leadid` bigint(20) NOT NULL,
  `account_signature` blob NOT NULL,
  `account_lead_india` bigint(20) NOT NULL,
  `content_type_al` varchar(10) NOT NULL,
  `orgunit_designation` bigint(20) NOT NULL,
  `orgunit_signature` blob NOT NULL,
  `orgunit_headid` bigint(20) NOT NULL,
  `content_type_ou` varchar(10) NOT NULL,
  `lsc_admin` bigint(20) NOT NULL,
  `account_logo` blob NOT NULL,
  `is_active` int(10) DEFAULT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `region` bigint(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `time_zone` varchar(20) NOT NULL,
  `pl_managerid` bigint(20) NOT NULL,
  `product_line` bigint(20) NOT NULL,
  `employee_type` bigint(20) NOT NULL,
  `reporting_managerid` bigint(20) NOT NULL,
  `is_active` int(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `craeted_by` varchar(100) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_by` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_module` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `k_node` bigint(20) NOT NULL,
  `account_id` bigint(20) DEFAULT NULL,
  `training_minutes` int(10) NOT NULL,
  `is_confidential` int(10) NOT NULL,
  `module_threshold` bigint(20) NOT NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_role` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `role_shortname` varchar(50) NOT NULL,
  `role_module_dfn_owner` varchar(100) NOT NULL,
  `role_module_df_approver` varchar(100) NOT NULL,
  `orgunit_designation` bigint(20) NOT NULL,
  `orgunit_signature` blob NOT NULL,
  `content_type_l1` varchar(10) NOT NULL,
  `vertical_head_designation` bigint(20) NOT NULL,
  `vertical_head_signature` blob NOT NULL,
  `content_type_l2` varchar(10) NOT NULL,
  `pl_manager_designation` bigint(20) NOT NULL,
  `pl_manager_signature` blob NOT NULL,
  `content_type_plm` varchar(10) NOT NULL,
  `role_certificate_name` varchar(50) DEFAULT NULL,
  `account_id` bigint(10) DEFAULT NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `lsc_role_module_mapping` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` bigint(10) DEFAULT NULL,
  `module_id` bigint(10) DEFAULT NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_role_user_mapping` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` bigint(10) NOT NULL,
  `user_id` bigint(10) NOT NULL,
  `role_status` varchar(10) NOT NULL,
  `assign_date` datetime NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `certified_date` datetime DEFAULT NULL,
  `email_sentdate` datetime DEFAULT NULL,
  `role_target_date` int(10) NOT NULL,
  `role_user_ktpm` varchar(50) NOT NULL,
  `role_user_kttype` varchar(10) NOT NULL,
  `role_user_ktpm_status` varchar(10) NOT NULL,
  `role_user_ktpm_approvaldate` datetime DEFAULT NULL,
  `role_user_notify` int( 10 ) NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_role_module_user_mapping` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` bigint(10) NOT NULL,
  `module_id` bigint(10) NOT NULL,
  `user_id` bigint(10) NOT NULL,
  `module_status` varchar(10) NOT NULL,
  `assign_date` datetime NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `completed_date` datetime DEFAULT NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_module_quiz` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `modul_eid` bigint(20) NOT NULL,
  `quiz_name` varchar(100) NOT NULL,
  `time_limit` int(10) NOT NULL,
  `question_perpage` int(10) DEFAULT NULL,
  `shuffle_questions` int(10) DEFAULT NULL,
  `shuff1e_within_questions` int(10) DEFAULT NULL,
  `attempts_allowed` bigint(20) DEFAULT NULL,
  `grading_methods` bigint(20) DEFAULT NULL,
  `required_grade` int(10) NOT NULL,  
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_module_user_attempts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `module_id` bigint(20) NOT NULL,
  `attempts_number` bigint(20) NOT NULL,
  `date_of_attempts` datetime DEFAULT NULL,
  `summary` text,
  `totalno_of_question` int(10) DEFAULT NULL,
  `correct_answers` int(10) DEFAULT NULL,
  `wrong_answers` int(10) DEFAULT NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_quiz_feedback` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `quiz_id` bigint(10) NOT NULL,
  `feedback_code` varchar(10) NOT NULL,
  `max_grade` int(10) NOT NULL,
  `min_grade` int(10) NOT NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `lsc_quiz_question` (

  `id` bigint(20) NOT NULL AUTO_INCREMENT,

  `quiz_id` bigint(20) NOT NULL,

  `serial` int(10) NOT NULL,

  `question_text` text NOT NULL,

  `grade` int(10) NOT NULL,

  `question_type` char(4) DEFAULT NULL,

  `in_quiz` int(11) NOT NULL,

  `is_active` int(10) NOT NULL,

  `created_by` bigint(20) NOT NULL,

  `created_date` datetime NOT NULL,

  `modified_by` bigint(20) DEFAULT NULL,

  `modified_date` datetime DEFAULT NULL,

  PRIMARY KEY (`id`)

) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT= 1;

CREATE TABLE IF NOT EXISTS `lsc_question_answers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `question_id` bigint(10) DEFAULT NULL,
  `answer` text NOT NULL,
  `fraction` double NOT NULL DEFAULT '0',
  `feedback` text NOT NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_quiz_assessment_content` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `quiz_id` bigint(10) DEFAULT NULL,
  `content_type` bigint(20) NOT NULL,
  `content_file` blob NOT NULL,
  `url` text,
  `skillport_requried` int(10) DEFAULT NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_user_attempts_quiz` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `quiz_id` bigint(10) NOT NULL,
  `user_id` bigint(10) NOT NULL,
  `questions_list` text,
  `start_date` datetime DEFAULT NULL,
  `completed_date` datetime DEFAULT NULL,
  `preview` int(10) DEFAULT NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_user_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(10) NOT NULL,
  `logon_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_email_template` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email_subject` text,
  `email_body` text,
  `remarks` text,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `lsc_email_notifications` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `email_title` text,
  `email_subject` text,
  `email_text` text,
  `email_cc` text,
  `email_bcc` text,
  `email_type` int(10) NOT NULL,
  `email_sent` int(10) NOT NULL,
  `email_failure` int(10) NOT NULL,
  `is_active` int(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `lsc_metadata` 
(
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `meta_name` varchar(50) NOT NULL,
	`meta_type` varchar(50) DEFAULT NULL,
	`meta_code` varchar(50) NOT NULL,
	`meta_text` varchar(100) DEFAULT NULL,
	`is_active` int(10) NOT NULL,
	`created_by` bigint(20) NOT NULL,
	`created_date` datetime NOT NULL,
	`modified_by` bigint(20) DEFAULT NULL,
	`modified_date` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `lsc_metadata_combo` 
(
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`type` varchar(50) NOT NULL,
	`admin` int(10) NOT NULL,
	`is_active` int(10) NOT NULL,
	`created_by` bigint(20) NOT NULL,
	`created_date` datetime NOT NULL,
	`modified_by` bigint(20) DEFAULT NULL,
	`modified_date` datetime DEFAULT NULL,	
	PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `lsc_session` 
(
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `data` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `last_accessed` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
