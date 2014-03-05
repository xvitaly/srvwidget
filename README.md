Installation
========
1. Upload all files to your web server.

2. Open /libs/srvwidget/SrvWidget.class.php and set MySQL username, password and database name.

3. Import this SQL dump file:
```
DROP TABLE IF EXISTS `servers`;
CREATE TABLE IF NOT EXISTS `servers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Address` text NOT NULL,
  `Type` enum('OUR','OTHER') NOT NULL,
  `Comment` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

INSERT INTO `servers` (`ID`, `Address`, `Type`, `Comment`) VALUES
(1, '46.174.48.44:27272', 'OUR', 'TEAM-FORTRESS.SU #1 (DUSTBOWL)'),
(2, '83.222.97.209:27203', 'OUR', 'TEAM-FORTRESS.SU #3 (GOLDRUSH)'),
(3, '46.174.48.29:27276', 'OUR', 'TEAM-FORTRESS.SU #5 (BADWATER)'),
(4, '46.174.48.24:27262', 'OUR', 'TEAM-FORTRESS.SU #7 (HOODOO)'),
(5, '93.191.11.90:27209', 'OTHER', 'G44 #3 (dustbowl)'),
(6, 'tf2.altfs.ru:27016', 'OTHER', 'ALTFS #2 (dustbowl, goldrush, badwater)'),
(7, 'tf2.altfs.ru:27017', 'OTHER', 'ALTFS #3 (dustbowl)'),
(8, '93.191.11.90:27208', 'OTHER', 'G44 #1 (popular maps)'),
(9, '77.241.20.23:27029', 'OTHER', 'Fastkill.ru (orange)'),
(10, 'tf2.altfs.ru:27015', 'OTHER', 'ALTFS #1 (all maps)'),
(11, '93.191.11.90:27202', 'OTHER', 'G44 #4 (saxton Hale)');
```

4. Enjoy.