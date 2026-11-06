DELIMITER $$

DROP TRIGGER IF EXISTS increment_publications$$
CREATE TRIGGER increment_publications 
AFTER INSERT ON Post
FOR EACH ROW 
BEGIN
    UPDATE Utilisateur SET nbIks = nbIks + 1 WHERE mail = NEW.mail;
END$$

DROP TRIGGER IF EXISTS decrement_publications$$
CREATE TRIGGER decrement_publications 
AFTER DELETE ON Post
FOR EACH ROW 
BEGIN
    UPDATE Utilisateur SET nbIks = nbIks - 1 WHERE mail = OLD.mail;
END$$

DROP TRIGGER IF EXISTS suivre_utilisateur$$
CREATE TRIGGER suivre_utilisateur
BEFORE INSERT ON Suivre 
FOR EACH ROW 
BEGIN 
    IF (NEW.mail = NEW.mailsuivi) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Un utilisateur ne peut pas se suivre.';
    END IF;
END$$

DROP TRIGGER IF EXISTS modif_post$$
CREATE TRIGGER modif_post 
BEFORE UPDATE ON Post 
FOR EACH ROW 
BEGIN 
    IF (OLD.mail != NEW.mail) THEN 
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'On ne peut pas modifier l''auteur d''un post, il appartient à un et un seul utilisateur.';
    END IF;
END$$


DROP TRIGGER IF EXISTS limite_post$$
CREATE TRIGGER limite_post
BEFORE INSERT ON Post 
FOR EACH ROW 
BEGIN
    DECLARE v_nbiks INT DEFAULT 0;

    SELECT nbIks INTO v_nbiks 
    FROM Utilisateur 
    WHERE mail = NEW.mail;

    IF (v_nbiks >= 50) THEN 
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Nombre de post trop élevé, impossible d''en poster d''autres.';
    END IF;
END$$

DELIMITER ;