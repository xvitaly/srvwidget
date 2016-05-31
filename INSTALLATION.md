Installation
========
1. Upload all files from this repository to your web server.

2. Open ```libs/srvwidget/Settings.class.php``` and set MySQL username, password, database name and Steam Web API token.

3. Import this SQL dump file:
```sql
DROP TABLE IF EXISTS `servers`;
CREATE TABLE IF NOT EXISTS `servers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ServerID` text NOT NULL,
  `Comment` text NOT NULL,
  `IsEnabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Servers table for Source Engine Web Widget' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `legacy`;
CREATE TABLE IF NOT EXISTS `legacy` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` text NOT NULL,
  `Comment` text NOT NULL,
  `IsEnabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Legacy table for Source Engine Web Widget' AUTO_INCREMENT=1 ;
```
