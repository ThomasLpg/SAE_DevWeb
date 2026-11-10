CREATE TABLE Utilisateur (
    mail VARCHAR(50) PRIMARY KEY,
    nom VARCHAR(15) NOT NULL,
    prenom VARCHAR(15) NOT NULL,
    pseudo VARCHAR(50) NOT NULL,
    nblikes INT DEFAULT 0 NOT NULL,
    nbIks INT DEFAULT 0 NOT NULL
);

CREATE TABLE Image (
    cheminFichier VARCHAR(100) PRIMARY KEY,
    descriptionImage VARCHAR(150)
);

CREATE TABLE Post (
    numPost INT PRIMARY KEY AUTO_INCREMENT,
    cheminFichier VARCHAR(100),
    contenu VARCHAR(235) NOT NULL,
    datepub DATE DEFAULT (CURRENT_DATE) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    nblikes INT DEFAULT 0 NOT NULL,
    FOREIGN KEY (mail) REFERENCES Utilisateur(mail),
    FOREIGN KEY (cheminFichier) REFERENCES Image(cheminFichier)
);

CREATE TABLE Tag (
    identifiantT INT PRIMARY KEY,
    `libellé` VARCHAR(30) NOT NULL,
    descriptionTag VARCHAR(150)
);

CREATE TABLE Suivre (
    mail VARCHAR(50),
    mailsuivi VARCHAR(50),
    PRIMARY KEY (mail, mailsuivi),
    FOREIGN KEY (mail) REFERENCES Utilisateur(mail),
    FOREIGN KEY (mailsuivi) REFERENCES Utilisateur(mail)
);

CREATE TABLE AbonnerTag (
    identifiantT INT,
    mail VARCHAR(50),
    PRIMARY KEY (identifiantT, mail),
    FOREIGN KEY (identifiantT) REFERENCES Tag(identifiantT),
    FOREIGN KEY (mail) REFERENCES Utilisateur(mail)
);

CREATE TABLE ContenuTag (
    identifiantT INT,
    numPost INT,
    PRIMARY KEY (identifiantT, numPost),
    FOREIGN KEY (identifiantT) REFERENCES Tag(identifiantT),
    FOREIGN KEY (numPost) REFERENCES Post(numPost)
);
