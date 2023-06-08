SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `sistemDB`
--

CREATE DATABASE IF NOT EXISTS `sistemDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sistemDB`;

-- --------------------------------------------------------
CREATE TABLE `stolovi` (
  `stoID` int(16) NOT NULL,
  `naziv` varchar(64) NOT NULL,
  `brMesta` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `stolovi` (`stoID`, `naziv`, `brMesta`) VALUES
(1, '1', 4),
(2, '2', 4),
(3, '3', 4),
(4, '4', 4),
(5, '5', 4),
(6, '6', 4),
(7, '7', 4),
(8, 'pomocni', 4);

-- --------------------------------------------------------

CREATE TABLE `rezervacije` (
  `rezID` int(16) NOT NULL,
  `korisnik` varchar(64) NOT NULL,
  `sto` varchar(64) NOT NULL,
  `datumRez` DATE NOT NULL,
  `opis` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rez` (`rezID`,`korisnik`, `sto`, `datumRez`,`opis`) VALUES
(1,'testKorisnik', 'TEST','2008-11-11', 99);


-- --------------------------------------------------------

CREATE TABLE `user` (
  `id` int(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'konobar1','konobar1'),
(3, 'konobar2','konobar2');

--
-- Indexes for dumped tables
--

ALTER TABLE `stolovi`
  ADD PRIMARY KEY (`stoID`);

ALTER TABLE `rez`
  ADD PRIMARY KEY (`rezID`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `stolovi`
  MODIFY `stoID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

ALTER TABLE `rez`
  MODIFY `rezID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

ALTER TABLE `user`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
  
COMMIT;

