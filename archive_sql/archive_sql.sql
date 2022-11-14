-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2022 at 07:17 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `22_pwem2_off`
--

-- --------------------------------------------------------

--
-- Table structure for table `ti_evenement`
--

CREATE TABLE `ti_evenement` (
  `id_evenement` int(10) UNSIGNED NOT NULL,
  `date_et_heure` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `prix` decimal(3,2) DEFAULT NULL,
  `infos_supp` mediumtext,
  `id_lieu` tinyint(1) UNSIGNED NOT NULL,
  `id_artiste` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ti_evenement`
--

INSERT INTO `ti_evenement` (`id_evenement`, `date_et_heure`, `prix`, `infos_supp`, `id_lieu`, `id_artiste`) VALUES
(1, '2023-07-08 23:30:00', '5.00', 'Concert dessiné par Philippe Girard et Francis Desharnais', 1, 3),
(2, '2023-07-08 22:30:00', '5.00', NULL, 1, 4),
(3, '2023-07-08 21:30:00', '5.00', 'Lancement de cassette', 1, 5),
(4, '2023-07-09 01:30:00', '5.00', 'Ex-Cougarettes et Mathias Mental', 1, 10),
(5, '2023-07-10 00:30:00', '5.00', 'Ex-We Are Wolves et Mathématique', 1, 11),
(6, '2023-07-09 22:30:00', '5.00', NULL, 1, 12),
(7, '2023-07-09 23:30:00', '5.00', NULL, 1, 14),
(9, '2023-07-10 23:59:00', '5.00', NULL, 1, 18),
(14, '2023-07-11 23:00:00', '5.00', NULL, 1, 30),
(15, '2023-07-11 23:59:00', '5.00', NULL, 1, 31),
(17, '2023-07-10 18:00:00', NULL, NULL, 2, 25),
(21, '2023-07-10 20:30:00', NULL, 'L\'incroyable Cabaret Olibrius Folkestra Circus présente:\r\nMarisol-Josée\r\nAlex Drapeau\r\nBoutch\r\nGab Paquet\r\nOlivier Légaré\r\nL\'abobinable Fanny Fay\r\nla troupe de feu Fogo Rasto', 2, 24),
(24, '2023-07-11 18:00:00', NULL, 'Collaboration Festival Diapason', 3, 39),
(25, '2023-07-08 17:00:00', NULL, NULL, 4, 9),
(27, '2023-07-10 18:00:00', NULL, NULL, 4, 28),
(30, '2023-07-11 21:30:00', NULL, NULL, 5, 37),
(33, '2023-07-08 22:00:00', NULL, NULL, 6, 7),
(34, '2023-07-08 23:00:00', NULL, NULL, 6, 8),
(35, '2023-07-09 23:00:00', NULL, NULL, 6, 13),
(36, '2023-07-09 22:00:00', NULL, 'Concert dessiné (Bordeaux-Qc)', 6, 15),
(37, '2023-07-10 23:00:00', NULL, NULL, 6, 21),
(39, '2023-07-08 20:30:00', NULL, NULL, 6, 24),
(41, '2023-07-11 23:30:00', NULL, 'Lancement d\'album', 6, 33),
(42, '2023-07-08 20:00:00', NULL, NULL, 3, 12),
(43, '2023-07-08 19:30:00', NULL, NULL, 2, 18),
(44, '2023-07-08 21:30:00', NULL, NULL, 5, 10),
(46, '2023-07-09 21:30:00', NULL, NULL, 3, 33),
(48, '2023-07-09 19:30:00', NULL, NULL, 4, 31);

-- --------------------------------------------------------

--
-- Table structure for table `ti_style_artiste`
--

CREATE TABLE `ti_style_artiste` (
  `id_style` tinyint(3) UNSIGNED NOT NULL,
  `id_artiste` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ti_style_artiste`
--

INSERT INTO `ti_style_artiste` (`id_style`, `id_artiste`) VALUES
(1, 24),
(2, 3),
(2, 4),
(2, 5),
(2, 10),
(2, 18),
(2, 33),
(3, 7),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 25),
(4, 30),
(5, 18),
(5, 21),
(5, 30),
(5, 31),
(6, 30),
(6, 37),
(7, 8),
(7, 9),
(7, 28),
(7, 39),
(8, 24),
(9, 24),
(10, 33),
(11, 21),
(12, 9),
(13, 7),
(13, 10),
(13, 13),
(13, 15),
(14, 3),
(14, 4),
(14, 5),
(14, 8),
(14, 39),
(15, 25);

