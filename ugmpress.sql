-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2018 at 05:40 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ugmpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE IF NOT EXISTS `author` (
  `author_id` mediumint(9) NOT NULL,
  `work_unit_id` mediumint(9) DEFAULT NULL,
  `institute_id` mediumint(9) DEFAULT NULL,
  `author_nip` varchar(256) NOT NULL,
  `author_name` varchar(256) NOT NULL,
  `author_degree_front` varchar(256) NOT NULL,
  `author_degree_back` varchar(256) NOT NULL,
  `author_latest_education` enum('s1','s2','s3','other') NOT NULL,
  `author_address` text NOT NULL,
  `author_contact` varchar(20) NOT NULL,
  `author_email` varchar(256) NOT NULL,
  `bank_id` varchar(4) DEFAULT NULL,
  `author_saving_num` varchar(30) NOT NULL,
  `heir_name` varchar(256) NOT NULL,
  `user_id` mediumint(9) DEFAULT NULL,
  `author_ktp` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`author_id`, `work_unit_id`, `institute_id`, `author_nip`, `author_name`, `author_degree_front`, `author_degree_back`, `author_latest_education`, `author_address`, `author_contact`, `author_email`, `bank_id`, `author_saving_num`, `heir_name`, `user_id`, `author_ktp`) VALUES
(16, 6, 4, '9988776655', 'bagaskara luthfi', '', 'S.T', 's1', 'purworejo', '085640276276', 'bagas@gmail.com', '002', '123456789', 'Sultan', 19, 'bagaskara_luthfi_20180922222655.jpg'),
(18, 8, 4, '23454678', 'syuhada sipayung', '', 'S.T, M.T', 's1', 'medan', '086775446678', 'syu@gmail.com', '008', '435657567', 'Sultona', 21, 'syuhada_sipayung_20180922223122.jpg'),
(19, 7, 5, '676767', 'lutfi authroe', 'Ir.', '', 's1', 'purworejo', '0856402762765', 'bgsbla33333@gmail.comm', '525', '2553646', 'Donic', 29, ''),
(20, 9, 4, '13245', 'edward', '', 'S.H.', 's1', 'jakarta', '08562723234', 'edward@gmail.com', '002', '2134567', 'Heru', 20, '');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `bank_name` varchar(256) NOT NULL,
  `bank_id` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`bank_name`, `bank_id`) VALUES
