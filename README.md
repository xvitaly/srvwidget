Installation
========
1. Upload all files from this repository to your web server.

2. Open ```/libs/srvwidget/Settings.class.php``` and set MySQL username, password, database name and Steam Web API token.

3. Import this SQL dump file:
```
DROP TABLE IF EXISTS `servers`;
CREATE TABLE IF NOT EXISTS `servers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ServerID` text NOT NULL,
  `Comment` text NOT NULL,
  `IsEnabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Servers table for Source Engine Web Widget' AUTO_INCREMENT=12 ;

INSERT INTO `servers` (`ID`, `ServerID`, `Comment`, `IsEnabled`) VALUES
(1, '85568392920040184', 'ALTFS #2 (dustbowl, goldrush, badwater)', 1),
(2, '85568392920040185', 'ALTFS #3 (dustbowl)', 1),
(3, '85568392920042321', 'G44 #1 (popular maps)', 1),
(4, '85568392920041679', 'Fastkill.ru (orange)', 1),
(5, '85568392920040180', 'ALTFS #1 (all maps)', 1),
(6, '85568392920042324', 'G44 #4 (saxton Hale)', 1),
(7, '85568392920041677', 'FASTKILL.RU 2Fort', 1),
(8, '85568392920041680', 'FASTKILL.RU Minecraft', 1),
(9, '85568392920042322', 'G44 #2 (all maps)', 1),
(10, '85568392920044001', 'ALTFS #7 (turbine only)', 1),
(11, '85568392920040188', 'ALTFS #6 (2fort only)', 1);
```

Requirements
========
PHP version 5.2+ with socket, mysqli and bcmath extensions. Requires full socket support. May not work on shared hosting!

License
========
Main code licensed under the terms of GNU General Public License version 3. You can find it here: https://www.gnu.org/licenses/gpl.html. External libraries can use another licenses, compatible with GNU GPLv3.
