Installation
========
1. Clone repository on server:
```bash
git clone --depth=1 https://github.com/xvitaly/srvwidget.git
```

2. Install dependencies using [Composer](https://getcomposer.org/):
```bash
composer install
```

3. Update autoloader scripts:
```bash
composer dump-autoload -o
```

4. Open `core/Settings.class.php` file in any text editor and set MySQL username, password, database name and Steam Web API token.

5. Import this sample SQL dump file:
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
