SELECT Utilisateur.mail, count(*) as nb_followers FROM Utilisateur 
INNER JOIN Suivre ON Utilisateur.mail = Suivre.mailsuivi
GROUP BY Utilisateur.mail
ORDER BY nb_followers
FETCH FIRST 10 ROWS ONLY;


SELECT libellé, count(*) as nbmentions FROM TAG 
INNER JOIN ContenuTag ON Tag.identifiantT = ContenuTag.identifiantT
INNER JOIN Post ON ContenuTag.numpost = Post.numpost
GROUP BY Tag.identifiantT, libellé
ORDER BY nbmentions ASC;