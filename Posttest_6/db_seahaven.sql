-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Okt 2024 pada 17.41
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_seahaven`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `profile_pic`) VALUES
(1, 'dhea03', '123@gmail.com', '$2y$10$JEgvo4JiGdGhH3Zh9RpoEOQ0q4zU48ch8K78xYzbZYOmkJsezxQPu', 'uploads/itik.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `volunteer_register`
--

CREATE TABLE `volunteer_register` (
  `id_volunteer` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `volunteer_name` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `volunteer_program` varchar(100) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `registration_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `volunteer_register`
--

INSERT INTO `volunteer_register` (`id_volunteer`, `username`, `volunteer_name`, `birthdate`, `volunteer_program`, `file_path`, `registration_date`) VALUES
(4, 'dhea03', 'Dhea Puspita', '2024-10-01', 'Coral Reef Protection Program', 'volunteer_id/2024-10-16 16.08.40.jpg', '2024-10-16 22:08:40'),
(5, 'dhea03', 'Dhea Puspita', '2003-06-03', 'Forest Regrowth Initiative', 'volunteer_id/2024-10-16 17.39.20.jpg', '2024-10-16 23:39:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `volunteer_register`
--
ALTER TABLE `volunteer_register`
  ADD PRIMARY KEY (`id_volunteer`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `volunteer_register`
--
ALTER TABLE `volunteer_register`
  MODIFY `id_volunteer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `volunteer_register`
--
ALTER TABLE `volunteer_register`
  ADD CONSTRAINT `volunteer_register_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
