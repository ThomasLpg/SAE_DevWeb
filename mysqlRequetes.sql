SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `Post` (
  `numPost` int(11) NOT NULL AUTO_INCREMENT AUTO_INCREMENT,
  `cheminFichier` varchar(100) DEFAULT NULL,
  `contenu` varchar(235) NOT NULL,
  `datepub` datetime NOT NULL DEFAULT current_timestamp(),
  `mail` varchar(50) NOT NULL,
  PRIMARY KEY (`numPost`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `Post` (`numPost`, `cheminFichier`, `contenu`, `datepub`, `mail`) VALUES
(15, NULL, 'Hey', '2026-11-05 17:11:54', 'thomasle52200@gmail.com');


DELIMITER $$
CREATE TRIGGER `decrement_publications` AFTER DELETE ON `Post` FOR EACH ROW BEGIN
    UPDATE Utilisateur 
    SET nbIks = nbIks - 1 
    WHERE mail = OLD.mail;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `increment_publications` AFTER INSERT ON `Post` FOR EACH ROW BEGIN
    UPDATE Utilisateur 
    SET nbIks = nbIks + 1 
    WHERE mail = NEW.mail;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `limite_post` BEFORE INSERT ON `Post` FOR EACH ROW BEGIN 
    DECLARE v_nbiks INT DEFAULT 0;

    SELECT nbIks INTO v_nbiks 
    FROM Utilisateur 
    WHERE mail = NEW.mail;

    IF (v_nbiks >= 50) THEN 
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Nombre de posts trop eleve, impossible d''en poster d''autres.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `modif_post` BEFORE UPDATE ON `Post` FOR EACH ROW BEGIN 
    IF (OLD.mail != NEW.mail) THEN 
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'On ne peut pas modifier l''auteur d''un post, il appartient a un et un seul utilisateur.';
    END IF;
END
$$
DELIMITER ;

ALTER TABLE `Post`
  ADD KEY `mail` (`mail`),
  ADD KEY `cheminFichier` (`cheminFichier`);


ALTER TABLE `Post`
  MODIFY `numPost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;


ALTER TABLE `Post`
  ADD CONSTRAINT `1` FOREIGN KEY (`mail`) REFERENCES `Utilisateur` (`mail`) ON DELETE CASCADE,
  ADD CONSTRAINT `2` FOREIGN KEY (`cheminFichier`) REFERENCES `Image` (`cheminFichier`) ON DELETE SET NULL;
COMMIT;