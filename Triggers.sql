CREATE OR REPLACE TRIGGER increment_publications 
AFTER INSERT ON Post
FOR EACH ROW 
BEGIN
UPDATE Utilisateur SET nbIks = nbIks+1 WHERE mail = :NEW.mail;
END;

CREATE OR REPLACE TRIGGER decrement_publications 
AFTER DELETE ON Post
FOR EACH ROW 
BEGIN
UPDATE Utilisateur SET nbIks = nbIks-1 WHERE mail = :OLD.mail;
END;

CREATE OR REPLACE TRIGGER suivre_utilisateur
BEFORE INSERT ON Suivre 
FOR EACH ROW 
WHEN (new.mail = new.mailsuivi)
BEGIN 
    RAISE_APPLICATION_ERROR(-20001, 'un utilisateur ne peut pas se suivre.');
END;


CREATE OR REPLACE TRIGGER modif_post 
BEFORE UPDATE ON Post 
FOR EACH ROW 
BEGIN 
    IF (:OLD.mail != :NEW.mail) THEN 
        RAISE_APPLICATION_ERROR(-20001, 'On ne peut pas modifier l''auteur d''un post, il appartient à un et un seul utilisateur.');
    END IF;
END;

CREATE OR REPLACE TRIGGER limite_post
BEFORE INSERT ON Post 
FOR EACH ROW 
DECLARE 
v_nbiks Utilisateur.NBIKS%TYPE;
BEGIN
    SELECT nbIks INTO v_nbiks FROM Utilisateur 
    WHERE mail = :NEW.mail;
    IF (v_nbiks > 50) THEN 
        RAISE_APPLICATION_ERROR(-20001, 'Nombre de post trop élevé, impossible d''en poster d''autres.');
    END IF;
END;

// Auto_incrementation_de_numpost_dans_POST
CREATE SEQUENCE seq_post
START WITH 1 
INCREMENT BY 1;


CREATE OR REPLACE TRIGGER increment_numpost 
BEFORE INSERT ON POST 
FOR EACH ROW
BEGIN
    
    :NEW.numPost := seq_post.NEXTVAL;

END;