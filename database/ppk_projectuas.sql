-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Des 2018 pada 01.39
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppk_projectuas`
--
CREATE DATABASE IF NOT EXISTS `ppk_projectuas` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ppk_projectuas`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `event`
--

CREATE TABLE `event` (
  `id` char(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tanggalMulai` date DEFAULT NULL,
  `jamMulai` time DEFAULT NULL,
  `tanggalSelesai` date DEFAULT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `cp` varchar(10) DEFAULT NULL,
  `gambar` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `event`
--

INSERT INTO `event` (`id`, `nama`, `tanggalMulai`, `jamMulai`, `tanggalSelesai`, `lokasi`, `deskripsi`, `cp`, `gambar`) VALUES
('E001', 'PROLIGA', '2018-12-11', '12:31:00', '2018-12-28', 'BRI JATENG', 'VOLY UNTUK HIDUP', '16.8987', '/ppk/assets/img/850982666_555725097.png'),
('E002', 'LIGA FUTSAL STATISTIK', '2018-12-12', '08:32:00', '2018-12-20', 'LAPANGAN FUTSAL', 'kuy buruan daftar', '16.8987', '/ppk/assets/img/669525146_433105468.png'),
('E003', 'Lomba PES Angkatan single', '2018-12-13', '11:56:00', '2018-12-22', 'Kantin Politeknik Statistika STIS', 'Daftarkan diri anda dan dapatkan hadiahnya', '16.8987', '/ppk/assets/img/772674560_363891601.png'),
('E004', 'Lomba dota di STIS', '2018-12-07', '11:19:00', '2018-12-10', 'Online', 'daftarkan diri anda segera untuk mendapatkan 50 juta rupiah', '16.8987', '/ppk/assets/img/626739501_425720214.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawabantambahan`
--

CREATE TABLE `jawabantambahan` (
  `idJawaban` int(11) NOT NULL,
  `idPertanyaan` char(4) NOT NULL,
  `nim` varchar(10) NOT NULL,
  `jawaban` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jawabantambahan`
--

INSERT INTO `jawabantambahan` (`idJawaban`, `idPertanyaan`, `nim`, `jawaban`) VALUES
(12, '16', '16.9999', 'Anti anti social club'),
(13, '16', '16.8888', 'komnet'),
(14, '16', '16.9025', 'rohis'),
(15, '16', '16.7777', 'MNC TV'),
(16, '17', '16.8987', 'sangat sering'),
(17, '20', '16.8987', 'sangat kuat'),
(18, '18', '16.8987', 'kadang solid'),
(19, '19', '16.8987', 'ingin juara');

-- --------------------------------------------------------

--
-- Struktur dari tabel `myevent`
--

CREATE TABLE `myevent` (
  `nim` varchar(10) NOT NULL,
  `idEvent` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `myevent`
--

INSERT INTO `myevent` (`nim`, `idEvent`) VALUES
('16.7777', 'E001'),
('16.7777', 'E002'),
('16.8888', 'E001'),
('16.8888', 'E002'),
('16.8987', 'E004'),
('16.9025', 'E001'),
('16.9025', 'E002'),
('16.9999', 'E001'),
('16.9999', 'E002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nohp`
--

CREATE TABLE `nohp` (
  `nim` varchar(10) NOT NULL,
  `noHP1` varchar(13) NOT NULL,
  `noHP2` varchar(13) DEFAULT NULL,
  `noHP3` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nohp`
--

INSERT INTO `nohp` (`nim`, `noHP1`, `noHP2`, `noHP3`) VALUES
('16.7777', '081233461678', '082346591725', ''),
('16.8888', '08', NULL, NULL),
('16.8987', '5', '6', '7'),
('16.9025', '081291270583', '1555', '55555'),
('16.9999', '088', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertanyaantambahan`
--

CREATE TABLE `pertanyaantambahan` (
  `idEvent` char(4) NOT NULL,
  `idPertanyaan` int(11) NOT NULL,
  `pertanyaan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pertanyaantambahan`
--

INSERT INTO `pertanyaantambahan` (`idEvent`, `idPertanyaan`, `pertanyaan`) VALUES
('E002', 16, 'Apa nama club anda?'),
('E004', 17, 'Seberapa sering mengikuti lomba dota?'),
('E004', 18, 'apakah tim anda solid?'),
('E004', 19, 'Mengapa anda ingin mendaftar?'),
('E004', 20, 'Seberapa kuat tim anda?');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `nim` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelas` varchar(5) NOT NULL,
  `password` varchar(16) NOT NULL,
  `kode` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`nim`, `nama`, `kelas`, `password`, `kode`) VALUES
('16.7777', 'Sutina', '3KS3', '2', '0'),
('16.8888', 'Sutina', '3KS1', '1', '1'),
('16.8987', 'Aldo', '3KS2', '23', '1'),
('16.9025', 'Arif Rahman H', '3KS2', '12', '0'),
('16.9999', 'Sutejo', '3KS1', '1', '0');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_event_user` (`cp`);

--
-- Indeks untuk tabel `jawabantambahan`
--
ALTER TABLE `jawabantambahan`
  ADD PRIMARY KEY (`idJawaban`),
  ADD KEY `FK_jawabanTambahan_user` (`nim`);

--
-- Indeks untuk tabel `myevent`
--
ALTER TABLE `myevent`
  ADD PRIMARY KEY (`nim`,`idEvent`),
  ADD KEY `FK_myevent_event` (`idEvent`);

--
-- Indeks untuk tabel `nohp`
--
ALTER TABLE `nohp`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `pertanyaantambahan`
--
ALTER TABLE `pertanyaantambahan`
  ADD PRIMARY KEY (`idPertanyaan`),
  ADD KEY `idEvent` (`idEvent`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nim`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jawabantambahan`
--
ALTER TABLE `jawabantambahan`
  MODIFY `idJawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `pertanyaantambahan`
--
ALTER TABLE `pertanyaantambahan`
  MODIFY `idPertanyaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_event_user` FOREIGN KEY (`cp`) REFERENCES `user` (`nim`);

--
-- Ketidakleluasaan untuk tabel `jawabantambahan`
--
ALTER TABLE `jawabantambahan`
  ADD CONSTRAINT `FK_jawabanTambahan_user` FOREIGN KEY (`nim`) REFERENCES `user` (`nim`);

--
-- Ketidakleluasaan untuk tabel `myevent`
--
ALTER TABLE `myevent`
  ADD CONSTRAINT `FK_myevent_event` FOREIGN KEY (`idEvent`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `FK_myevent_user` FOREIGN KEY (`nim`) REFERENCES `user` (`nim`);

--
-- Ketidakleluasaan untuk tabel `nohp`
--
ALTER TABLE `nohp`
  ADD CONSTRAINT `FK__user` FOREIGN KEY (`nim`) REFERENCES `user` (`nim`);

--
-- Ketidakleluasaan untuk tabel `pertanyaantambahan`
--
ALTER TABLE `pertanyaantambahan`
  ADD CONSTRAINT `pertanyaantambahan_ibfk_1` FOREIGN KEY (`idEvent`) REFERENCES `event` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