('BANK BRI', '002'),
('BANK EKSPOR INDONESIA', '003'),
('BANK MANDIRI', '008'),
('BANK BNI', '009'),
('BANK DANAMON', '011'),
('PERMATA BANK', '013'),
('BANK BCA', '014'),
('BANK BII', '016'),
('BANK PANIN', '019'),
('BANK ARTA NIAGA KENCANA', '020'),
('BANK NIAGA', '022'),
('BANK BUANA IND', '023'),
('BANK LIPPO', '026'),
('BANK NISP', '028'),
('AMERICAN EXPRESS BANK LTD', '030'),
('CITIBANK N.A.', '031'),
('JP. MORGAN CHASE BANK, N.A.', '032'),
('BANK OF AMERICA, N.A', '033'),
('ING INDONESIA BANK', '034'),
('BANK MULTICOR TBK.', '036'),
('BANK ARTHA GRAHA', '037'),
('BANK CREDIT AGRICOLE INDOSUEZ', '039'),
('THE BANGKOK BANK COMP. LTD', '040'),
('THE HONGKONG & SHANGHAI B.C.', '041'),
('THE BANK OF TOKYO MITSUBISHI UFJ LTD', '042'),
('BANK SUMITOMO MITSUI INDONESIA', '045'),
('BANK DBS INDONESIA', '046'),
('BANK RESONA PERDANIA', '047'),
('BANK MIZUHO INDONESIA', '048'),
('STANDARD CHARTERED BANK', '050'),
('BANK ABN AMRO', '052'),
('BANK KEPPEL TATLEE BUANA', '053'),
('BANK CAPITAL INDONESIA, TBK.', '054'),
('BANK BNP PARIBAS INDONESIA', '057'),
('BANK UOB INDONESIA', '058'),
('KOREA EXCHANGE BANK DANAMON', '059'),
('RABOBANK INTERNASIONAL INDONESIA', '060'),
('ANZ PANIN BANK', '061'),
('DEUTSCHE BANK AG.', '067'),
('BANK WOORI INDONESIA', '068'),
('BANK OF CHINA LIMITED', '069'),
('BANK BUMI ARTA', '076'),
('BANK EKONOMI', '087'),
('BANK ANTARDAERAH', '088'),
('BANK HAGA', '089'),
('BANK IFI', '093'),
('BANK CENTURY, TBK.', '095'),
('BANK MAYAPADA', '097'),
('BANK JABAR', '110'),
('BANK DKI', '111'),
('BPD DIY', '112'),
('BANK JATENG', '113'),
('BANK JATIM', '114'),
('BPD JAMBI', '115'),
('BPD ACEH', '116'),
('BANK SUMUT', '117'),
('BANK NAGARI', '118'),
('BANK RIAU', '119'),
('BANK SUMSEL', '120'),
('BANK LAMPUNG', '121'),
('BPD KALSEL', '122'),
('BPD KALIMANTAN BARAT', '123'),
('BPD KALTIM', '124'),
('BPD KALTENG', '125'),
('BPD SULSEL', '126'),
('BANK SULUT', '127'),
('BPD NTB', '128'),
('BPD BALI', '129'),
('BANK NTT', '130'),
('BANK MALUKU', '131'),
('BPD PAPUA', '132'),
('BANK BENGKULU', '133'),
('BPD SULAWESI TENGAH', '134'),
('BANK SULTRA', '135'),
('BANK NUSANTARA PARAHYANGAN', '145'),
('BANK SWADESI', '146'),
('BANK MUAMALAT', '147'),
('BANK MESTIKA', '151'),
('BANK METRO EXPRESS', '152'),
('BANK SHINTA INDONESIA', '153'),
('BANK MASPION', '157'),
('BANK HAGAKITA', '159'),
('BANK GANESHA', '161'),
('BANK WINDU KENTJANA', '162'),
('HALIM INDONESIA BANK', '164'),
('BANK HARMONI INTERNATIONAL', '166'),
('BANK KESAWAN', '167'),
('BANK TABUNGAN NEGARA (PERSERO)', '200'),
('BANK HIMPUNAN SAUDARA 1906, TBK .', '212'),
('BANK TABUNGAN PENSIUNAN NASIONAL', '213'),
('BANK SWAGUNA', '405'),
('BANK JASA ARTA', '422'),
('BANK MEGA', '426'),
('BANK JASA JAKARTA', '427'),
('BANK BUKOPIN', '441'),
('BANK SYARIAH MANDIRI', '451'),
('BANK BISNIS INTERNASIONAL', '459'),
('BANK SRI PARTHA', '466'),
('BANK JASA JAKARTA', '472'),
('BANK BINTANG MANUNGGAL', '484'),
('BANK BUMIPUTERA', '485'),
('BANK YUDHA BHAKTI', '490'),
('BANK MITRANIAGA', '491'),
('BANK AGRO NIAGA', '494'),
('BANK INDOMONEX', '498'),
('BANK ROYAL INDONESIA', '501'),
('BANK ALFINDO', '503'),
('BANK SYARIAH MEGA', '506'),
('BANK INA PERDANA', '513'),
('BANK HARFA', '517'),
('PRIMA MASTER BANK', '520'),
('BANK PERSYARIKATAN INDONESIA', '521'),
('BANK DIPO INTERNATIONAL', '523'),
('BANK AKITA', '525'),
('LIMAN INTERNATIONAL BANK', '526'),
('ANGLOMAS INTERNASIONAL BANK', '531'),
('BANK KESEJAHTERAAN EKONOMI', '535'),
('BANK UIB', '536'),
('BANK ARTOS IND', '542'),
('BANK PURBA DANARTA', '547'),
('BANK MULTI ARTA SENTOSA', '548'),
('BANK MAYORA', '553'),
('BANK INDEX SELINDO', '555'),
('BANK EKSEKUTIF', '558'),
('CENTRATAMA NASIONAL BANK', '559'),
('BANK FAMA INTERNASIONAL', '562'),
('BANK SINAR HARAPAN BALI', '564'),
('BANK VICTORIA INTERNATIONAL', '566'),
('BANK HARDA', '567'),
('BANK FINCONESIA', '945'),
('BANK MERINCORP', '946'),
('BANK MAYBANK INDOCORP', '947'),
('BANK OCBC – INDONESIA', '948'),
('BANK CHINA TRUST INDONESIA', '949'),
('BANK COMMONWEALTH', '950');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `book_id` mediumint(9) NOT NULL,
  `draft_id` mediumint(9) DEFAULT NULL,
  `book_code` varchar(256) NOT NULL,
  `book_title` varchar(256) NOT NULL,
  `book_edition` varchar(256) NOT NULL,
  `isbn` varchar(256) NOT NULL,
  `book_file` varchar(256) DEFAULT NULL,
  `published_date` date NOT NULL,
  `printing_type` enum('p','o') NOT NULL DEFAULT 'o',
  `serial_num` mediumint(9) NOT NULL,
  `serial_num_per_year` mediumint(9) NOT NULL,
  `copies_num` varchar(256) NOT NULL,
  `book_notes` text NOT NULL,
  `is_reprint` enum('y','n') NOT NULL DEFAULT 'n'
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `draft_id`, `book_code`, `book_title`, `book_edition`, `isbn`, `book_file`, `published_date`, `printing_type`, `serial_num`, `serial_num_per_year`, `copies_num`, `book_notes`, `is_reprint`) VALUES
(19, 40, '', 'cara memelihara lele', '', '', 'cara_memelihara_lele_20181009130948.docx', '2018-10-09', 'o', 0, 0, '', '', 'n'),
(20, 41, '', 'cara database', '', '', '', '2018-10-09', 'o', 0, 0, '', '', 'n');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` mediumint(9) NOT NULL,
  `category_name` varchar(256) NOT NULL,
  `category_year` year(4) NOT NULL,
  `category_note` text NOT NULL,
  `date_open` date NOT NULL,
  `date_close` date NOT NULL,
  `category_status` enum('y','n') NOT NULL DEFAULT 'y'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_year`, `category_note`, `date_open`, `date_close`, `category_status`) VALUES