-- --------------------------------------------------------

--
-- Table structure for table `t_actualite`
--

CREATE TABLE `t_actualite` (
  `id_actualite` tinyint(4) UNSIGNED NOT NULL,
  `titre` varchar(200) NOT NULL,
  `date_actualite` datetime DEFAULT NULL,
  `auteurs` varchar(100) DEFAULT NULL,
  `article` text NOT NULL,
  `etat_publication` tinyint(1) NOT NULL COMMENT '0=brouillon, 1=publié, 2=archivé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_actualite`
--

INSERT INTO `t_actualite` (`id_actualite`, `titre`, `date_actualite`, `auteurs`, `article`, `etat_publication`) VALUES
(1, 'Débutez votre fin de semaine sur une note familiale à la Scène de la famille Télé-Québec', '2023-07-11 08:33:00', 'Elisabeth et Karine', 'De 13 h à 19 h, profitez de ce lieu en famille. De nombreux kiosques, maquillage pour enfants, animation de cirque, jeux gonflables et bien plus. L’Express Rock’n’Roll sera également stationné et accueillera mélomanes et néophytes à son bord pour faire découvrir ce musée ambulant. À 19 h 30, The Babalooneys (Québec), un quintette au son rock surf typiquement californien des années 60. À 20 h 30, du rock’n’roll sans compromis avec Les Rockfellers (Québec) et à 21 h 30 le Québec Redneck Bluegrass Project (Saguenay Lac-Saint-Jean, Irlande), cette gang d’hillbillies exilés de leur Québec natal qui se rencontrent en Chine partagera son folk-bluegrass.', 1),
(2, 'Soirée à saveur internationale sur la rue Cartier', '2023-07-11 16:30:00', 'Elisabeth et Karine', 'À 17 h 30, LaTourelle Orkestra (Québec) vous proposera leur entraînante musique du monde à saveur tsigane. À 19 h, Romain Malagnoux (Québec), habile guitariste à la voix posée, saura faire danser les passants de la rue Cartier. À 20 h 30, chanteuse romanti-comico-tragique originaire de la Côte Nord, Odile DuPont (Québec), vous charmera à grands coups de chansonnettes.', 1),
(3, 'Un apéro qui promet à la Scène Caisse populaire de Québec', '2023-07-11 10:00:00', 'Elisabeth et Karine', 'À 17 h, le sextuor Harvest Breed (Sherbrooke) vous servira un apéro musical aux influences des années 60 et 70. À 19 h, Orkestar Kriminal (Montréal), une douzaine de musiciens puisant dans le répertoire yiddish, grec, danois, punk des années 1920 et 1930 prendront place sur le parvis. À 21 h, Friendly Rich & The Lollipop People, une troupe rock-folk-jazz-expérimentale dont la musique rappelle celle de Tom Waits et l’univers de Frank Zappa.', 1),
(4, 'Une soirée folle au Fou-Bar', '2023-07-11 19:00:00', 'Elisabeth et Karine', 'À 18 h, c’est un rendez-vous avec Harry Coe (Québec), cet homme-orchestre sensible, drôle et lucide chantant la condition ouvrière moderne avec charme et énergie. À 19 h, chanteuse romanti-comico-tragique originaire de la Côte Nord, Odile DuPont (Québec) vous charmera à grands coups de chansonnettes.', 1),
(5, 'Des activités pour tous les goûts', '2023-07-08 11:43:00', 'Elisabeth et Karine', 'Depuis mercredi, le Festival OFF de Québec bat son plein au centre-ville de Québec. Les festivaliers sont au rendez-vous et dame nature semble vouloir nous donner la chance de pouvoir profiter pleinement des spectacles extérieurs à venir. Durant les deux derniers jours du festival (vendredi et samedi), de la poésie frivole, des chansonnettes, du disco pop vintage, du métal, du country folk, du folk-bluegrass, du rock-folk-jazz-expérimental, du yiddish, du punk trash et du rock… du rock surf, du rock garage, du stoner rock, du rock’n’roll! Sans oublier les activités familiales à la Place de l’Université-du-Québec (scène Télé-Québec) de 13 h à 19 h.', 1),
(6, '4 jours, 7 scènes, 40 spectacles et plusieurs premières fois!', '2023-07-07 14:30:00', 'Elisabeth et Karine', 'Du 8 au 11 juillet, plus de 40 spectacles avec des artistes des quatre coins du Québec, du Canada et des États-Unis se tiendront dans la vieille Capitale. 4 jours d’expériences musicales inusitées qui promettent l’exaltation des nouvelles sensations. Vous en redemanderez !', 1),
(7, 'Festival OFF de Québec : c’est toujours la première fois!', '2023-07-07 10:00:00', 'Elisabeth et Karine', 'Le Festival OFF de Québec est un évènement musical indépendant qui se donne pour mission d’offrir au grand public la surprise, l’étonnement et l’émoi d’une première expérience… tant pour les artistes que les festivaliers. Chaque année, grandes primeurs, nouveaux projets, et découvertes musicales vous sont licencieusement proposés. Des sons réinventés, des projets inédits, des mélanges de styles saugrenus, des artistes connus dans des groupes moins connus, des costumes jamais vus, des grandes stars en devenir, des collaborations insolites, des soirées délirantes qui frôlent l’indécence, bref, des souvenirs pour la vie.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_artiste`
--

CREATE TABLE `t_artiste` (
  `id_artiste` mediumint(8) UNSIGNED NOT NULL,
  `nom_artiste` varchar(100) NOT NULL,
  `description` mediumtext,
  `provenance` varchar(100) DEFAULT NULL COMMENT 'ville, pays',
  `site_web_artiste` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_artiste`
--

INSERT INTO `t_artiste` (`id_artiste`, `nom_artiste`, `description`, `provenance`, `site_web_artiste`) VALUES
(3, 'Diamond Rings', 'Véritable coqueluche du courant électro/pop kitsch, Diamond Rings n\'a plus besoin de présentation. De son habillement excentrique sur scène où ceinture dorée, make up arc-en-ciel, leggings et bijoux démodés sont ressuscités, en passant par ses textes outrageusement naïfs, Diamond Rings fait plus qu\'un clin d\'oeil aux années 80, il les fait littéralement revivre. Avec son premier album complet «Special Affections» qui lui a permis de tourner avec Robyn et de décrocher un contrat de musique avec l\'importante étiquette européenne Astralwerks (Hot Chip, Phoenix...), l\'ex-chanteur des D\'Urbervilles sert un cocktail sonore explosif alliant sexiness et nostalgie, qui redirige tous les états d\'âme en un même et seul lieu : le dancefloor! Colore ta peau, arbore ton t-shirt de licorne, empoigne ta pouliche en peluche et viens assumer ton inclinaison inavouée pour le kitsch avec son maître incontesté!', 'Toronto, Canada', 'http://diamondringsmusic.com/'),
(4, 'Purity Ring', 'Issue du déluré/déjanté/disjoncté groupe torontois GOBBLE GOBBLE qui avait littéralement fait exploser le complexe Méduse durant la dernière édition du OFF, Megan James n\'a eu besoin que d\'un simple, le tube électro-glitch/pop «Ungirthed», pour être encensée par les poids lourds de l\'indie : Pitchfork, Stereogum et The Guardian, parmi bien d\'autres. Surfant sur un buzz aussi instantané que mérité, Purity Ring proposera un des tous premiers spectacles de sa jeune existence au OFF! Une occasion en or de découvrir la pop luxuriante, futuriste et fracturée de cette artiste qui sera bientôt sur toutes les lèvres... (Burial, Teams, Star Slinger)', 'Edmonton, Canada', 'http://purityringthing.com/'),
(5, 'Mathématique', 'Jeune artiste de Québec au potentiel immense, Pascale Mercier a fait office de métronome cardiaque depuis deux ans dans la vieille capitale, alors qu\'elle a sillonné les bars branchés pour y présenter son premier album «Coeur». Punché et efficace, le 8-bit-électro-pop naïf de Mathématique a inspiré plus d\'un pas de danse et obligé aux déhanchements en série lors de ses prestations incendiaires. Cette année, elle nous revient plus en forme que jamais pour présenter son deuxième album en primeur au OFF! Pensez à  votre coeur et repoussez votre infarctus, avec l\'exercice cardio des plus ludiques qu\'est Mathématique!', 'Québec, Canada', 'https://soundcloud.com/mathematique'),
(7, 'Leafer', 'Dans le but de faire les spectacles les plus intenses, Leafer brille comme étant l\'un des groupes les plus prometteurs de la ville de Québec. Le groupe a déjà  produit deux albums complets de façon indépendante. Au cours des deux dernières années, Leafer a joué avec Sebastien Grainger et les Montagnes, Malajube et Clues. Ils adorent créer des ambiances délirantes dans leurs performances, ayant même déjà  lancé des cagoules et des masques à  leur public. Leur dernier album, Sea Scene, résonne par ses claviers puissants, ses guitares recherchées et des rythmiques étonnantes. Le groupe se démarque par l\'opposition qui existe entre les voix des deux chanteurs ainsi que par des contrepoints subtilement amenés.', 'Québec, Canada', 'http://www.myspace.com/leaferleafer'),
(8, 'Peter peter', 'Nouvelle vedette montante d\'Audiogram (Karkwa, Alex Nevsky, Pierre Lapointe...), Peter Peter a proposé cet hiver un premier album fort prometteur. En plus de ses textes aboutis et réfléchis, l\'auteur-compositeur possède un talent indiscutable pour accorder la mélancolie à  ses arrangements folk/pop, dans une décharge émotive transcendante. Avec sa direction artistique moderne et accrocheuse, Peter Peter saura graffigner votre coeur et édulcorer les averses qui s\'empreignent de votre vie.', 'Québec, Canada', 'http://info.audiogram.com/peter-peter-presente-noir-eden/?v=media'),
(9, 'Sam Eloi', 'Les membres du défunt groupe Les Saligauds se sont réunis pour donner corps et vie au projet Sam Eloi (chanteur et guitariste du groupe) et préparent actuellement un premier EP. C\'est sur une base s\'étalant assez largement du bluegrass au folk rock que s\'allient des sonorités acoustiques et électriques en une texture résolument feutrée. Au milieu d\'un environnement traversé de folk, Sam Eloi verse ses mélodies indélébiles en des vers où se mélangent les solubles intrigues aux volutes instantanées. La poésie se prête tantôt à  la prose tantôt au vers libre pour donner lieu à  un monde où se côtoient la chanson prolixe livreuse d\'histoires et la parole laconique aux allures fuyantes de paysage.', 'Montréal, Canada', 'https://sameloi.bandcamp.com/'),
(10, 'TangoCharlie', 'TangoChalie est un nouveau groupe formé d\'ex-Cougarettes et Mathias Mental. TangoCharlie a des influences Indie Rock (Saviez-vous que Rock N\' Roll, à  la base, ça voulait dire \"Sexe\"?) et des influences électro (Saviez-vous qu\'électro, ça voulait dire électronique?) TangoCharlie a des arrangements rock (Guitare, basse, batterie, clavier) ainsi qu\'une esthétique électro. \'\'Vous avez besoin de la musique de TangoCharlie comme vous avez besoin d\'une claque dans face. Et, croyez-moi, vous avez besoin d\'une claque dans face.\'\'', 'Montréal, Canada', 'http://tangocharlie.bandcamp.com'),
(11, 'LEAP', 'Jeune groupe réunissant Antonin (ex-drummer de We Are Wolves) à  la guitare et à  la voix, Pascale Mercier (aka Mathématique) à  la batterie, ainsi qu\'une basse, LEAP est la surprise du OFF 2014. Post-rock-garage, inspiré de Joy Division, My Bloody Valentine, The Fresh and Onlys, Vivian Girls... Aucun démo de disponible au moment d\'écrire ces lignes, et pourtant on est sûrs que ce sera un succès. Pourquoi?', 'Québec, Canada', 'https://www.facebook.com/LEAP-243611415685487/'),
(12, '3D kids', 'La formation 3D KIDS existe depuis 2004. Puriste de punk \'77, les 3D KIDS gardent ça simple et droit au but. X (guitare/voix), Y (batterie) et Z (basse) ont deux albums à  leur actif (ZYX et Retarded Love) et un troisième est prévu avant la fin de l\'année.', 'Québec, Canada', 'http://3dkids.bandcamp.com '),
(13, 'Ponctuation', 'On les connait déjà  pour leur dimension artistique très raffinée avec leur excellent projet indie-rock aux accents électro Waving Hand. Maintenant, avec PONCTUATION, on les redécouvre sous un angle brut et sauvage. Malgré ce virage à  180 degrés, les frères Guillaume et Maxime Chiasson conservent toujours leur doigté précis et recherché, mais cette fois-ci dans une perspective de rock garage énergique, psychédélique et «dans ta face». Une véritable bombe à  distorsion en prestation live... (Ty Segall, Wavves, Thee Oh Sees)', 'Québec, Canada', 'http://ponctuationponctuation.bandcamp.com'),
(14, 'Lesbo Vrouven', 'Sam Murdock (guitare, voix), Hugo Lebel (bass) et Antoine Caron (drum) s\'attaquent de façon déconcertante à  la musique et aux chorégraphies depuis le chaud printemps 2006, avec cette urgence brûlante hors du commun. Après Je reviens Geneviève un premier disque court et inflexible et Encore la mort, évocateur titre avec ses chansons lourdes à  faire pleurer sur la piste de danse, le trio est de retour d\'une pause bébé pour la sueur et le sel.', 'Québec, Canada', 'http://www.lesbovrouven.com'),
(15, 'Sol Hess & The Sympatik\'s', 'Sol Hess & the Sympatik\'s est un groupe de Bordeaux,  en tournée avec DELATOURETTE à  l\'occasion d\'un split-EP illustré par deux dessinatrices: la québécoise Caro Caron et la bordelaise Laureline Mattiussi. A l\'occasion de leur venue au festival OFF,  Sol Hess & the Sympatik\'s feront un concert dessiné exceptionnel avec au dessin,  Laureline Mattiussi,  Caro Caron et Philippe Girard!\r\n\r\n\"Dans la musique tour à  tour très atmosphérique, puis franchement échevelée, de Sol Hess & The Sympatik\'s, chacun des quatre instrumentistes a son espace. Les guitares à  force pédales et la batterie, renvoient aux soniques 90\'s. Tandis que le chanteur-guitariste maîtrise pleinement sa voix, qui oscille entre couleurs new wave, véhémence explosive et déliés crooner à  la Sixteen Horsepower. Comme si, le long de leur set, Sol Hess & The Sympatik\'s racontaient une histoire, dans un anglais d\'évidence plein de sens.\" Patrick Scarzello', 'Bordeaux, France', 'http://sympatiks.blogspot.com/'),
(18, 'Lunice', 'Participant de l\'édition 2010 du prestigieux Red Bull Music Academy, danseur et musicien électronique montrélais, Lunice sait comment faire danser les gens à  son tour. Il le fait un peu partout autour du monde avec son mélange de beats hiphop hyperactifs et de sonorités synthétiques percutantes, un peu à  la manière des compagnons du collectif Lucky Me; Machinedrum (NY), Rustie (UK) ou Hudson Mohawke (UK).', 'Montréal, Canada', 'https://soundcloud.com/lunice'),
(21, 'Black Taboo', 'Plus besoin de présentation pour le groupe depuis leur hit \'\'God Bless the Topless\'\': Black Taboo sont les rois ici en ce qui concerne le rap aux paroles malpropres, politically incorrectes et vulgaires. Toujours sous le signe de l\'humour et de la dérision, les textes de leur plus récent album Gold Tits City sont plus matures. Black Taboo sur scène c\'est comme les lions au cirque: méchants, mais on veut tellement les voir rugir!', 'Québec, Canada', 'http://blacktaboo.bandcamp.com/'),
(24, 'Cabaret Olibrius', 'Troupe burlesque funambule de personnages gitanesques la tête pleine de bulles, l\'Olibrius Folkestra est la réunion de différents musiciens, auteurs-compositeurs, artistes de cirque réunis dans une même symbiose afin de vous faire vivre dans une folie des plus colorés, une soirée à  vous couper le souffle aux ambiances des Cabarets/Cirques du début 20e siècle à  saveur contemporaine.\r\nEn résulte des heures de musiques et de styles variés, de la chanson aux influences tziganes, folk, en passant par les musiques traditionnelles québécoises et irlandaises, valses, swings, gitans déjantés en formations variables accompagnés de performances de cirque enflammées et inimaginables. Pour l\'occasion du 8 juillet\r\nL\'incroyable Cabaret Olibrius Folkestra Circus présente:\r\nMarisol-Josée\r\nAlex Drapeau\r\nBoutch\r\nGab Paquet\r\nOlivier Légaré\r\nL\'abobinable Fanny Fay\r\nla troupe de feu Fogo Rasto et plusieurs autres surprises farfelues!!', 'Québec, Canada', 'http://www.reverbnation.com/olibriusfolkestra'),
(25, 'Jah & I', 'Natif des collines de St-Ann\'s en Jamaique, chanteur et rastaman charismatique, Daddy Rushy fonde à  Québec le groupe Jah & I. La formation prend son envol et séduit le public en utilisant les rythmes chauds et festifs du reggae. Appuyé par l\'expérience et la maturité de ses musiciens talentueux, Jah & I transporte l\'auditoire vers un univers authentique et fidèle aux racines Jamaïcaine. À la fois dansante, rafraîchissante et universelle, la musique de Jah & I se démarque. Que ce soit par les mélodies inspirées du leader, la complicité des guitares, la créativité des claviers ou bien la basse solide, les musiciens savent diffuser leur passion.', 'Québec, Canada', 'https://www.facebook.com/Jah-I-163404430344429/'),
(28, 'Simon Paradis', 'Indéniablement l\'une des plus signifiantes découvertes des dernières années sur la scène de Québec, Simon Paradis distille un folk alambiqué et éclectique, aux textures sonores parfois scintillantes, parfois densément barbouillées, toujours cinématographiques. En équilibre précaire mais parfait entre l\'exploration sonore et le lyrisme, l\'univers de Paradis s\'aborde impérativement avec le coeur mais aussi par l\'imaginaire et l\'abstraction. (Who Are You, M. Ward, Sufjan Stevens, Patrick Watson)', 'Québec, Canada', 'http://www.simonparadis.com'),
(30, 'Koriass', 'Après avoir fait plus que ses preuves lors de diverses compétitions de battle rap, Koriass produit un premier album sur l\'étiquette 7ième Ciel en 2008. Cet album et son succès élargit son publique sans lui aliéner ses fans de longue date. Juste avant la sortie en septembre de Petites victoires, son deuxième album, le rappeur vient nous donner une bonne dose de Hip-hop!', 'Québec, Canada', 'http://www.koriass.com'),
(31, 'Boogat', 'Vétéran de la scène rap québecoise, il a commencé il y a plus qu\'une dizaine d\'année à  se faire entendre à  Québec avec Andromaïck. Maintenant établi à  Montréal depuis quelque années, le vocaliste n\'est pas gêné d\'expérimenter. Alliant les chaudes musiques latines au côté urbain de la musique électronique et du Hip-hop, Boogat apporte un vent de fraîcheur énergique à  la musique du monde traditionelle. Il est accompagné sur scène d\'un percussioniste virtuose et de DJ Torres. Boogat propose un spectacle inédit, dansant et accessible à  tous les publics. Party ensolleillé!', 'Montréal, Canada', 'http://www.boogat.com'),
(33, 'Pax Kingz', 'Pax Kingz c\'est Millimetrik et Maxime Robin qui font du dubstep qui font une musique plus accessible et plus dansante que leur travil respectif en solo. Présence remarqué du duo lors de leurs rares prestations à  Mutek, au FME et à  Envol et Macadam en 2009. Le deuxième opus du duo, Pax Kingz II: Medieval Bass, verra le jour lors de leur prestation au festival OFF. Bass moyenâgeuse = très particulier.', 'Québec, Canada', 'http://paxkingz.bandcamp.com'),
(37, 'K6A', 'Le collectif rap québecois s\'assemble pour une des rares prestations du collectif complet. Ce groupe comprend FiligraNn (Wordup Battles), Monk-E, Maybe Watson (Alaclair Ensemble), KenLo (Craqnuques, Alaclair Ensemble) et bien d\'autres rappeurs à  entendre! Il est difficile de choisir un préféré. Tentez l\'expérience en les voyant live! «Original block party» en perspective.', 'Québec, Canada', 'http://www.myspace.com/k6a'),
(39, 'Frank feutré - Présentation du Festival Diapason', 'Projet porté par le jeune auteur-compositeur Benjamin Bleuez, Frank Feutré opère une curieuse gymnastique sonore et textuelle. Entre originalité exquise et candeur désarmante, Bleuez cultive un langage inventé, teinté d\'anglais, de swahili, de néologismes et de mots valises. En utilisant l\'ordinaire comme matière première, Frank Feutré y greffe avec doigté une généreuse part d\'imaginaire, un procédé romantique et rêveur qui n\'est pas sans rappeler un certain Jérôme Minière avec lequel il partage une vision artistique commune.', 'Montréal, Canada', 'http://frankfeutre.bandcamp.com/');

-- --------------------------------------------------------

--
-- Table structure for table `t_lieu`
--

CREATE TABLE `t_lieu` (
  `id_lieu` tinyint(1) UNSIGNED NOT NULL COMMENT 'Entre 5 et 10 lieux',
  `nom_lieu` varchar(50) NOT NULL,
  `no_civique` varchar(15) NOT NULL,
  `rue` varchar(50) NOT NULL,
  `code_postal` varchar(6) NOT NULL,
  `indications` varchar(50) DEFAULT NULL,
  `site_web_lieu` varchar(150) DEFAULT NULL,
  `telephone` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_lieu`
--

INSERT INTO `t_lieu` (`id_lieu`, `nom_lieu`, `no_civique`, `rue`, `code_postal`, `indications`, `site_web_lieu`, `telephone`) VALUES
(1, 'La Salle Multi (Méduse)', '591', 'rue Saint-Vallier Est', 'G1K9G6', NULL, 'http://www.meduse.org/fr/', '(418) 524-7553'),
(2, 'La Ninkasi du Faubourg', '811', 'rue Saint-Jean', 'G1R1R2', NULL, 'http://www.laninkasi.ca/', '(418) 529-8538'),
(3, 'Fou-bar', '525', 'rue St-Jean', 'G1R1P5', NULL, 'http://www.foubar.ca/', '(418) 522-1987'),
(4, 'Sacrilège', '447', 'rue St-Jean', 'G1R1P5', NULL, 'http://lesacrilege.com/', '(418) 649-1985'),
(5, 'Scène Desjardins (Le parvis St-Jean-Baptiste)', '480', 'rue Saint-Jean', 'G1R1P4', 'Devant l\'Église St-Jean-Baptiste', NULL, NULL),
(6, 'Le Studio d\'Essai (Méduse)', '591', 'Saint-Vallier Est', 'G1K 3P', NULL, 'http://www.meduse.org/fr/', '(418) 524-7553');

-- --------------------------------------------------------

--
-- Table structure for table `t_style`
--

CREATE TABLE `t_style` (
  `id_style` tinyint(3) UNSIGNED NOT NULL,
  `nom_style` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_style`
--

INSERT INTO `t_style` (`id_style`, `nom_style`) VALUES
(1, 'Burlesque'),
(2, 'Électro'),
(3, 'Rock'),
(4, 'Trash'),
(5, 'Hip-hop'),
(6, 'Rap'),
(7, 'Folk'),
(8, 'Country'),
(9, 'Punk'),
(10, 'Expérimental'),
(11, 'Humour'),
(12, 'Franco'),
(13, 'Indie'),
(14, 'Pop'),
(15, 'Reggae');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ti_evenement`
--
ALTER TABLE `ti_evenement`
  ADD PRIMARY KEY (`id_evenement`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_artiste` (`id_artiste`);

--
-- Indexes for table `ti_style_artiste`
--
ALTER TABLE `ti_style_artiste`
  ADD PRIMARY KEY (`id_style`,`id_artiste`),
  ADD KEY `id_style` (`id_style`),
  ADD KEY `id_artiste` (`id_artiste`);

--
-- Indexes for table `t_actualite`
--
ALTER TABLE `t_actualite`
  ADD PRIMARY KEY (`id_actualite`);

--
-- Indexes for table `t_artiste`
--
ALTER TABLE `t_artiste`
  ADD PRIMARY KEY (`id_artiste`);

--
-- Indexes for table `t_lieu`
--
ALTER TABLE `t_lieu`
  ADD PRIMARY KEY (`id_lieu`);

--
-- Indexes for table `t_style`
--
ALTER TABLE `t_style`
  ADD PRIMARY KEY (`id_style`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ti_evenement`
--
ALTER TABLE `ti_evenement`
  MODIFY `id_evenement` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `t_actualite`
--
ALTER TABLE `t_actualite`
  MODIFY `id_actualite` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t_artiste`
--
ALTER TABLE `t_artiste`
  MODIFY `id_artiste` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `t_lieu`
--
ALTER TABLE `t_lieu`
  MODIFY `id_lieu` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Entre 5 et 10 lieux', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_style`
--
ALTER TABLE `t_style`
  MODIFY `id_style` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ti_evenement`
--
ALTER TABLE `ti_evenement`
  ADD CONSTRAINT `ti_evenement_ibfk_1` FOREIGN KEY (`id_lieu`) REFERENCES `t_lieu` (`id_lieu`),
  ADD CONSTRAINT `ti_evenement_ibfk_2` FOREIGN KEY (`id_artiste`) REFERENCES `t_artiste` (`id_artiste`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ti_style_artiste`
--
ALTER TABLE `ti_style_artiste`
  ADD CONSTRAINT `ti_style_artiste_ibfk_1` FOREIGN KEY (`id_style`) REFERENCES `t_style` (`id_style`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ti_style_artiste_ibfk_2` FOREIGN KEY (`id_artiste`) REFERENCES `t_artiste` (`id_artiste`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
