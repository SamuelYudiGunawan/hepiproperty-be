-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Nov 2023 pada 12.00
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rus_stats`
--

--
-- Dumping data untuk tabel `kotas`
--

INSERT INTO `kotas` (`id`, `nama`, `provinsi_id`, `created_at`, `updated_at`) VALUES
(1, 'KABUPATEN SIMEULUE', 2, NULL, NULL),
(2, 'KABUPATEN ACEH SINGKIL', 2, NULL, NULL),
(3, 'KABUPATEN ACEH SELATAN', 2, NULL, NULL),
(4, 'KABUPATEN ACEH TENGGARA', 2, NULL, NULL),
(5, 'KABUPATEN ACEH TIMUR', 2, NULL, NULL),
(6, 'KABUPATEN ACEH TENGAH', 2, NULL, NULL),
(7, 'KABUPATEN ACEH BARAT', 2, NULL, NULL),
(8, 'KABUPATEN ACEH BESAR', 2, NULL, NULL),
(9, 'KABUPATEN PIDIE', 2, NULL, NULL),
(10, 'KABUPATEN BIREUEN', 2, NULL, NULL),
(11, 'KABUPATEN ACEH UTARA', 2, NULL, NULL),
(12, 'KABUPATEN ACEH BARAT DAYA', 2, NULL, NULL),
(13, 'KABUPATEN GAYO LUES', 2, NULL, NULL),
(14, 'KABUPATEN ACEH TAMIANG', 2, NULL, NULL),
(15, 'KABUPATEN NAGAN RAYA', 2, NULL, NULL),
(16, 'KABUPATEN ACEH JAYA', 2, NULL, NULL),
(17, 'KABUPATEN BENER MERIAH', 2, NULL, NULL),
(18, 'KABUPATEN PIDIE JAYA', 2, NULL, NULL),
(19, 'KOTA BANDA ACEH', 2, NULL, NULL),
(20, 'KOTA SABANG', 2, NULL, NULL),
(21, 'KOTA LANGSA', 2, NULL, NULL),
(22, 'KOTA LHOKSEUMAWE', 2, NULL, NULL),
(23, 'KOTA SUBULUSSALAM', 2, NULL, NULL),
(24, 'KABUPATEN NIAS', 3, NULL, NULL),
(25, 'KABUPATEN MANDAILING NATAL', 3, NULL, NULL),
(26, 'KABUPATEN TAPANULI SELATAN', 3, NULL, NULL),
(27, 'KABUPATEN TAPANULI TENGAH', 3, NULL, NULL),
(28, 'KABUPATEN TAPANULI UTARA', 3, NULL, NULL),
(29, 'KABUPATEN TOBA SAMOSIR', 3, NULL, NULL),
(30, 'KABUPATEN LABUHANBATU', 3, NULL, NULL),
(31, 'KABUPATEN ASAHAN', 3, NULL, NULL),
(32, 'KABUPATEN SIMALUNGUN', 3, NULL, NULL),
(33, 'KABUPATEN DAIRI', 3, NULL, NULL),
(34, 'KABUPATEN KARO', 3, NULL, NULL),
(35, 'KABUPATEN DELI SERDANG', 3, NULL, NULL),
(36, 'KABUPATEN LANGKAT', 3, NULL, NULL),
(37, 'KABUPATEN NIAS SELATAN', 3, NULL, NULL),
(38, 'KABUPATEN HUMBANG HASUNDUTAN', 3, NULL, NULL),
(39, 'KABUPATEN PAKPAK BHARAT', 3, NULL, NULL),
(40, 'KABUPATEN SAMOSIR', 3, NULL, NULL),
(41, 'KABUPATEN SERDANG BEDAGAI', 3, NULL, NULL),
(42, 'KABUPATEN BATU BARA', 3, NULL, NULL),
(43, 'KABUPATEN PADANG LAWAS UTARA', 3, NULL, NULL),
(44, 'KABUPATEN PADANG LAWAS', 3, NULL, NULL),
(45, 'KABUPATEN LABUHAN BATU SELATAN', 3, NULL, NULL),
(46, 'KABUPATEN LABUHAN BATU UTARA', 3, NULL, NULL),
(47, 'KABUPATEN NIAS UTARA', 3, NULL, NULL),
(48, 'KABUPATEN NIAS BARAT', 3, NULL, NULL),
(49, 'KOTA SIBOLGA', 3, NULL, NULL),
(50, 'KOTA TANJUNG BALAI', 3, NULL, NULL),
(51, 'KOTA PEMATANGSIANTAR', 3, NULL, NULL),
(52, 'KOTA TEBINGTINGGI', 3, NULL, NULL),
(53, 'KOTA MEDAN', 3, NULL, NULL),
(54, 'KOTA BINJAI', 3, NULL, NULL),
(55, 'KOTA PADANGSIDIMPUAN', 3, NULL, NULL),
(56, 'KOTA GUNUNGSITOLI', 3, NULL, NULL),
(57, 'KABUPATEN KEPULAUAN MENTAWAI', 4, NULL, NULL),
(58, 'KABUPATEN PESISIR SELATAN', 4, NULL, NULL),
(59, 'KABUPATEN SOLOK', 4, NULL, NULL),
(60, 'KABUPATEN SIJUNJUNG', 4, NULL, NULL),
(61, 'KABUPATEN TANAH DATAR', 4, NULL, NULL),
(62, 'KABUPATEN PADANG PARIAMAN', 4, NULL, NULL),
(63, 'KABUPATEN AGAM', 4, NULL, NULL),
(64, 'KABUPATEN LIMAPULUH KOTA', 4, NULL, NULL),
(65, 'KABUPATEN PASAMAN', 4, NULL, NULL),
(66, 'KABUPATEN SOLOK SELATAN', 4, NULL, NULL),
(67, 'KABUPATEN DHARMASRAYA', 4, NULL, NULL),
(68, 'KABUPATEN PASAMAN BARAT', 4, NULL, NULL),
(69, 'KOTA PADANG', 4, NULL, NULL),
(70, 'KOTA SOLOK', 4, NULL, NULL),
(71, 'KOTA SAWAH LUNTO', 4, NULL, NULL),
(72, 'KOTA PADANG PANJANG', 4, NULL, NULL),
(73, 'KOTA BUKITTINGGI', 4, NULL, NULL),
(74, 'KOTA PAYAKUMBUH', 4, NULL, NULL),
(75, 'KOTA PARIAMAN', 4, NULL, NULL),
(76, 'KABUPATEN KUANTAN SINGINGI', 5, NULL, NULL),
(77, 'KABUPATEN INDRAGIRI HULU', 5, NULL, NULL),
(78, 'KABUPATEN INDRAGIRI HILIR', 5, NULL, NULL),
(79, 'KABUPATEN PELALAWAN', 5, NULL, NULL),
(80, 'KABUPATEN SIAK', 5, NULL, NULL),
(81, 'KABUPATEN KAMPAR', 5, NULL, NULL),
(82, 'KABUPATEN ROKAN HULU', 5, NULL, NULL),
(83, 'KABUPATEN BENGKALIS', 5, NULL, NULL),
(84, 'KABUPATEN ROKAN HILIR', 5, NULL, NULL),
(85, 'KABUPATEN KEPULAUAN MERANTI', 5, NULL, NULL),
(86, 'KOTA PEKANBARU', 5, NULL, NULL),
(87, 'KOTA DUMAI', 5, NULL, NULL),
(88, 'KABUPATEN KERINCI', 6, NULL, NULL),
(89, 'KABUPATEN MERANGIN', 6, NULL, NULL),
(90, 'KABUPATEN SAROLANGUN', 6, NULL, NULL),
(91, 'KABUPATEN BATANGHARI', 6, NULL, NULL),
(92, 'KABUPATEN MUARO JAMBI', 6, NULL, NULL),
(93, 'KABUPATEN TANJUNG JABUNG TIMUR', 6, NULL, NULL),
(94, 'KABUPATEN TANJUNG JABUNG BARAT', 6, NULL, NULL),
(95, 'KABUPATEN TEBO', 6, NULL, NULL),
(96, 'KABUPATEN BUNGO', 6, NULL, NULL),
(97, 'KOTA JAMBI', 6, NULL, NULL),
(98, 'KOTA SUNGAI PENUH', 6, NULL, NULL),
(99, 'KABUPATEN OGAN KOMERING ULU', 7, NULL, NULL),
(100, 'KABUPATEN OGAN KOMERING ILIR', 7, NULL, NULL),
(101, 'KABUPATEN MUARA ENIM', 7, NULL, NULL),
(102, 'KABUPATEN LAHAT', 7, NULL, NULL),
(103, 'KABUPATEN MUSI RAWAS', 7, NULL, NULL),
(104, 'KABUPATEN MUSI BANYUASIN', 7, NULL, NULL),
(105, 'KABUPATEN BANYUASIN', 7, NULL, NULL),
(106, 'KABUPATEN OGAN KOMERING ULU SELATAN', 7, NULL, NULL),
(107, 'KABUPATEN OKU TIMUR', 7, NULL, NULL),
(108, 'KABUPATEN OGAN ILIR', 7, NULL, NULL),
(109, 'KABUPATEN EMPAT LAWANG', 7, NULL, NULL),
(110, 'KABUPATEN PENUKAL ABAB LEMATANG ILIR', 7, NULL, NULL),
(111, 'KABUPATEN MUSI RAWAS UTARA', 7, NULL, NULL),
(112, 'KOTA PALEMBANG', 7, NULL, NULL),
(113, 'KOTA PRABUMULIH', 7, NULL, NULL),
(114, 'KOTA PAGAR ALAM', 7, NULL, NULL),
(115, 'KOTA LUBUKLINGGAU', 7, NULL, NULL),
(116, 'KABUPATEN BENGKULU SELATAN', 8, NULL, NULL),
(117, 'KABUPATEN REJANG LEBONG', 8, NULL, NULL),
(118, 'KABUPATEN BENGKULU UTARA', 8, NULL, NULL),
(119, 'KABUPATEN KAUR', 8, NULL, NULL),
(120, 'KABUPATEN SELUMA', 8, NULL, NULL),
(121, 'KABUPATEN MUKOMUKO', 8, NULL, NULL),
(122, 'KABUPATEN LEBONG', 8, NULL, NULL),
(123, 'KABUPATEN KEPAHIANG', 8, NULL, NULL),
(124, 'KABUPATEN BENGKULU TENGAH', 8, NULL, NULL),
(125, 'KOTA BENGKULU', 8, NULL, NULL),
(126, 'KABUPATEN LAMPUNG BARAT', 9, NULL, NULL),
(127, 'KABUPATEN TANGGAMUS', 9, NULL, NULL),
(128, 'KABUPATEN LAMPUNG SELATAN', 9, NULL, NULL),
(129, 'KABUPATEN LAMPUNG TIMUR', 9, NULL, NULL),
(130, 'KABUPATEN LAMPUNG TENGAH', 9, NULL, NULL),
(131, 'KABUPATEN LAMPUNG UTARA', 9, NULL, NULL),
(132, 'KABUPATEN WAY KANAN', 9, NULL, NULL),
(133, 'KABUPATEN TULANGBAWANG', 9, NULL, NULL),
(134, 'KABUPATEN PESAWARAN', 9, NULL, NULL),
(135, 'KABUPATEN PRINGSEWU', 9, NULL, NULL),
(136, 'KABUPATEN MESUJI', 9, NULL, NULL),
(137, 'KABUPATEN TULANG BAWANG BARAT', 9, NULL, NULL),
(138, 'KABUPATEN PESISIR BARAT', 9, NULL, NULL),
(139, 'KOTA BANDAR LAMPUNG', 9, NULL, NULL),
(140, 'KOTA METRO', 9, NULL, NULL),
(141, 'KABUPATEN BANGKA', 10, NULL, NULL),
(142, 'KABUPATEN BELITUNG', 10, NULL, NULL),
(143, 'KABUPATEN BANGKA BARAT', 10, NULL, NULL),
(144, 'KABUPATEN BANGKA TENGAH', 10, NULL, NULL),
(145, 'KABUPATEN BANGKA SELATAN', 10, NULL, NULL),
(146, 'KABUPATEN BELITUNG TIMUR', 10, NULL, NULL),
(147, 'KOTA PANGKAL PINANG', 10, NULL, NULL),
(148, 'KABUPATEN KARIMUN', 11, NULL, NULL),
(149, 'KABUPATEN BINTAN', 11, NULL, NULL),
(150, 'KABUPATEN NATUNA', 11, NULL, NULL),
(151, 'KABUPATEN LINGGA', 11, NULL, NULL),
(152, 'KABUPATEN KEPULAUAN ANAMBAS', 11, NULL, NULL),
(153, 'KOTA BATAM', 11, NULL, NULL),
(154, 'KOTA TANJUNGPINANG', 11, NULL, NULL),
(155, 'KABUPATEN KEPULAUAN SERIBU', 12, NULL, NULL),
(156, 'KOTA JAKARTA SELATAN', 12, NULL, NULL),
(157, 'KOTA JAKARTA TIMUR', 12, NULL, NULL),
(158, 'KOTA JAKARTA PUSAT', 12, NULL, NULL),
(159, 'KOTA JAKARTA BARAT', 12, NULL, NULL),
(160, 'KOTA JAKARTA UTARA', 12, NULL, NULL),
(161, 'KABUPATEN BOGOR', 13, NULL, NULL),
(162, 'KABUPATEN SUKABUMI', 13, NULL, NULL),
(163, 'KABUPATEN CIANJUR', 13, NULL, NULL),
(164, 'KABUPATEN BANDUNG', 13, NULL, NULL),
(165, 'KABUPATEN GARUT', 13, NULL, NULL),
(166, 'KABUPATEN TASIKMALAYA', 13, NULL, NULL),
(167, 'KABUPATEN CIAMIS', 13, NULL, NULL),
(168, 'KABUPATEN KUNINGAN', 13, NULL, NULL),
(169, 'KABUPATEN CIREBON', 13, NULL, NULL),
(170, 'KABUPATEN MAJALENGKA', 13, NULL, NULL),
(171, 'KABUPATEN SUMEDANG', 13, NULL, NULL),
(172, 'KABUPATEN INDRAMAYU', 13, NULL, NULL),
(173, 'KABUPATEN SUBANG', 13, NULL, NULL),
(174, 'KABUPATEN PURWAKARTA', 13, NULL, NULL),
(175, 'KABUPATEN KARAWANG', 13, NULL, NULL),
(176, 'KABUPATEN BEKASI', 13, NULL, NULL),
(177, 'KABUPATEN BANDUNG BARAT', 13, NULL, NULL),
(178, 'KABUPATEN PANGANDARAN', 13, NULL, NULL),
(179, 'KOTA BOGOR', 13, NULL, NULL),
(180, 'KOTA SUKABUMI', 13, NULL, NULL),
(181, 'KOTA BANDUNG', 13, NULL, NULL),
(182, 'KOTA CIREBON', 13, NULL, NULL),
(183, 'KOTA BEKASI', 13, NULL, NULL),
(184, 'KOTA DEPOK', 13, NULL, NULL),
(185, 'KOTA CIMAHI', 13, NULL, NULL),
(186, 'KOTA TASIKMALAYA', 13, NULL, NULL),
(187, 'KOTA BANJAR', 13, NULL, NULL),
(188, 'KABUPATEN CILACAP', 14, NULL, NULL),
(189, 'KABUPATEN BANYUMAS', 14, NULL, NULL),
(190, 'KABUPATEN PURBALINGGA', 14, NULL, NULL),
(191, 'KABUPATEN BANJARNEGARA', 14, NULL, NULL),
(192, 'KABUPATEN KEBUMEN', 14, NULL, NULL),
(193, 'KABUPATEN PURWOREJO', 14, NULL, NULL),
(194, 'KABUPATEN WONOSOBO', 14, NULL, NULL),
(195, 'KABUPATEN MAGELANG', 14, NULL, NULL),
(196, 'KABUPATEN BOYOLALI', 14, NULL, NULL),
(197, 'KABUPATEN KLATEN', 14, NULL, NULL),
(198, 'KABUPATEN SUKOHARJO', 14, NULL, NULL),
(199, 'KABUPATEN WONOGIRI', 14, NULL, NULL),
(200, 'KABUPATEN KARANGANYAR', 14, NULL, NULL),
(201, 'KABUPATEN SRAGEN', 14, NULL, NULL),
(202, 'KABUPATEN GROBOGAN', 14, NULL, NULL),
(203, 'KABUPATEN BLORA', 14, NULL, NULL),
(204, 'KABUPATEN REMBANG', 14, NULL, NULL),
(205, 'KABUPATEN PATI', 14, NULL, NULL),
(206, 'KABUPATEN KUDUS', 14, NULL, NULL),
(207, 'KABUPATEN JEPARA', 14, NULL, NULL),
(208, 'KABUPATEN DEMAK', 14, NULL, NULL),
(209, 'KABUPATEN SEMARANG', 14, NULL, NULL),
(210, 'KABUPATEN TEMANGGUNG', 14, NULL, NULL),
(211, 'KABUPATEN KENDAL', 14, NULL, NULL),
(212, 'KABUPATEN BATANG', 14, NULL, NULL),
(213, 'KABUPATEN PEKALONGAN', 14, NULL, NULL),
(214, 'KABUPATEN PEMALANG', 14, NULL, NULL),
(215, 'KABUPATEN TEGAL', 14, NULL, NULL),
(216, 'KABUPATEN BREBES', 14, NULL, NULL),
(217, 'KOTA MAGELANG', 14, NULL, NULL),
(218, 'KOTA SURAKARTA', 14, NULL, NULL),
(219, 'KOTA SALATIGA', 14, NULL, NULL),
(220, 'KOTA SEMARANG', 14, NULL, NULL),
(221, 'KOTA PEKALONGAN', 14, NULL, NULL),
(222, 'KOTA TEGAL', 14, NULL, NULL),
(223, 'KABUPATEN KULON PROGO', 15, NULL, NULL),
(224, 'KABUPATEN BANTUL', 15, NULL, NULL),
(225, 'KABUPATEN GUNUNG KIDUL', 15, NULL, NULL),
(226, 'KABUPATEN SLEMAN', 15, NULL, NULL),
(227, 'KOTA YOGYAKARTA', 15, NULL, NULL),
(228, 'KABUPATEN PACITAN', 16, NULL, NULL),
(229, 'KABUPATEN PONOROGO', 16, NULL, NULL),
(230, 'KABUPATEN TRENGGALEK', 16, NULL, NULL),
(231, 'KABUPATEN TULUNGAGUNG', 16, NULL, NULL),
(232, 'KABUPATEN BLITAR', 16, NULL, NULL),
(233, 'KABUPATEN KEDIRI', 16, NULL, NULL),
(234, 'KABUPATEN MALANG', 16, NULL, NULL),
(235, 'KABUPATEN LUMAJANG', 16, NULL, NULL),
(236, 'KABUPATEN JEMBER', 16, NULL, NULL),
(237, 'KABUPATEN BANYUWANGI', 16, NULL, NULL),
(238, 'KABUPATEN BONDOWOSO', 16, NULL, NULL),
(239, 'KABUPATEN SITUBONDO', 16, NULL, NULL),
(240, 'KABUPATEN PROBOLINGGO', 16, NULL, NULL),
(241, 'KABUPATEN PASURUAN', 16, NULL, NULL),
(242, 'KABUPATEN SIDOARJO', 16, NULL, NULL),
(243, 'KABUPATEN MOJOKERTO', 16, NULL, NULL),
(244, 'KABUPATEN JOMBANG', 16, NULL, NULL),
(245, 'KABUPATEN NGANJUK', 16, NULL, NULL),
(246, 'KABUPATEN MADIUN', 16, NULL, NULL),
(247, 'KABUPATEN MAGETAN', 16, NULL, NULL),
(248, 'KABUPATEN NGAWI', 16, NULL, NULL),
(249, 'KABUPATEN BOJONEGORO', 16, NULL, NULL),
(250, 'KABUPATEN TUBAN', 16, NULL, NULL),
(251, 'KABUPATEN LAMONGAN', 16, NULL, NULL),
(252, 'KABUPATEN GRESIK', 16, NULL, NULL),
(253, 'KABUPATEN BANGKALAN', 16, NULL, NULL),
(254, 'KABUPATEN SAMPANG', 16, NULL, NULL),
(255, 'KABUPATEN PAMEKASAN', 16, NULL, NULL),
(256, 'KABUPATEN SUMENEP', 16, NULL, NULL),
(257, 'KOTA KEDIRI', 16, NULL, NULL),
(258, 'KOTA BLITAR', 16, NULL, NULL),
(259, 'KOTA MALANG', 16, NULL, NULL),
(260, 'KOTA PROBOLINGGO', 16, NULL, NULL),
(261, 'KOTA PASURUAN', 16, NULL, NULL),
(262, 'KOTA MOJOKERTO', 16, NULL, NULL),
(263, 'KOTA MADIUN', 16, NULL, NULL),
(264, 'KOTA SURABAYA', 16, NULL, NULL),
(265, 'KOTA BATU', 16, NULL, NULL),
(266, 'KABUPATEN PANDEGLANG', 17, NULL, NULL),
(267, 'KABUPATEN LEBAK', 17, NULL, NULL),
(268, 'KABUPATEN TANGERANG', 17, NULL, NULL),
(269, 'KABUPATEN SERANG', 17, NULL, NULL),
(270, 'KOTA TANGERANG', 17, NULL, NULL),
(271, 'KOTA CILEGON', 17, NULL, NULL),
(272, 'KOTA SERANG', 17, NULL, NULL),
(273, 'KOTA TANGERANG SELATAN', 17, NULL, NULL),
(274, 'KABUPATEN JEMBRANA', 18, NULL, NULL),
(275, 'KABUPATEN TABANAN', 18, NULL, NULL),
(276, 'KABUPATEN BADUNG', 18, NULL, NULL),
(277, 'KABUPATEN GIANYAR', 18, NULL, NULL),
(278, 'KABUPATEN KLUNGKUNG', 18, NULL, NULL),
(279, 'KABUPATEN BANGLI', 18, NULL, NULL),
(280, 'KABUPATEN KARANGASEM', 18, NULL, NULL),
(281, 'KABUPATEN BULELENG', 18, NULL, NULL),
(282, 'KOTA DENPASAR', 18, NULL, NULL),
(283, 'KABUPATEN LOMBOK BARAT', 19, NULL, NULL),
(284, 'KABUPATEN LOMBOK TENGAH', 19, NULL, NULL),
(285, 'KABUPATEN LOMBOK TIMUR', 19, NULL, NULL),
(286, 'KABUPATEN SUMBAWA', 19, NULL, NULL),
(287, 'KABUPATEN DOMPU', 19, NULL, NULL),
(288, 'KABUPATEN BIMA', 19, NULL, NULL),
(289, 'KABUPATEN SUMBAWA BARAT', 19, NULL, NULL),
(290, 'KABUPATEN LOMBOK UTARA', 19, NULL, NULL),
(291, 'KOTA MATARAM', 19, NULL, NULL),
(292, 'KOTA BIMA', 19, NULL, NULL),
(293, 'KABUPATEN SUMBA BARAT', 20, NULL, NULL),
(294, 'KABUPATEN SUMBA TIMUR', 20, NULL, NULL),
(295, 'KABUPATEN KUPANG', 20, NULL, NULL),
(296, 'KABUPATEN TIMOR TENGAH SELATAN', 20, NULL, NULL),
(297, 'KABUPATEN TIMUR TENGAH UTARA', 20, NULL, NULL),
(298, 'KABUPATEN BELU', 20, NULL, NULL),
(299, 'KABUPATEN ALOR', 20, NULL, NULL),
(300, 'KABUPATEN LEMBATA', 20, NULL, NULL),
(301, 'KABUPATEN FLORES TIMUR', 20, NULL, NULL),
(302, 'KABUPATEN SIKKA', 20, NULL, NULL),
(303, 'KABUPATEN ENDE', 20, NULL, NULL),
(304, 'KABUPATEN NGADA', 20, NULL, NULL),
(305, 'KABUPATEN MANGGARAI', 20, NULL, NULL),
(306, 'KABUPATEN ROTE NDAO', 20, NULL, NULL),
(307, 'KABUPATEN MANGGARAI BARAT', 20, NULL, NULL),
(308, 'KABUPATEN SUMBA TENGAH', 20, NULL, NULL),
(309, 'KABUPATEN SUMBA BARAT DAYA', 20, NULL, NULL),
(310, 'KABUPATEN NAGEKEO', 20, NULL, NULL),
(311, 'KABUPATEN MANGGARAI TIMUR', 20, NULL, NULL),
(312, 'KABUPATEN SABU RAIJUA', 20, NULL, NULL),
(313, 'KABUPATEN MALAKA', 20, NULL, NULL),
(314, 'KOTA KUPANG', 20, NULL, NULL),
(315, 'KABUPATEN SAMBAS', 21, NULL, NULL),
(316, 'KABUPATEN BENGKAYANG', 21, NULL, NULL),
(317, 'KABUPATEN LANDAK', 21, NULL, NULL),
(318, 'KABUPATEN MEMPAWAH', 21, NULL, NULL),
(319, 'KABUPATEN SANGGAU', 21, NULL, NULL),
(320, 'KABUPATEN KETAPANG', 21, NULL, NULL),
(321, 'KABUPATEN SINTANG', 21, NULL, NULL),
(322, 'KABUPATEN KAPUAS HULU', 21, NULL, NULL),
(323, 'KABUPATEN SEKADAU', 21, NULL, NULL),
(324, 'KABUPATEN MELAWI', 21, NULL, NULL),
(325, 'KABUPATEN KAYONG UTARA', 21, NULL, NULL),
(326, 'KABUPATEN KUBU RAYA', 21, NULL, NULL),
(327, 'KOTA PONTIANAK', 21, NULL, NULL),
(328, 'KOTA SINGKAWANG', 21, NULL, NULL),
(329, 'KABUPATEN KOTAWARINGIN BARAT', 22, NULL, NULL),
(330, 'KABUPATEN KOTAWARINGIN TIMUR', 22, NULL, NULL),
(331, 'KABUPATEN KAPUAS', 22, NULL, NULL),
(332, 'KABUPATEN BARITO SELATAN', 22, NULL, NULL),
(333, 'KABUPATEN BARITO UTARA', 22, NULL, NULL),
(334, 'KABUPATEN SUKAMARA', 22, NULL, NULL),
(335, 'KABUPATEN LAMANDAU', 22, NULL, NULL),
(336, 'KABUPATEN SERUYAN', 22, NULL, NULL),
(337, 'KABUPATEN KATINGAN', 22, NULL, NULL),
(338, 'KABUPATEN PULANG PISAU', 22, NULL, NULL),
(339, 'KABUPATEN GUNUNG MAS', 22, NULL, NULL),
(340, 'KABUPATEN BARITO TIMUR', 22, NULL, NULL),
(341, 'KABUPATEN MURUNG RAYA', 22, NULL, NULL),
(342, 'KOTA PALANGKARAYA', 22, NULL, NULL),
(343, 'KABUPATEN TANAH LAUT', 23, NULL, NULL),
(344, 'KABUPATEN KOTABARU', 23, NULL, NULL),
(345, 'KABUPATEN BANJAR', 23, NULL, NULL),
(346, 'KABUPATEN BARITO KUALA', 23, NULL, NULL),
(347, 'KABUPATEN TAPIN', 23, NULL, NULL),
(348, 'KABUPATEN HULU SUNGAI SELATAN', 23, NULL, NULL),
(349, 'KABUPATEN HULU SUNGAI TENGAH', 23, NULL, NULL),
(350, 'KABUPATEN HULU SUNGAI UTARA', 23, NULL, NULL),
(351, 'KABUPATEN TABALONG', 23, NULL, NULL),
(352, 'KABUPATEN TANAH BUMBU', 23, NULL, NULL),
(353, 'KABUPATEN BALANGAN', 23, NULL, NULL),
(354, 'KOTA BANJARMASIN', 23, NULL, NULL),
(355, 'KOTA BANJARBARU', 23, NULL, NULL),
(356, 'KABUPATEN PASER', 24, NULL, NULL),
(357, 'KABUPATEN KUTAI BARAT', 24, NULL, NULL),
(358, 'KABUPATEN KUTAI KARTANEGARA', 24, NULL, NULL),
(359, 'KABUPATEN KUTAI TIMUR', 24, NULL, NULL),
(360, 'KABUPATEN BERAU', 24, NULL, NULL),
(361, 'KABUPATEN PENAJAM PASER UTARA', 24, NULL, NULL),
(362, 'KABUPATEN MAHAKAM HULU', 24, NULL, NULL),
(363, 'KOTA BALIKPAPAN', 24, NULL, NULL),
(364, 'KOTA SAMARINDA', 24, NULL, NULL),
(365, 'KOTA BONTANG', 24, NULL, NULL),
(366, 'KABUPATEN MALINAU', 25, NULL, NULL),
(367, 'KABUPATEN BULUNGAN', 25, NULL, NULL),
(368, 'KABUPATEN TANA TIDUNG', 25, NULL, NULL),
(369, 'KABUPATEN NUNUKAN', 25, NULL, NULL),
(370, 'KOTA TARAKAN', 25, NULL, NULL),
(371, 'KABUPATEN BOLAANG MONGONDOW', 26, NULL, NULL),
(372, 'KABUPATEN MINAHASA', 26, NULL, NULL),
(373, 'KABUPATEN KEPULAUAN SANGIHE', 26, NULL, NULL),
(374, 'KABUPATEN KEPULAUAN TALAUD', 26, NULL, NULL),
(375, 'KABUPATEN MINAHASA SELATAN', 26, NULL, NULL),
(376, 'KABUPATEN MINAHASA UTARA', 26, NULL, NULL),
(377, 'KABUPATEN BOLAANG MONGONDOW UTARA', 26, NULL, NULL),
(378, 'KABUPATEN SIAU TAGULANDANG BIARO', 26, NULL, NULL),
(379, 'KABUPATEN MINAHASA TENGGARA', 26, NULL, NULL),
(380, 'KABUPATEN BOLAANG MONGONDOW SELATAN', 26, NULL, NULL),
(381, 'KABUPATEN BOLAANG MONGONDOW TIMUR', 26, NULL, NULL),
(382, 'KOTA MANADO', 26, NULL, NULL),
(383, 'KOTA BITUNG', 26, NULL, NULL),
(384, 'KOTA TOMOHON', 26, NULL, NULL),
(385, 'KOTA KOTAMOBAGU', 26, NULL, NULL),
(386, 'KABUPATEN BANGGAI KEPULAUAN', 27, NULL, NULL),
(387, 'KABUPATEN BANGGAI', 27, NULL, NULL),
(388, 'KABUPATEN MOROWALI', 27, NULL, NULL),
(389, 'KOTA POSO', 27, NULL, NULL),
(390, 'KABUPATEN DONGGALA', 27, NULL, NULL),
(391, 'KABUPATEN TOLI-TOLI', 27, NULL, NULL),
(392, 'KABUPATEN BUOL', 27, NULL, NULL),
(393, 'KABUPATEN PARIGI MOUTONG', 27, NULL, NULL),
(394, 'KABUPATEN TOJO UNA-UNA', 27, NULL, NULL),
(395, 'KABUPATEN SIGI', 27, NULL, NULL),
(396, 'KABUPATEN BANGGAI LAUT', 27, NULL, NULL),
(397, 'KABUPATEN MOROWALI UTARA', 27, NULL, NULL),
(398, 'KOTA PALU', 27, NULL, NULL),
(399, 'KABUPATEN KEPULAUAN SELAYAR', 28, NULL, NULL),
(400, 'KABUPATEN BULUKUMBA', 28, NULL, NULL),
(401, 'KABUPATEN BANTAENG', 28, NULL, NULL),
(402, 'KABUPATEN JENEPONTO', 28, NULL, NULL),
(403, 'KABUPATEN TAKALAR', 28, NULL, NULL),
(404, 'KABUPATEN GOWA', 28, NULL, NULL),
(405, 'KABUPATEN SINJAI', 28, NULL, NULL),
(406, 'KABUPATEN MAROS', 28, NULL, NULL),
(407, 'KABUPATEN PANGKAJENE DAN KEPULAUAN', 28, NULL, NULL),
(408, 'KABUPATEN BARRU', 28, NULL, NULL),
(409, 'KABUPATEN BONE', 28, NULL, NULL),
(410, 'KABUPATEN SOPPENG', 28, NULL, NULL),
(411, 'KABUPATEN WAJO', 28, NULL, NULL),
(412, 'KABUPATEN SIDENRENG RAPPANG', 28, NULL, NULL),
(413, 'KABUPATEN PINRANG', 28, NULL, NULL),
(414, 'KABUPATEN ENREKANG', 28, NULL, NULL),
(415, 'KABUPATEN LUWU', 28, NULL, NULL),
(416, 'KABUPATEN TANA TORAJA', 28, NULL, NULL),
(417, 'KABUPATEN LUWU UTARA', 28, NULL, NULL),
(418, 'KABUPATEN LUWU TIMUR', 28, NULL, NULL),
(419, 'KABUPATEN TORAJA UTARA', 28, NULL, NULL),
(420, 'KOTA MAKASSAR', 28, NULL, NULL),
(421, 'KOTA PAREPARE', 28, NULL, NULL),
(422, 'KOTA PALOPO', 28, NULL, NULL),
(423, 'KABUPATEN BUTON', 29, NULL, NULL),
(424, 'KABUPATEN MUNA', 29, NULL, NULL),
(425, 'KABUPATEN KONAWE', 29, NULL, NULL),
(426, 'KABUPATEN KOLAKA', 29, NULL, NULL),
(427, 'KABUPATEN KONAWE SELATAN', 29, NULL, NULL),
(428, 'KABUPATEN BOMBANA', 29, NULL, NULL),
(429, 'KABUPATEN WAKATOBI', 29, NULL, NULL),
(430, 'KABUPATEN KOLAKA UTARA', 29, NULL, NULL),
(431, 'KABUPATEN BUTON UTARA', 29, NULL, NULL),
(432, 'KABUPATEN KONAWE UTARA', 29, NULL, NULL),
(433, 'KABUPATEN KOLAKA TIMUR', 29, NULL, NULL),
(434, 'KABUPATEN KONAWE KEPULAUAN', 29, NULL, NULL),
(435, 'KABUPATEN MUNA BARAT', 29, NULL, NULL),
(436, 'KABUPATEN BUTON TENGAH', 29, NULL, NULL),
(437, 'KABUPATEN BUTON SELATAN', 29, NULL, NULL),
(438, 'KOTA KENDARI', 29, NULL, NULL),
(439, 'KOTA BAUBAU', 29, NULL, NULL),
(440, 'KABUPATEN BOALEMO', 30, NULL, NULL),
(441, 'KABUPATEN GORONTALO', 30, NULL, NULL),
(442, 'KABUPATEN POHUWATO', 30, NULL, NULL),
(443, 'KABUPATEN BONE BOLANGO', 30, NULL, NULL),
(444, 'KABUPATEN GORONTALO UTARA', 30, NULL, NULL),
(445, 'KOTA GORONTALO', 30, NULL, NULL),
(446, 'KABUPATEN MAJENE', 31, NULL, NULL),
(447, 'KABUPATEN POLEWALI MANDAR', 31, NULL, NULL),
(448, 'KABUPATEN MAMASA', 31, NULL, NULL),
(449, 'KABUPATEN MAMUJU', 31, NULL, NULL),
(450, 'KABUPATEN MAMUJU UTARA', 31, NULL, NULL),
(451, 'KABUPATEN MAMUJU TENGAH', 31, NULL, NULL),
(452, 'KABUPATEN MALUKU TENGGARA BARAT', 32, NULL, NULL),
(453, 'KABUPATEN MALUKU TENGGARA', 32, NULL, NULL),
(454, 'KABUPATEN MALUKU TENGAH', 32, NULL, NULL),
(455, 'KABUPATEN BURU', 32, NULL, NULL),
(456, 'KABUPATEN KEPULAUAN ARU', 32, NULL, NULL),
(457, 'KABUPATEN SERAM BAGIAN BARAT', 32, NULL, NULL),
(458, 'KABUPATEN SERAM BAGIAN TIMUR', 32, NULL, NULL),
(459, 'KABUPATEN MALUKU BARAT DAYA', 32, NULL, NULL),
(460, 'KABUPATEN BURU SELATAN', 32, NULL, NULL),
(461, 'KOTA AMBON', 32, NULL, NULL),
(462, 'KOTA TUAL', 32, NULL, NULL),
(463, 'KABUPATEN HALMAHERA BARAT', 33, NULL, NULL),
(464, 'KABUPATEN HALMAHERA TENGAH', 33, NULL, NULL),
(465, 'KABUPATEN KEPULAUAN SULA', 33, NULL, NULL),
(466, 'KABUPATEN HALMAHERA SELATAN', 33, NULL, NULL),
(467, 'KABUPATEN HALMAHERA UTARA', 33, NULL, NULL),
(468, 'KABUPATEN HALMAHERA TIMUR', 33, NULL, NULL),
(469, 'KABUPATEN PULAU MOROTAI', 33, NULL, NULL),
(470, 'KABUPATEN PULAU TALIABU', 33, NULL, NULL),
(471, 'KOTA TERNATE', 33, NULL, NULL),
(472, 'KOTA TIDORE KEPULAUAN', 33, NULL, NULL),
(473, 'KABUPATEN FAKFAK', 34, NULL, NULL),
(474, 'KABUPATEN KAIMANA', 34, NULL, NULL),
(475, 'KABUPATEN TELUK WONDAMA', 34, NULL, NULL),
(476, 'KABUPATEN TELUK BINTUNI', 34, NULL, NULL),
(477, 'KABUPATEN MANOKWARI', 34, NULL, NULL),
(478, 'KABUPATEN SORONG SELATAN', 34, NULL, NULL),
(479, 'KABUPATEN SORONG', 34, NULL, NULL),
(480, 'KABUPATEN RAJA AMPAT', 34, NULL, NULL),
(481, 'KABUPATEN TAMBRAUW', 34, NULL, NULL),
(482, 'KABUPATEN MAYBRAT', 34, NULL, NULL),
(483, 'KABUPATEN MANOKWARI SELATAN', 34, NULL, NULL),
(484, 'KABUPATEN PEGUNUNGAN ARFAK', 34, NULL, NULL),
(485, 'KOTA SORONG', 34, NULL, NULL),
(486, 'KABUPATEN MERAUKE', 35, NULL, NULL),
(487, 'KABUPATEN JAYAWIJAYA', 35, NULL, NULL),
(488, 'KABUPATEN JAYAPURA', 35, NULL, NULL),
(489, 'KABUPATEN NABIRE', 35, NULL, NULL),
(490, 'KABUPATEN KEPULAUAN YAPEN', 35, NULL, NULL),
(491, 'KABUPATEN BIAK NUMFOR', 35, NULL, NULL),
(492, 'KABUPATEN PANIAI', 35, NULL, NULL),
(493, 'KABUPATEN PUNCAK JAYA', 35, NULL, NULL),
(494, 'KABUPATEN MIMIKA', 35, NULL, NULL),
(495, 'KABUPATEN BOVEN DIGOEL', 35, NULL, NULL),
(496, 'KABUPATEN MAPPI', 35, NULL, NULL),
(497, 'KABUPATEN ASMAT', 35, NULL, NULL),
(498, 'KABUPATEN YAHUKIMO', 35, NULL, NULL),
(499, 'KABUPATEN PEGUNUNGAN BINTANG', 35, NULL, NULL),
(500, 'KABUPATEN TOLIKARA', 35, NULL, NULL),
(501, 'KABUPATEN SARMI', 35, NULL, NULL),
(502, 'KABUPATEN KEEROM', 35, NULL, NULL),
(503, 'KABUPATEN WAROPEN', 35, NULL, NULL),
(504, 'KABUPATEN SUPIORI', 35, NULL, NULL),
(505, 'KABUPATEN MAMBERAMO RAYA', 35, NULL, NULL),
(506, 'KABUPATEN NDUGA', 35, NULL, NULL),
(507, 'KABUPATEN LANNY JAYA', 35, NULL, NULL),
(508, 'KABUPATEN MAMBERAMO TENGAH', 35, NULL, NULL),
(509, 'KABUPATEN YALIMO', 35, NULL, NULL),
(510, 'KABUPATEN PUNCAK', 35, NULL, NULL),
(511, 'KABUPATEN DOGIYAI', 35, NULL, NULL),
(512, 'KABUPATEN INTAN JAYA', 35, NULL, NULL),
(513, 'KABUPATEN DEIYAI', 35, NULL, NULL),
(514, 'KOTA JAYAPURA', 35, NULL, NULL),
(515, 'Lainnya', 1, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