(13, 'Umum', 2018, 'Bebas untuk siapa saja', '2018-09-25', '2019-03-28', 'y'),
(15, 'Hibah Jogja', 2018, 'heheh', '2018-08-10', '2019-09-29', 'y'),
(16, 'bebas', 2018, 'hibah untuk apa saja bebas yaa', '2018-10-30', '2018-11-10', 'n');

-- --------------------------------------------------------

--
-- Table structure for table `draft`
--

CREATE TABLE IF NOT EXISTS `draft` (
  `draft_id` mediumint(9) NOT NULL,
  `category_id` mediumint(9) DEFAULT NULL,
  `theme_id` mediumint(9) DEFAULT NULL,
  `draft_title` varchar(256) NOT NULL,
  `draft_file` varchar(256) DEFAULT NULL,
  `entry_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `finish_date` timestamp NULL DEFAULT NULL,
  `print_date` timestamp NULL DEFAULT NULL,
  `is_review` enum('y','n') NOT NULL DEFAULT 'n',
  `review_start_date` datetime NOT NULL,
  `review_end_date` datetime NOT NULL,
  `review1_file` varchar(255) NOT NULL,
  `review1_upload_date` timestamp NULL DEFAULT NULL,
  `review1_last_upload` varchar(255) NOT NULL,
  `review1_notes` text NOT NULL,
  `review1_notes_author` text NOT NULL,
  `review1_deadline` datetime NOT NULL,
  `review1_flag` enum('y','n') DEFAULT NULL,
  `review2_file` varchar(255) NOT NULL,
  `review2_upload_date` timestamp NULL DEFAULT NULL,
  `review2_notes` text NOT NULL,
  `review2_notes_author` text NOT NULL,
  `review2_deadline` datetime NOT NULL,
  `review2_flag` enum('y','n') DEFAULT NULL,
  `review_status` text NOT NULL,
  `is_edit` enum('y','n') NOT NULL DEFAULT 'n',
  `edit_start_date` datetime NOT NULL,
  `edit_end_date` datetime NOT NULL,
  `edit_file` varchar(255) NOT NULL,
  `edit_upload_date` timestamp NULL DEFAULT NULL,
  `edit_last_upload` varchar(255) NOT NULL,
  `edit_notes` text NOT NULL,
  `edit_notes_author` text NOT NULL,
  `edit_deadline` datetime NOT NULL,
  `edit_status` text NOT NULL,
  `is_layout` enum('y','n') NOT NULL DEFAULT 'n',
  `layout_start_date` datetime NOT NULL,
  `layout_end_date` datetime NOT NULL,
  `layout_file` varchar(255) NOT NULL,
  `layout_upload_date` timestamp NULL DEFAULT NULL,
  `layout_last_upload` varchar(255) NOT NULL,
  `layout_notes` text NOT NULL,
  `layout_notes_author` text NOT NULL,
  `layout_deadline` datetime NOT NULL,
  `cover_file` varchar(255) NOT NULL,
  `cover_upload_date` timestamp NULL DEFAULT NULL,
  `cover_last_upload` varchar(255) NOT NULL,
  `cover_notes` text NOT NULL,
  `cover_notes_author` text NOT NULL,
  `layout_status` text NOT NULL,
  `is_proofread` enum('y','n') NOT NULL DEFAULT 'n',
  `proofread_start_date` datetime NOT NULL,
  `proofread_end_date` datetime NOT NULL,
  `proofread_file` varchar(255) NOT NULL,
  `proofread_upload_date` datetime DEFAULT NULL,
  `proofread_last_upload` varchar(255) NOT NULL,
  `proofread_notes` text NOT NULL,
  `proofread_notes_author` text NOT NULL,
  `proofread_status` text NOT NULL,
  `draft_status` int(11) NOT NULL,
  `draft_notes` text NOT NULL,
  `kriteria1_reviewer1` text NOT NULL,
  `kriteria2_reviewer1` text NOT NULL,
  `kriteria3_reviewer1` text NOT NULL,
  `kriteria4_reviewer1` text NOT NULL,
  `nilai_reviewer1` text NOT NULL,
  `kriteria1_reviewer2` text NOT NULL,
  `kriteria2_reviewer2` text NOT NULL,
  `kriteria3_reviewer2` text NOT NULL,
  `kriteria4_reviewer2` text NOT NULL,
  `nilai_reviewer2` text NOT NULL,
  `review2_last_upload` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `draft`
--

INSERT INTO `draft` (`draft_id`, `category_id`, `theme_id`, `draft_title`, `draft_file`, `entry_date`, `finish_date`, `print_date`, `is_review`, `review_start_date`, `review_end_date`, `review1_file`, `review1_upload_date`, `review1_last_upload`, `review1_notes`, `review1_notes_author`, `review1_deadline`, `review1_flag`, `review2_file`, `review2_upload_date`, `review2_notes`, `review2_notes_author`, `review2_deadline`, `review2_flag`, `review_status`, `is_edit`, `edit_start_date`, `edit_end_date`, `edit_file`, `edit_upload_date`, `edit_last_upload`, `edit_notes`, `edit_notes_author`, `edit_deadline`, `edit_status`, `is_layout`, `layout_start_date`, `layout_end_date`, `layout_file`, `layout_upload_date`, `layout_last_upload`, `layout_notes`, `layout_notes_author`, `layout_deadline`, `cover_file`, `cover_upload_date`, `cover_last_upload`, `cover_notes`, `cover_notes_author`, `layout_status`, `is_proofread`, `proofread_start_date`, `proofread_end_date`, `proofread_file`, `proofread_upload_date`, `proofread_last_upload`, `proofread_notes`, `proofread_notes_author`, `proofread_status`, `draft_status`, `draft_notes`, `kriteria1_reviewer1`, `kriteria2_reviewer1`, `kriteria3_reviewer1`, `kriteria4_reviewer1`, `nilai_reviewer1`, `kriteria1_reviewer2`, `kriteria2_reviewer2`, `kriteria3_reviewer2`, `kriteria4_reviewer2`, `nilai_reviewer2`, `review2_last_upload`) VALUES
(40, 13, 18, 'cara memelihara lele', 'cara_memelihara_lele_20181009110800.docx', '2018-10-09 04:08:00', '2018-10-09 06:09:09', NULL, 'y', '2018-10-11 23:45:00', '2018-10-09 11:25:08', 'cara_memelihara_lele_review1_file_20181012141302.docx', '2018-10-12 07:13:02', '', '<p>jelekkk hahah</p>', '<p><b style="background-color: rgb(255, 255, 0);">makasih ya pak, semangattas hehehee</b></p>', '2018-12-10 23:45:00', 'y', 'cara_memelihara_lele_review2_file_20181012141126.docx', '2018-10-12 07:11:26', '<p>baguss tapi jelek wowkowkowk</p>', '<p>hehe siapp MAKASIH!</p>', '2018-12-10 23:45:00', 'n', '<p>saya setujui draftnya. silakan koreksi sesuai masukan reviewer</p>', 'y', '2018-10-09 11:27:56', '2018-10-09 11:32:49', 'cara_memelihara_lele_edit_file_20181012205155.docx', '2018-10-12 13:51:55', 'editor', '<p>saya edit dulu yaa</p><p><br></p><p>-----</p><p><span style="font-size: 24px; color: rgb(255, 0, 0); font-weight: bold;">revisi mayor</span></p><ol><li>penulisan kata salah</li><li>kata asing cetak miring</li></ol>', '<p>oke siapp</p>', '0000-00-00 00:00:00', '<p>oke saya setujui</p>', 'y', '2018-10-09 11:34:32', '2018-10-12 21:07:38', '', NULL, '', '<p>mantap jiwaa</p>', '', '0000-00-00 00:00:00', '', NULL, '', '', '', '<p>layout kurang bagus, ulangi ya</p><p><br></p><p>---</p><p>oke saya setujui lagi</p>', 'y', '2018-10-12 21:07:38', '2018-10-09 11:40:06', '', NULL, '', '', '', '<p>oke stujui</p>', 12, '', '<p>qqqqqqq</p>', '<p>www</p>', '<p>eee</p>', '<p style="line-height: 1;">rrrr</p>', '1,1,1,1', '<p>fgdfg</p>', '<p>dgdfg</p>', '<p>dfgdf</p>', '<p>dfgdfg</p>', '5,5,5,5', ''),
(41, 13, 17, 'cara database', 'cara_database_20181009140208.docx', '2018-10-09 07:02:08', '2018-10-11 07:58:19', NULL, 'y', '2018-10-09 14:10:18', '2018-10-11 14:58:19', '', NULL, '', '<p>yesdfgg</p>', '', '2018-12-08 14:10:18', 'n', '', NULL, '<p>sudah bagus</p>', '', '2018-12-08 14:10:18', 'y', '<p>review selesai</p><p>disetujui</p>', 'y', '2018-10-09 14:20:38', '2018-10-09 14:21:46', '', NULL, '', '<p>editan in progressss</p>', '', '2018-10-25 00:00:00', '<p>editorial selesai fix</p>', 'y', '2018-10-09 14:36:27', '2018-10-09 14:22:22', '', NULL, '', '<p>okkeee</p><p>9 okt = revisiasd asd</p>', '', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 'y', '2018-10-09 14:22:22', '2018-10-10 13:48:10', '', NULL, '', '', '', '', 14, '', '<p>okee</p>', '<p>fdfg</p>', '<p>dfgdfg</p>', '<p>dfgdfg</p>', '3,3,3,3', '', '', '', '', '', ''),
(43, 13, 20, 'hukum perdata indonesia', 'hukum_perdata_indonesia_20181010134935.docx', '2018-10-10 06:49:35', NULL, NULL, 'y', '2018-10-10 13:50:07', '2018-10-12 21:25:21', 'hukum_perdata_indonesia_review1_file_20181012104424.docx', '2018-10-12 03:44:24', '', '<p>sudah bagus sih mas hehehe</p>', '<p>oke siap pakkk, makasihh</p>', '2018-12-09 13:50:07', 'y', 'hehehehe', '2018-10-12 06:09:53', '', '', '2018-12-09 13:50:07', NULL, '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'hukum_perdata_indonesia_edit_file_20181012124327.docx', '2018-10-12 05:43:27', '', '', '<p>heheh</p>', '0000-00-00 00:00:00', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '0000-00-00 00:00:00', 'hukum_perdata_indonesia_cover_file_20181012164833.docx', '2018-10-12 09:48:33', 'superadmin', '', '', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 5, '', '<p>satuuuu</p>', '<p>duaaa</p>', '<p>tigaa</p>', '<p>empatt</p>', '1,2,3,4', '<p>empattt</p>', '<p>tiggaaa</p>', '<p>duaaa</p>', '<p>dsatuu</p>', '4,3,2,1', ''),
(45, 15, 21, 'Spesies Ikan Tuna', 'Spesies_Ikan_Tuna_20181010142919.docx', '2018-10-10 07:29:19', NULL, NULL, 'y', '2018-10-11 23:58:36', '2018-10-12 00:28:19', '', NULL, '', '', '<p>eheheh sipp</p>', '2018-12-10 23:58:36', 'y', 'Spesies_Ikan_Tuna_review2_file_20181012140601.docx', '2018-10-12 07:06:01', '<p>lumayan sih keren</p>', '<p>keren</p>', '2018-12-10 23:58:36', 'y', '<p>keren</p>', 'y', '2018-10-10 14:31:00', '2018-10-12 21:24:31', '', NULL, '', '', '', '0000-00-00 00:00:00', '', 'n', '2018-10-10 14:31:13', '0000-00-00 00:00:00', '', NULL, '', '', '', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 7, '', 'c1', '<p>v2</p>', '<p>b3</p>', '<p>n4</p>', '2,3,4,5', '<p>sudah keren</p>', '<p>baguss</p>', '<p>termantap</p>', '<p>cihuy</p>', '5,3,4,5', ''),
(47, 15, 17, 'buat testing', 'buat_testing_20181012210834.docx', '2018-10-12 14:08:34', NULL, NULL, 'y', '2018-10-12 21:09:18', '2018-10-12 21:09:20', '', NULL, '', '', '', '2018-12-11 21:09:18', NULL, '', NULL, '', '', '2018-12-11 21:09:18', NULL, '', 'y', '2018-10-12 21:09:37', '2018-10-12 21:32:41', '', NULL, '', '', '', '0000-00-00 00:00:00', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 7, '', '', '', '', '', '', '', '', '', '', '', ''),
(48, 13, 18, 'coba sajaaa', 'coba_sajaaa_20181012212015.docx', '2018-10-12 14:20:15', NULL, NULL, 'y', '0000-00-00 00:00:00', '2018-10-12 21:20:23', '', NULL, '', '', '', '0000-00-00 00:00:00', NULL, '', NULL, '', '', '0000-00-00 00:00:00', NULL, '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '0000-00-00 00:00:00', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 5, '', '', '', '', '', '', '', '', '', '', '', ''),
(49, 15, 20, 'revieww selalu', 'revieww_selalu_20181012212700.docx', '2018-10-12 14:27:00', NULL, NULL, 'y', '2018-10-12 21:27:17', '2018-10-12 22:18:44', '', NULL, '', '', '', '2018-12-11 21:27:17', NULL, '', NULL, '', '', '2018-12-11 21:27:17', NULL, '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '0000-00-00 00:00:00', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 5, '', '', '', '', '', '', '', '', '', '', '', ''),
(50, 13, 18, 'powerbank', 'powerbank_20181012213549.docx', '2018-10-12 14:35:49', NULL, NULL, 'y', '0000-00-00 00:00:00', '2018-10-12 21:36:41', '', NULL, '', '', '', '0000-00-00 00:00:00', NULL, '', NULL, '', '', '0000-00-00 00:00:00', NULL, '', 'y', '0000-00-00 00:00:00', '2018-10-12 21:36:48', '', NULL, '', '', '', '0000-00-00 00:00:00', '', 'y', '0000-00-00 00:00:00', '2018-10-12 21:36:52', '', NULL, '', '', '', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 'n', '2018-10-12 21:36:52', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 12, '', '', '', '', '', '', '', '', '', '', '', ''),
(51, 13, 17, 'delcell', 'delcell_20181012213612.docx', '2018-10-12 14:36:12', NULL, NULL, 'y', '0000-00-00 00:00:00', '2018-10-12 21:36:21', '', NULL, '', '', '', '0000-00-00 00:00:00', NULL, '', NULL, '', '', '0000-00-00 00:00:00', NULL, '', 'y', '0000-00-00 00:00:00', '2018-10-12 21:36:27', '', NULL, '', '', '', '0000-00-00 00:00:00', '', 'y', '0000-00-00 00:00:00', '2018-10-12 21:36:31', '', NULL, '', '', '', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 'n', '2018-10-12 21:36:31', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 12, '', '', '', '', '', '', '', '', '', '', '', ''),
(52, 15, 17, 'desk scr', 'desk_scr_20181012214015.docx', '2018-10-12 14:40:15', NULL, NULL, 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '0000-00-00 00:00:00', NULL, '', NULL, '', '', '0000-00-00 00:00:00', NULL, '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '0000-00-00 00:00:00', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 'n', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `draft_author`
--

CREATE TABLE IF NOT EXISTS `draft_author` (
  `draft_author_id` mediumint(9) NOT NULL,
  `draft_id` mediumint(9) DEFAULT NULL,
  `author_id` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `draft_author`
--

INSERT INTO `draft_author` (`draft_author_id`, `draft_id`, `author_id`) VALUES
(83, 41, 16),
(85, 43, 18),
(87, 43, 20),
(88, 45, 19),
(90, 40, 18),
(91, 47, 18),
(92, 48, 20),
(93, 49, 18),
(94, 50, 18),
(95, 51, 19),
(96, 52, 18);

-- --------------------------------------------------------

--
-- Table structure for table `draft_reviewer`
--

CREATE TABLE IF NOT EXISTS `draft_reviewer` (
  `draft_reviewer_id` mediumint(9) NOT NULL,
  `draft_id` mediumint(9) DEFAULT NULL,
  `reviewer_id` mediumint(9) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1 = Accept, 2 = Reject'
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `draft_reviewer`
--

INSERT INTO `draft_reviewer` (`draft_reviewer_id`, `draft_id`, `reviewer_id`, `status`) VALUES
(21, 40, 30, 0),
(23, 41, 27, 0),
(24, 41, 26, 0),
(26, 43, 27, 0),
(27, 45, 28, 0),
(30, 40, 35, 0),
(31, 45, 34, 0),
(34, 47, 26, 0),
(35, 49, 27, 0);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `faculty_id` mediumint(9) NOT NULL,
  `faculty_name` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `faculty_name`) VALUES
(5, 'Teknik'),
(6, 'Kedokteran'),
(7, 'Hukum'),
(8, 'Kehutanan'),
(9, 'Ekonomi'),
(11, 'Ilmu Budaya');

-- --------------------------------------------------------

--
-- Table structure for table `institute`
--

CREATE TABLE IF NOT EXISTS `institute` (
  `institute_id` mediumint(9) NOT NULL,
  `institute_name` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`institute_id`, `institute_name`) VALUES
(4, 'UGM'),
(5, 'UI'),
(6, 'UNS'),
(7, 'Pemda Sleman');

-- --------------------------------------------------------

--
-- Table structure for table `responsibility`
--

CREATE TABLE IF NOT EXISTS `responsibility` (
  `responsibility_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) DEFAULT NULL,
  `draft_id` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `responsibility`
