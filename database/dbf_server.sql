--
-- Database: `dbf_server`
--
# CREATE DATABASE IF NOT EXISTS `dbf_server` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
# USE `dbf_server`;

-- --------------------------------------------------------

--
-- Table structure for table `algorithm`
--

CREATE TABLE `algorithm` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rate_cpu` double UNSIGNED DEFAULT NULL,
  `rate_gpu` double UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crack`
--

CREATE TABLE `crack` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gen_id` tinyint(3) UNSIGNED NOT NULL,
  `algo_id` int(10) UNSIGNED NOT NULL,
  `gen_config` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `len_min` tinyint(3) UNSIGNED NOT NULL,
  `len_max` tinyint(3) UNSIGNED NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `charset_1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `charset_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `charset_3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `charset_4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mask` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `target` varchar(5120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_dep` tinyint(4) DEFAULT '0',
  `result` varchar(10240) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key_total` bigint(20) UNSIGNED DEFAULT NULL,
  `key_assigned` bigint(20) UNSIGNED DEFAULT '0',
  `key_finished` bigint(20) UNSIGNED DEFAULT '0',
  `key_error` bigint(20) UNSIGNED DEFAULT '0',
  `res_assigned` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(4) DEFAULT '0' COMMENT '0: Not assigned all keys; 1: Pending (All keys are assigned); 2: Finished;',
  `ts_create` int(10) UNSIGNED DEFAULT NULL,
  `ts_last_connect` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cracker`
--

CREATE TABLE `cracker` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `config` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '{\n    "stdin":"",\n    "infile":""\n}',
  `input_mode` tinyint(3) UNSIGNED DEFAULT NULL COMMENT '0: none; 1: infile; 2: stdin; 3: both;'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cracker_algo`
--

CREATE TABLE `cracker_algo` (
  `cracker_id` int(10) UNSIGNED NOT NULL,
  `algo_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cracker_gen`
--

CREATE TABLE `cracker_gen` (
  `cracker_id` int(10) UNSIGNED NOT NULL,
  `gen_id` tinyint(3) UNSIGNED NOT NULL,
  `config` varchar(500) DEFAULT NULL COMMENT '{}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cracker_plat`
--

CREATE TABLE `cracker_plat` (
  `cracker_id` int(10) UNSIGNED NOT NULL,
  `plat_id` tinyint(3) UNSIGNED NOT NULL,
  `md5` char(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crack_info`
--

CREATE TABLE `crack_info` (
  `crack_id` bigint(20) UNSIGNED NOT NULL,
  `plat_id` tinyint(3) UNSIGNED NOT NULL,
  `gen_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `cracker_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `download`
--

CREATE TABLE `download` (
  `sort` tinyint(4) DEFAULT NULL,
  `file_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `os` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `arch` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `processor` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(10) UNSIGNED DEFAULT NULL,
  `md5` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `generator`
--

CREATE TABLE `generator` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `config` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '{\n    "stdout":"",\n    "infile":""\n}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gen_plat`
--

CREATE TABLE `gen_plat` (
  `gen_id` tinyint(3) UNSIGNED NOT NULL,
  `plat_id` tinyint(3) UNSIGNED NOT NULL,
  `alt_plat_id` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'if NULL generator exists for the current platform, else alternative platform`s id of the generator',
  `md5` char(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `info_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `info_type` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `info_value` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platform`
--

CREATE TABLE `platform` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'os_arch_processor[_brand]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `crack_id` bigint(20) UNSIGNED NOT NULL,
  `start` bigint(20) UNSIGNED NOT NULL,
  `offset` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ts_save` int(10) UNSIGNED DEFAULT '0',
  `retry` tinyint(3) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `algorithm`
--
ALTER TABLE `algorithm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_algorithm` (`name`);

--
-- Indexes for table `crack`
--
ALTER TABLE `crack`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_crack` (`gen_id`),
  ADD KEY `idx_crack_0` (`algo_id`),
  ADD KEY `idx_crack_1` (`res_assigned`);

--
-- Indexes for table `cracker`
--
ALTER TABLE `cracker`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_cracker` (`name`);

--
-- Indexes for table `cracker_algo`
--
ALTER TABLE `cracker_algo`
  ADD PRIMARY KEY (`cracker_id`,`algo_id`),
  ADD KEY `idx_cracker_algo` (`cracker_id`),
  ADD KEY `idx_cracker_algo_0` (`algo_id`);

--
-- Indexes for table `cracker_gen`
--
ALTER TABLE `cracker_gen`
  ADD PRIMARY KEY (`cracker_id`,`gen_id`),
  ADD KEY `idx_cracker_gen` (`cracker_id`),
  ADD KEY `idx_cracker_gen_0` (`gen_id`);

--
-- Indexes for table `cracker_plat`
--
ALTER TABLE `cracker_plat`
  ADD PRIMARY KEY (`cracker_id`,`plat_id`),
  ADD KEY `idx_cracker_plat` (`cracker_id`),
  ADD KEY `idx_cracker_plat_0` (`plat_id`);

--
-- Indexes for table `crack_info`
--
ALTER TABLE `crack_info`
  ADD PRIMARY KEY (`crack_id`,`plat_id`),
  ADD KEY `idx_crack_info` (`crack_id`),
  ADD KEY `idx_crack_info_0` (`plat_id`),
  ADD KEY `idx_crack_info_1` (`gen_id`),
  ADD KEY `idx_crack_info_2` (`cracker_id`);

--
-- Indexes for table `download`
--
ALTER TABLE `download`
  ADD PRIMARY KEY (`file_type`,`name`,`os`,`arch`,`processor`,`brand`);

--
-- Indexes for table `generator`
--
ALTER TABLE `generator`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_generator` (`name`);

--
-- Indexes for table `gen_plat`
--
ALTER TABLE `gen_plat`
  ADD PRIMARY KEY (`gen_id`,`plat_id`),
  ADD KEY `idx_gen_plat` (`gen_id`),
  ADD KEY `idx_gen_plat_0` (`plat_id`),
  ADD KEY `idx_gen_plat_1` (`alt_plat_id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`info_name`);

--
-- Indexes for table `platform`
--
ALTER TABLE `platform`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_platform` (`name`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD KEY `idx_task` (`crack_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crack`
--
ALTER TABLE `crack`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `crack`
--
ALTER TABLE `crack`
  ADD CONSTRAINT `fk_crack` FOREIGN KEY (`gen_id`) REFERENCES `generator` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_crack_0` FOREIGN KEY (`algo_id`) REFERENCES `algorithm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cracker_algo`
--
ALTER TABLE `cracker_algo`
  ADD CONSTRAINT `fk_cracker_algo` FOREIGN KEY (`cracker_id`) REFERENCES `cracker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cracker_algo_0` FOREIGN KEY (`algo_id`) REFERENCES `algorithm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cracker_gen`
--
ALTER TABLE `cracker_gen`
  ADD CONSTRAINT `fk_cracker_gen` FOREIGN KEY (`cracker_id`) REFERENCES `cracker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cracker_gen_0` FOREIGN KEY (`gen_id`) REFERENCES `generator` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cracker_plat`
--
ALTER TABLE `cracker_plat`
  ADD CONSTRAINT `fk_cracker_plat` FOREIGN KEY (`cracker_id`) REFERENCES `cracker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cracker_plat_0` FOREIGN KEY (`plat_id`) REFERENCES `platform` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crack_info`
--
ALTER TABLE `crack_info`
  ADD CONSTRAINT `fk_crack_info` FOREIGN KEY (`crack_id`) REFERENCES `crack` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_crack_info_0` FOREIGN KEY (`plat_id`) REFERENCES `platform` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_crack_info_1` FOREIGN KEY (`gen_id`) REFERENCES `generator` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_crack_info_2` FOREIGN KEY (`cracker_id`) REFERENCES `cracker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gen_plat`
--
ALTER TABLE `gen_plat`
  ADD CONSTRAINT `fk_gen_plat` FOREIGN KEY (`gen_id`) REFERENCES `generator` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gen_plat_0` FOREIGN KEY (`plat_id`) REFERENCES `platform` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gen_plat_1` FOREIGN KEY (`alt_plat_id`) REFERENCES `platform` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `fk_task` FOREIGN KEY (`crack_id`) REFERENCES `crack` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
