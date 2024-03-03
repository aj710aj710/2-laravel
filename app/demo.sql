--
-- Table structure for table `affiliate_configs`
--

DROP TABLE IF EXISTS `affiliate_configs`;
CREATE TABLE `affiliate_configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `products` text COLLATE utf8mb4_unicode_ci,
  `plans` text COLLATE utf8mb4_unicode_ci,
  `affiliates` text COLLATE utf8mb4_unicode_ci,
  `commission_type` tinyint(4) NOT NULL DEFAULT '1',
  `commission_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `recurring_commission_type` tinyint(4) NOT NULL DEFAULT '1',
  `recurring_commission_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_histories`
--

DROP TABLE IF EXISTS `affiliate_histories`;
CREATE TABLE `affiliate_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `authentication_log`
--

DROP TABLE IF EXISTS `authentication_log`;
CREATE TABLE `authentication_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `authenticatable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authenticatable_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `login_at` timestamp NULL DEFAULT NULL,
  `login_successful` tinyint(1) NOT NULL DEFAULT '0',
  `logout_at` timestamp NULL DEFAULT NULL,
  `cleared_by_user` tinyint(1) NOT NULL DEFAULT '0',
  `location` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gateway_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

DROP TABLE IF EXISTS `beneficiaries`;
CREATE TABLE `beneficiaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `beneficiary_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL,
  `card_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_holder_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expire_month` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expire_year` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_routing_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `best_features_settings`
--

DROP TABLE IF EXISTS `best_features_settings`;
CREATE TABLE `best_features_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkout_page_settings`
--

DROP TABLE IF EXISTS `checkout_page_settings`;
CREATE TABLE `checkout_page_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_size` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_info` longtext COLLATE utf8mb4_unicode_ci,
  `basic_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_info` longtext COLLATE utf8mb4_unicode_ci,
  `billing_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_zip_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_info` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_first_name` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_last_name` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_email` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_phone` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_zip_code` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_address` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_city` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_state` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_country` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_method` tinyint(4) DEFAULT NULL,
  `payment` longtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `short_name` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonecode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `continent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` tinyint(4) NOT NULL DEFAULT '0',
  `discount` int(11) NOT NULL DEFAULT '0',
  `redemption_type` int(11) NOT NULL DEFAULT '0',
  `product_plan` int(11) NOT NULL DEFAULT '0',
  `valid_date` date NOT NULL,
  `maximum_redemption` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_placement` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `current_currency` smallint(6) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency_code`, `symbol`, `currency_placement`, `current_currency`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'USD', '$', 'before', 1, NULL, '2023-10-16 06:33:46', '2023-10-16 06:33:46'),
(2, 'BDT', '৳', 'before', 0, NULL, '2023-10-16 06:33:46', '2023-10-16 06:33:46'),
(3, 'INR', '₹', 'before', 0, NULL, '2023-10-16 06:33:46', '2023-10-16 06:33:46'),
(4, 'GBP', '£', 'after', 0, NULL, '2023-10-16 06:33:46', '2023-10-16 06:33:46'),
(5, 'MXN', '$', 'before', 0, NULL, '2023-10-16 06:33:46', '2023-10-16 06:33:46'),
(6, 'SAR', 'SR', 'before', 0, NULL, '2023-10-16 06:33:46', '2023-10-16 06:33:46');

-- --------------------------------------------------------

--
-- Table structure for table `database_backups`
--

DROP TABLE IF EXISTS `database_backups`;
CREATE TABLE `database_backups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `database_backup_cron_settings`
--

DROP TABLE IF EXISTS `database_backup_cron_settings`;
CREATE TABLE `database_backup_cron_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour_of_day` time NOT NULL DEFAULT '00:00:00',
  `backup_after_days` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_backup_after_days` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category` tinyint(4) DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `user_id`, `category`, `subject`, `body`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Payment Successful', '<div>Subject: Payment Successful - Order #{{invoice_id}}</div><div><br></div><div>Here are the details of your order:</div><div><br></div><div>Order Number: #{{invoice_id}}</div><div>Payment Amount: {{total}}</div><div>Payment Method: {{gateway_name}}</div><div>Download Link: {{link}}</div><div><br></div>', 1, NULL, '2023-10-17 12:40:10', '2023-10-17 12:50:43'),