--

INSERT INTO `responsibility` (`responsibility_id`, `user_id`, `draft_id`) VALUES
(61, 18, NULL),
(62, NULL, NULL),
(63, 30, NULL),
(64, 18, NULL),
(65, 28, NULL),
(69, 31, NULL),
(70, 28, NULL),
(91, 30, NULL),
(93, 18, NULL),
(94, 18, NULL),
(107, 18, NULL),
(108, 28, NULL),
(109, 18, NULL),
(110, 28, NULL),
(111, 18, 40),
(112, 28, 40),
(113, 18, 41),
(114, 28, 41),
(115, 18, 45),
(116, 28, 45),
(119, 28, NULL),
(120, 31, NULL),
(121, 18, NULL),
(122, 18, 47);

-- --------------------------------------------------------

--
-- Table structure for table `reviewer`
--

CREATE TABLE IF NOT EXISTS `reviewer` (
  `reviewer_id` mediumint(9) NOT NULL,
  `reviewer_nip` varchar(256) NOT NULL,
  `reviewer_name` varchar(256) NOT NULL,
  `faculty_id` mediumint(9) DEFAULT NULL,
  `user_id` mediumint(9) DEFAULT NULL,
  `expert` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviewer`
--

INSERT INTO `reviewer` (`reviewer_id`, `reviewer_nip`, `reviewer_name`, `faculty_id`, `user_id`, `expert`) VALUES
(26, '43453656', 'jono subandi', 8, 22, 'Kesehatan'),
(27, '35667768689', 'bahri sulaiman', 9, 24, 'Kesehatan'),
(28, '546897654', 'agus sitohang', 7, 23, 'Kesehatan, Dokter'),
(30, '12345767', 'luthfii rev', 5, 29, 'Kesehatan, Dokter,teknik'),
(34, '23454678', 'syuhada sipayung', 5, 21, 'Kesehatan, Dokter,teknik'),
(35, '9988776655', 'bagaskara luthfi', 8, 19, 'teknik');

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `theme_id` mediumint(9) NOT NULL,
  `theme_name` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`theme_id`, `theme_name`) VALUES
(16, 'Kesehatan'),
(17, 'Teknologi Informasi'),
(18, 'Perikanan'),
(20, 'Hukum'),
(21, 'Kelautan'),
(22, 'Geologi');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` mediumint(9) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `level` enum('superadmin','admin_penerbitan','staff_penerbitan','editor','layouter','admin_pemasaran','admin_percetakan','admin_gudang','author','reviewer','author_reviewer') NOT NULL,
  `is_blocked` enum('y','n') NOT NULL DEFAULT 'n'
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `level`, `is_blocked`) VALUES
(1, 'superadmin', '17c4520f6cfd1ab53d8745e84681eb49', 'superadmin', 'n'),
(17, 'adminpenerbitan', '66de94d7cec1e3fa6a8b0ed7dd5e437d', 'admin_penerbitan', 'n'),
(18, 'editornana', '0827f0a0a8c299dcbbafb7eefe542642', 'editor', 'n'),
(19, 'bagas', 'ee776a18253721efe8a62e4abd29dc47', 'author_reviewer', 'n'),
(20, 'edward', 'a53f3929621dba1306f8a61588f52f55', 'author_reviewer', 'n'),
(21, 'syuhada', 'c664c3ce1e6d809f591d6c80cb9695eb', 'author_reviewer', 'n'),
(22, 'jono', '42867493d4d4874f331d288df0044baa', 'reviewer', 'n'),
(23, 'agus', 'fdf169558242ee051cca1479770ebac3', 'reviewer', 'n'),
(24, 'bahri', '846c25ead0e84f2d7ccf10922f682278', 'reviewer', 'n'),
(25, 'anggoro', '5e44d321ad90f6d2567971f9fb38f6ee', 'author', 'n'),
(28, 'layouteraziz', '27a5358401dea7677331deb28df22b76', 'layouter', 'n'),
(29, 'luthfi', 'd5cd72b7bcbf56bc503904f1ac7d9bc2', 'author_reviewer', 'n'),
(30, 'editorakbar', '213111240db8c5c09be2967c49f0008b', 'editor', 'n'),
(31, 'layouterandi', '4ddef3b83e93d2bd02f11d27e5561ba8', 'layouter', 'n');

