DATABASE SCRIPT
/////////////////////////////////////
CREATE TABLE `voiture` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `kmh` int(11) NOT NULL,
  `characteristics` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`characteristics`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voiture`
--

INSERT INTO `voiture` (`id`, `model`, `kmh`, `characteristics`) VALUES
(26, 'Tesla Model 4', 200, '[\"Electric\",\"Autopilot\"]'),
(27, 'bmw', 245, '[]'),
(29, 'Tesla Model 7', 200, '[\"Electric\",\"Autopilot\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;
