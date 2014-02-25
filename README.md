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
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

INSERT INTO `servers` (`ID`, `Address`, `Type`) VALUES
(1, '46.174.48.44:27272', 'OUR'),
(2, '83.222.97.209:27203', 'OUR'),
(3, '46.174.48.29:27276', 'OUR'),
(4, '46.174.48.24:27262', 'OUR'),
(5, '93.191.11.90:27209', 'OTHER'),
(6, '89.223.24.149:27016', 'OTHER'),
(7, '89.223.24.149:27017', 'OTHER'),
(8, '93.191.11.90:27208', 'OTHER'),
(9, '77.241.20.23:27029', 'OTHER'),
(10, '89.223.24.149:27015', 'OTHER'),
(11, '93.191.11.90:27202', 'OTHER');
```

4. Enjoy.