-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Sob 04. led 2025, 13:23
-- Verze serveru: 10.4.28-MariaDB
-- Verze PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `techpetal`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `theme` varchar(255) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `parameters` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `post`
--

INSERT INTO `post` (`id`, `title`, `date`, `theme`, `rating`, `text`, `image`, `link`, `parameters`) VALUES
(1, 'Introduction to AI', '2025-01-01', 'Technology', 5, 'A detailed overview of artificial intelligence and its applications.', 'ai_intro.jpg', 'https://example.com/ai-intro', '{\"difficulty\":\"beginner\",\"duration\":\"30min\"}'),
(2, 'Top 10 Web Development Tools', '2025-01-02', 'Web Development', 4, 'Explore the most popular tools for web development.', 'web_tools.jpg', 'https://example.com/web-tools', '{\"difficulty\":\"intermediate\",\"tools_count\":10}'),
(3, 'Understanding Machine Learning', '2025-01-03', 'Technology', 5, 'An article explaining the basics of machine learning.', 'ml_basics.jpg', 'https://example.com/ml-basics', '{\"difficulty\":\"beginner\",\"duration\":\"45min\"}'),
(4, 'Cybersecurity Best Practices', '2025-01-04', 'Security', 5, 'Learn how to protect yourself online with these tips.', 'cybersecurity_tips.jpg', 'https://example.com/cybersecurity-tips', '{\"difficulty\":\"advanced\",\"focus\":\"personal security\"}'),
(5, 'Future of Quantum Computing', '2025-01-05', 'Technology', 4, 'Discussion on the potential impact of quantum computing.', 'quantum_future.jpg', 'https://example.com/quantum-future', '{\"difficulty\":\"expert\",\"predictions\":5}');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin','moderator') DEFAULT 'user',
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created`) VALUES
(1, 'Pavel', 'paja5913@gmail.com', '$2y$10$oSOP9iYn8A2OvHRyRAPv0uqIlWvmH.li3FrDEuH7C1HELeaQ5587O', 'admin', '2025-01-04 12:08:43'),
(2, 'xd', 'xd', '$2y$10$JWjY2wj2xN.ORk5cElOnVuACYeOs.8EYLn4OQUBYymweuq61bU2lS', 'admin', '2025-01-04 12:16:05');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