(2, 2, 2, 'Payment Failure', '<div>Subject: Payment Failure - Order #{{invoice_id}}</div><div><br></div><div>Here are the details of your order:</div><div><br></div><div>Order Number: #{{invoice_id}}</div><div>Payment Amount: {{total}}</div><div>Payment Method: {{gateway_name}}</div><div><br></div>', 1, NULL, '2023-10-17 12:40:15', '2023-10-17 12:50:44'),
(3, 2, 3, 'Invoice', '<div><span style=\"background-color: var(--bs-modal-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\">Order Number: #{{invoice_id}}</span><br></div><div>Payment Amount: {{total}}</div><div>Payment Method: {{gateway_name}}</div><div>Download Link:{{link}}</div><div><br></div>', 0, NULL, '2023-10-17 12:47:38', '2023-10-17 12:50:45'),
(4, 2, 4, 'Payment Cancelation', '<div>Subject: Subscription Cancellation - Order #{{invoice_id}}</div><div><br></div><div>Here are the details of your order:</div><div><br></div><div>Order Number: #{{invoice_id}}</div><div>Payment Amount: {{total}}</div><div>Payment Method: {{gateway_name}}</div><div><br></div>', 0, NULL, '2023-10-17 12:48:50', '2023-10-17 12:50:46'),
(5, 2, 6, 'Payment Cancelation', '<div>Subject: Payment Cancellation - Order #{{invoice_id}}</div><div><br></div><div>Here are the details of your order:</div><div><br></div><div>Order Number: #{{invoice_id}}</div><div>Payment Amount: {{total}}</div><div>Payment Method: {{gateway_name}}</div><div><br></div>', 0, NULL, '2023-10-17 12:50:00', '2023-10-17 12:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features_settings`
--

DROP TABLE IF EXISTS `features_settings`;
CREATE TABLE `features_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image` int(11) DEFAULT NULL,
  `icon` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_managers`
--

DROP TABLE IF EXISTS `file_managers`;
CREATE TABLE `file_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `external_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_sections`
--

DROP TABLE IF EXISTS `frontend_sections`;
CREATE TABLE `frontend_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_title` text COLLATE utf8mb4_unicode_ci,
  `title` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_page_title` tinyint(4) DEFAULT NULL,
  `has_banner_image` tinyint(4) NOT NULL DEFAULT '0',
  `has_image` tinyint(4) NOT NULL DEFAULT '0',
  `has_description` tinyint(4) NOT NULL DEFAULT '0',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `banner_image` int(11) DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

DROP TABLE IF EXISTS `gateways`;
CREATE TABLE `gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=Active,0=Disable',
  `mode` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=live,2=sandbox',
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client id, public key, key, store id, api key',
  `secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client secret, secret, store password, auth token',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`,`user_id`, `title`, `slug`, `image`, `status`, `mode`, `url`, `key`, `secret`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1,'Paypal', 'paypal', 'assets/images/gateway-icon/paypal.png', 1, 2, '', '', '', NULL, NULL, NULL),