-- --------------------------------------------------------

--
-- Table structure for table `worksheet`
--

CREATE TABLE IF NOT EXISTS `worksheet` (
  `worksheet_id` mediumint(9) NOT NULL,
  `draft_id` mediumint(9) DEFAULT NULL,
  `worksheet_num` varchar(256) NOT NULL,
  `is_reprint` enum('y','n') NOT NULL DEFAULT 'n',
  `worksheet_status` int(1) NOT NULL DEFAULT '0' COMMENT '1 = Approve, 2 = Reject',
  `worksheet_notes` text NOT NULL,
  `worksheet_pic` varchar(256) NOT NULL,
  `worksheet_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worksheet`
--

INSERT INTO `worksheet` (`worksheet_id`, `draft_id`, `worksheet_num`, `is_reprint`, `worksheet_status`, `worksheet_notes`, `worksheet_pic`, `worksheet_ts`) VALUES
(22, 40, '2018-10-01', 'n', 1, 'naskah sudah oke', 'editornana', '2018-10-09 04:17:02'),
(23, 41, '2018-10-02', 'n', 1, 'naskaha sudah bagus', 'editornana', '2018-10-09 07:03:03'),
(25, 43, '2018-10-04', 'n', 1, '', 'superadmin', '2018-10-10 06:49:57'),
(27, 45, '2018-10-06', 'n', 1, '', 'superadmin', '2018-10-10 07:30:04'),
(29, 47, '2018-10-07', 'n', 1, '', 'superadmin', '2018-10-12 14:09:00'),
(30, 48, '2018-10-08', 'n', 1, '', 'superadmin', '2018-10-12 14:20:20'),
(31, 49, '2018-10-09', 'n', 1, '', 'superadmin', '2018-10-12 14:27:07'),
(32, 50, '2018-10-10', 'n', 1, '', 'superadmin', '2018-10-12 14:35:54'),
(33, 51, '2018-10-11', 'n', 1, '', 'superadmin', '2018-10-12 14:36:17'),
(34, 52, '2018-10-12', 'n', 0, '', '', '2018-10-12 14:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `work_unit`
--

CREATE TABLE IF NOT EXISTS `work_unit` (
  `work_unit_id` mediumint(9) NOT NULL,
  `work_unit_name` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_unit`
--

INSERT INTO `work_unit` (`work_unit_id`, `work_unit_name`) VALUES
(6, 'Teknik Elektro dan Teknologi Informasi'),
(7, 'KPFT UGM'),
(8, 'Badan Penerbitan dan Publikasi'),
(9, 'UGM Press'),
(10, 'DSSDI');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`author_id`),
  ADD KEY `work_unit_id` (`work_unit_id`),
  ADD KEY `institute_id` (`institute_id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `id_proposal` (`draft_id`),
  ADD KEY `code_id` (`book_code`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `draft`
--
ALTER TABLE `draft`
  ADD PRIMARY KEY (`draft_id`),
  ADD KEY `id_kategori` (`category_id`),
  ADD KEY `id_penulis` (`theme_id`);

--
-- Indexes for table `draft_author`
--
ALTER TABLE `draft_author`
  ADD PRIMARY KEY (`draft_author_id`),
  ADD KEY `draft_id` (`draft_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `draft_reviewer`
--
ALTER TABLE `draft_reviewer`
  ADD PRIMARY KEY (`draft_reviewer_id`),
  ADD KEY `draft_id` (`draft_id`),
  ADD KEY `author_id` (`reviewer_id`),
  ADD KEY `reviewer_id` (`reviewer_id`),
  ADD KEY `draft_id_2` (`draft_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `institute`
--
ALTER TABLE `institute`
  ADD PRIMARY KEY (`institute_id`);

--
-- Indexes for table `responsibility`
--
ALTER TABLE `responsibility`
  ADD PRIMARY KEY (`responsibility_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `draft_id` (`draft_id`);

--
-- Indexes for table `reviewer`
--
ALTER TABLE `reviewer`
  ADD PRIMARY KEY (`reviewer_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`theme_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `worksheet`
--
ALTER TABLE `worksheet`
  ADD PRIMARY KEY (`worksheet_id`),
  ADD KEY `id_proposal` (`draft_id`);

--
-- Indexes for table `work_unit`
--
ALTER TABLE `work_unit`
  ADD PRIMARY KEY (`work_unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `author_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `draft`
--
ALTER TABLE `draft`
  MODIFY `draft_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `draft_author`
--
ALTER TABLE `draft_author`
  MODIFY `draft_author_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `draft_reviewer`
--
ALTER TABLE `draft_reviewer`
  MODIFY `draft_reviewer_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `institute`
--
ALTER TABLE `institute`
  MODIFY `institute_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `responsibility`
--
ALTER TABLE `responsibility`
  MODIFY `responsibility_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT for table `reviewer`
--
ALTER TABLE `reviewer`
  MODIFY `reviewer_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `theme_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `worksheet`
--
ALTER TABLE `worksheet`
  MODIFY `worksheet_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `work_unit`
--
ALTER TABLE `work_unit`
  MODIFY `work_unit_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `author`
--
ALTER TABLE `author`
  ADD CONSTRAINT `author_ibfk_1` FOREIGN KEY (`work_unit_id`) REFERENCES `work_unit` (`work_unit_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `author_ibfk_2` FOREIGN KEY (`institute_id`) REFERENCES `institute` (`institute_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `author_ibfk_3` FOREIGN KEY (`bank_id`) REFERENCES `bank` (`bank_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `author_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`draft_id`) REFERENCES `draft` (`draft_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `draft`
--
ALTER TABLE `draft`
  ADD CONSTRAINT `draft_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `draft_ibfk_2` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`theme_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `draft_author`
--
ALTER TABLE `draft_author`
  ADD CONSTRAINT `draft_author_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author` (`author_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `draft_author_ibfk_3` FOREIGN KEY (`draft_id`) REFERENCES `draft` (`draft_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `draft_reviewer`
--
ALTER TABLE `draft_reviewer`
  ADD CONSTRAINT `draft_reviewer_ibfk_1` FOREIGN KEY (`draft_id`) REFERENCES `draft` (`draft_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `draft_reviewer_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `reviewer` (`reviewer_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `responsibility`
--
ALTER TABLE `responsibility`
  ADD CONSTRAINT `responsibility_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `responsibility_ibfk_2` FOREIGN KEY (`draft_id`) REFERENCES `draft` (`draft_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `reviewer`
--
ALTER TABLE `reviewer`
  ADD CONSTRAINT `reviewer_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reviewer_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `worksheet`
--
ALTER TABLE `worksheet`
  ADD CONSTRAINT `worksheet_ibfk_1` FOREIGN KEY (`draft_id`) REFERENCES `draft` (`draft_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
