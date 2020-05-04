DROP TABLE IF EXISTS ksiazka;
CREATE TABLE ksiazka (
id_ks INT(10) NOT NULL AUTO_INCREMENT,
tytul VARCHAR(100) NOT NULL,
autor VARCHAR(100) NOT NULL,
cena DECIMAL(5,2) DEFAULT NULL,
okladka ENUM('twarda', 'miekka'),
kategoria ENUM('fantastyka', 'kryminal', 'horror', 'romans', 'nauka', 'kuchnia', 'obyczajowa', 'fakt', 'poradnik', 'biografia', 'dla dzieci', 'inna'),
liczba INT(10) DEFAULT NULL,
wydawnictwo VARCHAR(50) DEFAULT NULL,
rok_wydania INT(10) DEFAULT NULL,
PRIMARY KEY (id_ks)
 ) ENGINE=INNODB DEFAULT CHARSET=UTF8;

INSERT INTO ksiazka VALUES (1, 'Harry Potter i Czara Ognia', 'J.K. Rowling', 39.99, 'miękka', 'fantastyka', 16, 'Media Rodzina', 2016), 
(2, 'To', 'Stephen King', 30.60, 'twarda', 'horror', 47, 'Albatros', 2017),
(3, 'O krok za daleko', 'Harlan Coben', 19.99, 'miekka', 'kryminal', 7, 'Albatros', 2020),
(4, 'Kicia Kocia gotuje', 'Anita Glowinska', 5.99, 'miekka', 'dla dzieci', 12, 'Media Rodzina', 2019),
(5, 'Sapiens. Od zwierzat do bogow', 'Y.N. Harari', 38.61, 'twarda', 'fakt', 3, 'Literackie', 2018),
(6, 'Miecz Przeznaczenia', 'Andrzej Sapkowski', 33.26, 'miekka', 'fantastyka', 11, 'SUPERNOWA', 2016);

DROP TABLE IF EXISTS klient;
CREATE TABLE klient (
id_kl INT(10) NOT NULL AUTO_INCREMENT,
login VARCHAR(30) NOT NULL,
haslo VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL,
imie VARCHAR(20) DEFAULT NULL,
nazwisko VARCHAR(30) DEFAULT NULL,
miasto VARCHAR(20) DEFAULT NULL,
ulica VARCHAR(40) DEFAULT NULL,
nr_domu VARCHAR(10) DEFAULT NULL,
nr_lokalu VARCHAR(10) DEFAULT NULL,
kod_pocztowy VARCHAR(10) DEFAULT NULL,
PRIMARY KEY (id_kl)
) ENGINE=INNODB DEFAULT CHARSET=UTF8;

INSERT INTO klient VALUES (1, 'alakowalska', '123456', 'akowalska@wp.pl', 'Alicja', 'Kowalska', 'Warszawa', 'Pomorska', '3', '26', '21-030'),
(2, 'matino', 'KrolZycia123', 'matin@o2.pl', 'Mateusz', 'Nowak', 'Gdynia', 'Sienkiewicza', '8', '11a', '43-997'),
(3, 'bialywilk', 'yenneferlove', 'zlecenia@kaermorhen.com', 'Geralt', 'Riv', 'Rivia', 'Kaer Morhen', '7', '-', '12-345'),
(4, 'llovegood', 'chrapakKretorogi', 'luna@magia.pl', 'Luna', 'Lovegood', 'Londyn', 'Hogwart', '2', '3c', '13-246'),
(5, 'Sauron', 'frodobaggins','sauron@mordor.com', 'Sauron', 'Oko', 'Mordor', 'wulkan', '1', '1', '66-666');

DROP TABLE IF EXISTS zamowienie;
CREATE TABLE zamowienie (
id_z INT(10) NOT NULL AUTO_INCREMENT,
kl_id INT(10) DEFAULT NULL,
data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
status ENUM('zlozone', 'oplacone', 'w realizacji', 'wyslane', 'doreczone', 'zwrot') DEFAULT 'zlozone',
PRIMARY KEY (id_z),
CONSTRAINT klienci FOREIGN KEY (kl_id) REFERENCES klient(id_kl) ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=UTF8;

INSERT INTO zamowienie VALUES (1, 1, '2020-05-04 21:26:22', 'zlozone'), (2, 3, '2019-03-24 10:16:52', 'doreczone'), 
(3, 2, '2017-05-30 09:51:37', 'w realizacji'), (4, 5, '2020-02-11 23:31:12', 'zwrot'), (5, 4, '2017-05-05 15:48:40', 'doreczone');

DROP TABLE IF EXISTS szczegoly;
CREATE TABLE szczegoly (
id_s INT(10) NOT NULL AUTO_INCREMENT,
ks_id INT(10) DEFAULT NULL,
z_id INT(10) DEFAULT NULL,
sztuk INT(10) DEFAULT NULL,
PRIMARY KEY(id_s),
CONSTRAINT zamowienia FOREIGN KEY (z_id) REFERENCES zamowienie(id_z) ON UPDATE CASCADE,
CONSTRAINT ksiazka1 FOREIGN KEY (ks_id) REFERENCES ksiazka(id_ks) ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=UTF8;

INSERT INTO szczegoly VALUES (1,1,2,2), (2,1,1,3), (3,2,1,6), (4,2,1,5), (5,3,1,4), (6,4,2,2), (7,5,1,1);

DROP TABLE IF EXISTS opinia;
CREATE TABLE opinia (
id_o INT(10) NOT NULL AUTO_INCREMENT,
ocena ENUM('1', '2', '3', '4', '5') NOT NULL,
opis VARCHAR(200) DEFAULT NULL,
ks_id INT(10) DEFAULT NULL,
kl_id INT(10) DEFAULT NULL,
PRIMARY KEY(id_o),
CONSTRAINT klienci2 FOREIGN KEY (kl_id) REFERENCES klient(id_kl) ON UPDATE CASCADE,
CONSTRAINT ksiazka FOREIGN KEY (ks_id) REFERENCES ksiazka(id_ks) ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=UTF8;

INSERT INTO opinia VALUES (1, '3', 'Historia jest niespojna. Daje ocene wyzej za glowna postac.', 6, 3),
(2, '5', 'Corka jest zadowolona, szybko zasypia. Dobra ksiazka.', 4, 2),
(3, '4', 'Ciekawa ksiazka, ale troszke malo o chrapakach kretorogich', 1, 4),
(4, '5', 'Bardzo dobra i merytoryczna ksiazka', 5, 3),
(5, '5', 'Bardzo lubie takie klimaty. Postac Dumbledora przypomina mi mojego wroga', 1, 5),
(6, '1', 'To chyba jednak nie moje klimaty. Nie doczytalam, nie polecam', 3, 1);