(2, 1,'Stripe', 'stripe', 'assets/images/gateway-icon/stripe.png', 1, 2, '', '', '', NULL, NULL, NULL),
(3, 1,'Razorpay', 'razorpay', 'assets/images/gateway-icon/razorpay.png', 1, 2, '', '', '', NULL, NULL, NULL),
(4, 1,'Instamojo', 'instamojo', 'assets/images/gateway-icon/instamojo.png', 1, 2, '', '', '', NULL, NULL, NULL),
(5, 1,'Mollie', 'mollie', 'assets/images/gateway-icon/mollie.png', 1, 2, '', '', '', NULL, NULL, NULL),
(6, 1,'Paystack', 'paystack', 'assets/images/gateway-icon/paystack.png', 1, 2, '', '', '', NULL, NULL, NULL),
(7, 1,'Sslcommerz', 'sslcommerz', 'assets/images/gateway-icon/sslcommerz.png', 1, 2, '', '', '', NULL, NULL, NULL),
(8, 1,'Flutterwave', 'flutterwave', 'assets/images/gateway-icon/flutterwave.png', 1, 2, '', '', '', NULL, NULL, NULL),
(9, 1,'Mercadopago', 'mercadopago', 'assets/images/gateway-icon/mercadopago.png', 1, 2, '', '', '', NULL, NULL, NULL),
(10,1, 'Bank', 'bank', 'assets/images/gateway-icon/bank.png', 1, 2, '', '', '', NULL, NULL, NULL),
(11,1, 'Cash', 'cash', 'assets/images/gateway-icon/cash.png', 1, 2, '', '', '', NULL, NULL, NULL),
(12, 2,'Paypal', 'paypal', 'assets/images/gateway-icon/paypal.png', 1, 2, '', '', '', NULL, NULL, NULL),
(13, 2,'Stripe', 'stripe', 'assets/images/gateway-icon/stripe.png', 1, 2, '', '', '', NULL, NULL, NULL),
(14, 2,'Razorpay', 'razorpay', 'assets/images/gateway-icon/razorpay.png', 1, 2, '', '', '', NULL, NULL, NULL),
(15, 2,'Instamojo', 'instamojo', 'assets/images/gateway-icon/instamojo.png', 1, 2, '', '', '', NULL, NULL, NULL),
(16, 2,'Mollie', 'mollie', 'assets/images/gateway-icon/mollie.png', 1, 2, '', '', '', NULL, NULL, NULL),
(17, 2,'Paystack', 'paystack', 'assets/images/gateway-icon/paystack.png', 1, 2, '', '', '', NULL, NULL, NULL),
(18, 2,'Sslcommerz', 'sslcommerz', 'assets/images/gateway-icon/sslcommerz.png', 1, 2, '', '', '', NULL, NULL, NULL),
(19, 2,'Flutterwave', 'flutterwave', 'assets/images/gateway-icon/flutterwave.png', 1, 2, '', '', '', NULL, NULL, NULL),
(20, 2,'Mercadopago', 'mercadopago', 'assets/images/gateway-icon/mercadopago.png', 1, 2, '', '', '', NULL, NULL, NULL),
(21,2, 'Bank', 'bank', 'assets/images/gateway-icon/bank.png', 1, 2, '', '', '', NULL, NULL, NULL),
(22,2, 'Cash', 'cash', 'assets/images/gateway-icon/cash.png', 1, 2, '', '', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

DROP TABLE IF EXISTS `gateway_currencies`;
CREATE TABLE `gateway_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gateway_id` bigint(20) UNSIGNED NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `conversion_rate` decimal(8,2) NOT NULL DEFAULT '1.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateway_currencies`
--

INSERT INTO `gateway_currencies` (`id`,`user_id`, `gateway_id`, `currency`, `conversion_rate`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,1, 1, 'USD', 1.00, NULL, NULL, NULL),
(2,1, 2, 'USD', 1.00, NULL, NULL, NULL),
(3,1, 3, 'INR', 80.00, NULL, NULL, NULL),
(4,1, 4, 'INR', 80.00, NULL, NULL, NULL),
(5,1, 5, 'USD', 1.00, NULL, NULL, NULL),
(6,1, 6, 'NGN', 464.00, NULL, NULL, NULL),
(7,1, 7, 'BDT', 100.00, NULL, NULL, NULL),
(8,1, 8, 'NGN', 464.00, NULL, NULL, NULL),
(9,1, 9, 'BRL', 5.00, NULL, NULL, NULL),
(10,1, 10, 'USD', 1.00, NULL, NULL, NULL),
(11,1, 11, 'USD', 1.00, NULL, NULL, NULL),
(12,2, 12, 'USD', 1.00, NULL, NULL, NULL),
(13,2, 13, 'USD', 1.00, NULL, NULL, NULL),
(14,2, 14, 'INR', 80.00, NULL, NULL, NULL),
(15,2, 15, 'INR', 80.00, NULL, NULL, NULL),
(16,2, 16, 'USD', 1.00, NULL, NULL, NULL),
(17,2, 17, 'NGN', 464.00, NULL, NULL, NULL),
(18,2, 18, 'BDT', 100.00, NULL, NULL, NULL),
(19,2, 19, 'NGN', 464.00, NULL, NULL, NULL),
(20,2, 20, 'BRL', 5.00, NULL, NULL, NULL),
(21,2, 21, 'USD', 1.00, NULL, NULL, NULL),
(22,2, 22, 'USD', 1.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `customer_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `plan_id` int(11) NOT NULL DEFAULT '0',
  `coupon_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_id` int(11) NOT NULL DEFAULT '0',
  `due_date` datetime NOT NULL,
  `coupon_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(12,2) NOT NULL DEFAULT '0.00',
  `setup_fees` decimal(12,2) NOT NULL DEFAULT '0.00',
  `shipping_charge` decimal(12,2) NOT NULL DEFAULT '0.00',
  `is_mailed` tinyint(4) NOT NULL DEFAULT '0',
  `is_recurring` tinyint(4) NOT NULL DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_settings`
--

DROP TABLE IF EXISTS `invoice_settings`;
CREATE TABLE `invoice_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `logo` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_info` text COLLATE utf8mb4_unicode_ci,
  `prefix` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_one` text COLLATE utf8mb4_unicode_ci,
  `info_two` text COLLATE utf8mb4_unicode_ci,
  `info_three` text COLLATE utf8mb4_unicode_ci,
  `footer_text` text COLLATE utf8mb4_unicode_ci,
  `column` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_settings`
--

INSERT INTO `invoice_settings` (`id`, `user_id`, `type`, `logo`, `title`, `company_info`, `prefix`, `info_one`, `info_two`, `info_three`, `footer_text`, `column`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 7, 'Invoice', '<p style=\"color: rgb(89, 102, 128); font-family: &quot;inter tight&quot;, sans-serif; text-align: justify;\"><font face=\"Open Sans, Arial, sans-serif\"><span style=\"font-size: 14px;\">Zaisub Company</span></font></p><p style=\"color: rgb(89, 102, 128); font-family: &quot;inter tight&quot;, sans-serif; text-align: justify;\"><font face=\"Open Sans, Arial, sans-serif\"><span style=\"font-size: 14px;\">379, Attorney Express</span></font></p><p style=\"color: rgb(89, 102, 128); font-family: &quot;inter tight&quot;, sans-serif; text-align: justify;\"><font face=\"Open Sans, Arial, sans-serif\"><span style=\"font-size: 14px;\">West Lilliana, Bilzen.</span></font></p><p style=\"color: rgb(89, 102, 128); font-family: &quot;inter tight&quot;, sans-serif; text-align: justify;\"><font face=\"Open Sans, Arial, sans-serif\"><span style=\"font-size: 14px;\">Phone: 01234567890</span></font></p>', 'Inv-', '<div style=\"font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;\"><strong>Billing</strong></div><div style=\"font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;\">{{customer_name}}</div><div style=\"\"><font face=\"Verdana, Arial, Helvetica, sans-serif\">{{customer_email}}</font><br></div><div style=\"font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;\">Address : {{billing_address}}</div><div style=\"font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;\">{{billing_city}}, {{billing_state}} {{billing_zip}}</div><div style=\"font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;\">{{billing_country}}</div>', '<div style=\"font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;\"><br></div>', '<p><b>Shipping</b></p><p>{{customer_name}}</p><p>{{customer_email}}</p><p>Address : {{shipping_address}}</p><p>{{shipping_city}}, {{shipping_state}} {{shipping_zip}}</p><p>{{shipping_country}}</p>', '<p><span style=\"background-color: var(--white); text-align: var(--bs-body-text-align);\"><font face=\"Verdana, Arial, Helvetica, sans-serif\"><span style=\"font-weight: var(--bs-body-font-weight);\">{{</span>total<span style=\"font-weight: var(--bs-body-font-weight);\">}} was paid on {{</span>payment_date<span style=\"font-weight: var(--bs-body-font-weight);\">}} via {{</span>payment_method<span style=\"font-weight: var(--bs-body-font-weight);\">}}.</span></font></span></p>', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', '2023-10-16 13:56:27', '2023-10-17 12:53:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag_id` bigint(20) UNSIGNED DEFAULT NULL,
  `font` bigint(20) UNSIGNED DEFAULT NULL,
  `rtl` tinyint(4) DEFAULT '4',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `default` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `iso_code`, `flag_id`, `font`, `rtl`, `status`, `default`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'English', 'en', 9, NULL, 0, 1, 0, '2023-10-16 06:33:46', '2023-10-17 13:14:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

DROP TABLE IF EXISTS `licenses`;
CREATE TABLE `licenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_plan` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_histories`
--

DROP TABLE IF EXISTS `mail_histories`;
CREATE TABLE `mail_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `host` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `date` datetime DEFAULT NULL,
  `error` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metas`
--

DROP TABLE IF EXISTS `metas`;
CREATE TABLE `metas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` mediumtext COLLATE utf8mb4_unicode_ci,
  `meta_description` mediumtext COLLATE utf8mb4_unicode_ci,
  `meta_keyword` mediumtext COLLATE utf8mb4_unicode_ci,
  `og_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_06_23_121213_create_settings_table', 1),
(7, '2022_06_25_104329_create_countries_table', 1),
(8, '2022_06_25_110824_create_currencies_table', 1),
(9, '2022_06_25_111037_create_languages_table', 1),
(10, '2022_11_30_040739_create_gateways_table', 1),
(11, '2023_01_03_075827_create_gateway_currencies_table', 1),
(12, '2023_01_05_092212_create_file_managers_table', 1),
(13, '2023_01_07_120244_create_banks_table', 1),
(14, '2023_01_30_071830_create_payments_table', 1),
(15, '2023_05_29_125747_create_contact_messages_table', 1),
(16, '2023_07_09_100721_create_notifications_table', 1),
(17, '2023_07_20_052653_create_email_templates_table', 1),
(18, '2023_07_22_111528_database_backups_table', 1),
(19, '2023_07_22_111738_database_backup_cron_settings_table', 1),
(20, '2023_08_07_062359_create_authentication_log_table', 1),
(21, '2023_08_26_075204_create_metas_table', 1),
(22, '2023_09_05_090819_create_notification_seens_table', 1),
(23, '2023_09_26_055112_create_products_table', 1),
(24, '2023_09_26_093327_create_subscriptions_table', 1),
(25, '2023_09_26_112059_create_user_details_table', 1),
(26, '2023_09_26_132437_create_plans_table', 1),
(27, '2023_09_27_071617_create_mail_histories_table', 1),
(28, '2023_09_27_114312_create_checkout_page_settings_table', 1),
(29, '2023_10_01_093154_create_coupons_table', 1),
(30, '2023_10_01_110337_create_orders_table', 1),
(31, '2023_10_02_055452_create_invoices_table', 1),
(32, '2023_10_02_070636_create_licenses_table', 1),
(33, '2023_10_04_065739_create_tax_settings_table', 1),
(34, '2023_10_05_105255_create_webhooks_table', 1),
(35, '2023_10_08_074534_create_webhook_events_table', 1),
(36, '2023_10_10_160043_create_invoice_settings_table', 1),
(37, '2023_10_23_093637_create_packages_table', 1),
(38, '2023_10_23_094232_create_user_packages_table', 1),
(39, '2023_10_23_105532_create_subscription_orders_table', 1),
(40, '2023_10_25_075216_create_frontend_sections_table', 1),
(41, '2023_10_25_125314_create_features_settings_table', 1),
(42, '2023_10_26_110108_create_best_features_settings_table', 1),
(43, '2023_10_26_122659_create_testimonials_table', 1),
(44, '2023_10_26_124142_create_faqs_table', 1),
(45, '2023_10_31_063626_add_dependency_field_for_saas', 1),
(46, '2023_11_13_130122_add_dependency_field_for_affiliate', 1),
(47, '2023_11_15_054606_create_affiliate_configs_table', 1),
(48, '2023_11_18_112911_create_affiliate_histories_table', 1),
(49, '2023_11_19_061425_create_beneficiaries_table', 1),
(50, '2023_11_19_061522_create_withdraws_table', 1),
(51, '2023_11_19_062635_create_transactions_table', 1);
-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `link` text COLLATE utf8mb4_unicode_ci,
  `view_status` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_seens`
--

DROP TABLE IF EXISTS `notification_seens`;
CREATE TABLE `notification_seens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_id` tinyint(4) DEFAULT NULL,
  `plan_id` bigint(20) DEFAULT NULL,
  `invoice_id` bigint(20) DEFAULT NULL,
  `gateway_id` bigint(20) DEFAULT NULL,
  `subscription_id` bigint(20) DEFAULT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount_type` tinyint(4) NOT NULL DEFAULT '0',
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `setup_fees` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax_type` int(11) NOT NULL DEFAULT '0',
  `conversion_rate` decimal(12,2) NOT NULL DEFAULT '0.00',
  `platform_charge` decimal(12,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `transaction_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` tinyint(4) NOT NULL DEFAULT '1',
  `delivery_status` tinyint(4) NOT NULL DEFAULT '1',
  `system_currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_deposit_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_deposit_slip_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_limit` int(11) NOT NULL DEFAULT '-1',
  `product_limit` int(11) NOT NULL DEFAULT '-1',
  `subscription_limit` int(11) NOT NULL DEFAULT '-1',
  `icon_id` int(11) DEFAULT NULL,
  `others` text COLLATE utf8mb4_unicode_ci,
  `monthly_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `yearly_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'active for 1 , deactivate for 0',
  `is_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'active for 1 , deactivate for 0',
  `is_trail` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'active for 1 , deactivate for 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `otp` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentable_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_id` bigint(20) UNSIGNED NOT NULL,
  `paymentId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tnxId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deposit_slip` int(11) DEFAULT NULL,
  `sub_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(12,2) NOT NULL DEFAULT '0.00',
  `system_currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conversion_rate` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `grand_total_with_conversation_rate` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `grand_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_details` longtext COLLATE utf8mb4_unicode_ci,
  `gateway_callback_details` longtext COLLATE utf8mb4_unicode_ci,
  `payment_time` datetime DEFAULT NULL,
  `payment_status` tinyint(4) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_day` int(11) NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `billing_cycle` tinyint(4) NOT NULL DEFAULT '0',
  `shipping_charge` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `bill` int(11) NOT NULL DEFAULT '0',
  `duration` tinyint(4) NOT NULL DEFAULT '0',
  `number_of_recurring_cycle` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `free_trail` int(11) NOT NULL DEFAULT '0',
  `setup_fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `option_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `option_key`, `option_value`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'build_version', '6', NULL, '2023-10-15 05:58:35', '2023-10-25 10:03:27'),
(2, 'current_version', '3.2', NULL, '2023-10-15 05:58:35', '2023-10-25 10:03:27'),
(13, 'app_color_design_type', '1', NULL, '2023-10-15 09:00:49', '2023-10-15 09:00:49'),
(14, 'app_primary_color', '#ff671b', NULL, '2023-10-15 09:00:49', '2023-10-15 09:00:49'),
(15, 'app_secondary_color', '#111111', NULL, '2023-10-15 09:00:49', '2023-10-15 09:00:49'),
(16, 'app_text_color', '#585858', NULL, '2023-10-15 09:00:50', '2023-10-15 09:00:50'),
(17, 'app_section_bg_color', '#fffaf7', NULL, '2023-10-15 09:00:50', '2023-10-15 09:00:50'),
(18, 'app_hero_bg_color1', '#000000', NULL, '2023-10-15 09:00:50', '2023-10-15 09:00:50'),
(19, 'app_hero_bg_color2', '#000000', NULL, '2023-10-15 09:00:50', '2023-10-15 09:00:50'),
(20, 'app_hero_bg_color', NULL, NULL, '2023-10-15 09:00:50', '2023-10-15 09:00:50'),
(21, 'app_logo', '71', NULL, '2023-10-15 09:00:50', '2023-11-02 10:43:49'),
(22, 'login_left_image', '51', NULL, '2023-10-15 09:00:50', '2023-11-01 14:43:43'),
(23, 'app_preloader', '5', NULL, '2023-10-15 09:03:03', '2023-10-15 09:03:03'),
(24, 'google_login_status', '0', NULL, '2023-10-16 09:15:03', '2023-10-16 09:15:03'),
(25, 'facebook_login_status', '0', NULL, '2023-10-16 09:15:35', '2023-10-16 09:15:35'),
(30, 'cookie_status', '1', NULL, '2023-10-16 09:28:44', '2023-10-17 05:48:46'),
(31, 'cookie_consent_text', 'Cookie Consent', NULL, '2023-10-16 09:28:57', '2023-10-16 09:28:57'),
(32, 'app_preloader_status', '1', NULL, '2023-10-16 09:29:31', '2023-10-16 09:29:47'),
(33, 'app_name', 'Zaisub', NULL, '2023-10-17 10:43:33', '2023-10-17 10:43:33'),
(34, 'app_email', 'zaisub@gmail.com', NULL, '2023-10-17 10:43:33', '2023-11-01 14:45:38'),
(35, 'app_contact_number', '+0086546', NULL, '2023-10-17 10:43:33', '2023-11-01 14:45:38'),
(36, 'app_location', 'new work', NULL, '2023-10-17 10:43:33', '2023-11-01 14:45:38'),
(37, 'app_copyright', 'Copyright © 2023, All Rights Reserved', NULL, '2023-10-17 10:43:33', '2023-11-01 14:45:38'),
(38, 'app_developed', NULL, NULL, '2023-10-17 10:43:33', '2023-10-17 10:43:33'),
(39, 'app_timezone', 'UTC', NULL, '2023-10-17 10:43:33', '2023-10-17 10:43:33'),
(40, 'show_language_switcher', '1', NULL, '2023-10-17 13:17:19', '2023-10-17 13:17:19'),
(45, 'frontend_status', '1', NULL, '2023-11-01 14:18:19', '2023-11-01 14:18:19'),
(46, 'registration_status', '1', NULL, '2023-11-01 14:18:19', '2023-11-01 14:18:19'),
(47, 'meta_keyword', NULL, NULL, '2023-11-01 14:18:19', '2023-11-01 14:18:19'),
(48, 'meta_author', NULL, NULL, '2023-11-01 14:18:19', '2023-11-01 14:18:19'),
(49, 'meta_description', NULL, NULL, '2023-11-01 14:18:19', '2023-11-01 14:18:19'),
(50, 'social_media_facebook', 'https://www.facebook.com/', NULL, '2023-11-01 14:18:19', '2023-11-01 14:47:11'),
(51, 'social_media_twitter', 'https://www.twitter.com/', NULL, '2023-11-01 14:18:19', '2023-11-01 14:47:11'),
(52, 'social_media_linkedin', 'https://www.linkedin.com/', NULL, '2023-11-01 14:18:19', '2023-11-01 14:47:11'),
(53, 'social_media_skype', 'https://www.skype.com/', NULL, '2023-11-01 14:18:19', '2023-11-01 14:47:11'),
(54, 'app_fav_icon', '35', NULL, '2023-11-01 14:20:51', '2023-11-01 14:21:09'),
(55, 'app_logo_white', '47', NULL, '2023-11-01 20:38:58', '2023-11-01 20:38:58'),
(56, 'app_footer_text', 'Our subscription and billing management software project aimed to streamline our business operations. The software offers comprehensive features, including automated billing, customization, and seamless integration with existing systems.', NULL, '2023-11-01 14:45:38', '2023-11-02 10:45:48'),
(57, 'develop_by', 'Zaisub', NULL, '2023-11-01 14:45:38', '2023-11-01 14:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `subscription_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliate_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `due_day` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(12,2) NOT NULL,
  `free_trail` int(11) NOT NULL DEFAULT '0',
  `setup_fee` decimal(9,2) NOT NULL DEFAULT '0.00',
  `billing_cycle` tinyint(4) NOT NULL DEFAULT '0',
  `bill` int(11) NOT NULL DEFAULT '1',
  `duration` tinyint(4) NOT NULL DEFAULT '0',
  `number_of_recurring_cycle` int(11) NOT NULL DEFAULT '0',
  `shipping_charge` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_orders`
--

DROP TABLE IF EXISTS `subscription_orders`;
CREATE TABLE `subscription_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_type` tinyint(4) NOT NULL DEFAULT '1',
  `payment_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount_type` tinyint(4) NOT NULL DEFAULT '0',
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax_type` tinyint(4) NOT NULL DEFAULT '1',
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) DEFAULT '0.00',
  `transaction_amount` decimal(12,2) DEFAULT '0.00',
  `system_currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_id` bigint(20) UNSIGNED NOT NULL,
  `gateway_currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conversion_rate` decimal(12,2) DEFAULT '1.00',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=pending, 1=paid, 2=cancelled',
  `bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bank_deposit_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_deposit_slip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_settings`
--

DROP TABLE IF EXISTS `tax_settings`;
CREATE TABLE `tax_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tax_rule_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `tax_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `tax_type` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` tinytext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` tinyint(4) NOT NULL,
  `tnxId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `purpose` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_time` datetime NOT NULL,
  `payment_method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nick_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_zip_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_logo` int(11) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` bigint(20) UNSIGNED DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '2',
  `email_verification_status` tinyint(4) NOT NULL DEFAULT '0',
  `phone_verification_status` tinyint(4) NOT NULL DEFAULT '0',
  `google_auth_status` tinyint(4) NOT NULL DEFAULT '0',
  `google2fa_secret` text COLLATE utf8mb4_unicode_ci,
  `google_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` int(11) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `last_seen` datetime NOT NULL DEFAULT '2023-11-02 12:01:36',
  `show_email_in_public` tinyint(4) NOT NULL DEFAULT '1',
  `show_phone_in_public` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `affiliate_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliate_commission_amount` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `basic_info` longtext COLLATE utf8mb4_unicode_ci,
  `basic_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_info` longtext COLLATE utf8mb4_unicode_ci,
  `billing_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_zip_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_info` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_zip_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_method` tinyint(4) DEFAULT NULL,
  `payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revenue` decimal(12,2) NOT NULL DEFAULT '0.00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_packages`
--

DROP TABLE IF EXISTS `user_packages`;
CREATE TABLE `user_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_limit` int(11) NOT NULL DEFAULT '-1',
  `product_limit` int(11) NOT NULL DEFAULT '-1',
  `subscription_limit` int(11) NOT NULL DEFAULT '-1',
  `monthly_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `yearly_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `is_trail` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'active for 1 , deactivate for 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `webhooks`
--

DROP TABLE IF EXISTS `webhooks`;
CREATE TABLE `webhooks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `webhook_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `webhook_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `webhook_events`
--

DROP TABLE IF EXISTS `webhook_events`;
CREATE TABLE `webhook_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_type` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `webhook_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `request_data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `webhook_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_msg` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retry_count` int(11) NOT NULL,
  `response_data` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

DROP TABLE IF EXISTS `withdraws`;
CREATE TABLE `withdraws` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `beneficiary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tnxId` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` mediumtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=pending, 1=complete, 2=rejected',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `uuid`, `name`, `nick_name`, `email`, `mobile`, `country`, `state`, `city`, `zip_code`, `address`, `currency`, `company_name`, `company_designation`, `company_country`, `company_state`, `company_city`, `company_zip_code`, `company_address`, `company_phone`, `company_logo`, `email_verified_at`, `password`, `image`, `role`, `email_verification_status`, `phone_verification_status`, `google_auth_status`, `google2fa_secret`, `google_id`, `facebook_id`, `verify_token`, `otp`, `otp_expiry`, `last_seen`, `show_email_in_public`, `show_phone_in_public`, `created_by`, `status`, `remember_token`, `deleted_at`, `created_at`, `updated_at`, `affiliate_code`, `affiliate_commission_amount`) VALUES
(1, '12345', 'Administrator', NULL, 'admin@gmail.com', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$BdL5CyYVs/ceteKYiXmc4u.0Z8QQHe8VhUvnRO9tnpfvuEeq/21XW', 5, 1, 1, 1, 0, 'B3T6UKYRECCWXI6U', NULL, NULL, NULL, NULL, NULL, '2023-12-28 13:52:16', 1, 1, NULL, 1, '1VIdAymKBb6eDupJmkCvb6GvjuIYNr7lo7nLSQIeUklHtoMjJ8eUyWhUFiCH', NULL, NULL, '2023-12-28 13:47:16', NULL, 0.00),
(2, '123455', 'User Doe', NULL, 'user@gmail.com', '+005465463234', 'New Work', NULL, 'Hempstead', '453432', '401 7TH AVE, NEW YORK, NY 10001-3463, USA', 'AFA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$wBGbvfBQ21X0ZOQrJTywTO6VzIYSAhky5WBM.ThlmGmeWBF7cP.TC', 6, 2, 1, 1, 0, 'IWX76L5GD5X5LI7W', NULL, NULL, NULL, NULL, NULL, '2023-12-28 13:26:09', 1, 1, NULL, 1, NULL, NULL, NULL, '2023-12-28 13:21:09', NULL, 0.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliate_configs`
--
ALTER TABLE `affiliate_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_histories`
--
ALTER TABLE `affiliate_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authentication_log`
--
ALTER TABLE `authentication_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authentication_log_authenticatable_type_authenticatable_id_index` (`authenticatable_type`,`authenticatable_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `best_features_settings`
--
ALTER TABLE `best_features_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkout_page_settings`
--
ALTER TABLE `checkout_page_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `database_backups`
--
ALTER TABLE `database_backups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `database_backup_cron_settings`
--
ALTER TABLE `database_backup_cron_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features_settings`
--
ALTER TABLE `features_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_managers`
--
ALTER TABLE `file_managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_managers_file_name_unique` (`file_name`);

--
-- Indexes for table `frontend_sections`
--
ALTER TABLE `frontend_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_language_unique` (`language`),
  ADD UNIQUE KEY `languages_iso_code_unique` (`iso_code`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_histories`
--
ALTER TABLE `mail_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metas`
--
ALTER TABLE `metas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `metas_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_seens`
--
ALTER TABLE `notification_seens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_uuid_unique` (`uuid`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_orders`
--
ALTER TABLE `subscription_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_settings`
--
ALTER TABLE `tax_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_uuid_unique` (`uuid`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_packages`
--
ALTER TABLE `user_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webhooks`
--
ALTER TABLE `webhooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webhook_events`
--
ALTER TABLE `webhook_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliate_configs`
--
ALTER TABLE `affiliate_configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_histories`
--
ALTER TABLE `affiliate_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `authentication_log`
--
ALTER TABLE `authentication_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `best_features_settings`
--
ALTER TABLE `best_features_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkout_page_settings`
--
ALTER TABLE `checkout_page_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `database_backups`
--
ALTER TABLE `database_backups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `database_backup_cron_settings`
--
ALTER TABLE `database_backup_cron_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `features_settings`
--
ALTER TABLE `features_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_managers`
--
ALTER TABLE `file_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_sections`
--
ALTER TABLE `frontend_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_histories`
--
ALTER TABLE `mail_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metas`
--
ALTER TABLE `metas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_seens`
--
ALTER TABLE `notification_seens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_orders`
--
ALTER TABLE `subscription_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_settings`
--
ALTER TABLE `tax_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_packages`
--
ALTER TABLE `user_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webhooks`
--
ALTER TABLE `webhooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webhook_events`
--
ALTER TABLE `webhook_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;


